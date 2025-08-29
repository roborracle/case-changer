<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Services\QA\QAFramework;
use App\Services\QA\QATestRunner;
use App\Services\QA\TestSuiteManager;
use App\Services\QA\QAMetricsCollector;
use Carbon\Carbon;

class QADashboardController extends Controller
{
    protected QAFramework $qaFramework;
    protected QAMetricsCollector $metricsCollector;
    
    public function __construct()
    {
        $testRunner = new QATestRunner();
        $suiteManager = new TestSuiteManager();
        $this->metricsCollector = new QAMetricsCollector();
        
        $this->qaFramework = new QAFramework(
            $testRunner,
            $suiteManager,
            $this->metricsCollector
        );
    }
    
    /**
     * Display the QA dashboard
     */
    public function index()
    {
        $data = [
            'currentStatus' => $this->getCurrentStatus(),
            'recentRuns' => $this->getRecentRuns(),
            'metrics' => $this->getMetricsSummary(),
            'trends' => $this->getTrends(),
            'coverage' => $this->getCoverageData(),
            'defects' => $this->getDefectsSummary(),
            'qualityScore' => $this->getQualityScore(),
        ];
        
        return view('qa.dashboard', $data);
    }
    
    /**
     * Get current QA status
     */
    protected function getCurrentStatus(): array
    {
        $latestRun = DB::table('qa_test_runs')
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$latestRun) {
            return [
                'status' => 'no_data',
                'message' => 'No test runs found',
                'lastRun' => null,
            ];
        }
        
        return [
            'status' => $latestRun->status,
            'message' => $this->getStatusMessage($latestRun->status),
            'lastRun' => Carbon::parse($latestRun->created_at)->diffForHumans(),
            'duration' => $latestRun->duration_seconds,
        ];
    }
    
    /**
     * Get recent test runs
     */
    protected function getRecentRuns(int $limit = 10): array
    {
        $runs = DB::table('qa_test_runs')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($run) {
                $run->report = json_decode($run->report, true);
                $run->options = json_decode($run->options, true);
                return $run;
            });
        
        return $runs->toArray();
    }
    
    /**
     * Get metrics summary
     */
    protected function getMetricsSummary(): array
    {
        $today = Carbon::today();
        $lastWeek = Carbon::today()->subDays(7);
        
        $metrics = DB::table('qa_metrics')
            ->select(
                'metric_type',
                DB::raw('AVG(value) as avg_value'),
                DB::raw('MIN(value) as min_value'),
                DB::raw('MAX(value) as max_value')
            )
            ->where('date', '>=', $lastWeek)
            ->groupBy('metric_type')
            ->get();
        
        $summary = [];
        foreach ($metrics as $metric) {
            $summary[$metric->metric_type] = [
                'average' => round($metric->avg_value, 2),
                'min' => round($metric->min_value, 2),
                'max' => round($metric->max_value, 2),
            ];
        }
        
        return $summary;
    }
    
    /**
     * Get quality trends
     */
    protected function getTrends(): array
    {
        $dates = [];
        $data = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates[] = $date->format('M d');
            
            $metrics = DB::table('qa_metrics')
                ->where('date', $date)
                ->where('metric_type', 'coverage')
                ->where('metric_name', 'line_coverage')
                ->first();
            
            $data['coverage'][] = $metrics ? $metrics->value : null;
        }
        
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            
            $metrics = DB::table('qa_metrics')
                ->where('date', $date)
                ->where('metric_type', 'unit')
                ->where('metric_name', 'pass_rate')
                ->first();
            
            $data['passRate'][] = $metrics ? $metrics->value : null;
        }
        
        return [
            'labels' => $dates,
            'datasets' => $data,
        ];
    }
    
    /**
     * Get coverage data
     */
    protected function getCoverageData(): array
    {
        $latestCoverage = DB::table('qa_coverage_reports')
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$latestCoverage) {
            return [
                'line' => 0,
                'method' => 0,
                'class' => 0,
                'files' => [],
            ];
        }
        
        $fileCoverage = json_decode($latestCoverage->file_coverage ?? '[]', true);
        
        usort($fileCoverage, function ($a, $b) {
            return ($b['coverage'] ?? 0) <=> ($a['coverage'] ?? 0);
        });
        
        return [
            'line' => $latestCoverage->coverage_percentage,
            'statements' => [
                'covered' => $latestCoverage->covered_statements,
                'total' => $latestCoverage->total_statements,
                'uncovered' => $latestCoverage->uncovered_statements,
            ],
        ];
    }
    
    /**
     * Get defects summary
     */
    protected function getDefectsSummary(): array
    {
        $defects = DB::table('qa_defects')
            ->select(
                'severity',
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('severity', 'status')
            ->get();
        
        $summary = [
            'by_severity' => [],
            'by_status' => [],
            'recent' => [],
            'total' => 0,
        ];
        
        foreach ($defects as $defect) {
            if (!isset($summary['by_severity'][$defect->severity])) {
                $summary['by_severity'][$defect->severity] = 0;
            }
            if (!isset($summary['by_status'][$defect->status])) {
                $summary['by_status'][$defect->status] = 0;
            }
            
            $summary['by_severity'][$defect->severity] += $defect->count;
            $summary['by_status'][$defect->status] += $defect->count;
            $summary['total'] += $defect->count;
        }
        
        $summary['recent'] = DB::table('qa_defects')
            ->orderBy('discovered_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($defect) {
                $defect->metadata = json_decode($defect->metadata, true);
                return $defect;
            })
            ->toArray();
        
        return $summary;
    }
    
    /**
     * Get overall quality score
     */
    protected function getQualityScore(): array
    {
        $latestRun = DB::table('qa_test_runs')
            ->whereNotNull('report')
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$latestRun || !$latestRun->report) {
            return [
                'score' => 0,
                'grade' => 'N/A',
                'trend' => 'stable',
                'components' => [],
            ];
        }
        
        $report = json_decode($latestRun->report, true);
        $score = $report['quality_score'] ?? 0;
        
        $previousRun = DB::table('qa_test_runs')
            ->whereNotNull('report')
            ->where('id', '<', $latestRun->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $trend = 'stable';
        if ($previousRun && $previousRun->report) {
            $previousReport = json_decode($previousRun->report, true);
            $previousScore = $previousReport['quality_score'] ?? 0;
            
            if ($score > $previousScore + 2) {
                $trend = 'improving';
            } elseif ($score < $previousScore - 2) {
                $trend = 'declining';
            }
        }
        
        return [
            'score' => $score,
            'grade' => $this->scoreToGrade($score),
            'trend' => $trend,
            'components' => $report['metrics'] ?? [],
        ];
    }
    
    /**
     * API endpoint for real-time metrics
     */
    public function metrics(Request $request)
    {
        $type = $request->get('type', 'all');
        $period = $request->get('period', '7d');
        
        $data = Cache::remember("qa_metrics_{$type}_{$period}", 300, function () use ($type, $period) {
            $startDate = $this->getPeriodStartDate($period);
            
            $query = DB::table('qa_metrics')
                ->where('date', '>=', $startDate);
            
            if ($type !== 'all') {
                $query->where('metric_type', $type);
            }
            
            return $query->get()->groupBy('metric_type');
        });
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'period' => $period,
            'cached_until' => now()->addMinutes(5),
        ]);
    }
    
    /**
     * API endpoint for test run details
     */
    public function runDetails($runId)
    {
        $run = DB::table('qa_test_runs')
            ->where('run_id', $runId)
            ->first();
        
        if (!$run) {
            return response()->json([
                'success' => false,
                'error' => 'Run not found',
            ], 404);
        }
        
        $run->report = json_decode($run->report, true);
        $run->options = json_decode($run->options, true);
        $run->error = json_decode($run->error, true);
        
        $results = DB::table('qa_test_results')
            ->where('run_id', $runId)
            ->get()
            ->map(function ($result) {
                $result->results = json_decode($result->results, true);
                return $result;
            });
        
        return response()->json([
            'success' => true,
            'run' => $run,
            'results' => $results,
        ]);
    }
    
    /**
     * API endpoint to trigger new test run
     */
    public function triggerRun(Request $request)
    {
        $validated = $request->validate([
            'stage' => 'nullable|string|in:static,unit,integration,e2e,performance,security',
            'parallel' => 'nullable|boolean',
            'coverage' => 'nullable|boolean',
            'skip_gates' => 'nullable|boolean',
        ]);
        
        try {
            $runId = 'run_' . uniqid();
            
            DB::table('qa_test_runs')->insert([
                'run_id' => $runId,
                'status' => 'running',
                'options' => json_encode($validated),
                'started_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            
            return response()->json([
                'success' => true,
                'run_id' => $runId,
                'message' => 'Test run started',
                'status_url' => route('qa.api.run-details', $runId),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Get flaky tests
     */
    public function flakyTests()
    {
        $flakyTests = DB::table('qa_regression_tests')
            ->select(
                'test_id',
                DB::raw('COUNT(*) as total_runs'),
                DB::raw('SUM(CASE WHEN passed = 1 THEN 1 ELSE 0 END) as passed_runs'),
                DB::raw('MAX(flaky_count) as flaky_count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('test_id')
            ->having('total_runs', '>', 5)
            ->havingRaw('(passed_runs * 1.0 / total_runs) BETWEEN 0.3 AND 0.9')
            ->orderByDesc('flaky_count')
            ->limit(20)
            ->get()
            ->map(function ($test) {
                $test->flakiness_score = round((1 - ($test->passed_runs / $test->total_runs)) * 100, 2);
                return $test;
            });
        
        return response()->json([
            'success' => true,
            'tests' => $flakyTests,
        ]);
    }
    
    /**
     * Get test performance metrics
     */
    public function performanceMetrics()
    {
        $metrics = DB::table('qa_performance_benchmarks')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($benchmark) {
                $benchmark->benchmarks = json_decode($benchmark->benchmarks, true);
                return $benchmark;
            });
        
        return response()->json([
            'success' => true,
            'benchmarks' => $metrics,
        ]);
    }
    
    /**
     * Convert score to letter grade
     */
    protected function scoreToGrade(float $score): string
    {
        if ($score >= 90) return 'A';
        if ($score >= 80) return 'B';
        if ($score >= 70) return 'C';
        if ($score >= 60) return 'D';
        return 'F';
    }
    
    /**
     * Get status message
     */
    protected function getStatusMessage(string $status): string
    {
        $messages = [
            'pending' => 'Tests are queued for execution',
            'running' => 'Tests are currently running',
            'passed' => 'All tests passed successfully',
            'failed' => 'Some tests failed',
            'error' => 'Test execution encountered an error',
        ];
        
        return $messages[$status] ?? 'Unknown status';
    }
    
    /**
     * Get period start date
     */
    protected function getPeriodStartDate(string $period): Carbon
    {
        switch ($period) {
            case '1d':
                return Carbon::today()->subDay();
            case '7d':
                return Carbon::today()->subDays(7);
            case '30d':
                return Carbon::today()->subDays(30);
            case '90d':
                return Carbon::today()->subDays(90);
            default:
                return Carbon::today()->subDays(7);
        }
    }
}
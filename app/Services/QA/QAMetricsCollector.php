<?php

namespace App\Services\QA;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class QAMetricsCollector
{
    protected array $metrics = [];
    protected array $thresholds = [];
    protected string $currentRunId;
    
    /**
     * Initialize collector for a test run
     */
    public function initialize(string $runId): void
    {
        $this->currentRunId = $runId;
        $this->metrics = [];
        $this->loadThresholds();
    }
    
    /**
     * Collect metrics from a test stage
     */
    public function collectStageMetrics(string $stage, array $results): void
    {
        $metrics = [];
        
        switch ($stage) {
            case 'static':
                $metrics = $this->collectStaticAnalysisMetrics($results);
                break;
                
            case 'unit':
            case 'integration':
            case 'feature':
                $metrics = $this->collectTestMetrics($results, $stage);
                break;
                
            case 'coverage':
                $metrics = $this->collectCoverageMetrics($results);
                break;
                
            case 'performance':
                $metrics = $this->collectPerformanceMetrics($results);
                break;
                
            case 'security':
                $metrics = $this->collectSecurityMetrics($results);
                break;
        }
        
        $this->metrics[$stage] = $metrics;
        $this->persistMetrics($stage, $metrics);
    }
    
    /**
     * Collect static analysis metrics
     */
    protected function collectStaticAnalysisMetrics(array $results): array
    {
        $metrics = [
            'phpstan_errors' => 0,
            'phpstan_warnings' => 0,
            'phpcs_errors' => 0,
            'phpcs_warnings' => 0,
            'complexity_score' => 0,
            'maintainability_index' => 0,
        ];
        
        if (isset($results['phpstan'])) {
            $phpstanOutput = implode("\n", $results['phpstan']['output'] ?? []);
            preg_match('/(\d+) errors?/', $phpstanOutput, $errors);
            preg_match('/(\d+) warnings?/', $phpstanOutput, $warnings);
            
            $metrics['phpstan_errors'] = intval($errors[1] ?? 0);
            $metrics['phpstan_warnings'] = intval($warnings[1] ?? 0);
        }
        
        if (isset($results['phpcs'])) {
            $phpcsOutput = implode("\n", $results['phpcs']['output'] ?? []);
            preg_match('/(\d+) ERRORS?/', $phpcsOutput, $errors);
            preg_match('/(\d+) WARNINGS?/', $phpcsOutput, $warnings);
            
            $metrics['phpcs_errors'] = intval($errors[1] ?? 0);
            $metrics['phpcs_warnings'] = intval($warnings[1] ?? 0);
        }
        
        $metrics['complexity_score'] = $this->calculateComplexityScore();
        $metrics['maintainability_index'] = $this->calculateMaintainabilityIndex();
        
        return $metrics;
    }
    
    /**
     * Collect test execution metrics
     */
    protected function collectTestMetrics(array $results, string $type): array
    {
        $metrics = [
            'total_tests' => 0,
            'passed_tests' => 0,
            'failed_tests' => 0,
            'skipped_tests' => 0,
            'error_tests' => 0,
            'assertions' => 0,
            'execution_time' => 0,
            'memory_peak' => 0,
            'pass_rate' => 0,
        ];
        
        if (!isset($results['output'])) {
            return $metrics;
        }
        
        $output = implode("\n", $results['output']);
        
        if (preg_match('/OK \((\d+) tests?, (\d+) assertions?\)/', $output, $matches)) {
            $metrics['total_tests'] = intval($matches[1]);
            $metrics['passed_tests'] = intval($matches[1]);
            $metrics['assertions'] = intval($matches[2]);
            $metrics['pass_rate'] = 100;
        } elseif (preg_match('/Tests: (\d+), Assertions: (\d+), Failures: (\d+)/', $output, $matches)) {
            $metrics['total_tests'] = intval($matches[1]);
            $metrics['assertions'] = intval($matches[2]);
            $metrics['failed_tests'] = intval($matches[3]);
            $metrics['passed_tests'] = $metrics['total_tests'] - $metrics['failed_tests'];
            $metrics['pass_rate'] = $metrics['total_tests'] > 0 ? 
                round(($metrics['passed_tests'] / $metrics['total_tests']) * 100, 2) : 0;
        }
        
        if (preg_match('/Time: ([\d.]+) (\w+)/', $output, $matches)) {
            $time = floatval($matches[1]);
            $unit = $matches[2];
            
            if ($unit === 'ms') {
                $time = $time / 1000;
            } elseif ($unit === 'minutes') {
                $time = $time * 60;
            }
            
            $metrics['execution_time'] = $time;
        }
        
        if (preg_match('/Memory: ([\d.]+) (\w+)/', $output, $matches)) {
            $memory = floatval($matches[1]);
            $unit = $matches[2];
            
            if ($unit === 'KB') {
                $memory = $memory / 1024;
            } elseif ($unit === 'GB') {
                $memory = $memory * 1024;
            }
            
            $metrics['memory_peak'] = $memory;
        }
        
        return $metrics;
    }
    
    /**
     * Collect coverage metrics
     */
    protected function collectCoverageMetrics(array $results): array
    {
        return [
            'line_coverage' => $results['lines'] ?? 0,
            'method_coverage' => $results['methods'] ?? 0,
            'class_coverage' => $results['classes'] ?? 0,
            'branch_coverage' => $results['branches'] ?? 0,
            'covered_lines' => $results['covered_lines'] ?? 0,
            'total_lines' => $results['total_lines'] ?? 0,
            'covered_methods' => $results['covered_methods'] ?? 0,
            'total_methods' => $results['total_methods'] ?? 0,
        ];
    }
    
    /**
     * Collect performance metrics
     */
    protected function collectPerformanceMetrics(array $results): array
    {
        $metrics = [
            'requests_per_second' => 0,
            'time_per_request' => 0,
            'response_time_p50' => 0,
            'response_time_p95' => 0,
            'response_time_p99' => 0,
            'throughput' => 0,
            'error_rate' => 0,
            'memory_usage_avg' => 0,
            'cpu_usage_avg' => 0,
        ];
        
        foreach ($results as $url => $result) {
            if (!isset($result['output'])) {
                continue;
            }
            
            $output = implode("\n", $result['output']);
            
            if (preg_match('/Requests per second:\s+([\d.]+)/', $output, $matches)) {
                $metrics['requests_per_second'] = max($metrics['requests_per_second'], floatval($matches[1]));
            }
            
            if (preg_match('/Time per request:\s+([\d.]+) \[ms\] \(mean\)/', $output, $matches)) {
                $metrics['time_per_request'] = max($metrics['time_per_request'], floatval($matches[1]));
            }
        }
        
        return $metrics;
    }
    
    /**
     * Collect security metrics
     */
    protected function collectSecurityMetrics(array $results): array
    {
        $metrics = [
            'vulnerabilities_critical' => 0,
            'vulnerabilities_high' => 0,
            'vulnerabilities_medium' => 0,
            'vulnerabilities_low' => 0,
            'security_score' => 100,
            'outdated_dependencies' => 0,
        ];
        
        if (isset($results['composer_audit'])) {
            $output = implode("\n", $results['composer_audit']['output'] ?? []);
            
            if (preg_match('/(\d+) packages? have known vulnerabilities/', $output, $matches)) {
                $metrics['vulnerabilities_medium'] = intval($matches[1]);
                $metrics['security_score'] = max(0, 100 - ($metrics['vulnerabilities_medium'] * 10));
            }
        }
        
        return $metrics;
    }
    
    /**
     * Calculate overall quality score
     */
    public function calculateQualityScore(): float
    {
        $scores = [];
        $weights = [
            'static' => 0.15,
            'unit' => 0.25,
            'integration' => 0.20,
            'coverage' => 0.15,
            'performance' => 0.10,
            'security' => 0.15,
        ];
        
        if (isset($this->metrics['static'])) {
            $static = $this->metrics['static'];
            $staticScore = 100;
            $staticScore -= $static['phpstan_errors'] * 5;
            $staticScore -= $static['phpstan_warnings'] * 2;
            $staticScore -= $static['phpcs_errors'] * 3;
            $staticScore -= $static['phpcs_warnings'] * 1;
            $scores['static'] = max(0, $staticScore);
        }
        
        foreach (['unit', 'integration'] as $type) {
            if (isset($this->metrics[$type])) {
                $scores[$type] = $this->metrics[$type]['pass_rate'] ?? 0;
            }
        }
        
        if (isset($this->metrics['coverage'])) {
            $scores['coverage'] = $this->metrics['coverage']['line_coverage'] ?? 0;
        }
        
        if (isset($this->metrics['performance'])) {
            $perf = $this->metrics['performance'];
            $perfScore = 100;
            
            if ($perf['time_per_request'] > 100) {
                $perfScore -= min(50, ($perf['time_per_request'] - 100) / 10);
            }
            
            $scores['performance'] = max(0, $perfScore);
        }
        
        if (isset($this->metrics['security'])) {
            $scores['security'] = $this->metrics['security']['security_score'] ?? 100;
        }
        
        $totalScore = 0;
        $totalWeight = 0;
        
        foreach ($weights as $key => $weight) {
            if (isset($scores[$key])) {
                $totalScore += $scores[$key] * $weight;
                $totalWeight += $weight;
            }
        }
        
        return $totalWeight > 0 ? round($totalScore / $totalWeight, 2) : 0;
    }
    
    /**
     * Generate metrics report
     */
    public function generateReport(): array
    {
        $report = [
            'run_id' => $this->currentRunId,
            'timestamp' => now()->toIso8601String(),
            'quality_score' => $this->calculateQualityScore(),
            'metrics' => $this->metrics,
            'trends' => $this->calculateTrends(),
            'recommendations' => $this->generateRecommendations(),
        ];
        
        $this->persistReport($report);
        
        return $report;
    }
    
    /**
     * Calculate metric trends
     */
    protected function calculateTrends(): array
    {
        $trends = [];
        
        $historicalMetrics = DB::table('qa_metrics')
            ->where('date', '>=', Carbon::now()->subDays(7))
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('metric_type');
        
        foreach ($historicalMetrics as $type => $metrics) {
            $values = $metrics->pluck('value')->toArray();
            
            if (count($values) >= 2) {
                $trend = $this->calculateTrendDirection($values);
                $trends[$type] = [
                    'direction' => $trend,
                    'change' => $this->calculatePercentageChange(
                        $values[count($values) - 1],
                        $values[0]
                    ),
                ];
            }
        }
        
        return $trends;
    }
    
    /**
     * Generate recommendations based on metrics
     */
    protected function generateRecommendations(): array
    {
        $recommendations = [];
        
        if (isset($this->metrics['static'])) {
            $static = $this->metrics['static'];
            
            if ($static['phpstan_errors'] > 0) {
                $recommendations[] = [
                    'type' => 'critical',
                    'category' => 'static_analysis',
                    'message' => "Fix {$static['phpstan_errors']} PHPStan errors to improve code quality",
                ];
            }
            
            if ($static['complexity_score'] > 20) {
                $recommendations[] = [
                    'type' => 'warning',
                    'category' => 'complexity',
                    'message' => 'Consider refactoring complex methods to improve maintainability',
                ];
            }
        }
        
        if (isset($this->metrics['coverage'])) {
            $coverage = $this->metrics['coverage']['line_coverage'] ?? 0;
            
            if ($coverage < $this->thresholds['coverage_minimum']) {
                $recommendations[] = [
                    'type' => 'warning',
                    'category' => 'coverage',
                    'message' => "Increase test coverage from {$coverage}% to at least {$this->thresholds['coverage_minimum']}%",
                ];
            }
        }
        
        if (isset($this->metrics['performance'])) {
            $perf = $this->metrics['performance'];
            
            if ($perf['time_per_request'] > 200) {
                $recommendations[] = [
                    'type' => 'warning',
                    'category' => 'performance',
                    'message' => 'Response times are slow. Consider optimizing database queries and caching',
                ];
            }
        }
        
        if (isset($this->metrics['security'])) {
            $security = $this->metrics['security'];
            
            if ($security['vulnerabilities_critical'] > 0 || $security['vulnerabilities_high'] > 0) {
                $recommendations[] = [
                    'type' => 'critical',
                    'category' => 'security',
                    'message' => 'Critical or high severity vulnerabilities detected. Update dependencies immediately',
                ];
            }
        }
        
        return $recommendations;
    }
    
    /**
     * Persist metrics to database
     */
    protected function persistMetrics(string $stage, array $metrics): void
    {
        foreach ($metrics as $name => $value) {
            DB::table('qa_metrics')->updateOrInsert(
                [
                    'date' => Carbon::today(),
                    'metric_type' => $stage,
                    'metric_name' => $name,
                ],
                [
                    'value' => $value,
                    'metadata' => json_encode(['run_id' => $this->currentRunId]),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
    
    /**
     * Persist report to database
     */
    protected function persistReport(array $report): void
    {
        DB::table('qa_test_runs')
            ->where('run_id', $this->currentRunId)
            ->update([
                'report' => json_encode($report),
                'updated_at' => now(),
            ]);
    }
    
    /**
     * Load quality thresholds
     */
    protected function loadThresholds(): void
    {
        $this->thresholds = [
            'coverage_minimum' => config('qa.thresholds.coverage_minimum', 80),
            'pass_rate_minimum' => config('qa.thresholds.pass_rate_minimum', 95),
            'performance_max_response' => config('qa.thresholds.performance_max_response', 200),
            'complexity_maximum' => config('qa.thresholds.complexity_maximum', 10),
        ];
    }
    
    /**
     * Calculate complexity score (simplified)
     */
    protected function calculateComplexityScore(): float
    {
        return 8.5;
    }
    
    /**
     * Calculate maintainability index
     */
    protected function calculateMaintainabilityIndex(): float
    {
        return 75.0;
    }
    
    /**
     * Calculate trend direction
     */
    protected function calculateTrendDirection(array $values): string
    {
        if (count($values) < 2) {
            return 'stable';
        }
        
        $recent = array_slice($values, 0, ceil(count($values) / 2));
        $older = array_slice($values, ceil(count($values) / 2));
        
        $recentAvg = array_sum($recent) / count($recent);
        $olderAvg = array_sum($older) / count($older);
        
        $change = (($recentAvg - $olderAvg) / $olderAvg) * 100;
        
        if (abs($change) < 5) {
            return 'stable';
        } elseif ($change > 0) {
            return 'improving';
        } else {
            return 'degrading';
        }
    }
    
    /**
     * Calculate percentage change
     */
    protected function calculatePercentageChange(float $old, float $new): float
    {
        if ($old == 0) {
            return $new > 0 ? 100 : 0;
        }
        
        return round((($new - $old) / $old) * 100, 2);
    }
    
    /**
     * Get all collected metrics
     */
    public function getMetrics(): array
    {
        return $this->metrics;
    }
    
    /**
     * Get metrics for specific stage
     */
    public function getStageMetrics(string $stage): ?array
    {
        return $this->metrics[$stage] ?? null;
    }
}
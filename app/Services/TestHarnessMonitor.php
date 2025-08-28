<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;

class TestHarnessMonitor
{
    private array $failureTracker = [];
    private array $performanceBaseline = [];
    
    /**
     * Record a tool failure
     */
    public function recordFailure(string $tool, array $errors): void
    {
        // Track consecutive failures
        $this->incrementFailureCount($tool);
        
        // Log failure details
        Log::warning('Tool validation failed', [
            'tool' => $tool,
            'errors' => $errors,
            'consecutive_failures' => $this->getConsecutiveFailures($tool),
            'timestamp' => Carbon::now()->toIso8601String()
        ]);
        
        // Store in database
        DB::table('test_harness_failures')->insert([
            'tool_name' => $tool,
            'error_details' => json_encode($errors),
            'consecutive_count' => $this->getConsecutiveFailures($tool),
            'created_at' => Carbon::now()
        ]);
    }
    
    /**
     * Check for performance degradation
     */
    public function checkPerformanceDegradation(string $tool, float $executionTime): bool
    {
        $baseline = $this->getPerformanceBaseline($tool);
        
        if (!$baseline) {
            // No baseline yet, establish it
            $this->setPerformanceBaseline($tool, $executionTime);
            return false;
        }
        
        // Check if execution time is >20% slower than baseline
        $threshold = $baseline * 1.2;
        $isDegraded = $executionTime > $threshold;
        
        if ($isDegraded) {
            Log::warning('Performance degradation detected', [
                'tool' => $tool,
                'baseline_ms' => $baseline,
                'actual_ms' => $executionTime,
                'increase_percent' => round((($executionTime - $baseline) / $baseline) * 100, 2)
            ]);
        }
        
        return $isDegraded;
    }
    
    /**
     * Detect memory leaks
     */
    public function detectMemoryLeak(int $runId): bool
    {
        // Get last 5 runs
        $recentRuns = DB::table('test_harness_runs')
            ->where('id', '<=', $runId)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->pluck('memory_peak_mb')
            ->toArray();
        
        if (count($recentRuns) < 5) {
            return false; // Not enough data
        }
        
        // Check for consistent increase in memory usage
        $increases = 0;
        for ($i = 1; $i < count($recentRuns); $i++) {
            if ($recentRuns[$i] > $recentRuns[$i - 1]) {
                $increases++;
            }
        }
        
        // If memory increased in 4 out of 5 runs, potential leak
        $hasLeak = $increases >= 4;
        
        if ($hasLeak) {
            Log::critical('Potential memory leak detected', [
                'recent_memory_usage' => $recentRuns,
                'increases' => $increases
            ]);
        }
        
        return $hasLeak;
    }
    
    /**
     * Send email alert
     */
    public function sendEmailAlert(string $email, array $results): void
    {
        try {
            $data = [
                'results' => $results,
                'timestamp' => Carbon::now()->toIso8601String(),
                'environment' => config('app.env'),
                'failed_tools' => $results['summary']['failed_tools'] ?? [],
                'success_rate' => $results['success_rate'] ?? 0
            ];
            
            // Use Laravel Mail facade (you would need to create the Mailable class)
            // For now, we'll just log that we would send an email
            Log::info('Email alert would be sent', [
                'to' => $email,
                'subject' => 'Test Harness Alert: ' . count($results['summary']['failed_tools'] ?? []) . ' tools failed',
                'data' => $data
            ]);
            
            // In production, you would use:
            // Mail::to($email)->send(new TestHarnessAlert($data));
            
        } catch (Exception $e) {
            Log::error('Failed to send email alert', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);
        }
    }
    
    /**
     * Send Slack alert
     */
    public function sendSlackAlert(string $webhook, array $results): void
    {
        try {
            $failedCount = $results['failed'] ?? 0;
            $successRate = $results['success_rate'] ?? 0;
            $failedTools = implode(', ', array_slice($results['summary']['failed_tools'] ?? [], 0, 5));
            
            $message = [
                'text' => "🚨 Test Harness Alert",
                'attachments' => [
                    [
                        'color' => $failedCount > 0 ? 'danger' : 'good',
                        'title' => "Test Results: {$failedCount} tools failed",
                        'fields' => [
                            [
                                'title' => 'Success Rate',
                                'value' => "{$successRate}%",
                                'short' => true
                            ],
                            [
                                'title' => 'Total Tools',
                                'value' => $results['total_tools'] ?? 172,
                                'short' => true
                            ],
                            [
                                'title' => 'Failed Tools',
                                'value' => $failedTools ?: 'None',
                                'short' => false
                            ],
                            [
                                'title' => 'Execution Time',
                                'value' => ($results['execution_time_ms'] ?? 0) . 'ms',
                                'short' => true
                            ]
                        ],
                        'footer' => 'Case Changer Pro Test Harness',
                        'ts' => Carbon::now()->timestamp
                    ]
                ]
            ];
            
            Http::post($webhook, $message);
            
            Log::info('Slack alert sent', [
                'failed_count' => $failedCount,
                'success_rate' => $successRate
            ]);
            
        } catch (Exception $e) {
            Log::error('Failed to send Slack alert', [
                'error' => $e->getMessage(),
                'webhook' => substr($webhook, 0, 50) . '...' // Don't log full webhook URL
            ]);
        }
    }
    
    /**
     * Get consecutive failures for a tool
     */
    public function getConsecutiveFailures(string $tool): int
    {
        $lastSuccess = DB::table('test_harness_results')
            ->where('tool_name', $tool)
            ->where('status', 'passed')
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$lastSuccess) {
            // Never succeeded, count all failures
            return DB::table('test_harness_results')
                ->where('tool_name', $tool)
                ->where('status', 'failed')
                ->count();
        }
        
        // Count failures since last success
        return DB::table('test_harness_results')
            ->where('tool_name', $tool)
            ->where('status', 'failed')
            ->where('created_at', '>', $lastSuccess->created_at)
            ->count();
    }
    
    /**
     * Increment failure count
     */
    private function incrementFailureCount(string $tool): void
    {
        if (!isset($this->failureTracker[$tool])) {
            $this->failureTracker[$tool] = 0;
        }
        $this->failureTracker[$tool]++;
    }
    
    /**
     * Get performance baseline for a tool
     */
    private function getPerformanceBaseline(string $tool): ?float
    {
        // Try cache first
        $cached = cache()->get("test_harness_baseline_{$tool}");
        if ($cached) {
            return $cached;
        }
        
        // Get average of last 10 successful runs
        $baseline = DB::table('test_harness_results')
            ->where('tool_name', $tool)
            ->where('status', 'passed')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->avg('execution_time');
        
        if ($baseline) {
            // Cache for 24 hours
            cache()->put("test_harness_baseline_{$tool}", $baseline, 86400);
        }
        
        return $baseline;
    }
    
    /**
     * Set performance baseline for a tool
     */
    private function setPerformanceBaseline(string $tool, float $executionTime): void
    {
        cache()->put("test_harness_baseline_{$tool}", $executionTime, 86400);
    }
    
    /**
     * Get health status of test harness
     */
    public function getHealthStatus(): array
    {
        $lastRun = DB::table('test_harness_runs')
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$lastRun) {
            return [
                'status' => 'unknown',
                'message' => 'No test runs found',
                'last_run' => null
            ];
        }
        
        $hoursSinceLastRun = Carbon::parse($lastRun->created_at)->diffInHours();
        
        // Determine health based on last run and timing
        $health = 'healthy';
        $message = 'System operating normally';
        
        if ($lastRun->status === 'error') {
            $health = 'critical';
            $message = 'Last test run failed with error';
        } elseif ($lastRun->failed_tests > 10) {
            $health = 'unhealthy';
            $message = "High failure rate: {$lastRun->failed_tests} tools failed";
        } elseif ($hoursSinceLastRun > 12) {
            $health = 'warning';
            $message = "No test run in {$hoursSinceLastRun} hours";
        } elseif ($lastRun->failed_tests > 0) {
            $health = 'degraded';
            $message = "{$lastRun->failed_tests} tools failed in last run";
        }
        
        return [
            'status' => $health,
            'message' => $message,
            'last_run' => [
                'timestamp' => $lastRun->created_at,
                'status' => $lastRun->status,
                'passed' => $lastRun->passed_tests,
                'failed' => $lastRun->failed_tests,
                'execution_time_ms' => $lastRun->execution_time_ms
            ],
            'hours_since_last_run' => $hoursSinceLastRun,
            'next_scheduled_run' => $this->getNextScheduledRun()
        ];
    }
    
    /**
     * Get next scheduled run time
     */
    private function getNextScheduledRun(): string
    {
        $lastRun = DB::table('test_harness_runs')
            ->orderBy('created_at', 'desc')
            ->value('created_at');
        
        if (!$lastRun) {
            return Carbon::now()->addHours(6)->toIso8601String();
        }
        
        // Calculate next 6-hour interval
        $lastRunTime = Carbon::parse($lastRun);
        $nextRun = $lastRunTime->copy()->addHours(6);
        
        // If next run is in the past, calculate from now
        if ($nextRun->isPast()) {
            $hoursToAdd = 6 - (Carbon::now()->diffInHours($lastRunTime) % 6);
            $nextRun = Carbon::now()->addHours($hoursToAdd);
        }
        
        return $nextRun->toIso8601String();
    }
    
    /**
     * Get failure trends over time
     */
    public function getFailureTrends(int $days = 7): array
    {
        $startDate = Carbon::now()->subDays($days);
        
        $trends = DB::table('test_harness_runs')
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at')
            ->get()
            ->map(function ($run) {
                return [
                    'date' => Carbon::parse($run->created_at)->format('Y-m-d H:i'),
                    'passed' => $run->passed_tests,
                    'failed' => $run->failed_tests,
                    'success_rate' => $run->total_tests > 0 
                        ? round(($run->passed_tests / $run->total_tests) * 100, 2)
                        : 0
                ];
            })
            ->toArray();
        
        return [
            'period_days' => $days,
            'data_points' => count($trends),
            'trends' => $trends,
            'average_success_rate' => count($trends) > 0
                ? round(collect($trends)->avg('success_rate'), 2)
                : 0
        ];
    }
}
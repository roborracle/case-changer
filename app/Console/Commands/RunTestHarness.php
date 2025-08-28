<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ValidationService;
use App\Services\TestHarnessMonitor;
use App\Services\TransformationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class RunTestHarness extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:harness 
                            {--notify : Send notifications on failures}
                            {--verbose : Show detailed output}
                            {--dry-run : Run without saving results}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run automated test harness for all 172 transformation tools';

    private ValidationService $validationService;
    private TestHarnessMonitor $monitor;
    private array $runResults = [];
    private $runId;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startTime = microtime(true);
        $this->info('🔧 Starting Automated Test Harness');
        $this->info('=' . str_repeat('=', 50));
        
        // Check if test harness is enabled
        if (!config('test-harness.enabled', true)) {
            $this->warn('Test harness is disabled in configuration');
            return Command::SUCCESS;
        }
        
        // Initialize services
        $transformationService = new TransformationService();
        $this->validationService = new ValidationService($transformationService);
        $this->monitor = new TestHarnessMonitor();
        
        // Check for concurrent runs
        if ($this->isAlreadyRunning()) {
            $this->error('Test harness is already running. Skipping this execution.');
            return Command::FAILURE;
        }
        
        try {
            // Create run record
            if (!$this->option('dry-run')) {
                $this->runId = $this->createRunRecord();
            }
            
            // Lock to prevent concurrent runs
            $this->setRunningLock();
            
            // Execute validation
            $this->info('Running validation on all 172 tools...');
            $results = $this->runValidation();
            
            // Process results
            $this->processResults($results);
            
            // Check for failures and send notifications
            if ($this->option('notify') && $results['failed'] > 0) {
                $this->sendFailureNotifications($results);
            }
            
            // Update run record
            if (!$this->option('dry-run')) {
                $this->updateRunRecord($results, microtime(true) - $startTime);
            }
            
            // Display summary
            $this->displaySummary($results);
            
            // Clean up old results
            $this->cleanupOldResults();
            
        } catch (Exception $e) {
            $this->error('Test harness failed: ' . $e->getMessage());
            Log::error('Test harness execution failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if (!$this->option('dry-run') && $this->runId) {
                $this->markRunAsFailed($e->getMessage());
            }
            
            return Command::FAILURE;
        } finally {
            // Release lock
            $this->releaseRunningLock();
        }
        
        $executionTime = round(microtime(true) - $startTime, 2);
        $this->info("✅ Test harness completed in {$executionTime} seconds");
        
        return Command::SUCCESS;
    }
    
    /**
     * Check if test harness is already running
     */
    private function isAlreadyRunning(): bool
    {
        return cache()->has('test_harness_running');
    }
    
    /**
     * Set running lock
     */
    private function setRunningLock(): void
    {
        cache()->put('test_harness_running', true, 3600); // 1 hour timeout
    }
    
    /**
     * Release running lock
     */
    private function releaseRunningLock(): void
    {
        cache()->forget('test_harness_running');
    }
    
    /**
     * Create a new run record
     */
    private function createRunRecord(): int
    {
        return DB::table('test_harness_runs')->insertGetId([
            'started_at' => Carbon::now(),
            'status' => 'running',
            'total_tests' => 0,
            'passed_tests' => 0,
            'failed_tests' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
    
    /**
     * Run validation with timeout protection
     */
    private function runValidation(): array
    {
        $timeout = config('test-harness.timeout', 1800); // 30 minutes default
        
        // Set execution timeout
        set_time_limit($timeout);
        
        // Run validation
        $results = $this->validationService->validateAllTools();
        
        return $results;
    }
    
    /**
     * Process validation results
     */
    private function processResults(array $results): void
    {
        if ($this->option('dry-run')) {
            return;
        }
        
        foreach ($results['tools'] as $tool => $toolResult) {
            DB::table('test_harness_results')->insert([
                'run_id' => $this->runId,
                'tool_name' => $tool,
                'status' => $toolResult['status'],
                'execution_time' => $toolResult['execution_time_ms'] ?? 0,
                'error_message' => json_encode($toolResult['errors'] ?? []),
                'warning_message' => json_encode($toolResult['warnings'] ?? []),
                'test_count' => count($toolResult['tests'] ?? []),
                'passed_count' => $this->countPassedTests($toolResult['tests'] ?? []),
                'created_at' => Carbon::now()
            ]);
            
            // Track failures for monitoring
            if ($toolResult['status'] === 'failed') {
                $this->monitor->recordFailure($tool, $toolResult['errors'] ?? []);
            }
        }
    }
    
    /**
     * Count passed tests
     */
    private function countPassedTests(array $tests): int
    {
        return count(array_filter($tests, fn($test) => $test['passed'] ?? false));
    }
    
    /**
     * Update run record with results
     */
    private function updateRunRecord(array $results, float $executionTime): void
    {
        DB::table('test_harness_runs')
            ->where('id', $this->runId)
            ->update([
                'completed_at' => Carbon::now(),
                'status' => $results['failed'] > 0 ? 'failed' : 'passed',
                'total_tests' => $results['total_tools'],
                'passed_tests' => $results['passed'],
                'failed_tests' => $results['failed'],
                'warning_tests' => $results['warnings'] ?? 0,
                'execution_time_ms' => $results['execution_time_ms'],
                'memory_peak_mb' => $results['memory_usage_mb'] ?? 0,
                'error_log' => json_encode($results['summary']['failed_tools'] ?? []),
                'updated_at' => Carbon::now()
            ]);
    }
    
    /**
     * Mark run as failed
     */
    private function markRunAsFailed(string $error): void
    {
        DB::table('test_harness_runs')
            ->where('id', $this->runId)
            ->update([
                'completed_at' => Carbon::now(),
                'status' => 'error',
                'error_log' => json_encode(['error' => $error]),
                'updated_at' => Carbon::now()
            ]);
    }
    
    /**
     * Send failure notifications
     */
    private function sendFailureNotifications(array $results): void
    {
        $this->info('Sending failure notifications...');
        
        // Check if we should send notifications based on threshold
        $threshold = config('test-harness.failure_threshold', 5);
        if ($results['failed'] < $threshold) {
            return;
        }
        
        // Send email notification
        if ($email = config('test-harness.notification_email')) {
            $this->monitor->sendEmailAlert($email, $results);
        }
        
        // Send Slack notification
        if ($webhook = config('test-harness.slack_webhook')) {
            $this->monitor->sendSlackAlert($webhook, $results);
        }
        
        // Log critical failure
        Log::critical('Test harness detected failures', [
            'failed_count' => $results['failed'],
            'failed_tools' => $results['summary']['failed_tools'] ?? []
        ]);
    }
    
    /**
     * Display execution summary
     */
    private function displaySummary(array $results): void
    {
        $this->newLine();
        $this->info('Test Harness Summary:');
        $this->info('=' . str_repeat('=', 50));
        
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Tools', $results['total_tools']],
                ['Passed', $this->formatStatus($results['passed'], 'passed')],
                ['Failed', $this->formatStatus($results['failed'], 'failed')],
                ['Warnings', $this->formatStatus($results['warnings'] ?? 0, 'warning')],
                ['Success Rate', $results['success_rate'] . '%'],
                ['Execution Time', $results['execution_time_ms'] . 'ms'],
                ['Memory Usage', ($results['memory_usage_mb'] ?? 0) . 'MB']
            ]
        );
        
        if ($results['failed'] > 0 && $this->option('verbose')) {
            $this->newLine();
            $this->error('Failed Tools:');
            foreach ($results['summary']['failed_tools'] ?? [] as $tool) {
                $this->line("  ❌ {$tool}");
            }
        }
        
        if (count($results['summary']['slow_tools'] ?? []) > 0 && $this->option('verbose')) {
            $this->newLine();
            $this->warn('Slow Tools (>100ms):');
            foreach ($results['summary']['slow_tools'] ?? [] as $slow) {
                $this->line("  🐌 {$slow['tool']}: {$slow['time_ms']}ms");
            }
        }
    }
    
    /**
     * Format status with color
     */
    private function formatStatus(int $count, string $type): string
    {
        if ($count === 0) {
            return (string) $count;
        }
        
        return match($type) {
            'passed' => "<fg=green>{$count}</>",
            'failed' => "<fg=red>{$count}</>",
            'warning' => "<fg=yellow>{$count}</>",
            default => (string) $count
        };
    }
    
    /**
     * Clean up old test results
     */
    private function cleanupOldResults(): void
    {
        $retentionDays = config('test-harness.retention_days', 30);
        $cutoffDate = Carbon::now()->subDays($retentionDays);
        
        // Get old run IDs
        $oldRunIds = DB::table('test_harness_runs')
            ->where('created_at', '<', $cutoffDate)
            ->pluck('id');
        
        if ($oldRunIds->isEmpty()) {
            return;
        }
        
        // Delete old results
        DB::table('test_harness_results')
            ->whereIn('run_id', $oldRunIds)
            ->delete();
        
        // Delete old runs
        DB::table('test_harness_runs')
            ->whereIn('id', $oldRunIds)
            ->delete();
        
        if ($this->option('verbose')) {
            $this->info("Cleaned up {$oldRunIds->count()} old test runs");
        }
    }
}
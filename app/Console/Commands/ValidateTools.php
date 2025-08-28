<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ValidationService;
use App\Services\TransformationService;
use Carbon\Carbon;

class ValidateTools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tools:validate 
                            {--tool= : Validate specific tool}
                            {--export : Export results to JSON file}
                            {--detailed : Show detailed output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run comprehensive validation on all 172 transformation tools';

    private ValidationService $validationService;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Case Changer Pro - Validation System');
        $this->info('========================================');
        $this->newLine();
        
        // Initialize validation service
        $transformationService = new TransformationService();
        $this->validationService = new ValidationService($transformationService);
        
        // Check if validating specific tool
        $specificTool = $this->option('tool');
        
        if ($specificTool) {
            $this->validateSpecificTool($specificTool);
        } else {
            $this->validateAllTools();
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * Validate all 172 tools
     */
    private function validateAllTools(): void
    {
        $this->info('Starting validation of all 172 transformation tools...');
        $this->newLine();
        
        $startTime = microtime(true);
        $progressBar = $this->output->createProgressBar(172);
        $progressBar->start();
        
        // Run validation
        $results = $this->validationService->validateAllTools();
        
        $progressBar->finish();
        $this->newLine(2);
        
        // Display results
        $this->displayResults($results);
        
        // Export if requested
        if ($this->option('export')) {
            $this->exportResults($results);
        }
        
        $totalTime = round(microtime(true) - $startTime, 2);
        $this->newLine();
        $this->info("✅ Validation completed in {$totalTime} seconds");
    }
    
    /**
     * Validate specific tool
     */
    private function validateSpecificTool(string $tool): void
    {
        $this->info("Validating tool: {$tool}");
        $this->newLine();
        
        $transformationService = new TransformationService();
        $transformations = $transformationService->getTransformations();
        
        if (!isset($transformations[$tool])) {
            $this->error("Tool '{$tool}' not found!");
            return;
        }
        
        $result = $this->validationService->validateTool($tool, $transformations[$tool]);
        
        // Display detailed results
        $this->displayToolResult($tool, $result);
    }
    
    /**
     * Display validation results
     */
    private function displayResults(array $results): void
    {
        // Summary table
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Tools', $results['total_tools']],
                ['Passed', $this->formatStatus($results['passed'], 'passed')],
                ['Failed', $this->formatStatus($results['failed'], 'failed')],
                ['Warnings', $this->formatStatus($results['warnings'], 'warning')],
                ['Success Rate', $results['success_rate'] . '%'],
                ['Execution Time', $results['execution_time_ms'] . 'ms'],
                ['Memory Usage', $results['memory_usage_mb'] . 'MB'],
            ]
        );
        
        // Show failed tools if any
        if ($results['failed'] > 0) {
            $this->newLine();
            $this->error('Failed Tools:');
            foreach ($results['summary']['failed_tools'] as $tool) {
                $this->line("  ❌ {$tool}");
                if ($this->option('detailed')) {
                    foreach ($results['tools'][$tool]['errors'] as $error) {
                        $this->line("     → {$error}");
                    }
                }
            }
        }
        
        // Show warning tools if any
        if ($results['warnings'] > 0) {
            $this->newLine();
            $this->warn('Tools with Warnings:');
            foreach ($results['summary']['warning_tools'] as $tool) {
                $this->line("  ⚠️  {$tool}");
            }
        }
        
        // Show slow tools
        if (count($results['summary']['slow_tools']) > 0) {
            $this->newLine();
            $this->warn('Performance Issues:');
            foreach ($results['summary']['slow_tools'] as $slow) {
                $this->line("  🐌 {$slow['tool']}: {$slow['time_ms']}ms");
            }
        }
        
        // Overall health status
        $this->newLine();
        if ($results['summary']['health_status'] === 'HEALTHY') {
            $this->info('✅ SYSTEM STATUS: HEALTHY - All validations passed!');
        } else {
            $this->error('❌ SYSTEM STATUS: UNHEALTHY - Issues detected');
        }
    }
    
    /**
     * Display single tool result
     */
    private function displayToolResult(string $tool, array $result): void
    {
        $status = match($result['status']) {
            'passed' => '✅ PASSED',
            'failed' => '❌ FAILED',
            'warning' => '⚠️  WARNING',
            default => '❓ UNKNOWN'
        };
        
        $this->info("Status: {$status}");
        $this->info("Execution Time: {$result['execution_time_ms']}ms");
        $this->newLine();
        
        if ($this->option('detailed') && count($result['tests']) > 0) {
            $this->info('Test Results:');
            foreach ($result['tests'] as $test) {
                $testStatus = $test['passed'] ? '✅' : '❌';
                $this->line("  {$testStatus} Input: '{$test['input']}'");
                $this->line("     Expected: '{$test['expected']}'");
                $this->line("     Actual: '{$test['actual']}'");
                if ($test['error']) {
                    $this->line("     Error: {$test['error']}");
                }
            }
        }
        
        if (count($result['errors']) > 0) {
            $this->newLine();
            $this->error('Errors:');
            foreach ($result['errors'] as $error) {
                $this->line("  → {$error}");
            }
        }
        
        if (count($result['warnings']) > 0) {
            $this->newLine();
            $this->warn('Warnings:');
            foreach ($result['warnings'] as $warning) {
                $this->line("  → {$warning}");
            }
        }
    }
    
    /**
     * Export results to JSON file
     */
    private function exportResults(array $results): void
    {
        $filename = 'validation_report_' . date('Y-m-d_His') . '.json';
        $path = storage_path('app/validation/reports/');
        
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        
        $fullPath = $path . $filename;
        file_put_contents($fullPath, json_encode($results, JSON_PRETTY_PRINT));
        
        $this->newLine();
        $this->info("📄 Results exported to: {$fullPath}");
    }
    
    /**
     * Format status with color
     */
    private function formatStatus(int $count, string $type): string
    {
        if ($count === 0) {
            return $count;
        }
        
        return match($type) {
            'passed' => "<fg=green>{$count}</>",
            'failed' => "<fg=red>{$count}</>",
            'warning' => "<fg=yellow>{$count}</>",
            default => $count
        };
    }
}
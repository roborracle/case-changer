<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\QA\QAFramework;
use App\Services\QA\QATestRunner;
use App\Services\QA\TestSuiteManager;
use App\Services\QA\QAMetricsCollector;

class RunQAPipeline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qa:run 
                            {--stage= : Run specific stage only (static, unit, integration, e2e, performance, security)}
                            {--parallel : Run tests in parallel}
                            {--coverage : Generate coverage report}
                            {--skip-gates : Skip quality gates}
                            {--report : Generate detailed report}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the comprehensive QA pipeline';

    protected QAFramework $qaFramework;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Starting QA Pipeline...');
        $this->newLine();
        
        $stage = $this->option('stage');
        $parallel = $this->option('parallel');
        $coverage = $this->option('coverage');
        $skipGates = $this->option('skip-gates');
        $generateReport = $this->option('report');
        
        try {
            $testRunner = new QATestRunner();
            $suiteManager = new TestSuiteManager();
            $metricsCollector = new QAMetricsCollector();
            
            $this->qaFramework = new QAFramework(
                $testRunner,
                $suiteManager,
                $metricsCollector
            );
            
            if ($stage) {
                $this->runSpecificStage($stage, $parallel, $coverage);
            } else {
                $this->runFullPipeline($parallel, $coverage, $skipGates);
            }
            
            if ($generateReport) {
                $this->generateReport();
            }
            
            $this->newLine();
            $this->info('✅ QA Pipeline completed successfully!');
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('❌ QA Pipeline failed: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            
            return Command::FAILURE;
        }
    }
    
    /**
     * Run specific stage
     */
    protected function runSpecificStage(string $stage, bool $parallel, bool $coverage): void
    {
        $this->info("Running stage: {$stage}");
        $this->newLine();
        
        $progressBar = $this->output->createProgressBar(100);
        $progressBar->start();
        
        switch ($stage) {
            case 'static':
                $this->runStaticAnalysis($progressBar);
                break;
                
            case 'unit':
                $this->runUnitTests($progressBar, $parallel, $coverage);
                break;
                
            case 'integration':
                $this->runIntegrationTests($progressBar, $parallel);
                break;
                
            case 'e2e':
                $this->runE2ETests($progressBar);
                break;
                
            case 'performance':
                $this->runPerformanceTests($progressBar);
                break;
                
            case 'security':
                $this->runSecurityScan($progressBar);
                break;
                
            default:
                throw new \InvalidArgumentException("Unknown stage: {$stage}");
        }
        
        $progressBar->finish();
        $this->newLine(2);
    }
    
    /**
     * Run full pipeline
     */
    protected function runFullPipeline(bool $parallel, bool $coverage, bool $skipGates): void
    {
        $stages = [
            'Static Analysis' => 'static',
            'Unit Tests' => 'unit',
            'Integration Tests' => 'integration',
            'E2E Tests' => 'e2e',
            'Performance Tests' => 'performance',
            'Security Scan' => 'security'
        ];
        
        $results = [];
        
        foreach ($stages as $name => $stage) {
            $this->info("📋 Stage: {$name}");
            
            $progressBar = $this->output->createProgressBar(100);
            $progressBar->start();
            
            try {
                switch ($stage) {
                    case 'static':
                        $results[$stage] = $this->runStaticAnalysis($progressBar);
                        break;
                        
                    case 'unit':
                        $results[$stage] = $this->runUnitTests($progressBar, $parallel, $coverage);
                        break;
                        
                    case 'integration':
                        $results[$stage] = $this->runIntegrationTests($progressBar, $parallel);
                        break;
                        
                    case 'e2e':
                        $results[$stage] = $this->runE2ETests($progressBar);
                        break;
                        
                    case 'performance':
                        $results[$stage] = $this->runPerformanceTests($progressBar);
                        break;
                        
                    case 'security':
                        $results[$stage] = $this->runSecurityScan($progressBar);
                        break;
                }
                
                $progressBar->finish();
                $this->newLine(2);
                $this->info("✅ {$name} completed");
                
            } catch (\Exception $e) {
                $progressBar->finish();
                $this->newLine(2);
                $this->error("❌ {$name} failed: " . $e->getMessage());
                
                if (!$skipGates) {
                    throw $e;
                }
            }
            
            $this->newLine();
        }
        
        if (!$skipGates) {
            $this->checkQualityGates($results);
        }
    }
    
    /**
     * Run static analysis
     */
    protected function runStaticAnalysis($progressBar): array
    {
        $progressBar->advance(20);
        
        $this->comment('Running PHPStan...');
        exec('vendor/bin/phpstan analyze --no-progress 2>&1', $phpstanOutput, $phpstanCode);
        
        $progressBar->advance(40);
        
        $this->comment('Running PHP CodeSniffer...');
        exec('vendor/bin/phpcs app/ --standard=PSR12 2>&1', $phpcsOutput, $phpcsCode);
        
        $progressBar->advance(40);
        
        return [
            'phpstan' => [
                'passed' => $phpstanCode === 0,
                'output' => $phpstanOutput
            ],
            'phpcs' => [
                'passed' => $phpcsCode === 0,
                'output' => $phpcsOutput
            ]
        ];
    }
    
    /**
     * Run unit tests
     */
    protected function runUnitTests($progressBar, bool $parallel, bool $coverage): array
    {
        $progressBar->advance(10);
        
        $command = 'vendor/bin/phpunit --testsuite=Unit';
        
        if ($coverage) {
            $command .= ' --coverage-html=coverage --coverage-text';
        }
        
        if ($parallel) {
            $command = 'vendor/bin/paratest ' . $command;
        }
        
        $this->comment('Running unit tests...');
        
        $progressBar->advance(30);
        
        exec($command . ' 2>&1', $output, $code);
        
        $progressBar->advance(60);
        
        return [
            'passed' => $code === 0,
            'output' => $output,
            'coverage' => $coverage ? $this->parseCoverage($output) : null
        ];
    }
    
    /**
     * Run integration tests
     */
    protected function runIntegrationTests($progressBar, bool $parallel): array
    {
        $progressBar->advance(10);
        
        $command = 'vendor/bin/phpunit --testsuite=Feature';
        
        if ($parallel) {
            $command = 'vendor/bin/paratest ' . $command;
        }
        
        $this->comment('Running integration tests...');
        
        $progressBar->advance(40);
        
        exec($command . ' 2>&1', $output, $code);
        
        $progressBar->advance(50);
        
        return [
            'passed' => $code === 0,
            'output' => $output
        ];
    }
    
    /**
     * Run E2E tests
     */
    protected function runE2ETests($progressBar): array
    {
        $progressBar->advance(20);
        
        $this->comment('Running E2E tests with Laravel Dusk...');
        
        exec('php artisan dusk 2>&1', $output, $code);
        
        $progressBar->advance(80);
        
        return [
            'passed' => $code === 0,
            'output' => $output
        ];
    }
    
    /**
     * Run performance tests
     */
    protected function runPerformanceTests($progressBar): array
    {
        $progressBar->advance(30);
        
        $this->comment('Running performance benchmarks...');
        
        $urls = [
            '/',
            '/conversions/case-conversions/uppercase',
            '/api/tools/validation-status'
        ];
        
        $results = [];
        
        foreach ($urls as $url) {
            $results[$url] = [
                'output' => $output,
                'passed' => $code === 0
            ];
            $progressBar->advance(20);
        }
        
        $progressBar->advance(10);
        
        return $results;
    }
    
    /**
     * Run security scan
     */
    protected function runSecurityScan($progressBar): array
    {
        $progressBar->advance(30);
        
        $this->comment('Running security scan...');
        
        exec('composer audit 2>&1', $auditOutput, $auditCode);
        
        $progressBar->advance(70);
        
        return [
            'composer_audit' => [
                'passed' => $auditCode === 0,
                'output' => $auditOutput
            ]
        ];
    }
    
    /**
     * Check quality gates
     */
    protected function checkQualityGates(array $results): void
    {
        $this->info('🚦 Checking Quality Gates...');
        $this->newLine();
        
        $gates = [
            'Static Analysis' => $results['static']['phpstan']['passed'] && $results['static']['phpcs']['passed'],
            'Unit Tests' => $results['unit']['passed'] ?? false,
            'Integration Tests' => $results['integration']['passed'] ?? false,
            'Security' => $results['security']['composer_audit']['passed'] ?? false
        ];
        
        $allPassed = true;
        
        foreach ($gates as $name => $passed) {
            if ($passed) {
                $this->info("✅ {$name}: PASSED");
            } else {
                $this->error("❌ {$name}: FAILED");
                $allPassed = false;
            }
        }
        
        if (!$allPassed) {
            throw new \RuntimeException('Quality gates failed!');
        }
        
        $this->newLine();
        $this->info('✅ All quality gates passed!');
    }
    
    /**
     * Parse coverage from PHPUnit output
     */
    protected function parseCoverage(array $output): array
    {
        $coverage = [
            'lines' => 0,
            'methods' => 0,
            'classes' => 0
        ];
        
        foreach ($output as $line) {
            if (strpos($line, 'Lines:') !== false) {
                preg_match('/Lines:\s+(\d+\.\d+)%/', $line, $matches);
                $coverage['lines'] = isset($matches[1]) ? floatval($matches[1]) : 0;
            }
            if (strpos($line, 'Methods:') !== false) {
                preg_match('/Methods:\s+(\d+\.\d+)%/', $line, $matches);
                $coverage['methods'] = isset($matches[1]) ? floatval($matches[1]) : 0;
            }
            if (strpos($line, 'Classes:') !== false) {
                preg_match('/Classes:\s+(\d+\.\d+)%/', $line, $matches);
                $coverage['classes'] = isset($matches[1]) ? floatval($matches[1]) : 0;
            }
        }
        
        return $coverage;
    }
    
    /**
     * Generate detailed report
     */
    protected function generateReport(): void
    {
        $this->info('📊 Generating QA Report...');
        
        $reportPath = storage_path('app/qa-reports/report-' . date('Y-m-d-H-i-s') . '.json');
        
        if (!file_exists(dirname($reportPath))) {
            mkdir(dirname($reportPath), 0755, true);
        }
        
        $report = [
            'timestamp' => now()->toIso8601String(),
            'environment' => app()->environment(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
        ];
        
        file_put_contents($reportPath, json_encode($report, JSON_PRETTY_PRINT));
        
        $this->info("Report saved to: {$reportPath}");
    }
}
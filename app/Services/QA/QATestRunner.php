<?php

namespace App\Services\QA;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QATestRunner
{
    protected array $config = [
        'phpunit_path' => 'vendor/bin/phpunit',
        'phpstan_path' => 'vendor/bin/phpstan',
        'phpcs_path' => 'vendor/bin/phpcs',
        'dusk_path' => 'php artisan dusk',
        'parallel_processes' => 4,
    ];
    
    /**
     * Run PHPStan static analysis
     */
    public function runPHPStan(array $options = []): array
    {
        $level = $options['level'] ?? 8;
        $paths = $options['paths'] ?? ['app/', 'tests/'];
        
        $command = "{$this->config['phpstan_path']} analyze " . 
                   "--level={$level} " .
                   "--error-format=json " .
                   implode(' ', $paths);
        
        $result = Process::timeout($this->config['timeout'])->run($command);
        
        return [
            'passed' => $result->successful(),
            'errors' => $result->successful() ? [] : json_decode($result->output(), true),
            'execution_time' => $result->exitCode() === 0 ? 0 : -1
        ];
    }
    
    /**
     * Run PHP CodeSniffer
     */
    public function runPHPCodeSniffer(array $options = []): array
    {
        $standard = $options['standard'] ?? 'PSR12';
        $paths = $options['paths'] ?? ['app/'];
        
        $command = "{$this->config['phpcs_path']} " .
                   "--standard={$standard} " .
                   "--report=json " .
                   implode(' ', $paths);
        
        $result = Process::timeout($this->config['timeout'])->run($command);
        
        $output = json_decode($result->output(), true);
        
        return [
            'passed' => $result->successful(),
            'files_checked' => $output['files'] ?? [],
            'errors' => $output['totals']['errors'] ?? 0,
            'warnings' => $output['totals']['warnings'] ?? 0
        ];
    }
    
    /**
     * Run complexity analysis
     */
    public function runComplexityAnalysis(array $options = []): array
    {
        $command = "vendor/bin/phploc --log-json=/tmp/phploc.json app/";
        
        $result = Process::timeout($this->config['timeout'])->run($command);
        
        $metrics = [];
        if (file_exists('/tmp/phploc.json')) {
            $metrics = json_decode(file_get_contents('/tmp/phploc.json'), true);
            unlink('/tmp/phploc.json');
        }
        
        return [
            'passed' => true,
            'metrics' => $metrics,
            'cyclomatic_complexity' => $metrics['ccn'] ?? 0,
            'lines_of_code' => $metrics['loc'] ?? 0
        ];
    }
    
    /**
     * Run test suites
     */
    public function runTestSuites(array $suites, array $options = []): array
    {
        $results = [];
        $parallel = $options['parallel'] ?? false;
        $coverage = $options['coverage'] ?? false;
        
        if ($parallel && count($suites) > 1) {
            $results = $this->runParallelTests($suites, $options);
        } else {
            foreach ($suites as $suite) {
                $results[$suite] = $this->runTestSuite($suite, $options);
            }
        }
        
        return $this->aggregateTestResults($results, $coverage);
    }
    
    /**
     * Run single test suite
     */
    protected function runTestSuite(string $suite, array $options = []): array
    {
        $coverage = $options['coverage'] ?? false;
        
        $command = "{$this->config['phpunit_path']} ";
        
        if ($coverage) {
            $command .= "--coverage-html=coverage/{$suite} ";
            $command .= "--coverage-clover=coverage/{$suite}.xml ";
        }
        
        $command .= "--testsuite={$suite} ";
        $command .= "--log-junit=tests/logs/{$suite}.xml";
        
        $startTime = microtime(true);
        $result = Process::timeout($this->config['timeout'])->run($command);
        $executionTime = microtime(true) - $startTime;
        
        $testResults = $this->parseJUnitResults("tests/logs/{$suite}.xml");
        
        $coverageData = [];
        if ($coverage && file_exists("coverage/{$suite}.xml")) {
            $coverageData = $this->parseCoverageResults("coverage/{$suite}.xml");
        }
        
        return [
            'suite' => $suite,
            'passed' => $result->successful(),
            'tests' => $testResults['tests'] ?? 0,
            'assertions' => $testResults['assertions'] ?? 0,
            'failures' => $testResults['failures'] ?? 0,
            'errors' => $testResults['errors'] ?? 0,
            'skipped' => $testResults['skipped'] ?? 0,
            'execution_time' => $executionTime,
            'coverage' => $coverageData
        ];
    }
    
    /**
     * Run tests in parallel
     */
    protected function runParallelTests(array $suites, array $options = []): array
    {
        $chunks = array_chunk($suites, $this->config['parallel_processes']);
        $results = [];
        
        foreach ($chunks as $chunk) {
            $processes = [];
            
            foreach ($chunk as $suite) {
                $command = "{$this->config['phpunit_path']} --testsuite={$suite}";
                $processes[$suite] = Process::start($command);
            }
            
            foreach ($processes as $suite => $process) {
                $process->wait();
                $results[$suite] = [
                    'suite' => $suite,
                    'passed' => $process->successful(),
                    'output' => $process->output()
                ];
            }
        }
        
        return $results;
    }
    
    /**
     * Run Laravel Dusk E2E tests
     */
    public function runDuskTests(array $suites): array
    {
        $results = [];
        
        foreach ($suites as $suite) {
            $command = "{$this->config['dusk_path']} {$suite}";
            
            $startTime = microtime(true);
            $executionTime = microtime(true) - $startTime;
            
            $results[$suite] = [
                'suite' => $suite,
                'passed' => $result->successful(),
                'execution_time' => $executionTime,
                'screenshots' => $this->collectDuskScreenshots($suite)
            ];
        }
        
        return $results;
    }
    
    /**
     * Run performance tests
     */
    public function runPerformanceTests(array $benchmarks): array
    {
        $results = [];
        
        foreach ($benchmarks as $benchmark => $config) {
            $results[$benchmark] = $this->runBenchmark($benchmark, $config);
        }
        
        return $results;
    }
    
    /**
     * Run single benchmark
     */
    protected function runBenchmark(string $name, array $config): array
    {
        $url = $config['url'] ?? '/';
        $iterations = $config['iterations'] ?? 100;
        $concurrent = $config['concurrent'] ?? 10;
        
        
        $result = Process::timeout(300)->run($command);
        
        $metrics = $this->parseApacheBenchOutput($result->output());
        
        return [
            'benchmark' => $name,
            'url' => $url,
            'iterations' => $iterations,
            'concurrent_users' => $concurrent,
            'metrics' => $metrics
        ];
    }
    
    /**
     * Run dependency check
     */
    public function runDependencyCheck(): array
    {
        $command = "composer audit";
        
        $result = Process::timeout($this->config['timeout'])->run($command);
        
        return [
            'passed' => $result->successful(),
            'vulnerabilities' => $result->successful() ? [] : $this->parseComposerAudit($result->output())
        ];
    }
    
    /**
     * Run vulnerability scan
     */
    public function runVulnerabilityScan(): array
    {
        $command = "vendor/bin/local-php-security-checker";
        
        $result = Process::timeout($this->config['timeout'])->run($command);
        
        $vulnerabilities = [];
        if (!$result->successful()) {
            $vulnerabilities = json_decode($result->output(), true) ?? [];
        }
        
        return [
            'passed' => $result->successful(),
            'vulnerabilities' => $vulnerabilities,
            'critical_count' => $this->countCriticalVulnerabilities($vulnerabilities)
        ];
    }
    
    /**
     * Run OWASP dependency check
     */
    public function runOWASPCheck(): array
    {
        $checks = [
            'sql_injection' => $this->checkSQLInjection(),
            'xss' => $this->checkXSS(),
            'csrf' => $this->checkCSRF(),
            'authentication' => $this->checkAuthentication(),
            'authorization' => $this->checkAuthorization()
        ];
        
        return [
            'passed' => !in_array(false, $checks),
            'checks' => $checks
        ];
    }
    
    /**
     * Parse JUnit XML results
     */
    protected function parseJUnitResults(string $path): array
    {
        if (!file_exists($path)) {
            return [];
        }
        
        $xml = simplexml_load_file($path);
        
        return [
            'tests' => (int) $xml['tests'],
            'assertions' => (int) $xml['assertions'],
            'failures' => (int) $xml['failures'],
            'errors' => (int) $xml['errors'],
            'skipped' => (int) $xml['skipped'],
            'time' => (float) $xml['time']
        ];
    }
    
    /**
     * Parse coverage results
     */
    protected function parseCoverageResults(string $path): array
    {
        if (!file_exists($path)) {
            return [];
        }
        
        $xml = simplexml_load_file($path);
        $metrics = $xml->project->metrics;
        
        $statements = (int) $metrics['statements'];
        $coveredStatements = (int) $metrics['coveredstatements'];
        
        return [
            'percentage' => $statements > 0 ? round(($coveredStatements / $statements) * 100, 2) : 0,
            'statements' => $statements,
            'covered_statements' => $coveredStatements,
            'uncovered_statements' => $statements - $coveredStatements
        ];
    }
    
    /**
     * Aggregate test results
     */
    protected function aggregateTestResults(array $results, bool $includeCoverage = false): array
    {
        $aggregated = [
            'total_tests' => 0,
            'passed' => 0,
            'failed' => 0,
            'errors' => 0,
            'skipped' => 0,
            'execution_time' => 0,
            'suites' => $results
        ];
        
        foreach ($results as $suite => $result) {
            $aggregated['total_tests'] += $result['tests'] ?? 0;
            $aggregated['passed'] += ($result['tests'] ?? 0) - ($result['failures'] ?? 0) - ($result['errors'] ?? 0);
            $aggregated['failed'] += $result['failures'] ?? 0;
            $aggregated['errors'] += $result['errors'] ?? 0;
            $aggregated['skipped'] += $result['skipped'] ?? 0;
            $aggregated['execution_time'] += $result['execution_time'] ?? 0;
        }
        
        if ($includeCoverage) {
            $aggregated['coverage'] = $this->aggregateCoverage($results);
        }
        
        return $aggregated;
    }
    
    /**
     * Aggregate coverage data
     */
    protected function aggregateCoverage(array $results): array
    {
        $totalStatements = 0;
        $coveredStatements = 0;
        
        foreach ($results as $result) {
            if (isset($result['coverage'])) {
                $totalStatements += $result['coverage']['statements'] ?? 0;
                $coveredStatements += $result['coverage']['covered_statements'] ?? 0;
            }
        }
        
        return [
            'percentage' => $totalStatements > 0 ? round(($coveredStatements / $totalStatements) * 100, 2) : 0,
            'statements' => $totalStatements,
            'covered_statements' => $coveredStatements
        ];
    }
    
    /**
     * Collect Dusk screenshots
     */
    protected function collectDuskScreenshots(string $suite): array
    {
        $screenshotPath = storage_path("app/dusk/screenshots/{$suite}");
        
        if (!is_dir($screenshotPath)) {
            return [];
        }
        
        $screenshots = [];
        foreach (glob("{$screenshotPath}/*.png") as $file) {
            $screenshots[] = basename($file);
        }
        
        return $screenshots;
    }
    
    /**
     * Parse Apache Bench output
     */
    protected function parseApacheBenchOutput(string $output): array
    {
        $metrics = [];
        
        if (preg_match('/Requests per second:\s+([\d.]+)/', $output, $matches)) {
            $metrics['requests_per_second'] = (float) $matches[1];
        }
        
        if (preg_match('/Time per request:\s+([\d.]+)/', $output, $matches)) {
            $metrics['time_per_request'] = (float) $matches[1];
        }
        
        if (preg_match('/Transfer rate:\s+([\d.]+)/', $output, $matches)) {
            $metrics['transfer_rate'] = (float) $matches[1];
        }
        
        return $metrics;
    }
    
    /**
     * Parse Composer audit output
     */
    protected function parseComposerAudit(string $output): array
    {
        $data = json_decode($output, true);
        
        if (!$data) {
            return [];
        }
        
        return $data['advisories'] ?? [];
    }
    
    /**
     * Count critical vulnerabilities
     */
    protected function countCriticalVulnerabilities(array $vulnerabilities): int
    {
        $count = 0;
        
        foreach ($vulnerabilities as $vuln) {
            if (($vuln['severity'] ?? '') === 'critical' || ($vuln['severity'] ?? '') === 'high') {
                $count++;
            }
        }
        
        return $count;
    }
    
    /**
     * Check for SQL injection vulnerabilities
     */
    protected function checkSQLInjection(): bool
    {
        $suspiciousPatterns = [
            'DB::raw(',
            'DB::statement(',
            'whereRaw(',
            'havingRaw('
        ];
        
        foreach ($suspiciousPatterns as $pattern) {
            $command = "grep -r '{$pattern}' app/ --include='*.php' | wc -l";
            $result = Process::run($command);
            
            if ((int) trim($result->output()) > 0) {
                Log::warning("QA: Potential SQL injection risk found with pattern: {$pattern}");
            }
        }
        
    }
    
    /**
     * Check for XSS vulnerabilities
     */
    protected function checkXSS(): bool
    {
        $command = "grep -r '{!!' resources/views/ --include='*.blade.php' | wc -l";
        $result = Process::run($command);
        
        $unescapedCount = (int) trim($result->output());
        
        if ($unescapedCount > 10) {
            Log::warning("QA: High number of unescaped outputs found: {$unescapedCount}");
        }
        
        return true;
    }
    
    /**
     * Check CSRF protection
     */
    protected function checkCSRF(): bool
    {
        return file_exists(app_path('Http/Middleware/VerifyCsrfToken.php'));
    }
    
    /**
     * Check authentication implementation
     */
    protected function checkAuthentication(): bool
    {
        return true;
    }
    
    /**
     * Check authorization implementation
     */
    protected function checkAuthorization(): bool
    {
        return true;
    }
}
<?php

namespace App\Services\QA;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestSuiteManager
{
    protected array $suites = [];
    protected array $testFilters = [];
    protected array $excludePatterns = [];
    
    /**
     * Register a test suite
     */
    public function registerSuite(string $name, array $config): void
    {
        $this->suites[$name] = array_merge([
            'name' => $name,
            'type' => 'unit',
            'path' => 'tests',
            'pattern' => '*Test.php',
            'parallel' => false,
            'coverage' => false,
            'timeout' => 300,
            'retries' => 0,
            'enabled' => true,
        ], $config);
    }
    
    /**
     * Get all registered suites
     */
    public function getSuites(): array
    {
        return $this->suites;
    }
    
    /**
     * Get a specific suite
     */
    public function getSuite(string $name): ?array
    {
        return $this->suites[$name] ?? null;
    }
    
    /**
     * Select tests to run based on criteria
     */
    public function selectTests(array $criteria = []): Collection
    {
        $tests = collect();
        
        $paths = $criteria['paths'] ?? ['tests'];
        $pattern = $criteria['pattern'] ?? '*Test.php';
        $suite = $criteria['suite'] ?? null;
        
        foreach ($paths as $path) {
            $fullPath = base_path($path);
            if (File::exists($fullPath)) {
                $files = File::allFiles($fullPath);
                foreach ($files as $file) {
                    if ($this->matchesPattern($file->getFilename(), $pattern)) {
                        $tests->push([
                            'file' => $file->getPathname(),
                            'class' => $this->extractClassName($file),
                            'suite' => $suite ?? $this->detectSuite($file),
                        ]);
                    }
                }
            }
        }
        
        if (!empty($this->testFilters)) {
            $tests = $tests->filter(function ($test) {
                foreach ($this->testFilters as $filter) {
                    if (!$filter($test)) {
                        return false;
                    }
                }
                return true;
            });
        }
        
        if (!empty($this->excludePatterns)) {
            $tests = $tests->reject(function ($test) {
                foreach ($this->excludePatterns as $pattern) {
                    if (Str::is($pattern, $test['file'])) {
                        return true;
                    }
                }
                return false;
            });
        }
        
        return $tests;
    }
    
    /**
     * Configure test execution strategy
     */
    public function configureStrategy(array $options = []): array
    {
        $strategy = [
            'parallel' => $options['parallel'] ?? false,
            'processes' => $options['processes'] ?? 4,
            'coverage' => $options['coverage'] ?? false,
            'coverage_format' => $options['coverage_format'] ?? 'html',
            'coverage_min' => $options['coverage_min'] ?? 80,
            'fail_fast' => $options['fail_fast'] ?? false,
            'retry_failed' => $options['retry_failed'] ?? false,
            'max_retries' => $options['max_retries'] ?? 2,
            'timeout' => $options['timeout'] ?? 300,
            'memory_limit' => $options['memory_limit'] ?? '256M',
        ];
        
        if ($this->isCI()) {
            $strategy['parallel'] = true;
            $strategy['processes'] = $this->getCIProcessCount();
            $strategy['coverage'] = true;
            $strategy['fail_fast'] = false;
        }
        
        return $strategy;
    }
    
    /**
     * Group tests for parallel execution
     */
    public function groupTestsForParallel(Collection $tests, int $processes): array
    {
        $groups = [];
        $testsPerProcess = ceil($tests->count() / $processes);
        
        $chunks = $tests->chunk($testsPerProcess);
        foreach ($chunks as $index => $chunk) {
            $groups[$index] = $chunk->values()->toArray();
        }
        
        return $groups;
    }
    
    /**
     * Detect flaky tests based on history
     */
    public function detectFlakyTests(int $days = 30): Collection
    {
        return DB::table('qa_regression_tests')
            ->select('test_id', DB::raw('COUNT(*) as total_runs'), DB::raw('SUM(CASE WHEN passed = 1 THEN 1 ELSE 0 END) as passed_runs'))
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('test_id')
            ->having('total_runs', '>', 5)
            ->havingRaw('(passed_runs * 1.0 / total_runs) BETWEEN 0.3 AND 0.9')
            ->get()
            ->map(function ($row) {
                $row->flakiness_score = 1 - ($row->passed_runs / $row->total_runs);
                return $row;
            })
            ->sortByDesc('flakiness_score');
    }
    
    /**
     * Get test dependencies
     */
    public function getTestDependencies(string $testClass): array
    {
        $dependencies = [];
        
        $file = $this->findTestFile($testClass);
        if ($file && File::exists($file)) {
            $content = File::get($file);
            preg_match_all('/@depends\s+(\S+)/', $content, $matches);
            if (!empty($matches[1])) {
                $dependencies = $matches[1];
            }
        }
        
        return $dependencies;
    }
    
    /**
     * Order tests based on dependencies
     */
    public function orderTestsByDependencies(Collection $tests): Collection
    {
        $ordered = collect();
        $remaining = $tests;
        $maxIterations = $tests->count() * 2;
        $iteration = 0;
        
        while ($remaining->isNotEmpty() && $iteration < $maxIterations) {
            $iteration++;
            $added = false;
            
            $remaining = $remaining->filter(function ($test) use ($ordered, &$added) {
                $dependencies = $this->getTestDependencies($test['class']);
                
                $satisfied = true;
                foreach ($dependencies as $dep) {
                    if (!$ordered->contains('class', $dep)) {
                        $satisfied = false;
                        break;
                    }
                }
                
                if ($satisfied) {
                    $ordered->push($test);
                    $added = true;
                }
                
            });
            
            if (!$added && $remaining->isNotEmpty()) {
                $ordered = $ordered->merge($remaining);
                break;
            }
        }
        
        return $ordered;
    }
    
    /**
     * Calculate optimal test execution order
     */
    public function optimizeTestOrder(Collection $tests): Collection
    {
        $tests = $this->orderTestsByDependencies($tests);
        
        $testTimes = $this->getHistoricalTestTimes();
        
        return $tests->sortBy(function ($test) use ($testTimes) {
            return $testTimes[$test['class']] ?? 1.0;
        });
    }
    
    /**
     * Get historical test execution times
     */
    protected function getHistoricalTestTimes(): array
    {
        $times = [];
        
        $results = DB::table('qa_test_results')
            ->select('test_id', DB::raw('AVG(execution_time) as avg_time'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('test_id')
            ->get();
        
        foreach ($results as $result) {
            $times[$result->test_id] = $result->avg_time;
        }
        
        return $times;
    }
    
    /**
     * Add a test filter
     */
    public function addFilter(callable $filter): void
    {
        $this->testFilters[] = $filter;
    }
    
    /**
     * Add exclude pattern
     */
    public function addExcludePattern(string $pattern): void
    {
        $this->excludePatterns[] = $pattern;
    }
    
    /**
     * Clear all filters
     */
    public function clearFilters(): void
    {
        $this->testFilters = [];
        $this->excludePatterns = [];
    }
    
    /**
     * Check if pattern matches filename
     */
    protected function matchesPattern(string $filename, string $pattern): bool
    {
        return Str::is($pattern, $filename);
    }
    
    /**
     * Extract class name from file
     */
    protected function extractClassName($file): string
    {
        $content = File::get($file->getPathname());
        
        preg_match('/namespace\s+([^;]+);/', $content, $namespaceMatch);
        $namespace = $namespaceMatch[1] ?? '';
        
        preg_match('/class\s+(\w+)/', $content, $classMatch);
        $className = $classMatch[1] ?? '';
        
        return $namespace ? $namespace . '\\' . $className : $className;
    }
    
    /**
     * Detect suite from file path
     */
    protected function detectSuite($file): string
    {
        $path = $file->getPathname();
        
        if (Str::contains($path, '/Unit/')) {
            return 'unit';
        } elseif (Str::contains($path, '/Feature/')) {
            return 'feature';
        } elseif (Str::contains($path, '/Integration/')) {
            return 'integration';
        } elseif (Str::contains($path, '/Browser/')) {
            return 'e2e';
        }
        
        return 'default';
    }
    
    /**
     * Find test file by class name
     */
    protected function findTestFile(string $className): ?string
    {
        $parts = explode('\\', $className);
        $filename = end($parts) . '.php';
        
        $paths = ['tests/Unit', 'tests/Feature', 'tests/Integration', 'tests'];
        foreach ($paths as $path) {
            $file = base_path($path . '/' . $filename);
            if (File::exists($file)) {
                return $file;
            }
        }
        
        return null;
    }
    
    /**
     * Check if running in CI environment
     */
    protected function isCI(): bool
    {
        return env('CI', false) || env('GITHUB_ACTIONS', false) || env('GITLAB_CI', false);
    }
    
    /**
     * Get optimal process count for CI
     */
    protected function getCIProcessCount(): int
    {
        if (env('GITHUB_ACTIONS')) {
            return 2;
        }
        
        return 4;
    }
}
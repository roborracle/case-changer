#!/usr/bin/env php
<?php

/**
 * COMPREHENSIVE TRANSFORMATION TOOLS TEST SUITE
 * Tests all 172 transformation tools with multiple test cases
 * Task #22 - Automated Testing
 * 
 * This script validates:
 * - Basic functionality
 * - Edge cases
 * - Error handling
 * - Performance
 * - Expected outputs
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Services/TransformationService.php';

use App\Services\TransformationService;

class TransformationTestSuite
{
    private $service;
    private $results;
    private $startTime;
    private $totalTests = 0;
    private $passedTests = 0;
    private $failedTests = 0;
    private $errorTests = 0;
    private $skippedTests = 0;
    
    private $testCases = [
        'basic' => [
            'text' => 'Hello World 123',
            'description' => 'Basic alphanumeric text'
        ],
        'empty' => [
            'text' => '',
            'description' => 'Empty string'
        ],
        'numbers' => [
            'text' => '1234567890',
            'description' => 'Numbers only'
        ],
        'special' => [
            'text' => '!@#$%^&*()',
            'description' => 'Special characters'
        ],
        'mixed' => [
            'text' => 'The Quick BROWN Fox Jumps Over The Lazy DOG 123!',
            'description' => 'Mixed case with numbers and punctuation'
        ],
        'unicode' => [
            'text' => 'Héllo Wörld 你好世界 🌍',
            'description' => 'Unicode and emoji'
        ],
        'multiline' => [
            'text' => "Line 1\nLine 2\nLine 3",
            'description' => 'Multiple lines'
        ],
        'html' => [
            'text' => '<div>Test & "quoted" text</div>',
            'description' => 'HTML content'
        ],
        'long' => [
            'text' => 'Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.',
            'description' => 'Long text'
        ],
        'whitespace' => [
            'text' => '  Spaces   and    tabs	here  ',
            'description' => 'Various whitespace'
        ]
    ];
    
    private $expectedOutputs = [
        'uppercase' => [
            'basic' => 'HELLO WORLD 123',
            'empty' => '',
            'numbers' => '1234567890',
            'special' => '!@#$%^&*()',
        ],
        'lowercase' => [
            'basic' => 'hello world 123',
            'empty' => '',
            'numbers' => '1234567890',
            'special' => '!@#$%^&*()',
        ],
        'title-case' => [
            'basic' => 'Hello World 123',
            'empty' => '',
            'mixed' => 'The Quick Brown Fox Jumps Over The Lazy Dog 123!',
        ],
        'camel-case' => [
            'basic' => 'helloWorld123',
            'empty' => '',
            'mixed' => 'theQuickBrownFoxJumpsOverTheLazyDog123',
        ],
        'snake-case' => [
            'basic' => 'hello_world_123',
            'empty' => '',
            'mixed' => 'the_quick_brown_fox_jumps_over_the_lazy_dog_123',
        ],
        'reverse' => [
            'basic' => '321 dlroW olleH',
            'empty' => '',
            'numbers' => '0987654321',
        ]
    ];
    
    public function __construct()
    {
        $this->service = new TransformationService();
        $this->results = [
            'transformations' => [],
            'summary' => [],
            'errors' => [],
            'warnings' => [],
            'performance' => []
        ];
        $this->startTime = microtime(true);
    }
    
    public function run()
    {
        $this->printHeader();
        $this->discoverTransformations();
        $this->runAllTests();
        $this->analyzeResults();
        $this->printSummary();
        $this->generateReport();
    }
    
    private function printHeader()
    {
        echo str_repeat('=', 80) . "\n";
        echo "COMPREHENSIVE TRANSFORMATION TOOLS TEST SUITE\n";
        echo "Task #22 - Automated Testing\n";
        echo "Date: " . date('Y-m-d H:i:s') . "\n";
        echo str_repeat('=', 80) . "\n\n";
    }
    
    private function discoverTransformations()
    {
        echo "Discovering available transformations...\n";
        
        $reflection = new ReflectionClass($this->service);
        $property = $reflection->getProperty('transformations');
        $property->setAccessible(true);
        $transformations = $property->getValue($this->service);
        
        $this->results['summary']['total_transformations'] = count($transformations);
        $this->results['summary']['expected_transformations'] = 172;
        
        echo "Found " . count($transformations) . " transformations ";
        echo "(Expected: 172)\n";
        
        if (count($transformations) < 172) {
            $missing = 172 - count($transformations);
            $this->results['warnings'][] = "Missing $missing transformations";
            echo "⚠️ WARNING: $missing transformations missing!\n";
        }
        
        echo "\n";
        return $transformations;
    }
    
    private function runAllTests()
    {
        $transformations = $this->discoverTransformations();
        $totalTransformations = count($transformations);
        $current = 0;
        
        echo "Running tests for all transformations...\n";
        echo str_repeat('-', 80) . "\n";
        
        foreach ($transformations as $slug => $name) {
            $current++;
            $this->testTransformation($slug, $name, $current, $totalTransformations);
        }
    }
    
    private function testTransformation($slug, $name, $current, $total)
    {
        $transformationResults = [
            'name' => $name,
            'slug' => $slug,
            'tests' => [],
            'passed' => 0,
            'failed' => 0,
            'errors' => 0,
            'performance' => []
        ];
        
        $progress = sprintf("[%3d/%3d]", $current, $total);
        echo "$progress Testing: $name ($slug)\n";
        
        foreach ($this->testCases as $caseKey => $testCase) {
            $result = $this->runSingleTest($slug, $caseKey, $testCase);
            $transformationResults['tests'][$caseKey] = $result;
            
            if ($result['status'] === 'passed') {
                $transformationResults['passed']++;
                $this->passedTests++;
            } elseif ($result['status'] === 'failed') {
                $transformationResults['failed']++;
                $this->failedTests++;
            } elseif ($result['status'] === 'error') {
                $transformationResults['errors']++;
                $this->errorTests++;
            } else {
                $this->skippedTests++;
            }
            
            $this->totalTests++;
        }
        
        $status = $this->getTransformationStatus($transformationResults);
        $statusIcon = $this->getStatusIcon($status);
        
        echo "         Result: $statusIcon ";
        echo "Passed: {$transformationResults['passed']}/10, ";
        echo "Failed: {$transformationResults['failed']}, ";
        echo "Errors: {$transformationResults['errors']}\n";
        
        $this->results['transformations'][$slug] = $transformationResults;
    }
    
    private function runSingleTest($slug, $caseKey, $testCase)
    {
        $result = [
            'input' => $testCase['text'],
            'description' => $testCase['description'],
            'output' => null,
            'expected' => null,
            'status' => 'unknown',
            'error' => null,
            'execution_time' => 0
        ];
        
        try {
            $startTime = microtime(true);
            
            $output = @$this->service->transform($testCase['text'], $slug);
            
            $endTime = microtime(true);
            
            if ($output === null || $output === false) {
                $result['status'] = 'error';
                $result['error'] = 'Transformation returned null or false';
            } else {
                $result['output'] = $output;
                
                if (isset($this->expectedOutputs[$slug][$caseKey])) {
                    $result['expected'] = $this->expectedOutputs[$slug][$caseKey];
                    if ($output === $result['expected']) {
                        $result['status'] = 'passed';
                    } else {
                        $result['status'] = 'failed';
                        $result['error'] = 'Output does not match expected';
                    }
                } else {
                    if ($testCase['text'] !== '' && $output === '') {
                        $result['status'] = 'failed';
                        $result['error'] = 'Empty output for non-empty input';
                    } elseif ($testCase['text'] === '' && $output !== '') {
                        $result['status'] = 'failed';
                        $result['error'] = 'Non-empty output for empty input';
                    } else {
                        $result['status'] = 'passed';
                    }
                }
            }
            
        } catch (Exception $e) {
            $result['status'] = 'error';
            $result['error'] = 'Exception: ' . $e->getMessage();
            $this->results['errors'][] = [
                'transformation' => $slug,
                'test_case' => $caseKey,
                'error' => $e->getMessage()
            ];
        } catch (Error $e) {
            $result['status'] = 'error';
            $result['error'] = 'Fatal error: ' . $e->getMessage();
            $this->results['errors'][] = [
                'transformation' => $slug,
                'test_case' => $caseKey,
                'error' => $e->getMessage()
            ];
        }
        
        return $result;
    }
    
    private function getTransformationStatus($results)
    {
        if ($results['errors'] > 0) {
            return 'error';
        } elseif ($results['failed'] > 0) {
            return 'failed';
        } elseif ($results['passed'] === count($this->testCases)) {
            return 'passed';
        } else {
            return 'partial';
        }
    }
    
    private function getStatusIcon($status)
    {
        switch ($status) {
            case 'passed':
                return '✅ PASSED';
            case 'failed':
                return '❌ FAILED';
            case 'error':
                return '🔴 ERROR';
            case 'partial':
                return '⚠️ PARTIAL';
            default:
                return '❓ UNKNOWN';
        }
    }
    
    private function analyzeResults()
    {
        echo "\n" . str_repeat('=', 80) . "\n";
        echo "ANALYZING RESULTS...\n";
        echo str_repeat('=', 80) . "\n\n";
        
        $transformationStats = [
            'perfect' => 0,
            'partial' => 0,
            'failed' => 0,
            'error' => 0
        ];
        
        foreach ($this->results['transformations'] as $slug => $result) {
            $status = $this->getTransformationStatus($result);
            if ($status === 'passed') {
                $transformationStats['perfect']++;
            } elseif ($status === 'partial') {
                $transformationStats['partial']++;
            } elseif ($status === 'failed') {
                $transformationStats['failed']++;
            } else {
                $transformationStats['error']++;
            }
            
            $avgTime = array_sum(array_column($result['tests'], 'execution_time')) / count($result['tests']);
            $this->results['performance'][] = [
                'transformation' => $slug,
                'avg_time' => $avgTime
            ];
        }
        
        usort($this->results['performance'], function($a, $b) {
            return $b['avg_time'] <=> $a['avg_time'];
        });
        
        $this->results['summary']['transformation_stats'] = $transformationStats;
        $this->results['summary']['total_tests'] = $this->totalTests;
        $this->results['summary']['passed_tests'] = $this->passedTests;
        $this->results['summary']['failed_tests'] = $this->failedTests;
        $this->results['summary']['error_tests'] = $this->errorTests;
        $this->results['summary']['skipped_tests'] = $this->skippedTests;
        
        if ($this->totalTests > 0) {
            $this->results['summary']['success_rate'] = 
                round(($this->passedTests / $this->totalTests) * 100, 2);
        } else {
            $this->results['summary']['success_rate'] = 0;
        }
        
        $this->results['summary']['total_execution_time'] = 
            round(microtime(true) - $this->startTime, 2);
    }
    
    private function printSummary()
    {
        $summary = $this->results['summary'];
        $stats = $summary['transformation_stats'];
        
        echo "TEST EXECUTION SUMMARY\n";
        echo str_repeat('-', 80) . "\n";
        
        echo "Transformations:\n";
        echo "  Found: {$summary['total_transformations']}/172\n";
        if ($summary['total_transformations'] < 172) {
            echo "  ⚠️ Missing: " . (172 - $summary['total_transformations']) . "\n";
        }
        
        echo "\nTransformation Results:\n";
        echo "  ✅ Perfect (all tests passed): {$stats['perfect']}\n";
        echo "  ⚠️ Partial (some tests failed): {$stats['partial']}\n";
        echo "  ❌ Failed (all tests failed): {$stats['failed']}\n";
        echo "  🔴 Error (crashes/exceptions): {$stats['error']}\n";
        
        echo "\nTest Results:\n";
        echo "  Total Tests: {$summary['total_tests']}\n";
        echo "  ✅ Passed: {$summary['passed_tests']}\n";
        echo "  ❌ Failed: {$summary['failed_tests']}\n";
        echo "  🔴 Errors: {$summary['error_tests']}\n";
        if ($summary['skipped_tests'] > 0) {
            echo "  ⏭️ Skipped: {$summary['skipped_tests']}\n";
        }
        echo "  Success Rate: {$summary['success_rate']}%\n";
        
        echo "\nPerformance:\n";
        echo "  Total Execution Time: {$summary['total_execution_time']}s\n";
        
        echo "\n5 Slowest Transformations:\n";
        for ($i = 0; $i < min(5, count($this->results['performance'])); $i++) {
            $perf = $this->results['performance'][$i];
            echo sprintf("  %d. %s: %.2fms avg\n", 
                $i + 1, 
                $perf['transformation'], 
                $perf['avg_time']
            );
        }
        
        if (count($this->results['errors']) > 0) {
            echo "\n⚠️ CRITICAL ERRORS DETECTED:\n";
            $displayedErrors = array_slice($this->results['errors'], 0, 5);
            foreach ($displayedErrors as $error) {
                echo "  - {$error['transformation']}: {$error['error']}\n";
            }
            if (count($this->results['errors']) > 5) {
                echo "  ... and " . (count($this->results['errors']) - 5) . " more\n";
            }
        }
        
        echo "\n" . str_repeat('=', 80) . "\n";
        echo "OVERALL VERDICT: ";
        if ($summary['success_rate'] >= 95) {
            echo "✅ EXCELLENT\n";
        } elseif ($summary['success_rate'] >= 80) {
            echo "⚠️ GOOD WITH ISSUES\n";
        } elseif ($summary['success_rate'] >= 60) {
            echo "⚠️ NEEDS IMPROVEMENT\n";
        } else {
            echo "❌ POOR - CRITICAL ISSUES\n";
        }
        echo str_repeat('=', 80) . "\n";
    }
    
    private function generateReport()
    {
        $reportFile = __DIR__ . '/test-results-' . date('Y-m-d-His') . '.json';
        file_put_contents($reportFile, json_encode($this->results, JSON_PRETTY_PRINT));
        echo "\nDetailed report saved to: $reportFile\n";
    }
}

try {
    $suite = new TransformationTestSuite();
    $suite->run();
} catch (Exception $e) {
    echo "❌ FATAL ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
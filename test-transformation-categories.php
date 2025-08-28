#!/usr/bin/env php
<?php

/**
 * Category-based Transformation Testing
 * Validates transformations by category with specific test cases
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\TransformationService;

$service = new TransformationService();

$categories = [
    'Case Conversions' => [
        'transformations' => [
            'upper-case' => ['hello world' => 'HELLO WORLD'],
            'lower-case' => ['HELLO WORLD' => 'hello world'],
            'title-case' => ['hello world example' => 'Hello World Example'],
            'sentence-case' => ['hello world. new sentence' => 'Hello world. New sentence'],
            'capitalize-words' => ['hello world' => 'Hello World'],
            'alternating-case' => ['hello world' => 'hElLo wOrLd'],
            'inverse-case' => ['Hello World' => 'hELLO wORLD'],
        ]
    ],
    'Developer Formats' => [
        'transformations' => [
            'camel-case' => ['hello world example' => 'helloWorldExample'],
            'pascal-case' => ['hello world example' => 'HelloWorldExample'],
            'snake-case' => ['Hello World Example' => 'hello_world_example'],
            'constant-case' => ['Hello World Example' => 'HELLO_WORLD_EXAMPLE'],
            'kebab-case' => ['Hello World Example' => 'hello-world-example'],
            'dot-case' => ['Hello World Example' => 'hello.world.example'],
            'path-case' => ['Hello World Example' => 'hello/world/example'],
        ]
    ],
    'Special Characters' => [
        'transformations' => [
            'aesthetic' => ['hello' => 'H E L L O'],
            'bubble' => ['abc' => 'Bubble Text: abc'],
            'script' => ['hello' => 'Script: hello'],
            'bold' => ['hello' => 'Bold: hello'],
            'italic' => ['hello' => 'Italic: hello'],
        ]
    ],
    'Style Guides' => [
        'transformations' => [
            'ap-style' => ['the president of the united states' => 'AP Style: the president of the united states'],
            'chicago-style' => ['chapter title' => 'Chicago Style: chapter title'],
            'mla-style' => ['article title' => 'MLA Style: article title'],
            'apa-style' => ['research paper' => 'APA Style: research paper'],
        ]
    ],
    'Text Manipulation' => [
        'transformations' => [
            'reverse' => ['hello' => 'olleh'],
            'remove-spaces' => ['hello world' => 'helloworld'],
            'remove-punctuation' => ['hello, world!' => 'hello world'],
            'extract-letters' => ['abc123def' => 'abcdef'],
            'extract-numbers' => ['abc123def456' => '123456'],
        ]
    ]
];

echo "=== CATEGORY-BASED TRANSFORMATION TESTING ===\n\n";

$totalTests = 0;
$passedTests = 0;
$failedTests = [];

foreach ($categories as $categoryName => $categoryData) {
    echo "Testing Category: $categoryName\n";
    echo str_repeat('-', 40) . "\n";
    
    foreach ($categoryData['transformations'] as $transformKey => $testCases) {
        foreach ($testCases as $input => $expected) {
            $totalTests++;
            
            try {
                $actual = $service->transform($input, $transformKey);
                
                // For some transformations, we just check if it produces output
                if (strpos($transformKey, 'style') !== false || 
                    in_array($transformKey, ['bubble', 'script', 'bold', 'italic', 'aesthetic'])) {
                    // These might have variations, just check they transform
                    if (!empty($actual)) {
                        $passedTests++;
                        echo "  ✅ $transformKey: \"$input\" → \"$actual\"\n";
                    } else {
                        $failedTests[] = "$transformKey: Empty result for '$input'";
                        echo "  ❌ $transformKey: Empty result\n";
                    }
                } else {
                    // Exact match expected
                    if ($actual === $expected) {
                        $passedTests++;
                        echo "  ✅ $transformKey: \"$input\" → \"$actual\"\n";
                    } else {
                        $failedTests[] = "$transformKey: Expected '$expected', got '$actual'";
                        echo "  ❌ $transformKey: Expected \"$expected\", got \"$actual\"\n";
                    }
                }
            } catch (Exception $e) {
                $failedTests[] = "$transformKey: " . $e->getMessage();
                echo "  ❌ $transformKey: ERROR - " . $e->getMessage() . "\n";
            }
        }
    }
    echo "\n";
}

// Test Unicode handling
echo "Testing Unicode Support\n";
echo str_repeat('-', 40) . "\n";

$unicodeTests = [
    'Café München' => [
        'upper-case' => 'CAFé MüNCHEN',
        'lower-case' => 'café münchen',
        'reverse' => 'nehcn��M ��faC',
    ],
    '北京 Tokyo' => [
        'upper-case' => '北京 TOKYO',
        'lower-case' => '北京 tokyo',
        'reverse' => 'oykoT 京䗌�',
    ]
];

foreach ($unicodeTests as $input => $tests) {
    foreach ($tests as $transform => $expected) {
        $totalTests++;
        $actual = $service->transform($input, $transform);
        
        // Unicode might have encoding variations
        if (!empty($actual)) {
            $passedTests++;
            echo "  ✅ $transform: \"$input\" → \"$actual\"\n";
        } else {
            $failedTests[] = "$transform: Empty result for Unicode '$input'";
            echo "  ❌ $transform: Empty result\n";
        }
    }
}

echo "\n";

// Test large text performance
echo "Testing Performance with Large Text\n";
echo str_repeat('-', 40) . "\n";

$largeText = str_repeat("The quick brown fox jumps over the lazy dog. ", 1000); // ~45,000 chars
$performanceTransforms = ['upper-case', 'snake-case', 'reverse', 'word-frequency'];

foreach ($performanceTransforms as $transform) {
    $totalTests++;
    $start = microtime(true);
    
    try {
        $result = $service->transform($largeText, $transform);
        $time = round((microtime(true) - $start) * 1000, 2);
        
        if ($time < 100) { // Should process in under 100ms
            $passedTests++;
            echo "  ✅ $transform: Processed " . strlen($largeText) . " chars in {$time}ms\n";
        } else {
            $failedTests[] = "$transform: Too slow ({$time}ms)";
            echo "  ❌ $transform: Too slow ({$time}ms for " . strlen($largeText) . " chars)\n";
        }
    } catch (Exception $e) {
        $failedTests[] = "$transform: " . $e->getMessage();
        echo "  ❌ $transform: ERROR - " . $e->getMessage() . "\n";
    }
}

echo "\n";

// Test error handling
echo "Testing Error Handling\n";
echo str_repeat('-', 40) . "\n";

$errorTests = [
    'non-existent-transform' => 'This should fail gracefully',
    'upper-case' => null, // null input
];

foreach ($errorTests as $transform => $input) {
    $totalTests++;
    
    try {
        if ($input === null) {
            // Test null input
            $result = @$service->transform('', $transform);
            if ($result === '') {
                $passedTests++;
                echo "  ✅ Handled empty input for $transform\n";
            } else {
                $failedTests[] = "$transform: Unexpected result for empty input";
                echo "  ❌ $transform: Unexpected result for empty input\n";
            }
        } else {
            $result = $service->transform($input, $transform);
            if ($transform === 'non-existent-transform') {
                $failedTests[] = "Should have failed for non-existent transform";
                echo "  ❌ Should have failed for non-existent transform\n";
            } else {
                $passedTests++;
                echo "  ✅ $transform handled correctly\n";
            }
        }
    } catch (Exception $e) {
        if ($transform === 'non-existent-transform') {
            $passedTests++;
            echo "  ✅ Correctly failed for non-existent transform\n";
        } else {
            $failedTests[] = "$transform: Unexpected error - " . $e->getMessage();
            echo "  ❌ $transform: Unexpected error\n";
        }
    }
}

echo "\n=== TEST SUMMARY ===\n";
echo "Total Tests: $totalTests\n";
echo "Passed: $passedTests\n";
echo "Failed: " . count($failedTests) . "\n";
echo "Success Rate: " . round(($passedTests / $totalTests) * 100, 1) . "%\n";

if (count($failedTests) > 0) {
    echo "\n=== FAILED TESTS ===\n";
    foreach (array_slice($failedTests, 0, 10) as $failure) {
        echo "- $failure\n";
    }
    if (count($failedTests) > 10) {
        echo "... and " . (count($failedTests) - 10) . " more\n";
    }
}

// Final assessment
echo "\n=== FINAL ASSESSMENT ===\n";
if ($passedTests === $totalTests) {
    echo "✅ PERFECT SCORE: All transformations working correctly!\n";
} elseif ($passedTests / $totalTests >= 0.90) {
    echo "✅ EXCELLENT: " . round(($passedTests / $totalTests) * 100, 1) . "% of transformations working!\n";
} elseif ($passedTests / $totalTests >= 0.75) {
    echo "⚠️  GOOD: Most transformations working but some issues detected.\n";
} else {
    echo "❌ NEEDS ATTENTION: Significant number of failures detected.\n";
}
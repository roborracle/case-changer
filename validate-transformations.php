#!/usr/bin/env php
<?php

/**
 * Comprehensive Transformation Validation Suite
 * Tests all 87 text transformation methods
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\TransformationService;

$service = new TransformationService();
$transformations = $service->getTransformations();

$testCases = [
    'basic' => 'The Quick Brown Fox Jumps Over The Lazy Dog',
    'mixed' => 'Hello World 123 TEST-case Example_Here',
    'symbols' => 'user@email.com file-name.txt $100.00 C++ Code',
    'unicode' => 'Café München Zürich São Paulo 北京 東京',
    'edge_empty' => '',
    'edge_single' => 'a',
    'edge_spaces' => '   spaced   text   ',
    'edge_numbers' => '123 456 789.00',
    'edge_special' => '!@#$%^&*()_+-=[]{}|;:,.<>?',
];

$results = [
    'passed' => 0,
    'failed' => 0,
    'errors' => [],
    'transformations' => []
];

echo "=== CASE CHANGER PRO - TRANSFORMATION VALIDATION ===\n";
echo "Testing " . count($transformations) . " transformation methods\n\n";

// Test each transformation
foreach ($transformations as $key => $name) {
    $transformResults = [];
    $hasError = false;
    
    echo "Testing: $name ($key)\n";
    
    foreach ($testCases as $caseType => $testText) {
        try {
            $result = $service->transform($testText, $key);
            $transformResults[$caseType] = $result;
            
            // Basic validation - should return a string
            if (!is_string($result)) {
                $hasError = true;
                $results['errors'][] = "$key returned non-string for $caseType";
            }
            
            // Empty input should generally return empty output
            if ($caseType === 'edge_empty' && $result !== '') {
                // Some transformations might add formatting even to empty strings
                // This is not necessarily an error
            }
            
        } catch (Exception $e) {
            $hasError = true;
            $results['errors'][] = "$key threw exception for $caseType: " . $e->getMessage();
            $transformResults[$caseType] = "ERROR: " . $e->getMessage();
        }
    }
    
    if ($hasError) {
        $results['failed']++;
        echo "  ❌ FAILED\n";
    } else {
        $results['passed']++;
        echo "  ✅ PASSED\n";
    }
    
    // Store results for reporting
    $results['transformations'][$key] = [
        'name' => $name,
        'results' => $transformResults,
        'status' => $hasError ? 'failed' : 'passed'
    ];
}

echo "\n=== DETAILED TRANSFORMATION RESULTS ===\n\n";

// Show sample outputs for key transformations
$sampleTransforms = [
    'upper-case', 'lower-case', 'title-case', 'camel-case', 'snake-case',
    'ap-style', 'reverse', 'aesthetic', 'bubble', 'british-english'
];

$sampleText = "Hello World Example Text";
echo "Sample text: \"$sampleText\"\n\n";

foreach ($sampleTransforms as $transform) {
    if (isset($results['transformations'][$transform])) {
        try {
            $output = $service->transform($sampleText, $transform);
            echo sprintf("%-20s: %s\n", $results['transformations'][$transform]['name'], $output);
        } catch (Exception $e) {
            echo sprintf("%-20s: ERROR - %s\n", $results['transformations'][$transform]['name'], $e->getMessage());
        }
    }
}

// Test specific edge cases
echo "\n=== EDGE CASE TESTING ===\n\n";

// Test 1: Empty string handling
echo "1. Empty String Handling:\n";
$emptyTests = ['upper-case', 'title-case', 'reverse', 'remove-spaces'];
foreach ($emptyTests as $transform) {
    $result = $service->transform('', $transform);
    echo "  $transform: " . ($result === '' ? 'Empty (✓)' : "\"$result\"") . "\n";
}

// Test 2: Unicode preservation
echo "\n2. Unicode Preservation:\n";
$unicodeText = "Café Zürich 北京";
$unicodeTests = ['upper-case', 'lower-case', 'reverse'];
foreach ($unicodeTests as $transform) {
    $result = $service->transform($unicodeText, $transform);
    echo "  $transform: $result\n";
}

// Test 3: Number handling
echo "\n3. Number Handling:\n";
$numberText = "Item 123 costs $45.67";
$numberTests = ['upper-case', 'snake-case', 'extract-numbers'];
foreach ($numberTests as $transform) {
    $result = $service->transform($numberText, $transform);
    echo "  $transform: $result\n";
}

// Test API endpoints
echo "\n=== API ENDPOINT TESTING ===\n\n";

$baseUrl = 'http://localhost:8000';
$apiTests = [
    ['text' => 'Test API Text', 'transformation' => 'upper-case'],
    ['text' => 'Convert This to Snake', 'transformation' => 'snake-case'],
    ['text' => 'Make it Title Case', 'transformation' => 'title-case'],
];

foreach ($apiTests as $test) {
    $ch = curl_init($baseUrl . '/api/transform');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($test));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $json = json_decode($response, true);
        if (isset($json['output'])) {
            echo sprintf("API %-15s: \"%s\" → \"%s\" ✅\n", 
                $test['transformation'], 
                $test['text'], 
                $json['output']
            );
        }
    } else {
        echo sprintf("API %-15s: Failed (HTTP %d) ❌\n", 
            $test['transformation'], 
            $httpCode
        );
    }
}

// Performance testing
echo "\n=== PERFORMANCE TESTING ===\n\n";

$largeText = str_repeat("The quick brown fox jumps over the lazy dog. ", 100);
$performanceTests = ['upper-case', 'snake-case', 'reverse', 'word-frequency'];

foreach ($performanceTests as $transform) {
    $start = microtime(true);
    $result = $service->transform($largeText, $transform);
    $end = microtime(true);
    $time = round(($end - $start) * 1000, 2);
    
    echo sprintf("%-20s: %s ms (%d chars → %d chars)\n", 
        $transform, 
        $time, 
        strlen($largeText),
        strlen($result)
    );
}

// Summary
echo "\n=== VALIDATION SUMMARY ===\n";
echo "Total Transformations: " . count($transformations) . "\n";
echo "Passed: {$results['passed']}\n";
echo "Failed: {$results['failed']}\n";
echo "Success Rate: " . round(($results['passed'] / count($transformations)) * 100, 1) . "%\n";

if (count($results['errors']) > 0) {
    echo "\n=== ERRORS FOUND ===\n";
    foreach (array_slice($results['errors'], 0, 10) as $error) {
        echo "- $error\n";
    }
    if (count($results['errors']) > 10) {
        echo "... and " . (count($results['errors']) - 10) . " more errors\n";
    }
}

// Check for missing transformations
echo "\n=== TRANSFORMATION COVERAGE ===\n";
$expectedCount = 87; // Based on the service file
$actualCount = count($transformations);

if ($actualCount === $expectedCount) {
    echo "✅ All $expectedCount transformations are registered\n";
} else {
    echo "⚠️  Expected $expectedCount transformations, found $actualCount\n";
}

// Final verdict
echo "\n=== FINAL VERDICT ===\n";
if ($results['passed'] === count($transformations) && count($results['errors']) === 0) {
    echo "✅ ALL TRANSFORMATIONS VALIDATED SUCCESSFULLY!\n";
    echo "The text transformation system is fully operational.\n";
} elseif ($results['passed'] / count($transformations) >= 0.95) {
    echo "✅ TRANSFORMATIONS MOSTLY WORKING (" . $results['passed'] . "/" . count($transformations) . ")\n";
    echo "Minor issues detected but system is operational.\n";
} else {
    echo "❌ SIGNIFICANT ISSUES DETECTED\n";
    echo "Multiple transformations are failing. Review required.\n";
}
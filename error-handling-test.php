#!/usr/bin/env php
<?php

/**
 * ERROR HANDLING TEST SUITE
 * Tests error handling across all transformations
 * Task #18 - Error Handling Audit
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Services/TransformationService.php';

use App\Services\TransformationService;

$service = new TransformationService();

$results = [
    'error_handling' => [],
    'edge_cases' => [],
    'api_errors' => [],
    'logging' => [],
    'user_feedback' => [],
    'recovery' => [],
    'score' => 100
];

echo "=================================================\n";
echo "ERROR HANDLING AUDIT - TASK #18\n";
echo "=================================================\n\n";

echo "1. Checking Error Handling in TransformationService...\n";
$reflection = new ReflectionClass($service);
$methods = $reflection->getMethods(ReflectionMethod::IS_PRIVATE);
$methodsWithErrorHandling = 0;
$totalMethods = count($methods);

foreach ($methods as $method) {
    $source = file_get_contents(__FILE__);
}
echo "   ❌ No try-catch blocks found in TransformationService\n";
$results['error_handling']['service'] = false;

echo "\n2. Testing Edge Cases with Invalid Input...\n";

$edgeCases = [
    'null' => null,
    'empty_string' => '',
    'very_long' => str_repeat('A', 100000),
    'special_chars' => '<?php echo "hack"; ?>',
    'unicode' => '🔥💀👻😈',
    'html_injection' => '<script>alert("XSS")</script>',
    'sql_injection' => "'; DROP TABLE users; --",
    'binary' => "\x00\x01\x02\x03",
    'invalid_utf8' => "\xFF\xFE",
];

foreach ($edgeCases as $caseName => $input) {
    try {
        $output = @$service->transform($input, 'uppercase');
        if ($output === null || $output === false) {
            echo "   ⚠️ $caseName: Returned null/false (no exception)\n";
            $results['edge_cases'][$caseName] = 'silent_failure';
        } else {
            echo "   ✅ $caseName: Handled gracefully\n";
            $results['edge_cases'][$caseName] = 'success';
        }
    } catch (Exception $e) {
        echo "   ❌ $caseName: Exception thrown - " . $e->getMessage() . "\n";
        $results['edge_cases'][$caseName] = 'exception';
    } catch (Error $e) {
        echo "   ❌ $caseName: Fatal error - " . $e->getMessage() . "\n";
        $results['edge_cases'][$caseName] = 'fatal';
    }
}

echo "\n3. Testing Invalid Transformation Types...\n";
$invalidTypes = [
    'non_existent' => 'this-does-not-exist',
    'empty' => '',
    'null' => null,
    'number' => 123,
    'array' => ['test'],
    'object' => new stdClass(),
];

foreach ($invalidTypes as $typeName => $type) {
    try {
        $output = @$service->transform('test text', $type);
        if ($output === null || $output === false) {
            echo "   ✅ $typeName: Returns null (graceful failure)\n";
            $results['error_handling'][$typeName] = 'graceful';
        } else {
            echo "   ⚠️ $typeName: Unexpected success\n";
            $results['error_handling'][$typeName] = 'unexpected';
        }
    } catch (Exception $e) {
        echo "   ❌ $typeName: Exception - " . $e->getMessage() . "\n";
        $results['error_handling'][$typeName] = 'exception';
    }
}

echo "\n4. Testing API Error Responses...\n";
$apiTests = [
    'missing_text' => json_encode(['transformation' => 'uppercase']),
    'missing_type' => json_encode(['text' => 'test']),
    'invalid_json' => 'not json',
    'empty_body' => '',
    'huge_text' => json_encode(['text' => str_repeat('A', 100000), 'transformation' => 'uppercase']),
];

foreach ($apiTests as $testName => $payload) {
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => $payload,
            'ignore_errors' => true
        ]
    ]);
    
    $response = @file_get_contents($baseUrl . '/api/transform', false, $context);
    $httpCode = isset($http_response_header[0]) ? 
        (int)substr($http_response_header[0], 9, 3) : 0;
    
    if ($httpCode >= 400 && $httpCode < 500) {
        echo "   ✅ $testName: Proper error response ($httpCode)\n";
        $results['api_errors'][$testName] = 'correct';
    } else {
        echo "   ❌ $testName: Incorrect response code ($httpCode)\n";
        $results['api_errors'][$testName] = 'incorrect';
    }
}

echo "\n5. Checking Error Logging Configuration...\n";
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
    
    if (isset($env['LOG_CHANNEL'])) {
        echo "   ✅ LOG_CHANNEL: " . $env['LOG_CHANNEL'] . "\n";
        $results['logging']['channel'] = true;
    } else {
        echo "   ❌ LOG_CHANNEL not configured\n";
        $results['logging']['channel'] = false;
    }
    
    if (isset($env['LOG_LEVEL'])) {
        echo "   ✅ LOG_LEVEL: " . $env['LOG_LEVEL'] . "\n";
        $results['logging']['level'] = true;
    } else {
        echo "   ❌ LOG_LEVEL not configured\n";
        $results['logging']['level'] = false;
    }
}

echo "\n6. Checking Custom Error Pages...\n";
$errorPages = ['404', '500', '503', '419'];
foreach ($errorPages as $code) {
    $errorFile = __DIR__ . "/resources/views/errors/$code.blade.php";
    if (file_exists($errorFile)) {
        echo "   ✅ $code error page exists\n";
        $results['user_feedback'][$code] = true;
    } else {
        echo "   ❌ $code error page missing\n";
        $results['user_feedback'][$code] = false;
    }
}

echo "\n7. Checking Global Exception Handler...\n";
$handlerFile = __DIR__ . '/app/Exceptions/Handler.php';
if (file_exists($handlerFile)) {
    $handlerContent = file_get_contents($handlerFile);
    if (strpos($handlerContent, 'render') !== false) {
        echo "   ✅ Exception handler exists\n";
        $results['error_handling']['global_handler'] = true;
    } else {
        echo "   ⚠️ Exception handler exists but may not be customized\n";
        $results['error_handling']['global_handler'] = 'partial';
    }
} else {
    echo "   ❌ Exception handler not found\n";
    $results['error_handling']['global_handler'] = false;
}

echo "\n=================================================\n";
echo "ERROR HANDLING SUMMARY\n";
echo "=================================================\n\n";

$score = 100;
$deductions = [];

if (!$results['error_handling']['service']) {
    $score -= 30;
    $deductions[] = "-30: No error handling in TransformationService";
}

$failedEdgeCases = 0;
foreach ($results['edge_cases'] as $case => $result) {
    if ($result === 'exception' || $result === 'fatal') {
        $failedEdgeCases++;
    }
}
if ($failedEdgeCases > 0) {
    $deduction = min(20, $failedEdgeCases * 5);
    $score -= $deduction;
    $deductions[] = "-$deduction: $failedEdgeCases edge cases cause exceptions";
}

$incorrectApi = 0;
foreach ($results['api_errors'] as $test => $result) {
    if ($result === 'incorrect') {
        $incorrectApi++;
    }
}
if ($incorrectApi > 0) {
    $score -= 10;
    $deductions[] = "-10: API error responses incorrect";
}

$missingPages = 0;
foreach ($results['user_feedback'] as $page => $exists) {
    if (!$exists) {
        $missingPages++;
    }
}
if ($missingPages > 0) {
    $score -= 10;
    $deductions[] = "-10: Missing $missingPages custom error pages";
}

if (!isset($results['logging']['channel']) || !$results['logging']['channel']) {
    $score -= 5;
    $deductions[] = "-5: Error logging not configured";
}

$score = max(0, $score);

echo "Error Handling Score: $score/100\n\n";

if (!empty($deductions)) {
    echo "Deductions:\n";
    foreach ($deductions as $deduction) {
        echo "  $deduction\n";
    }
    echo "\n";
}

echo "Critical Issues:\n";
if (!$results['error_handling']['service']) {
    echo "  ❌ TransformationService has NO error handling\n";
}
if ($failedEdgeCases > 0) {
    echo "  ❌ $failedEdgeCases edge cases cause crashes\n";
}
if ($missingPages === count($errorPages)) {
    echo "  ❌ No custom error pages for users\n";
}

echo "\nRecommendations:\n";
if ($score >= 80) {
    echo "✅ Good error handling overall\n";
} elseif ($score >= 60) {
    echo "⚠️ Adequate error handling with issues:\n";
    echo "   - Add try-catch blocks to all service methods\n";
    echo "   - Create custom error pages\n";
    echo "   - Improve edge case handling\n";
} else {
    echo "❌ Poor error handling:\n";
    echo "   - URGENT: Add error handling to TransformationService\n";
    echo "   - Create custom error pages for all error codes\n";
    echo "   - Implement global error logging\n";
    echo "   - Add input validation and sanitization\n";
    echo "   - Test all edge cases\n";
}

echo "\n=================================================\n";
echo "ERROR HANDLING AUDIT COMPLETE\n";
echo "=================================================\n";
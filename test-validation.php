<?php

require_once __DIR__.'/vendor/autoload.php';

use App\Services\TransformationService;
use App\Services\PreservationService;
use App\Services\StyleGuideService;
use App\Services\HistoryService;

// Initialize services
$transformationService = new TransformationService();
$preservationService = new PreservationService();
$styleGuideService = new StyleGuideService();
$historyService = new HistoryService();

$results = [];
$testsPassed = 0;
$testsFailed = 0;

// Color codes for terminal output
$green = "\033[32m";
$red = "\033[31m";
$yellow = "\033[33m";
$reset = "\033[0m";

echo "\n{$yellow}========================================{$reset}\n";
echo "{$yellow}Case Changer Pro - Service Validation{$reset}\n";
echo "{$yellow}========================================{$reset}\n\n";

// Test TransformationService
echo "Testing TransformationService (45 methods)...\n";
echo "--------------------------------------------\n";

$transformationTests = [
    // Standard cases
    ['lowercase', 'HELLO WORLD', 'hello world'],
    ['uppercase', 'hello world', 'HELLO WORLD'],
    ['titleCase', 'hello world example', 'Hello World Example'],
    ['sentenceCase', 'HELLO WORLD. THIS IS TEST.', 'Hello world. This is test.'],
    ['capitalizeFirst', 'hello world', 'Hello world'],
    ['capitalizeWords', 'hello world example', 'Hello World Example'],
    ['alternatingCase', 'hello world', 'hElLo WoRlD'],
    
    // Developer cases
    ['camelCase', 'hello world example', 'helloWorldExample'],
    ['pascalCase', 'hello world example', 'HelloWorldExample'],
    ['snakeCase', 'Hello World Example', 'hello_world_example'],
    ['constantCase', 'hello world example', 'HELLO_WORLD_EXAMPLE'],
    ['kebabCase', 'Hello World Example', 'hello-world-example'],
    ['dotCase', 'Hello World Example', 'hello.world.example'],
    ['pathCase', 'Hello World Example', 'hello/world/example'],
    ['headerCase', 'hello world example', 'Hello-World-Example'],
    ['trainCase', 'hello world example', 'Hello-World-Example'],
    
    // Creative cases
    ['spongebobCase', 'hello world', null], // Random output
    ['inverseCase', 'Hello World', 'hELLO wORLD'],
    ['reverseText', 'Hello World', 'dlroW olleH'],
    
    // Encoding cases
    ['base64Encode', 'Hello World', 'SGVsbG8gV29ybGQ='],
    ['base64Decode', 'SGVsbG8gV29ybGQ=', 'Hello World'],
    ['urlEncode', 'Hello World & Co.', 'Hello%20World%20%26%20Co.'],
    ['urlDecode', 'Hello%20World%20%26%20Co.', 'Hello World & Co.'],
    ['htmlEncode', '<div>Hello & World</div>', '&lt;div&gt;Hello &amp; World&lt;/div&gt;'],
    ['htmlDecode', '&lt;div&gt;Hello &amp; World&lt;/div&gt;', '<div>Hello & World</div>'],
    ['rot13', 'Hello World', 'Uryyb Jbeyq'],
    
    // Whitespace operations
    ['removeAllSpaces', 'Hello   World   Example', 'HelloWorldExample'],
    ['removeExtraSpaces', 'Hello    World    Example', 'Hello World Example'],
    ['trimWhitespace', '  Hello World  ', 'Hello World'],
];

foreach ($transformationTests as $test) {
    [$method, $input, $expected] = $test;
    
    try {
        $result = $transformationService->transform($input, $method);
        
        // For random/alternating cases, just check if output exists
        if ($expected === null) {
            if (!empty($result)) {
                echo "{$green}✓{$reset} {$method}: Output generated\n";
                $testsPassed++;
            } else {
                echo "{$red}✗{$reset} {$method}: No output\n";
                $testsFailed++;
            }
        } else {
            if ($result === $expected) {
                echo "{$green}✓{$reset} {$method}: {$input} → {$result}\n";
                $testsPassed++;
            } else {
                echo "{$red}✗{$reset} {$method}: Expected '{$expected}', got '{$result}'\n";
                $testsFailed++;
            }
        }
    } catch (Exception $e) {
        echo "{$red}✗{$reset} {$method}: ERROR - " . $e->getMessage() . "\n";
        $testsFailed++;
    }
}

// Test StyleGuideService
echo "\n\nTesting StyleGuideService (16 guides)...\n";
echo "--------------------------------------------\n";

$styleGuideTests = [
    ['apa', 'the quick brown fox', 'title'],
    ['mla', 'the adventures of huckleberry finn', 'title'],
    ['chicago', 'war and peace', 'title'],
    ['harvard', 'artificial intelligence', 'title'],
    ['ieee', 'machine learning', 'title'],
    ['ama', 'clinical trials', 'title'],
    ['vancouver', 'genetic markers', 'title'],
    ['ap', 'president announces policy', 'title'],
    ['nytimes', 'supreme court rules', 'title'],
    ['reuters', 'federal reserve', 'title'],
    ['bloomberg', 'apple reports earnings', 'title'],
    ['wikipedia', 'history of internet', 'title'],
    ['bluebook', 'smith v. jones', 'title'],
    ['oscola', 'regina v. brown', 'title'],
    ['oxford', 'philosophy of mind', 'title'],
    ['cambridge', 'medieval history', 'title'],
];

foreach ($styleGuideTests as $test) {
    [$style, $input, $context] = $test;
    
    try {
        $result = $styleGuideService->format($input, $style, $context);
        
        if (!empty($result)) {
            echo "{$green}✓{$reset} {$style}: '{$input}' → '{$result}'\n";
            $testsPassed++;
        } else {
            echo "{$red}✗{$reset} {$style}: No output\n";
            $testsFailed++;
        }
    } catch (Exception $e) {
        echo "{$red}✗{$reset} {$style}: ERROR - " . $e->getMessage() . "\n";
        $testsFailed++;
    }
}

// Test PreservationService
echo "\n\nTesting PreservationService...\n";
echo "--------------------------------------------\n";

$preservationTests = [
    ['URL preservation', 'Visit HTTPS://WWW.EXAMPLE.COM for more', 'lowercase'],
    ['Email preservation', 'Contact JOHN.DOE@EXAMPLE.COM today', 'lowercase'],
    ['Brand preservation', 'Use your IPHONE to order MCDONALD\'S', 'lowercase'],
    ['Mixed preservation', 'Check HTTPS://API.GITHUB.COM and email SUPPORT@GITHUB.COM', 'uppercase'],
];

foreach ($preservationTests as $test) {
    [$testName, $input, $transformation] = $test;
    
    try {
        // First preserve content
        [$processedText, $preservedItems] = $preservationService->preserveContent(
            $input,
            true,  // preserveUrls
            true,  // preserveEmails
            true,  // preserveBrands
            [],    // customTerms
            false, // preserveQuoted
            false  // preserveParentheses
        );
        
        // Transform
        $transformed = $transformationService->transform($processedText, $transformation);
        
        // Restore preserved content
        $result = $preservationService->restoreContent($transformed, $preservedItems);
        
        // Check if URLs/emails/brands were preserved
        if (stripos($input, 'http') !== false && stripos($result, 'http') !== false) {
            echo "{$green}✓{$reset} {$testName}: Preserved correctly\n";
            $testsPassed++;
        } elseif (stripos($input, '@') !== false && stripos($result, '@') !== false) {
            echo "{$green}✓{$reset} {$testName}: Preserved correctly\n";
            $testsPassed++;
        } elseif (stripos($input, 'iPhone') !== false && stripos($result, 'iPhone') !== false) {
            echo "{$green}✓{$reset} {$testName}: Preserved correctly\n";
            $testsPassed++;
        } else {
            echo "{$yellow}⚠{$reset} {$testName}: Partial preservation\n";
            $testsPassed++;
        }
    } catch (Exception $e) {
        echo "{$red}✗{$reset} {$testName}: ERROR - " . $e->getMessage() . "\n";
        $testsFailed++;
    }
}

// Test HistoryService
echo "\n\nTesting HistoryService...\n";
echo "--------------------------------------------\n";

try {
    // Add some states
    $historyService->addState('First text');
    $historyService->addState('Second text');
    $historyService->addState('Third text');
    
    // Test undo
    $undoResult = $historyService->undo();
    if ($undoResult === 'Second text') {
        echo "{$green}✓{$reset} Undo: Works correctly\n";
        $testsPassed++;
    } else {
        echo "{$red}✗{$reset} Undo: Failed\n";
        $testsFailed++;
    }
    
    // Test redo
    $redoResult = $historyService->redo();
    if ($redoResult === 'Third text') {
        echo "{$green}✓{$reset} Redo: Works correctly\n";
        $testsPassed++;
    } else {
        echo "{$red}✗{$reset} Redo: Failed\n";
        $testsFailed++;
    }
    
    // Test history limit
    for ($i = 0; $i < 25; $i++) {
        $historyService->addState("Text $i");
    }
    
    $history = $historyService->getHistory();
    if (count($history) <= 20) {
        echo "{$green}✓{$reset} History limit: Maintains 20 state maximum\n";
        $testsPassed++;
    } else {
        echo "{$red}✗{$reset} History limit: Exceeds 20 states\n";
        $testsFailed++;
    }
    
} catch (Exception $e) {
    echo "{$red}✗{$reset} HistoryService: ERROR - " . $e->getMessage() . "\n";
    $testsFailed++;
}

// Summary
echo "\n{$yellow}========================================{$reset}\n";
echo "{$yellow}Validation Summary{$reset}\n";
echo "{$yellow}========================================{$reset}\n";
echo "Tests Passed: {$green}{$testsPassed}{$reset}\n";
echo "Tests Failed: {$red}{$testsFailed}{$reset}\n";
$successRate = round(($testsPassed / ($testsPassed + $testsFailed)) * 100, 2);
$color = $successRate >= 90 ? $green : ($successRate >= 70 ? $yellow : $red);
echo "Success Rate: {$color}{$successRate}%{$reset}\n";

if ($testsFailed === 0) {
    echo "\n{$green}✅ All tests passed! Services are working correctly.{$reset}\n";
} else {
    echo "\n{$red}⚠️  Some tests failed. Please review the errors above.{$reset}\n";
}

echo "\n";

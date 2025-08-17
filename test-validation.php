<?php
/**
 * Case Changer Validation Test Suite
 * Purpose: Validate all transformations work correctly
 * Date: 2025-08-16
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Livewire\CaseChanger;

// Create instance for testing
$changer = new CaseChanger();

// Test data
$testCases = [
    'basic' => 'hello world',
    'prepositions' => 'the cat in the hat on the mat',
    'quotes' => "She said 'hello' and he said \"goodbye\"",
    'mixed' => 'The QUICK brown FOX jumps OVER the lazy DOG',
    'punctuation' => 'Hello, world! How are you? I am fine.',
    'numbers' => 'test123 ABC456 789xyz',
    'unicode' => 'Café résumé naïve façade',
    'empty' => '',
    'spaces' => 'too    many     spaces    here',
    'underscores' => 'convert_these_underscores_to_spaces'
];

// Colors for output
$red = "\033[0;31m";
$green = "\033[0;32m";
$yellow = "\033[1;33m";
$reset = "\033[0m";

echo "{$yellow}=== Case Changer Validation Test Suite ==={$reset}\n\n";

// Test each transformation
$results = [];
$passed = 0;
$failed = 0;

// Function to test a transformation
function testTransformation($changer, $method, $input, $expectedContains = null) {
    global $green, $red, $reset;
    
    try {
        $changer->inputText = $input;
        $changer->$method();
        $output = $changer->outputText;
        
        if ($expectedContains !== null && strpos($output, $expectedContains) === false) {
            echo "{$red}✗{$reset} {$method}: Expected to contain '{$expectedContains}', got '{$output}'\n";
            return false;
        }
        
        echo "{$green}✓{$reset} {$method}: '{$input}' → '{$output}'\n";
        return true;
    } catch (Exception $e) {
        echo "{$red}✗{$reset} {$method}: ERROR - " . $e->getMessage() . "\n";
        return false;
    }
}

// Test basic transformations
echo "{$yellow}Testing Basic Transformations:{$reset}\n";
$basicTests = [
    ['transformToTitleCase', 'hello world', 'Hello World'],
    ['transformToUpperCase', 'hello world', 'HELLO WORLD'],
    ['transformToLowerCase', 'HELLO WORLD', 'hello world'],
    ['transformToSentenceCase', 'hello world. how are you?', 'Hello world.'],
    ['transformToFirstLetter', 'hello world', 'Hello world'],
    ['transformToAlternatingCase', 'hello world', null], // Can't predict exact output
    ['transformToRandomCase', 'hello world', null], // Random output
];

foreach ($basicTests as $test) {
    if (testTransformation($changer, $test[0], $test[1], $test[2])) {
        $passed++;
    } else {
        $failed++;
    }
}

// Test style guides
echo "\n{$yellow}Testing Style Guide Formatters:{$reset}\n";
$styleGuides = [
    'applyApaStyle',
    'applyChicagoStyle',
    'applyApStyle',
    'applyMlaStyle',
    'applyBluebookStyle',
    'applyAmaStyle',
    'applyNyTimesStyle',
    'applyWikipediaStyle'
];

$styleInput = 'the effects of social media on academic performance';
foreach ($styleGuides as $method) {
    if (testTransformation($changer, $method, $styleInput)) {
        $passed++;
    } else {
        $failed++;
    }
}

// Test advanced features
echo "\n{$yellow}Testing Advanced Features:{$reset}\n";
$advancedTests = [
    ['fixPrepositions', 'the cat in the hat', null],
    ['addSpaces', 'hello,world!test', 'hello,'],
    ['removeSpaces', 'hello , world !', 'hello,'],
    ['spacesToUnderscores', 'hello world test', 'hello_world_test'],
    ['underscoresToSpaces', 'hello_world_test', 'hello world test'],
    ['removeExtraSpaces', 'hello   world    test', 'hello world test'],
    ['convertToSmartQuotes', "She said 'hello'", null] // Check for curly quotes
];

foreach ($advancedTests as $test) {
    if (testTransformation($changer, $test[0], $test[1], $test[2])) {
        $passed++;
    } else {
        $failed++;
    }
}

// Test developer features
echo "\n{$yellow}Testing Developer Features:{$reset}\n";
$developerTests = [
    ['transformToCamelCase', 'hello world test', 'helloWorldTest'],
    ['transformToSnakeCase', 'HelloWorldTest', 'hello_world_test'],
    ['transformToKebabCase', 'HelloWorldTest', 'hello-world-test'],
    ['transformToPascalCase', 'hello world test', 'HelloWorldTest'],
    ['transformToConstantCase', 'helloWorldTest', 'HELLO_WORLD_TEST']
];

foreach ($developerTests as $test) {
    if (testTransformation($changer, $test[0], $test[1], $test[2])) {
        $passed++;
    } else {
        $failed++;
    }
}

// Test edge cases
echo "\n{$yellow}Testing Edge Cases:{$reset}\n";

// Empty input
$changer->inputText = '';
$changer->transformToTitleCase();
if ($changer->outputText === '') {
    echo "{$green}✓{$reset} Empty input handled correctly\n";
    $passed++;
} else {
    echo "{$red}✗{$reset} Empty input not handled correctly\n";
    $failed++;
}

// Very long input
$longText = str_repeat('This is a test sentence. ', 1000);
$changer->inputText = $longText;
try {
    $changer->transformToUpperCase();
    if (strlen($changer->outputText) > 0) {
        echo "{$green}✓{$reset} Long input handled correctly\n";
        $passed++;
    }
} catch (Exception $e) {
    echo "{$red}✗{$reset} Long input caused error: " . $e->getMessage() . "\n";
    $failed++;
}

// Unicode characters
$changer->inputText = 'Café résumé naïve';
$changer->transformToUpperCase();
if (strpos($changer->outputText, 'CAF') !== false) {
    echo "{$green}✓{$reset} Unicode characters handled\n";
    $passed++;
} else {
    echo "{$red}✗{$reset} Unicode characters not handled correctly\n";
    $failed++;
}

// Summary
echo "\n{$yellow}=== Test Summary ==={$reset}\n";
echo "Passed: {$green}{$passed}{$reset}\n";
echo "Failed: {$red}{$failed}{$reset}\n";
$percentage = $passed > 0 ? round(($passed / ($passed + $failed)) * 100, 2) : 0;
echo "Success Rate: " . ($percentage >= 70 ? $green : $red) . "{$percentage}%{$reset}\n";

if ($failed > 0) {
    echo "\n{$red}⚠ VALIDATION FAILED - {$failed} tests did not pass{$reset}\n";
    echo "Cannot mark task as complete until all tests pass.\n";
    exit(1);
} else {
    echo "\n{$green}✓ All tests passed!{$reset}\n";
    exit(0);
}
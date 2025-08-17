<?php

// Case Changer Validation Test Script
// This validates all functionality programmatically

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Livewire/CaseChanger.php';

use App\Livewire\CaseChanger;

echo "=== CASE CHANGER VALIDATION PROTOCOL ===\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n";
echo "Technology: Laravel TALL Stack\n\n";

$results = [
    'passed' => 0,
    'failed' => 0,
    'errors' => []
];

// Create instance of CaseChanger component
$component = new CaseChanger();

// Test helper function
function testTransformation($component, $method, $input, $expected, $description) {
    global $results;
    
    echo "Testing: $description\n";
    echo "  Input: \"$input\"\n";
    
    try {
        // Set the input text
        $component->inputText = $input;
        
        // Call the transformation method
        $component->$method();
        
        // Get the output
        $output = $component->outputText;
        echo "  Output: \"$output\"\n";
        
        // Check if output matches expected
        if ($output === $expected || ($expected === 'PATTERN' && !empty($output))) {
            echo "  ✅ PASSED\n\n";
            $results['passed']++;
            return true;
        } else {
            echo "  ❌ FAILED: Expected \"$expected\", got \"$output\"\n\n";
            $results['failed']++;
            return false;
        }
    } catch (Exception $e) {
        echo "  ❌ ERROR: " . $e->getMessage() . "\n\n";
        $results['failed']++;
        $results['errors'][] = $e->getMessage();
        return false;
    }
}

echo "=== BASIC TRANSFORMATIONS ===\n\n";

// Test basic transformations
$basicInput = "the QUICK brown FOX jumps OVER the lazy DOG";

testTransformation($component, 'transformToTitleCase', $basicInput, 
    "The Quick Brown Fox Jumps Over The Lazy Dog", "Title Case");

testTransformation($component, 'transformToSentenceCase', $basicInput, 
    "The quick brown fox jumps over the lazy dog", "Sentence Case");

testTransformation($component, 'transformToUpperCase', $basicInput, 
    "THE QUICK BROWN FOX JUMPS OVER THE LAZY DOG", "UPPERCASE");

testTransformation($component, 'transformToLowerCase', $basicInput, 
    "the quick brown fox jumps over the lazy dog", "lowercase");

testTransformation($component, 'transformToFirstLetter', $basicInput, 
    "The quick brown fox jumps over the lazy dog", "First Letter");

testTransformation($component, 'transformToAlternatingCase', "hello world", 
    "hElLo WoRlD", "Alternating Case");

// Randomized case - just check it produces output
$component->inputText = $basicInput;
$component->transformToRandomCase();
if (!empty($component->outputText)) {
    echo "Testing: Randomized Case\n";
    echo "  Input: \"$basicInput\"\n";
    echo "  Output: \"{$component->outputText}\"\n";
    echo "  ✅ PASSED (produces randomized output)\n\n";
    $results['passed']++;
} else {
    echo "  ❌ FAILED: Randomized Case produced no output\n\n";
    $results['failed']++;
}

echo "=== STYLE GUIDE FORMATTERS ===\n\n";

// Test style guides
$styleInput = "the art of war by sun tzu";

testTransformation($component, 'applyApaStyle', $styleInput, 
    "The Art of War by Sun Tzu", "APA Style");

testTransformation($component, 'applyChicagoStyle', $styleInput, 
    "The Art of War by Sun Tzu", "Chicago Style");

testTransformation($component, 'applyApStyle', $styleInput, 
    "The Art of War by Sun Tzu", "AP Style");

testTransformation($component, 'applyMlaStyle', $styleInput, 
    "The Art of War by Sun Tzu", "MLA Style");

testTransformation($component, 'applyBluebookStyle', $styleInput, 
    "THE ART OF WAR BY SUN TZU", "Bluebook Style");

testTransformation($component, 'applyAmaStyle', $styleInput, 
    "The Art Of War By Sun Tzu", "AMA Style");

testTransformation($component, 'applyNyTimesStyle', $styleInput, 
    "The Art of War by Sun Tzu", "NY Times Style");

testTransformation($component, 'applyWikipediaStyle', $styleInput, 
    "The art of war by sun tzu", "Wikipedia Style");

echo "=== ADVANCED FEATURES ===\n\n";

// Test preposition fixer
testTransformation($component, 'fixPrepositions', "the cat is ON the mat IN the house", 
    "The Cat Is on the Mat in the House", "Fix Prepositions");

// Test space/underscore operations
testTransformation($component, 'underscoresToSpaces', "hello_world_test", 
    "hello world test", "Add Spaces");

testTransformation($component, 'removeSpaces', "hello world test", 
    "helloworldtest", "Remove Spaces");

testTransformation($component, 'spacesToUnderscores', "hello world test", 
    "hello_world_test", "Add Underscores");

testTransformation($component, 'underscoresToSpaces', "hello_world_test", 
    "hello world test", "Remove Underscores");

// Test smart quotes
$quotesInput = 'She said "hello" and \'goodbye\'';
$component->inputText = $quotesInput;
$component->convertToSmartQuotes();
$quotesOutput = $component->outputText;

echo "Testing: Smart Quotes\n";
echo "  Input: \"$quotesInput\"\n";
echo "  Output: \"$quotesOutput\"\n";

// Check if output contains smart quotes (using Unicode characters)
if (strpos($quotesOutput, "\u{201C}") !== false || strpos($quotesOutput, "\u{2018}") !== false) {
    echo "  ✅ PASSED (contains smart quotes)\n\n";
    $results['passed']++;
} else {
    echo "  ❌ FAILED: Smart quotes not detected\n\n";
    $results['failed']++;
}

// Test empty input handling
echo "=== ERROR HANDLING ===\n\n";

$component->inputText = "";
$component->transformToTitleCase();
if ($component->outputText === "") {
    echo "Testing: Empty Input Handling\n";
    echo "  ✅ PASSED (handles empty input gracefully)\n\n";
    $results['passed']++;
} else {
    echo "  ❌ FAILED: Unexpected output for empty input\n\n";
    $results['failed']++;
}

// Test with special characters
$specialInput = "hello@world#test$123%abc";
$component->inputText = $specialInput;
$component->transformToUpperCase();
if ($component->outputText === "HELLO@WORLD#TEST$123%ABC") {
    echo "Testing: Special Characters\n";
    echo "  ✅ PASSED (preserves special characters)\n\n";
    $results['passed']++;
} else {
    echo "  ❌ FAILED: Special characters not handled correctly\n\n";
    $results['failed']++;
}

// Final Report
echo "=== VALIDATION SUMMARY ===\n";
echo "Tests Passed: {$results['passed']}\n";
echo "Tests Failed: {$results['failed']}\n";
echo "Errors Encountered: " . count($results['errors']) . "\n\n";

if ($results['failed'] === 0 && count($results['errors']) === 0) {
    echo "✅ ALL VALIDATIONS PASSED!\n";
    echo "🎉 Case Changer is fully functional and validated!\n";
    exit(0);
} else {
    echo "❌ VALIDATION FAILED - Issues detected\n";
    if (count($results['errors']) > 0) {
        echo "\nErrors:\n";
        foreach ($results['errors'] as $error) {
            echo "  - $error\n";
        }
    }
    exit(1);
}

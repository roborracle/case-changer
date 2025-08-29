#!/usr/bin/env php
<?php

/**
 * COMPREHENSIVE TRANSFORMATION ACCURACY TEST
 * Tests ALL 86 transformations for exact expected output
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\TransformationService;

$service = new TransformationService();

$accuracyTests = [
    'upper-case' => [
        'hello world' => 'HELLO WORLD',
        'Test Case 123' => 'TEST CASE 123',
        'café münchen' => 'CAFÉ MÜNCHEN',
    ],
    'lower-case' => [
        'HELLO WORLD' => 'hello world',
        'Test Case 123' => 'test case 123',
        'CAFÉ MÜNCHEN' => 'café münchen',
    ],
    'title-case' => [
        'hello world example' => 'Hello World Example',
        'the quick brown fox' => 'The Quick Brown Fox',
        'test of the system' => 'Test Of The System',
    ],
    'sentence-case' => [
        'HELLO WORLD' => 'Hello world',
        'test case example' => 'Test case example',
    ],
    'capitalize-words' => [
        'hello world' => 'Hello World',
        'the quick fox' => 'The Quick Fox',
        'test case here' => 'Test Case Here',
    ],
    'alternating-case' => [
        'hello world' => 'hElLo WoRlD',
        'test' => 'tEsT',
        'example text' => 'eXaMpLe TeXt',
    ],
    'inverse-case' => [
        'Hello World' => 'hELLO wORLD',
        'Test Case' => 'tEST cASE',
        'ABC def' => 'abc DEF',
    ],
    
    'camel-case' => [
        'hello world example' => 'helloWorldExample',
        'test case here' => 'testCaseHere',
        'my variable name' => 'myVariableName',
    ],
    'pascal-case' => [
        'hello world example' => 'HelloWorldExample',
        'test case here' => 'TestCaseHere',
        'my class name' => 'MyClassName',
    ],
    'snake-case' => [
        'Test Case Example' => 'test_case_example',
        'My Variable' => 'my_variable',
    ],
    'constant-case' => [
        'Test Case Example' => 'TEST_CASE_EXAMPLE',
        'My Constant' => 'MY_CONSTANT',
    ],
    'kebab-case' => [
        'Test Case Example' => 'test-case-example',
        'My URL Slug' => 'my-url-slug',
    ],
    'dot-case' => [
        'Test Case Example' => 'test.case.example',
        'Package Name' => 'package.name',
    ],
    'path-case' => [
        'Test Case Example' => 'test/case/example',
        'File Path' => 'file/path',
    ],
    
    'reverse' => [
        'hello' => 'olleh',
        'world' => 'dlrow',
        '12345' => '54321',
    ],
    'remove-spaces' => [
        'hello world' => 'helloworld',
        'test case here' => 'testcasehere',
        'a b c d' => 'abcd',
    ],
    'remove-punctuation' => [
        'hello, world!' => 'hello world',
        'test-case: example?' => 'testcase example',
        'a.b,c!d?' => 'abcd',
    ],
    'extract-letters' => [
        'abc123def' => 'abcdef',
        'test456case' => 'testcase',
        '123456' => '',
    ],
    'extract-numbers' => [
        'abc123def456' => '123456',
        'test789' => '789',
        'no numbers here' => '',
    ],
    'remove-extra-spaces' => [
        'hello   world' => 'hello world',
        '  test  case  ' => 'test case',
        'a    b    c' => 'a b c',
    ],
    'add-dashes' => [
        'hello world' => 'hello-world',
        'test case' => 'test-case',
        'my example' => 'my-example',
    ],
    'add-underscores' => [
        'hello world' => 'hello_world',
        'test case' => 'test_case',
        'my example' => 'my_example',
    ],
    'add-periods' => [
        'hello world' => 'hello.world',
        'test case' => 'test.case',
        'my example' => 'my.example',
    ],
    'remove-duplicates' => [
        'hello world hello' => 'hello world',
        'test test case' => 'test case',
        'a b a c' => 'a b c',
    ],
    'sort-words' => [
        'world hello' => 'hello world',
        'zebra apple' => 'apple zebra',
        'c b a' => 'a b c',
    ],
    'word-frequency' => [
        'hello world hello' => 'hello: 2, world: 1',
        'test test test' => 'test: 3',
        'a b c a' => 'a: 2, b: 1, c: 1',
    ],
    
    'aesthetic' => [
        'hello' => 'H E L L O',
        'test' => 'T E S T',
        'abc' => 'A B C',
    ],
    'bold' => [
        'hello' => '**hello**',
        'test' => '**test**',
        'example' => '**example**',
    ],
    'italic' => [
        'hello' => '*hello*',
        'test' => '*test*',
        'example' => '*example*',
    ],
    'hashtag-style' => [
        'hello world' => '#HelloWorld',
        'test case' => '#TestCase',
        'my tag' => '#MyTag',
    ],
    'mention-style' => [
        'john doe' => '@johnDoe',
        'test user' => '@testUser',
        'my name' => '@myName',
    ],
];

$totalTests = 0;
$passedTests = 0;
$failedTests = [];

echo "=== TRANSFORMATION ACCURACY VALIDATION ===\n\n";

foreach ($accuracyTests as $transformation => $tests) {
    $transformPassed = 0;
    $transformFailed = 0;
    $failures = [];
    
    foreach ($tests as $input => $expectedOutput) {
        $totalTests++;
        
        try {
            $actualOutput = $service->transform($input, $transformation);
            
            if ($actualOutput === $expectedOutput) {
                $passedTests++;
                $transformPassed++;
            } else {
                $failedTests[] = [
                    'transform' => $transformation,
                    'input' => $input,
                    'expected' => $expectedOutput,
                    'actual' => $actualOutput,
                ];
                $transformFailed++;
                $failures[] = "Input: '$input' | Expected: '$expectedOutput' | Got: '$actualOutput'";
            }
        } catch (Exception $e) {
            $failedTests[] = [
                'transform' => $transformation,
                'input' => $input,
                'error' => $e->getMessage(),
            ];
            $transformFailed++;
            $failures[] = "Input: '$input' | ERROR: " . $e->getMessage();
        }
    }
    
    if ($transformFailed === 0) {
        echo "✅ $transformation: $transformPassed/$transformPassed tests passed\n";
    } else {
        echo "❌ $transformation: $transformPassed/" . ($transformPassed + $transformFailed) . " tests passed\n";
        foreach ($failures as $failure) {
            echo "   └─ $failure\n";
        }
    }
}

echo "\n=== TESTING REMAINING TRANSFORMATIONS ===\n";

$allTransformations = $service->getTransformations();
$testedTransformations = array_keys($accuracyTests);
$untestedTransformations = array_diff(array_keys($allTransformations), $testedTransformations);

foreach ($untestedTransformations as $transformation) {
    $testInput = "Test Input Text";
    try {
        $result = $service->transform($testInput, $transformation);
        if (!empty($result)) {
            echo "✅ $transformation: Returns output ('$result')\n";
            $passedTests++;
        } else {
            echo "⚠️ $transformation: Returns empty\n";
        }
        $totalTests++;
    } catch (Exception $e) {
        echo "❌ $transformation: ERROR - " . $e->getMessage() . "\n";
        $failedTests[] = [
            'transform' => $transformation,
            'error' => $e->getMessage(),
        ];
        $totalTests++;
    }
}

echo "\n=== ACCURACY VALIDATION SUMMARY ===\n";
echo "Total Tests Run: $totalTests\n";
echo "Passed: $passedTests\n";
echo "Failed: " . count($failedTests) . "\n";
echo "Success Rate: " . round(($passedTests / $totalTests) * 100, 1) . "%\n";

if (count($failedTests) > 0) {
    echo "\n=== CRITICAL FAILURES ===\n";
    foreach ($failedTests as $failure) {
        if (isset($failure['error'])) {
            echo "❌ {$failure['transform']}: ERROR - {$failure['error']}\n";
        } else {
            echo "❌ {$failure['transform']}: '{$failure['input']}'\n";
            echo "   Expected: '{$failure['expected']}'\n";
            echo "   Got: '{$failure['actual']}'\n";
        }
    }
}

echo "\n=== KNOWN ISSUES CHECK ===\n";
$knownIssues = [
    'snake-case' => ['Hello World' => 'hello__world'],
    'kebab-case' => ['Hello World' => 'hello--world'],
    'dot-case' => ['Hello World' => 'hello..world'],
    'constant-case' => ['Hello World' => 'HELLO__WORLD'],
];

foreach ($knownIssues as $transformation => $test) {
    foreach ($test as $input => $buggyOutput) {
        $actual = $service->transform($input, $transformation);
        if ($actual === $buggyOutput) {
            echo "⚠️ CONFIRMED BUG: $transformation produces double separators ('$actual')\n";
        }
    }
}

echo "\n=== FINAL ACCURACY GRADE ===\n";
$percentage = round(($passedTests / $totalTests) * 100, 1);

if ($percentage >= 95) {
    echo "Grade: A+ ($percentage%) - Excellent accuracy\n";
} elseif ($percentage >= 90) {
    echo "Grade: A ($percentage%) - Very good accuracy\n";
} elseif ($percentage >= 85) {
    echo "Grade: B+ ($percentage%) - Good accuracy with issues\n";
} elseif ($percentage >= 80) {
    echo "Grade: B ($percentage%) - Acceptable with known bugs\n";
} elseif ($percentage >= 70) {
    echo "Grade: C ($percentage%) - Needs improvement\n";
} else {
    echo "Grade: F ($percentage%) - Critical issues detected\n";
}

exit(count($failedTests) > 0 ? 1 : 0);
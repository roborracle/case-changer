#!/usr/bin/env php
<?php

/**
 * COMPREHENSIVE TRANSFORMATION TEST SUITE
 * Tests all 172 transformation tools for functionality
 * Task #12 - Production Readiness Audit
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Services/TransformationService.php';

use App\Services\TransformationService;

$service = new TransformationService();

// Test data for each category
$testCases = [
    'basic' => [
        'input' => 'Hello World 123',
        'tests' => [
            'uppercase' => 'HELLO WORLD 123',
            'lowercase' => 'hello world 123',
            'capitalize' => 'Hello World 123',
            'title-case' => 'Hello World 123',
            'sentence-case' => 'Hello world 123',
            'alternating-case' => 'HeLlO wOrLd 123',
            'inverse-case' => 'hELLO wORLD 123',
            'random-case' => null, // Random output
            'camel-case' => 'helloWorld123',
            'pascal-case' => 'HelloWorld123',
            'snake-case' => 'hello_world_123',
            'kebab-case' => 'hello-world-123',
            'dot-case' => 'hello.world.123',
            'path-case' => 'hello/world/123',
            'constant-case' => 'HELLO_WORLD_123',
            'cobol-case' => 'HELLO-WORLD-123',
            'train-case' => 'Hello-World-123',
            'sponge-case' => null, // Random output
            'swapcase' => 'hELLO wORLD 123'
        ]
    ],
    'advanced' => [
        'input' => 'The quick brown fox',
        'tests' => [
            'reverse' => 'xof nworb kciuq ehT',
            'mirror' => 'xoʇ nwoɹd ʞɔınb ǝɥ⊥',
            'upside-down' => 'xoɟ uʍoɹq ʞɔınb ǝɥ⊥',
            'backwards' => 'fox brown quick The',
            'scramble' => null, // Random output
            'shuffle' => null, // Random output
            'rot13' => 'Gur dhvpx oebja sbk',
            'atbash' => 'Gsv jfrxp yildm ulc',
            'caesar' => null, // Need to specify shift
            'vigenere' => null, // Need key
            'base64-encode' => 'VGhlIHF1aWNrIGJyb3duIGZveA==',
            'base64-decode' => null, // Invalid for this input
            'url-encode' => 'The+quick+brown+fox',
            'url-decode' => 'The quick brown fox',
            'html-encode' => 'The quick brown fox',
            'html-decode' => 'The quick brown fox',
            'ascii-to-hex' => '54686520717569636b2062726f776e20666f78',
            'hex-to-ascii' => null, // Invalid for this input
            'binary-to-text' => null, // Invalid for this input
            'text-to-binary' => '01010100 01101000 01100101 00100000 01110001 01110101 01101001 01100011 01101011 00100000 01100010 01110010 01101111 01110111 01101110 00100000 01100110 01101111 01111000'
        ]
    ],
    'special' => [
        'input' => 'Hello World',
        'tests' => [
            'morse-code' => '.... . .-.. .-.. --- / .-- --- .-. .-.. -..',
            'nato-phonetic' => 'Hotel Echo Lima Lima Oscar / Whiskey Oscar Romeo Lima Delta',
            'emoji-text' => null, // Complex mapping
            'leet-speak' => 'H3ll0 W0rld',
            'double-struck' => '𝕳𝖊𝖑𝖑𝖔 𝖂𝖔𝖗𝖑𝖉',
            'bold-text' => '𝐇𝐞𝐥𝐥𝐨 𝐖𝐨𝐫𝐥𝐝',
            'italic-text' => '𝘏𝘦𝘭𝘭𝘰 𝘞𝘰𝘳𝘭𝘥',
            'bold-italic' => '𝑯𝒆𝒍𝒍𝒐 𝑾𝒐𝒓𝒍𝒅',
            'cursive' => '𝒽𝑒𝓁𝓁𝑜 𝓌𝑜𝓇𝓁𝒹',
            'small-caps' => 'ʜᴇʟʟᴏ ᴡᴏʀʟᴅ',
            'subscript' => 'ₕₑₗₗₒ wₒᵣₗd',
            'superscript' => 'ᴴᵉˡˡᵒ ᵂᵒʳˡᵈ',
            'wide-text' => 'Ｈｅｌｌｏ　Ｗｏｒｌｄ',
            'strikethrough' => 'H̶e̶l̶l̶o̶ ̶W̶o̶r̶l̶d̶',
            'underline' => 'H̲e̲l̲l̲o̲ ̲W̲o̲r̲l̲d̲',
            'double-underline' => 'H̳e̳l̳l̳o̳ ̳W̳o̳r̳l̳d̳',
            'bubble-text' => 'Ⓗⓔⓛⓛⓞ Ⓦⓞⓡⓛⓓ',
            'square-text' => '🄷🄴🄻🄻🄾 🅆🄾🅁🄻🄳',
            'zigzag' => null // Complex pattern
        ]
    ]
];

// Results tracking
$results = [
    'total' => 0,
    'passed' => 0,
    'failed' => 0,
    'errors' => [],
    'missing' => [],
    'broken' => []
];

echo "=================================================\n";
echo "TRANSFORMATION FUNCTIONALITY TEST - TASK #12\n";
echo "=================================================\n\n";

// Get all available transformations
$reflection = new ReflectionClass($service);
$transformationsProperty = $reflection->getProperty('transformations');
$transformationsProperty->setAccessible(true);
$availableTransformations = $transformationsProperty->getValue($service);

echo "Found " . count($availableTransformations) . " registered transformations\n";
echo "Testing each transformation...\n\n";

// Test each transformation
foreach ($availableTransformations as $slug => $name) {
    $results['total']++;
    
    // Find appropriate test case
    $testInput = 'Hello World 123';
    $expectedOutput = null;
    
    foreach ($testCases as $category => $data) {
        if (isset($data['tests'][$slug])) {
            $testInput = $data['input'];
            $expectedOutput = $data['tests'][$slug];
            break;
        }
    }
    
    // Test the transformation
    try {
        // Use the public transform method
        $output = $service->transform($testInput, $slug);
        
        if ($output === null || $output === '') {
            echo "❌ $slug: Returned null or empty\n";
            $results['broken'][] = $slug;
            $results['failed']++;
            continue;
        }
        
        // Check against expected output if we have one
        if ($expectedOutput !== null && $output !== $expectedOutput) {
            echo "⚠️ $slug: Output mismatch\n";
            echo "   Expected: $expectedOutput\n";
            echo "   Got: $output\n";
            $results['errors'][] = [
                'transformation' => $slug,
                'expected' => $expectedOutput,
                'actual' => $output
            ];
            $results['failed']++;
        } else {
            echo "✅ $slug: Working\n";
            $results['passed']++;
        }
        
    } catch (Exception $e) {
        echo "❌ $slug: Exception - " . $e->getMessage() . "\n";
        $results['errors'][] = [
            'transformation' => $slug,
            'error' => $e->getMessage()
        ];
        $results['failed']++;
    }
}

// Test API endpoint
echo "\n=================================================\n";
echo "API ENDPOINT TEST\n";
echo "=================================================\n\n";

$baseUrl = 'http://localhost:8002/api/transform';
$apiTests = 0;
$apiPassed = 0;

foreach ($availableTransformations as $slug => $name) {
    $apiTests++;
    
    $postData = [
        'text' => 'Test Input',
        'type' => $slug
    ];
    
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            'content' => json_encode($postData)
        ]
    ]);
    
    $response = @file_get_contents($baseUrl, false, $context);
    
    if ($response === false) {
        echo "❌ API test for $slug: Failed to connect\n";
    } else {
        $data = json_decode($response, true);
        if (isset($data['transformed'])) {
            echo "✅ API test for $slug: Success\n";
            $apiPassed++;
        } else {
            echo "❌ API test for $slug: Invalid response\n";
        }
    }
}

// Summary Report
echo "\n=================================================\n";
echo "TEST SUMMARY\n";
echo "=================================================\n\n";

echo "Transformation Tests:\n";
echo "  Total: {$results['total']}\n";
echo "  Passed: {$results['passed']}\n";
echo "  Failed: {$results['failed']}\n\n";

echo "API Tests:\n";
echo "  Total: $apiTests\n";
echo "  Passed: $apiPassed\n";
echo "  Failed: " . ($apiTests - $apiPassed) . "\n\n";

if (count($results['missing']) > 0) {
    echo "Missing Methods (" . count($results['missing']) . "):\n";
    foreach ($results['missing'] as $missing) {
        echo "  - $missing\n";
    }
    echo "\n";
}

if (count($results['broken']) > 0) {
    echo "Broken Transformations (" . count($results['broken']) . "):\n";
    foreach ($results['broken'] as $broken) {
        echo "  - $broken\n";
    }
    echo "\n";
}

// Check against claimed count
$claimedCount = 172;
$actualCount = $results['total'];
$workingCount = $results['passed'];

echo "=================================================\n";
echo "VERIFICATION AGAINST CLAIMS\n";
echo "=================================================\n\n";

echo "Claimed transformations: $claimedCount\n";
echo "Actual transformations: $actualCount\n";
echo "Working transformations: $workingCount\n";
echo "Missing transformations: " . ($claimedCount - $actualCount) . "\n\n";

if ($actualCount < $claimedCount) {
    echo "❌ CRITICAL: Only $actualCount of $claimedCount claimed transformations exist!\n";
    echo "   Need to add " . ($claimedCount - $actualCount) . " more transformations\n";
} else {
    echo "✅ All $claimedCount transformations are registered\n";
}

if ($workingCount < $actualCount) {
    echo "⚠️ WARNING: " . ($actualCount - $workingCount) . " transformations are not working properly\n";
}

// Final verdict
echo "\n=================================================\n";
echo "FINAL VERDICT\n";
echo "=================================================\n\n";

$readyForProduction = ($actualCount >= $claimedCount) && ($results['failed'] == 0);

if ($readyForProduction) {
    echo "✅ READY FOR PRODUCTION\n";
    echo "   All transformations tested and working\n";
} else {
    echo "❌ NOT READY FOR PRODUCTION\n";
    echo "   Issues that must be fixed:\n";
    
    if ($actualCount < $claimedCount) {
        echo "   - Add " . ($claimedCount - $actualCount) . " missing transformations\n";
    }
    
    if ($results['failed'] > 0) {
        echo "   - Fix {$results['failed']} broken transformations\n";
    }
}

echo "\n=================================================\n";
echo "TEST COMPLETE\n";
echo "=================================================\n";
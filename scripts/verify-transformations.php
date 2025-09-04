#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\TransformationService;

$service = new TransformationService();

// Get all transformations
$reflection = new ReflectionClass($service);
$property = $reflection->getProperty('transformations');
$property->setAccessible(true);
$allTransformations = $property->getValue($service);

$testText = "Hello World 123";
$passed = 0;
$failed = 0;
$errors = [];

echo "\n";
echo "================================\n";
echo "  TRANSFORMATION VERIFICATION   \n";
echo "================================\n";
echo "\n";
echo "Testing " . count($allTransformations) . " transformations...\n";
echo "\n";

$categories = [
    'Case Conversions' => ['upper-case', 'lower-case', 'title-case', 'sentence-case', 'capitalize-words', 'alternating-case', 'inverse-case'],
    'Developer Formats' => ['camel-case', 'pascal-case', 'snake-case', 'constant-case', 'kebab-case', 'dot-case', 'path-case'],
    'Creative Formats' => ['reverse', 'aesthetic', 'sarcasm', 'smallcaps', 'bubble', 'square', 'emoji-case'],
    'Utility' => ['remove-spaces', 'remove-extra-spaces', 'add-dashes', 'add-underscores', 'remove-punctuation']
];

foreach ($categories as $categoryName => $transformations) {
    echo "📁 $categoryName:\n";
    
    foreach ($transformations as $transformation) {
        if (!isset($allTransformations[$transformation])) {
            echo "   ⚠️  $transformation - NOT FOUND\n";
            $failed++;
            continue;
        }
        
        try {
            $result = $service->transform($testText, $transformation);
            if (!empty($result)) {
                echo "   ✅ $transformation - OK\n";
                $passed++;
            } else {
                echo "   ⚠️  $transformation - EMPTY RESULT\n";
                $failed++;
            }
        } catch (Exception $e) {
            echo "   ❌ $transformation - ERROR: " . $e->getMessage() . "\n";
            $errors[] = "$transformation: " . $e->getMessage();
            $failed++;
        }
    }
    echo "\n";
}

// Summary
echo "================================\n";
echo "           SUMMARY              \n";
echo "================================\n";
echo "\n";
echo "Total Transformations: " . count($allTransformations) . "\n";
echo "Tested: " . ($passed + $failed) . "\n";
echo "✅ Passed: $passed\n";
echo "❌ Failed: $failed\n";
echo "\n";

if ($failed > 0) {
    echo "⚠️  Some transformations failed. Please review and fix.\n";
    if (count($errors) > 0) {
        echo "\nErrors:\n";
        foreach ($errors as $error) {
            echo "  - $error\n";
        }
    }
    exit(1);
} else {
    echo "🎉 All tested transformations are working!\n";
    exit(0);
}
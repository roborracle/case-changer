#!/usr/bin/env php
<?php

/**
 * PERFORMANCE TESTING SUITE
 * Tests application performance metrics
 * Task #15 - Performance Audit
 */

$results = [
    'pages' => [],
    'api' => [],
    'assets' => [],
    'memory' => [],
    'summary' => []
];

echo "=================================================\n";
echo "PERFORMANCE TESTING - TASK #15\n";
echo "=================================================\n\n";

echo "1. Testing Homepage Load Time...\n";
$times = [];
for ($i = 0; $i < 5; $i++) {
    $start = microtime(true);
    $response = @file_get_contents($baseUrl);
    $end = microtime(true);
}
$avgTime = array_sum($times) / count($times);
$results['pages']['homepage'] = [
    'avg_time' => round($avgTime, 2),
    'min_time' => round(min($times), 2),
    'max_time' => round(max($times), 2),
    'size' => strlen($response ?? '')
];
echo "   Average: {$results['pages']['homepage']['avg_time']}ms\n";
echo "   Size: " . number_format($results['pages']['homepage']['size']) . " bytes\n\n";

echo "2. Testing Conversions Page Load...\n";
$times = [];
for ($i = 0; $i < 5; $i++) {
    $start = microtime(true);
    $response = @file_get_contents($baseUrl . '/conversions');
    $end = microtime(true);
    $times[] = ($end - $start) * 1000;
    usleep(100000);
}
$avgTime = array_sum($times) / count($times);
$results['pages']['conversions'] = [
    'avg_time' => round($avgTime, 2),
    'min_time' => round(min($times), 2),
    'max_time' => round(max($times), 2),
    'size' => strlen($response ?? '')
];
echo "   Average: {$results['pages']['conversions']['avg_time']}ms\n";
echo "   Size: " . number_format($results['pages']['conversions']['size']) . " bytes\n\n";

echo "3. Testing Tool Page (uppercase)...\n";
$times = [];
for ($i = 0; $i < 5; $i++) {
    $start = microtime(true);
    $response = @file_get_contents($baseUrl . '/conversions/case-formats/uppercase');
    $end = microtime(true);
    $times[] = ($end - $start) * 1000;
    usleep(100000);
}
$avgTime = array_sum($times) / count($times);
$results['pages']['tool'] = [
    'avg_time' => round($avgTime, 2),
    'min_time' => round(min($times), 2),
    'max_time' => round(max($times), 2),
    'size' => strlen($response ?? '')
];
echo "   Average: {$results['pages']['tool']['avg_time']}ms\n";
echo "   Size: " . number_format($results['pages']['tool']['size']) . " bytes\n\n";

echo "4. Testing API Transformation Endpoint...\n";
$transformations = ['uppercase', 'lowercase', 'camel-case', 'snake-case', 'reverse'];
$testText = str_repeat("The quick brown fox jumps over the lazy dog. ", 10);

foreach ($transformations as $type) {
    $times = [];
    for ($i = 0; $i < 10; $i++) {
        $postData = json_encode(['text' => $testText, 'type' => $type]);
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Content-Length: ' . strlen($postData)
                ],
                'content' => $postData
            ]
        ]);
        
        $start = microtime(true);
        $response = @file_get_contents($baseUrl . '/api/transform', false, $context);
        $end = microtime(true);
        
        if ($response !== false) {
            $times[] = ($end - $start) * 1000;
        }
    }
    
    if (count($times) > 0) {
        $results['api'][$type] = [
            'avg_time' => round(array_sum($times) / count($times), 2),
            'min_time' => round(min($times), 2),
            'max_time' => round(max($times), 2),
            'success_rate' => (count($times) / 10) * 100
        ];
        echo "   $type: {$results['api'][$type]['avg_time']}ms (Success: {$results['api'][$type]['success_rate']}%)\n";
    } else {
        $results['api'][$type] = ['error' => 'All requests failed'];
        echo "   $type: FAILED\n";
    }
}

echo "\n5. Checking Asset Sizes...\n";
$assetsDir = __DIR__ . '/public/build/assets';
if (is_dir($assetsDir)) {
    $files = glob($assetsDir . '/*');
    $totalSize = 0;
    $cssSize = 0;
    $jsSize = 0;
    
    foreach ($files as $file) {
        $size = filesize($file);
        $totalSize += $size;
        
        if (strpos($file, '.css') !== false) {
            $cssSize += $size;
        } elseif (strpos($file, '.js') !== false) {
            $jsSize += $size;
        }
    }
    
    $results['assets'] = [
        'total_size' => $totalSize,
        'css_size' => $cssSize,
        'js_size' => $jsSize,
        'file_count' => count($files)
    ];
    
    echo "   Total assets: " . number_format($totalSize / 1024, 2) . " KB\n";
    echo "   CSS: " . number_format($cssSize / 1024, 2) . " KB\n";
    echo "   JS: " . number_format($jsSize / 1024, 2) . " KB\n";
    echo "   Files: {$results['assets']['file_count']}\n";
}

echo "\n6. Testing Memory Usage...\n";
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Services/TransformationService.php';

use App\Services\TransformationService;

$memStart = memory_get_usage(true);
$peakStart = memory_get_peak_usage(true);

$service = new TransformationService();

$largeText = str_repeat("Lorem ipsum dolor sit amet. ", 1000);
for ($i = 0; $i < 10; $i++) {
    $service->transform($largeText, 'uppercase');
    $service->transform($largeText, 'lowercase');
    $service->transform($largeText, 'reverse');
}

$memEnd = memory_get_usage(true);
$peakEnd = memory_get_peak_usage(true);

$results['memory'] = [
    'initial' => $memStart / 1024 / 1024,
    'final' => $memEnd / 1024 / 1024,
    'peak' => $peakEnd / 1024 / 1024,
    'increase' => ($memEnd - $memStart) / 1024 / 1024
];

echo "   Initial: " . round($results['memory']['initial'], 2) . " MB\n";
echo "   Final: " . round($results['memory']['final'], 2) . " MB\n";
echo "   Peak: " . round($results['memory']['peak'], 2) . " MB\n";
echo "   Increase: " . round($results['memory']['increase'], 2) . " MB\n";

echo "\n7. Testing Concurrent Load...\n";
$concurrent = 10;
$urls = [];
for ($i = 0; $i < $concurrent; $i++) {
    $urls[] = $baseUrl;
}

$start = microtime(true);
$mh = curl_multi_init();
$handles = [];

foreach ($urls as $url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_multi_add_handle($mh, $ch);
    $handles[] = $ch;
}

$running = null;
do {
    curl_multi_exec($mh, $running);
    curl_multi_select($mh);
} while ($running > 0);

foreach ($handles as $ch) {
    curl_multi_remove_handle($mh, $ch);
    curl_close($ch);
}
curl_multi_close($mh);

$end = microtime(true);
$concurrentTime = ($end - $start) * 1000;

$results['concurrent'] = [
    'requests' => $concurrent,
    'total_time' => round($concurrentTime, 2),
    'avg_time' => round($concurrentTime / $concurrent, 2)
];

echo "   $concurrent concurrent requests: {$results['concurrent']['total_time']}ms total\n";
echo "   Average per request: {$results['concurrent']['avg_time']}ms\n";

echo "\n=================================================\n";
echo "PERFORMANCE SUMMARY\n";
echo "=================================================\n\n";

$pageLoadScore = 100;
if ($results['pages']['homepage']['avg_time'] > 200) $pageLoadScore -= 20;
if ($results['pages']['homepage']['avg_time'] > 500) $pageLoadScore -= 30;
if ($results['pages']['homepage']['avg_time'] > 1000) $pageLoadScore -= 30;

$apiScore = 100;
foreach ($results['api'] as $type => $metrics) {
    if (isset($metrics['error']) || $metrics['success_rate'] < 100) {
        $apiScore = 0;
        break;
    }
    if ($metrics['avg_time'] > 100) $apiScore -= 10;
    if ($metrics['avg_time'] > 200) $apiScore -= 10;
}

$assetScore = 100;
if (isset($results['assets'])) {
    $totalKB = $results['assets']['total_size'] / 1024;
    if ($totalKB > 500) $assetScore -= 20;
    if ($totalKB > 1000) $assetScore -= 30;
    if ($totalKB > 2000) $assetScore -= 30;
}

$memoryScore = 100;
if ($results['memory']['peak'] > 50) $memoryScore -= 20;
if ($results['memory']['peak'] > 100) $memoryScore -= 30;
if ($results['memory']['increase'] > 10) $memoryScore -= 20;

$overallScore = ($pageLoadScore + $apiScore + $assetScore + $memoryScore) / 4;

echo "Performance Metrics:\n";
echo "  Page Load Score: $pageLoadScore/100\n";
echo "  API Score: $apiScore/100\n";
echo "  Asset Score: $assetScore/100\n";
echo "  Memory Score: $memoryScore/100\n";
echo "  Overall Score: " . round($overallScore) . "/100\n\n";

echo "Recommendations:\n";
if ($pageLoadScore < 80) {
    echo "  ⚠️ Page load times need optimization\n";
}
if ($apiScore < 80) {
    echo "  ⚠️ API endpoints are slow or failing\n";
}
if ($assetScore < 80) {
    echo "  ⚠️ Asset sizes are too large\n";
}
if ($memoryScore < 80) {
    echo "  ⚠️ High memory usage detected\n";
}

if ($overallScore >= 80) {
    echo "  ✅ Performance is generally good\n";
} elseif ($overallScore >= 60) {
    echo "  ⚠️ Performance needs improvement\n";
} else {
    echo "  ❌ Performance is poor\n";
}

echo "\n=================================================\n";
echo "PERFORMANCE TEST COMPLETE\n";
echo "=================================================\n";
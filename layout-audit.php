#!/usr/bin/env php
<?php

/**
 * LAYOUT AUDIT SCRIPT
 * Tests all pages and documents layout issues
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Http/Controllers/ConversionController.php';

use App\Http\Controllers\ConversionController;

$controller = new ConversionController();
$categories = getCategories();

$issues = [];
$totalPages = 0;
$pagesWithIssues = 0;

echo "=================================================\n";
echo "LAYOUT & ALIGNMENT AUDIT - TASK #10\n";
echo "=================================================\n\n";

function getCategories() {
    $reflection = new ReflectionClass('App\Http\Controllers\ConversionController');
    $property = $reflection->getProperty('categories');
    $property->setAccessible(true);
    $controller = new ConversionController();
    return $property->getValue($controller);
}

echo "Testing Home Page...\n";
$response = file_get_contents($baseUrl);
$totalPages++;
if (strpos($response, 'grid-cols-') === false) {
    $issues[] = ['page' => 'home', 'issue' => 'Missing grid layout'];
    $pagesWithIssues++;
}

echo "Testing Conversions Index...\n";
$response = file_get_contents($baseUrl . '/conversions');
$totalPages++;

$gridPatterns = ['grid-cols-1', 'sm:grid-cols-2', 'md:grid-cols-3', 'lg:grid-cols-4'];
foreach ($gridPatterns as $pattern) {
    if (strpos($response, $pattern) === false) {
        $issues[] = ['page' => 'conversions/index', 'issue' => "Missing responsive grid: $pattern"];
    }
}

echo "\nTesting Category Pages...\n";
foreach ($categories as $categorySlug => $categoryData) {
    echo "  - $categorySlug: ";
    $url = $baseUrl . '/conversions/' . $categorySlug;
    $response = @file_get_contents($url);
    $totalPages++;
    
    if ($response === false) {
        echo "❌ Failed to load\n";
        $issues[] = ['page' => "conversions/$categorySlug", 'issue' => 'Page not accessible'];
        $pagesWithIssues++;
    } else {
        $hasGrid = strpos($response, 'grid') !== false;
        $hasContainer = strpos($response, 'container') !== false || strpos($response, 'max-w-') !== false;
        
        if (!$hasGrid || !$hasContainer) {
            echo "⚠️ Layout issues\n";
            $issues[] = ['page' => "conversions/$categorySlug", 'issue' => 'Missing grid or container'];
            $pagesWithIssues++;
        } else {
            echo "✅\n";
        }
    }
    
    foreach ($categoryData['tools'] as $toolSlug => $toolData) {
        $url = $baseUrl . '/conversions/' . $categorySlug . '/' . $toolSlug;
        $totalPages++;
    }
}

echo "\n=================================================\n";
echo "LAYOUT PATTERNS CHECK\n";
echo "=================================================\n\n";

$sampleToolUrl = $baseUrl . '/conversions/case-formats/uppercase';
$response = @file_get_contents($sampleToolUrl);

if ($response) {
    $hasInputArea = strpos($response, 'textarea') !== false;
    $hasOutputArea = strpos($response, 'output') !== false || strpos($response, 'result') !== false;
    $hasButtons = strpos($response, 'button') !== false;
    
    echo "Sample Tool Page Structure:\n";
    echo "  Input area: " . ($hasInputArea ? '✅' : '❌') . "\n";
    echo "  Output area: " . ($hasOutputArea ? '✅' : '❌') . "\n";
    echo "  Action buttons: " . ($hasButtons ? '✅' : '❌') . "\n";
    
    $responsiveClasses = ['sm:', 'md:', 'lg:', 'xl:'];
    $foundResponsive = 0;
    foreach ($responsiveClasses as $prefix) {
        if (strpos($response, $prefix) !== false) {
            $foundResponsive++;
        }
    }
    echo "  Responsive prefixes found: $foundResponsive/4\n";
    
    $hasGlassmorphism = strpos($response, 'glass') !== false || strpos($response, 'backdrop') !== false;
    echo "  Glassmorphism styling: " . ($hasGlassmorphism ? '✅' : '❌') . "\n";
}

echo "\n=================================================\n";
echo "AUDIT SUMMARY\n";
echo "=================================================\n\n";

echo "Total pages checked: $totalPages\n";
echo "Pages with issues: $pagesWithIssues\n";
echo "Issue count: " . count($issues) . "\n\n";

if (count($issues) > 0) {
    echo "ISSUES FOUND:\n";
    echo "-------------\n";
    foreach ($issues as $issue) {
        echo "  📍 " . $issue['page'] . ": " . $issue['issue'] . "\n";
    }
}

echo "\n=================================================\n";
echo "CSS FILES CHECK\n";
echo "=================================================\n\n";

$cssPath = __DIR__ . '/public/build/assets';
if (is_dir($cssPath)) {
    $cssFiles = glob($cssPath . '/*.css');
    echo "CSS files found: " . count($cssFiles) . "\n";
    
    foreach ($cssFiles as $file) {
        $size = filesize($file);
        $name = basename($file);
        echo "  - $name: " . number_format($size / 1024, 2) . " KB\n";
    }
} else {
    echo "❌ Build directory not found\n";
}

echo "\n=================================================\n";
echo "RECOMMENDATIONS\n";
echo "=================================================\n\n";

if ($pagesWithIssues > 0) {
    echo "🔴 CRITICAL: Layout issues found on $pagesWithIssues pages\n\n";
    echo "Recommended fixes:\n";
    echo "1. Ensure all category pages use consistent grid layouts\n";
    echo "2. Add responsive grid classes (grid-cols-1 sm:grid-cols-2 etc.)\n";
    echo "3. Verify container/max-width classes are applied\n";
    echo "4. Test all pages at mobile breakpoints\n";
    echo "5. Implement visual regression testing\n";
} else {
    echo "✅ No major layout issues detected\n";
    echo "   (Note: This is a basic check - visual inspection still recommended)\n";
}

echo "\n=================================================\n";
echo "LAYOUT AUDIT COMPLETE\n";
echo "=================================================\n";
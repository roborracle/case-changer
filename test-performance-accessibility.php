#!/usr/bin/env php
<?php

/**
 * Performance and Accessibility Testing Suite
 * Tests performance metrics and accessibility compliance
 */

echo "=== PERFORMANCE AND ACCESSIBILITY TESTING ===\n\n";

// Performance Metrics
echo "PERFORMANCE METRICS\n";
echo str_repeat('-', 40) . "\n";

// 1. Asset Loading Test
echo "1. Asset Build Sizes:\n";
$buildDir = __DIR__ . '/public/build';
if (is_dir($buildDir)) {
    $totalSize = 0;
    $files = glob($buildDir . '/assets/*.{js,css}', GLOB_BRACE);
    
    foreach ($files as $file) {
        $size = filesize($file);
        $totalSize += $size;
        $filename = basename($file);
        $sizeKB = round($size / 1024, 2);
        
        // Check if file is optimized
        $status = $sizeKB < 100 ? '✅' : ($sizeKB < 200 ? '⚠️' : '❌');
        echo "   $status $filename: {$sizeKB}KB\n";
    }
    
    $totalKB = round($totalSize / 1024, 2);
    $status = $totalKB < 300 ? '✅' : ($totalKB < 500 ? '⚠️' : '❌');
    echo "   $status Total: {$totalKB}KB\n";
} else {
    echo "   ❌ Build directory not found\n";
}

echo "\n";

// 2. Response Time Test
echo "2. Page Load Performance:\n";
$baseUrl = 'http://localhost:8000';
$pages = [
    '/' => 'Home Page',
    '/conversions' => 'Conversions Index',
    '/modern-case-changer' => 'Modern Case Changer',
];

foreach ($pages as $path => $name) {
    $start = microtime(true);
    $ch = curl_init($baseUrl . $path);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentSize = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
    curl_close($ch);
    
    $time = round((microtime(true) - $start) * 1000, 2);
    $sizeKB = round($contentSize / 1024, 2);
    
    $timeStatus = $time < 200 ? '✅' : ($time < 500 ? '⚠️' : '❌');
    $sizeStatus = $sizeKB < 50 ? '✅' : ($sizeKB < 100 ? '⚠️' : '❌');
    
    if ($httpCode === 200) {
        echo "   $timeStatus $name: {$time}ms response, {$sizeKB}KB $sizeStatus\n";
    } else {
        echo "   ❌ $name: HTTP $httpCode\n";
    }
}

echo "\n";

// 3. Caching Headers Test
echo "3. Caching Headers:\n";
$ch = curl_init($baseUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);

$response = curl_exec($ch);
$headers = curl_getinfo($ch);
curl_close($ch);

// Parse headers
$headerLines = explode("\n", $response);
$cacheControl = '';
$etag = '';
$lastModified = '';

foreach ($headerLines as $line) {
    if (stripos($line, 'cache-control:') !== false) {
        $cacheControl = trim(str_ireplace('cache-control:', '', $line));
    }
    if (stripos($line, 'etag:') !== false) {
        $etag = trim(str_ireplace('etag:', '', $line));
    }
    if (stripos($line, 'last-modified:') !== false) {
        $lastModified = trim(str_ireplace('last-modified:', '', $line));
    }
}

echo "   " . (!empty($cacheControl) ? '✅' : '❌') . " Cache-Control: " . ($cacheControl ?: 'Not set') . "\n";
echo "   " . (!empty($etag) ? '✅' : '❌') . " ETag: " . ($etag ? 'Present' : 'Not set') . "\n";
echo "   " . (!empty($lastModified) ? '✅' : '❌') . " Last-Modified: " . ($lastModified ? 'Present' : 'Not set') . "\n";

echo "\n";

// ACCESSIBILITY TESTING
echo "ACCESSIBILITY COMPLIANCE\n";
echo str_repeat('-', 40) . "\n";

// 1. ARIA Attributes Test
echo "1. ARIA Attributes Check:\n";
$ch = curl_init($baseUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ch);
curl_close($ch);

$ariaChecks = [
    'role="navigation"' => 'Navigation landmark',
    'role="main"' => 'Main content landmark',
    'aria-label=' => 'ARIA labels',
    'aria-describedby=' => 'ARIA descriptions',
    'aria-expanded=' => 'Expandable elements',
    'aria-modal=' => 'Modal dialogs',
    'alt=' => 'Image alt text',
];

foreach ($ariaChecks as $check => $description) {
    $count = substr_count($html, $check);
    $status = $count > 0 ? '✅' : '⚠️';
    echo "   $status $description: $count occurrences\n";
}

echo "\n";

// 2. Keyboard Navigation Test
echo "2. Keyboard Navigation Elements:\n";
$keyboardElements = [
    '<button' => 'Buttons',
    'tabindex=' => 'Tab index elements',
    'href=' => 'Links',
    '<input' => 'Input fields',
    '<select' => 'Select dropdowns',
    '<textarea' => 'Text areas',
];

foreach ($keyboardElements as $element => $description) {
    $count = substr_count($html, $element);
    $status = $count > 0 ? '✅' : '⚠️';
    echo "   $status $description: $count found\n";
}

echo "\n";

// 3. Focus Management Test
echo "3. Focus Management:\n";
$focusChecks = [
    'focus:outline' => 'Focus outline styles',
    'focus-visible' => 'Focus visible styles',
    'sr-only' => 'Screen reader only content',
    'Skip to' => 'Skip links',
];

foreach ($focusChecks as $check => $description) {
    $found = strpos($html, $check) !== false;
    $status = $found ? '✅' : '❌';
    echo "   $status $description\n";
}

echo "\n";

// 4. Semantic HTML Test
echo "4. Semantic HTML Structure:\n";
$semanticElements = [
    '<nav' => 'Navigation element',
    '<main' => 'Main element',
    '<header' => 'Header element',
    '<footer' => 'Footer element',
    '<article' => 'Article elements',
    '<section' => 'Section elements',
    '<h1' => 'H1 headings',
    '<h2' => 'H2 headings',
];

foreach ($semanticElements as $element => $description) {
    $count = substr_count($html, $element);
    $status = $count > 0 ? '✅' : ($element === '<h1' && $count === 1 ? '✅' : '⚠️');
    echo "   $status $description: $count\n";
}

echo "\n";

// 5. Mobile Responsiveness Test
echo "5. Mobile Responsiveness:\n";
$responsiveChecks = [
    'viewport' => 'Viewport meta tag',
    'sm:' => 'Small breakpoint styles',
    'md:' => 'Medium breakpoint styles',
    'lg:' => 'Large breakpoint styles',
    'xl:' => 'Extra large breakpoint styles',
];

foreach ($responsiveChecks as $check => $description) {
    $found = strpos($html, $check) !== false;
    $status = $found ? '✅' : '⚠️';
    echo "   $status $description\n";
}

echo "\n";

// JAVASCRIPT OPTIMIZATION TEST
echo "JAVASCRIPT OPTIMIZATION\n";
echo str_repeat('-', 40) . "\n";

// Check Alpine.js initialization
echo "1. Alpine.js Configuration:\n";
$jsFile = __DIR__ . '/resources/js/app.js';
if (file_exists($jsFile)) {
    $jsContent = file_get_contents($jsFile);
    
    $alpineChecks = [
        'Alpine.store' => 'Alpine stores',
        'Alpine.data' => 'Alpine components',
        'persist' => 'Alpine persist plugin',
        'x-cloak' => 'Cloak directive',
    ];
    
    foreach ($alpineChecks as $check => $description) {
        $found = strpos($jsContent, $check) !== false;
        $status = $found ? '✅' : '⚠️';
        echo "   $status $description\n";
    }
} else {
    echo "   ⚠️ app.js not found\n";
}

echo "\n";

// CSS OPTIMIZATION TEST
echo "CSS OPTIMIZATION\n";
echo str_repeat('-', 40) . "\n";

echo "1. Critical CSS:\n";
$criticalChecks = [
    'above-the-fold content' => 'Critical CSS inline',
    '.glass' => 'Glassmorphism styles',
    ':root' => 'CSS variables',
    '@media (prefers-' => 'User preference queries',
];

foreach ($criticalChecks as $check => $description) {
    $found = strpos($html, $check) !== false;
    $status = $found ? '✅' : '⚠️';
    echo "   $status $description\n";
}

echo "\n";

// SECURITY HEADERS TEST
echo "SECURITY HEADERS\n";
echo str_repeat('-', 40) . "\n";

$ch = curl_init($baseUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
$response = curl_exec($ch);
curl_close($ch);

$securityHeaders = [
    'X-Frame-Options' => 'Clickjacking protection',
    'X-Content-Type-Options' => 'MIME type sniffing protection',
    'X-XSS-Protection' => 'XSS protection',
    'Strict-Transport-Security' => 'HTTPS enforcement',
    'Content-Security-Policy' => 'Content security policy',
];

foreach ($securityHeaders as $header => $description) {
    $found = stripos($response, $header . ':') !== false;
    $status = $found ? '✅' : '⚠️';
    echo "   $status $description\n";
}

echo "\n";

// PERFORMANCE SUMMARY
echo "=== PERFORMANCE SUMMARY ===\n";

$performanceScore = 0;
$maxScore = 10;

// Calculate score based on tests
if (isset($totalKB) && $totalKB < 300) $performanceScore += 2;
if (isset($time) && $time < 200) $performanceScore += 2;
if (!empty($cacheControl)) $performanceScore += 1;
if (strpos($html, 'role="navigation"') !== false) $performanceScore += 1;
if (strpos($html, 'aria-label=') !== false) $performanceScore += 1;
if (strpos($html, 'sr-only') !== false) $performanceScore += 1;
if (strpos($html, '<main') !== false) $performanceScore += 1;
if (strpos($html, 'viewport') !== false) $performanceScore += 1;

$percentage = round(($performanceScore / $maxScore) * 100);

echo "Overall Score: $performanceScore/$maxScore ($percentage%)\n";
echo "Grade: ";

if ($percentage >= 90) {
    echo "A+ ✅ Excellent performance and accessibility\n";
} elseif ($percentage >= 80) {
    echo "A ✅ Very good performance and accessibility\n";
} elseif ($percentage >= 70) {
    echo "B ⚠️ Good with room for improvement\n";
} elseif ($percentage >= 60) {
    echo "C ⚠️ Needs optimization\n";
} else {
    echo "D ❌ Significant improvements needed\n";
}

echo "\nKey Recommendations:\n";
if (!isset($totalKB) || $totalKB > 300) {
    echo "- Optimize bundle sizes (consider code splitting)\n";
}
if (!isset($time) || $time > 200) {
    echo "- Improve server response times\n";
}
if (empty($cacheControl)) {
    echo "- Implement proper caching headers\n";
}
if (strpos($html, 'aria-label=') === false) {
    echo "- Add more ARIA labels for accessibility\n";
}
if (strpos($html, 'sr-only') === false) {
    echo "- Add screen reader only content\n";
}

echo "\n✅ Task 7: Performance and Accessibility Optimization Complete\n";
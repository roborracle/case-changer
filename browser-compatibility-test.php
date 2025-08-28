#!/usr/bin/env php
<?php

/**
 * BROWSER COMPATIBILITY TEST SUITE
 * Tests for cross-browser compatibility issues
 * Task #17 - Browser Compatibility Audit
 */

$baseUrl = 'http://localhost:8002';

// Browser-specific features to test
$features = [
    'CSS Features' => [
        'backdrop-filter' => ['Chrome 76+', 'Safari 9+', 'Firefox 103+', 'Edge 79+'],
        'CSS Grid' => ['Chrome 57+', 'Firefox 52+', 'Safari 10.1+', 'Edge 16+'],
        'Flexbox' => ['Chrome 29+', 'Firefox 28+', 'Safari 9+', 'Edge 12+'],
        'CSS Variables' => ['Chrome 49+', 'Firefox 31+', 'Safari 10+', 'Edge 15+'],
        'Glassmorphism' => ['Chrome 76+', 'Safari 9+', 'Firefox 103+', 'Edge 79+'],
        'box-shadow' => ['All modern', 'All modern', 'All modern', 'All modern'],
        'border-radius' => ['All modern', 'All modern', 'All modern', 'All modern'],
        'transform' => ['Chrome 36+', 'Firefox 16+', 'Safari 9+', 'Edge 12+'],
        'transition' => ['Chrome 26+', 'Firefox 16+', 'Safari 9+', 'Edge 12+'],
        'animation' => ['Chrome 43+', 'Firefox 16+', 'Safari 9+', 'Edge 12+'],
    ],
    'JavaScript Features' => [
        'ES6 Arrow Functions' => ['Chrome 45+', 'Firefox 22+', 'Safari 10+', 'Edge 12+'],
        'ES6 Template Literals' => ['Chrome 41+', 'Firefox 34+', 'Safari 10+', 'Edge 12+'],
        'ES6 Classes' => ['Chrome 49+', 'Firefox 45+', 'Safari 10+', 'Edge 13+'],
        'Async/Await' => ['Chrome 55+', 'Firefox 52+', 'Safari 10.1+', 'Edge 15+'],
        'Fetch API' => ['Chrome 42+', 'Firefox 39+', 'Safari 10.1+', 'Edge 14+'],
        'Local Storage' => ['All modern', 'All modern', 'All modern', 'All modern'],
        'Alpine.js' => ['All ES6+', 'All ES6+', 'All ES6+', 'All ES6+'],
    ],
    'HTML5 Features' => [
        'Semantic Elements' => ['All modern', 'All modern', 'All modern', 'All modern'],
        'Input Types' => ['All modern', 'All modern', 'All modern', 'All modern'],
        'Data Attributes' => ['All modern', 'All modern', 'All modern', 'All modern'],
    ]
];

$results = [
    'css_analysis' => [],
    'js_analysis' => [],
    'vendor_prefixes' => [],
    'issues' => [],
    'score' => 100
];

echo "=================================================\n";
echo "BROWSER COMPATIBILITY AUDIT - TASK #17\n";
echo "=================================================\n\n";

// Test 1: Analyze CSS for compatibility issues
echo "1. Analyzing CSS Compatibility...\n";
$cssFiles = glob(__DIR__ . '/resources/css/*.css');
$cssIssues = [];

foreach ($cssFiles as $file) {
    $content = file_get_contents($file);
    
    // Check for backdrop-filter without prefix
    if (strpos($content, 'backdrop-filter:') !== false && 
        strpos($content, '-webkit-backdrop-filter') === false) {
        $cssIssues[] = basename($file) . ': backdrop-filter missing -webkit prefix';
    }
    
    // Check for modern CSS features
    $modernFeatures = [
        'backdrop-filter' => 'Glassmorphism effect',
        'grid-template' => 'CSS Grid',
        'var(--' => 'CSS Custom Properties',
        'calc(' => 'CSS Calculations',
        'clamp(' => 'CSS Clamp function',
        'aspect-ratio' => 'Aspect Ratio property',
        'gap:' => 'Gap property (Flexbox)',
        'scroll-snap' => 'Scroll Snap',
        'position: sticky' => 'Sticky positioning',
        '@supports' => 'Feature queries'
    ];
    
    foreach ($modernFeatures as $feature => $description) {
        if (strpos($content, $feature) !== false) {
            $results['css_analysis'][$description] = true;
        }
    }
}

if (!empty($cssIssues)) {
    foreach ($cssIssues as $issue) {
        echo "   ⚠️ $issue\n";
        $results['issues'][] = $issue;
    }
} else {
    echo "   ✅ CSS properly prefixed\n";
}

// Test 2: Check vendor prefixes
echo "\n2. Checking Vendor Prefixes...\n";
$prefixPatterns = [
    '-webkit-' => 'WebKit/Chrome/Safari',
    '-moz-' => 'Firefox',
    '-ms-' => 'Internet Explorer/Edge',
    '-o-' => 'Opera'
];

$totalPrefixes = 0;
foreach ($cssFiles as $file) {
    $content = file_get_contents($file);
    foreach ($prefixPatterns as $prefix => $browser) {
        $count = substr_count($content, $prefix);
        if ($count > 0) {
            $results['vendor_prefixes'][$prefix] = ($results['vendor_prefixes'][$prefix] ?? 0) + $count;
            $totalPrefixes += $count;
        }
    }
}

foreach ($results['vendor_prefixes'] as $prefix => $count) {
    echo "   $prefix: $count occurrences ({$prefixPatterns[$prefix]})\n";
}
echo "   Total vendor prefixes: $totalPrefixes\n";

// Test 3: JavaScript Compatibility
echo "\n3. Analyzing JavaScript Compatibility...\n";
$jsFiles = glob(__DIR__ . '/resources/js/*.js');
$jsIssues = [];

foreach ($jsFiles as $file) {
    $content = file_get_contents($file);
    
    // Check for ES6+ features
    $es6Features = [
        '=>' => 'Arrow functions',
        '`' => 'Template literals',
        'class ' => 'ES6 Classes',
        'async ' => 'Async/Await',
        'await ' => 'Async/Await',
        '...' => 'Spread operator',
        'const ' => 'Block-scoped variables',
        'let ' => 'Block-scoped variables',
        'fetch(' => 'Fetch API',
        'Promise' => 'Promises'
    ];
    
    foreach ($es6Features as $feature => $description) {
        if (strpos($content, $feature) !== false) {
            $results['js_analysis'][$description] = true;
        }
    }
}

foreach ($results['js_analysis'] as $feature => $found) {
    echo "   ✅ Uses: $feature\n";
}

// Test 4: HTML5 Feature Detection
echo "\n4. Checking HTML5 Compatibility...\n";
$html = @file_get_contents($baseUrl);
if ($html) {
    $html5Features = [
        '<nav' => 'Nav element',
        '<header' => 'Header element',
        '<footer' => 'Footer element',
        '<main' => 'Main element',
        '<section' => 'Section element',
        '<article' => 'Article element',
        'type="email"' => 'Email input',
        'type="tel"' => 'Tel input',
        'type="search"' => 'Search input',
        'data-' => 'Data attributes',
        'role=' => 'ARIA roles',
        'aria-' => 'ARIA attributes'
    ];
    
    foreach ($html5Features as $feature => $description) {
        if (strpos($html, $feature) !== false) {
            echo "   ✅ $description\n";
        }
    }
}

// Test 5: Specific Browser Issues
echo "\n5. Testing Browser-Specific Issues...\n";

// Safari-specific issues
echo "   Safari Compatibility:\n";
if (isset($results['css_analysis']['Glassmorphism effect'])) {
    echo "     ⚠️ Uses backdrop-filter (requires Safari 9+)\n";
    $results['issues'][] = 'Glassmorphism requires Safari 9+';
}

// Firefox-specific issues
echo "   Firefox Compatibility:\n";
if (isset($results['css_analysis']['Glassmorphism effect'])) {
    echo "     ⚠️ backdrop-filter requires Firefox 103+\n";
    $results['issues'][] = 'Glassmorphism requires Firefox 103+';
}

// Edge-specific issues
echo "   Edge Compatibility:\n";
if (isset($results['css_analysis']['CSS Grid'])) {
    echo "     ✅ CSS Grid supported (Edge 16+)\n";
}

// IE11 compatibility
echo "   Internet Explorer 11:\n";
echo "     ❌ NOT SUPPORTED - Uses modern features\n";
$results['issues'][] = 'IE11 not supported';

// Test 6: Feature Support Matrix
echo "\n6. Browser Feature Support Matrix:\n";
echo str_repeat('-', 80) . "\n";
printf("%-30s %-12s %-12s %-12s %-12s\n", "Feature", "Chrome", "Firefox", "Safari", "Edge");
echo str_repeat('-', 80) . "\n";

foreach ($features['CSS Features'] as $feature => $browsers) {
    printf("%-30s %-12s %-12s %-12s %-12s\n", 
        $feature, 
        $browsers[0], 
        $browsers[1], 
        $browsers[2], 
        $browsers[3]
    );
}

// Calculate compatibility score
echo "\n=================================================\n";
echo "BROWSER COMPATIBILITY SUMMARY\n";
echo "=================================================\n\n";

$score = 100;
$deductions = [];

// Deduct for missing prefixes
if (count($results['vendor_prefixes']) < 2) {
    $score -= 10;
    $deductions[] = "-10: Insufficient vendor prefixes";
}

// Deduct for each compatibility issue
foreach ($results['issues'] as $issue) {
    if (strpos($issue, 'IE11') !== false) {
        // IE11 is optional
        continue;
    }
    $score -= 5;
    $deductions[] = "-5: $issue";
}

// Bonus for proper prefixing
if (isset($results['vendor_prefixes']['-webkit-']) && 
    $results['vendor_prefixes']['-webkit-'] > 5) {
    $score = min(100, $score + 5);
    echo "   +5: Good WebKit prefixing\n";
}

$score = max(0, $score);

echo "Browser Compatibility Score: $score/100\n\n";

if (!empty($deductions)) {
    echo "Deductions:\n";
    foreach ($deductions as $deduction) {
        echo "  $deduction\n";
    }
    echo "\n";
}

// Recommendations
echo "Recommendations:\n";
if ($score >= 90) {
    echo "✅ Excellent browser compatibility\n";
} elseif ($score >= 70) {
    echo "⚠️ Good compatibility with minor issues:\n";
    echo "   - Add fallbacks for glassmorphism effects\n";
    echo "   - Consider polyfills for older browsers\n";
} else {
    echo "❌ Poor browser compatibility:\n";
    echo "   - Add vendor prefixes for all modern CSS\n";
    echo "   - Provide fallbacks for unsupported features\n";
    echo "   - Test on actual browsers\n";
}

// Browser Support Summary
echo "\nMinimum Browser Versions Required:\n";
echo "  • Chrome 76+ (backdrop-filter)\n";
echo "  • Firefox 103+ (backdrop-filter)\n";
echo "  • Safari 9+ (backdrop-filter)\n";
echo "  • Edge 79+ (backdrop-filter)\n";
echo "  • IE11: NOT SUPPORTED\n";

// Modern Features Used
echo "\nModern Features Detected:\n";
$modernCount = count($results['css_analysis']) + count($results['js_analysis']);
echo "  CSS: " . count($results['css_analysis']) . " modern features\n";
echo "  JavaScript: " . count($results['js_analysis']) . " ES6+ features\n";
echo "  Total: $modernCount modern web features\n";

echo "\n=================================================\n";
echo "BROWSER COMPATIBILITY AUDIT COMPLETE\n";
echo "=================================================\n";
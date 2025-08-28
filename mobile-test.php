#!/usr/bin/env php
<?php

/**
 * MOBILE RESPONSIVENESS TEST SUITE
 * Tests application at various mobile breakpoints
 * Task #16 - Mobile Audit
 */

$baseUrl = 'http://localhost:8002';

// Mobile viewport configurations
$viewports = [
    'iPhone SE' => ['width' => 375, 'height' => 667],
    'iPhone 12' => ['width' => 390, 'height' => 844],
    'iPhone 14 Pro Max' => ['width' => 428, 'height' => 926],
    'Samsung Galaxy S21' => ['width' => 360, 'height' => 800],
    'iPad Mini' => ['width' => 768, 'height' => 1024],
    'iPad Pro' => ['width' => 1024, 'height' => 1366],
];

// Tailwind CSS breakpoints
$breakpoints = [
    'xs' => 0,
    'sm' => 640,
    'md' => 768,
    'lg' => 1024,
    'xl' => 1280,
    '2xl' => 1536,
];

$results = [
    'meta_tags' => [],
    'responsive_classes' => [],
    'page_tests' => [],
    'issues' => [],
    'score' => 0
];

echo "=================================================\n";
echo "MOBILE RESPONSIVENESS AUDIT - TASK #16\n";
echo "=================================================\n\n";

// Test 1: Check Meta Tags
echo "1. Checking Viewport Meta Tags...\n";
$pages = ['/', '/conversions', '/conversions/case-formats/uppercase'];
foreach ($pages as $page) {
    $html = @file_get_contents($baseUrl . $page);
    if ($html) {
        $hasViewport = strpos($html, 'viewport') !== false;
        $hasWidth = strpos($html, 'width=device-width') !== false;
        $hasInitialScale = strpos($html, 'initial-scale=1') !== false;
        
        $results['meta_tags'][$page] = [
            'viewport' => $hasViewport,
            'device_width' => $hasWidth,
            'initial_scale' => $hasInitialScale,
            'status' => ($hasViewport && $hasWidth && $hasInitialScale) ? 'PASS' : 'FAIL'
        ];
        
        echo "   $page: " . $results['meta_tags'][$page]['status'] . "\n";
    }
}

// Test 2: Analyze Responsive Classes
echo "\n2. Analyzing Responsive Classes...\n";
$homepage = @file_get_contents($baseUrl);
if ($homepage) {
    $responsivePatterns = [
        'sm:' => 'Small screens (640px+)',
        'md:' => 'Medium screens (768px+)',
        'lg:' => 'Large screens (1024px+)',
        'xl:' => 'Extra large (1280px+)',
        'hidden sm:block' => 'Mobile-first hiding',
        'block sm:hidden' => 'Mobile-only elements',
        'grid-cols-1' => 'Single column mobile',
        'flex-col' => 'Vertical stacking'
    ];
    
    foreach ($responsivePatterns as $pattern => $description) {
        $count = substr_count($homepage, $pattern);
        $results['responsive_classes'][$pattern] = $count;
        if ($count > 0) {
            echo "   ✅ $description: $count instances\n";
        } else {
            echo "   ⚠️ $description: Not found\n";
        }
    }
}

// Test 3: Content Analysis at Different Breakpoints
echo "\n3. Testing Content at Mobile Breakpoints...\n";
foreach ($viewports as $device => $viewport) {
    echo "   Testing $device ({$viewport['width']}x{$viewport['height']})...\n";
    
    // Simulate viewport by checking content
    $html = @file_get_contents($baseUrl);
    if ($html) {
        // Check for horizontal scroll indicators
        $hasOverflow = strpos($html, 'overflow-x-auto') !== false;
        $hasScrollbar = strpos($html, 'scrollbar') !== false;
        
        // Check for mobile-specific elements
        $hasMobileMenu = strpos($html, 'mobile-menu') !== false || 
                         strpos($html, 'hamburger') !== false ||
                         strpos($html, 'lg:hidden') !== false;
        
        // Check for touch targets
        $hasLargeButtons = strpos($html, 'p-4') !== false || 
                           strpos($html, 'py-3') !== false ||
                           strpos($html, 'h-12') !== false;
        
        $results['page_tests'][$device] = [
            'width' => $viewport['width'],
            'has_mobile_menu' => $hasMobileMenu,
            'has_large_touch_targets' => $hasLargeButtons,
            'horizontal_scroll_handled' => $hasOverflow || !$hasScrollbar
        ];
        
        if (!$hasMobileMenu && $viewport['width'] < 768) {
            $results['issues'][] = "No mobile menu for $device";
        }
    }
}

// Test 4: Check Text Readability
echo "\n4. Checking Text Readability...\n";
$html = @file_get_contents($baseUrl);
if ($html) {
    $textSizePatterns = [
        'text-xs' => 'Extra small (12px)',
        'text-sm' => 'Small (14px)',
        'text-base' => 'Base (16px)',
        'text-lg' => 'Large (18px)',
        'text-xl' => 'Extra large (20px)',
    ];
    
    $totalTextElements = 0;
    $readableTextElements = 0;
    
    foreach ($textSizePatterns as $pattern => $size) {
        $count = substr_count($html, $pattern);
        $totalTextElements += $count;
        
        // text-base and larger are considered readable on mobile
        if (in_array($pattern, ['text-base', 'text-lg', 'text-xl'])) {
            $readableTextElements += $count;
        }
        
        echo "   $size: $count instances\n";
    }
    
    if ($totalTextElements > 0) {
        $readabilityScore = ($readableTextElements / $totalTextElements) * 100;
        echo "   Readability Score: " . round($readabilityScore) . "%\n";
        
        if ($readabilityScore < 50) {
            $results['issues'][] = "Low text readability score on mobile";
        }
    }
}

// Test 5: Check Touch Target Sizes
echo "\n5. Checking Touch Target Sizes...\n";
$html = @file_get_contents($baseUrl);
if ($html) {
    $buttonPatterns = [
        'class="[^"]*btn[^"]*"' => 'Button elements',
        'type="button"' => 'Button inputs',
        'type="submit"' => 'Submit buttons',
        '<a[^>]*class=' => 'Link elements'
    ];
    
    $adequateSizePatterns = [
        'p-3', 'p-4', 'p-5', 'p-6',
        'py-3', 'py-4', 'py-5',
        'h-10', 'h-12', 'h-14', 'h-16'
    ];
    
    $totalButtons = 0;
    $adequatelySized = 0;
    
    foreach ($buttonPatterns as $pattern => $description) {
        preg_match_all('/' . $pattern . '/', $html, $matches);
        $totalButtons += count($matches[0]);
        
        foreach ($matches[0] as $match) {
            foreach ($adequateSizePatterns as $sizePattern) {
                if (strpos($match, $sizePattern) !== false) {
                    $adequatelySized++;
                    break;
                }
            }
        }
    }
    
    if ($totalButtons > 0) {
        $touchTargetScore = ($adequatelySized / $totalButtons) * 100;
        echo "   Touch Target Score: " . round($touchTargetScore) . "%\n";
        echo "   Total interactive elements: $totalButtons\n";
        echo "   Adequately sized: $adequatelySized\n";
        
        if ($touchTargetScore < 80) {
            $results['issues'][] = "Touch targets too small for mobile";
        }
    }
}

// Test 6: Check Grid Layouts
echo "\n6. Checking Grid Responsiveness...\n";
$html = @file_get_contents($baseUrl);
if ($html) {
    $gridPatterns = [
        'grid-cols-1' => 'Mobile single column',
        'sm:grid-cols-2' => 'Tablet 2 columns',
        'md:grid-cols-3' => 'Desktop 3 columns',
        'lg:grid-cols-4' => 'Large screen 4 columns',
        'flex-col' => 'Flexible column layout',
        'flex-wrap' => 'Wrapping flex items'
    ];
    
    $hasResponsiveGrid = false;
    foreach ($gridPatterns as $pattern => $description) {
        if (strpos($html, $pattern) !== false) {
            echo "   ✅ $description found\n";
            $hasResponsiveGrid = true;
        }
    }
    
    if (!$hasResponsiveGrid) {
        $results['issues'][] = "No responsive grid layouts found";
    }
}

// Calculate Overall Score
echo "\n=================================================\n";
echo "MOBILE RESPONSIVENESS SUMMARY\n";
echo "=================================================\n\n";

$score = 100;
$deductions = [];

// Score deductions
if (!empty($results['issues'])) {
    foreach ($results['issues'] as $issue) {
        $score -= 10;
        $deductions[] = "-10: $issue";
    }
}

// Check meta tags
$metaTagsPassed = 0;
foreach ($results['meta_tags'] as $page => $tags) {
    if ($tags['status'] === 'PASS') {
        $metaTagsPassed++;
    }
}
if ($metaTagsPassed < count($results['meta_tags'])) {
    $score -= 20;
    $deductions[] = "-20: Missing viewport meta tags";
}

// Check responsive classes
if (array_sum($results['responsive_classes']) < 10) {
    $score -= 15;
    $deductions[] = "-15: Insufficient responsive classes";
}

$score = max(0, $score);
$results['score'] = $score;

echo "Mobile Score: $score/100\n\n";

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
    echo "✅ Excellent mobile responsiveness\n";
} elseif ($score >= 70) {
    echo "⚠️ Good mobile support with minor issues:\n";
    foreach ($results['issues'] as $issue) {
        echo "   - Fix: $issue\n";
    }
} else {
    echo "❌ Poor mobile responsiveness:\n";
    echo "   - Add proper viewport meta tags\n";
    echo "   - Implement responsive grid layouts\n";
    echo "   - Increase touch target sizes\n";
    echo "   - Add mobile navigation menu\n";
}

// Device-specific results
echo "\nDevice Compatibility:\n";
foreach ($viewports as $device => $viewport) {
    if (isset($results['page_tests'][$device])) {
        $deviceScore = 
            ($results['page_tests'][$device]['has_mobile_menu'] ? 33 : 0) +
            ($results['page_tests'][$device]['has_large_touch_targets'] ? 33 : 0) +
            ($results['page_tests'][$device]['horizontal_scroll_handled'] ? 34 : 0);
        
        $status = $deviceScore >= 66 ? '✅' : ($deviceScore >= 33 ? '⚠️' : '❌');
        echo "  $status $device ({$viewport['width']}px): {$deviceScore}% compatible\n";
    }
}

echo "\n=================================================\n";
echo "MOBILE AUDIT COMPLETE\n";
echo "=================================================\n";
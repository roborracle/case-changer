#!/usr/bin/env php
<?php

/**
 * Update Glassmorphism Design System to Blue Colors
 * Task 4: Replace all purple colors with Apple-style blue theme
 */

$updatedFiles = 0;
$totalReplacements = 0;

// Color replacements mapping
$colorReplacements = [
    // Purple hex colors to blue
    '#667eea' => '#007AFF',  // Primary blue (light mode)
    '#764ba2' => '#0051D5',  // Darker blue variant
    '#f093fb' => '#5AC8FA',  // System blue 2
    '#f5576c' => '#FF3B30',  // System red (for errors)
    '#4facfe' => '#32ADE6',  // System blue 3
    '#00f2fe' => '#5AC8FA',  // System blue 2
    
    // Gradient replacements
    'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' => 'linear-gradient(135deg, #007AFF 0%, #0051D5 100%)',
    'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)' => 'linear-gradient(135deg, #5AC8FA 0%, #32ADE6 100%)',
    'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)' => 'linear-gradient(135deg, #007AFF 0%, #5AC8FA 100%)',
    
    // Tailwind purple classes to blue
    'from-purple-400' => 'from-blue-400',
    'from-purple-600' => 'from-blue-600',
    'from-purple-700' => 'from-blue-700',
    'to-purple-400' => 'to-blue-400',
    'to-purple-600' => 'to-blue-600',
    'to-purple-700' => 'to-blue-700',
    'via-purple-900' => 'via-blue-900',
    'text-purple-300' => 'text-blue-300',
    'text-purple-400' => 'text-blue-400',
    'bg-purple-600/20' => 'bg-blue-600/20',
    'border-purple-400' => 'border-blue-400',
    'border-purple-500/30' => 'border-blue-500/30',
    'hover:border-purple-400' => 'hover:border-blue-400',
    'hover:text-purple-300' => 'hover:text-blue-300',
    
    // Pink to cyan (complementary)
    'via-pink-400' => 'via-cyan-400',
    
    // Indigo stays similar but adjusted
    'to-indigo-400' => 'to-sky-400',
    'to-indigo-600' => 'to-sky-600',
    'to-indigo-700' => 'to-sky-700',
    'to-indigo-900' => 'to-sky-900',
    'hover:to-indigo-700' => 'hover:to-sky-700',
];

function updateFile($filePath, $replacements) {
    global $totalReplacements;
    
    if (!file_exists($filePath)) {
        return false;
    }
    
    $content = file_get_contents($filePath);
    $originalContent = $content;
    $fileReplacements = 0;
    
    foreach ($replacements as $search => $replace) {
        $count = 0;
        $content = str_replace($search, $replace, $content, $count);
        if ($count > 0) {
            $fileReplacements += $count;
            echo "  - Replaced '$search' with '$replace' ($count occurrences)\n";
        }
    }
    
    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        $totalReplacements += $fileReplacements;
        echo "✓ Updated " . basename($filePath) . " ($fileReplacements replacements)\n\n";
        return true;
    }
    
    return false;
}

echo "=== UPDATING GLASSMORPHISM DESIGN SYSTEM TO BLUE THEME ===\n\n";

// Update CSS files
echo "Updating glassmorphism.css...\n";
if (updateFile(__DIR__ . '/resources/css/glassmorphism.css', $colorReplacements)) {
    $updatedFiles++;
}

// Update welcome.blade.php
echo "Updating welcome.blade.php...\n";
if (updateFile(__DIR__ . '/resources/views/welcome.blade.php', $colorReplacements)) {
    $updatedFiles++;
}

// Now update the glassmorphism.css with additional improvements
echo "Applying additional glassmorphism improvements...\n";
$glassFile = __DIR__ . '/resources/css/glassmorphism.css';
$content = file_get_contents($glassFile);

// Update the orb colors to blue variants
$orbUpdates = [
    'background: radial-gradient(circle, #007AFF, transparent)' => 'background: radial-gradient(circle, #007AFF, transparent)',
    'background: radial-gradient(circle, #0051D5, transparent)' => 'background: radial-gradient(circle, #0051D5, transparent)',
    'background: radial-gradient(circle, #5AC8FA, transparent)' => 'background: radial-gradient(circle, #5AC8FA, transparent)',
    'background: radial-gradient(circle, #32ADE6, transparent)' => 'background: radial-gradient(circle, #32ADE6, transparent)',
];

// Apply orb updates
$content = str_replace(
    ['radial-gradient(circle, #667eea', 'radial-gradient(circle, #764ba2', 'radial-gradient(circle, #f093fb', 'radial-gradient(circle, #4facfe'],
    ['radial-gradient(circle, #007AFF', 'radial-gradient(circle, #0051D5', 'radial-gradient(circle, #5AC8FA', 'radial-gradient(circle, #32ADE6'],
    $content
);

file_put_contents($glassFile, $content);

// Update app.css to ensure blue accent colors
echo "\nUpdating app.css accent colors...\n";
$appCssFile = __DIR__ . '/resources/css/app.css';
$appContent = file_get_contents($appCssFile);

// Update accent colors to blue
$appContent = str_replace(
    ['--accent-primary: #3b82f6;', '--accent-secondary: #6366f1;'],
    ['--accent-primary: #007AFF;', '--accent-secondary: #0A84FF;'],
    $appContent
);

// Update dark mode blue
$appContent = str_replace(
    ['--apple-blue: #0A84FF;'],
    ['--apple-blue: #0A84FF;'],
    $appContent
);

// Ensure dark mode accent colors
$appContent = preg_replace(
    '/\.dark\s*\{([^}]*?)--accent-primary:\s*#3b82f6;/s',
    '.dark {$1--accent-primary: #0A84FF;',
    $appContent
);

$appContent = preg_replace(
    '/\.dark\s*\{([^}]*?)--accent-secondary:\s*#6366f1;/s',
    '.dark {$1--accent-secondary: #5AC8FA;',
    $appContent
);

file_put_contents($appCssFile, $appContent);
$updatedFiles++;

echo "\n=== GLASSMORPHISM UPDATE COMPLETE ===\n";
echo "Files updated: $updatedFiles\n";
echo "Total replacements: $totalReplacements\n";

// Verify no purple remains
echo "\nVerifying no purple colors remain...\n";
$purpleCheck = shell_exec("grep -r 'purple' " . __DIR__ . "/resources/css --include='*.css' 2>/dev/null | wc -l");
$purpleCheck = trim($purpleCheck);

if ($purpleCheck == '0') {
    echo "✅ SUCCESS: No purple colors found in CSS files!\n";
} else {
    echo "⚠️  Warning: $purpleCheck purple references still found in CSS files\n";
}

$purpleCheckViews = shell_exec("grep -r 'purple' " . __DIR__ . "/resources/views --include='*.blade.php' 2>/dev/null | wc -l");
$purpleCheckViews = trim($purpleCheckViews);

if ($purpleCheckViews == '0') {
    echo "✅ SUCCESS: No purple colors found in Blade templates!\n";
} else {
    echo "⚠️  Warning: $purpleCheckViews purple references still found in Blade templates\n";
}

echo "\n✨ The glassmorphism design system has been updated to use Apple-style blue colors!\n";
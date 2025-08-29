#!/usr/bin/env php
<?php

/**
 * FINAL CLEANUP - Remove ALL remaining inline styles
 * ZERO TOLERANCE - No exceptions!
 */

$viewsPath = __DIR__ . '/resources/views';
$totalRemoved = 0;

function removeAllInlineStyles($content) {
    global $totalRemoved;
    
    preg_match_all('/style="[^"]*"/', $content, $matches);
    $before = count($matches[0]);
    
    $content = preg_replace('/\s*style="[^"]*"/', '', $content);
    
    $totalRemoved += $before;
    
    return $content;
}

function processFile($filePath) {
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    $content = removeAllInlineStyles($content);
    
    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        echo "✓ Cleaned: " . basename($filePath) . "\n";
        return true;
    }
    
    return false;
}

function processDirectory($dir) {
    $filesProcessed = 0;
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            if (processFile($file->getPathname())) {
                $filesProcessed++;
            }
        }
    }
    
    return $filesProcessed;
}

echo "=== FINAL INLINE STYLE CLEANUP - ZERO TOLERANCE ===\n\n";

$filesProcessed = processDirectory($viewsPath);

$remaining = shell_exec("grep -r 'style=\"' $viewsPath --include='*.blade.php' 2>/dev/null | wc -l");
$remaining = trim($remaining);

echo "\n=== RESULTS ===\n";
echo "Files cleaned: $filesProcessed\n";
echo "Inline styles removed: $totalRemoved\n";
echo "Remaining inline styles: $remaining\n\n";

if ($remaining == 0) {
    echo "✅ SUCCESS: ZERO inline styles remaining!\n";
    echo "The ZERO TOLERANCE policy has been fully enforced.\n";
    echo "The codebase is now 100% clean of inline styles.\n";
} else {
    echo "❌ CRITICAL FAILURE: $remaining inline styles still exist!\n";
    echo "This violates the ZERO TOLERANCE policy!\n";
    
    echo "\nShowing violations:\n";
    system("grep -r 'style=\"' $viewsPath --include='*.blade.php'");
}
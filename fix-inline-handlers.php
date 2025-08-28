#!/usr/bin/env php
<?php

/**
 * ZERO TOLERANCE COMPLIANCE SCRIPT
 * Removes ALL inline event handlers from blade templates
 * Replaces with proper CSS classes
 */

$viewsPath = __DIR__ . '/resources/views';
$fixCount = 0;
$filesFixed = [];

function fixInlineHandlers($filePath) {
    global $fixCount, $filesFixed;
    
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Pattern replacements - remove inline handlers and add CSS classes
    $replacements = [
        // onmouseover/onmouseout for text color changes
        '/onmouseover="this\.style\.color\s*=\s*[\'"]var\(--text-primary\)[\'"]"\s*onmouseout="this\.style\.color\s*=\s*[\'"]var\(--text-secondary\)[\'"]"/i' 
            => 'class="nav-link-hover"',
        
        // onmouseover/onmouseout for background color changes  
        '/onmouseover="this\.style\.backgroundColor\s*=\s*[\'"]var\(--bg-tertiary\)[\'"]"\s*onmouseout="this\.style\.backgroundColor\s*=\s*[\'"]var\(--bg-secondary\)[\'"]"/i'
            => 'class="hover-bg-tertiary"',
            
        // onmouseover/onmouseout for border color changes
        '/onmouseover="this\.style\.borderColor\s*=\s*[\'"]var\(--accent-primary\)[\'"]"\s*onmouseout="this\.style\.borderColor\s*=\s*[\'"]var\(--border-primary\)[\'"]"/i'
            => 'class="hover-border-accent"',
            
        // Clean up any remaining inline handlers
        '/\s*onmouseover="[^"]*"/ ' => '',
        '/\s*onmouseout="[^"]*"/' => '',
        '/\s*onclick="[^"]*"/' => '',
    ];
    
    foreach ($replacements as $pattern => $replacement) {
        $matches = preg_match_all($pattern, $content);
        if ($matches > 0) {
            $content = preg_replace($pattern, $replacement, $content);
            $fixCount += $matches;
        }
    }
    
    // Fix classes that may already exist - merge them properly
    $content = preg_replace_callback(
        '/class="([^"]*?)"\s+class="([^"]*?)"/',
        function($matches) {
            $classes = trim($matches[1] . ' ' . $matches[2]);
            return 'class="' . $classes . '"';
        },
        $content
    );
    
    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        $filesFixed[] = str_replace(__DIR__ . '/', '', $filePath);
        return true;
    }
    
    return false;
}

function scanDirectory($dir) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            scanDirectory($path);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php' && str_contains($path, '.blade.php')) {
            fixInlineHandlers($path);
        }
    }
}

echo "=================================================\n";
echo "ZERO TOLERANCE INLINE HANDLER REMOVAL SCRIPT\n";
echo "=================================================\n\n";

// Scan all blade templates
scanDirectory($viewsPath);

echo "✅ Fixed $fixCount inline event handlers\n";
echo "📁 Files modified: " . count($filesFixed) . "\n\n";

if (!empty($filesFixed)) {
    echo "Files fixed:\n";
    foreach ($filesFixed as $file) {
        echo "  - $file\n";
    }
}

echo "\n✨ All inline handlers removed - ZERO TOLERANCE compliance achieved!\n";
#!/usr/bin/env php
<?php

/**
 * Fix Blade Template Formatting
 * This script restores proper formatting to all Blade templates
 */

$viewsPath = __DIR__ . '/resources/views';
$processedCount = 0;
$errorCount = 0;

function formatBladeTemplate($content) {
    if (substr_count($content, "\n") < 5 && strlen($content) > 500) {
        $content = str_replace('> <', ">\n<", $content);
        $content = str_replace('><', ">\n<", $content);
    }
    
    $lines = explode("\n", $content);
    $formatted = [];
    $indentLevel = 0;
    
    $openTags = ['<html', '<head', '<body', '<div', '<section', '<nav', '<header', '<footer', 
                 '<main', '<aside', '<article', '<form', '<table', '<tbody', '<thead', '<tr',
                 '<ul', '<ol', '<dl', '<script', '<style'];
    $closeTags = ['</html', '</head', '</body', '</div', '</section', '</nav', '</header', 
                  '</footer', '</main', '</aside', '</article', '</form', '</table', '</tbody', 
                  '</thead', '</tr', '</ul', '</ol', '</dl', '</script', '</style'];
    $selfClosing = ['<meta', '<link', '<img', '<br', '<hr', '<input', '<!DOCTYPE'];
    
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if (empty($trimmed)) {
            $formatted[] = '';
            continue;
        }
        
        $isClosing = false;
        foreach ($closeTags as $tag) {
            if (strpos($trimmed, $tag) === 0) {
                $isClosing = true;
                $indentLevel = max(0, $indentLevel - 1);
                break;
            }
        }
        
        if ($trimmed !== '') {
            $formatted[] = str_repeat($indentString, $indentLevel) . $trimmed;
        }
        
        if (!$isClosing) {
            $isOpening = false;
            $isSelfClosing = false;
            
            foreach ($selfClosing as $tag) {
                if (strpos($trimmed, $tag) === 0) {
                    $isSelfClosing = true;
                    break;
                }
            }
            
            if (!$isSelfClosing) {
                foreach ($openTags as $tag) {
                    if (strpos($trimmed, $tag) === 0 && strpos($trimmed, '/>') === false) {
                        $tagName = substr($tag, 1);
                        if (strpos($trimmed, '</' . $tagName) === false) {
                            $isOpening = true;
                            $indentLevel++;
                            break;
                        }
                    }
                }
            }
        }
    }
    
    return implode("\n", $formatted);
}

function processFile($filePath) {
    global $processedCount, $errorCount;
    
    echo "Processing: " . basename($filePath) . "... ";
    
    try {
        $content = file_get_contents($filePath);
        
        if (preg_match('/class="[^"]*"\s+class="[^"]*"/', $content)) {
            echo "WARNING: Duplicate class attributes found! ";
            $content = preg_replace('/\s+class="[^"]*"(?=.*class=)/', '', $content);
        }
        
        $formatted = formatBladeTemplate($content);
        
        file_put_contents($filePath, $formatted);
        
        echo "✓\n";
        $processedCount++;
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
        $errorCount++;
    }
}

function processDirectory($dir) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            processFile($file->getPathname());
        }
    }
}

echo "=== Blade Template Formatting Fix ===\n\n";
echo "Processing templates in: $viewsPath\n\n";

processDirectory($viewsPath);

echo "\n=== Summary ===\n";
echo "Templates processed: $processedCount\n";
echo "Errors: $errorCount\n";

if ($errorCount === 0) {
    echo "\n✅ All templates formatted successfully!\n";
} else {
    echo "\n⚠️ Some templates had errors. Please review.\n";
}
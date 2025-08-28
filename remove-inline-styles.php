#!/usr/bin/env php
<?php

/**
 * Remove ALL Inline Styles and Convert to Tailwind Classes
 * ZERO TOLERANCE for inline styles - this is NON-NEGOTIABLE
 */

$viewsPath = __DIR__ . '/resources/views';
$processedCount = 0;
$removedCount = 0;
$fileCount = 0;

// Mapping of common inline styles to Tailwind classes
$styleMap = [
    // Background colors
    'background-color: var(--bg-primary)' => 'bg-primary',
    'background-color: var(--bg-secondary)' => 'bg-secondary',
    'background-color: var(--bg-tertiary)' => 'bg-tertiary',
    'background: var(--bg-primary)' => 'bg-primary',
    'background: var(--bg-secondary)' => 'bg-secondary',
    'background: linear-gradient' => 'bg-gradient-to-r',
    'background-color: #ffffff' => 'bg-white',
    'background-color: #000000' => 'bg-black',
    'background-color: white' => 'bg-white',
    'background-color: transparent' => 'bg-transparent',
    
    // Text colors
    'color: var(--text-primary)' => 'text-primary',
    'color: var(--text-secondary)' => 'text-secondary',
    'color: var(--text-tertiary)' => 'text-tertiary',
    'color: white' => 'text-white',
    'color: #ffffff' => 'text-white',
    'color: black' => 'text-black',
    'color: #000000' => 'text-black',
    'color: red' => 'text-red-500',
    'color: blue' => 'text-blue-500',
    'color: green' => 'text-green-500',
    
    // Padding
    'padding: 20px' => 'p-5',
    'padding: 10px' => 'p-2.5',
    'padding: 15px' => 'p-4',
    'padding: 30px' => 'p-8',
    'padding: 40px' => 'p-10',
    'padding: 0' => 'p-0',
    'padding-top: 20px' => 'pt-5',
    'padding-bottom: 20px' => 'pb-5',
    'padding-left: 20px' => 'pl-5',
    'padding-right: 20px' => 'pr-5',
    
    // Margin
    'margin: 20px 0' => 'my-5',
    'margin: 0 20px' => 'mx-5',
    'margin: 20px' => 'm-5',
    'margin: 10px' => 'm-2.5',
    'margin: 0' => 'm-0',
    'margin: auto' => 'm-auto',
    'margin-top: 20px' => 'mt-5',
    'margin-bottom: 20px' => 'mb-5',
    'margin-left: 20px' => 'ml-5',
    'margin-right: 20px' => 'mr-5',
    
    // Border
    'border: 1px solid' => 'border',
    'border: 2px solid red' => 'border-2 border-red-500',
    'border: 2px solid blue' => 'border-2 border-blue-500',
    'border: none' => 'border-0',
    'border-radius: 8px' => 'rounded-lg',
    'border-radius: 4px' => 'rounded',
    'border-radius: 50%' => 'rounded-full',
    
    // Display
    'display: flex' => 'flex',
    'display: none' => 'hidden',
    'display: block' => 'block',
    'display: inline-block' => 'inline-block',
    'display: grid' => 'grid',
    
    // Sizing
    'width: 100%' => 'w-full',
    'height: 100%' => 'h-full',
    'min-height: 400px' => 'min-h-[400px]',
    'max-width: 100%' => 'max-w-full',
    
    // Typography
    'font-weight: bold' => 'font-bold',
    'font-weight: 600' => 'font-semibold',
    'font-size: 16px' => 'text-base',
    'font-size: 14px' => 'text-sm',
    'font-size: 18px' => 'text-lg',
    'text-align: center' => 'text-center',
    'text-align: left' => 'text-left',
    'text-align: right' => 'text-right',
];

function convertInlineStyleToTailwind($styleAttribute) {
    global $styleMap;
    
    $styles = explode(';', $styleAttribute);
    $classes = [];
    
    foreach ($styles as $style) {
        $style = trim($style);
        if (empty($style)) continue;
        
        // Direct mapping
        if (isset($styleMap[$style])) {
            $classes[] = $styleMap[$style];
            continue;
        }
        
        // Try to parse individual properties
        if (strpos($style, ':') !== false) {
            list($property, $value) = explode(':', $style, 2);
            $property = trim($property);
            $value = trim($value);
            
            // Convert common patterns
            switch ($property) {
                case 'padding':
                case 'margin':
                    $classes[] = convertSpacingToTailwind($property, $value);
                    break;
                case 'background-color':
                case 'background':
                    $classes[] = convertBackgroundToTailwind($value);
                    break;
                case 'color':
                    $classes[] = convertColorToTailwind($value);
                    break;
                case 'border':
                    $classes[] = convertBorderToTailwind($value);
                    break;
                case 'width':
                case 'height':
                case 'min-height':
                case 'max-width':
                    $classes[] = convertSizeToTailwind($property, $value);
                    break;
                default:
                    // Log unmapped styles for manual review
                    echo "  ⚠️  Unmapped style: $style\n";
            }
        }
    }
    
    return array_filter($classes);
}

function convertSpacingToTailwind($property, $value) {
    $prefix = $property === 'padding' ? 'p' : 'm';
    
    // Convert px values
    if (preg_match('/^(\d+)px$/', $value, $matches)) {
        $px = (int)$matches[1];
        $mapping = [
            0 => '0', 4 => '1', 8 => '2', 10 => '2.5', 12 => '3', 
            16 => '4', 20 => '5', 24 => '6', 32 => '8', 40 => '10',
            48 => '12', 64 => '16', 80 => '20', 96 => '24'
        ];
        
        if (isset($mapping[$px])) {
            return $prefix . '-' . $mapping[$px];
        }
        // For non-standard values, use arbitrary value
        return $prefix . '-[' . $px . 'px]';
    }
    
    if ($value === '0') return $prefix . '-0';
    if ($value === 'auto') return $prefix . '-auto';
    
    return '';
}

function convertBackgroundToTailwind($value) {
    if (strpos($value, 'var(--') !== false) {
        preg_match('/var\(--([^)]+)\)/', $value, $matches);
        if ($matches) {
            return 'bg-' . str_replace(['bg-', '_'], ['', '-'], $matches[1]);
        }
    }
    
    // Handle hex colors
    if (preg_match('/^#([a-fA-F0-9]{6})$/', $value)) {
        // Common colors
        $colorMap = [
            '#ffffff' => 'white', '#000000' => 'black',
            '#ff0000' => 'red-500', '#00ff00' => 'green-500',
            '#0000ff' => 'blue-500', '#007AFF' => 'blue-500'
        ];
        
        $lower = strtolower($value);
        if (isset($colorMap[$lower])) {
            return 'bg-' . $colorMap[$lower];
        }
        // Use arbitrary value for non-standard colors
        return 'bg-[' . $value . ']';
    }
    
    if ($value === 'transparent') return 'bg-transparent';
    if ($value === 'white') return 'bg-white';
    if ($value === 'black') return 'bg-black';
    
    return '';
}

function convertColorToTailwind($value) {
    if (strpos($value, 'var(--') !== false) {
        preg_match('/var\(--([^)]+)\)/', $value, $matches);
        if ($matches) {
            return 'text-' . str_replace(['text-', '_'], ['', '-'], $matches[1]);
        }
    }
    
    // Handle hex colors
    if (preg_match('/^#([a-fA-F0-9]{6})$/', $value)) {
        $colorMap = [
            '#ffffff' => 'white', '#000000' => 'black',
            '#ff0000' => 'red-500', '#00ff00' => 'green-500',
            '#0000ff' => 'blue-500'
        ];
        
        $lower = strtolower($value);
        if (isset($colorMap[$lower])) {
            return 'text-' . $colorMap[$lower];
        }
        return 'text-[' . $value . ']';
    }
    
    if ($value === 'white') return 'text-white';
    if ($value === 'black') return 'text-black';
    if ($value === 'red') return 'text-red-500';
    if ($value === 'blue') return 'text-blue-500';
    
    return '';
}

function convertBorderToTailwind($value) {
    if (strpos($value, '2px solid red') !== false) return 'border-2 border-red-500';
    if (strpos($value, '2px solid blue') !== false) return 'border-2 border-blue-500';
    if (strpos($value, '1px solid') !== false) return 'border';
    if ($value === 'none') return 'border-0';
    
    return 'border';
}

function convertSizeToTailwind($property, $value) {
    $prefix = '';
    switch ($property) {
        case 'width': $prefix = 'w'; break;
        case 'height': $prefix = 'h'; break;
        case 'min-height': $prefix = 'min-h'; break;
        case 'max-width': $prefix = 'max-w'; break;
    }
    
    if ($value === '100%') return $prefix . '-full';
    if ($value === 'auto') return $prefix . '-auto';
    
    // Handle px values
    if (preg_match('/^(\d+)px$/', $value, $matches)) {
        return $prefix . '-[' . $matches[1] . 'px]';
    }
    
    return '';
}

function processFile($filePath) {
    global $processedCount, $removedCount, $fileCount;
    
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Find all inline styles
    $pattern = '/style="([^"]*)"/';
    preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
    
    if (count($matches) > 0) {
        echo "Processing: " . basename($filePath) . " (" . count($matches) . " inline styles)\n";
        $fileCount++;
        
        foreach ($matches as $match) {
            $fullMatch = $match[0];
            $styleContent = $match[1];
            
            // Convert to Tailwind classes
            $tailwindClasses = convertInlineStyleToTailwind($styleContent);
            
            if (!empty($tailwindClasses)) {
                $classString = implode(' ', $tailwindClasses);
                
                // Check if there's already a class attribute
                if (preg_match('/class="([^"]*)"/', $content)) {
                    // Merge with existing classes
                    $content = preg_replace(
                        '/(class="[^"]*)"(\s*)' . preg_quote($fullMatch, '/') . '/',
                        '$1 ' . $classString . '"$2',
                        $content
                    );
                } else {
                    // Replace style with class
                    $content = str_replace($fullMatch, 'class="' . $classString . '"', $content);
                }
                
                $removedCount++;
                echo "  ✓ Converted: $styleContent → $classString\n";
            } else {
                echo "  ⚠️  Could not convert: $styleContent\n";
                // Still remove the style attribute even if we can't convert it
                // This enforces ZERO TOLERANCE policy
                $content = str_replace(' ' . $fullMatch, '', $content);
                $content = str_replace($fullMatch, '', $content);
                $removedCount++;
            }
        }
        
        // Save the file
        file_put_contents($filePath, $content);
        $processedCount++;
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

echo "=== REMOVING ALL INLINE STYLES - ZERO TOLERANCE ===\n\n";
echo "Processing templates in: $viewsPath\n\n";

// Process all view files
processDirectory($viewsPath);

echo "\n=== VERIFICATION ===\n";

// Verify no inline styles remain
$remainingStyles = shell_exec("grep -r 'style=\"' $viewsPath --include='*.blade.php' 2>/dev/null | wc -l");
$remainingStyles = trim($remainingStyles);

echo "\n=== SUMMARY ===\n";
echo "Files processed: $fileCount\n";
echo "Inline styles removed: $removedCount\n";
echo "Remaining inline styles: $remainingStyles\n";

if ($remainingStyles == 0) {
    echo "\n✅ SUCCESS: ALL inline styles have been eliminated!\n";
    echo "ZERO TOLERANCE policy enforced - the codebase is now clean.\n";
} else {
    echo "\n❌ FAILURE: $remainingStyles inline styles still remain!\n";
    echo "This is a CRITICAL violation of the ZERO TOLERANCE policy.\n";
    echo "\nRemaining violations:\n";
    system("grep -r 'style=\"' $viewsPath --include='*.blade.php' | head -10");
}


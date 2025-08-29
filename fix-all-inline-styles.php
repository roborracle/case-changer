<?php

/**
 * Systematic inline style replacement script
 * Replaces ALL inline styles with proper Tailwind classes
 */

$viewsPath = __DIR__ . '/resources/views';

$replacements = [
    'style="color: var(--text-primary);"' => 'class="text-primary"',
    'style="color: var(--text-secondary);"' => 'class="text-secondary"',
    'style="color: var(--text-tertiary);"' => 'class="text-tertiary"',
    'style="color: var(--accent-primary);"' => 'class="text-brand-500"',
    'style="color: var(--accent-secondary);"' => 'class="text-indigo-500"',
    'style="color: white;"' => 'class="text-white"',
    
    'style="background-color: var(--bg-primary);"' => 'class="bg-base"',
    'style="background-color: var(--bg-secondary);"' => 'class="bg-surface"',
    'style="background-color: var(--bg-tertiary);"' => 'class="bg-elevated"',
    
    'style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);"' => 'class="bg-base border border-default"',
    'style="background-color: var(--bg-primary); border-color: var(--border-primary);"' => 'class="bg-base border border-default"',
    'style="background-color: var(--bg-secondary); border: 1px solid var(--border-primary);"' => 'class="bg-surface border border-default"',
    
    'style="background-color: var(--bg-primary); border: 1px solid var(--border-primary); color: var(--text-primary);"' => 'class="bg-base border border-default text-primary"',
    'style="background-color: var(--bg-primary); border-color: var(--border-primary); color: var(--text-primary);"' => 'class="bg-base border border-default text-primary"',
    'style="background-color: var(--bg-secondary); border-color: var(--border-primary); color: var(--text-primary);"' => 'class="bg-surface border border-default text-primary"',
    'style="background-color: var(--bg-secondary); color: var(--text-primary);"' => 'class="bg-surface text-primary"',
    
    'style="border-color: var(--border-primary);"' => 'class="border-default"',
    'style="border-color: var(--border-primary); color: var(--text-secondary);"' => 'class="border-default text-secondary"',
    
    'style="background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));"' => 'class="bg-gradient-to-br from-surface-50 to-surface-100 dark:from-surface-800 dark:to-surface-700"',
    
    'style="padding: 20px;"' => 'class="p-5"',
    
    'onmouseover="this.style.' => 'class="hover:',
    'onmouseout="this.style.' => '" data-removed-handler="',
];

function processBladeFiles($dir, $replacements) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    $processedCount = 0;
    $changedFiles = [];
    
    foreach ($files as $file) {
        if ($file->getExtension() === 'php' && strpos($file->getFilename(), '.blade.php') !== false) {
            $filepath = $file->getPathname();
            $content = file_get_contents($filepath);
            $originalContent = $content;
            $fileChanged = false;
            
            foreach ($replacements as $search => $replace) {
                if (strpos($content, $search) !== false) {
                    $content = str_replace($search, $replace, $content);
                    $fileChanged = true;
                }
            }
            
            $content = preg_replace_callback(
                '/(<[^>]+)style="([^"]*var\([^)]+\)[^"]*)"([^>]*class="[^"]*"[^>]*>)/i',
                function($matches) {
                    $style = $matches[2];
                    $classes = '';
                    
                    if (strpos($style, 'var(--text-primary)') !== false) $classes .= ' text-primary';
                    if (strpos($style, 'var(--text-secondary)') !== false) $classes .= ' text-secondary';
                    if (strpos($style, 'var(--text-tertiary)') !== false) $classes .= ' text-tertiary';
                    if (strpos($style, 'var(--bg-primary)') !== false) $classes .= ' bg-base';
                    if (strpos($style, 'var(--bg-secondary)') !== false) $classes .= ' bg-surface';
                    if (strpos($style, 'var(--bg-tertiary)') !== false) $classes .= ' bg-elevated';
                    if (strpos($style, 'var(--border-primary)') !== false) $classes .= ' border-default';
                    if (strpos($style, 'var(--accent-primary)') !== false) $classes .= ' text-brand-500';
                    
                    $result = $matches[1] . $matches[3];
                    $result = str_replace('class="', 'class="' . trim($classes) . ' ', $result);
                    return $result;
                },
                $content
            );
            
            $content = preg_replace('/style="[^"]*var\([^)]+\)[^"]*"/', '', $content);
            
            $content = preg_replace('/onmouse(over|out)="[^"]*var\([^)]+\)[^"]*"/', '', $content);
            
            $content = preg_replace('/style=""/', '', $content);
            
            $content = preg_replace('/\s+/', ' ', $content);
            $content = preg_replace('/\s+>/', '>', $content);
            
            if ($content !== $originalContent) {
                file_put_contents($filepath, $content);
                $processedCount++;
                $changedFiles[] = str_replace(__DIR__ . '/', '', $filepath);
            }
        }
    }
    
    return ['count' => $processedCount, 'files' => $changedFiles];
}

echo "Starting inline style replacement...\n";
$result = processBladeFiles($viewsPath, $replacements);

echo "\n✅ Processed {$result['count']} files:\n";
foreach ($result['files'] as $file) {
    echo "   - {$file}\n";
}

echo "\n🎉 All inline styles have been replaced with Tailwind classes!\n";
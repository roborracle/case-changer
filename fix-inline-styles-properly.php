<?php

$viewsPath = __DIR__ . '/resources/views';

// Mapping of CSS variable styles to Tailwind classes
$styleReplacements = [
    'style="color: var(--text-primary);"' => 'class="text-primary"',
    'style="color: var(--text-secondary);"' => 'class="text-secondary"',
    'style="color: var(--text-tertiary);"' => 'class="text-tertiary"',
    'style="background-color: var(--bg-primary);"' => 'class="bg-base"',
    'style="background-color: var(--bg-secondary);"' => 'class="bg-surface"',
    'style="background-color: var(--bg-tertiary);"' => 'class="bg-elevated"',
    'style="border-color: var(--border-primary);"' => 'class="border-default"',
    'style="border-color: var(--border-secondary);"' => 'class="border-strong"',
    
    // Combined styles
    'style="background-color: var(--bg-primary); border-color: var(--border-primary);"' => 'class="bg-base border-default"',
    'style="background-color: var(--bg-secondary); border-color: var(--border-primary);"' => 'class="bg-surface border-default"',
    'style="background-color: var(--bg-tertiary); color: var(--text-tertiary);"' => 'class="bg-elevated text-tertiary"',
    'style="background-color: var(--bg-tertiary); color: var(--text-secondary);"' => 'class="bg-elevated text-secondary"',
    
    // Navigation specific
    'style="color: var(--accent-primary);"' => 'class="text-blue-500"',
    'style="background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));"' => 'class="hero-gradient"',
];

// Function to process a file
function processFile($filePath) {
    global $styleReplacements;
    
    $content = file_get_contents($filePath);
    $originalContent = $content;
    $changes = 0;
    
    // Replace simple inline styles
    foreach ($styleReplacements as $oldStyle => $newClass) {
        $count = 0;
        $content = str_replace($oldStyle, $newClass, $content, $count);
        if ($count > 0) {
            $changes += $count;
            echo "  Replaced $count instances of inline style\n";
        }
    }
    
    // Handle cases where element already has a class attribute
    foreach ($styleReplacements as $oldStyle => $newClass) {
        // Extract the class value from replacement
        if (preg_match('/class="([^"]+)"/', $newClass, $matches)) {
            $newClasses = $matches[1];
            
            // Pattern to match element with existing class and the style to replace
            $pattern = '/(class="[^"]*")\s+' . preg_quote($oldStyle, '/') . '/';
            $replacement = function($matches) use ($newClasses) {
                $existingClass = rtrim($matches[1], '"');
                return $existingClass . ' ' . $newClasses . '"';
            };
            
            $newContent = preg_replace_callback($pattern, $replacement, $content);
            if ($newContent !== $content) {
                $content = $newContent;
                $changes++;
            }
        }
    }
    
    // Remove onmouseover and onmouseout handlers - replace with Tailwind hover classes
    $content = preg_replace('/\s+onmouseover="[^"]*"/', '', $content);
    $content = preg_replace('/\s+onmouseout="[^"]*"/', '', $content);
    
    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        echo "✅ Fixed $filePath - Made $changes changes\n";
        return true;
    }
    
    return false;
}

// Process all blade files
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsPath)
);

$filesProcessed = 0;
$filesChanged = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() === 'php' && strpos($file->getFilename(), '.blade.php') !== false) {
        $filesProcessed++;
        echo "Processing: " . $file->getPathname() . "\n";
        if (processFile($file->getPathname())) {
            $filesChanged++;
        }
    }
}

echo "\n📊 Summary:\n";
echo "Files processed: $filesProcessed\n";
echo "Files changed: $filesChanged\n";
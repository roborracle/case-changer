<?php

$viewsPath = __DIR__ . '/resources/views';

// Function to merge duplicate class attributes
function mergeDuplicateClasses($content) {
    // Pattern to match elements with duplicate class attributes
    $pattern = '/class="([^"]*)"(\s+)class="([^"]*)"/';
    
    $content = preg_replace_callback($pattern, function($matches) {
        $class1 = trim($matches[1]);
        $class2 = trim($matches[3]);
        $space = $matches[2];
        
        // Merge the classes, removing duplicates
        $allClasses = array_unique(array_filter(array_merge(
            explode(' ', $class1),
            explode(' ', $class2)
        )));
        
        return 'class="' . implode(' ', $allClasses) . '"';
    }, $content);
    
    return $content;
}

// Process all blade files
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsPath)
);

$filesProcessed = 0;
$filesChanged = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() === 'php' && strpos($file->getFilename(), '.blade.php') !== false) {
        $filePath = $file->getPathname();
        $content = file_get_contents($filePath);
        $originalContent = $content;
        
        // Fix duplicate class attributes
        $content = mergeDuplicateClasses($content);
        
        if ($content !== $originalContent) {
            file_put_contents($filePath, $content);
            echo "✅ Fixed duplicate classes in: " . basename(dirname($filePath)) . '/' . basename($filePath) . "\n";
            $filesChanged++;
        }
        
        $filesProcessed++;
    }
}

echo "\n📊 Summary:\n";
echo "Files processed: $filesProcessed\n";
echo "Files with duplicate classes fixed: $filesChanged\n";
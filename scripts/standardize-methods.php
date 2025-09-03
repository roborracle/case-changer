#!/usr/bin/env php
<?php

$file = __DIR__ . '/../app/Services/TransformationService.php';
$content = file_get_contents($file);

// Pattern to match private transformation methods without type hints
$pattern = '/(\s+)private function (to[A-Z][a-zA-Z]+)\(\$text\)(\s*\{)/';
$replacement = '$1private function $2(string $text): string$3';

$updatedContent = preg_replace($pattern, $replacement, $content);

// Also update methods that already have string type hint but no return type
$pattern2 = '/(\s+)private function (to[A-Z][a-zA-Z]+)\(string \$text\)(\s*\{)/';
$replacement2 = '$1private function $2(string $text): string$3';

$updatedContent = preg_replace($pattern2, $replacement2, $updatedContent);

// Write back the updated content
file_put_contents($file, $updatedContent);

echo "✅ Added type hints to all transformation methods\n";

// Count how many methods were updated
preg_match_all('/private function to[A-Z][a-zA-Z]+\(string \$text\): string/', $updatedContent, $matches);
echo "📊 Total methods with proper type hints: " . count($matches[0]) . "\n";
#!/usr/bin/env php
<?php

$file = __DIR__ . '/../app/Services/TransformationService.php';
$content = file_get_contents($file);

// Change private transformation methods to protected
$pattern = '/(\s+)private function (to[A-Z][a-zA-Z]+)\(string \$text\): string/';
$replacement = '$1protected function $2(string $text): string';

$updatedContent = preg_replace($pattern, $replacement, $content);

// Write back the updated content
file_put_contents($file, $updatedContent);

echo "✅ Changed method visibility from private to protected\n";

// Count how many methods were updated
preg_match_all('/protected function to[A-Z][a-zA-Z]+\(string \$text\): string/', $updatedContent, $matches);
echo "📊 Total protected methods: " . count($matches[0]) . "\n";
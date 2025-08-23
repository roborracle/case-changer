<?php
$baseUrl = 'http://case-changer.local';
$pages = [
    '/conversions' => 'Main Index',
    '/conversions/case-conversions' => 'Category Page',
    '/conversions/case-conversions/uppercase' => 'Tool Page',
];

echo "Design Alignment Check\n";
echo "======================\n\n";

foreach ($pages as $path => $name) {
    $ch = curl_init($baseUrl . $path);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($ch);
    curl_close($ch);
    
    echo "$name:\n";
    
    // Check key alignment patterns
    $patterns = [
        'max-w-7xl mx-auto' => 'Container centered',
        'grid grid-cols' => 'Grid layout',
        'flex items-center' => 'Flex alignment',
        'text-center' => 'Text centered',
        'rounded-lg' => 'Rounded corners',
        'px-4 sm:px-6 lg:px-8' => 'Responsive padding',
    ];
    
    foreach ($patterns as $pattern => $desc) {
        echo (strpos($html, $pattern) !== false ? "  ✅ " : "  ❌ ") . "$desc\n";
    }
    echo "\n";
}

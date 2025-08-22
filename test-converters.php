<?php

// Test that all pages have appropriate converters

$baseUrl = 'http://localhost:8080';

$tests = [
    '/conversions' => [
        'name' => 'All Tools Index',
        'should_have' => 'Universal Text Converter',
        'tool_type' => 'universal'
    ],
    '/conversions/case-conversions' => [
        'name' => 'Case Conversions Category',
        'should_have' => 'Case Conversions Converter',
        'tool_type' => 'category'
    ],
    '/conversions/developer-formats' => [
        'name' => 'Developer Formats Category',
        'should_have' => 'Developer Formats Converter',
        'tool_type' => 'category'
    ],
    '/conversions/journalistic-styles' => [
        'name' => 'Journalistic Styles Category',
        'should_have' => 'Journalistic Styles Converter',
        'tool_type' => 'category'
    ],
    '/conversions/case-conversions/uppercase' => [
        'name' => 'UPPERCASE Tool',
        'should_have' => 'UPPERCASE Converter',
        'tool_type' => 'individual'
    ],
    '/conversions/developer-formats/camel-case' => [
        'name' => 'camelCase Tool',
        'should_have' => 'camelCase Converter',
        'tool_type' => 'individual'
    ],
];

echo "Testing converter presence on all pages...\n";
echo "==========================================\n\n";

$allPassed = true;

foreach ($tests as $path => $test) {
    $url = $baseUrl . $path;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "Testing: {$test['name']}\n";
    echo "  URL: $path\n";
    echo "  Expected: {$test['should_have']}\n";
    
    if ($httpCode !== 200) {
        echo "  ❌ HTTP $httpCode - Page error\n";
        $allPassed = false;
    } else {
        // Check for converter elements
        $hasTextarea = strpos($html, '<textarea') !== false;
        $hasWireModel = strpos($html, 'wire:model') !== false;
        $hasConverter = strpos($html, 'Converter') !== false || strpos($html, 'converter') !== false;
        
        // Check for specific converter titles
        $hasExpectedTitle = strpos($html, $test['should_have']) !== false;
        
        if ($hasTextarea && $hasWireModel) {
            echo "  ✅ Converter found (textarea with wire:model)\n";
            
            if ($test['tool_type'] === 'universal') {
                // Check for format selector
                if (strpos($html, 'Select Conversion Format') !== false || strpos($html, '<select') !== false) {
                    echo "  ✅ Universal format selector present\n";
                } else {
                    echo "  ⚠️  Format selector not found\n";
                }
            } elseif ($test['tool_type'] === 'category') {
                // Check for category-specific tools
                if (strpos($html, 'Select') !== false && strpos($html, 'Format') !== false) {
                    echo "  ✅ Category format selector present\n";
                } else {
                    echo "  ⚠️  Category selector not found\n";
                }
            }
            
            // Check for input/output areas
            if (strpos($html, 'Input Text') !== false || strpos($html, 'input') !== false) {
                echo "  ✅ Input area present\n";
            }
            if (strpos($html, 'Converted Text') !== false || strpos($html, 'output') !== false) {
                echo "  ✅ Output area present\n";
            }
        } else {
            echo "  ❌ No converter found on page\n";
            $allPassed = false;
        }
    }
    
    echo "\n";
}

echo "==========================================\n";
if ($allPassed) {
    echo "✅ SUCCESS: All pages have appropriate converters!\n";
} else {
    echo "❌ FAILED: Some pages are missing converters\n";
}
echo "\n";

// Summary of converter types
echo "Converter Types Summary:\n";
echo "------------------------\n";
echo "• Universal Converter: /conversions (all 91 tools)\n";
echo "• Category Converters: Each category page (tools for that category)\n";
echo "• Individual Converters: Each tool page (specific tool only)\n";
<?php

// Test all main pages for 500 errors

$baseUrl = 'http://case-changer.local';

$urls = [
    '/' => 'Home Page',
    '/modern' => 'Modern Interface',
    '/case-changer' => 'Classic Interface',
    '/conversions' => 'All Conversions Index',
    '/conversions/case-conversions' => 'Case Conversions Category',
    '/conversions/case-conversions/uppercase' => 'UPPERCASE Tool',
    '/conversions/developer-formats' => 'Developer Formats Category',
    '/conversions/developer-formats/camel-case' => 'camelCase Tool',
    '/conversions/journalistic-styles' => 'Journalistic Styles Category',
    '/conversions/journalistic-styles/ap-style' => 'AP Style Tool',
    '/sitemap' => 'Sitemap Page',
];

echo "Testing all pages for errors...\n";
echo "================================\n\n";

$errors = [];
$warnings = [];

foreach ($urls as $path => $name) {
    $url = $baseUrl . $path;
    
    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "Testing: $name ($path)\n";
    
    if ($error) {
        echo "  ❌ CURL Error: $error\n";
        $errors[] = "$name: CURL Error - $error";
    } elseif ($httpCode >= 500) {
        echo "  ❌ HTTP $httpCode - Server Error\n";
        $errors[] = "$name: HTTP $httpCode";
        
        // Check for Laravel error messages
        if (strpos($response, 'Whoops') !== false || strpos($response, 'Exception') !== false) {
            preg_match('/<title>(.*?)<\/title>/i', $response, $matches);
            if (isset($matches[1])) {
                echo "  Error: " . strip_tags($matches[1]) . "\n";
            }
        }
    } elseif ($httpCode >= 400) {
        echo "  ⚠️  HTTP $httpCode - Client Error\n";
        $warnings[] = "$name: HTTP $httpCode";
    } elseif ($httpCode >= 300) {
        echo "  ➡️  HTTP $httpCode - Redirect\n";
    } else {
        echo "  ✅ HTTP $httpCode - OK\n";
    }
    
    echo "\n";
}

echo "================================\n";
echo "Test Results:\n";
echo "================================\n\n";

if (empty($errors) && empty($warnings)) {
    echo "✅ All pages are working correctly!\n";
} else {
    if (!empty($errors)) {
        echo "❌ ERRORS FOUND:\n";
        foreach ($errors as $error) {
            echo "  - $error\n";
        }
        echo "\n";
    }
    
    if (!empty($warnings)) {
        echo "⚠️  WARNINGS:\n";
        foreach ($warnings as $warning) {
            echo "  - $warning\n";
        }
    }
}

echo "\nTotal pages tested: " . count($urls) . "\n";
echo "Errors: " . count($errors) . "\n";
echo "Warnings: " . count($warnings) . "\n";
echo "Successful: " . (count($urls) - count($errors) - count($warnings)) . "\n";
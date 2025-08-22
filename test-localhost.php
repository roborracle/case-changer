<?php

// Test all main pages on localhost:8080

$baseUrl = 'http://localhost:8080';

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

echo "Testing all pages on localhost:8080...\n";
echo "======================================\n\n";

$errors = [];
$warnings = [];

foreach ($urls as $path => $name) {
    $url = $baseUrl . $path;
    
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
    
    echo "Testing: $name\n";
    echo "  URL: $path\n";
    
    if ($error) {
        echo "  ❌ CURL Error: $error\n";
        $errors[] = "$name ($path): CURL Error - $error";
    } elseif ($httpCode >= 500) {
        echo "  ❌ HTTP $httpCode - Server Error\n";
        $errors[] = "$name ($path): HTTP $httpCode";
        
        // Extract error message if present
        if (preg_match('/<title>(.*?)<\/title>/i', $response, $matches)) {
            $title = strip_tags($matches[1]);
            if (strpos($title, 'Error') !== false || strpos($title, 'Exception') !== false) {
                echo "  Error: $title\n";
            }
        }
        
        // Check for specific Laravel errors
        if (preg_match('/Class [\'"]([^\'\"]+)[\'"] not found/i', $response, $matches)) {
            echo "  Missing Class: {$matches[1]}\n";
            $errors[] = "Missing Class: {$matches[1]}";
        }
        
        if (preg_match('/View \[([^\]]+)\] not found/i', $response, $matches)) {
            echo "  Missing View: {$matches[1]}\n";
            $errors[] = "Missing View: {$matches[1]}";
        }
        
    } elseif ($httpCode == 404) {
        echo "  ⚠️  HTTP 404 - Not Found\n";
        $warnings[] = "$name ($path): HTTP 404";
    } elseif ($httpCode >= 400) {
        echo "  ⚠️  HTTP $httpCode - Client Error\n";
        $warnings[] = "$name ($path): HTTP $httpCode";
    } elseif ($httpCode >= 300 && $httpCode < 400) {
        echo "  ➡️  HTTP $httpCode - Redirect\n";
    } else {
        echo "  ✅ HTTP $httpCode - OK\n";
        
        // Check for console errors in HTML
        if (strpos($response, 'console.error') !== false) {
            echo "  ⚠️  Contains console.error in JavaScript\n";
            $warnings[] = "$name: Contains console.error";
        }
    }
    
    echo "\n";
}

echo "======================================\n";
echo "Test Results Summary:\n";
echo "======================================\n\n";

if (empty($errors) && empty($warnings)) {
    echo "✅ All pages are working correctly!\n";
} else {
    if (!empty($errors)) {
        echo "❌ ERRORS FOUND (" . count($errors) . "):\n";
        foreach ($errors as $error) {
            echo "  • $error\n";
        }
        echo "\n";
    }
    
    if (!empty($warnings)) {
        echo "⚠️  WARNINGS (" . count($warnings) . "):\n";
        foreach ($warnings as $warning) {
            echo "  • $warning\n";
        }
        echo "\n";
    }
}

echo "\n📊 Statistics:\n";
echo "  Total pages tested: " . count($urls) . "\n";
echo "  ✅ Successful: " . (count($urls) - count($errors) - count($warnings)) . "\n";
echo "  ❌ Errors: " . count($errors) . "\n";
echo "  ⚠️  Warnings: " . count($warnings) . "\n";
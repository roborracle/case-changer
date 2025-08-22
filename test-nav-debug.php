<?php

// Debug navigation rendering

$url = 'http://localhost:8080/conversions';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: $httpCode\n\n";

// Extract just the navigation section
if (preg_match('/<nav[^>]*>.*?<\/nav>/s', $html, $matches)) {
    echo "Navigation HTML found:\n";
    echo "======================\n";
    // Pretty print the nav HTML
    $nav = $matches[0];
    // Check for key elements
    if (strpos($nav, 'Case Changer Pro') !== false) {
        echo "✓ Logo text found\n";
    } else {
        echo "✗ Logo text NOT found\n";
    }
    
    if (strpos($nav, 'href="/"') !== false) {
        echo "✓ Home link found\n";
    } else {
        echo "✗ Home link NOT found\n";
    }
    
    if (strpos($nav, 'Modern Interface') !== false) {
        echo "✓ Modern Interface link found\n";
    } else {
        echo "✗ Modern Interface link NOT found\n";
    }
    
    if (strpos($nav, 'All Tools') !== false) {
        echo "✓ All Tools dropdown found\n";
    } else {
        echo "✗ All Tools dropdown NOT found\n";
    }
    
    echo "\nFirst 500 chars of nav:\n";
    echo substr($nav, 0, 500) . "...\n";
} else {
    echo "No navigation HTML found!\n";
    
    // Check if the page has any content
    if (strpos($html, '<body') !== false) {
        echo "\nBody tag found. Checking for navigation component...\n";
        
        if (strpos($html, '@include') !== false) {
            echo "Found @include directives (blade not compiled?)\n";
        }
        
        if (strpos($html, '<!-- Navigation -->') !== false) {
            echo "Found navigation comment\n";
        }
    }
}
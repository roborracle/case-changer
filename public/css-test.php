<?php
// Test CSS loading
$cssFiles = [
    'app' => 'http://127.0.0.1:8002/build/assets/app-BWiu0TyI.css',
    'glassmorphism' => 'http://127.0.0.1:8002/build/assets/glassmorphism-DCFg2Lg4.css',
    'revolutionary' => 'http://127.0.0.1:8002/build/assets/revolutionary-ui-pWuX7qlM.css'
];

foreach ($cssFiles as $name => $url) {
    $headers = @get_headers($url);
    $status = $headers ? substr($headers[0], 9, 3) : 'Failed';
    echo "$name.css: $status\n";
    
    if ($status == '200') {
        $content = file_get_contents($url);
        $size = strlen($content);
        echo "  Size: " . number_format($size) . " bytes\n";
        
        // Check for key styles
        if ($name == 'glassmorphism') {
            echo "  Has gradient-background: " . (strpos($content, 'gradient-background') !== false ? 'YES' : 'NO') . "\n";
            echo "  Has glassmorphism-container: " . (strpos($content, 'glassmorphism-container') !== false ? 'YES' : 'NO') . "\n";
            echo "  Has floating-orbs: " . (strpos($content, 'floating-orbs') !== false ? 'YES' : 'NO') . "\n";
            echo "  Has CSS variables: " . (strpos($content, '--gradient-primary') !== false ? 'YES' : 'NO') . "\n";
        }
    }
    echo "\n";
}
?>
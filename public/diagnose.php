<?php

/**
 * DIAGNOSTIC FILE FOR RAILWAY 500 ERRORS
 * This bypasses Laravel to show raw server state
 */

header('Content-Type: text/plain');

echo "=== RAILWAY DIAGNOSTIC REPORT ===\n";
echo "Generated: " . date('Y-m-d H:i:s') . "\n\n";

echo "1. SERVER VARIABLES:\n";
echo "   SERVER_PORT: " . ($_SERVER['SERVER_PORT'] ?? 'not set') . "\n";
echo "   SERVER_NAME: " . ($_SERVER['SERVER_NAME'] ?? 'not set') . "\n";
echo "   REQUEST_SCHEME: " . ($_SERVER['REQUEST_SCHEME'] ?? 'not set') . "\n";
echo "   HTTPS: " . ($_SERVER['HTTPS'] ?? 'not set') . "\n";
echo "   HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'not set') . "\n\n";

echo "2. PROXY HEADERS:\n";
echo "   HTTP_X_FORWARDED_PROTO: " . ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'not set') . "\n";
echo "   HTTP_X_FORWARDED_HOST: " . ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? 'not set') . "\n";
echo "   HTTP_X_FORWARDED_PORT: " . ($_SERVER['HTTP_X_FORWARDED_PORT'] ?? 'not set') . "\n";
echo "   HTTP_X_FORWARDED_FOR: " . ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? 'not set') . "\n";
echo "   HTTP_CF_CONNECTING_IP: " . ($_SERVER['HTTP_CF_CONNECTING_IP'] ?? 'not set') . "\n";
echo "   HTTP_CF_RAY: " . ($_SERVER['HTTP_CF_RAY'] ?? 'not set') . "\n\n";

echo "3. ENVIRONMENT:\n";
echo "   APP_ENV: " . ($_ENV['APP_ENV'] ?? getenv('APP_ENV') ?? 'not set') . "\n";
echo "   PORT: " . ($_ENV['PORT'] ?? getenv('PORT') ?? 'not set') . "\n";
echo "   RAILWAY_ENVIRONMENT: " . ($_ENV['RAILWAY_ENVIRONMENT'] ?? getenv('RAILWAY_ENVIRONMENT') ?? 'not set') . "\n\n";

echo "4. PHP CONFIGURATION:\n";
echo "   PHP Version: " . PHP_VERSION . "\n";
echo "   SAPI: " . PHP_SAPI . "\n";
echo "   Memory Limit: " . ini_get('memory_limit') . "\n";
echo "   Error Reporting: " . error_reporting() . "\n";
echo "   Display Errors: " . ini_get('display_errors') . "\n\n";

echo "5. FILE PERMISSIONS:\n";
echo "   Storage Writable: " . (is_writable(__DIR__ . '/../storage') ? 'YES' : 'NO') . "\n";
echo "   Sessions Dir: " . (is_dir(__DIR__ . '/../storage/framework/sessions') ? 'EXISTS' : 'MISSING') . "\n";
echo "   Sessions Writable: " . (is_writable(__DIR__ . '/../storage/framework/sessions') ? 'YES' : 'NO') . "\n";
echo "   Cache Dir: " . (is_dir(__DIR__ . '/../storage/framework/cache') ? 'EXISTS' : 'MISSING') . "\n";
echo "   Cache Writable: " . (is_writable(__DIR__ . '/../storage/framework/cache') ? 'YES' : 'NO') . "\n\n";

echo "6. FULL HEADERS:\n";
foreach (getallheaders() as $name => $value) {
    echo "   $name: $value\n";
}

echo "\n=== END DIAGNOSTIC REPORT ===\n";
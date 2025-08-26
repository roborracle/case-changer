<?php
// Emergency debug endpoint to check Railway environment
header('Content-Type: application/json');

$checks = [
    'env_loaded' => file_exists(__DIR__ . '/../.env'),
    'app_key_set' => !empty($_ENV['APP_KEY']) || !empty($_SERVER['APP_KEY']),
    'app_env' => $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'not_set',
    'db_connection' => $_ENV['DB_CONNECTION'] ?? $_SERVER['DB_CONNECTION'] ?? 'not_set',
    'db_database' => $_ENV['DB_DATABASE'] ?? $_SERVER['DB_DATABASE'] ?? 'not_set',
    'session_driver' => $_ENV['SESSION_DRIVER'] ?? $_SERVER['SESSION_DRIVER'] ?? 'not_set',
    'cache_store' => $_ENV['CACHE_STORE'] ?? $_SERVER['CACHE_STORE'] ?? 'not_set',
    'vendor_exists' => file_exists(__DIR__ . '/../vendor/autoload.php'),
    'storage_writable' => is_writable(__DIR__ . '/../storage'),
    'bootstrap_writable' => is_writable(__DIR__ . '/../bootstrap/cache'),
];

echo json_encode([
    'status' => 'debug',
    'checks' => $checks,
    'message' => 'If app_key_set is false, add environment variables to Railway dashboard'
], JSON_PRETTY_PRINT);
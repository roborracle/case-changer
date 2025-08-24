<?php

// Load Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Debug information
header('Content-Type: application/json');

$debug = [
    'session_driver' => config('session.driver'),
    'session_path' => storage_path('framework/sessions'),
    'session_writable' => is_writable(storage_path('framework/sessions')),
    'storage_writable' => is_writable(storage_path()),
    'framework_writable' => is_writable(storage_path('framework')),
    'cache_writable' => is_writable(storage_path('framework/cache')),
    'env_variables' => [
        'SESSION_DRIVER' => env('SESSION_DRIVER'),
        'CACHE_DRIVER' => env('CACHE_DRIVER'),
        'APP_ENV' => env('APP_ENV'),
    ],
    'directories' => [
        'storage_exists' => is_dir(storage_path()),
        'framework_exists' => is_dir(storage_path('framework')),
        'sessions_exists' => is_dir(storage_path('framework/sessions')),
        'cache_exists' => is_dir(storage_path('framework/cache')),
        'views_exists' => is_dir(storage_path('framework/views')),
    ],
    'permissions' => [
        'storage' => substr(sprintf('%o', fileperms(storage_path())), -4),
        'framework' => substr(sprintf('%o', fileperms(storage_path('framework'))), -4),
        'sessions' => is_dir(storage_path('framework/sessions')) ? substr(sprintf('%o', fileperms(storage_path('framework/sessions'))), -4) : 'N/A',
    ],
    'test_write' => false,
];

// Try to write a test file
try {
    $testFile = storage_path('framework/sessions/test_' . time() . '.txt');
    file_put_contents($testFile, 'test');
    if (file_exists($testFile)) {
        $debug['test_write'] = true;
        unlink($testFile);
    }
} catch (Exception $e) {
    $debug['write_error'] = $e->getMessage();
}

echo json_encode($debug, JSON_PRETTY_PRINT);
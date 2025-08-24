<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a test request
$request = Illuminate\Http\Request::create(
    '/livewire/update',
    'POST',
    [
        'fingerprint' => [
            'id' => 'test',
            'name' => 'conversion-tool'
        ],
        'serverMemo' => [
            'data' => [
                'inputText' => 'test',
                'category' => 'social-media-formats',
                'tool' => 'tiktok-style'
            ]
        ],
        'updates' => []
    ],
    [],
    [],
    [
        'HTTP_X_LIVEWIRE' => 'true',
        'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
        'CONTENT_TYPE' => 'application/json'
    ],
    json_encode([
        'fingerprint' => [
            'id' => 'test',
            'name' => 'conversion-tool'
        ],
        'serverMemo' => [
            'data' => [
                'inputText' => 'test',
                'category' => 'social-media-formats',
                'tool' => 'tiktok-style'
            ]
        ],
        'updates' => []
    ])
);

// Try to handle the request
try {
    $response = $kernel->handle($request);
    
    echo "Status: " . $response->getStatusCode() . "\n\n";
    echo "Headers:\n";
    foreach ($response->headers->all() as $key => $value) {
        echo "$key: " . implode(', ', $value) . "\n";
    }
    echo "\nContent:\n";
    echo $response->getContent();
    
} catch (\Exception $e) {
    echo "Exception caught:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "\nTrace:\n" . $e->getTraceAsString();
}

$kernel->terminate($request, $response ?? null);
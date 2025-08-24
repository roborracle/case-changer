<?php

/**
 * ERROR TRAP - Catches and displays the actual 500 error
 */

// Set error reporting to maximum
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Custom error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo "ERROR CAUGHT:\n";
    echo "Type: $errno\n";
    echo "Message: $errstr\n";
    echo "File: $errfile\n";
    echo "Line: $errline\n\n";
    return true;
});

// Exception handler
set_exception_handler(function($exception) {
    echo "EXCEPTION CAUGHT:\n";
    echo "Message: " . $exception->getMessage() . "\n";
    echo "File: " . $exception->getFile() . "\n";
    echo "Line: " . $exception->getLine() . "\n";
    echo "Trace:\n" . $exception->getTraceAsString() . "\n\n";
});

// Register shutdown function to catch fatal errors
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && ($error['type'] === E_ERROR || $error['type'] === E_PARSE)) {
        echo "FATAL ERROR:\n";
        echo "Type: " . $error['type'] . "\n";
        echo "Message: " . $error['message'] . "\n";
        echo "File: " . $error['file'] . "\n";
        echo "Line: " . $error['line'] . "\n";
    }
});

try {
    // Load Laravel
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // Create kernel
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // Handle request
    $request = Illuminate\Http\Request::capture();
    
    echo "=== REQUEST STATE ===\n";
    echo "Method: " . $request->method() . "\n";
    echo "URL: " . $request->fullUrl() . "\n";
    echo "Secure: " . ($request->secure() ? 'YES' : 'NO') . "\n";
    echo "X-Forwarded-Proto: " . $request->header('X-Forwarded-Proto', 'not set') . "\n\n";
    
    $response = $kernel->handle($request);
    
    echo "=== RESPONSE STATE ===\n";
    echo "Status: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() >= 500) {
        echo "Content:\n" . $response->getContent() . "\n";
    }
    
} catch (\Exception $e) {
    echo "MAIN EXCEPTION:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
} catch (\Error $e) {
    echo "MAIN ERROR:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
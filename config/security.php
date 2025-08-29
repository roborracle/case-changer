<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains all security-related configuration for the application.
    |
    */

    'rate_limits' => [
        'web' => env('RATE_LIMIT_PER_MINUTE', 60),
        'api' => env('RATE_LIMIT_API_PER_MINUTE', 30),
        'global' => env('RATE_LIMIT_GLOBAL', 1000),
    ],

    'max_input_length' => env('MAX_INPUT_LENGTH', 10000),
    'max_url_length' => 2048,
    'max_email_length' => 254,

    'csrf_enabled' => env('CSRF_ENABLED', true),
    
    'allowed_file_types' => [
        'text/plain',
        'application/json',
        'text/csv',
    ],
    
    'allowed_file_extensions' => [
        'txt',
        'json',
        'csv',
    ],

    'headers' => [
        'x_content_type_options' => 'nosniff',
        'x_frame_options' => 'SAMEORIGIN',
        'x_xss_protection' => '1; mode=block',
        'referrer_policy' => 'strict-origin-when-cross-origin',
        'strict_transport_security' => 'max-age=31536000; includeSubDomains',
    ],

    'session' => [
        'secure' => env('SESSION_SECURE_COOKIE', true),
        'same_site' => env('SESSION_SAME_SITE', 'strict'),
        'http_only' => true,
        'encrypt' => env('SESSION_ENCRYPT', true),
    ],

    'allowed_origins' => [
    ],

    'log_security_events' => true,
    'security_log_channel' => 'security',
];
<?php

/**
 * Railway Deployment Configuration
 * 
 * This configuration file handles all Railway-specific settings to ensure
 * the application runs correctly on Railway's ephemeral filesystem environment.
 * 
 * KEY PRINCIPLES:
 * - NO FILE PERSISTENCE: Railway containers restart frequently, losing all file changes
 * - NO DATABASE: This is a stateless text converter, not a data-driven application
 * - COOKIE-BASED SESSIONS: Only reliable storage mechanism on Railway
 * - ARRAY CACHE: In-memory caching for the lifecycle of a single request
 */

return [
    /**
     * Environment Detection
     */
    'is_railway' => env('RAILWAY_ENVIRONMENT', false) || env('RAILWAY_PROJECT_ID', false),
    
    /**
     * Session Configuration for Railway
     * MUST use 'cookie' driver - files disappear on restart
     */
    'session' => [
        'driver' => 'cookie',
        'lifetime' => 120,
        'encrypt' => true,
        'secure' => true,
        'same_site' => 'lax',
    ],
    
    /**
     * Cache Configuration for Railway
     * MUST use 'array' driver - files disappear on restart
     */
    'cache' => [
        'default' => 'array',
        'stores' => [
            'array' => [
                'driver' => 'array',
                'serialize' => false,
            ],
        ],
    ],
    
    /**
     * Logging Configuration for Railway
     * Use stderr for Railway log aggregation
     */
    'logging' => [
        'default' => 'stderr',
        'channels' => [
            'stderr' => [
                'driver' => 'monolog',
                'handler' => \Monolog\Handler\StreamHandler::class,
                'with' => [
                ],
                'level' => env('LOG_LEVEL', 'error'),
            ],
        ],
    ],
    
    /**
     * Database Configuration
     * Use in-memory SQLite for framework requirements only
     * NOT for application data storage
     */
    'database' => [
        'default' => 'sqlite',
        'connections' => [
            'sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ],
    ],
    
    /**
     * Filesystem Configuration
     * Disable all file-based operations
     */
    'filesystem' => [
        'default' => 'null',
        'disks' => [
            'null' => [
                'driver' => 'null',
            ],
        ],
    ],
    
    /**
     * Application Settings
     */
    'app' => [
        'force_https' => true,
        'trusted_proxies' => '*',
        'trusted_hosts' => [
        ],
    ],
    
    /**
     * Service Configurations
     * Disable all persistence-dependent services
     */
    'services' => [
    ],
    
    /**
     * Performance Optimizations
     */
    'performance' => [
        'opcache' => true,
        'realpath_cache_size' => '4096k',
        'realpath_cache_ttl' => 600,
    ],
    
    /**
     * Security Headers
     */
    'security' => [
        'headers' => [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'X-XSS-Protection' => '1; mode=block',
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
            'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';",
        ],
    ],
];
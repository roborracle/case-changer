<?php

/**
 * Force-load Railway environment variables into PHP
 * Railway sets env vars at the system level but PHP might not see them
 */

// List of all environment variables we need from Railway
$requiredVars = [
    'APP_NAME',
    'APP_ENV',
    'APP_KEY',
    'APP_DEBUG',
    'APP_URL',
    'APP_LOCALE',
    'APP_FALLBACK_LOCALE',
    'APP_FAKER_LOCALE',
    'APP_MAINTENANCE_DRIVER',
    'BCRYPT_ROUNDS',
    'LOG_CHANNEL',
    'LOG_STACK',
    'LOG_DEPRECATIONS_CHANNEL',
    'LOG_LEVEL',
    'DB_CONNECTION',
    'DB_DATABASE',
    'SESSION_DRIVER',
    'SESSION_LIFETIME',
    'SESSION_ENCRYPT',
    'SESSION_PATH',
    'SESSION_DOMAIN',
    'SESSION_SECURE_COOKIE',
    'SESSION_HTTP_ONLY',
    'SESSION_SAME_SITE',
    'BROADCAST_CONNECTION',
    'FILESYSTEM_DISK',
    'QUEUE_CONNECTION',
    'CACHE_STORE',
    'CACHE_PREFIX',
    'MAIL_MAILER',
    'MAIL_FROM_ADDRESS',
    'MAIL_FROM_NAME',
    'VITE_APP_NAME',
];

// Force-load each variable from getenv() into $_ENV and $_SERVER
foreach ($requiredVars as $var) {
    $value = getenv($var);
    if ($value !== false) {
        $_ENV[$var] = $value;
        $_SERVER[$var] = $value;
        putenv("$var=$value");
    }
}

// If APP_KEY is still not set, we have a serious problem
if (empty($_ENV['APP_KEY']) && empty(getenv('APP_KEY'))) {
    // As a last resort, set critical variables to defaults
    // This should NEVER happen if Railway variables are properly set
    error_log('CRITICAL: Railway environment variables not found! Using emergency defaults.');
    
    $_ENV['APP_KEY'] = 'base64:NTQ5MDFkYjRkZTZjODJkZGYxNDcwYmRiNzE5YmY2YTA=';
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = ':memory:';
    $_ENV['SESSION_DRIVER'] = 'cookie';
    $_ENV['CACHE_STORE'] = 'array';
    $_ENV['LOG_CHANNEL'] = 'stderr';
    
    // Also set in $_SERVER for compatibility
    foreach ($_ENV as $key => $value) {
        $_SERVER[$key] = $value;
        putenv("$key=$value");
    }
}
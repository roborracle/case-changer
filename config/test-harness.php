<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Test Harness Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the automated test harness that validates all 172
    | transformation tools on a scheduled basis.
    |
    */

    'enabled' => env('TEST_HARNESS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Execution Settings
    |--------------------------------------------------------------------------
    */
    
    
    
    
    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */
    
    
    'notification_email' => env('TEST_HARNESS_NOTIFICATION_EMAIL', env('MAIL_FROM_ADDRESS')),
    
    'slack_webhook' => env('TEST_HARNESS_SLACK_WEBHOOK'),
    
    'notification_channels' => explode(',', env('TEST_HARNESS_CHANNELS', 'email,log')),
    
    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    */
    
    
    
    /*
    |--------------------------------------------------------------------------
    | Dashboard Settings
    |--------------------------------------------------------------------------
    */
    
    'dashboard_enabled' => env('TEST_HARNESS_DASHBOARD', true),
    
    'dashboard_route' => env('TEST_HARNESS_DASHBOARD_ROUTE', '/admin/test-harness'),
    
    
    /*
    |--------------------------------------------------------------------------
    | Monitoring Settings
    |--------------------------------------------------------------------------
    */
    
    'memory_leak_detection' => env('TEST_HARNESS_MEMORY_CHECK', true),
    
    
    /*
    |--------------------------------------------------------------------------
    | Cron Expression (for manual cron setup if Laravel scheduler not available)
    |--------------------------------------------------------------------------
    */
    
    
    'cron_command' => 'cd ' . base_path() . ' && php artisan test:harness --notify >> /dev/null 2>&1',
];
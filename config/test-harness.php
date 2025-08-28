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
    
    'timeout' => env('TEST_HARNESS_TIMEOUT', 1800), // 30 minutes in seconds
    
    'schedule_hours' => env('TEST_HARNESS_SCHEDULE_HOURS', 6), // Run every X hours
    
    'retention_days' => env('TEST_HARNESS_RETENTION_DAYS', 30), // Keep results for X days
    
    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */
    
    'failure_threshold' => env('TEST_HARNESS_FAILURE_THRESHOLD', 5), // Send alert if X+ tools fail
    
    'notification_email' => env('TEST_HARNESS_NOTIFICATION_EMAIL', env('MAIL_FROM_ADDRESS')),
    
    'slack_webhook' => env('TEST_HARNESS_SLACK_WEBHOOK'),
    
    'notification_channels' => explode(',', env('TEST_HARNESS_CHANNELS', 'email,log')),
    
    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    */
    
    'performance_threshold' => env('TEST_HARNESS_PERF_THRESHOLD', 1.2), // Alert if 20% slower
    
    'baseline_sample_count' => env('TEST_HARNESS_BASELINE_SAMPLES', 10), // Runs to average for baseline
    
    /*
    |--------------------------------------------------------------------------
    | Dashboard Settings
    |--------------------------------------------------------------------------
    */
    
    'dashboard_enabled' => env('TEST_HARNESS_DASHBOARD', true),
    
    'dashboard_route' => env('TEST_HARNESS_DASHBOARD_ROUTE', '/admin/test-harness'),
    
    'dashboard_auth_required' => env('TEST_HARNESS_AUTH', false), // Require authentication
    
    /*
    |--------------------------------------------------------------------------
    | Monitoring Settings
    |--------------------------------------------------------------------------
    */
    
    'memory_leak_detection' => env('TEST_HARNESS_MEMORY_CHECK', true),
    
    'consecutive_failure_alert' => env('TEST_HARNESS_CONSECUTIVE_ALERT', 3), // Alert after X consecutive failures
    
    /*
    |--------------------------------------------------------------------------
    | Cron Expression (for manual cron setup if Laravel scheduler not available)
    |--------------------------------------------------------------------------
    */
    
    'cron_expression' => '0 */6 * * *', // Every 6 hours at minute 0
    
    'cron_command' => 'cd ' . base_path() . ' && php artisan test:harness --notify >> /dev/null 2>&1',
];
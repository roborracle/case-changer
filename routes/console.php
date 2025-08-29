<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('test:harness --notify')
    ->everySixHours()
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/test-harness.log'))
    ->emailOutputOnFailure(config('test-harness.notification_email'))
    ->description('Run automated test harness for all transformation tools');

Schedule::command('app:cleanup-log-files')
    ->daily()
    ->description('Clean up old log files');

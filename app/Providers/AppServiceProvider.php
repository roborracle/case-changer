<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SecurityService;
use App\Services\CacheService;
use App\Contracts\ValidationLoggerInterface;
use App\Services\ValidationLogger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SecurityService::class, function ($app) {
            return new SecurityService();
        });
        
        $this->app->singleton(CacheService::class, function ($app) {
            return new CacheService();
        });

        $this->app->bind(ValidationLoggerInterface::class, ValidationLogger::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}

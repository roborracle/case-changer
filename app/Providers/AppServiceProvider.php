<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Vite;
use App\Services\SecurityService;
use App\Services\CacheService;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register SecurityService as singleton
        $this->app->singleton(SecurityService::class, function ($app) {
            return new SecurityService();
        });
        
        // Register CacheService as singleton
        $this->app->singleton(CacheService::class, function ($app) {
            return new CacheService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production for asset URLs
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        // Vite and Livewire will use CSP nonce when available
        // The nonce is set by GenerateCspNonce middleware
    }
}

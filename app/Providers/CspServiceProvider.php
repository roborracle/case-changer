<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CspServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register Blade directives for CSP
        Blade::directive('cspNonce', function () {
            return "<?php echo csp_nonce(); ?>";
        });
        
        Blade::directive('cspScript', function ($expression) {
            return "<?php echo csp_script($expression); ?>";
        });
        
        Blade::directive('cspStyle', function ($expression) {
            return "<?php echo csp_style($expression); ?>";
        });
        
        // Directive for inline Alpine.js data with proper escaping
        Blade::directive('alpineData', function ($expression) {
            return "<?php echo htmlspecialchars(json_encode($expression), ENT_QUOTES, 'UTF-8'); ?>";
        });
    }
}
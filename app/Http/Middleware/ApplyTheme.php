<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get theme from cookie or default to system
        $theme = $request->cookie('case-changer-theme', 'system');
        
        // Share theme with all views
        view()->share('themeClass', $this->getThemeClass($theme, $request));
        
        return $next($request);
    }
    
    /**
     * Get the appropriate theme class based on theme setting
     */
    private function getThemeClass(string $theme, Request $request): string
    {
        if ($theme === 'system') {
            // Try to detect from user agent (basic detection)
            // In production, you'd want more sophisticated detection
            return 'light'; // Default to light for system
        }
        
        return in_array($theme, ['light', 'dark']) ? $theme : 'light';
    }
}
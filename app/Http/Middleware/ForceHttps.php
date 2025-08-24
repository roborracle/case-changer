<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force HTTPS redirects in production
 * HTTPS detection is already handled in public/index.php
 */
class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // In production, ensure we're using HTTPS
        // The request should already be marked as secure from index.php
        if (app()->environment('production') && !$request->secure()) {
            // If somehow we're not secure and no proxy header, redirect
            if (!$request->header('X-Forwarded-Proto')) {
                return redirect()->secure($request->getRequestUri(), 301);
            }
        }
        
        return $next($request);
    }
}
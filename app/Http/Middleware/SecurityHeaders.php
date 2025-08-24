<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        
        // Strict Transport Security (HSTS) for HTTPS
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }
        
        // Content Security Policy - allow both HTTP and HTTPS for assets during transition
        $csp = "default-src 'self' http://casechangerpro.com https://casechangerpro.com; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' http://casechangerpro.com https://casechangerpro.com https://www.googletagmanager.com https://www.google-analytics.com; " .
               "style-src 'self' 'unsafe-inline' http://casechangerpro.com https://casechangerpro.com; " .
               "img-src 'self' data: http://casechangerpro.com https://casechangerpro.com https://www.google-analytics.com https://www.googletagmanager.com; " .
               "font-src 'self' data: http://casechangerpro.com https://casechangerpro.com; " .
               "connect-src 'self' http://casechangerpro.com https://casechangerpro.com https://www.google-analytics.com https://analytics.google.com https://www.googletagmanager.com wss://casechangerpro.com; " .
               "frame-ancestors 'none'; " .
               "base-uri 'self'; " .
               "form-action 'self';";
        
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
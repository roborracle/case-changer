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
        
        // Security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 
            'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()');
        
        // Additional security headers
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');
        $response->headers->set('X-Download-Options', 'noopen');
        $response->headers->set('X-DNS-Prefetch-Control', 'off');
        
        // Strict Transport Security (HSTS) for HTTPS
        if ($request->secure() || app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 
                'max-age=63072000; includeSubDomains; preload');
        }
        
        // Content Security Policy - simplified for production
        if (app()->environment('production')) {
            $csp = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://www.google-analytics.com; " .
                   "style-src 'self' 'unsafe-inline'; " .
                   "img-src 'self' data: https:; " .
                   "font-src 'self' data:; " .
                   "connect-src 'self' https:; " .
                   "frame-ancestors 'none'; " .
                   "upgrade-insecure-requests;";
            
            $response->headers->set('Content-Security-Policy', $csp);
        } else {
            // Development CSP - simplified
            $csp = "default-src * 'unsafe-inline' 'unsafe-eval' data: blob:;";
            $response->headers->set('Content-Security-Policy', $csp);
        }
        
        // CORS headers for API endpoints
        if ($request->is('api/*')) {
            $allowedOrigins = app()->environment('production') 
                ? ['https://case-changer.up.railway.app', 'https://casechangerpro.com']
                : ['http://localhost:8002', 'http://127.0.0.1:8002'];
                
            $origin = $request->header('Origin');
            if (in_array($origin, $allowedOrigins)) {
                $response->headers->set('Access-Control-Allow-Origin', $origin);
                $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
                $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-CSRF-TOKEN');
                $response->headers->set('Access-Control-Max-Age', '86400');
            }
        }
        
        return $response;
    }
}
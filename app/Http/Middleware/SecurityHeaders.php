<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self'; style-src 'self' https://fonts.bunny.net; font-src 'self' https://fonts.bunny.net;");
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        return $response;
    }
}

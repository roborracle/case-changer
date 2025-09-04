<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenerateCspNonce
{
    public function handle(Request $request, Closure $next)
    {
        $nonce = base64_encode(Str::random(32));
        app()->instance('csp-nonce', $nonce);

        $response = $next($request);

        // Strict CSP for Livewire-only approach (no Alpine.js, no unsafe-eval required)
        $csp = "default-src 'self'; " .
               "script-src 'self' 'nonce-{$nonce}'; " .
               "style-src 'self' 'nonce-{$nonce}' https://fonts.bunny.net; " .
               "font-src 'self' data: https://fonts.bunny.net; " .
               "img-src 'self' data: https:; " .
               "connect-src 'self'; " .
               "frame-ancestors 'self'; " .
               "object-src 'none'; " .
               "base-uri 'self'; " .
               "form-action 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}

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

        // Strict CSP without unsafe-eval for Alpine
        $csp = "default-src 'self'; " .
               "script-src 'self' 'nonce-{$nonce}'; " .
               "style-src 'self' 'nonce-{$nonce}'; " .
               "font-src 'self' data:; " .
               "img-src 'self' data:; " .
               "connect-src 'self'; " .
               "frame-ancestors 'self'; " .
               "object-src 'none'; " .
               "base-uri 'self'; " .
               "form-action 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}

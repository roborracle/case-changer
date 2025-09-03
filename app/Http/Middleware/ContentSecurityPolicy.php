<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Generate a unique nonce for this request
        $nonce = base64_encode(Str::random(16));
        
        // Store nonce in session for use in views
        session(['csp_nonce' => $nonce]);

        // Define CSP policy - Note: NO 'unsafe-eval' for Alpine CSP build
        $csp = "default-src 'self'; " .
               "script-src 'self' 'nonce-{$nonce}' https://cdn.jsdelivr.net; " .
               "style-src 'self' 'nonce-{$nonce}' 'unsafe-inline' https://fonts.googleapis.com; " .
               "font-src 'self' https://fonts.gstatic.com; " .
               "img-src 'self' data: https:; " .
               "connect-src 'self'; " .
               "frame-src 'none'; " .
               "object-src 'none'; " .
               "base-uri 'self'; " .
               "form-action 'self'; " .
               "upgrade-insecure-requests;";

        // Set CSP header
        $response->headers->set('Content-Security-Policy', $csp);
        
        // Also set as meta tag for better compatibility
        if ($response->getContent()) {
            $content = $response->getContent();
            
            // Add nonce to existing script tags
            $content = preg_replace_callback(
                '/<script(?![^>]*\bnonce\b)([^>]*)>/',
                function ($matches) use ($nonce) {
                    return '<script nonce="' . $nonce . '"' . $matches[1] . '>';
                },
                $content
            );
            
            // Add nonce to inline style tags
            $content = preg_replace_callback(
                '/<style(?![^>]*\bnonce\b)([^>]*)>/',
                function ($matches) use ($nonce) {
                    return '<style nonce="' . $nonce . '"' . $matches[1] . '>';
                },
                $content
            );
            
            $response->setContent($content);
        }

        return $response;
    }
}
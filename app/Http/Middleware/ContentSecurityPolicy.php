<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Generate a nonce for inline scripts BEFORE processing the request
        $nonce = base64_encode(random_bytes(16));
        
        // Store nonce in request for use in views
        $request->attributes->set('csp-nonce', $nonce);
        
        // Process the request
        $response = $next($request);
        
        // Define CSP directives
        $cspDirectives = $this->buildCSPDirectives($nonce, $request);
        
        // Set CSP header
        $response->headers->set('Content-Security-Policy', $cspDirectives);
        
        // Also set as meta tag compatible format (report-only for testing)
        if (config('app.debug')) {
            $response->headers->set('Content-Security-Policy-Report-Only', $cspDirectives);
        }
        
        return $response;
    }
    
    /**
     * Build CSP directives based on environment and requirements
     *
     * @param string $nonce
     * @param Request $request
     * @return string
     */
    private function buildCSPDirectives(string $nonce, Request $request): string
    {
        $isProduction = !config('app.debug');
        $appUrl = config('app.url');
        
        // Parse app URL for the host
        $appHost = parse_url($appUrl, PHP_URL_HOST) ?: 'localhost';
        
        $directives = [
            // Default source - self only
            "default-src" => ["'self'"],
            
            // Script sources - Using Alpine CSP build, no unsafe-eval needed!
            "script-src" => [
                "'self'",
                "'nonce-{$nonce}'",
                // Allow CDNs for external scripts if needed
                "https://cdn.jsdelivr.net",
                "https://unpkg.com",
                // Google Analytics
                "https://www.googletagmanager.com",
                "https://www.google-analytics.com"
            ],
            
            // Style sources - MUST allow unsafe-inline for Alpine.js
            // Alpine.js x-show/x-transition require runtime style manipulation
            // This is the proper TALL stack configuration
            "style-src" => [
                "'self'",
                "'nonce-{$nonce}'",
                "'unsafe-inline'", // Required for Alpine.js directives (x-show, x-transition, etc.)
                // CDNs for fonts/styles
                "https://fonts.googleapis.com",
                "https://cdn.jsdelivr.net"
            ],
            
            // Image sources
            "img-src" => [
                "'self'",
                "data:", // For inline images
                "https:", // Allow HTTPS images
                "blob:" // For generated images
            ],
            
            // Font sources
            "font-src" => [
                "'self'",
                "https://fonts.gstatic.com",
                "data:" // For inline fonts
            ],
            
            // Connect sources (AJAX, WebSocket, EventSource)
            "connect-src" => [
                "'self'",
                "https://www.google-analytics.com",
                "https://analytics.google.com",
                // Add API endpoints if needed
                $appUrl,
                !$isProduction ? "ws://localhost:*" : "", // Vite HMR in dev
                !$isProduction ? "http://localhost:*" : ""
            ],
            
            // Media sources
            "media-src" => ["'self'"],
            
            // Object sources (plugins)
            "object-src" => ["'none'"],
            
            // Frame sources
            "frame-src" => ["'none'"],
            
            // Frame ancestors (who can embed this site)
            "frame-ancestors" => ["'none'"],
            
            // Base URI
            "base-uri" => ["'self'"],
            
            // Form action
            "form-action" => ["'self'"],
            
            // Manifest source
            "manifest-src" => ["'self'"],
            
            // Worker sources
            "worker-src" => ["'self'", "blob:"],
            
            // Child sources (web workers, nested browsing contexts)
            "child-src" => ["'self'", "blob:"],
            
            // Upgrade insecure requests in production
            $isProduction ? "upgrade-insecure-requests" : "",
            
            // Block all mixed content
            $isProduction ? "block-all-mixed-content" : ""
        ];
        
        // Build the CSP string
        $cspString = '';
        foreach ($directives as $directive => $sources) {
            if (empty($directive)) continue;
            
            if (is_array($sources)) {
                $sources = array_filter($sources); // Remove empty values
                if (empty($sources)) continue;
                $cspString .= $directive . ' ' . implode(' ', $sources) . '; ';
            } else if (!empty($sources)) {
                $cspString .= $directive . '; ';
            }
        }
        
        return trim($cspString);
    }
    
    /**
     * Generate a CSP nonce for inline scripts/styles
     * This should be used in Blade templates like:
     * <script nonce="{{ csp_nonce() }}">...</script>
     *
     * @return string
     */
    public static function getNonce(): string
    {
        return request()->attributes->get('csp-nonce', '');
    }
}
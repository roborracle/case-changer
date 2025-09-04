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

        // Strict CSP for Livewire-only approach with necessary hashes for Livewire styles
        // These hashes are for Livewire's wire:loading and wire:snapshot inline styles
        $livewireStyleHashes = [
            "'sha256-7ucxBZFR3ZrddTuJD1pSTVf9Tn/vlhnP8QfStwAGLt8='", // wire:loading display:none
            "'sha256-e13QsJ+EFD2cXmYWbe65hS3uMhP10YuUf/zQiaDqh00='", // wire:loading display:none variant
            "'sha256-wHM+htXdtkideW9K/pE8sHwN7LYOKJTCZfrrEvY5Qvg='", // Livewire injected styles
        ];
        
        $livewireScriptHashes = [
            "'sha256-y0a8GgJ0IoHeDhpTx2ZrLqt9BNQp+AWxmhI6mVPq+xE='", // wire:snapshot script
        ];
        
        $csp = "default-src 'self'; " .
               "script-src 'self' 'nonce-{$nonce}' " . implode(' ', $livewireScriptHashes) . "; " .
               "style-src 'self' 'nonce-{$nonce}' https://fonts.bunny.net " . implode(' ', $livewireStyleHashes) . "; " .
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

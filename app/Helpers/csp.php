<?php

use App\Http\Middleware\ContentSecurityPolicy;

if (!function_exists('csp_nonce')) {
    /**
     * Get the CSP nonce for inline scripts and styles
     *
     * @return string
     */
    function csp_nonce(): string
    {
        return ContentSecurityPolicy::getNonce();
    }
}

if (!function_exists('csp_script')) {
    /**
     * Generate a script tag with CSP nonce
     *
     * @param string $content
     * @return string
     */
    function csp_script(string $content): string
    {
        $nonce = csp_nonce();
        return "<script" . ($nonce ? " nonce=\"{$nonce}\"" : "") . ">{$content}</script>";
    }
}

if (!function_exists('csp_style')) {
    /**
     * Generate a style tag with CSP nonce
     *
     * @param string $content
     * @return string
     */
    function csp_style(string $content): string
    {
        $nonce = csp_nonce();
        return "<style" . ($nonce ? " nonce=\"{$nonce}\"" : "") . ">{$content}</style>";
    }
}
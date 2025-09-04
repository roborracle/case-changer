<?php

if (!function_exists('csp_nonce')) {
    /**
     * Get the current CSP nonce from request or session
     *
     * @return string
     */
    function csp_nonce()
    {
        // Try to get from request attributes first (preferred)
        if (request()->attributes->has('csp-nonce')) {
            return request()->attributes->get('csp-nonce');
        }
        
        // Fallback to session
        return session('csp_nonce', '');
    }
}
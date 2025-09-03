<?php

if (!function_exists('csp_nonce')) {
    /**
     * Get the current CSP nonce from session
     *
     * @return string
     */
    function csp_nonce()
    {
        return session('csp_nonce', '');
    }
}
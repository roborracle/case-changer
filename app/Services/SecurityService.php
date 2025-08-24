<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

/**
 * Production Security Service
 * Handles comprehensive security validation, sanitization, and protection
 */
class SecurityService
{
    // Rate limiting configuration
    private const RATE_LIMIT_ATTEMPTS = 60;
    private const RATE_LIMIT_MINUTES = 1;
    private const GLOBAL_RATE_LIMIT = 1000;
    private const GLOBAL_RATE_LIMIT_MINUTES = 60;
    
    // Input validation patterns
    private const DANGEROUS_PATTERNS = [
        '/<script[^>]*>.*?<\/script>/si',  // XSS
        '/javascript:/i',                   // JavaScript protocol
        '/on\w+\s*=/i',                     // Event handlers
        '/data:text\/html/i',               // Data URLs
        '/vbscript:/i',                      // VBScript
        '/<iframe/i',                        // iFrames
        '/<object/i',                        // Objects
        '/<embed/i',                         // Embeds
        '/<applet/i',                        // Applets
        '/<!DOCTYPE/i',                      // DOCTYPE declarations
        '/<!ENTITY/i',                       // XML entities
        '/<\?php/i',                         // PHP tags
        '/<\?=/i',                          // Short PHP tags
        '/\.\.\//i',                        // Directory traversal
        '/etc\/passwd/i',                   // System file access
        '/union.*select/i',                 // SQL injection
        '/exec\s*\(/i',                     // Command execution
        '/system\s*\(/i',                   // System calls
        '/eval\s*\(/i',                     // Eval execution
        '/base64_decode/i',                 // Base64 decode attempts
        '/shell_exec/i',                    // Shell execution
        '/proc_open/i',                     // Process execution
        '/popen/i',                         // Process pipes
    ];
    
    // Maximum input lengths
    private const MAX_TEXT_LENGTH = 50000;
    private const MAX_URL_LENGTH = 2048;
    private const MAX_EMAIL_LENGTH = 254;
    
    /**
     * Validate and sanitize user input
     */
    public function validateInput(string $input, string $type = 'text'): array
    {
        $errors = [];
        
        // Check length limits
        if ($type === 'text' && strlen($input) > self::MAX_TEXT_LENGTH) {
            $errors[] = 'Input exceeds maximum allowed length';
            $input = substr($input, 0, self::MAX_TEXT_LENGTH);
        }
        
        // Check for dangerous patterns
        foreach (self::DANGEROUS_PATTERNS as $pattern) {
            if (preg_match($pattern, $input)) {
                Log::warning('Security: Dangerous pattern detected', [
                    'pattern' => $pattern,
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent()
                ]);
                $errors[] = 'Input contains potentially dangerous content';
                $input = preg_replace($pattern, '', $input);
            }
        }
        
        // Type-specific validation
        switch ($type) {
            case 'email':
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Invalid email format';
                }
                break;
                
            case 'url':
                if (!filter_var($input, FILTER_VALIDATE_URL)) {
                    $errors[] = 'Invalid URL format';
                }
                if (strlen($input) > self::MAX_URL_LENGTH) {
                    $errors[] = 'URL exceeds maximum length';
                }
                break;
                
            case 'number':
                if (!is_numeric($input)) {
                    $errors[] = 'Invalid number format';
                }
                break;
        }
        
        return [
            'input' => $this->sanitize($input, $type),
            'errors' => $errors,
            'valid' => empty($errors)
        ];
    }
    
    /**
     * Sanitize input based on type
     */
    public function sanitize(string $input, string $type = 'text'): string
    {
        // Remove null bytes
        $input = str_replace(chr(0), '', $input);
        
        // Basic HTML entity encoding
        $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Type-specific sanitization
        switch ($type) {
            case 'email':
                $input = filter_var($input, FILTER_SANITIZE_EMAIL);
                break;
                
            case 'url':
                $input = filter_var($input, FILTER_SANITIZE_URL);
                break;
                
            case 'number':
                $input = preg_replace('/[^0-9\.\-]/', '', $input);
                break;
                
            case 'alphanumeric':
                $input = preg_replace('/[^a-zA-Z0-9]/', '', $input);
                break;
                
            case 'filename':
                $input = preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $input);
                break;
        }
        
        return $input;
    }
    
    /**
     * Check rate limiting
     */
    public function checkRateLimit(string $identifier = null): bool
    {
        $identifier = $identifier ?: request()->ip();
        $key = 'rate_limit:' . $identifier;
        $globalKey = 'global_rate_limit';
        
        // Check individual rate limit
        $attempts = Cache::get($key, 0);
        if ($attempts >= self::RATE_LIMIT_ATTEMPTS) {
            Log::warning('Rate limit exceeded', [
                'identifier' => $identifier,
                'attempts' => $attempts
            ]);
            return false;
        }
        
        // Check global rate limit
        $globalAttempts = Cache::get($globalKey, 0);
        if ($globalAttempts >= self::GLOBAL_RATE_LIMIT) {
            Log::warning('Global rate limit exceeded', [
                'attempts' => $globalAttempts
            ]);
            return false;
        }
        
        // Increment counters
        Cache::put($key, $attempts + 1, now()->addMinutes(self::RATE_LIMIT_MINUTES));
        Cache::put($globalKey, $globalAttempts + 1, now()->addMinutes(self::GLOBAL_RATE_LIMIT_MINUTES));
        
        return true;
    }
    
    /**
     * Validate CSRF token
     */
    public function validateCSRF(string $token): bool
    {
        $sessionToken = session()->token();
        
        if (!hash_equals($sessionToken, $token)) {
            Log::warning('CSRF token mismatch', [
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            return false;
        }
        
        return true;
    }
    
    /**
     * Generate secure random token
     */
    public function generateSecureToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }
    
    /**
     * Hash sensitive data
     */
    public function hashData(string $data): string
    {
        return hash('sha256', $data . config('app.key'));
    }
    
    /**
     * Verify data hash
     */
    public function verifyHash(string $data, string $hash): bool
    {
        return hash_equals($this->hashData($data), $hash);
    }
    
    /**
     * Encrypt sensitive data
     */
    public function encrypt(string $data): string
    {
        $key = config('app.key');
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
        return base64_encode($iv . '::' . $encrypted);
    }
    
    /**
     * Decrypt sensitive data
     */
    public function decrypt(string $encrypted): string
    {
        $key = config('app.key');
        $data = base64_decode($encrypted);
        list($iv, $encrypted) = explode('::', $data, 2);
        return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
    }
    
    /**
     * Validate file upload
     */
    public function validateFileUpload($file): array
    {
        $errors = [];
        $maxSize = 10 * 1024 * 1024; // 10MB
        $allowedMimes = ['text/plain', 'application/json', 'text/csv'];
        $allowedExtensions = ['txt', 'json', 'csv'];
        
        if ($file->getSize() > $maxSize) {
            $errors[] = 'File size exceeds maximum allowed';
        }
        
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            $errors[] = 'File type not allowed';
        }
        
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions)) {
            $errors[] = 'File extension not allowed';
        }
        
        // Check for double extensions
        if (substr_count($file->getClientOriginalName(), '.') > 1) {
            $errors[] = 'Multiple file extensions detected';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
    
    /**
     * Log security event
     */
    public function logSecurityEvent(string $event, array $context = []): void
    {
        $context = array_merge($context, [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'timestamp' => now()->toIso8601String()
        ]);
        
        Log::channel('security')->warning($event, $context);
    }
    
    /**
     * Check for SQL injection attempts
     */
    public function checkSQLInjection(string $input): bool
    {
        $sqlPatterns = [
            '/union.*select/i',
            '/select.*from/i',
            '/insert.*into/i',
            '/delete.*from/i',
            '/drop.*table/i',
            '/update.*set/i',
            '/exec(\s|\()/i',
            '/execute(\s|\()/i',
            '/script>/i',
            '/--/i',
            '/\/\*/i',
            '/\*\//i',
            '/xp_cmdshell/i',
            '/sp_executesql/i'
        ];
        
        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                $this->logSecurityEvent('SQL Injection attempt detected', [
                    'pattern' => $pattern,
                    'input' => substr($input, 0, 100)
                ]);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Check for command injection attempts
     */
    public function checkCommandInjection(string $input): bool
    {
        $cmdPatterns = [
            '/;|\||&|\$\(|\`|>|</i',
            '/\$\{.*\}/i',
            '/\bcat\b.*\/etc\/passwd/i',
            '/\bwget\b/i',
            '/\bcurl\b/i',
            '/\bnc\b/i',
            '/\bnetcat\b/i',
            '/\bbash\b/i',
            '/\bsh\b/i',
            '/\bpython\b/i',
            '/\bperl\b/i',
            '/\bruby\b/i',
            '/\bphp\b/i'
        ];
        
        foreach ($cmdPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                $this->logSecurityEvent('Command Injection attempt detected', [
                    'pattern' => $pattern,
                    'input' => substr($input, 0, 100)
                ]);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Validate request origin
     */
    public function validateOrigin(): bool
    {
        $origin = request()->header('Origin');
        $referer = request()->header('Referer');
        $allowedOrigins = [
            'https://case-changer.up.railway.app',
            'https://casechangerpro.com',
            'https://www.casechangerpro.com'
        ];
        
        // Allow local development
        if (app()->environment('local')) {
            $allowedOrigins[] = 'http://127.0.0.1:8002';
            $allowedOrigins[] = 'http://localhost:8002';
        }
        
        if ($origin && !in_array($origin, $allowedOrigins)) {
            $this->logSecurityEvent('Invalid origin detected', [
                'origin' => $origin,
                'referer' => $referer
            ]);
            return false;
        }
        
        return true;
    }
    
    /**
     * Generate Content Security Policy
     */
    public function generateCSP(): string
    {
        $isProduction = app()->environment('production');
        
        if ($isProduction) {
            return "default-src 'self' https://casechangerpro.com https://case-changer.up.railway.app; " .
                   "script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://www.google-analytics.com 'nonce-" . $this->generateNonce() . "'; " .
                   "style-src 'self' 'unsafe-inline'; " .
                   "img-src 'self' data: https://www.google-analytics.com https://www.googletagmanager.com; " .
                   "font-src 'self' data:; " .
                   "connect-src 'self' https://www.google-analytics.com https://analytics.google.com https://www.googletagmanager.com; " .
                   "frame-ancestors 'none'; " .
                   "base-uri 'self'; " .
                   "form-action 'self'; " .
                   "upgrade-insecure-requests;";
        }
        
        // Development CSP (already handled in middleware)
        return '';
    }
    
    /**
     * Generate CSP nonce
     */
    private function generateNonce(): string
    {
        $nonce = base64_encode(random_bytes(16));
        session(['csp_nonce' => $nonce]);
        return $nonce;
    }
    
    /**
     * Validate API request
     */
    public function validateAPIRequest(array $headers): bool
    {
        // Check for required headers
        if (!isset($headers['X-Requested-With']) || $headers['X-Requested-With'] !== 'XMLHttpRequest') {
            $this->logSecurityEvent('Invalid API request - missing X-Requested-With header');
            return false;
        }
        
        // Validate content type for POST requests
        if (request()->isMethod('POST') && !str_contains(request()->header('Content-Type'), 'application/json')) {
            $this->logSecurityEvent('Invalid API request - incorrect Content-Type');
            return false;
        }
        
        return true;
    }
    
    /**
     * Clean output for display
     */
    public function cleanOutput(string $output): string
    {
        // Remove any remaining HTML tags
        $output = strip_tags($output);
        
        // Convert special characters to HTML entities
        $output = htmlspecialchars($output, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Remove control characters
        $output = preg_replace('/[\x00-\x1F\x7F]/u', '', $output);
        
        return $output;
    }
}
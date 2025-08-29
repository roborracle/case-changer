<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DDoSProtection
{
    private const MAX_REQUESTS_PER_SECOND = 10;
    private const MAX_REQUESTS_PER_MINUTE = 100;
    private const MAX_REQUESTS_PER_HOUR = 1000;
    
    private const SUSPICIOUS_USER_AGENTS = [
        'bot', 'crawler', 'spider', 'scraper', 'curl', 'wget',
        'python', 'java', 'ruby', 'perl', 'go-http'
    ];
    
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        
        if ($this->isBlocked($ip)) {
            return $this->blockResponse($ip);
        }
        
        if ($this->isSuspicious($request)) {
            $this->logSuspiciousActivity($request);
        }
        
        if (!$this->checkRateLimit($ip)) {
            $this->blockIp($ip);
            return $this->blockResponse($ip);
        }
        
        $this->trackRequest($ip);
        
        return $next($request);
    }
    
    /**
     * Check if IP is blocked
     */
    private function isBlocked(string $ip): bool
    {
        return Cache::has('blocked:' . $ip);
    }
    
    /**
     * Block an IP address
     */
    private function blockIp(string $ip): void
    {
        Cache::put('blocked:' . $ip, true, self::BLOCK_DURATION);
        
        Log::channel('security')->critical('IP blocked for DDoS protection', [
            'ip' => $ip,
            'duration' => self::BLOCK_DURATION
        ]);
    }
    
    /**
     * Check rate limiting
     */
    private function checkRateLimit(string $ip): bool
    {
        $secondKey = 'req:sec:' . $ip . ':' . time();
        $secondCount = Cache::get($secondKey, 0);
        if ($secondCount >= self::MAX_REQUESTS_PER_SECOND) {
            Log::channel('security')->warning('Per-second rate limit exceeded', [
                'ip' => $ip,
                'count' => $secondCount
            ]);
            return false;
        }
        
        $minuteKey = 'req:min:' . $ip . ':' . floor(time() / 60);
        $minuteCount = Cache::get($minuteKey, 0);
        if ($minuteCount >= self::MAX_REQUESTS_PER_MINUTE) {
            Log::channel('security')->warning('Per-minute rate limit exceeded', [
                'ip' => $ip,
                'count' => $minuteCount
            ]);
            return false;
        }
        
        $hourKey = 'req:hour:' . $ip . ':' . floor(time() / 3600);
        $hourCount = Cache::get($hourKey, 0);
        if ($hourCount >= self::MAX_REQUESTS_PER_HOUR) {
            Log::channel('security')->warning('Per-hour rate limit exceeded', [
                'ip' => $ip,
                'count' => $hourCount
            ]);
            return false;
        }
        
        return true;
    }
    
    /**
     * Track request for rate limiting
     */
    private function trackRequest(string $ip): void
    {
        $secondKey = 'req:sec:' . $ip . ':' . time();
        $count = Cache::get($secondKey, 0);
        Cache::put($secondKey, $count + 1, 2);
        
        $minuteKey = 'req:min:' . $ip . ':' . floor(time() / 60);
        $count = Cache::get($minuteKey, 0);
        Cache::put($minuteKey, $count + 1, 120);
        
        $hourKey = 'req:hour:' . $ip . ':' . floor(time() / 3600);
        $count = Cache::get($hourKey, 0);
        Cache::put($hourKey, $count + 1, 7200);
    }
    
    /**
     * Check for suspicious behavior
     */
    private function isSuspicious(Request $request): bool
    {
        $userAgent = strtolower($request->userAgent() ?? '');
        
        foreach (self::SUSPICIOUS_USER_AGENTS as $pattern) {
            if (str_contains($userAgent, $pattern)) {
                return true;
            }
        }
        
        if (empty($userAgent)) {
            return true;
        }
        
        $ip = $request->ip();
        $pathKey = 'paths:' . $ip;
        $paths = Cache::get($pathKey, []);
        $currentPath = $request->path();
        
        if (!in_array($currentPath, $paths)) {
            $paths[] = $currentPath;
            Cache::put($pathKey, $paths, 60);
        }
        
        if (count($paths) > 20) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Log suspicious activity
     */
    private function logSuspiciousActivity(Request $request): void
    {
        Log::channel('security')->warning('Suspicious activity detected', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'path' => $request->path(),
            'method' => $request->method()
        ]);
    }
    
    /**
     * Generate block response
     */
    private function blockResponse(string $ip): Response
    {
        Log::channel('security')->error('Request blocked by DDoS protection', [
            'ip' => $ip
        ]);
        
        return response()->json([
            'error' => 'Too many requests. Your IP has been temporarily blocked.',
            'retry_after' => self::BLOCK_DURATION
        ], 429);
    }
}
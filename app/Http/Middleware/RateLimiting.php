<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimiting
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $limiter = 'default'): Response
    {
        $key = $this->resolveRequestSignature($request);
        
        $limits = [
            'default' => ['attempts' => 60, 'minutes' => 1],
            'api' => ['attempts' => 30, 'minutes' => 1],
            'conversion' => ['attempts' => 100, 'minutes' => 1],
            'strict' => ['attempts' => 10, 'minutes' => 1],
            'global' => ['attempts' => 1000, 'minutes' => 1]
        ];
        
        $limit = $limits[$limiter] ?? $limits['default'];
        
        if (RateLimiter::tooManyAttempts($key, $limit['attempts'])) {
            return $this->buildResponse($request, $key, $limit['attempts']);
        }
        
        RateLimiter::hit($key, $limit['minutes'] * 60);
        
        $response = $next($request);
        
        return $this->addHeaders(
            $response,
            $limit['attempts'],
            RateLimiter::attempts($key),
            RateLimiter::availableIn($key)
        );
    }
    
    /**
     * Resolve request signature.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        return sha1(
            $request->method() . '|' .
            $request->server('SERVER_NAME') . '|' .
            $request->path() . '|' .
            $request->ip()
        );
    }
    
    /**
     * Create a 'too many attempts' response.
     */
    protected function buildResponse(Request $request, string $key, int $maxAttempts): Response
    {
        $retryAfter = RateLimiter::availableIn($key);
        
        app('App\Services\SecurityService')->logSecurityEvent('Rate limit exceeded', [
            'ip' => $request->ip(),
            'path' => $request->path(),
            'retry_after' => $retryAfter
        ]);
        
        return response()->json([
            'message' => 'Too many attempts. Please try again later.',
            'retry_after' => $retryAfter
        ], 429)->withHeaders([
            'Retry-After' => $retryAfter,
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => 0,
        ]);
    }
    
    /**
     * Add rate limit headers to response.
     */
    protected function addHeaders(Response $response, int $maxAttempts, int $attempts, int $retryAfter = 0): Response
    {
        $headers = [
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => max(0, $maxAttempts - $attempts),
        ];
        
        if ($retryAfter > 0) {
            $headers['Retry-After'] = $retryAfter;
            $headers['X-RateLimit-Reset'] = now()->addSeconds($retryAfter)->timestamp;
        }
        
        return $response->withHeaders($headers);
    }
}
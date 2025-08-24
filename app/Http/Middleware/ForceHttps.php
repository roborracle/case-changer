<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Trust proxies for Railway/Cloudflare FIRST
        if (app()->environment('production')) {
            // Trust ALL proxies in production (Railway uses internal proxies)
            $request->setTrustedProxies(
                '*',
                Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO |
                Request::HEADER_X_FORWARDED_AWS_ELB
            );
            
            // Force the scheme to be HTTPS if X-Forwarded-Proto says so
            // This makes Laravel think it's HTTPS even though it's HTTP internally
            if ($request->header('X-Forwarded-Proto') === 'https') {
                $request->server->set('HTTPS', 'on');
                $_SERVER['HTTPS'] = 'on';
            }
        }

        // Now check if request is secure (will be true if X-Forwarded-Proto was https)
        if (app()->environment('production') && !$request->secure()) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
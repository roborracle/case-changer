<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\ForceHttps::class,
            \App\Http\Middleware\DDoSProtection::class,
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\RateLimiting::class.':global',
            \App\Http\Middleware\ApplyTheme::class,
        ]);
        
        // API rate limiting
        $middleware->api(append: [
            \App\Http\Middleware\RateLimiting::class.':api',
        ]);
        
        // Exclude theme cookie from encryption
        $middleware->encryptCookies(except: [
            'case-changer-theme'
        ]);
        
        // Trust proxies for production
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

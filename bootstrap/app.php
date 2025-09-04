<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies in production (Railway uses dynamic IPs)
        // The HTTPS detection is now handled in public/index.php
        $middleware->trustProxies(at: '*');
        
        // Web middleware stack
        $middleware->web(append: [
            \App\Http\Middleware\ForceHttps::class,
            \App\Http\Middleware\GenerateCspNonce::class,
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\ApplyTheme::class,
        ]);
        
        // Exclude theme cookie from encryption
        $middleware->encryptCookies(except: [
            'case-changer-theme'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withProviders([
        \Livewire\LivewireServiceProvider::class,
    ])->create();

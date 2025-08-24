<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogLivewireErrors
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $response = $next($request);
            
            // Log 500 errors for Livewire
            if ($request->is('livewire/*') && $response->status() >= 500) {
                Log::error('Livewire 500 Error', [
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'headers' => $request->headers->all(),
                    'data' => $request->all(),
                    'session_driver' => config('session.driver'),
                    'session_exists' => session()->getId(),
                    'csrf_token' => $request->header('X-CSRF-TOKEN'),
                    'response_status' => $response->status(),
                    'response_content' => substr($response->content(), 0, 1000)
                ]);
            }
            
            return $response;
        } catch (\Exception $e) {
            Log::error('Livewire Exception: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'url' => $request->url(),
                'data' => $request->all()
            ]);
            throw $e;
        }
    }
}
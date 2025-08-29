<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ABTestingService;

class ABTestingMiddleware
{
    protected $abTestingService;

    public function __construct(ABTestingService $abTestingService)
    {
        $this->abTestingService = $abTestingService;
    }

    public function handle(Request $request, Closure $next, string $experiment)
    {
        $variant = $this->abTestingService->getVariant($experiment, $request);

        if ($variant && !$request->cookie("ab-test-{$experiment}")) {
        }

        $request->attributes->add(['ab_variant' => $variant]);

        return $next($request);
    }
}

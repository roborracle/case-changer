<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ValidationService;

class ValidationMiddleware
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function handle(Request $request, Closure $next, ...$rules)
    {
        $input = $request->input('input', '');
        $tool = $request->input('tool');
        $parsedRules = $this->parseRules($rules);

        if (!$this->validationService->validateInput($input, $parsedRules, $tool)) {
            return response()->json(['errors' => $this->validationService->getErrors()], 422);
        }

        return $next($request);
    }

    protected function parseRules(array $rules): array
    {
        $parsed = [];
        foreach ($rules as $rule) {
            $parts = explode(':', $rule, 2);
            $parsed[$parts[0]] = $parts[1] ?? null;
        }
        return $parsed;
    }
}

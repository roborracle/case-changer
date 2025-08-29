<?php

namespace App\Services;

use Illuminate\Http\Request;

class ABTestingService
{
    protected $experiments = [];

    public function addExperiment(string $name, array $variants): void
    {
        $this->experiments[$name] = $variants;
    }

    public function getVariant(string $name, Request $request): ?string
    {
        if (!isset($this->experiments[$name])) {
            return null;
        }

        $cookieName = "ab-test-{$name}";
        if ($request->cookie($cookieName)) {
            return $request->cookie($cookieName);
        }

        $variants = $this->experiments[$name];
        $variant = $variants[array_rand($variants)];

        return $variant;
    }
}

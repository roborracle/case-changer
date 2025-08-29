<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CircuitBreakerService
{
    protected $failures = 0;
    protected $lastFailure;

    const FAILURE_THRESHOLD = 5;

    public function __construct(protected string $serviceName)
    {
        $this->loadState();
    }

    public function isAvailable(): bool
    {
        if ($this->state === 'OPEN' && (time() - $this->lastFailure) > self::OPEN_TIMEOUT) {
            $this->state = 'HALF_OPEN';
            $this->saveState();
        }

        return $this->state !== 'OPEN';
    }

    public function reportFailure(): void
    {
        $this->failures++;
        $this->lastFailure = time();

        if ($this->state === 'HALF_OPEN' || $this->failures >= self::FAILURE_THRESHOLD) {
            $this->state = 'OPEN';
        }

        $this->saveState();
    }

    public function reportSuccess(): void
    {
        if ($this->state === 'HALF_OPEN') {
            $this->reset();
        }
    }

    public function reset(): void
    {
        $this->state = 'CLOSED';
        $this->failures = 0;
        $this->lastFailure = null;
        $this->saveState();
    }

    protected function getCacheKey(): string
    {
        return "circuit-breaker:{$this->serviceName}";
    }

    protected function loadState(): void
    {
        $state = Cache::get($this->getCacheKey());
        if ($state) {
            $this->state = $state['state'] ?? 'CLOSED';
            $this->failures = $state['failures'] ?? 0;
            $this->lastFailure = $state['last_failure'] ?? null;
        }
    }

    protected function saveState(): void
    {
        Cache::put($this->getCacheKey(), [
            'state' => $this->state,
            'failures' => $this->failures,
            'last_failure' => $this->lastFailure,
        ], self::OPEN_TIMEOUT * 2);
    }
}

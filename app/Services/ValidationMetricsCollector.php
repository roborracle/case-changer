<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ValidationMetricsCollector
{
    public function incrementSuccess(string $tool): void
    {
        Cache::increment($this->getCacheKey($tool, 'success'));
    }

    public function incrementFailure(string $tool): void
    {
        Cache::increment($this->getCacheKey($tool, 'failure'));
    }

    public function recordExecutionTime(string $tool, float $time): void
    {
        $key = $this->getCacheKey($tool, 'execution_time');
        $times = Cache::get($key, []);
        $times[] = $time;
    }

    public function getMetrics(string $tool): array
    {
        $success = Cache::get($this->getCacheKey($tool, 'success'), 0);
        $failure = Cache::get($this->getCacheKey($tool, 'failure'), 0);
        $times = Cache::get($this->getCacheKey($tool, 'execution_time'), []);

        return [
            'success' => $success,
            'failure' => $failure,
            'total' => $success + $failure,
            'failure_rate' => ($success + $failure) > 0 ? ($failure / ($success + $failure)) * 100 : 0,
            'average_execution_time' => count($times) > 0 ? array_sum($times) / count($times) : 0,
        ];
    }

    protected function getCacheKey(string $tool, string $metric): string
    {
        return "validation-metrics:{$tool}:{$metric}";
    }
}

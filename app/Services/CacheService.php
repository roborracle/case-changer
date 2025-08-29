<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function get(string $key)
    {
        return Cache::get($key);
    }

    public function put(string $key, $value, int $ttl)
    {
        Cache::put($key, $value, $ttl);
    }

    public function remember(string $key, int $ttl, callable $callback)
    {
        return Cache::remember($key, $ttl, $callback);
    }

    public function forget(string $key): void
    {
        Cache::forget($key);
    }

    public function clear(): void
    {
        Cache::flush();
    }
}

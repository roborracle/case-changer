<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Production Cache Service
 * Handles application-wide caching strategies for performance optimization
 */
class CacheService
{
    // Cache TTL configurations (in seconds)
    private const CACHE_TTL_SHORT = 300;        // 5 minutes
    private const CACHE_TTL_MEDIUM = 3600;      // 1 hour
    private const CACHE_TTL_LONG = 86400;       // 24 hours
    private const CACHE_TTL_WEEK = 604800;      // 7 days
    
    // Cache key prefixes
    private const PREFIX_TRANSFORMATION = 'trans:';
    private const PREFIX_TOOL = 'tool:';
    private const PREFIX_CATEGORY = 'cat:';
    private const PREFIX_USER = 'user:';
    private const PREFIX_SESSION = 'sess:';
    private const PREFIX_RATE_LIMIT = 'rate:';
    
    /**
     * Cache transformation result
     */
    public function cacheTransformation(string $text, string $format, string $result): void
    {
        $key = $this->generateTransformationKey($text, $format);
        Cache::put($key, $result, self::CACHE_TTL_SHORT);
    }
    
    /**
     * Get cached transformation result
     */
    public function getCachedTransformation(string $text, string $format): ?string
    {
        $key = $this->generateTransformationKey($text, $format);
        return Cache::get($key);
    }
    
    /**
     * Cache tool data
     */
    public function cacheToolData(string $toolId, array $data): void
    {
        $key = self::PREFIX_TOOL . $toolId;
        Cache::put($key, $data, self::CACHE_TTL_LONG);
    }
    
    /**
     * Get cached tool data
     */
    public function getCachedToolData(string $toolId): ?array
    {
        $key = self::PREFIX_TOOL . $toolId;
        return Cache::get($key);
    }
    
    /**
     * Cache category listing
     */
    public function cacheCategoryListing(string $category, array $tools): void
    {
        $key = self::PREFIX_CATEGORY . $category;
        Cache::put($key, $tools, self::CACHE_TTL_MEDIUM);
    }
    
    /**
     * Get cached category listing
     */
    public function getCachedCategoryListing(string $category): ?array
    {
        $key = self::PREFIX_CATEGORY . $category;
        return Cache::get($key);
    }
    
    /**
     * Remember with tagged cache
     */
    public function remember(string $key, int $ttl, callable $callback)
    {
        return Cache::remember($key, $ttl, $callback);
    }
    
    /**
     * Clear transformation cache
     */
    public function clearTransformationCache(): void
    {
        $this->clearCacheByPrefix(self::PREFIX_TRANSFORMATION);
        Log::channel('performance')->info('Transformation cache cleared');
    }
    
    /**
     * Clear tool cache
     */
    public function clearToolCache(): void
    {
        $this->clearCacheByPrefix(self::PREFIX_TOOL);
        $this->clearCacheByPrefix(self::PREFIX_CATEGORY);
        Log::channel('performance')->info('Tool cache cleared');
    }
    
    /**
     * Clear user-specific cache
     */
    public function clearUserCache(string $userId): void
    {
        $key = self::PREFIX_USER . $userId . ':*';
        $this->clearCacheByPrefix($key);
        Log::channel('performance')->info('User cache cleared', ['user_id' => $userId]);
    }
    
    /**
     * Warm up cache with frequently used data
     */
    public function warmUpCache(): void
    {
        // Cache common transformations
        $commonTransformations = [
            'uppercase', 'lowercase', 'title', 'sentence',
            'camel', 'pascal', 'kebab', 'snake'
        ];
        
        // Pre-cache tool categories
        $categories = [
            'case-converters', 'encoders-decoders', 'formatters',
            'text-effects', 'generators', 'analyzers'
        ];
        
        foreach ($categories as $category) {
            // Trigger category caching through controller
            $this->cacheCategoryListing($category, []);
        }
        
        Log::channel('performance')->info('Cache warmed up');
    }
    
    /**
     * Generate cache key for transformation
     */
    private function generateTransformationKey(string $text, string $format): string
    {
        // Use hash for long text to keep key size manageable
        $textHash = strlen($text) > 100 
            ? md5($text) 
            : base64_encode($text);
            
        return self::PREFIX_TRANSFORMATION . $format . ':' . $textHash;
    }
    
    /**
     * Clear cache by prefix pattern
     */
    private function clearCacheByPrefix(string $prefix): void
    {
        // For database cache driver
        if (config('cache.default') === 'database') {
            \DB::table('cache')
                ->where('key', 'like', '%' . $prefix . '%')
                ->delete();
        }
        // For Redis
        elseif (config('cache.default') === 'redis') {
            $keys = \Redis::keys($prefix . '*');
            if (!empty($keys)) {
                \Redis::del($keys);
            }
        }
    }
    
    /**
     * Get cache statistics
     */
    public function getCacheStatistics(): array
    {
        $stats = [
            'driver' => config('cache.default'),
            'transformation_keys' => $this->countKeys(self::PREFIX_TRANSFORMATION),
            'tool_keys' => $this->countKeys(self::PREFIX_TOOL),
            'category_keys' => $this->countKeys(self::PREFIX_CATEGORY),
            'user_keys' => $this->countKeys(self::PREFIX_USER),
            'total_size' => $this->calculateCacheSize()
        ];
        
        return $stats;
    }
    
    /**
     * Count keys by prefix
     */
    private function countKeys(string $prefix): int
    {
        if (config('cache.default') === 'database') {
            return \DB::table('cache')
                ->where('key', 'like', '%' . $prefix . '%')
                ->count();
        }
        
        return 0;
    }
    
    /**
     * Calculate total cache size
     */
    private function calculateCacheSize(): string
    {
        if (config('cache.default') === 'database') {
            $size = \DB::table('cache')->sum(\DB::raw('LENGTH(value)'));
            return $this->formatBytes($size ?? 0);
        }
        
        return 'N/A';
    }
    
    /**
     * Format bytes to human readable
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
    
    /**
     * Implement cache stampede protection
     */
    public function preventStampede(string $key, int $ttl, callable $callback)
    {
        $value = Cache::get($key);
        $lockKey = $key . ':lock';
        
        if ($value === null) {
            // Try to acquire lock
            $acquired = Cache::add($lockKey, true, 30);
            
            if ($acquired) {
                try {
                    $value = $callback();
                    Cache::put($key, $value, $ttl);
                } finally {
                    Cache::forget($lockKey);
                }
            } else {
                // Wait for other process to populate cache
                $attempts = 0;
                while ($value === null && $attempts < 10) {
                    usleep(100000); // 100ms
                    $value = Cache::get($key);
                    $attempts++;
                }
            }
        }
        
        return $value;
    }
}
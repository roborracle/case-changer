<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;

class AnalyticsService
{
    protected Agent $agent;
    protected ?string $sessionId = null;
    protected ?string $userId = null;
    
    public function __construct()
    {
        $this->agent = new Agent();
        $this->initializeSession();
    }
    
    /**
     * Initialize or retrieve session
     */
    protected function initializeSession(): void
    {
        $this->sessionId = session()->getId() ?: Str::uuid()->toString();
        $this->userId = auth()->id() ?? null;
        
        $this->updateSession();
    }
    
    /**
     * Update session information
     */
    protected function updateSession(): void
    {
        try {
            DB::table('analytics_sessions')->updateOrInsert(
                ['session_id' => $this->sessionId],
                [
                    'user_id' => $this->userId,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'referrer_source' => $this->parseReferrerSource(),
                    'device_type' => $this->getDeviceType(),
                    'browser' => $this->agent->browser(),
                    'os' => $this->agent->platform(),
                    'country' => $this->getCountryCode(),
                    'updated_at' => Carbon::now()
                ]
            );
        } catch (\Exception $e) {
            Log::debug('Failed to update analytics session: ' . $e->getMessage());
        }
    }
    
    /**
     * Track generic event
     */
    public function trackEvent(string $eventType, array $eventData = []): void
    {
        try {
            DB::table('analytics_events')->insert([
                'user_id' => $this->userId,
                'session_id' => $this->sessionId,
                'event_type' => $eventType,
                'event_data' => json_encode($eventData),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => Carbon::now()
            ]);
            
            DB::table('analytics_sessions')
                ->where('session_id', $this->sessionId)
                ->increment('events_count');
                
            $this->updateDailyMetric('events', $eventType);
            
        } catch (\Exception $e) {
            Log::debug('Failed to track event: ' . $e->getMessage());
        }
    }
    
    /**
     * Track page view
     */
    public function trackPageView(string $url, ?string $title = null, ?string $referrer = null): void
    {
        try {
            DB::table('analytics_pageviews')->insert([
                'session_id' => $this->sessionId,
                'page_url' => $url,
                'page_title' => $title,
                'referrer' => $referrer ?? request()->header('referer'),
                'device_type' => $this->getDeviceType(),
                'browser' => $this->agent->browser(),
                'os' => $this->agent->platform(),
                'country' => $this->getCountryCode(),
                'created_at' => Carbon::now()
            ]);
            
            DB::table('analytics_sessions')
                ->where('session_id', $this->sessionId)
                ->increment('page_views');
                
            $this->trackEvent('page_view', [
                'url' => $url,
                'title' => $title
            ]);
            
            $this->updateDailyMetric('pageviews', $url);
            
        } catch (\Exception $e) {
            Log::debug('Failed to track page view: ' . $e->getMessage());
        }
    }
    
    /**
     * Track tool conversion
     */
    public function trackConversion(string $toolName, string $inputText, string $outputText, float $processingTime = 0): void
    {
        try {
            $metadata = [
                'input_preview' => substr($inputText, 0, 100),
                'output_preview' => substr($outputText, 0, 100),
                'transformation_type' => $this->categorizeTransformation($toolName)
            ];
            
            DB::table('analytics_conversions')->insert([
                'session_id' => $this->sessionId,
                'conversion_type' => 'tool_usage',
                'tool_used' => $toolName,
                'input_length' => strlen($inputText),
                'output_length' => strlen($outputText),
                'processing_time_ms' => $processingTime,
                'successful' => true,
                'metadata' => json_encode($metadata),
                'created_at' => Carbon::now()
            ]);
            
            $this->trackEvent('conversion', [
                'tool' => $toolName,
                'input_length' => strlen($inputText),
                'output_length' => strlen($outputText)
            ]);
            
            $this->updateDailyMetric('conversions', $toolName);
            
            Cache::forget('analytics:realtime');
            
        } catch (\Exception $e) {
            Log::debug('Failed to track conversion: ' . $e->getMessage());
        }
    }
    
    /**
     * Track performance metrics
     */
    public function trackPerformance(string $url, array $metrics): void
    {
        try {
            DB::table('analytics_performance')->insert([
                'page_url' => $url,
                'load_time' => $metrics['load_time'] ?? 0,
                'ttfb' => $metrics['ttfb'] ?? 0,
                'fcp' => $metrics['fcp'] ?? 0,
                'lcp' => $metrics['lcp'] ?? 0,
                'cls' => $metrics['cls'] ?? 0,
                'fid' => $metrics['fid'] ?? 0,
                'lighthouse_score' => $metrics['lighthouse_score'] ?? null,
                'session_id' => $this->sessionId,
                'created_at' => Carbon::now()
            ]);
            
            $this->trackEvent('performance', $metrics);
            
        } catch (\Exception $e) {
            Log::debug('Failed to track performance: ' . $e->getMessage());
        }
    }
    
    /**
     * Get real-time metrics
     */
    public function getRealTimeMetrics(): array
    {
        return Cache::remember('analytics:realtime', 60, function () {
            $now = Carbon::now();
            $fiveMinutesAgo = $now->copy()->subMinutes(5);
            
            return [
                'active_users' => DB::table('analytics_events')
                    ->where('created_at', '>=', $fiveMinutesAgo)
                    ->distinct('session_id')
                    ->count('session_id'),
                    
                'page_views_5min' => DB::table('analytics_pageviews')
                    ->where('created_at', '>=', $fiveMinutesAgo)
                    ->count(),
                    
                'conversions_5min' => DB::table('analytics_conversions')
                    ->where('created_at', '>=', $fiveMinutesAgo)
                    ->count(),
                    
                'top_pages' => DB::table('analytics_pageviews')
                    ->select('page_url', DB::raw('COUNT(*) as views'))
                    ->where('created_at', '>=', $fiveMinutesAgo)
                    ->groupBy('page_url')
                    ->orderByDesc('views')
                    ->limit(5)
                    ->get(),
                    
                'recent_conversions' => DB::table('analytics_conversions')
                    ->select('tool_used', 'created_at')
                    ->where('created_at', '>=', $fiveMinutesAgo)
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->get()
            ];
        });
    }
    
    /**
     * Get dashboard metrics
     */
    public function getDashboardMetrics(string $period = 'today'): array
    {
        $cacheKey = "analytics:dashboard:{$period}";
        
        return Cache::remember($cacheKey, 300, function () use ($period) {
            $dateRange = $this->getDateRange($period);
            
            return [
                'summary' => $this->getSummaryMetrics($dateRange),
                'charts' => $this->getChartData($dateRange),
                'top_tools' => $this->getTopTools($dateRange),
                'user_metrics' => $this->getUserMetrics($dateRange),
                'performance' => $this->getPerformanceMetrics($dateRange)
            ];
        });
    }
    
    /**
     * Get summary metrics
     */
    protected function getSummaryMetrics(array $dateRange): array
    {
        return [
            'total_users' => DB::table('analytics_sessions')
                ->whereBetween('started_at', $dateRange)
                ->distinct('user_id')
                ->count('user_id'),
                
            'total_sessions' => DB::table('analytics_sessions')
                ->whereBetween('started_at', $dateRange)
                ->count(),
                
            'total_pageviews' => DB::table('analytics_pageviews')
                ->whereBetween('created_at', $dateRange)
                ->count(),
                
            'total_conversions' => DB::table('analytics_conversions')
                ->whereBetween('created_at', $dateRange)
                ->count(),
                
            'avg_session_duration' => DB::table('analytics_sessions')
                ->whereBetween('started_at', $dateRange)
                ->avg('duration_seconds'),
                
            'bounce_rate' => $this->calculateBounceRate($dateRange)
        ];
    }
    
    /**
     * Get chart data for visualizations
     */
    protected function getChartData(array $dateRange): array
    {
        $days = Carbon::parse($dateRange[0])->diffInDays(Carbon::parse($dateRange[1]));
        $groupBy = $days > 31 ? 'DATE(created_at)' : 'HOUR(created_at)';
        
        return [
            'pageviews_trend' => DB::table('analytics_pageviews')
                ->select(DB::raw($groupBy . ' as period'), DB::raw('COUNT(*) as count'))
                ->whereBetween('created_at', $dateRange)
                ->groupBy('period')
                ->orderBy('period')
                ->get(),
                
            'conversions_trend' => DB::table('analytics_conversions')
                ->select(DB::raw($groupBy . ' as period'), DB::raw('COUNT(*) as count'))
                ->whereBetween('created_at', $dateRange)
                ->groupBy('period')
                ->orderBy('period')
                ->get(),
                
            'device_breakdown' => DB::table('analytics_sessions')
                ->select('device_type', DB::raw('COUNT(*) as count'))
                ->whereBetween('started_at', $dateRange)
                ->groupBy('device_type')
                ->get(),
                
            'browser_breakdown' => DB::table('analytics_sessions')
                ->select('browser', DB::raw('COUNT(*) as count'))
                ->whereBetween('started_at', $dateRange)
                ->groupBy('browser')
                ->limit(5)
                ->get()
        ];
    }
    
    /**
     * Get top performing tools
     */
    protected function getTopTools(array $dateRange): array
    {
        return DB::table('analytics_conversions')
            ->select('tool_used', 
                    DB::raw('COUNT(*) as usage_count'),
                    DB::raw('AVG(processing_time_ms) as avg_time'),
                    DB::raw('SUM(CASE WHEN successful = 1 THEN 1 ELSE 0 END) / COUNT(*) * 100 as success_rate'))
            ->whereBetween('created_at', $dateRange)
            ->groupBy('tool_used')
            ->orderByDesc('usage_count')
            ->limit(10)
            ->get()
            ->toArray();
    }
    
    /**
     * Get user behavior metrics
     */
    protected function getUserMetrics(array $dateRange): array
    {
        return [
            'new_vs_returning' => $this->getNewVsReturning($dateRange),
            'avg_pages_per_session' => DB::table('analytics_sessions')
                ->whereBetween('started_at', $dateRange)
                ->avg('page_views'),
            'geographic_distribution' => DB::table('analytics_sessions')
                ->select('country', DB::raw('COUNT(*) as count'))
                ->whereBetween('started_at', $dateRange)
                ->whereNotNull('country')
                ->groupBy('country')
                ->orderByDesc('count')
                ->limit(10)
                ->get()
        ];
    }
    
    /**
     * Get performance metrics
     */
    protected function getPerformanceMetrics(array $dateRange): array
    {
        return [
            'avg_load_time' => DB::table('analytics_performance')
                ->whereBetween('created_at', $dateRange)
                ->avg('load_time'),
                
            'avg_ttfb' => DB::table('analytics_performance')
                ->whereBetween('created_at', $dateRange)
                ->avg('ttfb'),
                
            'core_web_vitals' => [
                'lcp' => DB::table('analytics_performance')
                    ->whereBetween('created_at', $dateRange)
                    ->avg('lcp'),
                'fid' => DB::table('analytics_performance')
                    ->whereBetween('created_at', $dateRange)
                    ->avg('fid'),
                'cls' => DB::table('analytics_performance')
                    ->whereBetween('created_at', $dateRange)
                    ->avg('cls')
            ]
        ];
    }
    
    /**
     * Update daily aggregated metrics
     */
    protected function updateDailyMetric(string $metricType, string $dimension): void
    {
        try {
            DB::table('analytics_daily_metrics')->updateOrInsert(
                [
                    'date' => Carbon::today(),
                    'metric_type' => $metricType,
                    'dimension' => $dimension
                ],
                [
                    'value' => DB::raw('value + 1'),
                    'updated_at' => Carbon::now()
                ]
            );
        } catch (\Exception $e) {
            Log::debug('Failed to update daily metric: ' . $e->getMessage());
        }
    }
    
    /**
     * Helper: Get date range for period
     */
    protected function getDateRange(string $period): array
    {
        $end = Carbon::now();
        
        switch ($period) {
            case 'today':
                $start = Carbon::today();
                break;
            case 'yesterday':
                $start = Carbon::yesterday();
                $end = Carbon::today()->subSecond();
                break;
            case 'week':
                $start = Carbon::now()->subWeek();
                break;
            case 'month':
                $start = Carbon::now()->subMonth();
                break;
            case 'year':
                $start = Carbon::now()->subYear();
                break;
            default:
                $start = Carbon::today();
        }
        
        return [$start, $end];
    }
    
    /**
     * Helper: Calculate bounce rate
     */
    protected function calculateBounceRate(array $dateRange): float
    {
        $totalSessions = DB::table('analytics_sessions')
            ->whereBetween('started_at', $dateRange)
            ->count();
            
        $bouncedSessions = DB::table('analytics_sessions')
            ->whereBetween('started_at', $dateRange)
            ->where('page_views', '<=', 1)
            ->count();
            
        return $totalSessions > 0 ? round(($bouncedSessions / $totalSessions) * 100, 2) : 0;
    }
    
    /**
     * Helper: Get new vs returning users
     */
    protected function getNewVsReturning(array $dateRange): array
    {
        $total = DB::table('analytics_sessions')
            ->whereBetween('started_at', $dateRange)
            ->count();
            
        $returning = DB::table('analytics_sessions')
            ->whereBetween('started_at', $dateRange)
            ->whereNotNull('user_id')
            ->count();
            
        return [
            'new' => $total - $returning,
            'returning' => $returning
        ];
    }
    
    /**
     * Helper: Get device type
     */
    protected function getDeviceType(): string
    {
        if ($this->agent->isMobile()) {
            return 'mobile';
        } elseif ($this->agent->isTablet()) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }
    
    /**
     * Helper: Parse referrer source
     */
    protected function parseReferrerSource(): ?string
    {
        $referrer = request()->header('referer');
        if (!$referrer) {
            return 'direct';
        }
        
        $host = parse_url($referrer, PHP_URL_HOST);
        
        if (str_contains($host, 'google')) return 'google';
        if (str_contains($host, 'facebook')) return 'facebook';
        if (str_contains($host, 'twitter')) return 'twitter';
        if (str_contains($host, 'linkedin')) return 'linkedin';
        
        return 'other';
    }
    
    /**
     * Helper: Get country code (simplified)
     */
    protected function getCountryCode(): ?string
    {
        return 'US';
    }
    
    /**
     * Helper: Categorize transformation type
     */
    protected function categorizeTransformation(string $toolName): string
    {
        if (str_contains($toolName, 'case')) return 'case_conversion';
        if (str_contains($toolName, 'encode') || str_contains($toolName, 'decode')) return 'encoding';
        if (str_contains($toolName, 'format')) return 'formatting';
        
        return 'other';
    }
}
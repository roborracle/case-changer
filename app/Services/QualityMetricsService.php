<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class QualityMetricsService
{
    private ValidationService $validationService;
    private TransformationService $transformationService;
    
    public function __construct()
    {
        $this->transformationService = new TransformationService();
        $this->validationService = new ValidationService($this->transformationService);
    }
    
    /**
     * Get comprehensive metrics for a category
     */
    public function getCategoryMetrics(string $category): array
    {
        return Cache::remember("category_metrics_{$category}", 300, function () use ($category) {
            $tools = $this->getToolsInCategory($category);
            
            if (empty($tools)) {
                return $this->getEmptyMetrics();
            }
            
            $metrics = [
                'category' => $category,
                'total_tools' => count($tools),
                'reliability_score' => 0,
                'average_speed' => 0,
                'total_usage' => 0,
                'error_rate' => 0,
                'last_validation' => null,
                'tools_passed' => 0,
                'tools_failed' => 0,
                'tools_warning' => 0,
                'performance_trend' => [],
                'usage_distribution' => [],
                'top_performers' => [],
                'needs_attention' => []
            ];
            
            $validationData = Cache::get('validation:latest');
            $totalSpeed = 0;
            $totalErrors = 0;
            $totalTests = 0;
            
            foreach ($tools as $toolId) {
                $toolMetrics = $this->getToolMetrics($toolId);
                
                $metrics['total_usage'] += $toolMetrics['usage_count'];
                $totalSpeed += $toolMetrics['avg_speed'];
                
                if ($toolMetrics['validation_status'] === 'passed') {
                    $metrics['tools_passed']++;
                } elseif ($toolMetrics['validation_status'] === 'failed') {
                    $metrics['tools_failed']++;
                } else {
                    $metrics['tools_warning']++;
                }
                
                if ($validationData && isset($validationData['tools'][$toolId])) {
                    $toolResult = $validationData['tools'][$toolId];
                    $totalErrors += count($toolResult['errors'] ?? []);
                    $totalTests += count($toolResult['tests'] ?? []);
                }
                
                if ($toolMetrics['reliability_score'] >= 95) {
                    $metrics['top_performers'][] = [
                        'id' => $toolId,
                        'name' => $this->transformationService->getTransformations()[$toolId] ?? $toolId,
                        'score' => $toolMetrics['reliability_score']
                    ];
                }
                
                if ($toolMetrics['reliability_score'] < 80 || $toolMetrics['error_rate'] > 5) {
                    $metrics['needs_attention'][] = [
                        'id' => $toolId,
                        'name' => $this->transformationService->getTransformations()[$toolId] ?? $toolId,
                        'issue' => $toolMetrics['error_rate'] > 5 ? 'High error rate' : 'Low reliability'
                    ];
                }
            }
            
            $toolCount = count($tools);
            $metrics['average_speed'] = $toolCount > 0 ? round($totalSpeed / $toolCount, 2) : 0;
            $metrics['error_rate'] = $totalTests > 0 ? round(($totalErrors / $totalTests) * 100, 2) : 0;
            $metrics['reliability_score'] = $this->calculateReliabilityScore($metrics);
            
            $metrics['performance_trend'] = $this->getPerformanceTrend($category);
            
            $metrics['usage_distribution'] = $this->getUsageDistribution($tools);
            
            $metrics['last_validation'] = $validationData['timestamp'] ?? null;
            
            usort($metrics['top_performers'], fn($a, $b) => $b['score'] <=> $a['score']);
            $metrics['top_performers'] = array_slice($metrics['top_performers'], 0, 5);
            
            return $metrics;
        });
    }
    
    /**
     * Get metrics for a specific tool
     */
    public function getToolMetrics(string $toolId): array
    {
        return Cache::remember("tool_metrics_{$toolId}", 300, function () use ($toolId) {
            $metrics = [
                'tool_id' => $toolId,
                'validation_status' => 'unknown',
                'reliability_score' => 0,
                'avg_speed' => 0,
                'max_speed' => 0,
                'usage_count' => 0,
                'error_rate' => 0,
                'last_validated' => null,
                'test_results' => [],
                'performance_history' => []
            ];
            
            $validationData = Cache::get('validation:latest');
            if ($validationData && isset($validationData['tools'][$toolId])) {
                $toolResult = $validationData['tools'][$toolId];
                
                $metrics['validation_status'] = $toolResult['status'];
                $metrics['avg_speed'] = $toolResult['execution_time_ms'] ?? 0;
                $metrics['last_validated'] = $toolResult['timestamp'];
                
                $totalTests = count($toolResult['tests'] ?? []);
                $passedTests = count(array_filter($toolResult['tests'] ?? [], fn($test) => $test['passed']));
                $metrics['reliability_score'] = $totalTests > 0 ? round(($passedTests / $totalTests) * 100, 2) : 0;
                
                $errors = count($toolResult['errors'] ?? []);
                $metrics['error_rate'] = $totalTests > 0 ? round(($errors / $totalTests) * 100, 2) : 0;
                
                $metrics['test_results'] = $toolResult['tests'] ?? [];
            }
            
            try {
                if (DB::getSchemaBuilder()->hasTable('transformations_usage')) {
                    $usage = DB::table('transformations_usage')
                        ->where('tool_name', $toolId)
                        ->where('created_at', '>=', Carbon::now()->subDays(30))
                        ->count();
                    
                    $metrics['usage_count'] = $usage;
                    
                    $avgTime = DB::table('transformations_usage')
                        ->where('tool_name', $toolId)
                        ->where('created_at', '>=', Carbon::now()->subDays(30))
                        ->avg('response_time_ms');
                    
                    if ($avgTime) {
                        $metrics['avg_speed'] = round($avgTime, 2);
                    }
                }
            } catch (\Exception $e) {
                Log::debug('Could not fetch usage metrics: ' . $e->getMessage());
            }
            
            try {
                if (DB::getSchemaBuilder()->hasTable('validation_audits')) {
                    $history = DB::table('validation_audits')
                        ->where('tool_name', $toolId)
                        ->where('created_at', '>=', Carbon::now()->subDays(7))
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get(['validation_status', 'execution_time_ms', 'created_at']);
                    
                    $metrics['performance_history'] = $history->map(function ($record) {
                        return [
                            'status' => $record->validation_status,
                            'speed' => $record->execution_time_ms,
                            'timestamp' => $record->created_at
                        ];
                    })->toArray();
                }
            } catch (\Exception $e) {
                Log::debug('Could not fetch performance history: ' . $e->getMessage());
            }
            
            return $metrics;
        });
    }
    
    /**
     * Get tools in a specific category
     */
    private function getToolsInCategory(string $category): array
    {
        $transformations = $this->transformationService->getTransformations();
        $categoryTools = [];
        
        foreach ($transformations as $toolId => $toolName) {
            $toolCategory = $this->transformationService->getToolCategory($toolId);
            if ($toolCategory === $category) {
                $categoryTools[] = $toolId;
            }
        }
        
        return $categoryTools;
    }
    
    /**
     * Calculate overall reliability score for a category
     */
    private function calculateReliabilityScore(array $metrics): float
    {
        $score = 100;
        
        $score -= $metrics['tools_failed'] * 10;
        
        $score -= $metrics['tools_warning'] * 5;
        
        if ($metrics['error_rate'] > 5) {
            $score -= min($metrics['error_rate'], 20);
        }
        
        if ($metrics['average_speed'] > 100) {
            $score -= min(($metrics['average_speed'] - 100) / 10, 10);
        }
        
        return max(0, round($score, 2));
    }
    
    /**
     * Get performance trend data for charts
     */
    private function getPerformanceTrend(string $category): array
    {
        $trend = [];
        
        try {
            if (DB::getSchemaBuilder()->hasTable('validation_audits')) {
                $tools = $this->getToolsInCategory($category);
                
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $dateStr = $date->format('Y-m-d');
                    
                    $avgTime = DB::table('validation_audits')
                        ->whereIn('tool_name', $tools)
                        ->whereDate('created_at', $date)
                        ->avg('execution_time_ms');
                    
                    $passRate = DB::table('validation_audits')
                        ->whereIn('tool_name', $tools)
                        ->whereDate('created_at', $date)
                        ->where('validation_status', 'passed')
                        ->count();
                    
                    $totalTests = DB::table('validation_audits')
                        ->whereIn('tool_name', $tools)
                        ->whereDate('created_at', $date)
                        ->count();
                    
                    $trend[] = [
                        'date' => $dateStr,
                        'avg_speed' => round($avgTime ?? 0, 2),
                        'pass_rate' => $totalTests > 0 ? round(($passRate / $totalTests) * 100, 2) : 0
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::debug('Could not fetch performance trend: ' . $e->getMessage());
        }
        
        return $trend;
    }
    
    /**
     * Get usage distribution for pie chart
     */
    private function getUsageDistribution(array $tools): array
    {
        $distribution = [];
        
        try {
            if (DB::getSchemaBuilder()->hasTable('transformations_usage')) {
                foreach ($tools as $toolId) {
                    $count = DB::table('transformations_usage')
                        ->where('tool_name', $toolId)
                        ->where('created_at', '>=', Carbon::now()->subDays(30))
                        ->count();
                    
                    if ($count > 0) {
                        $distribution[] = [
                            'tool' => $this->transformationService->getTransformations()[$toolId] ?? $toolId,
                            'count' => $count
                        ];
                    }
                }
                
                usort($distribution, fn($a, $b) => $b['count'] <=> $a['count']);
                $distribution = array_slice($distribution, 0, 10);
            }
        } catch (\Exception $e) {
            Log::debug('Could not fetch usage distribution: ' . $e->getMessage());
        }
        
        return $distribution;
    }
    
    /**
     * Get empty metrics structure
     */
    private function getEmptyMetrics(): array
    {
        return [
            'category' => '',
            'total_tools' => 0,
            'reliability_score' => 0,
            'average_speed' => 0,
            'total_usage' => 0,
            'error_rate' => 0,
            'last_validation' => null,
            'tools_passed' => 0,
            'tools_failed' => 0,
            'tools_warning' => 0,
            'performance_trend' => [],
            'usage_distribution' => [],
            'top_performers' => [],
            'needs_attention' => []
        ];
    }
    
    /**
     * Refresh all metrics caches
     */
    public function refreshMetrics(): void
    {
        $categories = ['Case Conversion', 'Programming Cases', 'Encoding & Decoding', 
                      'Text Formatting', 'Text Generators', 'Text Analysis', 
                      'Style Guides', 'Social Media'];
        
        foreach ($categories as $category) {
            Cache::forget("category_metrics_{$category}");
        }
        
        $transformations = $this->transformationService->getTransformations();
        foreach ($transformations as $toolId => $toolName) {
            Cache::forget("tool_metrics_{$toolId}");
        }
    }
}
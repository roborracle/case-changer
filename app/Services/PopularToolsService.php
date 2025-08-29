<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\ValidationService;
use App\Services\TransformationService;
use Carbon\Carbon;

class PopularToolsService
{
    private TransformationService $transformationService;
    private ValidationService $validationService;
    
    /**
     * Default top 10 most popular tools
     */
    private array $defaultTopTools = [
        'upper-case',
        'lower-case', 
        'title-case',
        'camel-case',
        'snake-case',
        'kebab-case',
        'sentence-case',
        'reverse',
        'base64-encode',
        'lorem-ipsum'
    ];
    
    public function __construct()
    {
        $this->transformationService = new TransformationService();
        $this->validationService = new ValidationService($this->transformationService);
    }
    
    /**
     * Get top 10 most popular tools with validation status
     */
    public function getTopToolsWithValidation(int $limit = 10): array
    {
        return Cache::remember('popular_tools_with_validation', 300, function () use ($limit) {
            $tools = $this->getPopularTools($limit);
            $transformations = $this->transformationService->getTransformations();
            
            $toolsWithData = [];
            foreach ($tools as $index => $toolId) {
                if (!isset($transformations[$toolId])) {
                    continue;
                }
                
                $validationStatus = $this->getToolValidationStatus($toolId);
                $cluster = $this->getToolCluster($toolId);
                
                $toolsWithData[] = [
                    'id' => $toolId,
                    'name' => $transformations[$toolId],
                    'description' => $this->getToolDescription($toolId),
                    'icon' => $this->getToolIcon($toolId),
                    'url' => '/tools/' . $toolId,
                    'category' => $cluster,
                    'validation' => $validationStatus,
                    'position' => $index + 1
                ];
            }
            
            return $toolsWithData;
        });
    }
    
    /**
     * Get popular tools based on usage or defaults
     */
    public function getPopularTools(int $limit = 10): array
    {
        $popularFromStats = $this->getPopularFromUsageStats($limit);
        
        if (!empty($popularFromStats)) {
            return $popularFromStats;
        }
        
        return array_slice($this->defaultTopTools, 0, $limit);
    }
    
    /**
     * Get popular tools from usage statistics
     */
    private function getPopularFromUsageStats(int $limit): array
    {
        try {
            if (DB::getSchemaBuilder()->hasTable('transformations_usage')) {
                return DB::table('transformations_usage')
                    ->select('tool_name')
                    ->where('created_at', '>=', Carbon::now()->subDays(30))
                    ->groupBy('tool_name')
                    ->orderByRaw('COUNT(*) DESC')
                    ->limit($limit)
                    ->pluck('tool_name')
                    ->toArray();
            }
        } catch (\Exception $e) {
            Log::info('Could not fetch usage statistics: ' . $e->getMessage());
        }
        
        return [];
    }
    
    /**
     * Get validation status for a tool
     */
    public function getToolValidationStatus(string $toolId): array
    {
        $cachedValidation = Cache::get('validation:latest');
        
        if ($cachedValidation && isset($cachedValidation['tools'][$toolId])) {
            $toolResult = $cachedValidation['tools'][$toolId];
            $timestamp = $cachedValidation['timestamp'] ?? null;
            
            return $this->formatValidationStatus($toolResult['status'] ?? 'unknown', $timestamp);
        }
        
        try {
            $lastValidation = DB::table('test_harness_results')
                ->where('tool_name', $toolId)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($lastValidation) {
                return $this->formatValidationStatus(
                    $lastValidation->status,
                    $lastValidation->created_at
                );
            }
        } catch (\Exception $e) {
            Log::debug('Could not fetch validation status: ' . $e->getMessage());
        }
        
        return [
            'status' => 'never',
            'badge' => 'gray',
            'icon' => 'clock',
            'label' => 'Not Validated',
            'timestamp' => null,
            'time_ago' => 'Never',
            'tooltip' => 'This tool has not been validated yet'
        ];
    }
    
    /**
     * Format validation status for display
     */
    private function formatValidationStatus(string $status, ?string $timestamp): array
    {
        if (!$timestamp) {
            return [
                'status' => 'never',
                'badge' => 'gray',
                'icon' => 'clock',
                'label' => 'Not Validated',
                'timestamp' => null,
                'time_ago' => 'Never',
                'tooltip' => 'This tool has not been validated yet'
            ];
        }
        
        $validatedAt = Carbon::parse($timestamp);
        $hoursAgo = $validatedAt->diffInHours();
        
        if ($status === 'failed') {
            return [
                'status' => 'failed',
                'badge' => 'red',
                'icon' => 'x',
                'label' => 'Failed',
                'timestamp' => $validatedAt->toIso8601String(),
                'time_ago' => $validatedAt->diffForHumans(),
                'tooltip' => 'Validation failed ' . $validatedAt->diffForHumans()
            ];
        }
        
        if ($hoursAgo <= 6) {
            return [
                'status' => 'passed',
                'badge' => 'green',
                'icon' => 'check',
                'label' => 'Validated',
                'timestamp' => $validatedAt->toIso8601String(),
                'time_ago' => $validatedAt->diffForHumans(),
                'tooltip' => 'Successfully validated ' . $validatedAt->diffForHumans()
            ];
        } elseif ($hoursAgo <= 24) {
            return [
                'status' => 'recent',
                'badge' => 'yellow',
                'icon' => 'warning',
                'label' => 'Recent',
                'timestamp' => $validatedAt->toIso8601String(),
                'time_ago' => $validatedAt->diffForHumans(),
                'tooltip' => 'Validated ' . $validatedAt->diffForHumans()
            ];
        } else {
            return [
                'status' => 'stale',
                'badge' => 'orange',
                'icon' => 'alert',
                'label' => 'Stale',
                'timestamp' => $validatedAt->toIso8601String(),
                'time_ago' => $validatedAt->diffForHumans(),
                'tooltip' => 'Last validated ' . $validatedAt->diffForHumans() . ' - needs refresh'
            ];
        }
    }
    
    /**
     * Get tool description
     */
    private function getToolDescription(string $toolId): string
    {
        $descriptions = [
            'upper-case' => 'Convert to UPPERCASE',
            'lower-case' => 'Convert to lowercase',
            'title-case' => 'Capitalize Each Word',
            'camel-case' => 'Convert to camelCase',
            'snake-case' => 'Convert to snake_case',
            'kebab-case' => 'Convert to kebab-case',
            'sentence-case' => 'Capitalize first letter',
            'reverse' => 'Reverse text characters',
            'base64-encode' => 'Encode to Base64',
            'lorem-ipsum' => 'Generate placeholder text',
            'pascal-case' => 'Convert to PascalCase',
            'constant-case' => 'Convert to CONSTANT_CASE',
            'url-encode' => 'Encode for URLs',
            'password-generator' => 'Generate secure passwords',
            'uuid-generator' => 'Generate unique IDs'
        ];
        
        return $descriptions[$toolId] ?? 'Transform your text';
    }
    
    /**
     * Get tool icon/emoji
     */
    private function getToolIcon(string $toolId): string
    {
        $icons = [
            'upper-case' => '🔠',
            'lower-case' => '🔡',
            'title-case' => '📝',
            'camel-case' => '🐫',
            'snake-case' => '🐍',
            'kebab-case' => '🥙',
            'sentence-case' => '📄',
            'reverse' => '🔄',
            'base64-encode' => '🔐',
            'lorem-ipsum' => '📜',
            'pascal-case' => '🏔️',
            'constant-case' => '📢',
            'url-encode' => '🔗',
            'password-generator' => '🔑',
            'uuid-generator' => '🆔'
        ];
        
        return $icons[$toolId] ?? '✨';
    }
    
    /**
     * Get tool cluster/category
     */
    private function getToolCluster(string $toolId): string
    {
        $clusters = [
            'upper-case' => 'Case Conversion',
            'lower-case' => 'Case Conversion',
            'title-case' => 'Case Conversion',
            'camel-case' => 'Programming Cases',
            'snake-case' => 'Programming Cases',
            'kebab-case' => 'Programming Cases',
            'pascal-case' => 'Programming Cases',
            'constant-case' => 'Programming Cases',
            'sentence-case' => 'Text Formatting',
            'reverse' => 'Text Effects',
            'base64-encode' => 'Encoding',
            'lorem-ipsum' => 'Generators',
            'url-encode' => 'Encoding',
            'password-generator' => 'Generators',
            'uuid-generator' => 'Generators'
        ];
        
        return $clusters[$toolId] ?? 'Text Tools';
    }
    
    /**
     * Get all validation statuses for dashboard
     */
    public function getAllValidationStatuses(): array
    {
        $transformations = $this->transformationService->getTransformations();
        $statuses = [];
        
        foreach ($transformations as $toolId => $toolName) {
            $statuses[$toolId] = $this->getToolValidationStatus($toolId);
        }
        
        return $statuses;
    }
    
    /**
     * Refresh validation cache
     */
    public function refreshValidationCache(): void
    {
        Cache::forget('popular_tools_with_validation');
        Cache::forget('validation:latest');
    }
}
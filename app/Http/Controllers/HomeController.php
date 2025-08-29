<?php

namespace App\Http\Controllers;

use App\Services\SchemaService;
use App\Services\PopularToolsService;
use App\Http\Controllers\ConversionController;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected SchemaService $schemaService;
    protected PopularToolsService $popularToolsService;

    public function __construct(SchemaService $schemaService)
    {
        $this->schemaService = $schemaService;
        $this->popularToolsService = new PopularToolsService();
    }

    public function index()
    {
        $topCategories = $this->getTopCategories();
        
        $schemaData = $this->schemaService->generateWebApplicationSchema();
        
        return view('welcome', [
            'topCategories' => $topCategories,
            'schemaData' => json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        ]);
    }
    
    /**
     * Get the top 10 most important categories
     */
    private function getTopCategories()
    {
        $categoryKeys = [
            'case-conversions',
            'developer-formats',
            'code-data-tools',
            'text-analysis',
            'creative-formats',
            'business-formats',
            'social-media-formats',
            'academic-styles',
            'journalistic-styles',
            'generators'
        ];
        
        $categories = [];
        $convController = new ConversionController($this->schemaService);
        $allCategories = $convController->categories;
        
        foreach ($categoryKeys as $key) {
            if (isset($allCategories[$key])) {
                $categories[] = [
                    'slug' => $key,
                    'title' => $allCategories[$key]['title'],
                    'description' => $allCategories[$key]['description'],
                    'icon' => $this->getCategoryIcon($key),
                    'tool_count' => count($allCategories[$key]['tools']),
                    'url' => route('conversions.category', $key)
                ];
            }
        }
        
        return $categories;
    }
    
    /**
     * Get icon for category
     */
    private function getCategoryIcon($category)
    {
        $icons = [
            'case-conversions' => '🔤',
            'developer-formats' => '💻',
            'code-data-tools' => '🔧',
            'text-analysis' => '📊',
            'creative-formats' => '🎨',
            'business-formats' => '💼',
            'social-media-formats' => '📱',
            'academic-styles' => '🎓',
            'journalistic-styles' => '📰',
            'generators' => '⚡'
        ];
        
        return $icons[$category] ?? '📝';
    }
    
    /**
     * Get validation status for all tools (API endpoint)
     */
    public function validationStatus()
    {
        $statuses = $this->popularToolsService->getAllValidationStatuses();
        
        $summary = [
            'total' => count($statuses),
            'passed' => 0,
            'failed' => 0,
            'warning' => 0,
            'never' => 0
        ];
        
        foreach ($statuses as $status) {
            switch ($status['status']) {
                case 'passed':
                    $summary['passed']++;
                    break;
                case 'failed':
                    $summary['failed']++;
                    break;
                case 'recent':
                case 'stale':
                    $summary['warning']++;
                    break;
                case 'never':
                    $summary['never']++;
                    break;
            }
        }
        
        $summary['health'] = $summary['failed'] === 0 ? 'operational' : 'degraded';
        $summary['lastCheck'] = Cache::get('validation:latest')['timestamp'] ?? null;
        
        return response()->json([
            'data' => $statuses,
            'summary' => $summary,
            'timestamp' => now()->toIso8601String(),
            'error' => null
        ]);
    }
}

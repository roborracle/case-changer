<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TransformationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransformationApiController extends Controller
{
    protected $transformationService;

    public function __construct(TransformationService $transformationService)
    {
        $this->transformationService = $transformationService;
    }

    /**
     * Handle transformation request via API
     */
    public function transform(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:10000',
            'transformation' => 'required|string',
        ]);

        try {
            $output = $this->transformationService->transform(
                $validated['text'],
                $validated['transformation']
            );

            return response()->json([
                'success' => true,
                'output' => $output,
                'transformation' => $validated['transformation'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Transformation failed',
            ], 422);
        }
    }

    /**
     * Get available transformations
     */
    public function transformations(): JsonResponse
    {
        return response()->json([
            'transformations' => $this->transformationService->getTransformations(),
        ]);
    }

    /**
     * Get all categories with their tools
     */
    public function categories(): JsonResponse
    {
        $categoriesConfig = config('categories.categories', []);
        $tools = config('tools');
        
        $result = [];
        
        foreach ($categoriesConfig as $category) {
            $categorySlug = $category['slug'] ?? '';
            
            $categoryData = [
                'slug' => $categorySlug,
                'name' => $category['name'] ?? $category['title'] ?? ucfirst(str_replace('-', ' ', $categorySlug)),
                'description' => $category['description'] ?? '',
                'icon' => $category['icon'] ?? '',
                'tools' => []
            ];
            
            // Get tools for this category
            if (isset($tools[$categorySlug])) {
                foreach ($tools[$categorySlug] as $toolSlug => $tool) {
                    $categoryData['tools'][] = [
                        'slug' => $toolSlug,
                        'name' => $tool['name'] ?? $tool['title'] ?? ucfirst(str_replace('-', ' ', $toolSlug)),
                        'description' => $tool['description'] ?? '',
                        'type' => $tool['type'] ?? 'transformation'
                    ];
                }
            }
            
            $result[] = $categoryData;
        }
        
        return response()->json([
            'data' => $result
        ]);
    }
}
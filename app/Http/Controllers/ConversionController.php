<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SchemaService;
use App\Services\ToolService;

class ConversionController extends Controller
{
    protected SchemaService $schemaService;
    protected ToolService $toolService;

    public function __construct(SchemaService $schemaService, ToolService $toolService)
    {
        $this->schemaService = $schemaService;
        $this->toolService = $toolService;
    }


    /**
     * Display the main categories index
     */
    public function index()
    {
        $breadcrumbs = $this->schemaService->generateBreadcrumbSchema([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'All Tools']
        ]);

        // Get categories with tools
        $categories = $this->toolService->getCategoriesWithTools();

        return view('conversions.index', [
            'categories' => $categories,
            'schemaData' => $breadcrumbs,
            'totalTools' => $this->toolService->getTotalToolCount()
        ]);
    }

    /**
     * Display a specific category page
     */
    public function category($category)
    {
        $categoryData = $this->toolService->getCategoryWithTools($category);
        
        if (!$categoryData) {
            abort(404);
        }

        $schemaData = $this->schemaService->getCategorySchemas($category, $categoryData);

        return view('conversions.category', [
            'category' => $categoryData,
            'categorySlug' => $category,
            'categoryData' => $categoryData,
            'tools' => $categoryData['tools'] ?? [],
            'allCategories' => $this->toolService->getCategoriesWithTools(),
            'schemaData' => $schemaData
        ]);
    }

    /**
     * Display a specific conversion tool page
     */
    public function tool($category, $tool)
    {
        $toolData = $this->toolService->getTool($category, $tool);
        $categoryData = $this->toolService->getCategoryWithTools($category);
        
        if (!$toolData || !$categoryData) {
            abort(404);
        }

        $schemaData = $this->schemaService->getToolSchemas(
            $category,
            $tool,
            $categoryData,
            $toolData
        );

        return view('conversions.tool', [
            'category' => $category,
            'tool' => $tool,
            'categoryData' => $categoryData,
            'toolData' => $toolData,
            'allCategories' => $this->toolService->getCategoriesWithTools(),
            'schemaData' => $schemaData
        ]);
    }

    /**
     * Get category data for API
     */
    public function getCategoryData($category)
    {
        $categoryData = $this->toolService->getCategoryWithTools($category);
        if (!$categoryData) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json($categoryData);
    }

    /**
     * Get all categories for sitemap
     */
    public function getAllCategories()
    {
        return response()->json($this->toolService->getCategoriesWithTools());
    }
}
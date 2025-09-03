<?php

namespace App\Http\Controllers;

use App\Services\SchemaService;
use App\Http\Controllers\ConversionController;

class HomeController extends Controller
{
    protected SchemaService $schemaService;

    public function __construct(SchemaService $schemaService)
    {
        $this->schemaService = $schemaService;
    }

    public function index()
    {
        $schemaData = $this->schemaService->getHomepageSchemas();
        
        // Get all tools for the selector
        $allTools = $this->getAllTools();
        
        // Define popular tools for quick access
        $popularTools = [
            ['id' => 'uppercase', 'name' => 'UPPERCASE', 'icon' => 'A'],
            ['id' => 'lowercase', 'name' => 'lowercase', 'icon' => 'a'],
            ['id' => 'title-case', 'name' => 'Title Case', 'icon' => 'Aa'],
            ['id' => 'camel-case', 'name' => 'camelCase', 'icon' => 'cC'],
            ['id' => 'snake-case', 'name' => 'snake_case', 'icon' => 's_c'],
            ['id' => 'kebab-case', 'name' => 'kebab-case', 'icon' => 'k-c'],
        ];
        
        return view('home', [
            'schemaData' => $schemaData,
            'allTools' => $allTools,
            'popularTools' => $popularTools
        ]);
    }
    
    private function getAllTools()
    {
        // Get categories from ConversionController (in production, this would be from a service)
        $controller = app(ConversionController::class);
        return $controller->getAllCategories();
    }
}
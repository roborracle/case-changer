<?php

namespace App\Http\Controllers;

use App\Services\SchemaService;

class HomeController extends Controller
{
    protected SchemaService $schemaService;

    public function __construct(SchemaService $schemaService)
    {
        $this->schemaService = $schemaService;
    }

    public function index()
    {
        $schemaData = $this->schemaService->generateHomepageSchema();
        
        return view('welcome', [
            'schemaData' => $schemaData
        ]);
    }
}
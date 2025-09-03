<?php

// WHY THIS FILE EXISTS: To handle the user input from the main form, orchestrate the text transformation, and pass the results back to the original view, preserving the UI.
// WHAT THIS FILE MUST NEVER DO: Contain complex business logic or deviate from the "request -> service -> response" pattern.
// SUCCESS DEFINITION: This file is successful if it seamlessly replaces the functionality of the old Livewire component without altering the user interface.

namespace App\Http\Controllers;

use App\Services\TransformationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransformationController extends Controller
{
    protected $transformationService;

    public function __construct(TransformationService $transformationService)
    {
        $this->transformationService = $transformationService;
    }

    /**
     * Handle the transformation request from the form submission.
     * This single method will replace the Livewire component's functionality.
     */
    public function transform(Request $request): View
    {
        $inputText = '';
        $outputText = '';
        $transformation = 'upper-case'; // Default transformation

        // Only process if it's a POST request with input
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'input' => 'required|string|max:10000',
                'transformation' => 'required|string',
            ]);
            
            $inputText = $validated['input'];
            $transformation = $validated['transformation'];
            $outputText = $this->transformationService->transform($inputText, $transformation);
        }

        // Get categories from config
        $categories = config('categories.categories');
        $featuredCategories = config('categories.featured_categories', []);
        
        // Get only featured categories for homepage
        $featured = [];
        foreach ($featuredCategories as $slug) {
            if (isset($categories[$slug])) {
                $featured[$slug] = $categories[$slug];
            }
        }

        // Return the view with all necessary data
        return view('home', [
            'input' => $inputText,
            'output' => $outputText,
            'selectedTransformation' => $transformation,
            'transformations' => $this->transformationService->getTransformations(),
            'categories' => $categories,
            'featuredCategories' => $featured,
        ]);
    }
}

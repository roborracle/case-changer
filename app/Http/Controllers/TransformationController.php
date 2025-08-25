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
        $inputText = $request->input('input', '');
        $transformation = $request->input('transformation', 'upper-case'); // Default to a safe value

        $outputText = '';
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'input' => 'required|string|max:10000',
                'transformation' => 'required|string', // Validation will be more robust later
            ]);
            $outputText = $this->transformationService->transform($validated['input'], $validated['transformation']);
        }

        // We return the 'home' view, passing all the necessary data to render the form and the result.
        return view('home', [
            'input' => $inputText,
            'output' => $outputText,
            'selectedTransformation' => $transformation,
            'transformations' => $this->transformationService->getTransformations(),
        ]);
    }
}

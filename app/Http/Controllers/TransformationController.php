<?php


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

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'input' => 'required|string|max:10000',
                'transformation' => 'required|string',
            ]);
            
            $inputText = $validated['input'];
            $transformation = $validated['transformation'];
            $outputText = $this->transformationService->transform($inputText, $transformation);
        }

        return view('home', [
            'input' => $inputText,
            'output' => $outputText,
            'selectedTransformation' => $transformation,
            'transformations' => $this->transformationService->getTransformations(),
        ]);
    }
}

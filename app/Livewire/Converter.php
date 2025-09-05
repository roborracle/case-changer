<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;
use App\Services\PlaceholderService;

class Converter extends Component
{
    public string $inputText = '';
    public string $outputText = '';
    public array $popularTools = [];
    public ?string $selectedTransformation = null;
    public string $placeholderText = 'Enter or paste your text here to transform it';
    public ?string $styleGuide = null;
    
    protected PlaceholderService $placeholderService;

    public function mount()
    {
        $this->placeholderService = new PlaceholderService();
        $this->popularTools = [
            ['key' => 'upper-case', 'label' => 'UPPERCASE'],
            ['key' => 'lower-case', 'label' => 'lowercase'],
            ['key' => 'title-case', 'label' => 'Title Case'],
            ['key' => 'sentence-case', 'label' => 'Sentence Case'],
            ['key' => 'camel-case', 'label' => 'camelCase'],
            ['key' => 'pascal-case', 'label' => 'PascalCase'],
            ['key' => 'snake-case', 'label' => 'snake_case'],
            ['key' => 'kebab-case', 'label' => 'kebab-case'],
        ];
    }

    public function transform(string $type, ?string $styleGuide = null)
    {
        $this->selectedTransformation = $type;
        $this->styleGuide = $styleGuide;
        
        // Update placeholder based on transformation
        $this->placeholderText = $this->placeholderService->getPlaceholder($type, $styleGuide);
        
        if ($this->inputText) {
            $transformationService = new TransformationService();
            $this->outputText = $transformationService->transform($this->inputText, $type, $styleGuide);
        } else {
            $this->outputText = '';
        }
    }
    
    public function setStyleGuide(string $styleGuide)
    {
        $this->styleGuide = $styleGuide;
        $this->placeholderText = $this->placeholderService->getPlaceholder('title-case', $styleGuide);
        
        if ($this->inputText) {
            $this->transform('title-case', $styleGuide);
        }
    }
    
    public function updatePlaceholder(string $transformation)
    {
        $this->selectedTransformation = $transformation;
        $this->placeholderText = $this->placeholderService->getPlaceholder($transformation, $this->styleGuide);
        
        // Automatically transform if there's input text
        if ($this->inputText) {
            $this->transform($transformation, $this->styleGuide);
        }
    }

    public function loadExample()
    {
        $this->inputText = 'Hello World - This is a Sample Text';
        $this->outputText = '';
        $this->selectedTransformation = null;
    }

    public function clearText()
    {
        $this->inputText = '';
        $this->outputText = '';
        $this->selectedTransformation = null;
    }


    /**
     * Clear output when input is cleared
     */
    public function updatedInputText()
    {
        if (!$this->inputText) {
            $this->outputText = '';
        }
    }

    public function render()
    {
        return view('livewire.converter');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;

class Converter extends Component
{
    public string $inputText = '';
    public string $outputText = '';
    public array $popularTools = [];
    public ?string $selectedTransformation = null;

    public function mount()
    {
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

    public function transform(string $type)
    {
        $this->selectedTransformation = $type;
        $transformationService = new TransformationService();
        $this->outputText = $transformationService->transform($this->inputText, $type);
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

    public function render()
    {
        return view('livewire.converter');
    }
}

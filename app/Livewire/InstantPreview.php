<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;

class InstantPreview extends Component
{
    public string $inputText = '';
    public array $quickTools = [];
    public array $previews = [];
    
    public function mount()
    {
        
        // Quick tools strip - most common transformations
        $this->quickTools = [
            ['key' => 'upper-case', 'label' => 'UPPERCASE', 'icon' => '🔠'],
            ['key' => 'lower-case', 'label' => 'lowercase', 'icon' => '🔡'],
            ['key' => 'title-case', 'label' => 'Title Case', 'icon' => '🔤'],
            ['key' => 'sentence-case', 'label' => 'Sentence case', 'icon' => '📝'],
            ['key' => 'camel-case', 'label' => 'camelCase', 'icon' => '🐪'],
            ['key' => 'pascal-case', 'label' => 'PascalCase', 'icon' => '🅿️'],
            ['key' => 'snake-case', 'label' => 'snake_case', 'icon' => '🐍'],
            ['key' => 'kebab-case', 'label' => 'kebab-case', 'icon' => '🔗'],
            ['key' => 'reverse', 'label' => 'Reverse', 'icon' => '↩️'],
            ['key' => 'alternating-case', 'label' => 'aLtErNaTiNg', 'icon' => '🔀'],
            ['key' => 'remove-spaces', 'label' => 'RemoveSpaces', 'icon' => '🚫'],
            ['key' => 'add-dashes', 'label' => 'Add-Dashes', 'icon' => '➖'],
        ];
        
        $this->generatePreviews();
    }
    
    public function updatedInputText()
    {
        $this->generatePreviews();
    }
    
    protected function generatePreviews()
    {
        $this->previews = [];
        $transformationService = new TransformationService();
        
        if (empty($this->inputText)) {
            // Show placeholder text for empty input
            $placeholderText = "Hello World Example";
            foreach ($this->quickTools as $tool) {
                $this->previews[$tool['key']] = [
                    'label' => $tool['label'],
                    'icon' => $tool['icon'],
                    'preview' => $transformationService->transform($placeholderText, $tool['key']),
                    'isPlaceholder' => true
                ];
            }
        } else {
            foreach ($this->quickTools as $tool) {
                $this->previews[$tool['key']] = [
                    'label' => $tool['label'],
                    'icon' => $tool['icon'],
                    'preview' => $transformationService->transform($this->inputText, $tool['key']),
                    'isPlaceholder' => false
                ];
            }
        }
    }
    
    public function copyPreview(string $transformationType)
    {
        if (isset($this->previews[$transformationType])) {
            $textToCopy = $this->previews[$transformationType]['preview'];
            $this->dispatch('copy-to-clipboard', text: $textToCopy);
            $this->dispatch('show-toast', message: 'Copied to clipboard!', type: 'success');
        }
    }
    
    public function loadExample()
    {
        $this->inputText = 'Hello World - This is a Sample Text for Testing Various Transformations';
        $this->generatePreviews();
    }
    
    public function clearText()
    {
        $this->inputText = '';
        $this->generatePreviews();
    }
    
    public function render()
    {
        return view('livewire.instant-preview');
    }
}
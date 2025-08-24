<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;
use App\Services\PreservationService;
use App\Services\StyleGuideService;

class CategoryConverter extends Component
{
    public $category;
    public $categoryData;
    public $inputText = '';
    public $outputText = '';
    public $selectedFormat;
    public $preserveUrls = true;
    public $preserveEmails = true;
    public $preserveHashtags = true;
    public $preserveMentions = true;
    public $preserveCodeBlocks = false;
    public $showPreservationOptions = false;
    
    // Services are resolved via getter methods to avoid Livewire serialization issues

    public function mount($category, $categoryData)
    {
        $this->category = $category;
        $this->categoryData = $categoryData;
        
        // Set first tool as default
        $toolKeys = array_keys($categoryData['tools']);
        $this->selectedFormat = $toolKeys[0] ?? 'uppercase';
        
        // Configure preservation options based on category
        $this->showPreservationOptions = in_array($category, ['developer-formats', 'technical-documentation']);
    }

    protected function getTransformationService(): TransformationService
    {
        return app(TransformationService::class);
    }

    protected function getPreservationService(): PreservationService
    {
        return app(PreservationService::class);
    }

    protected function getStyleGuideService(): StyleGuideService
    {
        return app(StyleGuideService::class);
    }

    public function updatedInputText()
    {
        $this->convertText();
    }

    public function updatedSelectedFormat()
    {
        $this->convertText();
    }

    public function convertText()
    {
        if (empty($this->inputText)) {
            $this->outputText = '';
            return;
        }

        // Configure preservation
        $preservationConfig = [
            'urls' => $this->preserveUrls,
            'emails' => $this->preserveEmails,
            'hashtags' => $this->preserveHashtags,
            'mentions' => $this->preserveMentions,
            'code_blocks' => $this->preserveCodeBlocks,
        ];

        // Apply transformation
        $result = $this->getTransformationService()->transform(
            $this->inputText,
            $this->selectedFormat,
            $preservationConfig
        );

        $this->outputText = $result;
    }

    public function copyToClipboard()
    {
        $this->dispatch('text-copied');
    }

    public function clearText()
    {
        $this->inputText = '';
        $this->outputText = '';
    }

    public function downloadText()
    {
        $filename = 'converted-' . $this->selectedFormat . '-' . date('Y-m-d-His') . '.txt';
        
        return response()->streamDownload(function () {
            echo $this->outputText;
        }, $filename);
    }

    public function render()
    {
        return view('livewire.category-converter');
    }
}
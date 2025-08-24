<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;
use App\Services\PreservationService;
use App\Services\StyleGuideService;

class ConversionTool extends Component
{
    public string $inputText = '';
    public string $outputText = '';
    public string $category = '';
    public string $tool = '';
    public array $toolData = [];
    public bool $copied = false;
    public array $stats = [
        'inputChars' => 0,
        'inputWords' => 0,
        'outputChars' => 0,
        'outputWords' => 0
    ];
    
    public array $preservationSettings = [
        'urls' => true,
        'emails' => true,
        'brands' => true,
        'code_blocks' => false,
        'markdown' => false,
        'mentions' => false,
        'hashtags' => false,
        'file_paths' => false
    ];

    private TransformationService $transformationService;
    private PreservationService $preservationService;
    private StyleGuideService $styleGuideService;

    public function boot()
    {
        $this->transformationService = app(TransformationService::class);
        $this->preservationService = app(PreservationService::class);
        $this->styleGuideService = app(StyleGuideService::class);
    }

    public function mount($category, $tool, $toolData)
    {
        $this->category = $category;
        $this->tool = $tool;
        $this->toolData = $toolData;
        
        // Set default preservation settings based on tool type
        $this->configurePreservationSettings();
    }

    public function updatedInputText($value)
    {
        $this->updateStats();
        $this->transform();
    }

    public function transform()
    {
        if (empty($this->inputText)) {
            $this->outputText = '';
            return;
        }

        try {
            // Apply preservation
            $preserved = $this->preservationService->preserve($this->inputText, $this->preservationSettings);
            
            // Map tool slug to transformation key
            $transformationKey = $this->mapToolToTransformation($this->tool);
            
            // Apply transformation based on category
            if (in_array($this->category, ['journalistic-styles', 'academic-styles', 'business-formats'])) {
                $transformed = $this->styleGuideService->applyStyleGuide($preserved['text'], $transformationKey);
            } else {
                $transformed = $this->transformationService->transform($preserved['text'], $transformationKey);
            }
            
            // Restore preserved content
            $this->outputText = $this->preservationService->restore($transformed, $preserved['preserved']);
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('ConversionTool transform error: ' . $e->getMessage(), [
                'tool' => $this->tool,
                'category' => $this->category,
                'trace' => $e->getTraceAsString()
            ]);
            $this->outputText = 'Error: ' . $e->getMessage();
        }
        
        $this->updateStats();
    }

    public function copyToClipboard()
    {
        $this->copied = true;
        $this->dispatch('copy-to-clipboard', ['text' => $this->outputText]);
        
        // Reset copied state after 2 seconds
        $this->dispatch('reset-copied');
    }

    public function clearAll()
    {
        $this->inputText = '';
        $this->outputText = '';
        $this->updateStats();
    }

    public function swapTexts()
    {
        $temp = $this->inputText;
        $this->inputText = $this->outputText;
        $this->outputText = $temp;
        $this->transform();
    }

    public function downloadOutput()
    {
        $filename = $this->tool . '-' . date('Y-m-d-His') . '.txt';
        
        return response()->streamDownload(function () {
            echo $this->outputText;
        }, $filename);
    }

    private function updateStats()
    {
        $this->stats = [
            'inputChars' => strlen($this->inputText),
            'inputWords' => str_word_count($this->inputText),
            'outputChars' => strlen($this->outputText),
            'outputWords' => str_word_count($this->outputText)
        ];
    }

    private function configurePreservationSettings()
    {
        // Configure preservation based on tool category
        switch ($this->category) {
            case 'developer-formats':
                $this->preservationSettings = [
                    'urls' => true,
                    'emails' => true,
                    'brands' => false,
                    'code_blocks' => true,
                    'markdown' => true,
                    'mentions' => false,
                    'hashtags' => false,
                    'file_paths' => true
                ];
                break;
                
            case 'social-media-formats':
                $this->preservationSettings = [
                    'urls' => true,
                    'emails' => true,
                    'brands' => true,
                    'code_blocks' => false,
                    'markdown' => false,
                    'mentions' => true,
                    'hashtags' => true,
                    'file_paths' => false
                ];
                break;
                
            case 'journalistic-styles':
            case 'academic-styles':
                $this->preservationSettings = [
                    'urls' => true,
                    'emails' => true,
                    'brands' => true,
                    'code_blocks' => false,
                    'markdown' => false,
                    'mentions' => false,
                    'hashtags' => false,
                    'file_paths' => false
                ];
                break;
                
            default:
                // Default settings
                break;
        }
    }

    private function mapToolToTransformation($tool)
    {
        // Simply return the tool slug as-is
        // The TransformationService now handles all these directly
        return $tool;
    }

    public function render()
    {
        return view('livewire.conversion-tool');
    }
}
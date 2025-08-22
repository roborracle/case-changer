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
            $this->outputText = $this->inputText;
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
        // Map URL-friendly slugs to transformation keys
        $mappings = [
            'uppercase' => 'uppercase',
            'lowercase' => 'lowercase',
            'title-case' => 'title_case',
            'sentence-case' => 'sentence_case',
            'capitalize-words' => 'capitalize_words',
            'alternating-case' => 'alternating_case',
            'inverse-case' => 'inverse_case',
            'camel-case' => 'camelCase',
            'pascal-case' => 'PascalCase',
            'snake-case' => 'snake_case',
            'constant-case' => 'CONSTANT_CASE',
            'kebab-case' => 'kebab-case',
            'dot-case' => 'dot.case',
            'path-case' => 'path/case',
            'namespace-case' => 'namespace\\case',
            'ada-case' => 'ada_case',
            'cobol-case' => 'cobol-case',
            'train-case' => 'train-case',
            'http-header-case' => 'http-header-case',
            'ap-style' => 'ap_title',
            'nyt-style' => 'nyt_title',
            'chicago-style' => 'chicago_title',
            'apa-style' => 'apa_title',
            'mla-style' => 'mla_title',
            'email-style' => 'email_style',
            'legal-style' => 'legal_style',
            'marketing-headline' => 'marketing_headline',
            'twitter-style' => 'social_media',
            'instagram-style' => 'social_media',
            'linkedin-style' => 'professional_social',
            'reverse' => 'reverse',
            'aesthetic' => 'aesthetic',
            'sarcasm' => 'sarcasm',
            'smallcaps' => 'smallcaps',
            'remove-spaces' => 'remove_spaces',
            'remove-extra-spaces' => 'remove_extra_spaces',
            'add-dashes' => 'add_dashes',
            'add-underscores' => 'add_underscores',
            'remove-punctuation' => 'remove_punctuation',
        ];
        
        return $mappings[$tool] ?? $tool;
    }

    public function render()
    {
        return view('livewire.conversion-tool');
    }
}
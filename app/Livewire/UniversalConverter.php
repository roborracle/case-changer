<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;
use App\Services\PreservationService;
use App\Services\StyleGuideService;

class UniversalConverter extends Component
{
    public $inputText = '';
    public $outputText = '';
    public $selectedFormat = 'uppercase';
    public $preserveUrls = true;
    public $preserveEmails = true;
    public $preserveHashtags = true;
    public $preserveMentions = true;
    public $preserveCodeBlocks = false;
    public $showPreservationOptions = false;

    // All available formats organized by category
    public $formats = [
        'Case Conversions' => [
            'uppercase' => 'UPPERCASE',
            'lowercase' => 'lowercase',
            'title-case' => 'Title Case',
            'sentence-case' => 'Sentence case',
            'capitalize-words' => 'Capitalize Words',
            'alternating-case' => 'aLtErNaTiNg CaSe',
            'inverse-case' => 'iNVERSE cASE',
        ],
        'Developer Formats' => [
            'camel-case' => 'camelCase',
            'pascal-case' => 'PascalCase',
            'snake-case' => 'snake_case',
            'constant-case' => 'CONSTANT_CASE',
            'kebab-case' => 'kebab-case',
            'dot-case' => 'dot.case',
            'path-case' => 'path/case',
        ],
        'Journalistic Styles' => [
            'ap-style' => 'AP Style',
            'nyt-style' => 'NY Times Style',
            'chicago-style' => 'Chicago Style',
            'guardian-style' => 'Guardian Style',
            'bbc-style' => 'BBC Style',
            'reuters-style' => 'Reuters Style',
        ],
        'Academic Styles' => [
            'apa-style' => 'APA Style',
            'mla-style' => 'MLA Style',
            'chicago-author-date' => 'Chicago Author-Date',
            'harvard-style' => 'Harvard Style',
            'ieee-style' => 'IEEE Style',
        ],
        'Creative Formats' => [
            'spongebob-mocking' => 'SpOnGeBoB MoCkInG',
            'clap-case' => 'Clap 👏 Case',
            'aesthetic-wide' => 'Ａｅｓｔｈｅｔｉｃ　Ｗｉｄｅ',
            'small-caps' => 'sᴍᴀʟʟ ᴄᴀᴘs',
            'upside-down' => 'ndsᴉpǝ poʍu',
            'bubble-text' => 'Ⓑⓤⓑⓑⓛⓔ Ⓣⓔⓧⓣ',
            'bold-serif' => '𝐁𝐨𝐥𝐝 𝐒𝐞𝐫𝐢𝐟',
            'italic-serif' => '𝐼𝑡𝑎𝑙𝑖𝑐 𝑆𝑒𝑟𝑖𝑓',
        ],
        'Business Formats' => [
            'email-subject' => 'Email Subject Line',
            'headline-style' => 'Headline Style',
            'brand-name' => 'BrandName Format',
            'domain-safe' => 'domain-safe-format',
            'filename-safe' => 'filename_safe_format',
            'hashtag-format' => '#HashtagFormat',
        ],
        'Social Media' => [
            'twitter-thread' => 'Twitter Thread 🧵',
            'instagram-caption' => 'Instagram Caption ✨',
            'linkedin-headline' => 'LinkedIn Professional',
            'youtube-title' => 'YouTube Video Title',
            'tiktok-caption' => 'TikTok Caption 🎵',
        ],
        'Technical Documentation' => [
            'markdown-header' => '# Markdown Header',
            'jira-ticket' => 'JIRA-TICKET-FORMAT',
            'git-branch' => 'feature/git-branch-name',
            'docker-image' => 'docker-image-name',
            'k8s-resource' => 'kubernetes-resource-name',
        ],
        'International Formats' => [
            'german-nouns' => 'German Noun Capitalization',
            'french-title' => 'French Title Format',
            'spanish-title' => 'Spanish Title Format',
        ],
        'Special Formats' => [
            'reverse-text' => 'txeT esreveR',
            'remove-spaces' => 'RemoveAllSpaces',
            'double-space' => 'Double  Space  Words',
            'acronym-generator' => 'A.C.R.O.N.Y.M',
            'slug-format' => 'slug-format-for-urls',
            'remove-punctuation' => 'Remove Punctuation',
            'numbers-to-words' => 'Convert 123 to Words',
            'morse-code' => '-- --- .-. ... . / -.-. --- -.. .',
        ]
    ];

    /**
     * Get the transformation service instance
     */
    protected function getTransformationService(): TransformationService
    {
        return app(TransformationService::class);
    }

    /**
     * Get the preservation service instance
     */
    protected function getPreservationService(): PreservationService
    {
        return app(PreservationService::class);
    }

    /**
     * Get the style guide service instance
     */
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
        
        // Auto-configure preservation based on format
        $developerFormats = ['camel-case', 'pascal-case', 'snake-case', 'constant-case', 'kebab-case', 'dot-case', 'path-case'];
        $this->showPreservationOptions = in_array($this->selectedFormat, $developerFormats);
    }

    public function convertText()
    {
        if (empty($this->inputText)) {
            $this->outputText = '';
            return;
        }

        try {
            // Configure preservation
            $preservationConfig = [
                'urls' => $this->preserveUrls,
                'emails' => $this->preserveEmails,
                'hashtags' => $this->preserveHashtags,
                'mentions' => $this->preserveMentions,
                'code_blocks' => $this->preserveCodeBlocks,
            ];

            // Apply transformation based on selected format
            $transformationService = $this->getTransformationService();
            $result = $transformationService->transform(
                $this->inputText,
                $this->selectedFormat,
                $preservationConfig
            );

            $this->outputText = $result;
        } catch (\Exception $e) {
            // Handle any transformation errors gracefully
            $this->outputText = $this->inputText; // Fallback to original text
            \Log::error('Transformation error: ' . $e->getMessage());
        }
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
        return view('livewire.universal-converter');
    }
}
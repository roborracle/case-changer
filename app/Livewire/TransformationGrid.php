<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;

class TransformationGrid extends Component
{
    public string $inputText = '';
    public string $outputText = '';
    public string $searchTerm = '';
    public string $activeCategory = 'all';
    public ?string $selectedTransformation = null;
    public array $categories = [];
    public array $transformations = [];
    public array $filteredTransformations = [];
    
    protected TransformationService $transformationService;
    
    public function mount()
    {
        $this->transformationService = new TransformationService();
        $this->transformations = $this->transformationService->getTransformations();
        $this->categories = $this->getCategorizedTransformations();
        $this->filterTransformations();
    }
    
    protected function getCategorizedTransformations(): array
    {
        return [
            'all' => ['label' => 'All Tools', 'count' => count($this->transformations)],
            'case' => ['label' => 'Case Converters', 'keys' => [
                'upper-case', 'lower-case', 'title-case', 'sentence-case', 
                'capitalize-words', 'alternating-case', 'inverse-case'
            ]],
            'developer' => ['label' => 'Developer Tools', 'keys' => [
                'camel-case', 'pascal-case', 'snake-case', 'constant-case',
                'kebab-case', 'dot-case', 'path-case', 'sql-case', 
                'python-case', 'java-case', 'php-case', 'ruby-case',
                'go-case', 'rust-case', 'swift-case'
            ]],
            'style' => ['label' => 'Writing Styles', 'keys' => [
                'ap-style', 'nyt-style', 'chicago-style', 'guardian-style',
                'bbc-style', 'reuters-style', 'economist-style', 'wsj-style',
                'apa-style', 'mla-style', 'harvard-style', 'vancouver-style',
                'ieee-style', 'ama-style', 'bluebook-style'
            ]],
            'social' => ['label' => 'Social Media', 'keys' => [
                'twitter-style', 'instagram-style', 'linkedin-style', 
                'facebook-style', 'youtube-title', 'tiktok-style',
                'hashtag-style', 'mention-style', 'twitter-font',
                'facebook-font', 'instagram-font', 'discord-font'
            ]],
            'encoding' => ['label' => 'Encoding & Decoding', 'keys' => [
                'base64-encode', 'base64-decode', 'url-encode', 'url-decode',
                'html-encode', 'html-decode', 'json-escape', 'json-unescape',
                'xml-escape', 'xml-unescape', 'sql-escape', 'regex-escape',
                'binary-translator', 'hex-converter', 'morse-code', 
                'caesar-cipher', 'md5-hash', 'sha256-hash'
            ]],
            'formatting' => ['label' => 'Text Formatting', 'keys' => [
                'bold', 'italic', 'bold-text', 'italic-text', 
                'strikethrough-text', 'underline-text', 'superscript',
                'subscript', 'wide-text', 'big-text', 'slash-text',
                'stacked-text'
            ]],
            'fun' => ['label' => 'Fun & Creative', 'keys' => [
                'aesthetic', 'sarcasm', 'smallcaps', 'bubble', 'square',
                'script', 'double-struck', 'emoji-case', 'upside-down',
                'mirror-text', 'zalgo-text', 'cursed-text', 'invisible-text',
                'pig-latin', 'wingdings'
            ]],
            'generators' => ['label' => 'Generators', 'keys' => [
                'password-generator', 'uuid-generator', 'random-number',
                'random-letter', 'random-date', 'random-month', 'random-ip',
                'lorem-ipsum', 'username-generator', 'email-generator',
                'hex-color', 'phone-number'
            ]],
            'utilities' => ['label' => 'Text Utilities', 'keys' => [
                'remove-spaces', 'remove-extra-spaces', 'add-dashes',
                'add-underscores', 'add-periods', 'remove-punctuation',
                'extract-letters', 'extract-numbers', 'remove-duplicates',
                'sort-words', 'shuffle-words', 'word-frequency',
                'line-break-remover', 'whitespace-remover', 'repeat-text'
            ]],
            'analytics' => ['label' => 'Text Analytics', 'keys' => [
                'reading-time', 'flesch-score', 'sentiment-analysis',
                'keyword-extractor', 'syllable-counter', 'paragraph-counter',
                'sentence-counter', 'unique-words', 'duplicate-finder'
            ]],
            'professional' => ['label' => 'Professional', 'keys' => [
                'email-style', 'legal-style', 'marketing-headline',
                'press-release', 'memo-style', 'report-style',
                'proposal-style', 'invoice-style', 'api-docs',
                'readme-style', 'changelog-style', 'user-manual',
                'technical-spec', 'code-comments', 'wiki-style',
                'markdown-style'
            ]],
            'numbers' => ['label' => 'Number Formatting', 'keys' => [
                'scientific-notation', 'engineering-notation', 
                'fraction-converter', 'percentage-format', 
                'currency-format', 'ordinal-numbers', 'spelled-numbers',
                'roman-numerals'
            ]]
        ];
    }
    
    public function filterByCategory(string $category)
    {
        $this->activeCategory = $category;
        $this->searchTerm = '';
        $this->filterTransformations();
    }
    
    public function updatedSearchTerm()
    {
        $this->activeCategory = 'all';
        $this->filterTransformations();
    }
    
    protected function filterTransformations()
    {
        if ($this->searchTerm) {
            $searchLower = strtolower($this->searchTerm);
            $this->filteredTransformations = array_filter(
                $this->transformations,
                fn($label, $key) => 
                    str_contains(strtolower($label), $searchLower) ||
                    str_contains(strtolower($key), $searchLower),
                ARRAY_FILTER_USE_BOTH
            );
        } elseif ($this->activeCategory !== 'all') {
            $categoryKeys = $this->categories[$this->activeCategory]['keys'] ?? [];
            $this->filteredTransformations = array_intersect_key(
                $this->transformations,
                array_flip($categoryKeys)
            );
        } else {
            $this->filteredTransformations = $this->transformations;
        }
    }
    
    public function transform(string $type)
    {
        $this->selectedTransformation = $type;
        if ($this->inputText) {
            $this->transformationService = new TransformationService();
            $this->outputText = $this->transformationService->transform($this->inputText, $type);
        } else {
            $this->outputText = '';
        }
    }
    
    public function updatedInputText()
    {
        if ($this->selectedTransformation && $this->inputText) {
            $this->transform($this->selectedTransformation);
        } else {
            $this->outputText = '';
        }
    }
    
    public function loadExample()
    {
        $this->inputText = 'Hello World - This is a Sample Text for Testing Various Transformations';
        $this->outputText = '';
        $this->selectedTransformation = null;
    }
    
    public function clearText()
    {
        $this->inputText = '';
        $this->outputText = '';
        $this->selectedTransformation = null;
    }
    
    public function copyOutput()
    {
        $this->dispatch('copy-to-clipboard', text: $this->outputText);
    }
    
    public function render()
    {
        return view('livewire.transformation-grid');
    }
}
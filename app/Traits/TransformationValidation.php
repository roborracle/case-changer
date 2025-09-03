<?php

namespace App\Traits;

trait TransformationValidation
{
    /**
     * Validation rules for different transformation categories
     */
    protected array $validationRules = [
        'encoding' => [
            'base64-decode' => ['pattern' => '/^[a-zA-Z0-9+\/]*={0,2}$/'],
            'hex-decode' => ['pattern' => '/^[0-9a-fA-F]*$/'],
            'binary-decode' => ['pattern' => '/^[01\s]*$/'],
            'morse-decode' => ['pattern' => '/^[\.\-\s\/]*$/']
        ],
        'generators' => [
            'allowEmpty' => true,
            'maxLength' => 1000
        ],
        'case_transformations' => [
            'minLength' => 0,
            'maxLength' => 50000
        ],
        'style_guides' => [
            'minLength' => 1,
            'maxLength' => 10000
        ],
        'social_media' => [
            'twitter-style' => ['maxLength' => 280],
            'instagram-style' => ['maxLength' => 2200],
            'tiktok-style' => ['maxLength' => 150]
        ]
    ];
    
    /**
     * Get validation rules for a specific transformation
     */
    protected function getValidationRules(string $transformation): array
    {
        // Check specific transformation rules
        foreach ($this->validationRules as $category => $rules) {
            if (isset($rules[$transformation])) {
                return $rules[$transformation];
            }
        }
        
        // Check category rules
        $category = $this->getTransformationCategory($transformation);
        if (isset($this->validationRules[$category])) {
            return $this->validationRules[$category];
        }
        
        // Default rules
        return [
            'minLength' => 0,
            'maxLength' => 50000,
            'allowEmpty' => false
        ];
    }
    
    /**
     * Categorize transformation for validation purposes
     */
    protected function getTransformationCategory(string $transformation): string
    {
        $categories = [
            'generators' => [
                'password-generator', 'uuid-generator', 'random-number',
                'random-letter', 'random-date', 'lorem-ipsum',
                'username-generator', 'email-generator', 'hex-color'
            ],
            'encoding' => [
                'base64-encode', 'base64-decode', 'url-encode', 'url-decode',
                'hex-encode', 'hex-decode', 'binary-encode', 'binary-decode',
                'morse-encode', 'morse-decode', 'rot13', 'atbash'
            ],
            'case_transformations' => [
                'upper-case', 'lower-case', 'title-case', 'sentence-case',
                'capitalize-words', 'alternating-case', 'inverse-case',
                'camel-case', 'pascal-case', 'snake-case', 'kebab-case'
            ],
            'style_guides' => [
                'ap-style', 'nyt-style', 'chicago-style', 'guardian-style',
                'bbc-style', 'reuters-style', 'economist-style', 'wsj-style',
                'apa-style', 'mla-style', 'harvard-style', 'ieee-style'
            ],
            'social_media' => [
                'twitter-style', 'instagram-style', 'linkedin-style',
                'facebook-style', 'youtube-title', 'tiktok-style',
                'hashtag-style', 'mention-style'
            ],
            'text_manipulation' => [
                'reverse', 'remove-spaces', 'remove-extra-spaces',
                'remove-punctuation', 'extract-letters', 'extract-numbers',
                'sort-words', 'shuffle-words', 'remove-duplicates'
            ],
            'formatting' => [
                'indent-text', 'outdent-text', 'wrap-text', 'unwrap-text',
                'justify-text', 'center-text', 'right-align', 'left-align'
            ],
            'visual_effects' => [
                'aesthetic', 'sarcasm', 'smallcaps', 'bubble', 'square',
                'script', 'double-struck', 'bold', 'italic', 'emoji-case',
                'vertical-text', 'diagonal-text', 'wave-text', 'circle-text'
            ]
        ];
        
        foreach ($categories as $category => $transformations) {
            if (in_array($transformation, $transformations)) {
                return $category;
            }
        }
        
        return 'default';
    }
    
    /**
     * Validate transformation input
     */
    protected function validateTransformationInput(string $text, string $transformation): ?string
    {
        $rules = $this->getValidationRules($transformation);
        $errors = $this->validateInput($text, $rules);
        
        if (!empty($errors)) {
            return 'Error: ' . implode('. ', $errors) . '.';
        }
        
        return null;
    }
    
    /**
     * Pre-process input based on transformation type
     */
    protected function preprocessInput(string $text, string $transformation): string
    {
        $category = $this->getTransformationCategory($transformation);
        
        switch ($category) {
            case 'encoding':
                // Remove whitespace for encoding operations
                if (strpos($transformation, 'decode') !== false) {
                    $text = preg_replace('/\s+/', '', $text);
                }
                break;
                
            case 'case_transformations':
                // Normalize unicode for case transformations
                if (function_exists('normalizer_normalize')) {
                    $normalized = normalizer_normalize($text, \Normalizer::FORM_C);
                    if ($normalized !== false) {
                        $text = $normalized;
                    }
                }
                break;
                
            case 'social_media':
                // Trim whitespace for social media
                $text = trim($text);
                break;
        }
        
        return $text;
    }
}
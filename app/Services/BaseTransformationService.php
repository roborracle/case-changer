<?php

namespace App\Services;

use App\Contracts\TransformationInterface;
use App\Traits\TransformationErrorHandling;
use App\Traits\TransformationValidation;
use Exception;
use Illuminate\Support\Facades\Log;

abstract class BaseTransformationService implements TransformationInterface
{
    use TransformationErrorHandling, TransformationValidation;
    
    /**
     * Transformation metadata including categories and descriptions
     */
    protected array $transformationMetadata = [];
    
    /**
     * Execute a transformation with full error handling and validation
     */
    protected function executeTransformation(string $methodName, string $text, string $transformation): string
    {
        try {
            // Pre-process input
            $text = $this->preprocessInput($text, $transformation);
            
            // Validate input
            $validationError = $this->validateTransformationInput($text, $transformation);
            if ($validationError !== null) {
                return $validationError;
            }
            
            // Execute the transformation
            if (!method_exists($this, $methodName)) {
                throw new Exception("Method {$methodName} not found");
            }
            
            $result = $this->$methodName($text);
            
            // Validate result
            if ($result === null || $result === false) {
                throw new Exception('Transformation returned invalid result');
            }
            
            // Ensure string result
            $result = (string) $result;
            
            // Log success
            $this->logSuccess($transformation, strlen($text), strlen($result));
            
            return $result;
            
        } catch (Exception $e) {
            return $this->handleTransformationError($transformation, $e, substr($text, 0, 100));
        }
    }
    
    /**
     * Check if transformation exists
     */
    public function hasTransformation(string $transformation): bool
    {
        return array_key_exists($transformation, $this->getTransformations());
    }
    
    /**
     * Get transformation metadata
     */
    public function getTransformationMetadata(string $transformation): ?array
    {
        if (!$this->hasTransformation($transformation)) {
            return null;
        }
        
        $category = $this->getTransformationCategory($transformation);
        
        return [
            'key' => $transformation,
            'name' => $this->getTransformations()[$transformation] ?? $transformation,
            'category' => $category,
            'validation_rules' => $this->getValidationRules($transformation),
            'description' => $this->transformationMetadata[$transformation]['description'] ?? null,
            'example' => $this->transformationMetadata[$transformation]['example'] ?? null
        ];
    }
    
    /**
     * Get transformations grouped by category
     */
    public function getGroupedTransformations(): array
    {
        $grouped = [
            'Case Transformations' => [],
            'Developer Formats' => [],
            'Style Guides - News' => [],
            'Style Guides - Academic' => [],
            'Text Effects' => [],
            'Business Formats' => [],
            'Social Media' => [],
            'Documentation' => [],
            'Localization' => [],
            'Text Processing' => [],
            'Encoding & Escaping' => [],
            'Generators' => [],
            'Text Formatting' => [],
            'Visual Effects' => []
        ];
        
        foreach ($this->getTransformations() as $key => $name) {
            $category = $this->getCategoryForDisplay($key);
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][$key] = $name;
        }
        
        // Remove empty categories
        return array_filter($grouped, function($items) {
            return !empty($items);
        });
    }
    
    /**
     * Get display category for a transformation
     */
    protected function getCategoryForDisplay(string $transformation): string
    {
        $categoryMap = [
            'upper-case' => 'Case Transformations',
            'lower-case' => 'Case Transformations',
            'title-case' => 'Case Transformations',
            'sentence-case' => 'Case Transformations',
            'capitalize-words' => 'Case Transformations',
            'alternating-case' => 'Case Transformations',
            'inverse-case' => 'Case Transformations',
            
            'camel-case' => 'Developer Formats',
            'pascal-case' => 'Developer Formats',
            'snake-case' => 'Developer Formats',
            'constant-case' => 'Developer Formats',
            'kebab-case' => 'Developer Formats',
            'dot-case' => 'Developer Formats',
            'path-case' => 'Developer Formats',
            
            'ap-style' => 'Style Guides - News',
            'nyt-style' => 'Style Guides - News',
            'chicago-style' => 'Style Guides - News',
            'guardian-style' => 'Style Guides - News',
            'bbc-style' => 'Style Guides - News',
            'reuters-style' => 'Style Guides - News',
            'economist-style' => 'Style Guides - News',
            'wsj-style' => 'Style Guides - News',
            
            'apa-style' => 'Style Guides - Academic',
            'mla-style' => 'Style Guides - Academic',
            'chicago-author-date' => 'Style Guides - Academic',
            'chicago-notes' => 'Style Guides - Academic',
            'harvard-style' => 'Style Guides - Academic',
            'vancouver-style' => 'Style Guides - Academic',
            'ieee-style' => 'Style Guides - Academic',
            'ama-style' => 'Style Guides - Academic',
            'bluebook-style' => 'Style Guides - Academic',
            
            'aesthetic' => 'Text Effects',
            'sarcasm' => 'Text Effects',
            'smallcaps' => 'Text Effects',
            'bubble' => 'Text Effects',
            'square' => 'Text Effects',
            'script' => 'Text Effects',
            'double-struck' => 'Text Effects',
            'bold' => 'Text Effects',
            'italic' => 'Text Effects',
            'emoji-case' => 'Text Effects',
            
            'email-style' => 'Business Formats',
            'legal-style' => 'Business Formats',
            'marketing-headline' => 'Business Formats',
            'press-release' => 'Business Formats',
            'memo-style' => 'Business Formats',
            'report-style' => 'Business Formats',
            'proposal-style' => 'Business Formats',
            'invoice-style' => 'Business Formats',
            
            'twitter-style' => 'Social Media',
            'instagram-style' => 'Social Media',
            'linkedin-style' => 'Social Media',
            'facebook-style' => 'Social Media',
            'youtube-title' => 'Social Media',
            'tiktok-style' => 'Social Media',
            'hashtag-style' => 'Social Media',
            'mention-style' => 'Social Media',
            
            'api-docs' => 'Documentation',
            'readme-style' => 'Documentation',
            'changelog-style' => 'Documentation',
            'user-manual' => 'Documentation',
            'technical-spec' => 'Documentation',
            'code-comments' => 'Documentation',
            'wiki-style' => 'Documentation',
            'markdown-style' => 'Documentation',
            
            'british-english' => 'Localization',
            'american-english' => 'Localization',
            'canadian-english' => 'Localization',
            'australian-english' => 'Localization',
            'eu-format' => 'Localization',
            'iso-format' => 'Localization',
            
            'reverse' => 'Text Processing',
            'remove-spaces' => 'Text Processing',
            'remove-extra-spaces' => 'Text Processing',
            'remove-punctuation' => 'Text Processing',
            'extract-letters' => 'Text Processing',
            'extract-numbers' => 'Text Processing',
            'remove-duplicates' => 'Text Processing',
            'sort-words' => 'Text Processing',
            'shuffle-words' => 'Text Processing',
            'word-frequency' => 'Text Processing',
            
            'base64-encode' => 'Encoding & Escaping',
            'base64-decode' => 'Encoding & Escaping',
            'url-encode' => 'Encoding & Escaping',
            'url-decode' => 'Encoding & Escaping',
            'html-encode' => 'Encoding & Escaping',
            'html-decode' => 'Encoding & Escaping',
            'hex-encode' => 'Encoding & Escaping',
            'hex-decode' => 'Encoding & Escaping',
            'binary-encode' => 'Encoding & Escaping',
            'binary-decode' => 'Encoding & Escaping',
            'morse-encode' => 'Encoding & Escaping',
            'morse-decode' => 'Encoding & Escaping',
            'rot13' => 'Encoding & Escaping',
            'atbash' => 'Encoding & Escaping',
            'caesar-cipher' => 'Encoding & Escaping',
            'vigenere-cipher' => 'Encoding & Escaping',
            'xml-escape' => 'Encoding & Escaping',
            'json-escape' => 'Encoding & Escaping',
            'csv-escape' => 'Encoding & Escaping',
            'sql-escape' => 'Encoding & Escaping',
            'shell-escape' => 'Encoding & Escaping',
            'javascript-escape' => 'Encoding & Escaping',
            'backslash-escape' => 'Encoding & Escaping',
            'double-quote-escape' => 'Encoding & Escaping',
            'single-quote-escape' => 'Encoding & Escaping',
            
            'password-generator' => 'Generators',
            'uuid-generator' => 'Generators',
            'random-number' => 'Generators',
            'random-letter' => 'Generators',
            'random-date' => 'Generators',
            'random-month' => 'Generators',
            'random-ip' => 'Generators',
            'lorem-ipsum' => 'Generators',
            'username-generator' => 'Generators',
            'email-generator' => 'Generators',
            'hex-color' => 'Generators',
            'phone-number' => 'Generators',
            
            'tab-to-spaces' => 'Text Formatting',
            'spaces-to-tabs' => 'Text Formatting',
            'indent-text' => 'Text Formatting',
            'outdent-text' => 'Text Formatting',
            'wrap-text' => 'Text Formatting',
            'unwrap-text' => 'Text Formatting',
            'justify-text' => 'Text Formatting',
            'center-text' => 'Text Formatting',
            'right-align' => 'Text Formatting',
            'left-align' => 'Text Formatting',
            
            'vertical-text' => 'Visual Effects',
            'diagonal-text' => 'Visual Effects',
            'wave-text' => 'Visual Effects',
            'circle-text' => 'Visual Effects',
            'spiral-text' => 'Visual Effects',
            'rainbow-text' => 'Visual Effects',
            'gradient-text' => 'Visual Effects',
            'shadow-text' => 'Visual Effects',
            'outline-text' => 'Visual Effects',
            'emboss-text' => 'Visual Effects'
        ];
        
        return $categoryMap[$transformation] ?? 'Other';
    }
}
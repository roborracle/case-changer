<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

/**
 * SCARLETT Documentation Standard
 * Purpose: Main Livewire component for text case transformation interface
 * Assumptions: User input is text, transformations are stateless
 * Constraints: Memory limit for large texts, browser clipboard API availability
 * Failure Modes: Invalid transformation type, empty input, memory overflow
 */
class CaseChanger extends Component
{
    /**
     * Maximum text length allowed (100KB)
     * @var int
     */
    private const MAX_TEXT_LENGTH = 100000;
    
    /**
     * User input text to be transformed
     * @var string
     */
    public string $inputText = '';
    
    /**
     * Transformed output text
     * @var string
     */
    public string $outputText = '';
    
    /**
     * Error message for user feedback
     * @var string
     */
    public string $errorMessage = '';
    
    /**
     * Whether advanced options are visible
     * @var bool
     */
    public bool $showAdvancedOptions = false;
    
    /**
     * Maximum length for prepositions to lowercase
     * @var int
     */
    public int $prepositionMaxLength = 4;
    
    /**
     * Whether text was copied to clipboard
     * @var bool
     */
    public bool $copied = false;
    
    /**
     * Text statistics
     * @var array
     */
    public array $stats = [
        'characters' => 0,
        'words' => 0,
        'sentences' => 0
    ];

    /**
     * Update statistics when text changes
     */
    public function updatedInputText(): void
    {
        $this->errorMessage = '';
        
        // Validate input length
        if (mb_strlen($this->inputText, 'UTF-8') > self::MAX_TEXT_LENGTH) {
            $this->errorMessage = 'Text exceeds maximum length of ' . number_format(self::MAX_TEXT_LENGTH) . ' characters.';
            $this->inputText = mb_substr($this->inputText, 0, self::MAX_TEXT_LENGTH, 'UTF-8');
        }
        
        // Check for valid UTF-8
        if (!mb_check_encoding($this->inputText, 'UTF-8')) {
            $this->errorMessage = 'Invalid character encoding detected. Please use UTF-8 text.';
            $this->inputText = mb_convert_encoding($this->inputText, 'UTF-8', 'UTF-8');
        }
        
        $this->updateStatistics();
        $this->copied = false;
    }

    /**
     * Update text statistics
     */
    private function updateStatistics(): void
    {
        $this->stats = [
            'characters' => strlen($this->inputText),
            'words' => str_word_count($this->inputText),
            'sentences' => preg_match_all('/[.!?]+/', $this->inputText, $matches)
        ];
    }

    /**
     * Transform text to Title Case
     */
    public function transformToTitleCase(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            $this->outputText = mb_convert_case($this->inputText, MB_CASE_TITLE, 'UTF-8');
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error during transformation. Please try again.';
            Log::error('Title case transformation failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Transform text to Sentence case
     */
    public function transformToSentenceCase(): void
    {
        $sentences = preg_split('/([.!?]+)/', $this->inputText, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = '';
        
        foreach ($sentences as $i => $sentence) {
            if ($i % 2 == 0) { // Text part
                $trimmed = trim($sentence);
                if (!empty($trimmed)) {
                    $result .= ucfirst(strtolower($trimmed));
                }
            } else { // Punctuation part
                $result .= $sentence;
                if ($i + 1 < count($sentences)) {
                    $result .= ' ';
                }
            }
        }
        
        $this->outputText = $result;
        $this->copied = false;
    }

    /**
     * Transform text to UPPERCASE
     */
    public function transformToUpperCase(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            $this->outputText = mb_strtoupper($this->inputText, 'UTF-8');
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error during transformation. Please try again.';
            Log::error('Uppercase transformation failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Transform text to lowercase
     */
    public function transformToLowerCase(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            $this->outputText = mb_strtolower($this->inputText, 'UTF-8');
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error during transformation. Please try again.';
            Log::error('Lowercase transformation failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Transform text to First Letter capitalization
     */
    public function transformToFirstLetter(): void
    {
        $this->outputText = ucfirst(strtolower($this->inputText));
        $this->copied = false;
    }

    /**
     * Transform text to Alternating Case
     */
    public function transformToAlternatingCase(): void
    {
        $result = '';
        $upper = true;
        
        for ($i = 0; $i < strlen($this->inputText); $i++) {
            $char = $this->inputText[$i];
            if (ctype_alpha($char)) {
                $result .= $upper ? strtolower($char) : strtoupper($char);
                $upper = !$upper;
            } else {
                $result .= $char;
            }
        }
        
        $this->outputText = $result;
        $this->copied = false;
    }

    /**
     * Transform text to Random Case
     */
    public function transformToRandomCase(): void
    {
        $result = '';
        
        for ($i = 0; $i < strlen($this->inputText); $i++) {
            $char = $this->inputText[$i];
            if (ctype_alpha($char)) {
                $result .= rand(0, 1) ? strtoupper($char) : strtolower($char);
            } else {
                $result .= $char;
            }
        }
        
        $this->outputText = $result;
        $this->copied = false;
    }

    /**
     * Private helper to apply preposition fixing logic to a string.
     */
    private function applyPrepositionFix(string $text): string
    {
        // Always start with a title-cased string for preposition fixing.
        $titleCasedText = ucwords(strtolower($text));

        $prepositions = ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'if', 'in', 'nor', 'of', 'on', 'or', 'so', 'the', 'to', 'up', 'yet'];
        $words = explode(' ', $titleCasedText);

        foreach ($words as $i => &$word) {
            // Skip first and last words, as they are always capitalized in titles.
            if ($i === 0 || $i === count($words) - 1) {
                continue;
            }

            $lowerWord = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $word));
            if (in_array($lowerWord, $prepositions) && strlen($lowerWord) < $this->prepositionMaxLength) {
                $word = strtolower($word);
            }
        }

        return implode(' ', $words);
    }

    /**
     * Fix prepositions according to style rules
     */
    public function fixPrepositions(): void
    {
        $this->outputText = $this->applyPrepositionFix($this->inputText);
        $this->copied = false;
    }

    /**
     * Convert straight quotes to smart quotes
     */
    public function convertToSmartQuotes(): void
    {
        $result = $this->inputText;
        
        // Define smart quote characters
        $leftDouble = "\u{201C}";   // "
        $rightDouble = "\u{201D}";  // "
        $leftSingle = "\u{2018}";   // '
        $rightSingle = "\u{2019}";  // '
        
        // Convert double quotes
        $result = preg_replace('/^"/', $leftDouble, $result);
        $result = preg_replace('/"$/', $rightDouble, $result);
        $result = preg_replace('/(\s)"/', '$1' . $leftDouble, $result);
        $result = preg_replace('/"(\s)/', $rightDouble . '$1', $result);
        $result = preg_replace('/([^\s])"([^\s])/', '$1' . $rightDouble . '$2', $result);
        
        // Convert single quotes/apostrophes
        $result = preg_replace("/^'/", $leftSingle, $result);
        $result = preg_replace("/'$/", $rightSingle, $result);
        $result = preg_replace("/(\s)'/", '$1' . $leftSingle, $result);
        $result = preg_replace("/'(\s)/", $rightSingle . '$1', $result);
        $result = preg_replace("/([a-z])'([a-z])/i", '$1' . $rightSingle . '$2', $result);
        
        $this->outputText = $result;
        $this->copied = false;
    }

    // Style Guide Formatters
    public function applyApaStyle(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // APA: Capitalize first word, last word, and all major words
            // Lowercase articles (a, an, the), conjunctions (and, but, or, for, nor), 
            // and prepositions under 4 letters
            $words = preg_split('/\s+/', mb_strtolower($this->inputText, 'UTF-8'));
            $apaExceptions = ['a', 'an', 'the', 'and', 'but', 'or', 'for', 'nor', 'as', 'at', 'by', 'in', 'of', 'on', 'to', 'up'];
            
            for ($i = 0; $i < count($words); $i++) {
                $word = $words[$i];
                // Always capitalize first and last word
                if ($i === 0 || $i === count($words) - 1) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Capitalize after colon (subtitle)
                else if ($i > 0 && mb_substr($words[$i-1], -1) === ':') {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Check if word should be lowercase
                else if (!in_array($word, $apaExceptions)) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
            }
            
            $this->outputText = implode(' ', $words);
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error applying APA style.';
            Log::error('APA style transformation failed', ['error' => $e->getMessage()]);
        }
    }

    public function applyChicagoStyle(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Chicago: Capitalize first/last words, nouns, pronouns, verbs, adjectives, adverbs
            // Lowercase articles, prepositions (unless 5+ letters), conjunctions, "to" in infinitives
            $words = preg_split('/\s+/', mb_strtolower($this->inputText, 'UTF-8'));
            $chicagoExceptions = ['a', 'an', 'the', 'and', 'but', 'for', 'nor', 'or', 'yet', 'so', 'as', 'at', 'by', 'in', 'of', 'on', 'to', 'up'];
            
            for ($i = 0; $i < count($words); $i++) {
                $word = $words[$i];
                
                // Always capitalize first and last word
                if ($i === 0 || $i === count($words) - 1) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Capitalize after colon or hyphen
                else if ($i > 0 && (mb_substr($words[$i-1], -1) === ':' || mb_substr($words[$i-1], -1) === '-')) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Capitalize prepositions 5+ letters
                else if (in_array($word, $chicagoExceptions) && mb_strlen($word, 'UTF-8') >= 5) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Keep lowercase if in exceptions and under 5 letters
                else if (!in_array($word, $chicagoExceptions)) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
            }
            
            $this->outputText = implode(' ', $words);
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error applying Chicago style.';
            Log::error('Chicago style transformation failed', ['error' => $e->getMessage()]);
        }
    }

    public function applyApStyle(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // AP Style: Capitalize principal words
            // Lowercase articles, conjunctions, prepositions under 4 letters
            $words = preg_split('/\s+/', mb_strtolower($this->inputText, 'UTF-8'));
            
            for ($i = 0; $i < count($words); $i++) {
                $word = $words[$i];
                $wordLength = mb_strlen($word, 'UTF-8');
                
                // Always capitalize first and last word
                if ($i === 0 || $i === count($words) - 1) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Capitalize words 4+ letters
                else if ($wordLength >= 4) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Keep articles, conjunctions, prepositions under 4 letters lowercase
                else if (in_array($word, ['a', 'an', 'the', 'and', 'but', 'or', 'for', 'nor', 'at', 'by', 'in', 'of', 'on', 'to', 'up', 'as'])) {
                    // Keep lowercase
                } else {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
            }
            
            $this->outputText = implode(' ', $words);
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error applying AP style.';
            Log::error('AP style transformation failed', ['error' => $e->getMessage()]);
        }
    }

    public function applyMlaStyle(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // MLA: Similar to APA but with slight differences
            // Capitalize first, last, and all principal words
            $words = preg_split('/\s+/', mb_strtolower($this->inputText, 'UTF-8'));
            $mlaExceptions = ['a', 'an', 'the', 'and', 'but', 'for', 'nor', 'or', 'so', 'yet', 'at', 'by', 'in', 'of', 'on', 'to', 'as', 'up'];
            
            for ($i = 0; $i < count($words); $i++) {
                $word = $words[$i];
                
                // Always capitalize first and last word
                if ($i === 0 || $i === count($words) - 1) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Capitalize after colon (subtitle)
                else if ($i > 0 && mb_substr($words[$i-1], -1) === ':') {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Keep exceptions lowercase unless they're verbs
                else if (!in_array($word, $mlaExceptions) || mb_strlen($word, 'UTF-8') >= 5) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
            }
            
            $this->outputText = implode(' ', $words);
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error applying MLA style.';
            Log::error('MLA style transformation failed', ['error' => $e->getMessage()]);
        }
    }

    public function applyBluebookStyle(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Bluebook: Legal citation style - specific rules for case names
            // Main words capitalized, procedural phrases and party designations in specific format
            $text = mb_strtolower($this->inputText, 'UTF-8');
            
            // Common legal abbreviations that should be formatted specifically
            $legalTerms = [
                'v.' => 'v.',
                'vs.' => 'v.',
                'versus' => 'v.',
                'et al.' => 'et al.',
                'ex rel.' => 'ex rel.',
                'in re' => 'In re',
                'corp.' => 'Corp.',
                'inc.' => 'Inc.',
                'ltd.' => 'Ltd.',
                'llc' => 'LLC',
                'l.l.c.' => 'LLC',
                'co.' => 'Co.'
            ];
            
            // Replace legal terms
            foreach ($legalTerms as $search => $replace) {
                $text = str_ireplace($search, $replace, $text);
            }
            
            // Capitalize main words but keep certain words lowercase
            $words = preg_split('/\s+/', $text);
            $exceptions = ['of', 'the', 'and', 'for', 'in', 'on', 'at', 'to', 'by', 'a', 'an'];
            
            for ($i = 0; $i < count($words); $i++) {
                if ($i === 0 || !in_array($words[$i], $exceptions)) {
                    if (!in_array($words[$i], array_values($legalTerms))) {
                        $words[$i] = mb_convert_case($words[$i], MB_CASE_TITLE, 'UTF-8');
                    }
                }
            }
            
            $this->outputText = implode(' ', $words);
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error applying Bluebook style.';
            Log::error('Bluebook style transformation failed', ['error' => $e->getMessage()]);
        }
    }

    public function applyAmaStyle(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // AMA: Medical/scientific style - capitalize major words
            // Lowercase articles, coordinating conjunctions, prepositions of 3 or fewer letters
            $words = preg_split('/\s+/', mb_strtolower($this->inputText, 'UTF-8'));
            $amaExceptions = ['a', 'an', 'the', 'and', 'but', 'or', 'for', 'nor', 'as', 'at', 'by', 'in', 'of', 'on', 'to', 'up', 'via'];
            
            for ($i = 0; $i < count($words); $i++) {
                $word = $words[$i];
                
                // Always capitalize first word
                if ($i === 0) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Keep last word lowercase if it's a preposition in AMA style
                else if ($i === count($words) - 1 && !in_array($word, $amaExceptions)) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Capitalize after colon
                else if ($i > 0 && mb_substr($words[$i-1], -1) === ':') {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Apply exceptions
                else if (!in_array($word, $amaExceptions) || mb_strlen($word, 'UTF-8') > 3) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
            }
            
            $this->outputText = implode(' ', $words);
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error applying AMA style.';
            Log::error('AMA style transformation failed', ['error' => $e->getMessage()]);
        }
    }

    public function applyNyTimesStyle(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // NY Times: Journalistic style - similar to AP but with some differences
            // Capitalize all words except articles, conjunctions, prepositions under 4 letters
            $words = preg_split('/\s+/', mb_strtolower($this->inputText, 'UTF-8'));
            
            for ($i = 0; $i < count($words); $i++) {
                $word = $words[$i];
                
                // Always capitalize first and last word
                if ($i === 0 || $i === count($words) - 1) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // NY Times capitalizes "to" in infinitives
                else if ($word === 'to' && $i < count($words) - 1) {
                    // Check if next word might be a verb (simplified check)
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Capitalize words 4+ letters
                else if (mb_strlen($word, 'UTF-8') >= 4) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
                // Keep short articles, conjunctions, prepositions lowercase
                else if (!in_array($word, ['a', 'an', 'the', 'and', 'but', 'or', 'for', 'nor', 'at', 'by', 'in', 'of', 'on', 'up'])) {
                    $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                }
            }
            
            $this->outputText = implode(' ', $words);
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error applying NY Times style.';
            Log::error('NY Times style transformation failed', ['error' => $e->getMessage()]);
        }
    }

    public function applyWikipediaStyle(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Wikipedia: Sentence case - only first word and proper nouns capitalized
            $sentences = preg_split('/([.!?]+\s*)/', $this->inputText, -1, PREG_SPLIT_DELIM_CAPTURE);
            $result = '';
            
            foreach ($sentences as $i => $part) {
                if ($i % 2 == 0 && !empty(trim($part))) {
                    // This is a sentence part
                    $part = mb_strtolower($part, 'UTF-8');
                    // Capitalize first character
                    $part = mb_strtoupper(mb_substr($part, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($part, 1, null, 'UTF-8');
                    
                    // Preserve common proper nouns and acronyms (simplified list)
                    $properNouns = ['I', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',
                                   'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 
                                   'September', 'October', 'November', 'December'];
                    
                    foreach ($properNouns as $proper) {
                        $part = preg_replace('/\b' . strtolower($proper) . '\b/i', $proper, $part);
                    }
                }
                $result .= $part;
            }
            
            $this->outputText = $result;
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error applying Wikipedia style.';
            Log::error('Wikipedia style transformation failed', ['error' => $e->getMessage()]);
        }
    }

    // Advanced Features
    public function removeExtraSpaces(): void
    {
        // Remove multiple spaces and trim
        $result = preg_replace('/\s+/', ' ', $this->inputText);
        $this->outputText = trim($result);
        $this->copied = false;
    }

    public function addSpaces(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Add spaces after punctuation if missing
            $result = $this->inputText;
            // Add space after punctuation if followed by letter
            $result = preg_replace('/([.!?,:;])(\S)/', '$1 $2', $result);
            // Don't add space before punctuation
            $this->outputText = $result;
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error adding spaces.';
            Log::error('Add spaces failed', ['error' => $e->getMessage()]);
        }
    }

    public function spacesToUnderscores(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            $this->outputText = str_replace(' ', '_', $this->inputText);
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error converting spaces to underscores.';
            Log::error('Spaces to underscores failed', ['error' => $e->getMessage()]);
        }
    }
    
    // Alias for compatibility
    public function convertSpacesToUnderscores(): void
    {
        $this->spacesToUnderscores();
    }

    public function underscoresToSpaces(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            $this->outputText = str_replace('_', ' ', $this->inputText);
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error converting underscores to spaces.';
            Log::error('Underscores to spaces failed', ['error' => $e->getMessage()]);
        }
    }
    
    // Alias for compatibility
    public function convertUnderscoresToSpaces(): void
    {
        $this->underscoresToSpaces();
    }

    public function removeSpaces(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Remove spaces before punctuation
            $result = $this->inputText;
            $result = preg_replace('/\s+([.!?,:;])/', '$1', $result);
            $this->outputText = $result;
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error removing spaces.';
            Log::error('Remove spaces failed', ['error' => $e->getMessage()]);
        }
    }

    // Developer Case Transformations
    public function transformToCamelCase(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Convert to camelCase
            $str = preg_replace('/[^a-zA-Z0-9]+/', ' ', $this->inputText);
            $str = trim($str);
            $str = ucwords($str);
            $str = lcfirst(str_replace(' ', '', $str));
            $this->outputText = $str;
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error converting to camelCase.';
            Log::error('CamelCase transformation failed', ['error' => $e->getMessage()]);
        }
    }
    
    public function transformToSnakeCase(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Convert to snake_case
            $str = preg_replace('/[^a-zA-Z0-9]+/', '_', $this->inputText);
            $str = preg_replace('/([a-z])([A-Z])/', '$1_$2', $str);
            $str = strtolower($str);
            $str = trim($str, '_');
            $this->outputText = $str;
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error converting to snake_case.';
            Log::error('Snake case transformation failed', ['error' => $e->getMessage()]);
        }
    }
    
    public function transformToKebabCase(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Convert to kebab-case
            $str = preg_replace('/[^a-zA-Z0-9]+/', '-', $this->inputText);
            $str = preg_replace('/([a-z])([A-Z])/', '$1-$2', $str);
            $str = strtolower($str);
            $str = trim($str, '-');
            $this->outputText = $str;
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error converting to kebab-case.';
            Log::error('Kebab case transformation failed', ['error' => $e->getMessage()]);
        }
    }
    
    public function transformToPascalCase(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Convert to PascalCase
            $str = preg_replace('/[^a-zA-Z0-9]+/', ' ', $this->inputText);
            $str = trim($str);
            $str = ucwords($str);
            $str = str_replace(' ', '', $str);
            $this->outputText = $str;
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error converting to PascalCase.';
            Log::error('Pascal case transformation failed', ['error' => $e->getMessage()]);
        }
    }
    
    public function transformToConstantCase(): void
    {
        try {
            $this->errorMessage = '';
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            // Convert to CONSTANT_CASE
            $str = preg_replace('/[^a-zA-Z0-9]+/', '_', $this->inputText);
            $str = preg_replace('/([a-z])([A-Z])/', '$1_$2', $str);
            $str = strtoupper($str);
            $str = trim($str, '_');
            $this->outputText = $str;
            $this->copied = false;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error converting to CONSTANT_CASE.';
            Log::error('Constant case transformation failed', ['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Copy output to clipboard
     */
    public function copyToClipboard(): void
    {
        if (!empty($this->outputText)) {
            $this->dispatch('copy-to-clipboard', text: $this->outputText);
            $this->copied = true;
            
            // Reset copied state after 2 seconds
            $this->dispatch('reset-copied');
        }
    }

    /**
     * Toggle advanced options visibility
     */
    public function toggleAdvancedOptions(): void
    {
        $this->showAdvancedOptions = !$this->showAdvancedOptions;
    }

    /**
     * Component mount lifecycle
     */
    public function mount(): void
    {
        $this->updateStatistics();
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.case-changer');
    }
}

<?php

namespace App\Services;

class ContextualSuggestionService
{
    /**
     * Analyze text and return contextual suggestions
     * @param string $text The input text to analyze
     * @return array Array of suggested transformations with context
     */
    public function analyzeText(string $text): array
    {
        if (empty($text)) {
            return [
                'context' => null,
                'suggestions' => [],
                'analysis' => null
            ];
        }

        $context = $this->detectContext($text);
        $suggestions = $this->generateSuggestions($text, $context);
        $analysis = $this->performTextAnalysis($text);

        return [
            'context' => $context,
            'suggestions' => $suggestions,
            'analysis' => $analysis
        ];
    }

    /**
     * Detect the context of the input text
     * @param string $text
     * @return string|null
     */
    private function detectContext(string $text): ?string
    {
        if ($this->isCode($text)) {
            return 'Code/Programming';
        }

        if ($this->isEmail($text)) {
            return 'Email/Communication';
        }

        if ($this->isUrl($text)) {
            return 'Web/URL';
        }

        if (strlen($text) < 100 && $this->isTitleLike($text)) {
            return 'Title/Heading';
        }

        if ($this->isList($text)) {
            return 'List/Enumeration';
        }

        if (str_word_count($text) > 50) {
            return 'Article/Document';
        }

        if ($this->isName($text)) {
            return 'Name/Identifier';
        }

        return 'General Text';
    }

    /**
     * Generate smart suggestions based on text and context
     * @param string $text
     * @param string|null $context
     * @return array
     */
    private function generateSuggestions(string $text, ?string $context): array
    {
        $suggestions = [];

        switch ($context) {
            case 'Code/Programming':
                $suggestions = [
                    ['type' => 'camelCase', 'label' => 'camelCase', 'style' => 'camel'],
                    ['type' => 'snake_case', 'label' => 'snake_case', 'style' => 'snake'],
                    ['type' => 'kebab-case', 'label' => 'kebab-case', 'style' => 'kebab'],
                    ['type' => 'PascalCase', 'label' => 'PascalCase', 'style' => 'pascal'],
                    ['type' => 'CONSTANT_CASE', 'label' => 'CONSTANT_CASE', 'style' => 'constant'],
                ];
                break;

            case 'Email/Communication':
                $suggestions = [
                    ['type' => 'sentence', 'label' => 'Sentence Case', 'style' => 'sentence'],
                    ['type' => 'title', 'label' => 'Title Case', 'style' => 'title'],
                    ['type' => 'capitalize', 'label' => 'Capitalize', 'style' => 'capitalize'],
                    ['type' => 'formal', 'label' => 'Formal Tone', 'style' => 'formal'],
                    ['type' => 'professional', 'label' => 'Professional', 'style' => 'professional'],
                ];
                break;

            case 'Web/URL':
                $suggestions = [
                    ['type' => 'slug', 'label' => 'URL Slug', 'style' => 'slug'],
                    ['type' => 'kebab-case', 'label' => 'kebab-case', 'style' => 'kebab'],
                    ['type' => 'lowercase', 'label' => 'lowercase', 'style' => 'lower'],
                    ['type' => 'encode-url', 'label' => 'URL Encode', 'style' => 'encode'],
                    ['type' => 'decode-url', 'label' => 'URL Decode', 'style' => 'decode'],
                ];
                break;

            case 'Title/Heading':
                $suggestions = [
                    ['type' => 'title', 'label' => 'Title Case', 'style' => 'title'],
                    ['type' => 'uppercase', 'label' => 'UPPERCASE', 'style' => 'upper'],
                    ['type' => 'capitalize', 'label' => 'Capitalize Each', 'style' => 'capitalize'],
                    ['type' => 'headline', 'label' => 'Headline Style', 'style' => 'headline'],
                    ['type' => 'hashtag', 'label' => '#HashTag', 'style' => 'hashtag'],
                ];
                break;

            case 'List/Enumeration':
                $suggestions = [
                    ['type' => 'bullet', 'label' => '• Bullet List', 'style' => 'bullet'],
                    ['type' => 'numbered', 'label' => '1. Numbered', 'style' => 'numbered'],
                    ['type' => 'alphabetize', 'label' => 'Alphabetize', 'style' => 'alpha'],
                    ['type' => 'csv', 'label' => 'CSV Format', 'style' => 'csv'],
                    ['type' => 'json', 'label' => 'JSON Array', 'style' => 'json'],
                ];
                break;

            case 'Article/Document':
                $suggestions = [
                    ['type' => 'sentence', 'label' => 'Sentence Case', 'style' => 'sentence'],
                    ['type' => 'paragraph', 'label' => 'Format Paragraphs', 'style' => 'paragraph'],
                    ['type' => 'summarize', 'label' => 'Summarize', 'style' => 'summary'],
                    ['type' => 'extract-keywords', 'label' => 'Keywords', 'style' => 'keywords'],
                    ['type' => 'remove-duplicates', 'label' => 'Remove Duplicates', 'style' => 'unique'],
                ];
                break;

            case 'Name/Identifier':
                $suggestions = [
                    ['type' => 'title', 'label' => 'Title Case', 'style' => 'title'],
                    ['type' => 'uppercase', 'label' => 'UPPERCASE', 'style' => 'upper'],
                    ['type' => 'initials', 'label' => 'Initials', 'style' => 'initials'],
                    ['type' => 'firstname', 'label' => 'First Name', 'style' => 'first'],
                    ['type' => 'lastname', 'label' => 'Last Name', 'style' => 'last'],
                ];
                break;

            default:
                $suggestions = [
                    ['type' => 'uppercase', 'label' => 'UPPERCASE', 'style' => 'upper'],
                    ['type' => 'lowercase', 'label' => 'lowercase', 'style' => 'lower'],
                    ['type' => 'title', 'label' => 'Title Case', 'style' => 'title'],
                    ['type' => 'sentence', 'label' => 'Sentence case', 'style' => 'sentence'],
                    ['type' => 'reverse', 'label' => 'Reverse', 'style' => 'reverse'],
                ];
        }

    }

    /**
     * Perform detailed text analysis
     * @param string $text
     * @return string
     */
    private function performTextAnalysis(string $text): string
    {
        $wordCount = str_word_count($text);
        $charCount = strlen($text);
        $lineCount = substr_count($text, "\n") + 1;

        if ($this->hasSpecialCharacters($text)) {
            return "Contains special characters";
        }

        if ($this->hasMixedCase($text)) {
            return "Mixed case detected";
        }

        if ($this->isAllCaps($text)) {
            return "All uppercase";
        }

        if ($this->isAllLower($text)) {
            return "All lowercase";
        }

        if ($lineCount > 1) {
            return "Multi-line text";
        }

        return "Ready for transformation";
    }

    /**
     * Check if text appears to be code
     * @param string $text
     * @return bool
     */
    private function isCode(string $text): bool
    {
        $codePatterns = [
            '/function\s+\w+\s*\(/',
            '/\$\w+/',
            '/\w+\s*=\s*\w+/',
            '/\{\s*\}/',
            '/\[\s*\]/',
            '/console\.log/',
            '/import\s+.*from/',
            '/class\s+\w+/',
            '/def\s+\w+/',
            '/if\s*\(.*\)/',
        ];

        foreach ($codePatterns as $pattern) {
            if (preg_match($pattern, $text)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if text contains email addresses
     * @param string $text
     * @return bool
     */
    private function isEmail(string $text): bool
    {
        return (bool) preg_match('/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/', $text);
    }

    /**
     * Check if text contains URLs
     * @param string $text
     * @return bool
     */
    private function isUrl(string $text): bool
    {
        return (bool) preg_match('/https?:\/\/[^\s]+/', $text) || 
               (bool) preg_match('/www\.[^\s]+/', $text);
    }

    /**
     * Check if text appears to be a title
     * @param string $text
     * @return bool
     */
    private function isTitleLike(string $text): bool
    {
        return strlen($text) < 100 && 
               substr_count($text, "\n") === 0 &&
               !preg_match('/[.!?]$/', trim($text));
    }

    /**
     * Check if text appears to be a list
     * @param string $text
     * @return bool
     */
    private function isList(string $text): bool
    {
        $lines = explode("\n", $text);
        if (count($lines) < 2) {
            return false;
        }

        $listPatterns = [
            '/^[\-\*\•]\s/',
            '/^\d+[\.]\s/',
            '/^[a-zA-Z][\.]\s/',
        ];

        $matchCount = 0;
        foreach ($lines as $line) {
            foreach ($listPatterns as $pattern) {
                if (preg_match($pattern, trim($line))) {
                    $matchCount++;
                    break;
                }
            }
        }

    }

    /**
     * Check if text appears to be a name
     * @param string $text
     * @return bool
     */
    private function isName(string $text): bool
    {
        $words = str_word_count($text);
        $hasCapitals = preg_match('/^[A-Z]/', $text);
        
        return $words >= 1 && $words <= 4 && 
               $hasCapitals && 
               !preg_match('/[0-9]/', $text) &&
               strlen($text) < 50;
    }

    /**
     * Check if text has special characters
     * @param string $text
     * @return bool
     */
    private function hasSpecialCharacters(string $text): bool
    {
        return (bool) preg_match('/[!@#$%^&*()_+=\[\]{};\':"\\|,.<>\/?]/', $text);
    }

    /**
     * Check if text has mixed case
     * @param string $text
     * @return bool
     */
    private function hasMixedCase(string $text): bool
    {
        return preg_match('/[a-z]/', $text) && preg_match('/[A-Z]/', $text);
    }

    /**
     * Check if text is all caps
     * @param string $text
     * @return bool
     */
    private function isAllCaps(string $text): bool
    {
        $letters = preg_replace('/[^a-zA-Z]/', '', $text);
        return !empty($letters) && strtoupper($letters) === $letters;
    }

    /**
     * Check if text is all lowercase
     * @param string $text
     * @return bool
     */
    private function isAllLower(string $text): bool
    {
        $letters = preg_replace('/[^a-zA-Z]/', '', $text);
        return !empty($letters) && strtolower($letters) === $letters;
    }

    /**
     * Get popular transformations based on usage patterns
     * @return array
     */
    public function getPopularTransformations(): array
    {
        return [
            ['type' => 'uppercase', 'label' => 'UPPERCASE', 'style' => 'upper'],
            ['type' => 'lowercase', 'label' => 'lowercase', 'style' => 'lower'],
            ['type' => 'title', 'label' => 'Title Case', 'style' => 'title'],
            ['type' => 'camelCase', 'label' => 'camelCase', 'style' => 'camel'],
            ['type' => 'snake_case', 'label' => 'snake_case', 'style' => 'snake'],
            ['type' => 'kebab-case', 'label' => 'kebab-case', 'style' => 'kebab'],
            ['type' => 'sentence', 'label' => 'Sentence case', 'style' => 'sentence'],
            ['type' => 'capitalize', 'label' => 'Capitalize', 'style' => 'capitalize'],
        ];
    }

    /**
     * Get all available tools organized by category
     * @param string|null $category
     * @param string|null $searchTerm
     * @return array
     */
    public function getAllTools(?string $category = null, ?string $searchTerm = null): array
    {
        $tools = [
            'case' => [
                ['type' => 'uppercase', 'label' => 'UPPERCASE', 'style' => 'upper', 'description' => 'Convert to all uppercase'],
                ['type' => 'lowercase', 'label' => 'lowercase', 'style' => 'lower', 'description' => 'Convert to all lowercase'],
                ['type' => 'title', 'label' => 'Title Case', 'style' => 'title', 'description' => 'Capitalize first letter of each word'],
                ['type' => 'sentence', 'label' => 'Sentence case', 'style' => 'sentence', 'description' => 'Capitalize first letter of sentences'],
                ['type' => 'capitalize', 'label' => 'Capitalize', 'style' => 'capitalize', 'description' => 'Capitalize first letter'],
                ['type' => 'toggle', 'label' => 'tOGGLE cASE', 'style' => 'toggle', 'description' => 'Invert the case'],
                ['type' => 'random', 'label' => 'RaNdOm CaSe', 'style' => 'random', 'description' => 'Random uppercase and lowercase'],
            ],
            'developer' => [
                ['type' => 'camelCase', 'label' => 'camelCase', 'style' => 'camel', 'description' => 'camelCase for variables'],
                ['type' => 'PascalCase', 'label' => 'PascalCase', 'style' => 'pascal', 'description' => 'PascalCase for classes'],
                ['type' => 'snake_case', 'label' => 'snake_case', 'style' => 'snake', 'description' => 'snake_case for Python'],
                ['type' => 'kebab-case', 'label' => 'kebab-case', 'style' => 'kebab', 'description' => 'kebab-case for URLs'],
                ['type' => 'CONSTANT_CASE', 'label' => 'CONSTANT_CASE', 'style' => 'constant', 'description' => 'CONSTANT_CASE for constants'],
                ['type' => 'dot.case', 'label' => 'dot.case', 'style' => 'dot', 'description' => 'dot.case notation'],
                ['type' => 'path/case', 'label' => 'path/case', 'style' => 'path', 'description' => 'path/case for file paths'],
                ['type' => 'cobol-case', 'label' => 'COBOL-CASE', 'style' => 'cobol', 'description' => 'COBOL-CASE hyphenated uppercase'],
                ['type' => 'train-case', 'label' => 'Train-Case', 'style' => 'train', 'description' => 'Train-Case hyphenated title'],
                ['type' => 'http-header', 'label' => 'Http-Header-Case', 'style' => 'header', 'description' => 'HTTP header case'],
            ],
            'style' => [
                ['type' => 'hashtag', 'label' => '#HashTag', 'style' => 'hashtag', 'description' => 'Create hashtags'],
                ['type' => 'slug', 'label' => 'url-slug', 'style' => 'slug', 'description' => 'URL friendly slug'],
                ['type' => 'alternating', 'label' => 'aLtErNaTiNg', 'style' => 'alternating', 'description' => 'Alternating case'],
                ['type' => 'inverted', 'label' => 'iNVERTED', 'style' => 'inverted', 'description' => 'Inverted first letter'],
                ['type' => 'studly', 'label' => 'StUdLy CaPs', 'style' => 'studly', 'description' => 'Studly caps style'],
                ['type' => 'sarcasm', 'label' => 'sArCaSm', 'style' => 'sarcasm', 'description' => 'Sarcasm/mocking text'],
                ['type' => 'clap', 'label' => '👏 Clap 👏 Case', 'style' => 'clap', 'description' => 'Add clap emojis'],
                ['type' => 'emoji', 'label' => '✨ Emoji ✨', 'style' => 'emoji', 'description' => 'Add decorative emojis'],
                ['type' => 'aesthetic', 'label' => 'ａｅｓｔｈｅｔｉｃ', 'style' => 'aesthetic', 'description' => 'Vaporwave aesthetic'],
                ['type' => 'wide', 'label' => 'Ｗｉｄｅ', 'style' => 'wide', 'description' => 'Wide/fullwidth text'],
            ],
            'creative' => [
                ['type' => 'reverse', 'label' => 'esreveR', 'style' => 'reverse', 'description' => 'Reverse the text'],
                ['type' => 'mirror', 'label' => 'ɿoɿɿiM', 'style' => 'mirror', 'description' => 'Mirror the text'],
                ['type' => 'upside-down', 'label' => 'uʍop ǝpᴉsd∩', 'style' => 'upside', 'description' => 'Flip text upside down'],
                ['type' => 'zalgo', 'label' => 'Z̸͎̀a̴̱͐l̶̰̾g̷͉̈́o̶̤̍', 'style' => 'zalgo', 'description' => 'Zalgo corrupted text'],
                ['type' => 'small-caps', 'label' => 'sᴍᴀʟʟ ᴄᴀᴘs', 'style' => 'smallcaps', 'description' => 'Small capitals'],
                ['type' => 'superscript', 'label' => 'ˢᵘᵖᵉʳˢᶜʳⁱᵖᵗ', 'style' => 'superscript', 'description' => 'Superscript text'],
                ['type' => 'subscript', 'label' => 'ₛᵤbₛcᵣᵢₚₜ', 'style' => 'subscript', 'description' => 'Subscript text'],
                ['type' => 'bubble', 'label' => 'ⓑⓤⓑⓑⓛⓔ', 'style' => 'bubble', 'description' => 'Bubble text'],
                ['type' => 'square', 'label' => '🅂🅀🅄🄰🅁🄴', 'style' => 'square', 'description' => 'Square text'],
                ['type' => 'cursive', 'label' => '𝒞𝓊𝓇𝓈𝒾𝓋ℯ', 'style' => 'cursive', 'description' => 'Cursive text'],
            ],
            'utility' => [
                ['type' => 'remove-spaces', 'label' => 'RemoveSpaces', 'style' => 'nospace', 'description' => 'Remove all spaces'],
                ['type' => 'remove-punctuation', 'label' => 'Remove Punctuation', 'style' => 'nopunct', 'description' => 'Strip punctuation'],
                ['type' => 'remove-numbers', 'label' => 'Remove Numbers', 'style' => 'nonums', 'description' => 'Remove all numbers'],
                ['type' => 'extract-numbers', 'label' => 'Extract Numbers', 'style' => 'nums', 'description' => 'Extract only numbers'],
                ['type' => 'remove-duplicates', 'label' => 'Remove Duplicates', 'style' => 'unique', 'description' => 'Remove duplicate lines'],
                ['type' => 'sort-alphabetically', 'label' => 'Sort A-Z', 'style' => 'sort', 'description' => 'Sort alphabetically'],
                ['type' => 'trim-whitespace', 'label' => 'Trim Whitespace', 'style' => 'trim', 'description' => 'Trim leading/trailing spaces'],
                ['type' => 'count-words', 'label' => 'Word Count', 'style' => 'count', 'description' => 'Count words'],
                ['type' => 'base64-encode', 'label' => 'Base64 Encode', 'style' => 'b64enc', 'description' => 'Encode to Base64'],
                ['type' => 'base64-decode', 'label' => 'Base64 Decode', 'style' => 'b64dec', 'description' => 'Decode from Base64'],
            ]
        ];

        if ($category && $category !== 'all' && isset($tools[$category])) {
            $filteredTools = $tools[$category];
        } else {
            $filteredTools = array_merge(...array_values($tools));
        }

        if ($searchTerm) {
            $searchTerm = strtolower($searchTerm);
            $filteredTools = array_filter($filteredTools, function($tool) use ($searchTerm) {
                return strpos(strtolower($tool['label']), $searchTerm) !== false ||
                       strpos(strtolower($tool['description']), $searchTerm) !== false ||
                       strpos(strtolower($tool['type']), $searchTerm) !== false;
            });
        }

        return array_values($filteredTools);
    }
}

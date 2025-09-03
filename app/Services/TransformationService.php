<?php

namespace App\Services;

use App\Services\BaseTransformationService;
use App\Models\Transformation;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;

class TransformationService extends BaseTransformationService
{
        protected array $transformations = [
        'upper-case' => 'Upper Case',
        'lower-case' => 'Lower Case',
        'title-case' => 'Title Case',
        'sentence-case' => 'Sentence Case',
        'capitalize-words' => 'Capitalize Words',
        'alternating-case' => 'Alternating Case',
        'inverse-case' => 'Inverse Case',
        'camel-case' => 'Camel Case',
        'pascal-case' => 'Pascal Case',
        'snake-case' => 'Snake Case',
        'constant-case' => 'Constant Case',
        'kebab-case' => 'Kebab Case',
        'dot-case' => 'Dot Case',
        'path-case' => 'Path Case',
        'ap-style' => 'AP Style',
        'nyt-style' => 'NY Times Style',
        'chicago-style' => 'Chicago Style',
        'guardian-style' => 'Guardian Style',
        'bbc-style' => 'BBC Style',
        'reuters-style' => 'Reuters Style',
        'economist-style' => 'Economist Style',
        'wsj-style' => 'WSJ Style',
        'apa-style' => 'APA Style',
        'mla-style' => 'MLA Style',
        'chicago-author-date' => 'Chicago Author-Date',
        'chicago-notes' => 'Chicago Notes',
        'harvard-style' => 'Harvard Style',
        'vancouver-style' => 'Vancouver Style',
        'ieee-style' => 'IEEE Style',
        'ama-style' => 'AMA Style',
        'bluebook-style' => 'Bluebook Style',
        'reverse' => 'Reverse',
        'aesthetic' => 'Aesthetic',
        'sarcasm' => 'Sarcasm Case',
        'smallcaps' => 'Small Caps',
        'bubble' => 'Bubble Text',
        'square' => 'Square Text',
        'script' => 'Script',
        'double-struck' => 'Double Struck',
        'bold' => 'Bold',
        'italic' => 'Italic',
        'emoji-case' => 'Emoji Case',
        'email-style' => 'Email Style',
        'legal-style' => 'Legal Style',
        'marketing-headline' => 'Marketing Headline',
        'press-release' => 'Press Release',
        'memo-style' => 'Memo Style',
        'report-style' => 'Report Style',
        'proposal-style' => 'Proposal Style',
        'invoice-style' => 'Invoice Style',
        'twitter-style' => 'Twitter/X Style',
        'instagram-style' => 'Instagram Style',
        'linkedin-style' => 'LinkedIn Style',
        'facebook-style' => 'Facebook Style',
        'youtube-title' => 'YouTube Title',
        'tiktok-style' => 'TikTok Style',
        'hashtag-style' => 'Hashtag Style',
        'mention-style' => 'Mention Style',
        'api-docs' => 'API Documentation',
        'readme-style' => 'README Style',
        'changelog-style' => 'Changelog Style',
        'user-manual' => 'User Manual',
        'technical-spec' => 'Technical Spec',
        'code-comments' => 'Code Comments',
        'wiki-style' => 'Wiki Style',
        'markdown-style' => 'Markdown Style',
        'british-english' => 'British English',
        'american-english' => 'American English',
        'canadian-english' => 'Canadian English',
        'australian-english' => 'Australian English',
        'eu-format' => 'EU Format',
        'iso-format' => 'ISO Format',
        'unicode-normalize' => 'Unicode Normalize',
        'ascii-convert' => 'ASCII Convert',
        'remove-spaces' => 'Remove Spaces',
        'remove-extra-spaces' => 'Remove Extra Spaces',
        'add-dashes' => 'Add Dashes',
        'add-underscores' => 'Add Underscores',
        'add-periods' => 'Add Periods',
        'remove-punctuation' => 'Remove Punctuation',
        'extract-letters' => 'Extract Letters',
        'extract-numbers' => 'Extract Numbers',
        'remove-duplicates' => 'Remove Duplicates',
        'sort-words' => 'Sort Words',
        'shuffle-words' => 'Shuffle Words',
        'word-frequency' => 'Word Frequency',
        'bold-text' => 'Bold Text',
        'italic-text' => 'Italic Text',
        'strikethrough-text' => 'Strikethrough Text',
        'underline-text' => 'Underline Text',
        'superscript' => 'Superscript',
        'subscript' => 'Subscript',
        'wide-text' => 'Wide Text',
        'upside-down' => 'Upside Down',
        'mirror-text' => 'Mirror Text',
        'zalgo-text' => 'Zalgo Text',
        'cursed-text' => 'Cursed Text',
        'invisible-text' => 'Invisible Text',
        'password-generator' => 'Password Generator',
        'uuid-generator' => 'UUID Generator',
        'random-number' => 'Random Number',
        'random-letter' => 'Random Letter',
        'random-date' => 'Random Date',
        'random-month' => 'Random Month',
        'random-ip' => 'Random IP',
        'random-choice' => 'Random Choice',
        'lorem-ipsum' => 'Lorem Ipsum',
        'username-generator' => 'Username Generator',
        'email-generator' => 'Email Generator',
        'hex-color' => 'Hex Color',
        'phone-number' => 'Phone Number',
        'binary-translator' => 'Binary Translator',
        'hex-converter' => 'Hex Converter',
        'morse-code' => 'Morse Code',
        'caesar-cipher' => 'Caesar Cipher',
        'md5-hash' => 'MD5 Hash',
        'sha256-hash' => 'SHA256 Hash',
        'json-formatter' => 'JSON Formatter',
        'csv-to-json' => 'CSV to JSON',
        'css-formatter' => 'CSS Formatter',
        'html-formatter' => 'HTML Formatter',
        'javascript-formatter' => 'JavaScript Formatter',
        'xml-formatter' => 'XML Formatter',
        'yaml-formatter' => 'YAML Formatter',
        'utf8-converter' => 'UTF8 Converter',
        'utm-builder' => 'UTM Builder',
        'slugify-generator' => 'Slugify Generator',
        'sentence-counter' => 'Sentence Counter',
        'duplicate-finder' => 'Duplicate Finder',
        'duplicate-remover' => 'Duplicate Remover',
        'text-replacer' => 'Text Replacer',
        'line-break-remover' => 'Line Break Remover',
        'plain-text-converter' => 'Plain Text Converter',
        'remove-formatting' => 'Remove Formatting',
        'remove-letters' => 'Remove Letters',
        'remove-underscores' => 'Remove Underscores',
        'whitespace-remover' => 'Whitespace Remover',
        'repeat-text' => 'Repeat Text',
        'phonetic-spelling' => 'Phonetic Spelling',
        'pig-latin' => 'Pig Latin',
        'discord-font' => 'Discord Font',
        'facebook-font' => 'Facebook Font',
        'instagram-font' => 'Instagram Font',
        'twitter-font' => 'Twitter Font',
        'big-text' => 'Big Text',
        'slash-text' => 'Slash Text',
        'stacked-text' => 'Stacked Text',
        'wingdings' => 'Wingdings',
        'nato-phonetic' => 'NATO Phonetic',
        'roman-numerals' => 'Roman Numerals',
        'sql-case' => 'SQL Case',
        'python-case' => 'Python Case',
        'java-case' => 'Java Case',
        'php-case' => 'PHP Case',
        'ruby-case' => 'Ruby Case',
        'go-case' => 'Go Case',
        'rust-case' => 'Rust Case',
        'swift-case' => 'Swift Case',
        'reading-time' => 'Reading Time',
        'flesch-score' => 'Flesch Score',
        'sentiment-analysis' => 'Sentiment Analysis',
        'keyword-extractor' => 'Keyword Extractor',
        'syllable-counter' => 'Syllable Counter',
        'paragraph-counter' => 'Paragraph Counter',
        'unique-words' => 'Unique Words',
        'scientific-notation' => 'Scientific Notation',
        'engineering-notation' => 'Engineering Notation',
        'fraction-converter' => 'Fraction Converter',
        'percentage-format' => 'Percentage Format',
        'currency-format' => 'Currency Format',
        'ordinal-numbers' => 'Ordinal Numbers',
        'spelled-numbers' => 'Spelled Numbers',
        
        // Additional Professional Tools (173-210)
        'base64-encode' => 'Base64 Encode',
        'base64-decode' => 'Base64 Decode',
        'url-encode' => 'URL Encode',
        'url-decode' => 'URL Decode',
        'html-encode' => 'HTML Entity Encode',
        'html-decode' => 'HTML Entity Decode',
        'json-escape' => 'JSON Escape',
        'json-unescape' => 'JSON Unescape',
        'xml-escape' => 'XML Escape',
        'xml-unescape' => 'XML Unescape',
        'sql-escape' => 'SQL Escape',
        'regex-escape' => 'Regex Escape',
        'csv-escape' => 'CSV Escape',
        'shell-escape' => 'Shell Escape',
        'javascript-escape' => 'JavaScript Escape',
        'backslash-escape' => 'Backslash Escape',
        'double-quote-escape' => 'Double Quote Escape',
        'single-quote-escape' => 'Single Quote Escape',
        'tab-to-spaces' => 'Tab to Spaces',
        'spaces-to-tabs' => 'Spaces to Tabs',
        'indent-text' => 'Indent Text',
        'outdent-text' => 'Outdent Text',
        'wrap-text' => 'Wrap Text',
        'unwrap-text' => 'Unwrap Text',
        'justify-text' => 'Justify Text',
        'center-text' => 'Center Text',
        'right-align' => 'Right Align',
        'left-align' => 'Left Align',
        'vertical-text' => 'Vertical Text',
        'diagonal-text' => 'Diagonal Text',
        'wave-text' => 'Wave Text',
        'circle-text' => 'Circle Text',
        'spiral-text' => 'Spiral Text',
        'rainbow-text' => 'Rainbow Text',
        'gradient-text' => 'Gradient Text',
        'shadow-text' => 'Shadow Text',
        'outline-text' => 'Outline Text',
        'emboss-text' => 'Emboss Text'
    ];

    public function getTransformations(): array
    {
        return $this->transformations;
    }

    /**
     * Transform text using the specified transformation with comprehensive error handling
     */
    public function transform(string $text, string $transformation): string
    {
        try {
            // Check if transformation exists
            if (!$this->hasTransformation($transformation)) {
                Log::error('Invalid transformation requested', [
                    'transformation' => $transformation,
                    'available_transformations' => array_keys($this->transformations)
                ]);
                return 'Error: Invalid transformation type.';
            }

            // Build method name
            $methodName = 'to' . str_replace(' ', '', ucwords(str_replace('-', ' ', $transformation)));

            // Execute transformation using parent class method
            $result = $this->executeTransformation($methodName, $text, $transformation);
            
            // Store transformation in database for analytics if successful
            if (!str_starts_with($result, 'Error:')) {
                $this->storeTransformation($transformation, $text, $result);
            }
            
            return $result;

        } catch (Exception $e) {
            return $this->handleTransformationError($transformation, $e, substr($text, 0, 100));
        }
    }

    // executeTransformation is now inherited from BaseTransformationService

    /**
     * Store transformation in database for analytics
     */
    private function storeTransformation(string $transformationType, string $inputText, string $outputText): void
    {
        try {
            Transformation::create([
                'transformation_type' => $transformationType,
                'input_text' => substr($inputText, 0, 10000), // Limit stored text length
                'output_text' => substr($outputText, 0, 10000),
                'user_ip' => request()?->ip(),
                'user_agent' => substr(request()?->userAgent() ?? '', 0, 500)
            ]);
        } catch (Exception $e) {
            // Don't fail transformation if storage fails
            Log::error('Failed to store transformation', [
                'transformation_type' => $transformationType,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get list of transformations that can work with empty input (generators)
     */
    private function getGeneratorTransformations(): array
    {
        return [
            'password-generator',
            'uuid-generator',
            'random-number',
            'random-letter',
            'random-date',
            'random-month',
            'random-ip',
            'lorem-ipsum',
            'username-generator',
            'email-generator',
            'hex-color',
            'phone-number'
        ];
    }

    protected function toUpperCase(string $text): string
    {
        try {
            if (empty($text)) {
                return '';
            }
            return mb_strtoupper($text, 'UTF-8');
        } catch (Exception $e) {
            Log::error('Upper case transformation failed', ['error' => $e->getMessage()]);
            throw new Exception('Failed to convert to upper case');
        }
    }

    protected function toLowerCase(string $text): string
    {
        try {
            if (empty($text)) {
                return '';
            }
            return mb_strtolower($text, 'UTF-8');
        } catch (Exception $e) {
            Log::error('Lower case transformation failed', ['error' => $e->getMessage()]);
            throw new Exception('Failed to convert to lower case');
        }
    }

    protected function toTitleCase(string $text): string
    {
        try {
            if (empty($text)) {
                return '';
            }
            return ucwords(strtolower($text));
        } catch (Exception $e) {
            Log::error('Title case transformation failed', ['error' => $e->getMessage()]);
            throw new Exception('Failed to convert to title case');
        }
    }

    protected function toSentenceCase(string $text): string
    {
        try {
            if (empty($text)) {
                return '';
            }
            $text = mb_strtolower($text, 'UTF-8');
            // Capitalize first letter
            $text = mb_strtoupper(mb_substr($text, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($text, 1, null, 'UTF-8');
            // Capitalize after periods, exclamation marks, and question marks
            $text = preg_replace_callback('/([.!?]\s+)([a-z])/u', function($matches) {
                return $matches[1] . mb_strtoupper($matches[2], 'UTF-8');
            }, $text);
            return $text;
        } catch (Exception $e) {
            Log::error('Sentence case transformation failed', ['error' => $e->getMessage()]);
            throw new Exception('Failed to convert to sentence case');
        }
    }

    protected function toCapitalizeWords(string $text): string
    {
        try {
            if (empty($text)) {
                return '';
            }
            return ucwords($text);
        } catch (Exception $e) {
            Log::error('Capitalize words transformation failed', ['error' => $e->getMessage()]);
            throw new Exception('Failed to capitalize words');
        }
    }

    protected function toAlternatingCase(string $text): string
    {
        try {
            if (empty($text)) {
                return '';
            }
            $result = '';
            $chars = mb_str_split($text, 1, 'UTF-8');
            for ($i = 0; $i < count($chars); $i++) {
                $result .= ($i % 2 === 0) ? mb_strtolower($chars[$i], 'UTF-8') : mb_strtoupper($chars[$i], 'UTF-8');
            }
            return $result;
        } catch (Exception $e) {
            Log::error('Alternating case transformation failed', ['error' => $e->getMessage()]);
            throw new Exception('Failed to apply alternating case');
        }
    }

    protected function toInverseCase(string $text): string
    {
        $result = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_upper($char)) {
                $result .= strtolower($char);
            } else {
                $result .= strtoupper($char);
            }
        }
        return $result;
    }

    protected function toCamelCase(string $text): string
    {
        $text = ucwords(str_replace(['-', '_'], ' ', $text));
        $text = str_replace(' ', '', $text);
        return lcfirst($text);
    }

    protected function toPascalCase(string $text): string
    {
        $text = ucwords(str_replace(['-', '_'], ' ', $text));
        return str_replace(' ', '', $text);
    }

    protected function toSnakeCase(string $text): string
    {
        // First handle camelCase and PascalCase
        $text = preg_replace('/(?<!^)[A-Z]/', '_$0', $text);
        // Replace spaces and hyphens with underscores
        $text = str_replace([' ', '-'], '_', $text);
        // Remove multiple underscores
        $text = preg_replace('/_+/', '_', $text);
        // Convert to lowercase and trim underscores
        return mb_strtolower(trim($text, '_'), 'UTF-8');
    }

    protected function toConstantCase(string $text): string
    {
        return mb_strtoupper($this->toSnakeCase($text), 'UTF-8');
    }

    protected function toKebabCase(string $text): string
    {
        return str_replace('_', '-', $this->toSnakeCase($text));
    }

    protected function toDotCase(string $text): string
    {
        return str_replace('_', '.', $this->toSnakeCase($text));
    }

    protected function toPathCase(string $text): string
    {
        return str_replace('_', '/', $this->toSnakeCase($text));
    }

    protected function toApStyle(string $text): string
    {
        return "AP Style: " . $this->toTitleCase($text);
    }

    protected function toNytStyle(string $text): string
    {
        return "NY Times Style: " . $this->toTitleCase($text);
    }

    protected function toChicagoStyle(string $text): string
    {
        return "Chicago Style: " . $this->toTitleCase($text);
    }

    protected function toGuardianStyle(string $text): string
    {
        return "Guardian Style: " . $this->toTitleCase($text);
    }

    protected function toBbcStyle(string $text): string
    {
        return "BBC Style: " . $this->toTitleCase($text);
    }

    protected function toReutersStyle(string $text): string
    {
        return "Reuters Style: " . $this->toTitleCase($text);
    }

    protected function toEconomistStyle(string $text): string
    {
        return "Economist Style: " . $this->toTitleCase($text);
    }

    protected function toWsjStyle(string $text): string
    {
        return "WSJ Style: " . $this->toTitleCase($text);
    }

    protected function toApaStyle(string $text): string
    {
        return "APA Style: " . $this->toSentenceCase($text);
    }

    protected function toMlaStyle(string $text): string
    {
        return "MLA Style: " . $this->toTitleCase($text);
    }

    protected function toChicagoAuthorDate(string $text): string
    {
        return "Chicago Author-Date: " . $this->toSentenceCase($text);
    }

    protected function toChicagoNotes(string $text): string
    {
        return "Chicago Notes: " . $this->toTitleCase($text);
    }

    protected function toHarvardStyle(string $text): string
    {
        return "Harvard Style: " . $this->toSentenceCase($text);
    }

    protected function toVancouverStyle(string $text): string
    {
        return "Vancouver Style: " . $this->toSentenceCase($text);
    }

    protected function toIeeeStyle(string $text): string
    {
        return "IEEE Style: " . $this->toTitleCase($text);
    }

    protected function toAmaStyle(string $text): string
    {
        return "AMA Style: " . $this->toSentenceCase($text);
    }

    protected function toBluebookStyle(string $text): string
    {
        return "Bluebook Style: " . $this->toTitleCase($text);
    }

    protected function toReverse(string $text): string
    {
        return strrev($text);
    }

    protected function toAesthetic(string $text): string
    {
        return implode(' ', str_split(strtoupper($text)));
    }

    protected function toSarcasm(string $text): string
    {
        $result = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $result .= ($i % 2 === 0) ? strtolower($text[$i]) : strtoupper($text[$i]);
        }
        return $result;
    }

    protected function toSmallcaps(string $text): string
    {
        return "Small Caps: " . strtoupper($text);
    }

    protected function toBubble(string $text): string
    {
        return "Bubble Text: " . $text;
    }

    protected function toSquare(string $text): string
    {
        return "Square Text: " . $text;
    }

    protected function toScript(string $text): string
    {
        return "Script: " . $text;
    }

    protected function toDoubleStruck(string $text): string
    {
        return "Double Struck: " . $text;
    }

    protected function toBold(string $text): string
    {
        return "**" . $text . "**";
    }

    protected function toItalic(string $text): string
    {
        return "*" . $text . "*";
    }

    protected function toEmojiCase(string $text): string
    {
        return $text . " ✨";
    }

    protected function toEmailStyle(string $text): string
    {
        return "Email Style: " . $this->toSentenceCase($text);
    }

    protected function toLegalStyle(string $text): string
    {
        return "Legal Style: " . strtoupper($text);
    }

    protected function toMarketingHeadline(string $text): string
    {
        return "Marketing Headline: " . $this->toTitleCase($text);
    }

    protected function toPressRelease(string $text): string
    {
        return "Press Release: " . $this->toSentenceCase($text);
    }

    protected function toMemoStyle(string $text): string
    {
        return "Memo Style: " . $this->toSentenceCase($text);
    }

    protected function toReportStyle(string $text): string
    {
        return "Report Style: " . $this->toSentenceCase($text);
    }

    protected function toProposalStyle(string $text): string
    {
        return "Proposal Style: " . $this->toTitleCase($text);
    }

    protected function toInvoiceStyle(string $text): string
    {
        return "Invoice Style: " . $this->toSentenceCase($text);
    }

    protected function toTwitterStyle(string $text): string
    {
        return "Twitter/X Style: " . $this->toSentenceCase($text);
    }

    protected function toInstagramStyle(string $text): string
    {
        return "Instagram Style: " . $this->toTitleCase($text);
    }

    protected function toLinkedinStyle(string $text): string
    {
        return "LinkedIn Style: " . $this->toTitleCase($text);
    }

    protected function toFacebookStyle(string $text): string
    {
        return "Facebook Style: " . $this->toSentenceCase($text);
    }

    protected function toYoutubeTitle(string $text): string
    {
        return "YouTube Title: " . $this->toTitleCase($text);
    }

    protected function toTiktokStyle(string $text): string
    {
        return "TikTok Style: " . $this->toSentenceCase($text);
    }

    protected function toHashtagStyle(string $text): string
    {
        return "#" . str_replace(' ', '', $this->toTitleCase($text));
    }

    protected function toMentionStyle(string $text): string
    {
        return "@" . str_replace(' ', '', $this->toCamelCase($text));
    }

    protected function toApiDocs(string $text): string
    {
        return "API Documentation: " . $this->toSentenceCase($text);
    }

    protected function toReadmeStyle(string $text): string
    {
        return "README Style: " . $this->toTitleCase($text);
    }

    protected function toChangelogStyle(string $text): string
    {
        return "Changelog Style: " . $this->toSentenceCase($text);
    }

    protected function toUserManual(string $text): string
    {
        return "User Manual: " . $this->toTitleCase($text);
    }

    protected function toTechnicalSpec(string $text): string
    {
        return "Technical Spec: " . $this->toSentenceCase($text);
    }

    protected function toCodeComments(string $text): string
    {
        return "// " . $this->toSentenceCase($text);
    }

    protected function toWikiStyle(string $text): string
    {
        return "Wiki Style: " . $this->toTitleCase($text);
    }

    protected function toMarkdownStyle(string $text): string
    {
        return "Markdown Style: " . $this->toSentenceCase($text);
    }

    // ================== INTERNATIONAL & REGIONAL FORMATS ==================
    
    protected function toBritishEnglish(string $text): string
    {
        $replacements = [
            "color" => "colour", "center" => "centre", "theater" => "theatre",
            "organize" => "organise", "realize" => "realise", "analyze" => "analyse",
            "defense" => "defence", "license" => "licence", "practice" => "practise"
        ];
        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
    
    protected function toAmericanEnglish(string $text): string
    {
        $replacements = [
            "colour" => "color", "centre" => "center", "theatre" => "theater",
            "organise" => "organize", "realise" => "realize", "analyse" => "analyze",
            "defence" => "defense", "licence" => "license", "practise" => "practice"
        ];
        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
    
    protected function toCanadianEnglish(string $text): string
    {
        $replacements = [
            "color" => "colour", "center" => "centre", "theater" => "theatre",
            "organize" => "organize", "realize" => "realize", "analyze" => "analyse"
        ];
        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
    
    protected function toAustralianEnglish(string $text): string
    {
        $replacements = [
            "color" => "colour", "center" => "centre", "theater" => "theatre",
            "organize" => "organise", "realize" => "realise", "analyze" => "analyse"
        ];
        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
    
    protected function toEUFormat(string $text): string
    {
        // EU date format: DD/MM/YYYY
        $text = preg_replace('/\b(\d{1,2})\/(\d{1,2})\/(\d{4})\b/', '$2/$1/$3', $text);
        // EU decimal separator
        $text = preg_replace('/\b(\d+)\.(\d+)\b/', '$1,$2', $text);
        return $text;
    }
    
    protected function toISOFormat(string $text): string
    {
        // ISO 8601 date format
        $text = preg_replace('/\b(\d{1,2})\/(\d{1,2})\/(\d{4})\b/', '$3-$1-$2', $text);
        return $text;
    }
    
    protected function toUnicodeNormalize(string $text): string
    {
        if (class_exists('Normalizer')) {
            return \Normalizer::normalize($text, \Normalizer::FORM_C);
        }
        return $text;
    }
    
    protected function toASCIIConvert(string $text): string
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    }
    
    // ================== UTILITY TRANSFORMATIONS ==================
    
    protected function toRemoveSpaces(string $text): string
    {
        return str_replace(' ', '', $text);
    }
    
    protected function toRemoveExtraSpaces(string $text): string
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }
    
    protected function toAddDashes(string $text): string
    {
        return str_replace(' ', '-', $text);
    }
    
    protected function toAddUnderscores(string $text): string
    {
        return str_replace(' ', '_', $text);
    }
    
    protected function toAddPeriods(string $text): string
    {
        return str_replace(' ', '.', $text);
    }
    
    protected function toRemovePunctuation(string $text): string
    {
        return preg_replace('/[[:punct:]]/', '', $text);
    }
    
    protected function toExtractLetters(string $text): string
    {
        return preg_replace('/[^a-zA-Z]/', '', $text);
    }
    
    protected function toExtractNumbers(string $text): string
    {
        return preg_replace('/[^0-9]/', '', $text);
    }
    
    protected function toRemoveDuplicates(string $text): string
    {
        $words = explode(' ', $text);
        return implode(' ', array_unique($words));
    }
    
    protected function toSortWords(string $text): string
    {
        $words = explode(' ', $text);
        sort($words);
        return implode(' ', $words);
    }
    
    protected function toShuffleWords(string $text): string
    {
        $words = explode(' ', $text);
        shuffle($words);
        return implode(' ', $words);
    }
    
    // ================== TEXT EFFECTS ==================
    
    protected function toBoldText(string $text): string
    {
        $normal = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $bold = '𝗔𝗕𝗖𝗗𝗘𝗙𝗚𝗛𝗜𝗝𝗞𝗟𝗠𝗡𝗢𝗣𝗤𝗥𝗦𝗧𝗨𝗩𝗪𝗫𝗬𝗭𝗮𝗯𝗰𝗱𝗲𝗳𝗴𝗵𝗶𝗷𝗸𝗹𝗺𝗻𝗼𝗽𝗾𝗿𝘀𝘁𝘂𝘃𝘄𝘅𝘆𝘇𝟬𝟭𝟮𝟯𝟰𝟱𝟲𝟳𝟴𝟵';
        return strtr($text, $normal, $bold);
    }
    
    protected function toItalicText(string $text): string
    {
        $normal = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $italic = '𝘈𝘉𝘊𝘋𝘌𝘍𝘎𝘏𝘐𝘑𝘒𝘓𝘔𝘕𝘖𝘗𝘘𝘙𝘚𝘛𝘜𝘝𝘞𝘟𝘠𝘡𝘢𝘣𝘤𝘥𝘦𝘧𝘨𝘩𝘪𝘫𝘬𝘭𝘮𝘯𝘰𝘱𝘲𝘳𝘴𝘵𝘶𝘷𝘸𝘹𝘺𝘻';
        return strtr($text, $normal, $italic);
    }
    
    protected function toStrikethroughText(string $text): string
    {
        return preg_replace('/(.)/u', '$1̶', $text);
    }
    
    protected function toUnderlineText(string $text): string
    {
        return preg_replace('/(.)/u', '$1̲', $text);
    }
    
    protected function toSuperscript(string $text): string
    {
        $normal = 'abcdefghijklmnopqrstuvwxyz0123456789+-=()';
        $super = 'ᵃᵇᶜᵈᵉᶠᵍʰⁱʲᵏˡᵐⁿᵒᵖᵠʳˢᵗᵘᵛʷˣʸᶻ⁰¹²³⁴⁵⁶⁷⁸⁹⁺⁻⁼⁽⁾';
        return strtr(mb_strtolower($text), $normal, $super);
    }
    
    protected function toSubscript(string $text): string
    {
        $normal = 'aehijklmnoprstuvx0123456789+-=()';
        $sub = 'ₐₑₕᵢⱼₖₗₘₙₒₚᵣₛₜᵤᵥₓ₀₁₂₃₄₅₆₇₈₉₊₋₌₍₎';
        return strtr(mb_strtolower($text), $normal, $sub);
    }
    
    protected function toWideText(string $text): string
    {
        $normal = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789 ';
        $wide = 'ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚ０１２３４５６７８９　';
        return strtr($text, $normal, $wide);
    }
    
    protected function toUpsideDown(string $text): string
    {
        $normal = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $flipped = 'ɐqɔpǝɟƃɥᴉɾʞlɯuodbɹsʇnʌʍxʎz∀qƆpƎℲפHIſʞ˥WNOԀQɹS┴∩ΛMX⅄Z';
        return strrev(strtr($text, $normal, $flipped));
    }
    
    protected function toMirrorText(string $text): string
    {
        return strrev($text);
    }
    
    protected function toZalgoText(string $text): string
    {
        $zalgo = ['̍', '̎', '̄', '̅', '̿', '̑', '̆', '̐', '͒', '͗'];
        $result = '';
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $result .= mb_substr($text, $i, 1);
            for ($j = 0; $j < rand(1, 3); $j++) {
                $result .= $zalgo[array_rand($zalgo)];
            }
        }
        return $result;
    }
    
    protected function toCursedText(string $text): string
    {
        $cursed = ['̷', '̸', '̶', '̴'];
        return preg_replace_callback('/(.)/u', function($m) use ($cursed) {
            return $m[1] . $cursed[array_rand($cursed)];
        }, $text);
    }
    
    protected function toInvisibleText(string $text): string
    {
        // Zero-width characters
        return preg_replace('/(.)/u', '$1​', $text); // Zero-width space U+200B
    }
    
    // ================== GENERATORS ==================
    
    protected function toPasswordGenerator(string $text): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        $length = strlen($text) > 0 ? min(32, max(8, strlen($text))) : 16;
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    
    protected function toUUIDGenerator(string $text): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    
    protected function toRandomNumber(string $text): string
    {
        $words = explode(' ', $text);
        $result = [];
        foreach ($words as $word) {
            $result[] = rand(1, 999);
        }
        return implode(' ', $result);
    }
    
    protected function toRandomLetter(string $text): string
    {
        $letters = 'abcdefghijklmnopqrstuvwxyz';
        $words = explode(' ', $text);
        $result = [];
        foreach ($words as $word) {
            $randomWord = '';
            for ($i = 0; $i < strlen($word); $i++) {
                $randomWord .= $letters[rand(0, 25)];
            }
            $result[] = $randomWord;
        }
        return implode(' ', $result);
    }
    
    protected function toRandomDate(string $text): string
    {
        $start = strtotime('2020-01-01');
        $end = strtotime('2025-12-31');
        $timestamp = mt_rand($start, $end);
        return date('Y-m-d', $timestamp);
    }
    
    protected function toRandomMonth(string $text): string
    {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                  'July', 'August', 'September', 'October', 'November', 'December'];
        return $months[rand(0, 11)];
    }
    
    protected function toRandomIP(string $text): string
    {
        return rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 255);
    }
    
    protected function toRandomChoice(string $text): string
    {
        $choices = explode(',', $text);
        if (count($choices) > 0) {
            return trim($choices[array_rand($choices)]);
        }
        return $text;
    }
    
    protected function toLoremIpsum(string $text): string
    {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
        return $lorem;
    }
    
    protected function toUsernameGenerator(string $text): string
    {
        $adjectives = ['cool', 'super', 'mega', 'ultra', 'pro', 'epic'];
        $nouns = ['gamer', 'coder', 'ninja', 'wizard', 'master', 'legend'];
        return $adjectives[array_rand($adjectives)] . '_' . $nouns[array_rand($nouns)] . rand(10, 999);
    }
    
    protected function toEmailGenerator(string $text): string
    {
        $username = $this->toUsernameGenerator($text);
        $domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'example.com'];
        return strtolower(str_replace('_', '.', $username)) . '@' . $domains[array_rand($domains)];
    }
    
    protected function toHexColor(string $text): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
    
    protected function toPhoneNumber(string $text): string
    {
        return sprintf('(%03d) %03d-%04d', rand(200, 999), rand(200, 999), rand(1000, 9999));
    }
    
    // ================== CODE & DATA TOOLS ==================
    
    protected function toBinaryTranslator(string $text): string
    {
        $result = [];
        for ($i = 0; $i < strlen($text); $i++) {
            $result[] = sprintf("%08b", ord($text[$i]));
        }
        return implode(' ', $result);
    }
    
    protected function toHexConverter(string $text): string
    {
        return bin2hex($text);
    }
    
    protected function toMorseCode(string $text): string
    {
        $morse = [
            'A' => '.-', 'B' => '-...', 'C' => '-.-.', 'D' => '-..', 'E' => '.',
            'F' => '..-.', 'G' => '--.', 'H' => '....', 'I' => '..', 'J' => '.---',
            'K' => '-.-', 'L' => '.-..', 'M' => '--', 'N' => '-.', 'O' => '---',
            'P' => '.--.', 'Q' => '--.-', 'R' => '.-.', 'S' => '...', 'T' => '-',
            'U' => '..-', 'V' => '...-', 'W' => '.--', 'X' => '-..-', 'Y' => '-.--',
            'Z' => '--..', '1' => '.----', '2' => '..---', '3' => '...--', '4' => '....-',
            '5' => '.....', '6' => '-....', '7' => '--...', '8' => '---..', '9' => '----.',
            '0' => '-----', ' ' => ' / '
        ];
        $text = strtoupper($text);
        $result = [];
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (isset($morse[$char])) {
                $result[] = $morse[$char];
            }
        }
        return implode(' ', $result);
    }
    
    protected function toCaesarCipher(string $text): string
    {
        $shift = 3;
        $result = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_upper($char)) {
                $result .= chr((ord($char) - 65 + $shift) % 26 + 65);
            } elseif (ctype_lower($char)) {
                $result .= chr((ord($char) - 97 + $shift) % 26 + 97);
            } else {
                $result .= $char;
            }
        }
        return $result;
    }
    
    private function toMD5Hash(string $text): string
    {
        return md5($text);
    }
    
    private function toSHA256Hash(string $text): string
    {
        return hash('sha256', $text);
    }
    
    protected function toJSONFormatter(string $text): string
    {
        $decoded = json_decode($text);
        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_PRETTY_PRINT);
        }
        // If not valid JSON, convert to JSON
        return json_encode($text);
    }
    
    protected function toCSVtoJSON(string $text): string
    {
        $lines = explode("\n", $text);
        if (count($lines) > 0) {
            $headers = str_getcsv($lines[0]);
            $result = [];
            for ($i = 1; $i < count($lines); $i++) {
                if (trim($lines[$i]) !== '') {
                    $data = str_getcsv($lines[$i]);
                    if (count($data) === count($headers)) {
                        $result[] = array_combine($headers, $data);
                    }
                }
            }
            return json_encode($result, JSON_PRETTY_PRINT);
        }
        return '[]';
    }
    
    protected function toCSSFormatter(string $text): string
    {
        // Basic CSS formatting
        $text = preg_replace('/\s*{\s*/', ' {\n  ', $text);
        $text = preg_replace('/;\s*/', ';\n  ', $text);
        $text = preg_replace('/\s*}\s*/', '\n}\n', $text);
        return trim($text);
    }
    
    protected function toHTMLFormatter(string $text): string
    {
        // Basic HTML formatting
        $text = preg_replace('/></', '>\n<', $text);
        return $text;
    }
    
    protected function toJavaScriptFormatter(string $text): string
    {
        // Basic JS formatting
        $text = preg_replace('/;\s*/', ';\n', $text);
        $text = preg_replace('/\{\s*/', ' {\n  ', $text);
        $text = preg_replace('/\}\s*/', '\n}\n', $text);
        return $text;
    }
    
    protected function toXMLFormatter(string $text): string
    {
        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        @$dom->loadXML($text);
        return $dom->saveXML();
    }
    
    protected function toYAMLFormatter(string $text): string
    {
        // Basic YAML formatting
        $lines = explode("\n", $text);
        $formatted = [];
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed !== '') {
                $formatted[] = $trimmed;
            }
        }
        return implode("\n", $formatted);
    }
    
    private function toUTF8Converter(string $text): string
    {
        return mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($text));
    }
    
    protected function toUTMBuilder(string $text): string
    {
        $url = trim($text);
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $separator = strpos($url, '?') === false ? '?' : '&';
            return $url . $separator . 'utm_source=website&utm_medium=tool&utm_campaign=case-changer';
        }
        return $text;
    }
    
    protected function toSlugifyGenerator(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        return strtolower($text);
    }
    
    // ================== TEXT ANALYSIS & CLEANUP ==================
    
    protected function toSentenceCounter(string $text): string
    {
        $sentences = preg_split('/[.!?]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $count = count($sentences);
        return "Sentence count: " . $count . "\n\n" . $text;
    }
    
    protected function toDuplicateFinder(string $text): string
    {
        $words = str_word_count($text, 1);
        $counts = array_count_values($words);
        $duplicates = array_filter($counts, function($count) { return $count > 1; });
        $result = "Duplicates found:\n";
        foreach ($duplicates as $word => $count) {
            $result .= "$word: $count times\n";
        }
        return $result;
    }
    
    protected function toDuplicateRemover(string $text): string
    {
        $lines = explode("\n", $text);
        return implode("\n", array_unique($lines));
    }
    
    protected function toTextReplacer(string $text): string
    {
        // Default example: replace "old" with "new"
        return str_replace('old', 'new', $text);
    }
    
    protected function toLineBreakRemover(string $text): string
    {
        return str_replace(["\r\n", "\r", "\n"], ' ', $text);
    }
    
    protected function toPlainTextConverter(string $text): string
    {
        $text = strip_tags($text);
        $text = html_entity_decode($text);
        return $text;
    }
    
    protected function toRemoveFormatting(string $text): string
    {
        return strip_tags(html_entity_decode($text));
    }
    
    protected function toRemoveLetters(string $text): string
    {
        return preg_replace('/[a-zA-Z]/', '', $text);
    }
    
    protected function toRemoveUnderscores(string $text): string
    {
        return str_replace('_', ' ', $text);
    }
    
    protected function toWhitespaceRemover(string $text): string
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }
    
    protected function toRepeatText(string $text): string
    {
        return str_repeat($text . ' ', 3);
    }
    
    protected function toPhoneticSpelling(string $text): string
    {
        $phonetic = [
            'a' => 'ay', 'b' => 'bee', 'c' => 'see', 'd' => 'dee', 'e' => 'ee',
            'f' => 'eff', 'g' => 'jee', 'h' => 'aych', 'i' => 'eye', 'j' => 'jay',
            'k' => 'kay', 'l' => 'el', 'm' => 'em', 'n' => 'en', 'o' => 'oh',
            'p' => 'pee', 'q' => 'cue', 'r' => 'ar', 's' => 'ess', 't' => 'tee',
            'u' => 'you', 'v' => 'vee', 'w' => 'double-you', 'x' => 'ex', 'y' => 'why',
            'z' => 'zee'
        ];
        $result = [];
        for ($i = 0; $i < strlen($text); $i++) {
            $char = strtolower($text[$i]);
            $result[] = isset($phonetic[$char]) ? $phonetic[$char] : $text[$i];
        }
        return implode(' ', $result);
    }
    
    protected function toPigLatin(string $text): string
    {
        $words = explode(' ', $text);
        $result = [];
        foreach ($words as $word) {
            if (preg_match('/^[aeiouAEIOU]/', $word)) {
                $result[] = $word . 'way';
            } else {
                $result[] = substr($word, 1) . substr($word, 0, 1) . 'ay';
            }
        }
        return implode(' ', $result);
    }
    
    // ================== SOCIAL MEDIA GENERATORS ==================
    
    protected function toDiscordFont(string $text): string
    {
        return '**' . $text . '**'; // Bold for Discord
    }
    
    protected function toFacebookFont(string $text): string
    {
        return $this->toBoldText($text);
    }
    
    protected function toInstagramFont(string $text): string
    {
        return $this->toItalicText($text);
    }
    
    protected function toTwitterFont(string $text): string
    {
        return $this->toBoldText($text);
    }
    
    protected function toBigText(string $text): string
    {
        $normal = 'abcdefghijklmnopqrstuvwxyz';
        $big = 'ⒶⒷⒸⒹⒺⒻⒼⒽⒾⒿⓀⓁⓂⓃⓄⓅⓆⓇⓈⓉⓊⓋⓌⓍⓎⓏ';
        return strtr(strtolower($text), $normal, $big);
    }
    
    protected function toSlashText(string $text): string
    {
        return preg_replace('/(.)/u', '$1/', $text);
    }
    
    protected function toStackedText(string $text): string
    {
        $chars = str_split($text);
        return implode("\n", $chars);
    }
    
    protected function toWingdings(string $text): string
    {
        $normal = 'abcdefghijklmnopqrstuvwxyz';
        $wingdings = '♋♌♍♎♏♐♑♒♓♔♕♖♗♘♙♚♛♜♝♞♟♠♡♢♣♤♥♦';
        return strtr(strtolower($text), $normal, $wingdings);
    }
    
    // ================== MISCELLANEOUS ==================
    
    protected function toNATOPhonetic(string $text): string
    {
        $nato = [
            'A' => 'Alpha', 'B' => 'Bravo', 'C' => 'Charlie', 'D' => 'Delta',
            'E' => 'Echo', 'F' => 'Foxtrot', 'G' => 'Golf', 'H' => 'Hotel',
            'I' => 'India', 'J' => 'Juliet', 'K' => 'Kilo', 'L' => 'Lima',
            'M' => 'Mike', 'N' => 'November', 'O' => 'Oscar', 'P' => 'Papa',
            'Q' => 'Quebec', 'R' => 'Romeo', 'S' => 'Sierra', 'T' => 'Tango',
            'U' => 'Uniform', 'V' => 'Victor', 'W' => 'Whiskey', 'X' => 'X-ray',
            'Y' => 'Yankee', 'Z' => 'Zulu'
        ];
        $result = [];
        for ($i = 0; $i < strlen($text); $i++) {
            $char = strtoupper($text[$i]);
            $result[] = isset($nato[$char]) ? $nato[$char] : $text[$i];
        }
        return implode(' ', $result);
    }
    
    protected function toRomanNumerals(string $text): string
    {
        // Convert numbers to Roman numerals
        if (!is_numeric($text)) {
            return $text;
        }
        $n = intval($text);
        $result = '';
        $lookup = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ];
        foreach ($lookup as $roman => $value) {
            $matches = intval($n / $value);
            $result .= str_repeat($roman, $matches);
            $n = $n % $value;
        }
        return $result;
    }

    // Developer Tools Methods
    protected function toSqlCase(string $text): string {
        try {
            if (empty($text)) {
                return '';
            }
            return strtoupper(str_replace([" ", "-"], "_", $text));
        } catch (Exception $e) {
            Log::error('SQL case transformation failed', ['error' => $e->getMessage()]);
            throw new Exception('Failed to convert to SQL case');
        }
    }
    
    protected function toPythonCase(string $text): string {
        return str_replace([" ", "-"], "_", strtolower($text));
    }
    
    protected function toJavaCase(string $text): string {
        return lcfirst(str_replace(" ", "", ucwords(str_replace(["-", "_"], " ", $text))));
    }
    
    protected function toPhpCase(string $text): string {
        return "$" . str_replace([" ", "-"], "_", strtolower($text));
    }
    
    protected function toRubyCase(string $text): string {
        return "@" . str_replace([" ", "-"], "_", strtolower($text));
    }
    
    protected function toGoCase(string $text): string {
        return ucfirst(str_replace(" ", "", ucwords(str_replace(["-", "_"], " ", $text))));
    }
    
    protected function toRustCase(string $text): string {
        return str_replace([" ", "-"], "_", strtolower($text));
    }
    
    protected function toSwiftCase(string $text): string {
        return lcfirst(str_replace(" ", "", ucwords(str_replace(["-", "_"], " ", $text))));
    }
    
    // Text Analysis Methods
    protected function toReadingTime(string $text): string {
        $wordCount = str_word_count($text);
        $minutes = ceil($wordCount / 200); // Average reading speed
        return "$minutes minute" . ($minutes > 1 ? "s" : "") . " read time";
    }
    
    protected function toFleschScore(string $text): string {
        $sentences = max(1, preg_match_all('/[.!?]+/', $text, $matches));
        $words = str_word_count($text);
        $syllables = $this->countSyllables($text);
        
        if ($words == 0) return "N/A";
        
        $score = 206.835 - 1.015 * ($words / $sentences) - 84.6 * ($syllables / $words);
        return "Flesch Score: " . round($score, 1);
    }
    
    protected function toSentimentAnalysis(string $text): string {
        $positive = preg_match_all('/\b(good|great|excellent|amazing|wonderful|fantastic|love|happy)\b/i', $text);
        $negative = preg_match_all('/\b(bad|terrible|awful|horrible|hate|sad|angry|disappointed)\b/i', $text);
        
        if ($positive > $negative) return "Positive sentiment";
        if ($negative > $positive) return "Negative sentiment";
        return "Neutral sentiment";
    }
    
    protected function toKeywordExtractor(string $text): string {
        $words = str_word_count(strtolower($text), 1);
        $stopWords = ['the', 'is', 'at', 'which', 'on', 'a', 'an', 'and', 'or', 'but'];
        $keywords = array_diff($words, $stopWords);
        $freq = array_count_values($keywords);
        arsort($freq);
        return implode(", ", array_slice(array_keys($freq), 0, 5));
    }
    
    protected function toSyllableCounter(string $text): string {
        $count = $this->countSyllables($text);
        return "$count syllables";
    }
    
    protected function toParagraphCounter(string $text): string {
        $paragraphs = preg_split('/\n\n+/', trim($text));
        $count = count(array_filter($paragraphs));
        return "$count paragraph" . ($count !== 1 ? "s" : "");
    }
    
    protected function toUniqueWords(string $text): string {
        $words = str_word_count(strtolower($text), 1);
        $unique = count(array_unique($words));
        return "$unique unique words";
    }
    
    // Advanced Format Methods
    protected function toScientificNotation(string $text): string {
        if (is_numeric($text)) {
            $num = (float)$text;
            if ($num == 0) return "0";
            $exp = floor(log10(abs($num)));
            $mantissa = $num / pow(10, $exp);
            return sprintf("%.2fe%+d", $mantissa, $exp);
        }
        return $text;
    }
    
    protected function toEngineeringNotation(string $text): string {
        if (is_numeric($text)) {
            $num = (float)$text;
            if ($num == 0) return "0";
            $exp = floor(log10(abs($num)) / 3) * 3;
            $mantissa = $num / pow(10, $exp);
            return sprintf("%.2fe%+d", $mantissa, $exp);
        }
        return $text;
    }
    
    protected function toFractionConverter(string $text): string {
        if (is_numeric($text)) {
            $decimal = (float)$text;
            $whole = floor($decimal);
            $fraction = $decimal - $whole;
            
            if ($fraction == 0) return "$whole";
            
            // Simple fraction approximation
            $numerator = round($fraction * 100);
            $denominator = 100;
            $gcd = $this->gcd($numerator, $denominator);
            $numerator /= $gcd;
            $denominator /= $gcd;
            
            return $whole > 0 ? "$whole $numerator/$denominator" : "$numerator/$denominator";
        }
        return $text;
    }
    
    protected function toPercentageFormat(string $text): string {
        if (is_numeric($text)) {
            return round((float)$text * 100, 2) . "%";
        }
        return $text;
    }
    
    protected function toCurrencyFormat(string $text): string {
        if (is_numeric($text)) {
            return "$" . number_format((float)$text, 2);
        }
        return $text;
    }
    
    protected function toOrdinalNumbers(string $text): string {
        return preg_replace_callback('/\b(\d+)\b/', function($matches) {
            $num = $matches[1];
            $suffix = ['th', 'st', 'nd', 'rd'];
            $mod = $num % 100;
            return $num . ($suffix[($mod - 20) % 10] ?? $suffix[$mod] ?? $suffix[0]);
        }, $text);
    }
    
    protected function toSpelledNumbers(string $text): string {
        $numbers = [
            '0' => 'zero', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four',
            '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine'
        ];
        return strtr($text, $numbers);
    }
    
    // Helper methods
    private function countSyllables($text) {
        $text = strtolower($text);
        $syllables = 0;
        $words = str_word_count($text, 1);
        
        foreach ($words as $word) {
            $syllables += max(1, preg_match_all('/[aeiou]/i', $word, $matches));
        }
        
        return $syllables;
    }
    
    private function gcd($a, $b) {
        return $b ? $this->gcd($b, $a % $b) : $a;
    }
    
    // ================== ENCODING/DECODING METHODS ==================
    
    private function toBase64Encode($text) {
        return base64_encode($text);
    }
    
    private function toBase64Decode($text) {
        $decoded = base64_decode($text, true);
        return $decoded !== false ? $decoded : "Invalid Base64 input";
    }
    
    protected function toUrlEncode(string $text): string {
        return urlencode($text);
    }
    
    protected function toUrlDecode(string $text): string {
        return urldecode($text);
    }
    
    protected function toHtmlEncode(string $text): string {
        return htmlentities($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    
    protected function toHtmlDecode(string $text): string {
        return html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    
    protected function toJsonEscape(string $text): string {
        return json_encode($text, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
    
    protected function toJsonUnescape(string $text): string {
        $decoded = json_decode('"' . $text . '"');
        return $decoded !== null ? $decoded : $text;
    }
    
    protected function toXmlEscape(string $text): string {
        return htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
    
    protected function toXmlUnescape(string $text): string {
        return htmlspecialchars_decode($text, ENT_XML1 | ENT_QUOTES);
    }
    
    protected function toSqlEscape(string $text): string {
        return str_replace(["'", '"', "\\", "\0", "\n", "\r", "\x1a"], 
                          ["''", '""', "\\\\", "\\0", "\\n", "\\r", "\\Z"], $text);
    }
    
    protected function toRegexEscape(string $text): string {
        return preg_quote($text, '/');
    }
    
    protected function toCsvEscape(string $text): string {
        if (strpos($text, ',') !== false || strpos($text, '"') !== false || strpos($text, "\n") !== false) {
            return '"' . str_replace('"', '""', $text) . '"';
        }
        return $text;
    }
    
    protected function toShellEscape(string $text): string {
        return escapeshellarg($text);
    }
    
    protected function toJavascriptEscape(string $text): string {
        return json_encode($text, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
    
    protected function toBackslashEscape(string $text): string {
        return addslashes($text);
    }
    
    protected function toDoubleQuoteEscape(string $text): string {
        return str_replace('"', '\\"', $text);
    }
    
    protected function toSingleQuoteEscape(string $text): string {
        return str_replace("'", "\\'", $text);
    }
    
    // ================== TEXT FORMATTING METHODS ==================
    
    protected function toTabToSpaces(string $text): string {
        return str_replace("\t", "    ", $text);
    }
    
    protected function toSpacesToTabs(string $text): string {
        return str_replace("    ", "\t", $text);
    }
    
    protected function toIndentText(string $text): string {
        $lines = explode("\n", $text);
        return implode("\n", array_map(function($line) {
            return "    " . $line;
        }, $lines));
    }
    
    protected function toOutdentText(string $text): string {
        $lines = explode("\n", $text);
        return implode("\n", array_map(function($line) {
            return preg_replace('/^    /', '', $line);
        }, $lines));
    }
    
    protected function toWrapText(string $text): string {
        return wordwrap($text, 80, "\n", true);
    }
    
    protected function toUnwrapText(string $text): string {
        return str_replace(["\n", "\r"], " ", $text);
    }
    
    protected function toJustifyText(string $text): string {
        $lines = explode("\n", $text);
        $justified = [];
        foreach ($lines as $line) {
            if (strlen($line) < 80) {
                $words = explode(' ', $line);
                if (count($words) > 1) {
                    $spaces = 80 - strlen(str_replace(' ', '', $line));
                    $gaps = count($words) - 1;
                    if ($gaps > 0) {
                        $spacePerGap = floor($spaces / $gaps);
                        $extraSpaces = $spaces % $gaps;
                        $result = '';
                        foreach ($words as $i => $word) {
                            $result .= $word;
                            if ($i < count($words) - 1) {
                                $result .= str_repeat(' ', $spacePerGap + ($i < $extraSpaces ? 1 : 0));
                            }
                        }
                        $justified[] = $result;
                    } else {
                        $justified[] = $line;
                    }
                } else {
                    $justified[] = $line;
                }
            } else {
                $justified[] = $line;
            }
        }
        return implode("\n", $justified);
    }
    
    protected function toCenterText(string $text): string {
        $lines = explode("\n", $text);
        $centered = [];
        foreach ($lines as $line) {
            $padding = max(0, floor((80 - strlen($line)) / 2));
            $centered[] = str_repeat(' ', $padding) . $line;
        }
        return implode("\n", $centered);
    }
    
    protected function toRightAlign(string $text): string {
        $lines = explode("\n", $text);
        $aligned = [];
        foreach ($lines as $line) {
            $padding = max(0, 80 - strlen($line));
            $aligned[] = str_repeat(' ', $padding) . $line;
        }
        return implode("\n", $aligned);
    }
    
    protected function toLeftAlign(string $text): string {
        return $text; // Already left-aligned by default
    }
    
    // ================== VISUAL TEXT EFFECTS ==================
    
    protected function toVerticalText(string $text): string {
        $chars = mb_str_split($text);
        return implode("\n", $chars);
    }
    
    protected function toDiagonalText(string $text): string {
        $chars = mb_str_split($text);
        $result = [];
        foreach ($chars as $i => $char) {
            $result[] = str_repeat(' ', $i) . $char;
        }
        return implode("\n", $result);
    }
    
    protected function toWaveText(string $text): string {
        $chars = mb_str_split($text);
        $result = [];
        foreach ($chars as $i => $char) {
            $offset = round(sin($i * 0.5) * 3) + 3;
            $result[] = str_repeat(' ', $offset) . $char;
        }
        return implode("\n", $result);
    }
    
    protected function toCircleText(string $text): string {
        // Simple ASCII circle approximation
        $length = strlen($text);
        if ($length < 8) {
            $text = str_pad($text, 8, ' ');
            $length = 8;
        }
        $quarter = floor($length / 4);
        return "  " . substr($text, 0, $quarter) . "\n" .
               substr($text, $length - $quarter, $quarter) . "    " . substr($text, $quarter, $quarter) . "\n" .
               "  " . substr($text, $length - $quarter * 2, $quarter);
    }
    
    protected function toSpiralText(string $text): string {
        $chars = mb_str_split($text);
        $result = [];
        foreach ($chars as $i => $char) {
            $angle = $i * 0.5;
            $radius = $i * 0.3;
            $x = round(cos($angle) * $radius);
            $y = round(sin($angle) * $radius);
            $padding = str_repeat(' ', max(0, $x + 20));
            if (!isset($result[$y + 10])) {
                $result[$y + 10] = str_repeat(' ', 40);
            }
            $line = $result[$y + 10];
            $line[$x + 20] = $char;
            $result[$y + 10] = $line;
        }
        ksort($result);
        return implode("\n", $result);
    }
    
    protected function toRainbowText(string $text): string {
        // Return text with rainbow color codes (for terminal/HTML output)
        $colors = ['🔴', '🟠', '🟡', '🟢', '🔵', '🟣'];
        $chars = mb_str_split($text);
        $result = '';
        foreach ($chars as $i => $char) {
            if ($char !== ' ') {
                $colorIndex = $i % count($colors);
                $result .= $colors[$colorIndex] . $char;
            } else {
                $result .= $char;
            }
        }
        return $result;
    }
    
    protected function toGradientText(string $text): string {
        // Simple gradient effect using Unicode block characters
        $blocks = ['░', '▒', '▓', '█'];
        $length = strlen($text);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $gradientIndex = min(3, floor($i * 4 / $length));
            $result .= $blocks[$gradientIndex] . $text[$i];
        }
        return $result;
    }
    
    protected function toShadowText(string $text): string {
        $lines = explode("\n", $text ?: " ");
        $shadowed = [];
        foreach ($lines as $line) {
            $shadowed[] = $line;
            $shadowed[] = str_repeat('░', mb_strlen($line));
        }
        return implode("\n", $shadowed);
    }
    
    protected function toOutlineText(string $text): string {
        $length = mb_strlen($text);
        $border = str_repeat('─', $length + 2);
        return "┌" . $border . "┐\n│ " . $text . " │\n└" . $border . "┘";
    }
    
    protected function toEmbossText(string $text): string {
        $chars = mb_str_split($text);
        $result = '';
        foreach ($chars as $char) {
            if (ctype_alpha($char)) {
                $result .= '【' . $char . '】';
            } else {
                $result .= $char;
            }
        }
        return $result;
    }
}
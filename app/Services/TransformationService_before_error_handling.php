<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Transformation;
use Exception;
use InvalidArgumentException;

class TransformationService
{
        private $transformations = [
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
        'spelled-numbers' => 'Spelled Numbers'
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
            if (empty($text) && !in_array($transformation, $this->getGeneratorTransformations())) {
                Log::warning('Empty input provided for transformation', [
                    'transformation' => $transformation,
                    'input_length' => strlen($text)
                ]);
                return 'Error: Please provide text to transform.';
            }

            if (strlen($text) > 50000) {
                Log::warning('Input text too long', [
                    'transformation' => $transformation,
                    'input_length' => strlen($text)
                ]);
                return 'Error: Text is too long. Please limit to 50,000 characters.';
            }

            if (!array_key_exists($transformation, $this->transformations)) {
                Log::error('Invalid transformation requested', [
                    'transformation' => $transformation,
                    'available_transformations' => array_keys($this->transformations)
                ]);
                return 'Error: Invalid transformation type.';
            }

            $methodName = 'to' . str_replace(' ', '', ucwords(str_replace('-', ' ', $transformation)));

            if (!method_exists($this, $methodName)) {
                Log::error('Transformation method not found', [
                    'transformation' => $transformation,
                    'method' => $methodName
                ]);
                return 'Error: Transformation method not implemented.';
            }

            $result = $this->executeTransformation($methodName, $text, $transformation);
            
            if (config('app.debug')) {
                Log::info('Transformation completed successfully', [
                    'transformation' => $transformation,
                    'input_length' => strlen($text),
                    'output_length' => strlen($result)
                ]);
            }
            
            $this->storeTransformation($transformation, $text, $result);
            
            return $result;

        } catch (Exception $e) {
            Log::error('Transformation failed with exception', [
                'transformation' => $transformation,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input_length' => strlen($text ?? '')
            ]);
            return 'Error: Transformation failed. Please try again.';
        }
    }

    /**
     * Execute transformation method with error handling
     */
    private function executeTransformation(string $methodName, string $text, string $transformation): string
    {
        try {
            $result = $this->$methodName($text);
            
            if ($result === null || $result === false) {
                throw new Exception('Transformation returned invalid result');
            }
            
            if (!is_string($result)) {
                $result = (string) $result;
            }
            
            return $result;
            
        } catch (Exception $e) {
            Log::error('Transformation method execution failed', [
                'method' => $methodName,
                'transformation' => $transformation,
                'error' => $e->getMessage(),
                'input_length' => strlen($text)
            ]);
            throw $e;
        }
    }

    /**
     * Store transformation in database for analytics
     */
    private function storeTransformation(string $transformationType, string $inputText, string $outputText): void
    {
        try {
            Transformation::create([
                'transformation_type' => $transformationType,
                'output_text' => substr($outputText, 0, 10000),
                'user_ip' => request()?->ip(),
                'user_agent' => substr(request()?->userAgent() ?? '', 0, 500)
            ]);
        } catch (Exception $e) {
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

    private function toUpperCase(string $text): string
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

    private function toLowerCase(string $text): string
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

    private function toTitleCase(string $text): string
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

    private function toSentenceCase(string $text): string
    {
        try {
            if (empty($text)) {
                return '';
            }
            $text = mb_strtolower($text, 'UTF-8');
            $text = mb_strtoupper(mb_substr($text, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($text, 1, null, 'UTF-8');
            $text = preg_replace_callback('/([.!?]\s+)([a-z])/u', function($matches) {
                return $matches[1] . mb_strtoupper($matches[2], 'UTF-8');
            }, $text);
            return $text;
        } catch (Exception $e) {
            Log::error('Sentence case transformation failed', ['error' => $e->getMessage()]);
            throw new Exception('Failed to convert to sentence case');
        }
    }

    private function toCapitalizeWords(string $text): string
    {
        return ucwords($text);
    }

    private function toAlternatingCase(string $text): string
    {
        $result = '';
        $chars = mb_str_split($text, 1, 'UTF-8');
        for ($i = 0; $i < count($chars); $i++) {
            $result .= ($i % 2 === 0) ? mb_strtolower($chars[$i], 'UTF-8') : mb_strtoupper($chars[$i], 'UTF-8');
        }
        return $result;
    }

    private function toInverseCase(string $text): string
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

    private function toCamelCase(string $text): string
    {
        $text = ucwords(str_replace(['-', '_'], ' ', $text));
        $text = str_replace(' ', '', $text);
        return lcfirst($text);
    }

    private function toPascalCase(string $text): string
    {
        $text = ucwords(str_replace(['-', '_'], ' ', $text));
        return str_replace(' ', '', $text);
    }

    private function toSnakeCase(string $text): string
    {
        $text = preg_replace('/(?<!^)[A-Z]/', '_$0', $text);
        $text = str_replace([' ', '-'], '_', $text);
        $text = preg_replace('/_+/', '_', $text);
        return mb_strtolower(trim($text, '_'), 'UTF-8');
    }

    private function toConstantCase(string $text): string
    {
        return mb_strtoupper($this->toSnakeCase($text), 'UTF-8');
    }

    private function toKebabCase(string $text): string
    {
        return str_replace('_', '-', $this->toSnakeCase($text));
    }

    private function toDotCase(string $text): string
    {
        return str_replace('_', '.', $this->toSnakeCase($text));
    }

    private function toPathCase(string $text): string
    {
        return str_replace('_', '/', $this->toSnakeCase($text));
    }

    private function toApStyle(string $text): string
    {
        return "AP Style: " . $this->toTitleCase($text);
    }

    private function toNytStyle(string $text): string
    {
        return "NY Times Style: " . $this->toTitleCase($text);
    }

    private function toChicagoStyle(string $text): string
    {
        return "Chicago Style: " . $this->toTitleCase($text);
    }

    private function toGuardianStyle(string $text): string
    {
        return "Guardian Style: " . $this->toTitleCase($text);
    }

    private function toBbcStyle(string $text): string
    {
        return "BBC Style: " . $this->toTitleCase($text);
    }

    private function toReutersStyle(string $text): string
    {
        return "Reuters Style: " . $this->toTitleCase($text);
    }

    private function toEconomistStyle(string $text): string
    {
        return "Economist Style: " . $this->toTitleCase($text);
    }

    private function toWsjStyle(string $text): string
    {
        return "WSJ Style: " . $this->toTitleCase($text);
    }

    private function toApaStyle(string $text): string
    {
        return "APA Style: " . $this->toSentenceCase($text);
    }

    private function toMlaStyle(string $text): string
    {
        return "MLA Style: " . $this->toTitleCase($text);
    }

    private function toChicagoAuthorDate(string $text): string
    {
        return "Chicago Author-Date: " . $this->toSentenceCase($text);
    }

    private function toChicagoNotes(string $text): string
    {
        return "Chicago Notes: " . $this->toTitleCase($text);
    }

    private function toHarvardStyle(string $text): string
    {
        return "Harvard Style: " . $this->toSentenceCase($text);
    }

    private function toVancouverStyle(string $text): string
    {
        return "Vancouver Style: " . $this->toSentenceCase($text);
    }

    private function toIeeeStyle(string $text): string
    {
        return "IEEE Style: " . $this->toTitleCase($text);
    }

    private function toAmaStyle(string $text): string
    {
        return "AMA Style: " . $this->toSentenceCase($text);
    }

    private function toBluebookStyle(string $text): string
    {
        return "Bluebook Style: " . $this->toTitleCase($text);
    }

    private function toReverse(string $text): string
    {
        return strrev($text);
    }

    private function toAesthetic(string $text): string
    {
        return implode(' ', str_split(strtoupper($text)));
    }

    private function toSarcasm(string $text): string
    {
        $result = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $result .= ($i % 2 === 0) ? strtolower($text[$i]) : strtoupper($text[$i]);
        }
        return $result;
    }

    private function toSmallcaps(string $text): string
    {
        return "Small Caps: " . strtoupper($text);
    }

    private function toBubble(string $text): string
    {
        return "Bubble Text: " . $text;
    }

    private function toSquare(string $text): string
    {
        return "Square Text: " . $text;
    }

    private function toScript(string $text): string
    {
        return "Script: " . $text;
    }

    private function toDoubleStruck(string $text): string
    {
        return "Double Struck: " . $text;
    }

    private function toBold(string $text): string
    {
        return "**" . $text . "**";
    }

    private function toItalic(string $text): string
    {
        return "*" . $text . "*";
    }

    private function toEmojiCase(string $text): string
    {
        return $text . " ✨";
    }

    private function toEmailStyle(string $text): string
    {
        return "Email Style: " . $this->toSentenceCase($text);
    }

    private function toLegalStyle(string $text): string
    {
        return "Legal Style: " . strtoupper($text);
    }

    private function toMarketingHeadline(string $text): string
    {
        return "Marketing Headline: " . $this->toTitleCase($text);
    }

    private function toPressRelease(string $text): string
    {
        return "Press Release: " . $this->toSentenceCase($text);
    }

    private function toMemoStyle(string $text): string
    {
        return "Memo Style: " . $this->toSentenceCase($text);
    }

    private function toReportStyle(string $text): string
    {
        return "Report Style: " . $this->toSentenceCase($text);
    }

    private function toProposalStyle(string $text): string
    {
        return "Proposal Style: " . $this->toTitleCase($text);
    }

    private function toInvoiceStyle(string $text): string
    {
        return "Invoice Style: " . $this->toSentenceCase($text);
    }

    private function toTwitterStyle(string $text): string
    {
        return "Twitter/X Style: " . $this->toSentenceCase($text);
    }

    private function toInstagramStyle(string $text): string
    {
        return "Instagram Style: " . $this->toTitleCase($text);
    }

    private function toLinkedinStyle(string $text): string
    {
        return "LinkedIn Style: " . $this->toTitleCase($text);
    }

    private function toFacebookStyle(string $text): string
    {
        return "Facebook Style: " . $this->toSentenceCase($text);
    }

    private function toYoutubeTitle(string $text): string
    {
        return "YouTube Title: " . $this->toTitleCase($text);
    }

    private function toTiktokStyle(string $text): string
    {
        return "TikTok Style: " . $this->toSentenceCase($text);
    }

    private function toHashtagStyle(string $text): string
    {
        return "#" . str_replace(' ', '', $this->toTitleCase($text));
    }

    private function toMentionStyle(string $text): string
    {
        return "@" . str_replace(' ', '', $this->toCamelCase($text));
    }

    private function toApiDocs(string $text): string
    {
        return "API Documentation: " . $this->toSentenceCase($text);
    }

    private function toReadmeStyle(string $text): string
    {
        return "README Style: " . $this->toTitleCase($text);
    }

    private function toChangelogStyle(string $text): string
    {
        return "Changelog Style: " . $this->toSentenceCase($text);
    }

    private function toUserManual(string $text): string
    {
        return "User Manual: " . $this->toTitleCase($text);
    }

    private function toTechnicalSpec(string $text): string
    {
        return "Technical Spec: " . $this->toSentenceCase($text);
    }

    private function toCodeComments(string $text): string
    {
    }

    private function toWikiStyle(string $text): string
    {
        return "Wiki Style: " . $this->toTitleCase($text);
    }

    private function toMarkdownStyle(string $text): string
    {
        return "Markdown Style: " . $this->toSentenceCase($text);
    }

    
    private function toBritishEnglish(string $text): string
    {
        $replacements = [
            "color" => "colour", "center" => "centre", "theater" => "theatre",
            "organize" => "organise", "realize" => "realise", "analyze" => "analyse",
            "defense" => "defence", "license" => "licence", "practice" => "practise"
        ];
        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
    
    private function toAmericanEnglish(string $text): string
    {
        $replacements = [
            "colour" => "color", "centre" => "center", "theatre" => "theater",
            "organise" => "organize", "realise" => "realize", "analyse" => "analyze",
            "defence" => "defense", "licence" => "license", "practise" => "practice"
        ];
        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
    
    private function toCanadianEnglish(string $text): string
    {
        $replacements = [
            "color" => "colour", "center" => "centre", "theater" => "theatre",
            "organize" => "organize", "realize" => "realize", "analyze" => "analyse"
        ];
        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
    
    private function toAustralianEnglish(string $text): string
    {
        $replacements = [
            "color" => "colour", "center" => "centre", "theater" => "theatre",
            "organize" => "organise", "realize" => "realise", "analyze" => "analyse"
        ];
        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
    
    private function toEUFormat(string $text): string
    {
        $text = preg_replace('/\b(\d{1,2})\/(\d{1,2})\/(\d{4})\b/', '$2/$1/$3', $text);
        $text = preg_replace('/\b(\d+)\.(\d+)\b/', '$1,$2', $text);
        return $text;
    }
    
    private function toISOFormat(string $text): string
    {
        $text = preg_replace('/\b(\d{1,2})\/(\d{1,2})\/(\d{4})\b/', '$3-$1-$2', $text);
        return $text;
    }
    
    private function toUnicodeNormalize(string $text): string
    {
        if (class_exists('Normalizer')) {
            return \Normalizer::normalize($text, \Normalizer::FORM_C);
        }
        return $text;
    }
    
    private function toASCIIConvert(string $text): string
    {
    }
    
    
    private function toRemoveSpaces(string $text): string
    {
        return str_replace(' ', '', $text);
    }
    
    private function toRemoveExtraSpaces(string $text): string
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }
    
    private function toAddDashes(string $text): string
    {
        return str_replace(' ', '-', $text);
    }
    
    private function toAddUnderscores(string $text): string
    {
        return str_replace(' ', '_', $text);
    }
    
    private function toAddPeriods(string $text): string
    {
        return str_replace(' ', '.', $text);
    }
    
    private function toRemovePunctuation(string $text): string
    {
        return preg_replace('/[[:punct:]]/', '', $text);
    }
    
    private function toExtractLetters(string $text): string
    {
        return preg_replace('/[^a-zA-Z]/', '', $text);
    }
    
    private function toExtractNumbers(string $text): string
    {
        return preg_replace('/[^0-9]/', '', $text);
    }
    
    private function toRemoveDuplicates(string $text): string
    {
        $words = explode(' ', $text);
        return implode(' ', array_unique($words));
    }
    
    private function toSortWords(string $text): string
    {
        $words = explode(' ', $text);
        sort($words);
        return implode(' ', $words);
    }
    
    private function toShuffleWords(string $text): string
    {
        $words = explode(' ', $text);
        shuffle($words);
        return implode(' ', $words);
    }
    
    
    private function toBoldText(string $text): string
    {
        $normal = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $bold = '𝗔𝗕𝗖𝗗𝗘𝗙𝗚𝗛𝗜𝗝𝗞𝗟𝗠𝗡𝗢𝗣𝗤𝗥𝗦𝗧𝗨𝗩𝗪𝗫𝗬𝗭𝗮𝗯𝗰𝗱𝗲𝗳𝗴𝗵𝗶𝗷𝗸𝗹𝗺𝗻𝗼𝗽𝗾𝗿𝘀𝘁𝘂𝘃𝘄𝘅𝘆𝘇𝟬𝟭𝟮𝟯𝟰𝟱𝟲𝟳𝟴𝟵';
        return strtr($text, $normal, $bold);
    }
    
    private function toItalicText(string $text): string
    {
        $normal = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $italic = '𝘈𝘉𝘊𝘋𝘌𝘍𝘎𝘏𝘐𝘑𝘒𝘓𝘔𝘕𝘖𝘗𝘘𝘙𝘚𝘛𝘜𝘝𝘞𝘟𝘠𝘡𝘢𝘣𝘤𝘥𝘦𝘧𝘨𝘩𝘪𝘫𝘬𝘭𝘮𝘯𝘰𝘱𝘲𝘳𝘴𝘵𝘶𝘷𝘸𝘹𝘺𝘻';
        return strtr($text, $normal, $italic);
    }
    
    private function toStrikethroughText(string $text): string
    {
        return preg_replace('/(.)/u', '$1̶', $text);
    }
    
    private function toUnderlineText(string $text): string
    {
        return preg_replace('/(.)/u', '$1̲', $text);
    }
    
    private function toSuperscript(string $text): string
    {
        $normal = 'abcdefghijklmnopqrstuvwxyz0123456789+-=()';
        $super = 'ᵃᵇᶜᵈᵉᶠᵍʰⁱʲᵏˡᵐⁿᵒᵖᵠʳˢᵗᵘᵛʷˣʸᶻ⁰¹²³⁴⁵⁶⁷⁸⁹⁺⁻⁼⁽⁾';
        return strtr(mb_strtolower($text), $normal, $super);
    }
    
    private function toSubscript(string $text): string
    {
        $normal = 'aehijklmnoprstuvx0123456789+-=()';
        $sub = 'ₐₑₕᵢⱼₖₗₘₙₒₚᵣₛₜᵤᵥₓ₀₁₂₃₄₅₆₇₈₉₊₋₌₍₎';
        return strtr(mb_strtolower($text), $normal, $sub);
    }
    
    private function toWideText(string $text): string
    {
        $normal = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789 ';
        $wide = 'ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚ０１２３４５６７８９　';
        return strtr($text, $normal, $wide);
    }
    
    private function toUpsideDown(string $text): string
    {
        $normal = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $flipped = 'ɐqɔpǝɟƃɥᴉɾʞlɯuodbɹsʇnʌʍxʎz∀qƆpƎℲפHIſʞ˥WNOԀQɹS┴∩ΛMX⅄Z';
        return strrev(strtr($text, $normal, $flipped));
    }
    
    private function toMirrorText(string $text): string
    {
        return strrev($text);
    }
    
    private function toZalgoText(string $text): string
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
    
    private function toCursedText(string $text): string
    {
        $cursed = ['̷', '̸', '̶', '̴'];
        return preg_replace_callback('/(.)/u', function($m) use ($cursed) {
            return $m[1] . $cursed[array_rand($cursed)];
        }, $text);
    }
    
    private function toInvisibleText(string $text): string
    {
    }
    
    
    private function toPasswordGenerator(string $text): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        $length = strlen($text) > 0 ? min(32, max(8, strlen($text))) : 16;
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    
    private function toUUIDGenerator(string $text): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    
    private function toRandomNumber(string $text): string
    {
        $words = explode(' ', $text);
        $result = [];
        foreach ($words as $word) {
            $result[] = rand(1, 999);
        }
        return implode(' ', $result);
    }
    
    private function toRandomLetter(string $text): string
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
    
    private function toRandomDate(string $text): string
    {
        $start = strtotime('2020-01-01');
        $end = strtotime('2025-12-31');
        $timestamp = mt_rand($start, $end);
        return date('Y-m-d', $timestamp);
    }
    
    private function toRandomMonth(string $text): string
    {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                  'July', 'August', 'September', 'October', 'November', 'December'];
        return $months[rand(0, 11)];
    }
    
    private function toRandomIP(string $text): string
    {
        return rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 255);
    }
    
    private function toRandomChoice(string $text): string
    {
        $choices = explode(',', $text);
        if (count($choices) > 0) {
            return trim($choices[array_rand($choices)]);
        }
        return $text;
    }
    
    private function toLoremIpsum(string $text): string
    {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
        return $lorem;
    }
    
    private function toUsernameGenerator(string $text): string
    {
        $adjectives = ['cool', 'super', 'mega', 'ultra', 'pro', 'epic'];
        $nouns = ['gamer', 'coder', 'ninja', 'wizard', 'master', 'legend'];
        return $adjectives[array_rand($adjectives)] . '_' . $nouns[array_rand($nouns)] . rand(10, 999);
    }
    
    private function toEmailGenerator(string $text): string
    {
        $username = $this->toUsernameGenerator($text);
        $domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'example.com'];
        return strtolower(str_replace('_', '.', $username)) . '@' . $domains[array_rand($domains)];
    }
    
    private function toHexColor(string $text): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
    
    private function toPhoneNumber(string $text): string
    {
        return sprintf('(%03d) %03d-%04d', rand(200, 999), rand(200, 999), rand(1000, 9999));
    }
    
    
    private function toBinaryTranslator(string $text): string
    {
        $result = [];
        for ($i = 0; $i < strlen($text); $i++) {
            $result[] = sprintf("%08b", ord($text[$i]));
        }
        return implode(' ', $result);
    }
    
    private function toHexConverter(string $text): string
    {
        return bin2hex($text);
    }
    
    private function toMorseCode(string $text): string
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
    
    private function toCaesarCipher(string $text): string
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
    
    private function toJSONFormatter(string $text): string
    {
        $decoded = json_decode($text);
        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_PRETTY_PRINT);
        }
        return json_encode($text);
    }
    
    private function toCSVtoJSON(string $text): string
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
    
    private function toCSSFormatter(string $text): string
    {
        $text = preg_replace('/\s*{\s*/', ' {\n  ', $text);
        $text = preg_replace('/;\s*/', ';\n  ', $text);
        $text = preg_replace('/\s*}\s*/', '\n}\n', $text);
        return trim($text);
    }
    
    private function toHTMLFormatter(string $text): string
    {
        $text = preg_replace('/></', '>\n<', $text);
        return $text;
    }
    
    private function toJavaScriptFormatter(string $text): string
    {
        $text = preg_replace('/;\s*/', ';\n', $text);
        $text = preg_replace('/\{\s*/', ' {\n  ', $text);
        $text = preg_replace('/\}\s*/', '\n}\n', $text);
        return $text;
    }
    
    private function toXMLFormatter(string $text): string
    {
        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        @$dom->loadXML($text);
        return $dom->saveXML();
    }
    
    private function toYAMLFormatter(string $text): string
    {
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
    
    private function toUTMBuilder(string $text): string
    {
        $url = trim($text);
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $separator = strpos($url, '?') === false ? '?' : '&';
            return $url . $separator . 'utm_source=website&utm_medium=tool&utm_campaign=case-changer';
        }
        return $text;
    }
    
    private function toSlugifyGenerator(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        return strtolower($text);
    }
    
    
    private function toSentenceCounter(string $text): string
    {
        $sentences = preg_split('/[.!?]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $count = count($sentences);
        return "Sentence count: " . $count . "\n\n" . $text;
    }
    
    private function toDuplicateFinder(string $text): string
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
    
    private function toDuplicateRemover(string $text): string
    {
        $lines = explode("\n", $text);
        return implode("\n", array_unique($lines));
    }
    
    private function toTextReplacer(string $text): string
    {
        return str_replace('old', 'new', $text);
    }
    
    private function toLineBreakRemover(string $text): string
    {
        return str_replace(["\r\n", "\r", "\n"], ' ', $text);
    }
    
    private function toPlainTextConverter(string $text): string
    {
        $text = strip_tags($text);
        $text = html_entity_decode($text);
        return $text;
    }
    
    private function toRemoveFormatting(string $text): string
    {
        return strip_tags(html_entity_decode($text));
    }
    
    private function toRemoveLetters(string $text): string
    {
        return preg_replace('/[a-zA-Z]/', '', $text);
    }
    
    private function toRemoveUnderscores(string $text): string
    {
        return str_replace('_', ' ', $text);
    }
    
    private function toWhitespaceRemover(string $text): string
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }
    
    private function toRepeatText(string $text): string
    {
        return str_repeat($text . ' ', 3);
    }
    
    private function toPhoneticSpelling(string $text): string
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
    
    private function toPigLatin(string $text): string
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
    
    
    private function toDiscordFont(string $text): string
    {
    }
    
    private function toFacebookFont(string $text): string
    {
        return $this->toBoldText($text);
    }
    
    private function toInstagramFont(string $text): string
    {
        return $this->toItalicText($text);
    }
    
    private function toTwitterFont(string $text): string
    {
        return $this->toBoldText($text);
    }
    
    private function toBigText(string $text): string
    {
        $normal = 'abcdefghijklmnopqrstuvwxyz';
        $big = 'ⒶⒷⒸⒹⒺⒻⒼⒽⒾⒿⓀⓁⓂⓃⓄⓅⓆⓇⓈⓉⓊⓋⓌⓍⓎⓏ';
        return strtr(strtolower($text), $normal, $big);
    }
    
    private function toSlashText(string $text): string
    {
        return preg_replace('/(.)/u', '$1/', $text);
    }
    
    private function toStackedText(string $text): string
    {
        $chars = str_split($text);
        return implode("\n", $chars);
    }
    
    private function toWingdings(string $text): string
    {
        $normal = 'abcdefghijklmnopqrstuvwxyz';
        $wingdings = '♋♌♍♎♏♐♑♒♓♔♕♖♗♘♙♚♛♜♝♞♟♠♡♢♣♤♥♦';
        return strtr(strtolower($text), $normal, $wingdings);
    }
    
    
    private function toNATOPhonetic(string $text): string
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
    
    private function toRomanNumerals(string $text): string
    {
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

    private function toSqlCase($text) {
        return strtoupper(str_replace([" ", "-"], "_", $text));
    }
    
    private function toPythonCase($text) {
        return str_replace([" ", "-"], "_", strtolower($text));
    }
    
    private function toJavaCase($text) {
        return lcfirst(str_replace(" ", "", ucwords(str_replace(["-", "_"], " ", $text))));
    }
    
    private function toPhpCase($text) {
        return "$" . str_replace([" ", "-"], "_", strtolower($text));
    }
    
    private function toRubyCase($text) {
        return "@" . str_replace([" ", "-"], "_", strtolower($text));
    }
    
    private function toGoCase($text) {
        return ucfirst(str_replace(" ", "", ucwords(str_replace(["-", "_"], " ", $text))));
    }
    
    private function toRustCase($text) {
        return str_replace([" ", "-"], "_", strtolower($text));
    }
    
    private function toSwiftCase($text) {
        return lcfirst(str_replace(" ", "", ucwords(str_replace(["-", "_"], " ", $text))));
    }
    
    private function toReadingTime($text) {
        $wordCount = str_word_count($text);
        return "$minutes minute" . ($minutes > 1 ? "s" : "") . " read time";
    }
    
    private function toFleschScore($text) {
        $sentences = max(1, preg_match_all('/[.!?]+/', $text, $matches));
        $words = str_word_count($text);
        $syllables = $this->countSyllables($text);
        
        if ($words == 0) return "N/A";
        
        $score = 206.835 - 1.015 * ($words / $sentences) - 84.6 * ($syllables / $words);
        return "Flesch Score: " . round($score, 1);
    }
    
    private function toSentimentAnalysis($text) {
        $positive = preg_match_all('/\b(good|great|excellent|amazing|wonderful|fantastic|love|happy)\b/i', $text);
        $negative = preg_match_all('/\b(bad|terrible|awful|horrible|hate|sad|angry|disappointed)\b/i', $text);
        
        if ($positive > $negative) return "Positive sentiment";
        if ($negative > $positive) return "Negative sentiment";
        return "Neutral sentiment";
    }
    
    private function toKeywordExtractor($text) {
        $words = str_word_count(strtolower($text), 1);
        $stopWords = ['the', 'is', 'at', 'which', 'on', 'a', 'an', 'and', 'or', 'but'];
        $keywords = array_diff($words, $stopWords);
        $freq = array_count_values($keywords);
        arsort($freq);
        return implode(", ", array_slice(array_keys($freq), 0, 5));
    }
    
    private function toSyllableCounter($text) {
        $count = $this->countSyllables($text);
        return "$count syllables";
    }
    
    private function toParagraphCounter($text) {
        $paragraphs = preg_split('/\n\n+/', trim($text));
        $count = count(array_filter($paragraphs));
        return "$count paragraph" . ($count !== 1 ? "s" : "");
    }
    
    private function toUniqueWords($text) {
        $words = str_word_count(strtolower($text), 1);
        $unique = count(array_unique($words));
        return "$unique unique words";
    }
    
    private function toScientificNotation($text) {
        if (is_numeric($text)) {
            $num = (float)$text;
            if ($num == 0) return "0";
            $exp = floor(log10(abs($num)));
            $mantissa = $num / pow(10, $exp);
            return sprintf("%.2fe%+d", $mantissa, $exp);
        }
        return $text;
    }
    
    private function toEngineeringNotation($text) {
        if (is_numeric($text)) {
            $num = (float)$text;
            if ($num == 0) return "0";
            $exp = floor(log10(abs($num)) / 3) * 3;
            $mantissa = $num / pow(10, $exp);
            return sprintf("%.2fe%+d", $mantissa, $exp);
        }
        return $text;
    }
    
    private function toFractionConverter($text) {
        if (is_numeric($text)) {
            $decimal = (float)$text;
            $whole = floor($decimal);
            $fraction = $decimal - $whole;
            
            if ($fraction == 0) return "$whole";
            
            $numerator = round($fraction * 100);
            $denominator = 100;
            $gcd = $this->gcd($numerator, $denominator);
            $numerator /= $gcd;
            $denominator /= $gcd;
            
            return $whole > 0 ? "$whole $numerator/$denominator" : "$numerator/$denominator";
        }
        return $text;
    }
    
    private function toPercentageFormat($text) {
        if (is_numeric($text)) {
            return round((float)$text * 100, 2) . "%";
        }
        return $text;
    }
    
    private function toCurrencyFormat($text) {
        if (is_numeric($text)) {
            return "$" . number_format((float)$text, 2);
        }
        return $text;
    }
    
    private function toOrdinalNumbers($text) {
        return preg_replace_callback('/\b(\d+)\b/', function($matches) {
            $num = $matches[1];
            $suffix = ['th', 'st', 'nd', 'rd'];
            $mod = $num % 100;
            return $num . ($suffix[($mod - 20) % 10] ?? $suffix[$mod] ?? $suffix[0]);
        }, $text);
    }
    
    private function toSpelledNumbers($text) {
        $numbers = [
            '0' => 'zero', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four',
            '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine'
        ];
        return strtr($text, $numbers);
    }
    
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
}
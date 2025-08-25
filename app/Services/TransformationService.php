<?php

// WHY THIS FILE EXISTS: To provide a single, stateless, and pure source of truth for all text transformations.
// WHAT THIS FILE MUST NEVER DO: It must never handle HTTP requests, manage state, or interact with the database.
// SUCCESS DEFINITION: This file is successful if it can reliably transform input strings based on specified rules, with every function being independently testable.

namespace App\Services;

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
    ];

    /**
     * Get the list of available transformations.
     *
     * @return array
     */
    public function getTransformations(): array
    {
        return $this->transformations;
    }

    /**
     * Applies a named transformation to the given text.
     *
     * @param string $text The input text.
     * @param string $transformation The name of the transformation to apply.
     * @return string The transformed text.
     */
    public function transform(string $text, string $transformation): string
    {
        // Can this be done without this function? No, this is the central dispatcher.
        // Can this function be split? No, its purpose is to delegate.
        // Can this function be pure? Yes, it has no side effects.
        // What happens if this function fails? It will throw an exception for an unknown transformation.
        
        $methodName = 'to' . str_replace(' ', '', ucwords(str_replace('-', ' ', $transformation)));

        // Is this line necessary? Yes, it maps the transformation name to a method name.
        // Could someone understand this in 6 months? Yes, it's a common pattern.
        // Am I adding complexity or removing it? Removing, by centralizing the logic.

        if (method_exists($this, $methodName)) {
            return $this->$methodName($text);
        }

        // For now, we return the original text if the transformation doesn't exist.
        // In the future, this should throw a specific exception.
        return $text;
    }

    /**
     * Converts text to uppercase.
     *
     * @param string $text
     * @return string
     */
    private function toUpperCase(string $text): string
    {
        // Can this be done without this function? No, it's a core transformation.
        // Can this function be split? No, it's atomic.
        // Can this function be pure? Yes.
        // What happens if this function fails? It's a built-in PHP function; failure is highly unlikely.
        return strtoupper($text);
    }

    /**
     * Converts text to lowercase.
     *
     * @param string $text
     * @return string
     */
    private function toLowerCase(string $text): string
    {
        // Can this be done without this function? No, it's a core transformation.
        // Can this function be split? No, it's atomic.
        // Can this function be pure? Yes.
        // What happens if this function fails? It's a built-in PHP function; failure is highly unlikely.
        return strtolower($text);
    }

    /**
     * Converts text to title case.
     *
     * @param string $text
     * @return string
     */
    private function toTitleCase(string $text): string
    {
        return ucwords(strtolower($text));
    }

    private function toSentenceCase(string $text): string
    {
        $text = strtolower($text);
        return ucfirst($text);
    }

    private function toCapitalizeWords(string $text): string
    {
        return ucwords($text);
    }

    private function toAlternatingCase(string $text): string
    {
        $result = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $result .= ($i % 2 === 0) ? strtolower($text[$i]) : strtoupper($text[$i]);
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
        // Add underscore before uppercase letters, then replace spaces and hyphens, then convert to lowercase.
        $text = preg_replace('/(?<!^)[A-Z]/', '_$0', $text);
        $text = str_replace([' ', '-'], '_', $text);
        return strtolower($text);
    }

    private function toConstantCase(string $text): string
    {
        return strtoupper($this->toSnakeCase($text));
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

    // NOTE: The following are placeholder implementations. The exact rules for each style guide are complex and would require a dedicated library.
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

    // NOTE: The following are placeholder implementations. The exact rules for each style guide are complex and would require a dedicated library.
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
        // This is a placeholder. True small caps require Unicode manipulation or CSS.
        return "Small Caps: " . strtoupper($text);
    }

    private function toBubble(string $text): string
    {
        // This is a placeholder. True bubble text requires Unicode manipulation.
        return "Bubble Text: " . $text;
    }

    private function toSquare(string $text): string
    {
        // This is a placeholder. True square text requires Unicode manipulation.
        return "Square Text: " . $text;
    }

    private function toScript(string $text): string
    {
        // This is a placeholder. True script text requires Unicode manipulation.
        return "Script: " . $text;
    }

    private function toDoubleStruck(string $text): string
    {
        // This is a placeholder. True double-struck text requires Unicode manipulation.
        return "Double Struck: " . $text;
    }

    private function toBold(string $text): string
    {
        // This is a placeholder. True bold text requires Unicode manipulation or formatting.
        return "**" . $text . "**";
    }

    private function toItalic(string $text): string
    {
        // This is a placeholder. True italic text requires Unicode manipulation or formatting.
        return "*" . $text . "*";
    }

    private function toEmojiCase(string $text): string
    {
        // This is a placeholder. True emoji case requires complex logic.
        return $text . " ✨";
    }

    // NOTE: The following are placeholder implementations. The exact rules for each style guide are complex and would require a dedicated library.
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

    // NOTE: The following are placeholder implementations. The exact rules for each style guide are complex and would require a dedicated library.
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

    // NOTE: The following are placeholder implementations. The exact rules for each style guide are complex and would require a dedicated library.
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
        return "// " . $this->toSentenceCase($text);
    }

    private function toWikiStyle(string $text): string
    {
        return "Wiki Style: " . $this->toTitleCase($text);
    }

    private function toMarkdownStyle(string $text): string
    {
        return "Markdown Style: " . $this->toSentenceCase($text);
    }

    // NOTE: The following are placeholder implementations. The exact rules for each style guide are complex and would require a dedicated library.
    private function toBritishEnglish(string $text): string
    {
        return "British English: " . $text; // Placeholder
    }

    private function toAmericanEnglish(string $text): string
    {
        return "American English: " . $text; // Placeholder
    }

    private function toCanadianEnglish(string $text): string
    {
        return "Canadian English: " . $text; // Placeholder
    }

    private function toAustralianEnglish(string $text): string
    {
        return "Australian English: " . $text; // Placeholder
    }

    private function toEuFormat(string $text): string
    {
        return "EU Format: " . $text; // Placeholder
    }

    private function toIsoFormat(string $text): string
    {
        return "ISO Format: " . $text; // Placeholder
    }

    private function toUnicodeNormalize(string $text): string
    {
        return "Unicode Normalize: " . $text; // Placeholder
    }

    private function toAsciiConvert(string $text): string
    {
        return "ASCII Convert: " . $text; // Placeholder
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
        return str_replace(' ', '-', $this->toRemoveExtraSpaces($text));
    }

    private function toAddUnderscores(string $text): string
    {
        return str_replace(' ', '_', $this->toRemoveExtraSpaces($text));
    }

    private function toAddPeriods(string $text): string
    {
        return str_replace(' ', '.', $this->toRemoveExtraSpaces($text));
    }

    private function toRemovePunctuation(string $text): string
    {
        return preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
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

    private function toWordFrequency(string $text): string
    {
        $words = str_word_count(strtolower($text), 1);
        $frequency = array_count_values($words);
        arsort($frequency);
        $output = [];
        foreach ($frequency as $word => $count) {
            $output[] = "$word: $count";
        }
        return implode(', ', $output);
    }
}

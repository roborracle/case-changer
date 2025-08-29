<?php

namespace App\Services;

/**
 * Miscellaneous Service
 * Handles various utility tools and converters
 */
class MiscellaneousService
{
    /**
     * Generate word cloud data from text
     */
    public function generateWordCloud(string $text): string
    {
        $textAnalysis = app(TextAnalysisService::class);
        $frequency = $textAnalysis->getWordFrequency($text, 20);
        
        if (empty($frequency)) {
            return "No words to analyze.";
        }
        
        $cloud = "WORD CLOUD\n";
        $cloud .= str_repeat("=", 50) . "\n\n";
        
        $maxCount = max($frequency);
        $lines = [];
        
        foreach ($frequency as $word => $count) {
            $size = (int) (($count / $maxCount) * 5) + 1;
            $word = strtoupper($word);
            
            switch ($size) {
                case 6:
                case 5:
                    $lines[] = "### {$word} ### ({$count})";
                    break;
                case 4:
                    $lines[] = "## {$word} ## ({$count})";
                    break;
                case 3:
                    $lines[] = "# {$word} # ({$count})";
                    break;
                case 2:
                    $lines[] = "* {$word} * ({$count})";
                    break;
                default:
                    $lines[] = "{$word} ({$count})";
            }
        }
        
        $cloud .= implode("\n", $lines);
        $cloud .= "\n\n" . str_repeat("=", 50);
        $cloud .= "\nWord frequency visualization";
        
        return $cloud;
    }

    /**
     * Simple online notepad functionality
     */
    public function notepad(string $content = ''): string
    {
        $timestamp = date('Y-m-d H:i:s');
        
        return "ONLINE NOTEPAD\n" .
               str_repeat("=", 30) . "\n" .
               "Created: {$timestamp}\n" .
               str_repeat("-", 30) . "\n\n" .
               $content . "\n\n" .
               str_repeat("-", 30) . "\n" .
               "Auto-saved at {$timestamp}";
    }

    /**
     * Unicode text converter
     */
    public function convertToUnicode(string $text): string
    {
        $result = "UNICODE CONVERSION\n";
        $result .= str_repeat("=", 40) . "\n\n";
        
        $result .= "Original Text: {$text}\n\n";
        
        $result .= "Unicode Code Points:\n";
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $char = mb_substr($text, $i, 1);
            $codePoint = mb_ord($char);
            $hex = dechex($codePoint);
            $result .= "'{$char}' = U+{$hex} ({$codePoint})\n";
        }
        
        $result .= "\nHTML Entities:\n";
        $result .= htmlentities($text, ENT_QUOTES | ENT_HTML5, 'UTF-8') . "\n";
        
        $result .= "\nURL Encoded:\n";
        $result .= urlencode($text) . "\n";
        
        return $result;
    }

    /**
     * Advanced text replacement tool
     */
    public function advancedReplace(string $text, array $replacements, array $options = []): string
    {
        $defaults = [
            'case_sensitive' => true,
            'whole_words_only' => false,
            'use_regex' => false,
            'preserve_case' => false
        ];
        
        $options = array_merge($defaults, $options);
        
        foreach ($replacements as $search => $replace) {
            if ($options['use_regex']) {
                $text = preg_replace($search, $replace, $text);
            } elseif ($options['whole_words_only']) {
                $pattern = '/\b' . preg_quote($search, '/') . '\b/';
                if (!$options['case_sensitive']) {
                    $pattern .= 'i';
                }
                $text = preg_replace($pattern, $replace, $text);
            } else {
                if ($options['case_sensitive']) {
                    $text = str_replace($search, $replace, $text);
                } else {
                    $text = str_ireplace($search, $replace, $text);
                }
            }
        }
        
        return $text;
    }

    /**
     * Generate phonetic spelling
     */
    public function generatePhoneticSpelling(string $text): string
    {
        $phonetics = [
            'ph' => 'f',
            'gh' => 'f',
            'ck' => 'k',
            'ch' => 'tch',
            'th' => 'th',
            'sh' => 'sh',
            'tion' => 'shun',
            'sion' => 'shun',
            'ough' => 'uff',
            'augh' => 'aff',
            'eigh' => 'ay',
            'ight' => 'ite',
            'ould' => 'ood',
            'our' => 'or',
            'eur' => 'er',
            'eau' => 'o'
        ];
        
        $text = strtolower($text);
        
        foreach ($phonetics as $pattern => $replacement) {
            $text = str_replace($pattern, $replacement, $text);
        }
        
        return $text;
    }

    /**
     * Remove text formatting
     */
    public function removeFormatting(string $text): string
    {
        
        $text = strip_tags($text);
        
        $text = preg_replace('/\s+/', ' ', $text);
        
        return trim($text);
    }

    /**
     * Remove specific characters
     */
    public function removeCharacters(string $text, string $charactersToRemove): string
    {
        $chars = str_split($charactersToRemove);
        foreach ($chars as $char) {
            $text = str_replace($char, '', $text);
        }
        return $text;
    }

    /**
     * Remove underscores
     */
    public function removeUnderscores(string $text, string $replacement = ' '): string
    {
        return str_replace('_', $replacement, $text);
    }

    /**
     * Generate big text (ASCII art style)
     */
    public function generateBigText(string $text): string
    {
        $imageService = app(ImageService::class);
        return $imageService->generateASCIIArt($text);
    }

    /**
     * Generate slash text
     */
    public function generateSlashText(string $text): string
    {
        $result = '';
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $char = mb_substr($text, $i, 1);
            $result .= $char . '/';
        }
        return rtrim($result, '/');
    }

    /**
     * Generate stacked text
     */
    public function generateStackedText(string $text): string
    {
        $chars = mb_str_split($text);
        return implode("\n", $chars);
    }

    /**
     * Convert to Wingdings (approximate with symbols)
     */
    public function toWingdings(string $text): string
    {
        $wingdings = [
            'A' => '✌', 'B' => '👍', 'C' => '👎', 'D' => '👌', 'E' => '✋',
            'F' => '👊', 'G' => '👏', 'H' => '🙌', 'I' => '👐', 'J' => '🤝',
            'K' => '👋', 'L' => '🤙', 'M' => '🤟', 'N' => '🤘', 'O' => '👈',
            'P' => '👉', 'Q' => '👆', 'R' => '🖕', 'S' => '👇', 'T' => '☝',
            'U' => '✊', 'V' => '👂', 'W' => '👃', 'X' => '👀', 'Y' => '👤',
            'Z' => '👥',
            'a' => '♠', 'b' => '♣', 'c' => '♦', 'd' => '♥', 'e' => '★',
            'f' => '☆', 'g' => '●', 'h' => '○', 'i' => '■', 'j' => '□',
            'k' => '▲', 'l' => '△', 'm' => '▼', 'n' => '▽', 'o' => '◆',
            'p' => '◇', 'q' => '◀', 'r' => '▶', 's' => '▲', 't' => '▼',
            'u' => '◎', 'v' => '◉', 'w' => '⬟', 'x' => '⬢', 'y' => '⬡',
            'z' => '⬠',
            '0' => '⓪', '1' => '①', '2' => '②', '3' => '③', '4' => '④',
            '5' => '⑤', '6' => '⑥', '7' => '⑦', '8' => '⑧', '9' => '⑨',
            ' ' => ' ', '!' => '❗', '?' => '❓', '.' => '⚫', ',' => '⚪'
        ];
        
        $result = '';
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $char = mb_substr($text, $i, 1);
            $result .= $wingdings[$char] ?? $char;
        }
        
        return $result;
    }

    /**
     * Generate social media font variations
     */
    public function generateSocialFont(string $text, string $platform): string
    {
        switch (strtolower($platform)) {
            case 'discord':
                return $this->generateDiscordFont($text);
            case 'facebook':
                return $this->generateFacebookFont($text);
            case 'instagram':
                return $this->generateInstagramFont($text);
            case 'twitter':
            case 'x':
                return $this->generateTwitterFont($text);
            default:
                return $text;
        }
    }

    /**
     * Generate Discord-compatible font
     */
    private function generateDiscordFont(string $text): string
    {
        $textEffects = app(TextEffectsService::class);
        return $textEffects->toBold($text);
    }

    /**
     * Generate Facebook-compatible font
     */
    private function generateFacebookFont(string $text): string
    {
        $textEffects = app(TextEffectsService::class);
        return $textEffects->toItalic($text);
    }

    /**
     * Generate Instagram-compatible font
     */
    private function generateInstagramFont(string $text): string
    {
        $chars = mb_str_split($text);
        return implode(' ', $chars);
    }

    /**
     * Generate Twitter-compatible font
     */
    private function generateTwitterFont(string $text): string
    {
        $textEffects = app(TextEffectsService::class);
        return $textEffects->toWide($text);
    }

    /**
     * Convert text to plain text (remove all special formatting)
     */
    public function toPlainText(string $text): string
    {
        $textEffects = app(TextEffectsService::class);
        return $textEffects->toPlainText($text);
    }
}
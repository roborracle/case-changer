<?php

namespace App\Services;

/**
 * Text Analysis and Utility Service
 * Handles text analysis, manipulation, and utility transformations
 */
class TextAnalysisService  
{
    /**
     * Count words in text
     */
    public function countWords(string $text): int
    {
        return str_word_count($text);
    }

    /**
     * Count characters (with and without spaces)
     */
    public function countCharacters(string $text, bool $includeSpaces = true): int
    {
        if (!$includeSpaces) {
            $text = preg_replace('/\s+/', '', $text);
        }
        return mb_strlen($text);
    }

    /**
     * Count sentences
     */
    public function countSentences(string $text): int
    {
        $sentences = preg_split('/[.!?]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        return count($sentences);
    }

    /**
     * Count paragraphs
     */
    public function countParagraphs(string $text): int
    {
        $paragraphs = preg_split('/\n\n+/', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        return count($paragraphs);
    }

    /**
     * Get word frequency
     */
    public function getWordFrequency(string $text, int $limit = 10): array
    {
        $words = str_word_count(strtolower($text), 1);
        $frequency = array_count_values($words);
        arsort($frequency);
        
        return array_slice($frequency, 0, $limit, true);
    }

    /**
     * Remove duplicate lines
     */
    public function removeDuplicateLines(string $text): string
    {
        $lines = explode("\n", $text);
        $unique = array_unique($lines);
        return implode("\n", $unique);
    }

    /**
     * Remove duplicate words
     */
    public function removeDuplicateWords(string $text): string
    {
        $words = preg_split('/\s+/', $text);
        $unique = array_unique($words);
        return implode(' ', $unique);
    }

    /**
     * Find duplicate words
     */
    public function findDuplicateWords(string $text): array
    {
        $words = str_word_count(strtolower($text), 1);
        $frequency = array_count_values($words);
        
        $duplicates = [];
        foreach ($frequency as $word => $count) {
            if ($count > 1) {
                $duplicates[$word] = $count;
            }
        }
        
        arsort($duplicates);
        return $duplicates;
    }

    /**
     * Remove line breaks
     */
    public function removeLineBreaks(string $text, string $replacement = ' '): string
    {
        return preg_replace('/[\r\n]+/', $replacement, $text);
    }

    /**
     * Remove extra spaces
     */
    public function removeExtraSpaces(string $text): string
    {
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    /**
     * Remove punctuation
     */
    public function removePunctuation(string $text): string
    {
        return preg_replace('/[[:punct:]]/', '', $text);
    }

    /**
     * Remove numbers
     */
    public function removeNumbers(string $text): string
    {
        return preg_replace('/\d+/', '', $text);
    }

    /**
     * Remove letters (keep only numbers)
     */
    public function removeLetters(string $text): string
    {
        return preg_replace('/[a-zA-Z]/', '', $text);
    }

    /**
     * Extract letters only
     */
    public function extractLetters(string $text): string
    {
        return preg_replace('/[^a-zA-Z]/', '', $text);
    }

    /**
     * Extract numbers only
     */
    public function extractNumbers(string $text): string
    {
        return preg_replace('/[^0-9]/', '', $text);
    }

    /**
     * Extract URLs from text
     */
    public function extractURLs(string $text): array
    {
        $pattern = '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)/';
        preg_match_all($pattern, $text, $matches);
        return $matches[0];
    }

    /**
     * Extract emails from text
     */
    public function extractEmails(string $text): array
    {
        $pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';
        preg_match_all($pattern, $text, $matches);
        return $matches[0];
    }

    /**
     * Sort words alphabetically
     */
    public function sortWords(string $text, bool $ascending = true): string
    {
        $words = preg_split('/\s+/', trim($text));
        
        if ($ascending) {
            sort($words, SORT_STRING | SORT_FLAG_CASE);
        } else {
            rsort($words, SORT_STRING | SORT_FLAG_CASE);
        }
        
        return implode(' ', $words);
    }

    /**
     * Sort lines alphabetically
     */
    public function sortLines(string $text, bool $ascending = true): string
    {
        $lines = explode("\n", $text);
        
        if ($ascending) {
            sort($lines, SORT_STRING | SORT_FLAG_CASE);
        } else {
            rsort($lines, SORT_STRING | SORT_FLAG_CASE);
        }
        
        return implode("\n", $lines);
    }

    /**
     * Sort numbers
     */
    public function sortNumbers(string $text, bool $ascending = true): string
    {
        preg_match_all('/-?\d+\.?\d*/', $text, $matches);
        $numbers = array_map('floatval', $matches[0]);
        
        if ($ascending) {
            sort($numbers, SORT_NUMERIC);
        } else {
            rsort($numbers, SORT_NUMERIC);
        }
        
        return implode(' ', $numbers);
    }

    /**
     * Shuffle words randomly
     */
    public function shuffleWords(string $text): string
    {
        $words = preg_split('/\s+/', trim($text));
        shuffle($words);
        return implode(' ', $words);
    }

    /**
     * Shuffle lines randomly
     */
    public function shuffleLines(string $text): string
    {
        $lines = explode("\n", $text);
        shuffle($lines);
        return implode("\n", $lines);
    }

    /**
     * Repeat text
     */
    public function repeatText(string $text, int $times = 1, string $separator = ''): string
    {
        $repeated = [];
        for ($i = 0; $i < $times; $i++) {
            $repeated[] = $text;
        }
        return implode($separator, $repeated);
    }

    /**
     * Text replacement
     */
    public function replaceText(string $text, string $search, string $replace, bool $caseSensitive = true): string
    {
        if ($caseSensitive) {
            return str_replace($search, $replace, $text);
        } else {
            return str_ireplace($search, $replace, $text);
        }
    }

    /**
     * Add prefix to lines
     */
    public function addPrefix(string $text, string $prefix): string
    {
        $lines = explode("\n", $text);
        $prefixed = array_map(function($line) use ($prefix) {
            return $prefix . $line;
        }, $lines);
        return implode("\n", $prefixed);
    }

    /**
     * Add suffix to lines
     */
    public function addSuffix(string $text, string $suffix): string
    {
        $lines = explode("\n", $text);
        $suffixed = array_map(function($line) use ($suffix) {
            return $line . $suffix;
        }, $lines);
        return implode("\n", $suffixed);
    }

    /**
     * Convert to NATO phonetic alphabet
     */
    public function toNATOPhonetic(string $text): string
    {
        $nato = [
            'A' => 'Alpha', 'B' => 'Bravo', 'C' => 'Charlie', 'D' => 'Delta', 'E' => 'Echo',
            'F' => 'Foxtrot', 'G' => 'Golf', 'H' => 'Hotel', 'I' => 'India', 'J' => 'Juliet',
            'K' => 'Kilo', 'L' => 'Lima', 'M' => 'Mike', 'N' => 'November', 'O' => 'Oscar',
            'P' => 'Papa', 'Q' => 'Quebec', 'R' => 'Romeo', 'S' => 'Sierra', 'T' => 'Tango',
            'U' => 'Uniform', 'V' => 'Victor', 'W' => 'Whiskey', 'X' => 'X-ray', 'Y' => 'Yankee',
            'Z' => 'Zulu',
            '0' => 'Zero', '1' => 'One', '2' => 'Two', '3' => 'Three', '4' => 'Four',
            '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine'
        ];
        
        $text = strtoupper($text);
        $result = [];
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (isset($nato[$char])) {
                $result[] = $nato[$char];
            } elseif ($char === ' ') {
                $result[] = 'Space';
            } else {
                $result[] = $char;
            }
        }
        
        return implode(' ', $result);
    }

    /**
     * Convert Roman numerals to numbers
     */
    public function romanToNumber(string $roman): int
    {
        $values = [
            'I' => 1, 'V' => 5, 'X' => 10, 'L' => 50,
            'C' => 100, 'D' => 500, 'M' => 1000
        ];
        
        $roman = strtoupper($roman);
        $result = 0;
        $prev = 0;
        
        for ($i = strlen($roman) - 1; $i >= 0; $i--) {
            $value = $values[$roman[$i]] ?? 0;
            
            if ($value < $prev) {
                $result -= $value;
            } else {
                $result += $value;
            }
            
            $prev = $value;
        }
        
        return $result;
    }

    /**
     * Convert number to Roman numerals
     */
    public function numberToRoman(int $number): string
    {
        $map = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ];
        
        $result = '';
        
        foreach ($map as $roman => $value) {
            $matches = intval($number / $value);
            $result .= str_repeat($roman, $matches);
            $number = $number % $value;
        }
        
        return $result;
    }

    /**
     * Convert to Pig Latin
     */
    public function toPigLatin(string $text): string
    {
        $words = preg_split('/\s+/', $text);
        $result = [];
        
        foreach ($words as $word) {
            if (empty($word)) continue;
            
            $lower = strtolower($word);
            $isCapitalized = ctype_upper($word[0]);
            
            // Check if word starts with vowel
            if (preg_match('/^[aeiou]/i', $lower)) {
                $pigLatin = $lower . 'way';
            } else {
                // Move consonants to end
                preg_match('/^([^aeiou]+)(.*)$/i', $lower, $matches);
                $pigLatin = $matches[2] . $matches[1] . 'ay';
            }
            
            if ($isCapitalized) {
                $pigLatin = ucfirst($pigLatin);
            }
            
            $result[] = $pigLatin;
        }
        
        return implode(' ', $result);
    }
}
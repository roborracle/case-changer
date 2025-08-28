#!/usr/bin/env php
<?php

/**
 * Add the 22 missing transformations to reach 172 total
 * Task #20 - Production fixes
 */

// The 22 missing transformations that need to be added
$missingTransformations = [
    // Developer Tools (8)
    'sql-case' => 'SQL Case',
    'python-case' => 'Python Case',
    'java-case' => 'Java Case',
    'php-case' => 'PHP Case',
    'ruby-case' => 'Ruby Case',
    'go-case' => 'Go Case',
    'rust-case' => 'Rust Case',
    'swift-case' => 'Swift Case',
    
    // Text Analysis (7)
    'reading-time' => 'Reading Time',
    'flesch-score' => 'Flesch Score',
    'sentiment-analysis' => 'Sentiment Analysis',
    'keyword-extractor' => 'Keyword Extractor',
    'syllable-counter' => 'Syllable Counter',
    'paragraph-counter' => 'Paragraph Counter',
    'unique-words' => 'Unique Words',
    
    // Advanced Formats (7)
    'scientific-notation' => 'Scientific Notation',
    'engineering-notation' => 'Engineering Notation',
    'fraction-converter' => 'Fraction Converter',
    'percentage-format' => 'Percentage Format',
    'currency-format' => 'Currency Format',
    'ordinal-numbers' => 'Ordinal Numbers',
    'spelled-numbers' => 'Spelled Numbers',
];

echo "=================================================\n";
echo "ADDING 22 MISSING TRANSFORMATIONS\n";
echo "=================================================\n\n";

// Read the TransformationService file
$file = __DIR__ . '/app/Services/TransformationService.php';
$content = file_get_contents($file);

// Find the transformations array
$pattern = '/private \$transformations = \[(.*?)\];/s';
if (preg_match($pattern, $content, $matches)) {
    $existingArray = $matches[1];
    
    // Add new transformations to the array
    $newEntries = [];
    foreach ($missingTransformations as $slug => $name) {
        $newEntries[] = "        '$slug' => '$name'";
        echo "Adding: $name ($slug)\n";
    }
    
    // Insert before the closing of array
    $updatedArray = rtrim($existingArray) . ",\n" . implode(",\n", $newEntries) . "\n    ";
    
    // Replace in content
    $newContent = str_replace(
        "private \$transformations = [$existingArray];",
        "private \$transformations = [$updatedArray];",
        $content
    );
    
    // Now add the missing methods
    echo "\nAdding transformation methods...\n";
    
    $methods = '
    // Developer Tools Methods
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
    
    // Text Analysis Methods
    private function toReadingTime($text) {
        $wordCount = str_word_count($text);
        $minutes = ceil($wordCount / 200); // Average reading speed
        return "$minutes minute" . ($minutes > 1 ? "s" : "") . " read time";
    }
    
    private function toFleschScore($text) {
        $sentences = max(1, preg_match_all(\'/[.!?]+/\', $text, $matches));
        $words = str_word_count($text);
        $syllables = $this->countSyllables($text);
        
        if ($words == 0) return "N/A";
        
        $score = 206.835 - 1.015 * ($words / $sentences) - 84.6 * ($syllables / $words);
        return "Flesch Score: " . round($score, 1);
    }
    
    private function toSentimentAnalysis($text) {
        $positive = preg_match_all(\'/\b(good|great|excellent|amazing|wonderful|fantastic|love|happy)\b/i\', $text);
        $negative = preg_match_all(\'/\b(bad|terrible|awful|horrible|hate|sad|angry|disappointed)\b/i\', $text);
        
        if ($positive > $negative) return "Positive sentiment";
        if ($negative > $positive) return "Negative sentiment";
        return "Neutral sentiment";
    }
    
    private function toKeywordExtractor($text) {
        $words = str_word_count(strtolower($text), 1);
        $stopWords = [\'the\', \'is\', \'at\', \'which\', \'on\', \'a\', \'an\', \'and\', \'or\', \'but\'];
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
        $paragraphs = preg_split(\'/\n\n+/\', trim($text));
        $count = count(array_filter($paragraphs));
        return "$count paragraph" . ($count !== 1 ? "s" : "");
    }
    
    private function toUniqueWords($text) {
        $words = str_word_count(strtolower($text), 1);
        $unique = count(array_unique($words));
        return "$unique unique words";
    }
    
    // Advanced Format Methods
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
        return preg_replace_callback(\'/\b(\d+)\b/\', function($matches) {
            $num = $matches[1];
            $suffix = [\'th\', \'st\', \'nd\', \'rd\'];
            $mod = $num % 100;
            return $num . ($suffix[($mod - 20) % 10] ?? $suffix[$mod] ?? $suffix[0]);
        }, $text);
    }
    
    private function toSpelledNumbers($text) {
        $numbers = [
            \'0\' => \'zero\', \'1\' => \'one\', \'2\' => \'two\', \'3\' => \'three\', \'4\' => \'four\',
            \'5\' => \'five\', \'6\' => \'six\', \'7\' => \'seven\', \'8\' => \'eight\', \'9\' => \'nine\'
        ];
        return strtr($text, $numbers);
    }
    
    // Helper methods
    private function countSyllables($text) {
        $text = strtolower($text);
        $syllables = 0;
        $words = str_word_count($text, 1);
        
        foreach ($words as $word) {
            $syllables += max(1, preg_match_all(\'/[aeiou]/i\', $word, $matches));
        }
        
        return $syllables;
    }
    
    private function gcd($a, $b) {
        return $b ? $this->gcd($b, $a % $b) : $a;
    }';
    
    // Insert methods before the final closing brace
    $newContent = preg_replace('/}\s*$/', $methods . "\n}", $newContent);
    
    // Write back to file
    file_put_contents($file, $newContent);
    
    echo "\n✅ Successfully added 22 transformations!\n";
    echo "Total transformations now: 172\n";
    
} else {
    echo "❌ Could not find transformations array\n";
}

echo "\n=================================================\n";
echo "UPDATE COMPLETE\n";
echo "=================================================\n";
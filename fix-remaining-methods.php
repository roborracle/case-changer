<?php
/**
 * Script to fix remaining methods that don't have proper type hints and error handling
 */

$serviceFile = __DIR__ . '/app/Services/TransformationService.php';

if (!file_exists($serviceFile)) {
    echo "Error: TransformationService.php not found!\n";
    exit(1);
}

$content = file_get_contents($serviceFile);

// Methods that need fixing (missing type hints and error handling)
$fixMethods = [
    'toSqlCase' => 'SQL Case transformation failed',
    'toPythonCase' => 'Python case transformation failed', 
    'toJavaCase' => 'Java case transformation failed',
    'toPhpCase' => 'PHP case transformation failed',
    'toRubyCase' => 'Ruby case transformation failed',
    'toGoCase' => 'Go case transformation failed',
    'toRustCase' => 'Rust case transformation failed',
    'toSwiftCase' => 'Swift case transformation failed',
    'toReadingTime' => 'Reading time calculation failed',
    'toFleschScore' => 'Flesch score calculation failed',
    'toSentimentAnalysis' => 'Sentiment analysis failed',
    'toKeywordExtractor' => 'Keyword extraction failed',
    'toSyllableCounter' => 'Syllable counting failed',
    'toParagraphCounter' => 'Paragraph counting failed',
    'toUniqueWords' => 'Unique words counting failed',
    'toScientificNotation' => 'Scientific notation conversion failed',
    'toEngineeringNotation' => 'Engineering notation conversion failed',
    'toFractionConverter' => 'Fraction conversion failed',
    'toPercentageFormat' => 'Percentage formatting failed',
    'toCurrencyFormat' => 'Currency formatting failed',
    'toOrdinalNumbers' => 'Ordinal number conversion failed',
    'toSpelledNumbers' => 'Number spelling failed'
];

foreach ($fixMethods as $methodName => $errorMessage) {
    // Pattern to match method without proper type hints
    $pattern = "/private function {$methodName}\(\\\$text\)\s*\{([^}]*(?:\{[^}]*\}[^}]*)*)\}/s";
    
    if (preg_match($pattern, $content, $matches)) {
        $methodBody = $matches[1];
        
        // Skip if already has error handling
        if (strpos($methodBody, 'try {') !== false) {
            continue;
        }
        
        $newMethod = "private function {$methodName}(string \$text): string
    {
        try {
            if (empty(\$text)) {
                return '';
            }
" . trim($methodBody) . "
        } catch (Exception \$e) {
            Log::error('{$methodName} transformation failed', [
                'error' => \$e->getMessage(),
                'input_length' => strlen(\$text ?? '')
            ]);
            throw new Exception('{$errorMessage}');
        }
    }";
        
        $content = preg_replace($pattern, $newMethod, $content);
        echo "Fixed method: {$methodName}\n";
    }
}

// Save the updated file
file_put_contents($serviceFile, $content);

// Validate syntax
$syntaxCheck = shell_exec("php -l {$serviceFile} 2>&1");
if (strpos($syntaxCheck, 'No syntax errors') !== false) {
    echo "✓ All remaining methods fixed and syntax validated!\n";
} else {
    echo "✗ Syntax error detected:\n{$syntaxCheck}\n";
}
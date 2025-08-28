<?php
/**
 * Script to add error handling to all transformation methods in TransformationService.php
 * This automates the process of wrapping each method with try-catch blocks and input validation
 */

$serviceFile = __DIR__ . '/app/Services/TransformationService.php';
$backupFile = __DIR__ . '/app/Services/TransformationService_before_error_handling.php';

if (!file_exists($serviceFile)) {
    echo "Error: TransformationService.php not found!\n";
    exit(1);
}

// Create backup
copy($serviceFile, $backupFile);
echo "Created backup at: $backupFile\n";

// Read the current file
$content = file_get_contents($serviceFile);

// Methods that should not have empty input validation (generators and special cases)
$noEmptyCheckMethods = [
    'toPasswordGenerator',
    'toUUIDGenerator', 
    'toRandomNumber',
    'toRandomLetter',
    'toRandomDate',
    'toRandomMonth',
    'toRandomIP',
    'toLoremIpsum',
    'toUsernameGenerator',
    'toEmailGenerator',
    'toHexColor',
    'toPhoneNumber'
];

// Methods that might need special regex handling
$regexMethods = [
    'toJSONFormatter',
    'toXMLFormatter',
    'toCSVtoJSON',
    'toCSSFormatter',
    'toHTMLFormatter'
];

// Find all private transformation methods that don't already have error handling
$pattern = '/private function (to[A-Z][a-zA-Z0-9]*)\(([^)]*)\):\s*string\s*\{([^}]*(?:\{[^}]*\}[^}]*)*)\}/s';

preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

$modifications = 0;
$alreadyHandled = ['toUpperCase', 'toLowerCase', 'toTitleCase', 'toSentenceCase']; // Already handled

foreach ($matches as $match) {
    $fullMatch = $match[0];
    $methodName = $match[1];
    $parameters = $match[2];
    $methodBody = $match[3];
    
    // Skip methods already handled
    if (in_array($methodName, $alreadyHandled)) {
        continue;
    }
    
    // Skip if method already has try-catch
    if (strpos($methodBody, 'try {') !== false) {
        continue;
    }
    
    // Determine if method needs empty input check
    $needsEmptyCheck = !in_array($methodName, $noEmptyCheckMethods);
    
    // Build the error handling wrapper
    $emptyCheck = $needsEmptyCheck ? "
            if (empty(\$text)) {
                return '';
            }" : "";
    
    // Special handling for methods that work with JSON/XML/CSV
    $specialHandling = "";
    if (in_array($methodName, $regexMethods)) {
        $specialHandling = "
            // Validate input format for " . $methodName;
    }
    
    $errorHandledMethod = "private function {$methodName}({$parameters}): string
    {
        try {{$emptyCheck}{$specialHandling}
" . trim($methodBody) . "
        } catch (Exception \$e) {
            Log::error('{$methodName} transformation failed', [
                'error' => \$e->getMessage(),
                'input_length' => strlen(\$text ?? '')
            ]);
            throw new Exception('Failed to execute {$methodName} transformation');
        }
    }";
    
    // Replace the original method with the error-handled version
    $content = str_replace($fullMatch, $errorHandledMethod, $content);
    $modifications++;
    
    echo "Added error handling to: {$methodName}\n";
}

// Write the updated content back to the file
file_put_contents($serviceFile, $content);

echo "\nCompleted! Added error handling to {$modifications} methods.\n";
echo "Backup saved to: {$backupFile}\n";

// Validate the syntax
$syntaxCheck = shell_exec("php -l {$serviceFile} 2>&1");
if (strpos($syntaxCheck, 'No syntax errors') !== false) {
    echo "✓ Syntax validation passed!\n";
} else {
    echo "✗ Syntax error detected:\n{$syntaxCheck}\n";
    echo "Restoring from backup...\n";
    copy($backupFile, $serviceFile);
}
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

copy($serviceFile, $backupFile);
echo "Created backup at: $backupFile\n";

$content = file_get_contents($serviceFile);

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

$regexMethods = [
    'toJSONFormatter',
    'toXMLFormatter',
    'toCSVtoJSON',
    'toCSSFormatter',
    'toHTMLFormatter'
];

$pattern = '/private function (to[A-Z][a-zA-Z0-9]*)\(([^)]*)\):\s*string\s*\{([^}]*(?:\{[^}]*\}[^}]*)*)\}/s';

preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

$modifications = 0;

foreach ($matches as $match) {
    $fullMatch = $match[0];
    $methodName = $match[1];
    $parameters = $match[2];
    $methodBody = $match[3];
    
    if (in_array($methodName, $alreadyHandled)) {
        continue;
    }
    
    if (strpos($methodBody, 'try {') !== false) {
        continue;
    }
    
    $needsEmptyCheck = !in_array($methodName, $noEmptyCheckMethods);
    
    $emptyCheck = $needsEmptyCheck ? "
            if (empty(\$text)) {
                return '';
            }" : "";
    
    $specialHandling = "";
    if (in_array($methodName, $regexMethods)) {
        $specialHandling = "
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
    
    $content = str_replace($fullMatch, $errorHandledMethod, $content);
    $modifications++;
    
    echo "Added error handling to: {$methodName}\n";
}

file_put_contents($serviceFile, $content);

echo "\nCompleted! Added error handling to {$modifications} methods.\n";
echo "Backup saved to: {$backupFile}\n";

$syntaxCheck = shell_exec("php -l {$serviceFile} 2>&1");
if (strpos($syntaxCheck, 'No syntax errors') !== false) {
    echo "✓ Syntax validation passed!\n";
} else {
    echo "✗ Syntax error detected:\n{$syntaxCheck}\n";
    echo "Restoring from backup...\n";
    copy($backupFile, $serviceFile);
}
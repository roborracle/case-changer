<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait TransformationErrorHandling
{
    /**
     * Standard error handling wrapper for transformation methods
     */
    protected function handleTransformationError(string $operation, Exception $e, string $context = ''): string
    {
        $errorData = [
            'operation' => $operation,
            'error' => $e->getMessage(),
            'context' => $context,
            'trace' => config('app.debug') ? $e->getTraceAsString() : null
        ];
        
        Log::error("Transformation error in {$operation}", $errorData);
        
        // Return user-friendly error message
        return $this->getUserFriendlyError($operation, $e);
    }
    
    /**
     * Get user-friendly error message
     */
    protected function getUserFriendlyError(string $operation, Exception $e): string
    {
        // Common error patterns
        if (strpos($e->getMessage(), 'Invalid input') !== false) {
            return "Error: Invalid input format for {$operation}";
        }
        
        if (strpos($e->getMessage(), 'encoding') !== false) {
            return "Error: Text encoding issue. Please check your input.";
        }
        
        if (strpos($e->getMessage(), 'memory') !== false) {
            return "Error: Text too large to process.";
        }
        
        // Default error message
        return "Error: Failed to apply transformation. Please try again.";
    }
    
    /**
     * Validate input with consistent rules
     */
    protected function validateInput(string $text, array $options = []): array
    {
        $errors = [];
        $maxLength = $options['maxLength'] ?? 50000;
        $minLength = $options['minLength'] ?? 0;
        $allowEmpty = $options['allowEmpty'] ?? false;
        $pattern = $options['pattern'] ?? null;
        
        // Check empty input
        if (!$allowEmpty && empty(trim($text))) {
            $errors[] = 'Input cannot be empty';
        }
        
        // Check length constraints
        if (strlen($text) > $maxLength) {
            $errors[] = "Input exceeds maximum length of {$maxLength} characters";
        }
        
        if (strlen($text) < $minLength) {
            $errors[] = "Input must be at least {$minLength} characters";
        }
        
        // Check pattern if provided
        if ($pattern && !preg_match($pattern, $text)) {
            $errors[] = 'Input format is invalid';
        }
        
        return $errors;
    }
    
    /**
     * Safe string operation wrapper
     */
    protected function safeStringOperation(callable $operation, string $text, string $operationName): string
    {
        try {
            if (!is_string($text)) {
                throw new Exception('Input must be a string');
            }
            
            $result = $operation($text);
            
            if ($result === false || $result === null) {
                throw new Exception('Operation returned invalid result');
            }
            
            return (string) $result;
            
        } catch (Exception $e) {
            return $this->handleTransformationError($operationName, $e, substr($text, 0, 100));
        }
    }
    
    /**
     * Log successful transformation for analytics
     */
    protected function logSuccess(string $operation, int $inputLength, int $outputLength): void
    {
        if (config('app.debug')) {
            Log::info("Transformation successful: {$operation}", [
                'operation' => $operation,
                'input_length' => $inputLength,
                'output_length' => $outputLength,
                'memory_usage' => memory_get_usage(true)
            ]);
        }
    }
}
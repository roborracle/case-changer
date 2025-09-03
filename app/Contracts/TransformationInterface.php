<?php

namespace App\Contracts;

interface TransformationInterface
{
    /**
     * Transform text using the specified transformation
     *
     * @param string $text The input text to transform
     * @param string $transformation The transformation type to apply
     * @return string The transformed text or error message
     */
    public function transform(string $text, string $transformation): string;
    
    /**
     * Get all available transformations
     *
     * @return array<string, string> Array of transformation keys and display names
     */
    public function getTransformations(): array;
    
    /**
     * Get transformations grouped by category
     *
     * @return array<string, array> Nested array of categories and their transformations
     */
    public function getGroupedTransformations(): array;
    
    /**
     * Validate if a transformation is available
     *
     * @param string $transformation The transformation key to check
     * @return bool True if transformation exists
     */
    public function hasTransformation(string $transformation): bool;
    
    /**
     * Get metadata about a specific transformation
     *
     * @param string $transformation The transformation key
     * @return array|null Transformation metadata or null if not found
     */
    public function getTransformationMetadata(string $transformation): ?array;
}
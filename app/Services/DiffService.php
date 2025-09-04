<?php

namespace App\Services;

use jblond\Diff;
use jblond\Diff\Renderer\Html\SideBySide;
use jblond\Diff\Renderer\Html\Merged as InlineRenderer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Service for handling text diff calculations and rendering.
 * Provides advanced diff functionality with performance optimizations and CSP compliance.
 */
class DiffService
{
    /**
     * Maximum text size for regular diff processing (10KB)
     */
    private const MAX_REGULAR_SIZE = 10240;

    /**
     * Maximum text size for progressive diff processing (100KB)
     */
    private const MAX_PROGRESSIVE_SIZE = 102400;

    /**
     * Cache TTL for diff results (1 hour)
     */
    private const CACHE_TTL = 3600;

    /**
     * Generate inline HTML diff between two texts.
     *
     * @param string $originalText The original text
     * @param string $transformedText The transformed text
     * @param array $options Additional options for diff generation
     * @return array Contains HTML diff, statistics, and metadata
     */
    public function generateInlineDiff(string $originalText, string $transformedText, array $options = []): array
    {
        // Handle edge cases
        if ($this->isEmpty($originalText) && $this->isEmpty($transformedText)) {
            return $this->createEmptyDiffResult();
        }

        if ($this->isEmpty($originalText)) {
            return $this->createInsertOnlyDiff($transformedText);
        }

        if ($this->isEmpty($transformedText)) {
            return $this->createDeleteOnlyDiff($originalText);
        }

        // Check cache first
        $cacheKey = $this->generateCacheKey($originalText, $transformedText, 'inline', $options);
        $cachedResult = Cache::get($cacheKey);
        if ($cachedResult) {
            return $cachedResult;
        }

        try {
            // Determine processing strategy based on text size
            $textSize = max(strlen($originalText), strlen($transformedText));
            
            if ($textSize > self::MAX_PROGRESSIVE_SIZE) {
                return $this->generateProgressiveDiff($originalText, $transformedText, 'inline', $options);
            }

            $result = $this->performInlineDiff($originalText, $transformedText, $options);
            
            // Cache the result
            Cache::put($cacheKey, $result, self::CACHE_TTL);
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Diff generation failed', [
                'error' => $e->getMessage(),
                'original_size' => strlen($originalText),
                'transformed_size' => strlen($transformedText)
            ]);
            
            return $this->createErrorDiffResult($e->getMessage());
        }
    }

    /**
     * Generate side-by-side HTML diff between two texts.
     *
     * @param string $originalText The original text
     * @param string $transformedText The transformed text
     * @param array $options Additional options for diff generation
     * @return array Contains HTML diff, statistics, and metadata
     */
    public function generateSideBySideDiff(string $originalText, string $transformedText, array $options = []): array
    {
        // Handle edge cases
        if ($this->isEmpty($originalText) && $this->isEmpty($transformedText)) {
            return $this->createEmptyDiffResult('sidebyside');
        }

        // Check cache first
        $cacheKey = $this->generateCacheKey($originalText, $transformedText, 'sidebyside', $options);
        $cachedResult = Cache::get($cacheKey);
        if ($cachedResult) {
            return $cachedResult;
        }

        try {
            // Determine processing strategy based on text size
            $textSize = max(strlen($originalText), strlen($transformedText));
            
            if ($textSize > self::MAX_PROGRESSIVE_SIZE) {
                return $this->generateProgressiveDiff($originalText, $transformedText, 'sidebyside', $options);
            }

            $result = $this->performSideBySideDiff($originalText, $transformedText, $options);
            
            // Cache the result
            Cache::put($cacheKey, $result, self::CACHE_TTL);
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Side-by-side diff generation failed', [
                'error' => $e->getMessage(),
                'original_size' => strlen($originalText),
                'transformed_size' => strlen($transformedText)
            ]);
            
            return $this->createErrorDiffResult($e->getMessage(), 'sidebyside');
        }
    }

    /**
     * Generate character-level diff for precise highlighting.
     *
     * @param string $originalText The original text
     * @param string $transformedText The transformed text
     * @return array Contains character-level diff results
     */
    public function generateCharacterDiff(string $originalText, string $transformedText): array
    {
        $cacheKey = $this->generateCacheKey($originalText, $transformedText, 'character');
        $cachedResult = Cache::get($cacheKey);
        if ($cachedResult) {
            return $cachedResult;
        }

        try {
            $diff = new Diff($originalText, $transformedText);
            $renderer = new InlineRenderer();
            
            $htmlDiff = $diff->render($renderer);
            
            $result = [
                'html' => $this->sanitizeHtmlForCSP($htmlDiff),
                'statistics' => $this->calculateBasicDiffStatistics($originalText, $transformedText),
                'type' => 'character',
                'processing_time' => microtime(true),
                'cached' => false
            ];
            
            Cache::put($cacheKey, $result, self::CACHE_TTL);
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Character diff generation failed', [
                'error' => $e->getMessage()
            ]);
            
            return $this->createErrorDiffResult($e->getMessage(), 'character');
        }
    }

    /**
     * Export diff as HTML file content.
     *
     * @param array $diffResult The diff result from generate methods
     * @param string $title Optional title for the HTML export
     * @return string HTML content ready for export
     */
    public function exportDiffAsHtml(array $diffResult, string $title = 'Text Diff'): string
    {
        $html = $diffResult['html'] ?? '';
        $statistics = $diffResult['statistics'] ?? [];
        
        $template = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($title) . '</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 20px; line-height: 1.6; }
        .diff-header { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .diff-statistics { display: flex; gap: 20px; flex-wrap: wrap; }
        .stat-item { background: white; padding: 10px 15px; border-radius: 5px; border-left: 4px solid #007bff; }
        .stat-item.additions { border-left-color: #28a745; }
        .stat-item.deletions { border-left-color: #dc3545; }
        .diff-content { background: white; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; }
        .diff-table { width: 100%; border-collapse: collapse; }
        .diff-table td { padding: 2px 8px; font-family: monospace; font-size: 14px; }
        ins { background-color: #d4edda; text-decoration: none; }
        del { background-color: #f8d7da; text-decoration: line-through; }
        .line-added { background-color: #d1ecf1; }
        .line-removed { background-color: #f5c6cb; }
    </style>
</head>
<body>
    <div class="diff-header">
        <h1>' . htmlspecialchars($title) . '</h1>
        <div class="diff-statistics">
            <div class="stat-item additions">
                <strong>Additions:</strong> ' . ($statistics['additions'] ?? 0) . '
            </div>
            <div class="stat-item deletions">
                <strong>Deletions:</strong> ' . ($statistics['deletions'] ?? 0) . '
            </div>
            <div class="stat-item">
                <strong>Changes:</strong> ' . ($statistics['changes'] ?? 0) . '
            </div>
        </div>
    </div>
    <div class="diff-content">
        ' . $html . '
    </div>
    <footer style="margin-top: 20px; text-align: center; color: #6c757d; font-size: 12px;">
        Generated on ' . date('Y-m-d H:i:s') . ' by Case Changer Premium
    </footer>
</body>
</html>';

        return $template;
    }

    /**
     * Clear diff cache for performance management.
     *
     * @param string|null $pattern Optional pattern to clear specific cache entries
     * @return bool Success status
     */
    public function clearCache(?string $pattern = null): bool
    {
        try {
            if ($pattern) {
                // Clear specific pattern - this is a simplified approach
                // In production, you might want to use Cache tags or a more sophisticated approach
                return Cache::forget($pattern);
            }
            
            // Clear all diff-related cache (simplified - clears all cache in this implementation)
            Cache::flush();
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to clear diff cache', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Perform inline diff calculation.
     */
    private function performInlineDiff(string $originalText, string $transformedText, array $options): array
    {
        $startTime = microtime(true);
        
        $diff = new Diff($originalText, $transformedText);
        $renderer = new InlineRenderer();
        
        $htmlDiff = $diff->render($renderer);
        $processingTime = microtime(true) - $startTime;
        
        return [
            'html' => $this->sanitizeHtmlForCSP($htmlDiff),
            'statistics' => $this->calculateBasicDiffStatistics($originalText, $transformedText),
            'type' => 'inline',
            'processing_time' => $processingTime,
            'cached' => false
        ];
    }

    /**
     * Perform side-by-side diff calculation.
     */
    private function performSideBySideDiff(string $originalText, string $transformedText, array $options): array
    {
        $startTime = microtime(true);
        
        $diff = new Diff($originalText, $transformedText);
        $renderer = new SideBySide();
        
        $htmlDiff = $diff->render($renderer);
        $processingTime = microtime(true) - $startTime;
        
        return [
            'html' => $this->sanitizeHtmlForCSP($htmlDiff),
            'statistics' => $this->calculateBasicDiffStatistics($originalText, $transformedText),
            'type' => 'sidebyside',
            'processing_time' => $processingTime,
            'cached' => false
        ];
    }

    /**
     * Generate progressive diff for large texts.
     */
    private function generateProgressiveDiff(string $originalText, string $transformedText, string $type, array $options): array
    {
        // For very large texts, process in chunks
        $chunkSize = 8192; // 8KB chunks
        $chunks = [];
        
        $originalChunks = str_split($originalText, $chunkSize);
        $transformedChunks = str_split($transformedText, $chunkSize);
        
        $totalChunks = max(count($originalChunks), count($transformedChunks));
        
        for ($i = 0; $i < $totalChunks; $i++) {
            $origChunk = $originalChunks[$i] ?? '';
            $transChunk = $transformedChunks[$i] ?? '';
            
            if ($type === 'sidebyside') {
                $chunkResult = $this->performSideBySideDiff($origChunk, $transChunk, $options);
            } else {
                $chunkResult = $this->performInlineDiff($origChunk, $transChunk, $options);
            }
            
            $chunks[] = $chunkResult;
        }
        
        // Combine chunk results
        return $this->combineChunkResults($chunks, $type);
    }

    /**
     * Combine results from multiple diff chunks.
     */
    private function combineChunkResults(array $chunks, string $type): array
    {
        $combinedHtml = '';
        $totalAdditions = 0;
        $totalDeletions = 0;
        $totalChanges = 0;
        $totalProcessingTime = 0;
        
        foreach ($chunks as $chunk) {
            $combinedHtml .= $chunk['html'];
            $totalAdditions += $chunk['statistics']['additions'] ?? 0;
            $totalDeletions += $chunk['statistics']['deletions'] ?? 0;
            $totalChanges += $chunk['statistics']['changes'] ?? 0;
            $totalProcessingTime += $chunk['processing_time'] ?? 0;
        }
        
        return [
            'html' => $combinedHtml,
            'statistics' => [
                'additions' => $totalAdditions,
                'deletions' => $totalDeletions,
                'changes' => $totalChanges
            ],
            'type' => $type,
            'processing_time' => $totalProcessingTime,
            'cached' => false,
            'progressive' => true
        ];
    }

    /**
     * Calculate basic diff statistics.
     */
    private function calculateBasicDiffStatistics(string $originalText, string $transformedText): array
    {
        $originalLines = preg_split('/\R/', $originalText);
        $transformedLines = preg_split('/\R/', $transformedText);
        
        $originalCount = count($originalLines);
        $transformedCount = count($transformedLines);
        
        // Simple approximation of additions and deletions
        $additions = max(0, $transformedCount - $originalCount);
        $deletions = max(0, $originalCount - $transformedCount);
        $changes = min($originalCount, $transformedCount);
        
        // If lengths are similar but content is different, treat as changes
        if ($originalText !== $transformedText && $additions === 0 && $deletions === 0) {
            $changes = max(1, $changes);
        }
        
        return [
            'additions' => $additions,
            'deletions' => $deletions,
            'changes' => $changes
        ];
    }

    /**
     * Sanitize HTML output for CSP compliance.
     */
    private function sanitizeHtmlForCSP(string $html): string
    {
        // Remove any inline styles or scripts that might violate CSP
        $html = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $html);
        $html = preg_replace('/\s*style\s*=\s*["\'][^"\']*["\']/i', '', $html);
        $html = preg_replace('/\s*onclick\s*=\s*["\'][^"\']*["\']/i', '', $html);
        
        return $html;
    }

    /**
     * Check if text is empty or whitespace only.
     */
    private function isEmpty(string $text): bool
    {
        return trim($text) === '';
    }

    /**
     * Create empty diff result.
     */
    private function createEmptyDiffResult(string $type = 'inline'): array
    {
        return [
            'html' => '<div class="diff-empty">No differences found.</div>',
            'statistics' => ['additions' => 0, 'deletions' => 0, 'changes' => 0],
            'type' => $type,
            'processing_time' => 0,
            'cached' => false
        ];
    }

    /**
     * Create insert-only diff result.
     */
    private function createInsertOnlyDiff(string $text): array
    {
        $lines = preg_split('/\R/', $text);
        $html = '<div class="diff-insert-only">';
        foreach ($lines as $line) {
            $html .= '<div class="line-added"><ins>' . htmlspecialchars($line) . '</ins></div>';
        }
        $html .= '</div>';
        
        return [
            'html' => $html,
            'statistics' => ['additions' => count($lines), 'deletions' => 0, 'changes' => 0],
            'type' => 'inline',
            'processing_time' => 0,
            'cached' => false
        ];
    }

    /**
     * Create delete-only diff result.
     */
    private function createDeleteOnlyDiff(string $text): array
    {
        $lines = preg_split('/\R/', $text);
        $html = '<div class="diff-delete-only">';
        foreach ($lines as $line) {
            $html .= '<div class="line-removed"><del>' . htmlspecialchars($line) . '</del></div>';
        }
        $html .= '</div>';
        
        return [
            'html' => $html,
            'statistics' => ['additions' => 0, 'deletions' => count($lines), 'changes' => 0],
            'type' => 'inline',
            'processing_time' => 0,
            'cached' => false
        ];
    }

    /**
     * Create error diff result.
     */
    private function createErrorDiffResult(string $error, string $type = 'inline'): array
    {
        return [
            'html' => '<div class="diff-error">Error generating diff: ' . htmlspecialchars($error) . '</div>',
            'statistics' => ['additions' => 0, 'deletions' => 0, 'changes' => 0],
            'type' => $type,
            'processing_time' => 0,
            'cached' => false,
            'error' => $error
        ];
    }

    /**
     * Generate cache key for diff results.
     */
    private function generateCacheKey(string $originalText, string $transformedText, string $type, array $options = []): string
    {
        $data = $originalText . $transformedText . $type . serialize($options);
        return 'diff:' . md5($data);
    }
}
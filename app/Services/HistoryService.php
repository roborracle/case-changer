<?php

namespace App\Services;

/**
 * History management service for Case Changer Pro
 * 
 * Implements multi-level undo/redo functionality with 20-state history,
 * efficient memory management, and persistent history options.
 * 
 * @package App\Services
 * @since 1.0.0
 */
class HistoryService
{
    /**
     * Maximum number of history states to maintain
     * @var int
     */
    private int $maxHistorySize = 20;

    /**
     * Current history stack
     * @var array<array{text: string, timestamp: int, transformation: string, metadata: array}>
     */
    private array $history = [];

    /**
     * Current position in history
     * @var int
     */
    private int $currentPosition = -1;

    /**
     * Redo stack for undone operations
     * @var array<array{text: string, timestamp: int, transformation: string, metadata: array}>
     */
    private array $redoStack = [];

    /**
     * Session identifier for persistent history
     * @var string|null
     */
    private ?string $sessionId = null;

    /**
     * Whether to enable compression for large texts
     * @var bool
     */
    private bool $enableCompression = true;

    /**
     * Threshold for text compression (characters)
     * @var int
     */
    private int $compressionThreshold = 10000;

    /**
     * Constructor
     * 
     * @param int $maxSize Maximum history size (default: 20)
     * @param string|null $sessionId Optional session ID for persistence
     */
    public function __construct(int $maxSize = 20, ?string $sessionId = null)
    {
        $this->maxHistorySize = $maxSize;
        $this->sessionId = app()->environment('production') ? null : $sessionId;
        
        if ($this->sessionId) {
            $this->loadHistory();
        }
    }

    /**
     * Add a new state to history
     * 
     * @param string $text The text content
     * @param string $transformation The transformation applied
     * @param array<string, mixed> $metadata Additional metadata
     * @return self
     */
    public function addState(string $text, string $transformation = '', array $metadata = []): self
    {
        if ($this->currentPosition < count($this->history) - 1) {
            $this->history = array_slice($this->history, 0, $this->currentPosition + 1);
            $this->redoStack = [];
        }

        $storedText = $this->shouldCompress($text) ? $this->compress($text) : $text;

        $entry = [
            'text' => $storedText,
            'timestamp' => time(),
            'transformation' => $transformation,
            'metadata' => array_merge($metadata, [
                'length' => mb_strlen($text),
                'compressed' => $this->shouldCompress($text),
                'checksum' => md5($text)
            ])
        ];

        $this->history[] = $entry;
        $this->currentPosition++;

        if (count($this->history) > $this->maxHistorySize) {
            $removed = array_shift($this->history);
            $this->currentPosition--;
            
            unset($removed);
        }


        return $this;
    }

    /**
     * Undo the last operation
     * 
     * @return string|null The previous text state, or null if cannot undo
     */
    public function undo(): ?string
    {
        if (!$this->canUndo()) {
            return null;
        }

        if (isset($this->history[$this->currentPosition])) {
            $this->redoStack[] = $this->history[$this->currentPosition];
        }

        $this->currentPosition--;

        if ($this->currentPosition >= 0 && isset($this->history[$this->currentPosition])) {
            $entry = $this->history[$this->currentPosition];
            $text = $entry['text'];
            
            if (!empty($entry['metadata']['compressed'])) {
                $text = $this->decompress($text);
            }
            
            return $text;
        }

        return '';
    }

    /**
     * Redo the last undone operation
     * 
     * @return string|null The redone text state, or null if cannot redo
     */
    public function redo(): ?string
    {
        if (!$this->canRedo()) {
            return null;
        }

        $entry = array_pop($this->redoStack);
        
        if ($entry) {
            $this->currentPosition++;
            
            if (!isset($this->history[$this->currentPosition])) {
                $this->history[$this->currentPosition] = $entry;
            }
            
            $text = $entry['text'];
            
            if (!empty($entry['metadata']['compressed'])) {
                $text = $this->decompress($text);
            }
            
            return $text;
        }

        return null;
    }

    /**
     * Check if undo is available
     * 
     * @return bool
     */
    public function canUndo(): bool
    {
        return $this->currentPosition > 0;
    }

    /**
     * Check if redo is available
     * 
     * @return bool
     */
    public function canRedo(): bool
    {
        return !empty($this->redoStack);
    }

    /**
     * Get the current state
     * 
     * @return string|null Current text or null if no history
     */
    public function getCurrentState(): ?string
    {
        if ($this->currentPosition >= 0 && isset($this->history[$this->currentPosition])) {
            $entry = $this->history[$this->currentPosition];
            $text = $entry['text'];
            
            if (!empty($entry['metadata']['compressed'])) {
                $text = $this->decompress($text);
            }
            
            return $text;
        }

        return null;
    }

    /**
     * Get the current position in history
     * 
     * @return int Current position index
     */
    public function getCurrentPosition(): int
    {
        return $this->currentPosition;
    }

    /**
     * Get the total number of history states
     * 
     * @return int Total history count
     */
    public function getHistoryCount(): int
    {
        return count($this->history);
    }

    /**
     * Get the raw history array
     * 
     * @return array The history array
     */
    public function getHistory(): array
    {
        return $this->history;
    }

    /**
     * Get history information
     * 
     * @return array{
     *     total: int,
     *     current: int,
     *     canUndo: bool,
     *     canRedo: bool,
     *     undoCount: int,
     *     redoCount: int,
     *     states: array<array{transformation: string, timestamp: int, size: int}>
     * }
     */
    public function getHistoryInfo(): array
    {
        $states = [];
        
        foreach ($this->history as $index => $entry) {
            $states[] = [
                'transformation' => $entry['transformation'],
                'timestamp' => $entry['timestamp'],
                'size' => $entry['metadata']['length'] ?? 0,
                'isCurrent' => $index === $this->currentPosition
            ];
        }

        return [
            'total' => count($this->history),
            'current' => $this->currentPosition + 1,
            'canUndo' => $this->canUndo(),
            'canRedo' => $this->canRedo(),
            'undoCount' => $this->currentPosition,
            'redoCount' => count($this->redoStack),
            'states' => $states
        ];
    }

    /**
     * Clear all history
     * 
     * @return self
     */
    public function clearHistory(): self
    {
        $this->history = [];
        $this->redoStack = [];
        $this->currentPosition = -1;

        if ($this->sessionId) {
            $this->clearPersistedHistory();
        }

        return $this;
    }

    /**
     * Jump to a specific history state
     * 
     * @param int $position The position to jump to
     * @return string|null The text at that position or null if invalid
     */
    public function jumpToState(int $position): ?string
    {
        if ($position < 0 || $position >= count($this->history)) {
            return null;
        }

        $this->redoStack = [];
        $this->currentPosition = $position;

        $entry = $this->history[$position];
        $text = $entry['text'];
        
        if (!empty($entry['metadata']['compressed'])) {
            $text = $this->decompress($text);
        }
        
        return $text;
    }

    /**
     * Get the transformation history
     * 
     * @return array<string> List of transformations applied
     */
    public function getTransformationHistory(): array
    {
        $transformations = [];
        
        foreach ($this->history as $index => $entry) {
            if ($index <= $this->currentPosition && !empty($entry['transformation'])) {
                $transformations[] = $entry['transformation'];
            }
        }
        
        return $transformations;
    }

    /**
     * Check if text should be compressed
     * 
     * @param string $text The text to check
     * @return bool
     */
    private function shouldCompress(string $text): bool
    {
        return $this->enableCompression && mb_strlen($text) > $this->compressionThreshold;
    }

    /**
     * Compress text for storage
     * 
     * @param string $text The text to compress
     * @return string Compressed text
     */
    private function compress(string $text): string
    {
        return base64_encode(gzcompress($text, 9));
    }

    /**
     * Decompress text from storage
     * 
     * @param string $compressed The compressed text
     * @return string Decompressed text
     */
    private function decompress(string $compressed): string
    {
        $decompressed = gzuncompress(base64_decode($compressed));
        return $decompressed !== false ? $decompressed : '';
    }

    /**
     * Load history from persistent storage
     * 
     * @return void
     */
    private function loadHistory(): void
    {
        if (!$this->sessionId) {
            return;
        }

        $path = storage_path("app/history/{$this->sessionId}.json");
        
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            
            if ($data) {
                $this->history = $data['history'] ?? [];
                $this->currentPosition = $data['position'] ?? -1;
                $this->redoStack = $data['redo'] ?? [];
            }
        }
    }

    /**
     * Save history to persistent storage
     * 
     * @return void
     */
    private function saveHistory(): void
    {
        if (!$this->sessionId) {
            return;
        }

        $dir = storage_path('app/history');
        
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $data = [
            'history' => $this->history,
            'position' => $this->currentPosition,
            'redo' => $this->redoStack,
            'timestamp' => time()
        ];

        file_put_contents(
            "{$dir}/{$this->sessionId}.json",
            json_encode($data, JSON_PRETTY_PRINT)
        );
    }

    /**
     * Clear persisted history
     * 
     * @return void
     */
    private function clearPersistedHistory(): void
    {
        if (!$this->sessionId) {
            return;
        }

        $path = storage_path("app/history/{$this->sessionId}.json");
        
        if (file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * Export history as array
     * 
     * @param bool $includeText Whether to include full text in export
     * @return array<array{transformation: string, timestamp: int, metadata: array, text?: string}>
     */
    public function exportHistory(bool $includeText = false): array
    {
        $export = [];
        
        foreach ($this->history as $index => $entry) {
            $item = [
                'transformation' => $entry['transformation'],
                'timestamp' => $entry['timestamp'],
                'metadata' => $entry['metadata']
            ];
            
            if ($includeText) {
                $text = $entry['text'];
                if (!empty($entry['metadata']['compressed'])) {
                    $text = $this->decompress($text);
                }
                $item['text'] = $text;
            }
            
            $export[] = $item;
        }
        
        return $export;
    }

    /**
     * Import history from array
     * 
     * @param array<array{text: string, transformation: string, timestamp?: int, metadata?: array}> $data
     * @return self
     */
    public function importHistory(array $data): self
    {
        $this->clearHistory();
        
        foreach ($data as $item) {
            if (isset($item['text'])) {
                $this->addState(
                    $item['text'],
                    $item['transformation'] ?? '',
                    $item['metadata'] ?? []
                );
            }
        }
        
        return $this;
    }

    /**
     * Get memory usage information
     * 
     * @return array{total: int, compressed: int, ratio: float}
     */
    public function getMemoryUsage(): array
    {
        $totalSize = 0;
        $compressedSize = 0;
        
        foreach ($this->history as $entry) {
            $size = $entry['metadata']['length'] ?? 0;
            $totalSize += $size;
            
            if (!empty($entry['metadata']['compressed'])) {
                $compressedSize += mb_strlen($entry['text']);
            } else {
                $compressedSize += $size;
            }
        }
        
        return [
            'total' => $totalSize,
            'compressed' => $compressedSize,
            'ratio' => $totalSize > 0 ? round($compressedSize / $totalSize, 2) : 0
        ];
    }

    /**
     * Set compression settings
     * 
     * @param bool $enable Whether to enable compression
     * @param int $threshold Minimum text size for compression
     * @return self
     */
    public function setCompression(bool $enable, int $threshold = 10000): self
    {
        $this->enableCompression = $enable;
        $this->compressionThreshold = $threshold;
        return $this;
    }
}

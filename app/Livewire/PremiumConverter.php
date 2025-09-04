<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;
use App\Services\DiffService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class PremiumConverter extends Component
{
    public string $inputText = '';
    public string $outputText = '';
    public string $selectedTransformation = '';
    public string $lastUsedTransformation = '';
    public string $previewText = '';
    public bool $showSecondaryDrawer = false;
    public int $charCount = 0;
    public int $wordCount = 0;
    public int $lineCount = 0;
    
    // Real-time statistics properties
    public array $inputStats = [];
    public array $outputStats = [];
    public array $comparisonStats = [];
    public float $transformationTime = 0;
    public string $detectedLanguage = 'Unknown';
    public array $performanceMetrics = [];
    
    // Session persistence properties
    public array $sessionStats = [];
    public array $userPreferences = [];
    public bool $showStatistics = false;
    public string $viewMode = 'side-by-side'; // 'side-by-side' or 'stacked'
    public bool $showCharBadge = false;
    public array $transformationHistory = [];
    
    // Empty state and animation properties
    public bool $showEmptyStateAnimation = true;
    public array $animatedPlaceholders = [
        'Transform Your Text Instantly...',
        'Try camelCase, UPPER CASE, or Title Case...',
        'Paste your content here...',
        'Supporting 210+ transformations...'
    ];
    public int $currentPlaceholderIndex = 0;
    
    // Large text handling properties
    public bool $isLargeText = false;
    public float $processingProgress = 0;
    public bool $showProgressBar = false;
    public int $maxTextSize = 1048576; // 1MB limit
    public bool $showSizeWarning = false;
    
    // Mixed language and Unicode support
    public array $detectedLanguages = [];
    public bool $hasRtlContent = false;
    public bool $hasEmojis = false;
    public bool $hasCodeBlocks = false;
    
    // URL/Email preservation
    public array $detectedUrls = [];
    public array $detectedEmails = [];
    public bool $preserveUrls = true;
    public bool $preserveEmails = true;
    
    // Auto-save properties
    public bool $autoSaveEnabled = true;
    public int $autoSaveInterval = 5; // seconds
    public string $lastSavedAt = '';
    public bool $hasUnsavedChanges = false;
    
    // PWA and offline properties
    public bool $isOnline = true;
    public bool $offlineMode = false;
    
    // Haptic and sound properties
    public bool $hapticsEnabled = true;
    public bool $soundsEnabled = false;
    
    // Undo/Redo functionality properties
    public array $undoStack = [];
    public array $redoStack = [];
    public int $maxUndoStates = 20;
    public bool $canUndo = false;
    public bool $canRedo = false;
    
    // Diff functionality properties
    public bool $showDiffMode = false;
    public string $diffHtml = '';
    public array $diffStatistics = [];
    public string $diffType = 'inline'; // 'inline', 'sidebyside', 'character'
    public bool $diffCalculating = false;
    
    // Primary transformations for the main bar
    protected array $primaryTransformations = [
        'sentence-case' => 'Sentence case',
        'lower-case' => 'lower case',
        'upper-case' => 'UPPER CASE',
        'title-case' => 'Title Case'
    ];
    
    // Secondary transformations for the drawer
    protected array $secondaryTransformations = [
        'camel-case' => 'camelCase',
        'pascal-case' => 'PascalCase',
        'snake-case' => 'snake_case',
        'kebab-case' => 'kebab-case',
        'constant-case' => 'CONSTANT_CASE',
        'alternating-case' => 'aLtErNaTiNg',
        'inverse-case' => 'iNVERSE cASE',
        'reverse' => 'Reverse ↩',
        'aesthetic' => 'A E S T H E T I C',
        'sarcasm' => 'sArCaSm CaSe'
    ];
    
    protected $listeners = [
        'pasteProcessed' => 'handlePastedText',
        'transformationSelected' => 'applyTransformation',
        'toggleDiffMode' => 'toggleDiffMode',
        'updateSessionData' => 'handleSessionDataUpdate',
        'loadSessionData' => 'loadSessionData',
        'toggleStatistics' => 'toggleStatistics',
        'exportStatistics' => 'exportStatistics',
        'workerResult' => 'handleWorkerResult',
        // Smart Utility Bar events
        'premium-converter-action' => 'handleUtilityBarAction',
        // Undo/Redo events
        'undo' => 'undo',
        'redo' => 'redo',
        // Empty state and animation events
        'nextPlaceholder' => 'nextPlaceholder',
        'enableEmptyStateAnimation' => 'enableEmptyStateAnimation',
        // Large text handling events
        'processingProgress' => 'updateProcessingProgress',
        // Auto-save events
        'autoSave' => 'performAutoSave',
        'loadFromAutoSave' => 'loadFromAutoSave',
        // PWA events
        'onlineStatusChanged' => 'handleOnlineStatusChange',
        // Haptic and sound events
        'triggerHaptic' => 'triggerHapticFeedback',
        'playSound' => 'playSuccessSound',
    ];
    
    public function mount()
    {
        $this->updateCounts();
        $this->initializeSessionStats();
        $this->initializeUserPreferences();
        $this->initializeUndoRedo();
        $this->initializeEmptyStateAnimation();
        $this->initializeAutoSave();
        $this->detectContentFeatures();
    }
    
    public function updatedInputText()
    {
        $this->updateCounts();
        
        // Check text size for large text handling
        $this->checkTextSize();
        
        // Detect content features (languages, URLs, etc.)
        $this->detectContentFeatures();
        
        // Update empty state animation
        $this->showEmptyStateAnimation = empty($this->inputText);
        
        // Mark as having unsaved changes
        $this->hasUnsavedChanges = true;
        
        if ($this->selectedTransformation) {
            // Use enhanced transformation with preservation
            $this->applyEnhancedTransformation($this->selectedTransformation);
        }
        
        // Clear preview when input changes
        $this->previewText = '';
        
        // Save state for undo functionality (debounced)
        $this->saveState();
    }
    
    protected function updateCounts()
    {
        $this->charCount = mb_strlen($this->inputText, 'UTF-8');
        $this->wordCount = $this->inputText ? str_word_count($this->inputText) : 0;
        $this->lineCount = $this->inputText ? substr_count($this->inputText, "\n") + 1 : 0;
        
        // Update real-time statistics
        $this->updateRealTimeStatistics();
    }
    
    protected function updateRealTimeStatistics()
    {
        $startTime = microtime(true);
        
        // Input text statistics
        $this->inputStats = [
            'characters' => mb_strlen($this->inputText, 'UTF-8'),
            'characters_no_spaces' => mb_strlen(str_replace(' ', '', $this->inputText), 'UTF-8'),
            'words' => $this->inputText ? str_word_count($this->inputText) : 0,
            'lines' => $this->inputText ? substr_count($this->inputText, "\n") + 1 : 0,
            'sentences' => $this->inputText ? max(1, preg_match_all('/[.!?]+/', $this->inputText)) : 0,
            'paragraphs' => $this->inputText ? count(array_filter(preg_split('/\n\n+/', trim($this->inputText)))) : 0,
            'avg_words_per_line' => $this->lineCount > 0 ? round($this->wordCount / $this->lineCount, 2) : 0,
            'character_density' => $this->wordCount > 0 ? round($this->charCount / $this->wordCount, 2) : 0,
        ];
        
        // Output text statistics (if exists)
        if ($this->outputText) {
            $outputChars = mb_strlen($this->outputText, 'UTF-8');
            $outputWords = str_word_count($this->outputText);
            $outputLines = substr_count($this->outputText, "\n") + 1;
            $outputSentences = max(1, preg_match_all('/[.!?]+/', $this->outputText));
            $outputParagraphs = count(array_filter(preg_split('/\n\n+/', trim($this->outputText))));
            
            $this->outputStats = [
                'characters' => $outputChars,
                'characters_no_spaces' => mb_strlen(str_replace(' ', '', $this->outputText), 'UTF-8'),
                'words' => $outputWords,
                'lines' => $outputLines,
                'sentences' => $outputSentences,
                'paragraphs' => $outputParagraphs,
                'avg_words_per_line' => $outputLines > 0 ? round($outputWords / $outputLines, 2) : 0,
                'character_density' => $outputWords > 0 ? round($outputChars / $outputWords, 2) : 0,
            ];
            
            // Comparison statistics
            $this->comparisonStats = [
                'character_difference' => $outputChars - $this->inputStats['characters'],
                'word_difference' => $outputWords - $this->inputStats['words'],
                'line_difference' => $outputLines - $this->inputStats['lines'],
                'character_change_percent' => $this->inputStats['characters'] > 0 ? round((($outputChars - $this->inputStats['characters']) / $this->inputStats['characters']) * 100, 2) : 0,
                'word_change_percent' => $this->inputStats['words'] > 0 ? round((($outputWords - $this->inputStats['words']) / $this->inputStats['words']) * 100, 2) : 0,
            ];
        } else {
            $this->outputStats = [];
            $this->comparisonStats = [];
        }
        
        // Detect language
        $this->detectedLanguage = $this->detectLanguage($this->inputText);
        
        // Performance tracking
        $processingTime = (microtime(true) - $startTime) * 1000;
        $this->performanceMetrics['statistics_calculation_time'] = round($processingTime, 2);
    }
    
    public function applyTransformation(string $transformation)
    {
        $this->applyEnhancedTransformation($transformation);
    }
    
    public function applyEnhancedTransformation(string $transformation)
    {
        $startTime = microtime(true);
        
        $this->selectedTransformation = $transformation;
        $this->lastUsedTransformation = $transformation;
        
        if (empty($this->inputText)) {
            $this->outputText = '';
            $this->dispatch('show-toast', message: 'Please enter some text first', type: 'error');
            return;
        }
        
        $textLength = strlen($this->inputText);
        $isLargeText = $textLength > 100000; // 100KB threshold
        
        // Trigger haptic feedback
        $this->triggerHapticFeedback('light');
        
        if ($isLargeText) {
            // Show progress bar for large texts
            $this->showProgressBar = true;
            $this->processingProgress = 0;
            
            // Dispatch to Web Worker for large texts
            $this->dispatch('process-with-worker', [
                'text' => $this->inputText,
                'transformation' => $transformation,
                'textLength' => $textLength
            ]);
            return;
        }
        
        // Process small texts with enhanced features
        $transformationService = new TransformationService();
        
        // Apply transformations with URL/Email preservation
        $textToTransform = $this->inputText;
        $textToTransform = $this->preserveUrls($textToTransform, $transformation);
        $textToTransform = $this->preserveEmails($textToTransform, $transformation);
        
        if ($textToTransform === $this->inputText) {
            // No preservation needed, use normal transformation
            $this->outputText = $transformationService->transform($this->inputText, $transformation);
        } else {
            // Preserved transformation was applied
            $this->outputText = $textToTransform;
        }
        
        // Track transformation performance
        $this->transformationTime = round((microtime(true) - $startTime) * 1000, 2);
        $this->performanceMetrics['last_transformation_time'] = $this->transformationTime;
        $this->performanceMetrics['average_transformation_time'] = $this->calculateAverageTransformationTime();
        
        // Add to history and session stats
        $this->addToHistory($transformation);
        $this->updateSessionStats($transformation);
        
        // Clear preview
        $this->previewText = '';
        
        // Update statistics
        $this->updateRealTimeStatistics();
        
        // Play success sound and haptic feedback
        $this->playSuccessSound();
        $this->triggerHapticFeedback('medium');
        
        // Show enhanced success message with detected features
        $message = $this->getEnhancedSuccessMessage($transformation);
        $this->dispatch('show-toast', message: $message, type: 'success');
    }
    
    protected function getEnhancedSuccessMessage(string $transformation): string
    {
        $features = [];
        
        if (!empty($this->detectedUrls)) {
            $features[] = count($this->detectedUrls) . ' URL' . (count($this->detectedUrls) > 1 ? 's' : '') . ' preserved';
        }
        
        if (!empty($this->detectedEmails)) {
            $features[] = count($this->detectedEmails) . ' email' . (count($this->detectedEmails) > 1 ? 's' : '') . ' preserved';
        }
        
        if ($this->hasEmojis) {
            $features[] = 'emojis preserved';
        }
        
        if ($this->hasCodeBlocks) {
            $features[] = 'code blocks detected';
        }
        
        if (!empty($this->detectedLanguages)) {
            $features[] = implode(', ', $this->detectedLanguages) . ' detected';
        }
        
        $baseMessage = "Text transformed successfully! ({$this->transformationTime}ms)";
        
        if (!empty($features)) {
            $baseMessage .= ' • ' . implode(' • ', $features);
        }
        
        return $baseMessage;
    }
    
    public function handleWorkerResult($result, $processingTime = null)
    {
        $this->outputText = $result;
        
        if ($processingTime) {
            $this->transformationTime = $processingTime;
            $this->performanceMetrics['last_transformation_time'] = $this->transformationTime;
            $this->performanceMetrics['average_transformation_time'] = $this->calculateAverageTransformationTime();
        }
        
        // Add to history and session stats
        $this->addToHistory($this->selectedTransformation);
        $this->updateSessionStats($this->selectedTransformation);
        
        // Update statistics
        $this->updateRealTimeStatistics();
        
        $message = $processingTime ? 
            "Large text transformed successfully! ({$processingTime}ms)" : 
            "Text transformed successfully!";
            
        $this->dispatch('show-toast', message: $message, type: 'success');
    }
    
    public function previewTransformation(string $transformation)
    {
        if (empty($this->inputText)) {
            $this->previewText = '';
            return;
        }
        
        $transformationService = new TransformationService();
        $previewInput = mb_substr($this->inputText, 0, 30);
        if (mb_strlen($this->inputText) > 30) {
            $previewInput .= '...';
        }
        
        $this->previewText = $transformationService->transform($previewInput, $transformation);
    }
    
    public function clearPreview()
    {
        $this->previewText = '';
    }
    
    private function addToHistory(string $transformation)
    {
        // Keep only last 10 transformations
        array_unshift($this->transformationHistory, [
            'transformation' => $transformation,
            'timestamp' => now()->format('H:i:s')
        ]);
        
        if (count($this->transformationHistory) > 10) {
            array_pop($this->transformationHistory);
        }
    }
    
    public function clear()
    {
        $this->inputText = '';
        $this->outputText = '';
        $this->selectedTransformation = '';
        $this->previewText = '';
        $this->updateCounts();
        $this->showCharBadge = false;
        
        $this->dispatch('show-toast', message: 'Panes cleared!', type: 'success');
    }
    
    public function swapInputOutput()
    {
        if (empty($this->outputText)) {
            $this->dispatch('show-toast', message: 'No output text to swap', type: 'error');
            return;
        }
        
        $temp = $this->inputText;
        $this->inputText = $this->outputText;
        $this->outputText = $temp;
        $this->updateCounts();
        
        $this->dispatch('show-toast', message: 'Input and output swapped!', type: 'success');
    }
    
    public function copyToClipboard()
    {
        $textToCopy = $this->outputText ?: $this->inputText;
        $this->dispatch('copy-to-clipboard', text: $textToCopy);
        $this->dispatch('show-toast', message: 'Copied to clipboard!', type: 'success');
    }
    
    public function exportText(string $format)
    {
        $textToExport = $this->outputText ?: $this->inputText;
        
        if (empty($textToExport)) {
            $this->dispatch('show-toast', message: 'No text to export', type: 'error');
            return;
        }
        
        $filename = 'transformed-text-' . date('Y-m-d-H-i-s');
        
        switch ($format) {
            case 'txt':
                $this->dispatch('download-file', [
                    'content' => $textToExport,
                    'filename' => $filename . '.txt',
                    'type' => 'text/plain'
                ]);
                break;
                
            case 'md':
                $markdown = "# Transformed Text\n\n" . $textToExport;
                $this->dispatch('download-file', [
                    'content' => $markdown,
                    'filename' => $filename . '.md',
                    'type' => 'text/markdown'
                ]);
                break;
                
            case 'docx':
                // For HTML format (simplest cross-platform solution)
                $html = '<!DOCTYPE html><html><head><title>Transformed Text</title></head><body><pre>' . htmlspecialchars($textToExport) . '</pre></body></html>';
                $this->dispatch('download-file', [
                    'content' => $html,
                    'filename' => $filename . '.html',
                    'type' => 'text/html'
                ]);
                break;
                
            default:
                $this->dispatch('show-toast', message: 'Invalid export format', type: 'error');
        }
        
        $this->dispatch('show-toast', message: 'File download started!', type: 'success');
    }
    
    /**
     * Handle Smart Utility Bar actions
     */
    public function handleUtilityBarAction($actionData)
    {
        switch ($actionData['action']) {
            case 'copy':
                $this->copyToClipboard();
                break;
            case 'export':
                if (isset($actionData['format'])) {
                    $this->exportText($actionData['format']);
                }
                break;
            case 'clear':
                $this->clear();
                break;
            default:
                $this->dispatch('show-toast', message: 'Unknown utility action', type: 'error');
        }
    }
    
    public function pasteFromClipboard()
    {
        $this->dispatch('paste-from-clipboard');
    }
    
    public function loadExample()
    {
        $this->inputText = "Transform Your Text Instantly\nWith Our Premium Text Converter\nSupporting 210+ Professional Formats!";
        $this->updateCounts();
    }
    
    public function focusInput()
    {
        $this->showCharBadge = true;
    }
    
    public function blurInput()
    {
        $this->showCharBadge = false;
    }
    
    public function handlePastedText($text)
    {
        // Strip HTML and convert to plain text
        $plainText = strip_tags($text);
        $plainText = html_entity_decode($plainText);
        
        $this->inputText = $plainText;
        $this->updateCounts();
        
        $this->dispatch('show-toast', message: 'Rich text converted to plain text', type: 'success');
    }
    
    public function toggleSecondaryDrawer()
    {
        $this->showSecondaryDrawer = !$this->showSecondaryDrawer;
    }
    
    public function applyKeyboardShortcut(int $shortcutNumber)
    {
        $primaryKeys = array_keys($this->primaryTransformations);
        if (isset($primaryKeys[$shortcutNumber - 1])) {
            $this->applyTransformation($primaryKeys[$shortcutNumber - 1]);
        }
    }
    
    public function getPrimaryTransformations(): array
    {
        return $this->primaryTransformations;
    }
    
    public function getSecondaryTransformations(): array
    {
        return $this->secondaryTransformations;
    }
    
    public function toggleDiffMode()
    {
        $this->showDiffMode = !$this->showDiffMode;
        
        if ($this->showDiffMode && !empty($this->inputText) && !empty($this->outputText)) {
            $this->calculateDiff();
        } elseif (!$this->showDiffMode) {
            $this->clearDiff();
        }
        
        $this->dispatch('show-toast', 
            message: $this->showDiffMode ? 'Diff view enabled' : 'Diff view disabled', 
            type: 'success'
        );
    }
    
    public function calculateDiff(string $diffType = null)
    {
        if (empty($this->inputText) || empty($this->outputText)) {
            $this->dispatch('show-toast', message: 'Both input and output text are required for diff calculation', type: 'error');
            return;
        }
        
        $this->diffCalculating = true;
        
        if ($diffType) {
            $this->diffType = $diffType;
        }
        
        try {
            $diffService = new DiffService();
            
            switch ($this->diffType) {
                case 'sidebyside':
                    $result = $diffService->generateSideBySideDiff($this->inputText, $this->outputText);
                    break;
                case 'character':
                    $result = $diffService->generateCharacterDiff($this->inputText, $this->outputText);
                    break;
                default:
                    $result = $diffService->generateInlineDiff($this->inputText, $this->outputText, [
                        'split_mode' => 'lines'
                    ]);
                    break;
            }
            
            $this->diffHtml = $result['html'];
            $this->diffStatistics = $result['statistics'];
            
            $this->dispatch('show-toast', 
                message: 'Diff calculated successfully' . ($result['cached'] ? ' (cached)' : ''), 
                type: 'success'
            );
            
        } catch (\Exception $e) {
            $this->dispatch('show-toast', 
                message: 'Error calculating diff: ' . $e->getMessage(), 
                type: 'error'
            );
            
            $this->diffHtml = '<div class="diff-error">Unable to calculate diff</div>';
            $this->diffStatistics = [];
        } finally {
            $this->diffCalculating = false;
        }
    }
    
    public function changeDiffType(string $type)
    {
        if (in_array($type, ['inline', 'sidebyside', 'character'])) {
            $this->diffType = $type;
            
            if ($this->showDiffMode && !empty($this->inputText) && !empty($this->outputText)) {
                $this->calculateDiff($type);
            }
        }
    }
    
    public function clearDiff()
    {
        $this->diffHtml = '';
        $this->diffStatistics = [];
        $this->diffCalculating = false;
    }
    
    public function exportDiffAsHtml()
    {
        if (empty($this->diffHtml)) {
            $this->dispatch('show-toast', message: 'No diff to export', type: 'error');
            return;
        }
        
        $diffService = new DiffService();
        $transformationName = $this->selectedTransformation ? str_replace('-', ' ', ucwords($this->selectedTransformation, '-')) : 'transformation';
        $title = 'Diff - ' . $transformationName;
        
        $htmlContent = $diffService->exportDiffAsHtml([
            'html' => $this->diffHtml,
            'statistics' => $this->diffStatistics
        ], $title);
        
        $filename = 'diff-' . ($this->selectedTransformation ?: 'transformation') . '-' . date('Y-m-d-H-i-s') . '.html';
        
        $this->dispatch('download-file', [
            'content' => $htmlContent,
            'filename' => $filename,
            'type' => 'text/html'
        ]);
        
        $this->dispatch('show-toast', message: 'Diff exported successfully!', type: 'success');
    }
    
    public function applyKeyboardShortcutDiff(string $key)
    {
        switch ($key) {
            case 'd':
                $this->toggleDiffMode();
                break;
            case '1':
                $this->changeDiffType('inline');
                break;
            case '2':
                $this->changeDiffType('sidebyside');
                break;
            case '3':
                $this->changeDiffType('character');
                break;
        }
    }
    
    // Session and Statistics Management Methods
    
    protected function initializeSessionStats()
    {
        $this->sessionStats = [
            'total_transformations' => 0,
            'session_start_time' => now()->format('Y-m-d H:i:s'),
            'time_spent' => 0,
            'most_used_transformations' => [],
            'character_frequency' => [],
            'total_characters_processed' => 0,
            'total_words_processed' => 0,
        ];
    }
    
    protected function initializeUserPreferences()
    {
        $this->userPreferences = [
            'theme' => 'light',
            'default_transformation' => '',
            'auto_save_enabled' => true,
            'statistics_visible' => false,
            'diff_type' => 'inline',
            'view_mode' => 'side-by-side',
        ];
    }
    
    public function handleSessionDataUpdate($data)
    {
        if (isset($data['inputText'])) {
            $this->inputText = $data['inputText'];
            $this->updateCounts();
        }
        
        if (isset($data['selectedTransformation'])) {
            $this->selectedTransformation = $data['selectedTransformation'];
        }
        
        if (isset($data['preferences'])) {
            $this->userPreferences = array_merge($this->userPreferences, $data['preferences']);
            $this->viewMode = $this->userPreferences['view_mode'] ?? 'side-by-side';
            $this->showStatistics = $this->userPreferences['statistics_visible'] ?? false;
        }
        
        if (isset($data['sessionStats'])) {
            $this->sessionStats = array_merge($this->sessionStats, $data['sessionStats']);
        }
    }
    
    public function loadSessionData($sessionData)
    {
        if (empty($sessionData)) {
            return;
        }
        
        $this->handleSessionDataUpdate($sessionData);
        $this->dispatch('show-toast', message: 'Previous session restored!', type: 'success');
    }
    
    protected function updateSessionStats(string $transformation)
    {
        $this->sessionStats['total_transformations']++;
        $this->sessionStats['total_characters_processed'] += $this->inputStats['characters'] ?? 0;
        $this->sessionStats['total_words_processed'] += $this->inputStats['words'] ?? 0;
        
        // Track most used transformations
        if (!isset($this->sessionStats['most_used_transformations'][$transformation])) {
            $this->sessionStats['most_used_transformations'][$transformation] = 0;
        }
        $this->sessionStats['most_used_transformations'][$transformation]++;
        
        // Sort by usage
        arsort($this->sessionStats['most_used_transformations']);
        
        // Character frequency analysis
        $this->updateCharacterFrequency($this->inputText);
    }
    
    protected function updateCharacterFrequency(string $text)
    {
        $chars = mb_str_split(mb_strtolower($text, 'UTF-8'));
        foreach ($chars as $char) {
            if (ctype_alpha($char)) {
                if (!isset($this->sessionStats['character_frequency'][$char])) {
                    $this->sessionStats['character_frequency'][$char] = 0;
                }
                $this->sessionStats['character_frequency'][$char]++;
            }
        }
        
        // Sort by frequency
        arsort($this->sessionStats['character_frequency']);
        
        // Keep only top 26 characters
        $this->sessionStats['character_frequency'] = array_slice($this->sessionStats['character_frequency'], 0, 26, true);
    }
    
    protected function calculateAverageTransformationTime()
    {
        if (!isset($this->performanceMetrics['transformation_times'])) {
            $this->performanceMetrics['transformation_times'] = [];
        }
        
        $this->performanceMetrics['transformation_times'][] = $this->transformationTime;
        
        // Keep only last 10 transformation times
        if (count($this->performanceMetrics['transformation_times']) > 10) {
            array_shift($this->performanceMetrics['transformation_times']);
        }
        
        return round(array_sum($this->performanceMetrics['transformation_times']) / count($this->performanceMetrics['transformation_times']), 2);
    }
    
    protected function detectLanguage(string $text)
    {
        if (empty($text)) {
            return 'Unknown';
        }
        
        // Simple language detection based on character patterns
        $text = mb_strtolower($text, 'UTF-8');
        
        // Remove punctuation and numbers
        $cleanText = preg_replace('/[^\p{L}\s]/u', '', $text);
        
        // Count specific character patterns
        $patterns = [
            'english' => ['the', 'and', 'of', 'to', 'in', 'is', 'you', 'that', 'it', 'he'],
            'spanish' => ['el', 'la', 'de', 'que', 'y', 'en', 'un', 'es', 'se', 'no'],
            'french' => ['le', 'de', 'et', 'à', 'un', 'il', 'être', 'et', 'en', 'avoir'],
            'german' => ['der', 'die', 'und', 'in', 'den', 'von', 'zu', 'das', 'mit', 'sich'],
            'italian' => ['il', 'di', 'che', 'e', 'la', 'per', 'in', 'un', 'è', 'del'],
        ];
        
        $scores = [];
        foreach ($patterns as $lang => $words) {
            $score = 0;
            foreach ($words as $word) {
                $score += substr_count($cleanText, ' ' . $word . ' ');
                // Also check at beginning and end of string
                if (strpos($cleanText, $word . ' ') === 0) $score++;
                if (strrpos($cleanText, ' ' . $word) === strlen($cleanText) - strlen(' ' . $word)) $score++;
            }
            $scores[$lang] = $score;
        }
        
        arsort($scores);
        $topLanguage = array_keys($scores)[0];
        
        // Return language if we have a decent confidence
        return $scores[$topLanguage] > 2 ? ucfirst($topLanguage) : 'Unknown';
    }
    
    public function toggleStatistics()
    {
        $this->showStatistics = !$this->showStatistics;
        $this->userPreferences['statistics_visible'] = $this->showStatistics;
        
        $message = $this->showStatistics ? 'Statistics panel opened' : 'Statistics panel closed';
        $this->dispatch('show-toast', message: $message, type: 'success');
    }
    
    public function exportStatistics(string $format = 'json')
    {
        $exportData = [
            'session_stats' => $this->sessionStats,
            'input_stats' => $this->inputStats,
            'output_stats' => $this->outputStats,
            'comparison_stats' => $this->comparisonStats,
            'performance_metrics' => $this->performanceMetrics,
            'detected_language' => $this->detectedLanguage,
            'transformation_history' => $this->transformationHistory,
            'export_timestamp' => now()->toISOString(),
        ];
        
        $filename = 'case-changer-statistics-' . date('Y-m-d-H-i-s');
        
        switch ($format) {
            case 'csv':
                $csvContent = $this->arrayToCsv($exportData);
                $this->dispatch('download-file', [
                    'content' => $csvContent,
                    'filename' => $filename . '.csv',
                    'type' => 'text/csv'
                ]);
                break;
                
            default:
                $this->dispatch('download-file', [
                    'content' => json_encode($exportData, JSON_PRETTY_PRINT),
                    'filename' => $filename . '.json',
                    'type' => 'application/json'
                ]);
                break;
        }
        
        $this->dispatch('show-toast', message: 'Statistics exported successfully!', type: 'success');
    }
    
    protected function arrayToCsv(array $data, string $prefix = ''): string
    {
        $csv = [];
        foreach ($data as $key => $value) {
            $fullKey = $prefix ? $prefix . '.' . $key : $key;
            if (is_array($value)) {
                $csv[] = $this->arrayToCsv($value, $fullKey);
            } else {
                $csv[] = $fullKey . ',' . $value;
            }
        }
        return implode("\n", $csv);
    }
    
    public function setViewMode(string $mode)
    {
        if (in_array($mode, ['side-by-side', 'stacked'])) {
            $this->viewMode = $mode;
            $this->userPreferences['view_mode'] = $mode;
            $this->dispatch('show-toast', message: 'View mode updated', type: 'success');
        }
    }
    
    public function getMemoryUsage()
    {
        return [
            'current' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
            'peak' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB',
        ];
    }
    
    // Empty State Animation Methods
    
    protected function initializeEmptyStateAnimation()
    {
        $this->showEmptyStateAnimation = empty($this->inputText);
        $this->currentPlaceholderIndex = 0;
    }
    
    public function nextPlaceholder()
    {
        $this->currentPlaceholderIndex = ($this->currentPlaceholderIndex + 1) % count($this->animatedPlaceholders);
    }
    
    public function getCurrentPlaceholder()
    {
        return $this->animatedPlaceholders[$this->currentPlaceholderIndex] ?? $this->animatedPlaceholders[0];
    }
    
    public function enableEmptyStateAnimation()
    {
        $this->showEmptyStateAnimation = empty($this->inputText);
    }
    
    // Large Text Handling Methods
    
    public function checkTextSize()
    {
        $textSize = strlen($this->inputText);
        $this->isLargeText = $textSize > 100000; // 100KB
        $this->showSizeWarning = $textSize > $this->maxTextSize;
        
        if ($this->showSizeWarning) {
            $this->dispatch('show-toast', 
                message: 'Warning: Text exceeds 1MB. Consider splitting into smaller chunks for better performance.', 
                type: 'warning'
            );
        }
        
        return $textSize;
    }
    
    public function updateProcessingProgress($progress)
    {
        $this->processingProgress = $progress;
        $this->showProgressBar = $progress > 0 && $progress < 100;
    }
    
    // Mixed Languages and Unicode Support Methods
    
    protected function detectContentFeatures()
    {
        if (empty($this->inputText)) {
            return;
        }
        
        // Detect RTL content
        $this->hasRtlContent = $this->detectRtlContent($this->inputText);
        
        // Detect emojis
        $this->hasEmojis = $this->detectEmojis($this->inputText);
        
        // Detect code blocks
        $this->hasCodeBlocks = $this->detectCodeBlocks($this->inputText);
        
        // Detect URLs and emails
        $this->detectUrlsAndEmails($this->inputText);
        
        // Detect multiple languages
        $this->detectMultipleLanguages($this->inputText);
    }
    
    protected function detectRtlContent(string $text): bool
    {
        // Check for Hebrew, Arabic, Persian characters
        return preg_match('/[\x{0590}-\x{05FF}\x{0600}-\x{06FF}\x{0750}-\x{077F}]/u', $text) > 0;
    }
    
    protected function detectEmojis(string $text): bool
    {
        // Detect emoji patterns
        return preg_match('/[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]/u', $text) > 0;
    }
    
    protected function detectCodeBlocks(string $text): bool
    {
        // Detect code patterns: ```code```, function(), class definitions, etc.
        $patterns = [
            '/```[\s\S]*?```/', // Markdown code blocks
            '/`[^`\n]+`/', // Inline code
            '/function\s+\w+\s*\(/', // Function definitions
            '/class\s+\w+/', // Class definitions
            '/\$\w+\s*=/', // Variable assignments
            '/<[a-zA-Z][^>]*>/', // HTML tags
            '/\w+\(\)/', // Function calls
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text)) {
                return true;
            }
        }
        
        return false;
    }
    
    protected function detectUrlsAndEmails(string $text)
    {
        // Detect URLs
        $urlPattern = '/https?:\/\/[^\s<>"\'{}\|\\^`\[\]]+/i';
        preg_match_all($urlPattern, $text, $urlMatches);
        $this->detectedUrls = $urlMatches[0] ?? [];
        
        // Detect emails
        $emailPattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';
        preg_match_all($emailPattern, $text, $emailMatches);
        $this->detectedEmails = $emailMatches[0] ?? [];
    }
    
    protected function detectMultipleLanguages(string $text)
    {
        // Enhanced language detection
        $this->detectedLanguages = [];
        
        if (preg_match('/[\x{0590}-\x{05FF}]/u', $text)) {
            $this->detectedLanguages[] = 'Hebrew';
        }
        if (preg_match('/[\x{0600}-\x{06FF}]/u', $text)) {
            $this->detectedLanguages[] = 'Arabic';
        }
        if (preg_match('/[\x{4e00}-\x{9fff}]/u', $text)) {
            $this->detectedLanguages[] = 'Chinese';
        }
        if (preg_match('/[\x{3040}-\x{309f}\x{30a0}-\x{30ff}]/u', $text)) {
            $this->detectedLanguages[] = 'Japanese';
        }
        if (preg_match('/[\x{ac00}-\x{d7af}]/u', $text)) {
            $this->detectedLanguages[] = 'Korean';
        }
        if (preg_match('/[\x{0400}-\x{04FF}]/u', $text)) {
            $this->detectedLanguages[] = 'Cyrillic';
        }
        
        // Add detected primary language
        if ($this->detectedLanguage !== 'Unknown') {
            $this->detectedLanguages[] = $this->detectedLanguage;
        }
        
        $this->detectedLanguages = array_unique($this->detectedLanguages);
    }
    
    // URL/Email Preservation Methods
    
    protected function preserveUrls(string $text, string $transformation): string
    {
        if (!$this->preserveUrls || empty($this->detectedUrls)) {
            return $text;
        }
        
        $placeholders = [];
        $preservedText = $text;
        
        foreach ($this->detectedUrls as $index => $url) {
            $placeholder = '__URL_PLACEHOLDER_' . $index . '__';
            $placeholders[$placeholder] = $url;
            $preservedText = str_replace($url, $placeholder, $preservedText);
        }
        
        // Apply transformation to text with placeholders
        $transformedText = $this->applyBasicTransformation($preservedText, $transformation);
        
        // Restore URLs
        foreach ($placeholders as $placeholder => $url) {
            $transformedText = str_replace($placeholder, $url, $transformedText);
        }
        
        return $transformedText;
    }
    
    protected function preserveEmails(string $text, string $transformation): string
    {
        if (!$this->preserveEmails || empty($this->detectedEmails)) {
            return $text;
        }
        
        $placeholders = [];
        $preservedText = $text;
        
        foreach ($this->detectedEmails as $index => $email) {
            $placeholder = '__EMAIL_PLACEHOLDER_' . $index . '__';
            $placeholders[$placeholder] = $email;
            $preservedText = str_replace($email, $placeholder, $preservedText);
        }
        
        // Apply transformation to text with placeholders
        $transformedText = $this->applyBasicTransformation($preservedText, $transformation);
        
        // Restore emails
        foreach ($placeholders as $placeholder => $email) {
            $transformedText = str_replace($placeholder, $email, $transformedText);
        }
        
        return $transformedText;
    }
    
    protected function applyBasicTransformation(string $text, string $transformation): string
    {
        $transformationService = new TransformationService();
        return $transformationService->transform($text, $transformation);
    }
    
    // Auto-save Methods
    
    protected function initializeAutoSave()
    {
        $this->lastSavedAt = now()->format('H:i:s');
    }
    
    public function performAutoSave()
    {
        if (!$this->autoSaveEnabled || !$this->hasUnsavedChanges) {
            return;
        }
        
        $saveData = [
            'inputText' => $this->inputText,
            'outputText' => $this->outputText,
            'selectedTransformation' => $this->selectedTransformation,
            'timestamp' => now()->toISOString(),
            'userPreferences' => $this->userPreferences,
            'sessionStats' => $this->sessionStats,
        ];
        
        $this->dispatch('save-to-local-storage', data: $saveData);
        $this->lastSavedAt = now()->format('H:i:s');
        $this->hasUnsavedChanges = false;
        
        $this->dispatch('show-toast', message: 'Auto-saved at ' . $this->lastSavedAt, type: 'info');
    }
    
    public function loadFromAutoSave($data)
    {
        if (empty($data)) {
            return;
        }
        
        $this->inputText = $data['inputText'] ?? '';
        $this->outputText = $data['outputText'] ?? '';
        $this->selectedTransformation = $data['selectedTransformation'] ?? '';
        
        if (isset($data['userPreferences'])) {
            $this->userPreferences = array_merge($this->userPreferences, $data['userPreferences']);
        }
        
        if (isset($data['sessionStats'])) {
            $this->sessionStats = array_merge($this->sessionStats, $data['sessionStats']);
        }
        
        $this->updateCounts();
        $this->hasUnsavedChanges = false;
        
        $this->dispatch('show-toast', message: 'Previous session restored from auto-save', type: 'success');
    }
    
    // PWA and Offline Methods
    
    public function handleOnlineStatusChange($isOnline)
    {
        $this->isOnline = $isOnline;
        $this->offlineMode = !$isOnline;
        
        $message = $isOnline ? 'Back online! All features available.' : 'Offline mode. Limited functionality available.';
        $type = $isOnline ? 'success' : 'warning';
        
        $this->dispatch('show-toast', message: $message, type: $type);
        
        // Sync data when back online
        if ($isOnline && $this->hasUnsavedChanges) {
            $this->performAutoSave();
        }
    }
    
    // Haptic and Sound Methods
    
    public function triggerHapticFeedback($type = 'light')
    {
        if (!$this->hapticsEnabled) {
            return;
        }
        
        $this->dispatch('trigger-haptic', type: $type);
    }
    
    public function playSuccessSound()
    {
        if (!$this->soundsEnabled) {
            return;
        }
        
        $this->dispatch('play-success-sound');
    }
    
    // Settings Methods
    
    public function toggleHaptics()
    {
        $this->hapticsEnabled = !$this->hapticsEnabled;
        $this->userPreferences['haptics_enabled'] = $this->hapticsEnabled;
        
        if ($this->hapticsEnabled) {
            $this->triggerHapticFeedback('medium');
        }
        
        $message = $this->hapticsEnabled ? 'Haptic feedback enabled' : 'Haptic feedback disabled';
        $this->dispatch('show-toast', message: $message, type: 'success');
    }
    
    public function toggleSounds()
    {
        $this->soundsEnabled = !$this->soundsEnabled;
        $this->userPreferences['sounds_enabled'] = $this->soundsEnabled;
        
        if ($this->soundsEnabled) {
            $this->playSuccessSound();
        }
        
        $message = $this->soundsEnabled ? 'Sound effects enabled' : 'Sound effects disabled';
        $this->dispatch('show-toast', message: $message, type: 'success');
    }
    
    public function toggleAutoSave()
    {
        $this->autoSaveEnabled = !$this->autoSaveEnabled;
        $this->userPreferences['auto_save_enabled'] = $this->autoSaveEnabled;
        
        $message = $this->autoSaveEnabled ? 'Auto-save enabled' : 'Auto-save disabled';
        $this->dispatch('show-toast', message: $message, type: 'success');
    }
    
    public function toggleUrlPreservation()
    {
        $this->preserveUrls = !$this->preserveUrls;
        $this->userPreferences['preserve_urls'] = $this->preserveUrls;
        
        $message = $this->preserveUrls ? 'URL preservation enabled' : 'URL preservation disabled';
        $this->dispatch('show-toast', message: $message, type: 'success');
    }
    
    public function toggleEmailPreservation()
    {
        $this->preserveEmails = !$this->preserveEmails;
        $this->userPreferences['preserve_emails'] = $this->preserveEmails;
        
        $message = $this->preserveEmails ? 'Email preservation enabled' : 'Email preservation disabled';
        $this->dispatch('show-toast', message: $message, type: 'success');
    }
    
    // Undo/Redo Implementation Methods
    
    protected function initializeUndoRedo()
    {
        // Save initial state
        $this->saveState();
    }
    
    protected function saveState(bool $clearRedo = true)
    {
        $state = [
            'inputText' => $this->inputText,
            'outputText' => $this->outputText,
            'selectedTransformation' => $this->selectedTransformation,
            'timestamp' => now()->timestamp,
        ];
        
        // Don't save if it's the same as the last state
        if (!empty($this->undoStack) && $this->undoStack[count($this->undoStack) - 1]['inputText'] === $this->inputText) {
            return;
        }
        
        array_push($this->undoStack, $state);
        
        // Keep only the most recent states
        if (count($this->undoStack) > $this->maxUndoStates) {
            array_shift($this->undoStack);
        }
        
        // Clear redo stack when new state is saved
        if ($clearRedo) {
            $this->redoStack = [];
        }
        
        $this->updateUndoRedoState();
    }
    
    public function undo()
    {
        if (empty($this->undoStack) || count($this->undoStack) <= 1) {
            $this->dispatch('show-toast', message: 'Nothing to undo', type: 'info');
            return;
        }
        
        // Save current state to redo stack
        $currentState = [
            'inputText' => $this->inputText,
            'outputText' => $this->outputText,
            'selectedTransformation' => $this->selectedTransformation,
            'timestamp' => now()->timestamp,
        ];
        array_push($this->redoStack, $currentState);
        
        // Remove the last state and restore the previous one
        array_pop($this->undoStack);
        $previousState = end($this->undoStack);
        
        $this->restoreState($previousState);
        
        $this->dispatch('show-toast', message: 'Undone', type: 'success');
    }
    
    public function redo()
    {
        if (empty($this->redoStack)) {
            $this->dispatch('show-toast', message: 'Nothing to redo', type: 'info');
            return;
        }
        
        $redoState = array_pop($this->redoStack);
        $this->restoreState($redoState, false);
        
        $this->dispatch('show-toast', message: 'Redone', type: 'success');
    }
    
    protected function restoreState(array $state, bool $saveState = true)
    {
        $this->inputText = $state['inputText'];
        $this->outputText = $state['outputText'];
        $this->selectedTransformation = $state['selectedTransformation'];
        
        $this->updateCounts();
        $this->updateRealTimeStatistics();
        
        if ($saveState) {
            $this->saveState(false); // Don't clear redo stack during restore
        }
        
        $this->updateUndoRedoState();
    }
    
    protected function updateUndoRedoState()
    {
        $this->canUndo = count($this->undoStack) > 1;
        $this->canRedo = count($this->redoStack) > 0;
    }
    
    public function render()
    {
        // Update memory usage in performance metrics
        $this->performanceMetrics['memory_usage'] = $this->getMemoryUsage();
        
        return view('livewire.premium-converter');
    }
}
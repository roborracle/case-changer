<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;
use App\Services\PreservationService;
use App\Services\StyleGuideService;
use App\Services\HistoryService;
use App\Services\ContextualSuggestionService;
use Illuminate\Support\Facades\Log;

/**
 * SCARLETT Documentation Standard
 * Purpose: Main Livewire component for text case transformation interface
 * Architecture: Service-oriented orchestrator following SOLID principles
 * Dependencies: TransformationService, PreservationService, StyleGuideService, HistoryService
 * Constraints: Memory limit for large texts, browser clipboard API availability
 * Failure Modes: Service unavailable, memory overflow, session timeout
 */
class CaseChanger extends Component
{
    /**
     * Maximum text length allowed (1MB)
     * @var int
     */
    private const MAX_TEXT_LENGTH = 1048576;
    
    /**
     * Livewire event listeners
     * @var array
     */
    protected $listeners = [
        'resetCopied' => 'resetCopied',
        'copyToClipboard' => 'copyToClipboard',
        'clearAll' => 'clearAll',
        'undo' => 'undo',
        'redo' => 'redo'
    ];
    
    /**
     * User input text to be transformed
     * @var string
     */
    public string $inputText = '';
    
    /**
     * Transformed output text
     * @var string
     */
    public string $outputText = '';
    
    /**
     * Currently selected transformation type
     * @var string
     */
    public string $selectedTransformation = '';
    
    /**
     * Currently selected style guide
     * @var string
     */
    public string $selectedStyleGuide = '';
    
    /**
     * Error message for user feedback
     * @var string
     */
    public string $errorMessage = '';
    
    /**
     * Success message for user feedback
     * @var string
     */
    public string $successMessage = '';
    
    /**
     * Whether advanced options are visible
     * @var bool
     */
    public bool $showAdvancedOptions = false;
    
    /**
     * Whether preservation settings are visible
     * @var bool
     */
    public bool $showPreservationSettings = false;
    
    /**
     * Whether text was copied to clipboard
     * @var bool
     */
    public bool $copied = false;
    
    /**
     * Text statistics
     * @var array
     */
    public array $stats = [
        'characters' => 0,
        'words' => 0,
        'sentences' => 0,
        'lines' => 0
    ];

    /**
     * Smart preservation settings
     * @var array
     */
    public array $preservationSettings = [
        'urls' => true,
        'emails' => true,
        'brands' => true,
        'code_blocks' => false,
        'markdown' => false,
        'mentions' => false,
        'hashtags' => false,
        'file_paths' => false,
        'custom_terms' => []
    ];

    /**
     * Available transformations grouped by category
     * @var array
     */
    public array $transformationGroups = [];
    
    /**
     * Available style guides
     * @var array
     */
    public array $styleGuides = [];
    
    /**
     * History state information
     * @var array
     */
    public array $historyInfo = [
        'can_undo' => false,
        'can_redo' => false,
        'position' => 0,
        'total' => 0
    ];

    /**
     * Contextual suggestions for current text
     * @var array
     */
    public array $contextualSuggestions = [];
    
    // Glassmorphism UI Properties
    public ?string $detectedContext = null;
    public array $suggestions = [];
    public array $popularTransformations = [];
    public string $activeCategory = 'all';
    public bool $showAdvanced = false;
    public int $totalTools = 0;
    public array $filteredTools = [];
    public string $searchTerm = '';
    public array $history = [];
    public ?string $notification = null;
    public ?string $textAnalysis = null;
    public int $totalTransformations = 0;
    public int $uniqueUsersToday = 0;
    
    // Advanced Settings
    public bool $preserveFormatting = true;
    public bool $smartDetection = true;
    public bool $autoSuggest = true;
    public bool $realTimePreview = false;
    
    /**
     * Service instances
     */
    protected TransformationService $transformationService;
    protected PreservationService $preservationService;
    protected StyleGuideService $styleGuideService;
    protected HistoryService $historyService;
    protected ContextualSuggestionService $contextualSuggestionService;

    /**
     * Component boot lifecycle - inject services using app() helper
     */
    public function boot(): void
    {
        // Use app() helper to resolve services - Livewire compatible pattern
        $this->transformationService = app(TransformationService::class);
        $this->preservationService = app(PreservationService::class);
        $this->styleGuideService = app(StyleGuideService::class);
        $this->historyService = app(HistoryService::class);
        $this->contextualSuggestionService = app(ContextualSuggestionService::class);
    }

    /**
     * Component mount lifecycle
     */
    public function mount(): void
    {
        $this->loadTransformationGroups();
        $this->loadStyleGuides();
        $this->updateStatistics();
        $this->updateHistoryInfo();
        $this->initializeGlassmorphismData();
        
        // Restore session if exists
        $this->restoreSession();
    }

    /**
     * Load available transformation groups
     */
    private function loadTransformationGroups(): void
    {
        $this->transformationGroups = [
            'standard' => [
                'title' => 'Standard Cases',
                'transformations' => [
                    'title' => 'Title Case',
                    'sentence' => 'Sentence case',
                    'upper' => 'UPPERCASE',
                    'lower' => 'lowercase',
                    'first_letter' => 'First letter',
                    'alternating' => 'aLtErNaTiNg CaSe',
                    'random' => 'RaNdOm CaSe',
                    'inverse' => 'iNVERSE cASE'
                ]
            ],
            'developer' => [
                'title' => 'Developer Cases',
                'transformations' => [
                    'camel' => 'camelCase',
                    'pascal' => 'PascalCase',
                    'snake' => 'snake_case',
                    'kebab' => 'kebab-case',
                    'constant' => 'CONSTANT_CASE',
                    'dot' => 'dot.case',
                    'path' => 'path/case',
                    'header' => 'Header-Case',
                    'cobol' => 'COBOL-CASE',
                    'macro' => 'MACRO_CASE',
                    'train' => 'Train-Case',
                    'flat' => 'flatcase',
                    'slug' => 'slug-case'
                ]
            ],
            'creative' => [
                'title' => 'Creative Cases',
                'transformations' => [
                    'spongebob' => 'sPoNgEbOb CaSe',
                    'wide' => 'Ｗｉｄｅ　Ｔｅｘｔ',
                    'small_caps' => 'sᴍᴀʟʟ ᴄᴀᴘs',
                    'strikethrough' => 's̶t̶r̶i̶k̶e̶t̶h̶r̶o̶u̶g̶h̶',
                    'zalgo' => 'Z̸̢̀a̸̧̕l̶̡̨g̷̨̧o̸̢̕ ̵̧̀T̶̨̕e̸̢̧x̴̨̕t̷̡̀',
                    'upside_down' => 'uʍop ǝpısdn',
                    'reversed' => 'desreveR',
                    'hashtag' => '#HashtagCase',
                    'mention' => '@mention_case',
                    'leetspeak' => 'L337sp34k'
                ]
            ],
            'encoding' => [
                'title' => 'Encoding & Conversion',
                'transformations' => [
                    'binary' => 'Binary',
                    'base64' => 'Base64',
                    'url_encoded' => 'URL Encoded',
                    'html_entities' => 'HTML Entities',
                    'rot13' => 'ROT13 Cipher',
                    'morse' => 'Morse Code',
                    'nato' => 'NATO Phonetic'
                ]
            ],
            'whitespace' => [
                'title' => 'Whitespace & Formatting',
                'transformations' => [
                    'remove_spaces' => 'Remove Spaces',
                    'remove_extra_spaces' => 'Remove Extra Spaces',
                    'add_spaces' => 'Add Spaces',
                    'spaces_to_underscores' => 'Spaces → Underscores',
                    'underscores_to_spaces' => 'Underscores → Spaces',
                    'no_whitespace' => 'No Whitespace',
                    'smart_quotes' => 'Smart "Quotes"'
                ]
            ]
        ];
    }

    /**
     * Load available style guides
     */
    private function loadStyleGuides(): void
    {
        $this->styleGuides = [
            'academic' => [
                'title' => 'Academic Styles',
                'guides' => [
                    'apa' => 'APA Style',
                    'mla' => 'MLA Style',
                    'chicago' => 'Chicago Style',
                    'harvard' => 'Harvard Style',
                    'ieee' => 'IEEE Style',
                    'ama' => 'AMA Style',
                    'vancouver' => 'Vancouver Style'
                ]
            ],
            'journalism' => [
                'title' => 'Journalism Styles',
                'guides' => [
                    'ap' => 'AP Style',
                    'nytimes' => 'NY Times Style',
                    'reuters' => 'Reuters Style',
                    'bloomberg' => 'Bloomberg Style',
                    'wikipedia' => 'Wikipedia Style'
                ]
            ],
            'legal_academic' => [
                'title' => 'Legal & Academic',
                'guides' => [
                    'bluebook' => 'Bluebook Style',
                    'oscola' => 'OSCOLA Style',
                    'oxford' => 'Oxford Style',
                    'cambridge' => 'Cambridge Style'
                ]
            ]
        ];
    }

    /**
     * Update statistics when text changes
     */
    public function updatedInputText(): void
    {
        $this->clearMessages();
        
        // Validate input length
        if (mb_strlen($this->inputText, 'UTF-8') > self::MAX_TEXT_LENGTH) {
            $this->errorMessage = 'Text exceeds maximum length of ' . number_format(self::MAX_TEXT_LENGTH) . ' characters.';
            $this->inputText = mb_substr($this->inputText, 0, self::MAX_TEXT_LENGTH, 'UTF-8');
        }
        
        // Check for valid UTF-8
        if (!mb_check_encoding($this->inputText, 'UTF-8')) {
            $this->errorMessage = 'Invalid character encoding detected. Please use UTF-8 text.';
            $this->inputText = mb_convert_encoding($this->inputText, 'UTF-8', 'UTF-8');
        }
        
        $this->updateStatistics();
        $this->updateContextualSuggestions();
        $this->copied = false;
        
        // Add to history
        if (!empty($this->inputText)) {
            $this->historyService->addState(
                $this->inputText,
                $this->selectedTransformation,
                [
                    'output' => $this->outputText,
                    'style_guide' => $this->selectedStyleGuide
                ]
            );
            $this->updateHistoryInfo();
        }
    }

    /**
     * Update text statistics
     */
    private function updateStatistics(): void
    {
        $text = $this->inputText;
        
        $this->stats = [
            'characters' => mb_strlen($text, 'UTF-8'),
            'words' => str_word_count($text),
            'sentences' => preg_match_all('/[.!?]+/', $text, $matches),
            'lines' => substr_count($text, "\n") + 1
        ];
    }
    
    /**
     * Update contextual suggestions based on input text
     */
    private function updateContextualSuggestions(): void
    {
        if (empty($this->inputText)) {
            $this->contextualSuggestions = [];
            $this->suggestions = [];
            $this->detectedContext = null;
            return;
        }
        
        $this->contextualSuggestions = $this->contextualSuggestionService->getSuggestions($this->inputText);
        
        // Map to glassmorphism format
        $this->suggestions = array_map(function($suggestion) {
            return [
                'type' => $suggestion['transformation'] ?? 'title',
                'label' => $suggestion['label'] ?? $suggestion['transformation'] ?? 'Transform',
                'style' => $this->getStyleForTransformation($suggestion['transformation'] ?? 'title')
            ];
        }, array_slice($this->contextualSuggestions, 0, 5));
        
        // Detect context
        $analysis = $this->contextualSuggestionService->analyzeText($this->inputText);
        if ($analysis['is_code']) {
            $this->detectedContext = 'Code';
        } elseif ($analysis['is_email']) {
            $this->detectedContext = 'Email';
        } elseif ($analysis['is_url']) {
            $this->detectedContext = 'URL';
        } elseif ($analysis['is_title']) {
            $this->detectedContext = 'Title';
        } else {
            $this->detectedContext = null;
        }
        
        // Update text analysis
        $wordCount = str_word_count($this->inputText);
        if ($wordCount === 1) {
            $this->textAnalysis = 'Single word';
        } elseif ($wordCount < 5) {
            $this->textAnalysis = 'Short phrase';
        } elseif ($wordCount < 20) {
            $this->textAnalysis = 'Sentence';
        } elseif ($wordCount < 100) {
            $this->textAnalysis = 'Paragraph';
        } else {
            $this->textAnalysis = 'Long text';
        }
    }
    
    /**
     * Initialize glassmorphism UI data
     */
    private function initializeGlassmorphismData(): void
    {
        // Initialize popular transformations
        $this->popularTransformations = [
            ['type' => 'upper', 'label' => 'UPPERCASE', 'style' => 'uppercase'],
            ['type' => 'lower', 'label' => 'lowercase', 'style' => 'lowercase'],
            ['type' => 'title', 'label' => 'Title Case', 'style' => 'title'],
            ['type' => 'sentence', 'label' => 'Sentence case', 'style' => 'sentence'],
            ['type' => 'camel', 'label' => 'camelCase', 'style' => 'camel'],
            ['type' => 'pascal', 'label' => 'PascalCase', 'style' => 'pascal'],
            ['type' => 'snake', 'label' => 'snake_case', 'style' => 'snake'],
            ['type' => 'kebab', 'label' => 'kebab-case', 'style' => 'kebab'],
        ];
        
        // Count total tools
        $this->totalTools = 0;
        foreach ($this->transformationGroups as $group) {
            $this->totalTools += count($group['transformations']);
        }
        
        // Initialize filtered tools
        $this->updateFilteredTools();
        
        // Set demo stats
        $this->totalTransformations = rand(50000, 100000);
        $this->uniqueUsersToday = rand(100, 500);
    }
    
    /**
     * Analyze text (for wire:input)
     */
    public function analyzeText(): void
    {
        $this->updateContextualSuggestions();
    }
    
    /**
     * Update filtered tools based on search and category
     */
    public function updateFilteredTools(): void
    {
        $tools = [];
        
        foreach ($this->transformationGroups as $groupKey => $group) {
            // Filter by category if not 'all'
            if ($this->activeCategory !== 'all') {
                $categoryMap = [
                    'case' => ['standard'],
                    'developer' => ['developer'],
                    'style' => ['encoding', 'whitespace'],
                    'creative' => ['creative']
                ];
                
                if (isset($categoryMap[$this->activeCategory]) && 
                    !in_array($groupKey, $categoryMap[$this->activeCategory])) {
                    continue;
                }
            }
            
            foreach ($group['transformations'] as $key => $label) {
                // Filter by search term
                if (!empty($this->searchTerm)) {
                    if (stripos($label, $this->searchTerm) === false && 
                        stripos($key, $this->searchTerm) === false) {
                        continue;
                    }
                }
                
                $tools[] = [
                    'type' => $key,
                    'label' => $label,
                    'style' => $this->getStyleForTransformation($key),
                    'description' => $this->getDescriptionForTransformation($key)
                ];
            }
        }
        
        $this->filteredTools = $tools;
    }
    
    /**
     * Get style class for transformation
     */
    private function getStyleForTransformation(string $type): string
    {
        $styleMap = [
            'upper' => 'uppercase',
            'lower' => 'lowercase',
            'title' => 'title',
            'sentence' => 'sentence',
            'camel' => 'camel',
            'pascal' => 'pascal',
            'snake' => 'snake',
            'kebab' => 'kebab',
            'alternating' => 'alternating',
            'inverse' => 'inverse',
            'wide' => 'wide',
            'small_caps' => 'small-caps',
            'reversed' => 'reversed'
        ];
        
        return $styleMap[$type] ?? 'default';
    }
    
    /**
     * Get description for transformation
     */
    private function getDescriptionForTransformation(string $type): string
    {
        $descriptions = [
            'upper' => 'Convert all text to uppercase letters',
            'lower' => 'Convert all text to lowercase letters',
            'title' => 'Capitalize the first letter of each word',
            'sentence' => 'Capitalize the first letter of each sentence',
            'camel' => 'Convert to camelCase for variables',
            'pascal' => 'Convert to PascalCase for classes',
            'snake' => 'Convert to snake_case for Python/Ruby',
            'kebab' => 'Convert to kebab-case for URLs',
            'alternating' => 'AlTeRnAtE case for each letter',
            'inverse' => 'Invert the case of each letter',
            'wide' => 'Convert to full-width characters',
            'small_caps' => 'Convert to small capital letters',
            'reversed' => 'Reverse the text order'
        ];
        
        return $descriptions[$type] ?? 'Transform your text';
    }

    /**
     * Apply selected transformation
     */
    public function applyTransformation(string $transformationType): void
    {
        try {
            $this->clearMessages();
            
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            $this->selectedTransformation = $transformationType;
            $this->selectedStyleGuide = '';
            
            // Apply preservation if enabled
            $text = $this->inputText;
            $preservedItems = [];
            
            if ($this->shouldUsePreservation($transformationType)) {
                [$text, $preservedItems] = $this->preservationService->preserveContent(
                    $text,
                    $this->preservationSettings
                );
            }
            
            // Apply transformation
            $transformed = $this->transformationService->transform($text, $transformationType);
            
            // Restore preserved content
            if (!empty($preservedItems)) {
                $transformed = $this->preservationService->restoreContent($transformed, $preservedItems);
            }
            
            $this->outputText = $transformed;
            $this->copied = false;
            
            // Add to history
            $this->addToHistory();
            
            // Show notification
            $this->showNotification('Transformation applied!');
            
            // Update stats
            $this->totalTransformations++;
            
        } catch (\Exception $e) {
            $this->errorMessage = 'Error during transformation: ' . $e->getMessage();
            Log::error('Transformation failed', [
                'type' => $transformationType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    /**
     * Transform text (glassmorphism method)
     */
    public function transform(string $type): void
    {
        $this->applyTransformation($type);
    }

    /**
     * Apply selected style guide
     */
    public function applyStyleGuide(string $styleGuide): void
    {
        try {
            $this->clearMessages();
            
            if (empty($this->inputText)) {
                $this->outputText = '';
                return;
            }
            
            $this->selectedStyleGuide = $styleGuide;
            $this->selectedTransformation = '';
            
            // Determine context type
            $context = $this->determineContext($this->inputText);
            
            // Apply style guide formatting
            $this->outputText = $this->styleGuideService->format(
                $this->inputText,
                $styleGuide,
                $context
            );
            
            $this->copied = false;
            
            // Add to history
            $this->addToHistory();
            
            $this->successMessage = 'Style guide applied successfully!';
            
        } catch (\Exception $e) {
            $this->errorMessage = 'Error applying style guide: ' . $e->getMessage();
            Log::error('Style guide application failed', [
                'guide' => $styleGuide,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Determine text context for style guide application
     */
    private function determineContext(string $text): string
    {
        // Check if it's a reference/citation
        if (preg_match('/^\s*\[?\d+\]?\.?\s*/', $text) || 
            preg_match('/\(\d{4}\)/', $text) ||
            preg_match('/pp?\.\s*\d+/', $text)) {
            return 'reference';
        }
        
        // Check if it's a heading (short, no ending punctuation)
        if (mb_strlen($text, 'UTF-8') < 100 && !preg_match('/[.!?]$/', trim($text))) {
            return 'heading';
        }
        
        // Default to title context
        return 'title';
    }

    /**
     * Check if preservation should be used for transformation
     */
    private function shouldUsePreservation(string $transformationType): bool
    {
        // Don't preserve for encoding transformations
        $noPreserveTypes = ['binary', 'base64', 'url_encoded', 'html_entities', 'rot13', 'morse', 'nato'];
        
        return !in_array($transformationType, $noPreserveTypes) && 
               array_filter($this->preservationSettings);
    }

    /**
     * Add custom term to preservation
     */
    public function addCustomTerm(string $term): void
    {
        if (!empty(trim($term))) {
            $this->preservationSettings['custom_terms'][] = trim($term);
            $this->successMessage = 'Custom term added to preservation list.';
        }
    }

    /**
     * Remove custom term from preservation
     */
    public function removeCustomTerm(int $index): void
    {
        if (isset($this->preservationSettings['custom_terms'][$index])) {
            array_splice($this->preservationSettings['custom_terms'], $index, 1);
            $this->successMessage = 'Custom term removed from preservation list.';
        }
    }

    /**
     * Undo last transformation
     */
    public function undo(): void
    {
        $text = $this->historyService->undo();
        
        if ($text !== null) {
            $this->inputText = $text;
            // Clear output since we're going back to a previous input state
            $this->outputText = '';
            $this->selectedTransformation = '';
            $this->selectedStyleGuide = '';
            $this->updateStatistics();
            $this->updateHistoryInfo();
            $this->successMessage = 'Undo successful.';
        }
    }

    /**
     * Redo last undone transformation
     */
    public function redo(): void
    {
        $text = $this->historyService->redo();
        
        if ($text !== null) {
            $this->inputText = $text;
            // Clear output since we're moving to a different input state  
            $this->outputText = '';
            $this->selectedTransformation = '';
            $this->selectedStyleGuide = '';
            $this->updateStatistics();
            $this->updateHistoryInfo();
            $this->successMessage = 'Redo successful.';
        }
    }

    /**
     * Jump to specific history state
     */
    public function jumpToState(int $position): void
    {
        $text = $this->historyService->jumpToState($position);
        
        if ($text !== null) {
            $this->inputText = $text;
            // Clear output since we're jumping to a different input state
            $this->outputText = '';
            $this->selectedTransformation = '';
            $this->selectedStyleGuide = '';
            $this->updateStatistics();
            $this->updateHistoryInfo();
            $this->successMessage = 'Jumped to history state ' . ($position + 1) . '.';
        }
    }

    /**
     * Add current state to history
     */
    private function addToHistory(): void
    {
        // Store the output text in history with transformation info
        $this->historyService->addState(
            $this->outputText,
            $this->selectedTransformation ?: $this->selectedStyleGuide,
            [
                'input' => $this->inputText,
                'style_guide' => $this->selectedStyleGuide,
                'preservation' => $this->preservationSettings
            ]
        );
        
        // Update history array for UI
        $this->history[] = [
            'transformation' => $this->getTransformationName($this->selectedTransformation),
            'timestamp' => now()->format('H:i:s'),
            'input' => substr($this->inputText, 0, 50),
            'output' => substr($this->outputText, 0, 50)
        ];
        
        // Keep only last 10 history items for UI
        $this->history = array_slice($this->history, -10);
        
        $this->updateHistoryInfo();
    }
    
    /**
     * Restore from history
     */
    public function restoreFromHistory(int $index): void
    {
        if (isset($this->history[$index])) {
            $this->jumpToState($index);
        }
    }

    /**
     * Update history information
     */
    private function updateHistoryInfo(): void
    {
        $this->historyInfo = [
            'can_undo' => $this->historyService->canUndo(),
            'can_redo' => $this->historyService->canRedo(),
            'position' => $this->historyService->getCurrentPosition() + 1,
            'total' => $this->historyService->getHistoryCount()
        ];
    }

    /**
     * Copy output to clipboard
     */
    public function copyToClipboard(): void
    {
        if (!empty($this->outputText)) {
            $this->dispatch('copy-to-clipboard', text: $this->outputText);
            $this->copied = true;
            $this->successMessage = 'Text copied to clipboard!';
            
            // Reset copied state after 2 seconds
            $this->dispatch('reset-copied');
        }
    }

    /**
     * Reset copied state
     */
    public function resetCopied(): void
    {
        $this->copied = false;
    }

    /**
     * Copy input text to output
     */
    public function copyInputToOutput(): void
    {
        $this->outputText = $this->inputText;
        $this->selectedTransformation = '';
        $this->selectedStyleGuide = '';
        $this->addToHistory();
        $this->successMessage = 'Input copied to output.';
    }

    /**
     * Swap input and output text
     */
    public function swapTexts(): void
    {
        $temp = $this->inputText;
        $this->inputText = $this->outputText;
        $this->outputText = $temp;
        $this->updateStatistics();
        $this->addToHistory();
        $this->successMessage = 'Input and output swapped.';
    }

    /**
     * Clear all text fields
     */
    public function clearAll(): void
    {
        $this->inputText = '';
        $this->outputText = '';
        $this->selectedTransformation = '';
        $this->selectedStyleGuide = '';
        $this->clearMessages();
        $this->copied = false;
        $this->updateStatistics();
        $this->historyService->clearHistory();
        $this->updateHistoryInfo();
    }

    /**
     * Toggle advanced options visibility
     */
    public function toggleAdvancedOptions(): void
    {
        $this->showAdvancedOptions = !$this->showAdvancedOptions;
    }

    /**
     * Toggle preservation settings visibility
     */
    public function togglePreservationSettings(): void
    {
        $this->showPreservationSettings = !$this->showPreservationSettings;
    }

    /**
     * Clear all messages
     */
    private function clearMessages(): void
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }

    /**
     * Restore session state
     */
    private function restoreSession(): void
    {
        $currentText = $this->historyService->getCurrentState();
        
        if ($currentText !== null) {
            // Set the last known text as input
            $this->inputText = $currentText;
            $this->outputText = '';
            
            // Get history info to restore transformation info from metadata
            $historyInfo = $this->historyService->getHistoryInfo();
            if (!empty($historyInfo['states'])) {
                $currentIndex = $this->historyService->getCurrentPosition();
                if (isset($historyInfo['states'][$currentIndex])) {
                    $this->selectedTransformation = $historyInfo['states'][$currentIndex]['transformation'] ?? '';
                }
            }
            
            $this->updateStatistics();
        }
    }

    /**
     * Download output as text file
     */
    public function downloadOutput(): void
    {
        if (!empty($this->outputText)) {
            $filename = 'transformed-text-' . date('Y-m-d-His') . '.txt';
            
            $this->dispatch('download-text', [
                'content' => $this->outputText,
                'filename' => $filename
            ]);
            
            $this->successMessage = 'Download started!';
        }
    }

    /**
     * Export transformation history
     */
    public function exportHistory(): void
    {
        $history = $this->historyService->exportHistory(true);
        
        if (!empty($history)) {
            $filename = 'transformation-history-' . date('Y-m-d-His') . '.json';
            
            $this->dispatch('download-text', [
                'content' => json_encode($history, JSON_PRETTY_PRINT),
                'filename' => $filename
            ]);
            
            $this->successMessage = 'History exported!';
        }
    }

    /**
     * Get transformation display name
     */
    public function getTransformationName(string $type): string
    {
        foreach ($this->transformationGroups as $group) {
            if (isset($group['transformations'][$type])) {
                return $group['transformations'][$type];
            }
        }
        return ucfirst(str_replace('_', ' ', $type));
    }

    /**
     * Get style guide display name
     */
    public function getStyleGuideName(string $guide): string
    {
        foreach ($this->styleGuides as $group) {
            if (isset($group['guides'][$guide])) {
                return $group['guides'][$guide];
            }
        }
        return strtoupper($guide) . ' Style';
    }

    // Elegant Interface Support Methods
    public $currentText = '';
    public $transformationHistory = [];
    public $showCommandPalette = false;
    public $commandSearch = '';
    public $canUndo = false;
    
    /**
     * Toggle command palette visibility
     */
    public function toggleCommandPalette(): void
    {
        $this->showCommandPalette = !$this->showCommandPalette;
        $this->commandSearch = '';
    }
    
    /**
     * Close command palette
     */
    public function closeCommandPalette(): void
    {
        $this->showCommandPalette = false;
        $this->commandSearch = '';
    }
    
    /**
     * Apply transformation and close command palette
     */
    public function applyAndClose(string $method): void
    {
        $this->applyTransformation($method);
        $this->closeCommandPalette();
    }
    
    /**
     * Jump to history state
     */
    public function jumpToHistory(int $index): void
    {
        if (isset($this->transformationHistory[$index])) {
            $this->currentText = $this->transformationHistory[$index]['text'];
            $this->notification = 'Jumped to: ' . $this->transformationHistory[$index]['transformation'];
        }
    }
    
    /**
     * Get filtered transformations for command palette
     */
    public function getFilteredTransformationsProperty()
    {
        if (empty($this->commandSearch)) {
            return $this->transformationGroups;
        }
        
        $search = strtolower($this->commandSearch);
        $filtered = [];
        
        foreach ($this->transformationGroups as $group) {
            $matches = [];
            foreach ($group['transformations'] as $key => $label) {
                if (str_contains(strtolower($label), $search) || str_contains(strtolower($key), $search)) {
                    $matches[$key] = $label;
                }
            }
            if (!empty($matches)) {
                $filtered[$group['title']] = $matches;
            }
        }
        
        return $filtered;
    }
    
    /**
     * Update suggestions when current text changes
     */
    public function updatedCurrentText(): void
    {
        $this->updateSuggestions();
        $this->updateStatistics();
    }
    
    /**
     * Update suggestions based on current text
     */
    public function updateSuggestions(): void
    {
        if (empty($this->currentText)) {
            $this->suggestions = [];
            return;
        }
        
        $this->suggestions = [];
        
        // Detect content type and suggest relevant transformations
        if (preg_match('/^[A-Z\s]+$/', $this->currentText)) {
            $this->suggestions[] = ['key' => 'lower', 'label' => 'Convert to lowercase'];
            $this->suggestions[] = ['key' => 'sentence', 'label' => 'Sentence case'];
        } elseif (preg_match('/^[a-z\s]+$/', $this->currentText)) {
            $this->suggestions[] = ['key' => 'upper', 'label' => 'UPPERCASE'];
            $this->suggestions[] = ['key' => 'title', 'label' => 'Title Case'];
        }
        
        // Detect code patterns
        if (preg_match('/function|class|const|var|let/', $this->currentText)) {
            $this->suggestions[] = ['key' => 'camel', 'label' => 'camelCase'];
            $this->suggestions[] = ['key' => 'snake', 'label' => 'snake_case'];
        }
        
        // Detect URLs
        if (preg_match('/https?:\/\//', $this->currentText)) {
            $this->suggestions[] = ['key' => 'slug', 'label' => 'URL Slug'];
            $this->suggestions[] = ['key' => 'url_encoded', 'label' => 'URL Encode'];
        }
        
        // Limit to 4 suggestions
        $this->suggestions = array_slice($this->suggestions, 0, 4);
    }
    
    /**
     * Show notification message
     */
    public function showNotification(string $message): void
    {
        $this->notification = $message;
        
        // Clear notification after 3 seconds
        $this->dispatch('clear-notification');
    }
    
    /**
     * Toggle advanced drawer
     */
    public function toggleAdvancedDrawer(): void
    {
        $this->showAdvanced = !$this->showAdvanced;
    }
    
    /**
     * Toggle batch mode
     */
    public function toggleBatchMode(): void
    {
        // Placeholder for batch mode functionality
        $this->showNotification('Batch mode coming soon!');
    }
    
    /**
     * Toggle chain mode
     */
    public function toggleChainMode(): void
    {
        // Placeholder for chain mode functionality
        $this->showNotification('Chain mode coming soon!');
    }
    
    /**
     * Render the component
     */
    public function render()
    {
        // Check if we should use glassmorphism interface
        $useGlassmorphism = request()->has('glassmorphism') || session('use_glassmorphism_interface');
        
        if ($useGlassmorphism) {
            session(['use_glassmorphism_interface' => true]);
            return view('livewire.glassmorphism-case-changer');
        }
        
        // Check if we should use the elegant interface
        $useElegantInterface = request()->has('elegant') || session('use_elegant_interface');
        
        if ($useElegantInterface) {
            session(['use_elegant_interface' => true]);
            return view('livewire.elegant-case-changer');
        }
        
        return view('livewire.case-changer');
    }
}

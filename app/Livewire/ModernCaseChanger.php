<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;
use App\Services\PreservationService;
use App\Services\StyleGuideService;
use App\Services\HistoryService;
use App\Services\ContextualSuggestionService;
use Illuminate\Support\Facades\Log;

class ModernCaseChanger extends Component
{
    protected $listeners = [
        'executeTransformation' => 'executeTransformation',
        'openCommandPalette' => 'openCommandPalette',
        'applyQuickAction' => 'applyQuickAction'
    ];
    
    public string $text = '';
    public string $originalText = '';
    public string $searchQuery = '';
    public bool $commandPaletteOpen = false;
    public bool $showQuickActions = false;
    public string $selectedText = '';
    public array $suggestions = [];
    public array $recentTransformations = [];
    public array $frequentTransformations = [];
    public int $selectedIndex = 0;
    public array $history = [];
    public int $historyIndex = -1;
    public string $contentType = '';
    public bool $isTransforming = false;
    public string $previewText = '';
    public string $hoveredTransformation = '';
    
    public array $preservationSettings = [
        'urls' => true,
        'emails' => true,
        'brands' => true,
        'code_blocks' => true,
        'markdown' => false,
        'mentions' => false,
        'hashtags' => false,
        'file_paths' => true
    ];
    
    private TransformationService $transformationService;
    private PreservationService $preservationService;
    private StyleGuideService $styleGuideService;
    private HistoryService $historyService;
    private ContextualSuggestionService $suggestionService;
    
    private array $quickTransformations = [
        'uppercase' => 'UPPERCASE',
        'lowercase' => 'lowercase',
        'title_case' => 'Title Case',
        'sentence_case' => 'Sentence case',
        'camelCase' => 'camelCase',
        'snake_case' => 'snake_case',
        'kebab-case' => 'kebab-case'
    ];
    
    private array $allTransformations = [
        'common' => [
            'uppercase' => 'UPPERCASE',
            'lowercase' => 'lowercase',
            'title_case' => 'Title Case',
            'sentence_case' => 'Sentence case',
            'capitalize_words' => 'Capitalize Words',
            'alternating_case' => 'aLtErNaTiNg CaSe',
            'inverse_case' => 'iNVERSE cASE'
        ],
        'developer' => [
            'camelCase' => 'camelCase',
            'PascalCase' => 'PascalCase',
            'snake_case' => 'snake_case',
            'CONSTANT_CASE' => 'CONSTANT_CASE',
            'kebab-case' => 'kebab-case',
            'dot.case' => 'dot.case',
            'path/case' => 'path/case',
            'namespace\\case' => 'namespace\\case',
            'ada_case' => 'Ada_Case',
            'cobol-case' => 'COBOL-CASE',
            'train-case' => 'Train-Case',
            'http-header-case' => 'Http-Header-Case'
        ],
        'creative' => [
            'reverse' => 'esreveR',
            'aesthetic' => 'a e s t h e t i c',
            'sarcasm' => 'sArCaSm',
            'emoji_case' => '🔤 Emoji Case',
            'smallcaps' => 'sᴍᴀʟʟᴄᴀᴘs',
            'bubble' => 'ⓑⓤⓑⓑⓛⓔ',
            'square' => '🅂🅀🅄🄰🅁🄴',
            'script' => '𝓈𝒸𝓇𝒾𝓅𝓉',
            'double_struck' => '𝕕𝕠𝕦𝕓𝕝𝕖',
            'bold' => '𝐛𝐨𝐥𝐝',
            'italic' => '𝘪𝘵𝘢𝘭𝘪𝘤'
        ],
        'utility' => [
            'remove_spaces' => 'RemoveSpaces',
            'remove_extra_spaces' => 'Remove Extra Spaces',
            'add_dashes' => 'Add-Dashes',
            'add_underscores' => 'Add_Underscores',
            'add_periods' => 'Add.Periods',
            'remove_punctuation' => 'Remove Punctuation',
            'extract_letters' => 'Extract Letters',
            'extract_numbers' => 'Extract Numbers',
            'remove_duplicates' => 'Remove Duplicates',
            'sort_words' => 'Sort Words',
            'shuffle_words' => 'Shuffle Words'
        ],
        'style_guides' => [
            'ap_title' => 'AP Title Case',
            'chicago_title' => 'Chicago Title',
            'mla_title' => 'MLA Title',
            'apa_title' => 'APA Title',
            'nyt_title' => 'NYT Title',
            'wikipedia_title' => 'Wikipedia Title',
            'email_style' => 'Email Style',
            'legal_style' => 'LEGAL STYLE',
            'marketing_headline' => 'Marketing Headline',
            'social_media' => 'Social Media Style',
            'academic_citation' => 'Academic Citation',
            'journalism' => 'Journalism Style',
            'technical_docs' => 'Technical Documentation',
            'user_manual' => 'User Manual Style',
            'api_docs' => 'API Documentation',
            'brand_guidelines' => 'Brand Guidelines'
        ]
    ];
    
    public function boot()
    {
        $this->transformationService = app(TransformationService::class);
        $this->preservationService = app(PreservationService::class);
        $this->styleGuideService = app(StyleGuideService::class);
        $this->historyService = app(HistoryService::class);
        $this->suggestionService = app(ContextualSuggestionService::class);
    }
    
    public function mount()
    {
        $this->loadUserPreferences();
        $this->initializeHistory();
    }
    
    public function updatedText($value)
    {
        if (strlen($value) > 0 && $value !== $this->originalText) {
            $this->detectContentType();
            $this->generateSuggestions();
            $this->showQuickActions = strlen($this->selectedText) > 0;
        } else {
            $this->suggestions = [];
            $this->showQuickActions = false;
        }
    }
    
    public function updatedSearchQuery($value)
    {
        $this->filterTransformations($value);
        $this->selectedIndex = 0;
    }
    
    public function detectContentType()
    {
        $patterns = [
            'code' => '/(?:function|class|def|var|let|const|import|export|if|for|while)\s+\w+/',
            'email' => '/[\w\.-]+@[\w\.-]+\.\w+/',
            'url' => '/https?:\/\/[^\s]+/',
            'title' => '/^[A-Z][^.!?]*[.!?]?$/',
            'markdown' => '/(?:^#{1,6}\s|\*\*|__|```|\[.*\]\(.*\))/',
            'path' => '/(?:\/\w+)+|(?:[A-Z]:\\\\[\w\\\\]+)/',
            'constant' => '/^[A-Z_]+$/',
            'camel' => '/^[a-z]+(?:[A-Z][a-z]+)*$/',
            'snake' => '/^[a-z]+(?:_[a-z]+)*$/',
            'kebab' => '/^[a-z]+(?:-[a-z]+)*$/'
        ];
        
        foreach ($patterns as $type => $pattern) {
            if (preg_match($pattern, $this->text)) {
                $this->contentType = $type;
                return;
            }
        }
        
        $this->contentType = 'text';
    }
    
    public function generateSuggestions()
    {
        $suggestions = [];
        
        // Context-based suggestions
        switch ($this->contentType) {
            case 'code':
                $suggestions = ['camelCase', 'snake_case', 'PascalCase', 'CONSTANT_CASE'];
                break;
            case 'title':
                $suggestions = ['ap_title', 'chicago_title', 'title_case', 'uppercase'];
                break;
            case 'email':
                $suggestions = ['lowercase', 'professional_email', 'remove_spaces'];
                break;
            case 'url':
                $suggestions = ['lowercase', 'kebab-case', 'remove_spaces'];
                break;
            case 'constant':
                $suggestions = ['snake_case', 'CONSTANT_CASE', 'kebab-case'];
                break;
            case 'camel':
                $suggestions = ['snake_case', 'kebab-case', 'PascalCase', 'CONSTANT_CASE'];
                break;
            case 'snake':
                $suggestions = ['camelCase', 'kebab-case', 'PascalCase', 'CONSTANT_CASE'];
                break;
            case 'kebab':
                $suggestions = ['camelCase', 'snake_case', 'PascalCase', 'title_case'];
                break;
            default:
                $suggestions = ['title_case', 'uppercase', 'lowercase', 'sentence_case'];
        }
        
        // Add frequent transformations
        $suggestions = array_unique(array_merge($suggestions, array_slice($this->frequentTransformations, 0, 2)));
        
        $this->suggestions = array_slice($suggestions, 0, 5);
    }
    
    public function openCommandPalette()
    {
        $this->commandPaletteOpen = true;
        $this->selectedIndex = 0;
        $this->searchQuery = '';
    }
    
    public function closeCommandPalette()
    {
        $this->commandPaletteOpen = false;
        $this->searchQuery = '';
        $this->previewText = '';
    }
    
    public function executeTransformation($transformation)
    {
        if (empty($this->text)) {
            return;
        }
        
        // Save current state to history
        $this->addToHistory($this->text);
        $this->originalText = $this->text;
        
        // Animate transformation
        $this->isTransforming = true;
        
        try {
            // Apply preservation
            $preserved = $this->preservationService->preserve($this->text, $this->preservationSettings);
            
            // Apply transformation
            if (strpos($transformation, '_title') !== false || strpos($transformation, '_style') !== false) {
                $transformed = $this->styleGuideService->applyStyleGuide($preserved['text'], $transformation);
            } else {
                $transformed = $this->transformationService->transform($preserved['text'], $transformation);
            }
            
            // Restore preserved content
            $result = $this->preservationService->restore($transformed, $preserved['preserved']);
            
            $this->text = $result;
            
            // Update frequent transformations
            $this->updateFrequentTransformations($transformation);
            
            // Add to recent
            $this->addToRecent($transformation);
            
        } catch (\Exception $e) {
            Log::error('Transformation failed', ['error' => $e->getMessage()]);
            $this->text = $this->originalText;
        }
        
        $this->isTransforming = false;
        $this->closeCommandPalette();
        $this->showQuickActions = false;
    }
    
    public function previewTransformation($transformation)
    {
        if (empty($this->text) || empty($transformation)) {
            $this->previewText = '';
            return;
        }
        
        try {
            $preserved = $this->preservationService->preserve($this->text, $this->preservationSettings);
            
            if (strpos($transformation, '_title') !== false || strpos($transformation, '_style') !== false) {
                $transformed = $this->styleGuideService->applyStyleGuide($preserved['text'], $transformation);
            } else {
                $transformed = $this->transformationService->transform($preserved['text'], $transformation);
            }
            
            $result = $this->preservationService->restore($transformed, $preserved['preserved']);
            
            // Limit preview length
            $this->previewText = strlen($result) > 100 ? substr($result, 0, 100) . '...' : $result;
            
        } catch (\Exception $e) {
            $this->previewText = '';
        }
    }
    
    public function applyQuickAction($index)
    {
        if (isset($this->suggestions[$index])) {
            $this->executeTransformation($this->suggestions[$index]);
        }
    }
    
    public function undo()
    {
        if ($this->historyIndex > 0) {
            $this->historyIndex--;
            $this->text = $this->history[$this->historyIndex];
        }
    }
    
    public function redo()
    {
        if ($this->historyIndex < count($this->history) - 1) {
            $this->historyIndex++;
            $this->text = $this->history[$this->historyIndex];
        }
    }
    
    public function copyToClipboard()
    {
        $this->dispatch('copy-to-clipboard', ['text' => $this->text]);
    }
    
    public function clearText()
    {
        $this->text = '';
        $this->originalText = '';
        $this->suggestions = [];
        $this->showQuickActions = false;
        $this->initializeHistory();
    }
    
    private function addToHistory($text)
    {
        // Remove any history after current index
        if ($this->historyIndex < count($this->history) - 1) {
            $this->history = array_slice($this->history, 0, $this->historyIndex + 1);
        }
        
        // Add new state
        $this->history[] = $text;
        $this->historyIndex = count($this->history) - 1;
        
        // Limit history size
        if (count($this->history) > 50) {
            array_shift($this->history);
            $this->historyIndex--;
        }
    }
    
    private function initializeHistory()
    {
        $this->history = [''];
        $this->historyIndex = 0;
    }
    
    private function addToRecent($transformation)
    {
        $this->recentTransformations = array_unique(array_merge(
            [$transformation],
            array_diff($this->recentTransformations, [$transformation])
        ));
        
        $this->recentTransformations = array_slice($this->recentTransformations, 0, 10);
        
        session(['recent_transformations' => $this->recentTransformations]);
    }
    
    private function updateFrequentTransformations($transformation)
    {
        $freq = session('transformation_frequency', []);
        $freq[$transformation] = ($freq[$transformation] ?? 0) + 1;
        
        arsort($freq);
        
        session(['transformation_frequency' => $freq]);
        
        $this->frequentTransformations = array_keys(array_slice($freq, 0, 5, true));
    }
    
    private function loadUserPreferences()
    {
        $this->recentTransformations = session('recent_transformations', []);
        $freq = session('transformation_frequency', []);
        arsort($freq);
        $this->frequentTransformations = array_keys(array_slice($freq, 0, 5, true));
        
        $this->preservationSettings = session('preservation_settings', $this->preservationSettings);
    }
    
    private function filterTransformations($query)
    {
        if (empty($query)) {
            return;
        }
        
        // Filter transformations based on search query
        // This will be used in the view to show filtered results
    }
    
    public function navigateUp()
    {
        if ($this->selectedIndex > 0) {
            $this->selectedIndex--;
        }
    }
    
    public function navigateDown()
    {
        // Calculate max index based on visible transformations
        $maxIndex = 20; // Will be calculated based on filtered results
        if ($this->selectedIndex < $maxIndex) {
            $this->selectedIndex++;
        }
    }
    
    public function selectCurrent()
    {
        // Execute the currently selected transformation
        // Based on selectedIndex and current filter
    }
    
    public function getTransformationLabel($key)
    {
        foreach ($this->allTransformations as $category => $transformations) {
            if (isset($transformations[$key])) {
                return $transformations[$key];
            }
        }
        return ucwords(str_replace(['_', '-'], ' ', $key));
    }
    
    public function getTransformationStyle($key)
    {
        $styles = [
            'uppercase' => 'text-transform: uppercase;',
            'lowercase' => 'text-transform: lowercase;',
            'title_case' => 'text-transform: capitalize;',
            'capitalize_words' => 'text-transform: capitalize;',
            'camelCase' => 'font-family: monospace;',
            'PascalCase' => 'font-family: monospace;',
            'snake_case' => 'font-family: monospace; text-transform: lowercase;',
            'CONSTANT_CASE' => 'font-family: monospace; text-transform: uppercase;',
            'kebab-case' => 'font-family: monospace; text-transform: lowercase;',
            'reverse' => 'unicode-bidi: bidi-override; direction: rtl;',
            'aesthetic' => 'letter-spacing: 0.3em;',
            'sarcasm' => 'font-style: italic;',
            'smallcaps' => 'font-variant: small-caps;',
            'bold' => 'font-weight: bold;',
            'italic' => 'font-style: italic;'
        ];
        
        return $styles[$key] ?? '';
    }
    
    public function render()
    {
        return view('livewire.modern-case-changer', [
            'transformations' => $this->allTransformations,
            'canUndo' => $this->historyIndex > 0,
            'canRedo' => $this->historyIndex < count($this->history) - 1,
            'quickTransformations' => $this->quickTransformations
        ]);
    }
}
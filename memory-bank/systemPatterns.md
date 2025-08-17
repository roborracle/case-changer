# Case Changer - System Patterns & Architecture

## High-Level Architecture

### System Overview
```
┌─────────────────────────────────────────────────┐
│                   Browser                        │
├─────────────────────────────────────────────────┤
│          Alpine.js (Client Interactions)         │
├─────────────────────────────────────────────────┤
│         Livewire (Reactive Components)           │
├─────────────────────────────────────────────────┤
│            Laravel (Application Core)            │
├─────────────────────────────────────────────────┤
│     Text Processing Engine (Service Layer)       │
└─────────────────────────────────────────────────┘
```

### Component Architecture

#### Core Components Hierarchy
```
App\Livewire\
├── CaseChanger.php              # Main container component
├── Components\
│   ├── TextInput.php            # Input text area component
│   ├── TextOutput.php           # Output display component
│   ├── TransformationButtons.php # Transformation selector
│   └── UtilityBar.php           # Copy, clear, count tools
└── Traits\
    ├── CaseTransformations.php  # Basic case logic
    ├── StyleGuideFormatters.php # Style guide implementations
    └── TextManipulators.php     # Advanced text features
```

## Design Patterns

### 1. Strategy Pattern for Transformations
Each transformation type implements a common interface:

```php
interface TextTransformer {
    public function transform(string $text): string;
    public function getName(): string;
    public function getDescription(): string;
}
```

### 2. Chain of Responsibility for Complex Formatting
Style guides use chained processors:

```php
abstract class FormattingRule {
    protected ?FormattingRule $next = null;
    
    public function setNext(FormattingRule $next): void {
        $this->next = $next;
    }
    
    abstract public function process(string $text): string;
}
```

### 3. Factory Pattern for Style Guide Creation
```php
class StyleGuideFactory {
    public static function create(string $type): StyleGuide {
        return match($type) {
            'apa' => new ApaStyleGuide(),
            'chicago' => new ChicagoStyleGuide(),
            'mla' => new MlaStyleGuide(),
            // ...
        };
    }
}
```

### 4. Singleton for Configuration Manager
```php
class TransformationConfig {
    private static ?self $instance = null;
    private array $settings = [];
    
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
```

## Component Specifications

### CaseChanger Component (Main)
**Responsibility**: Orchestrate all text transformations and manage state

**Properties**:
- `public string $inputText = ''`
- `public string $outputText = ''`
- `public string $selectedTransformation = 'title-case'`
- `public array $transformationHistory = []`
- `public array $settings = []`

**Methods**:
- `transform(): void` - Apply selected transformation
- `copy(): void` - Copy output to clipboard
- `clear(): void` - Reset all fields
- `undo(): void` - Revert to previous state

### TextProcessor Service
**Responsibility**: Core text processing logic

**Structure**:
```php
namespace App\Services;

class TextProcessor {
    private array $transformers = [];
    
    public function registerTransformer(string $key, TextTransformer $transformer): void
    public function transform(string $text, string $type): string
    public function detectCurrentCase(string $text): string
    public function preserveFormatting(string $text, callable $processor): string
}
```

## Data Flow

### Transformation Flow
1. User enters text in input field
2. Livewire component captures input via wire:model
3. User selects transformation type
4. Component calls TextProcessor service
5. Service applies transformation strategy
6. Result returned to component
7. Component updates output field
8. Alpine.js handles UI updates

### State Management
```javascript
// Alpine.js component for client-side state
Alpine.data('caseChanger', () => ({
    copied: false,
    charCount: 0,
    wordCount: 0,
    
    updateCounts() {
        this.charCount = this.$refs.input.value.length;
        this.wordCount = this.$refs.input.value.split(/\s+/).filter(Boolean).length;
    },
    
    copyToClipboard() {
        navigator.clipboard.writeText(this.$refs.output.value);
        this.copied = true;
        setTimeout(() => this.copied = false, 2000);
    }
}));
```

## Style Guide Implementation Patterns

### APA Style Pattern
```php
class ApaFormatter implements StyleGuide {
    private array $minorWords = ['a', 'an', 'the', 'and', 'but', 'or', 'nor', 'for', 'yet', 'so'];
    private array $exceptions = ['iPhone', 'iOS', 'COVID-19'];
    
    public function format(string $text): string {
        // 1. Split into words
        // 2. Apply major word capitalization
        // 3. Lowercase minor words (except first/last)
        // 4. Preserve exceptions
        // 5. Handle hyphenated words
        // 6. Process colons and subtitles
    }
}
```

### Preposition Handler Pattern
```php
class PrepositionHandler {
    private array $prepositions = [
        'at', 'by', 'for', 'in', 'of', 'on', 'to', 'up', 'as', 'but', 'off', 'out', 'via'
    ];
    
    public function process(string $text, int $maxLength = 4): string {
        // Lowercase prepositions under specified length
        // Preserve if first or last word
        // Handle special cases
    }
}
```

## Performance Optimizations

### Caching Strategy
```php
class TransformationCache {
    private array $cache = [];
    private int $maxSize = 100;
    
    public function get(string $key): ?string {
        return $this->cache[$key] ?? null;
    }
    
    public function set(string $key, string $value): void {
        if (count($this->cache) >= $this->maxSize) {
            array_shift($this->cache);
        }
        $this->cache[$key] = $value;
    }
    
    private function generateKey(string $text, string $type): string {
        return md5($text . '::' . $type);
    }
}
```

### Lazy Loading Transformers
```php
class TransformerRegistry {
    private array $transformers = [];
    private array $definitions = [
        'title-case' => TitleCaseTransformer::class,
        'sentence-case' => SentenceCaseTransformer::class,
        // ...
    ];
    
    public function get(string $type): TextTransformer {
        if (!isset($this->transformers[$type])) {
            $class = $this->definitions[$type];
            $this->transformers[$type] = new $class();
        }
        return $this->transformers[$type];
    }
}
```

## Error Handling Patterns

### Graceful Degradation
```php
trait ErrorHandling {
    protected function safeTransform(string $text, callable $transformer): string {
        try {
            return $transformer($text);
        } catch (\Exception $e) {
            Log::error('Transformation failed', [
                'text_length' => strlen($text),
                'error' => $e->getMessage()
            ]);
            return $text; // Return original on error
        }
    }
}
```

### Input Validation
```php
trait InputValidation {
    protected function validateInput(string $text): bool {
        if (strlen($text) > 50000) {
            throw new \InvalidArgumentException('Text exceeds maximum length');
        }
        
        if (!mb_check_encoding($text, 'UTF-8')) {
            throw new \InvalidArgumentException('Invalid character encoding');
        }
        
        return true;
    }
}
```

## Testing Strategy

### Unit Test Structure
```php
namespace Tests\Unit\Services;

class TextProcessorTest extends TestCase {
    public function test_title_case_transformation()
    public function test_apa_style_formatting()
    public function test_preposition_handling()
    public function test_quote_conversion()
    public function test_edge_cases()
}
```

### Feature Test Structure
```php
namespace Tests\Feature\Livewire;

class CaseChangerTest extends TestCase {
    public function test_component_renders()
    public function test_text_transformation()
    public function test_copy_functionality()
    public function test_clear_functionality()
    public function test_keyboard_shortcuts()
}
```

## Security Considerations

### XSS Prevention
- All output escaped by default via Blade
- No HTML input accepted
- Content Security Policy headers

### Input Sanitization
```php
trait Sanitization {
    protected function sanitize(string $text): string {
        // Remove zero-width characters
        $text = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
        
        // Normalize line endings
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        
        // Trim excessive whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        
        return $text;
    }
}
```

## Deployment Architecture

### Production Environment
```
├── Load Balancer (Nginx)
├── Application Servers (Laravel)
│   ├── Instance 1
│   ├── Instance 2
│   └── Instance N
├── Cache Layer (Redis)
└── Monitoring (New Relic/Datadog)
```

### Environment Configuration
- Development: Local SQLite, debug enabled
- Staging: MySQL, debug disabled, testing mode
- Production: MySQL, optimized, monitoring enabled

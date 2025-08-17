# Architecture Decisions - Case Changer

## Decision: Livewire for Real-time Interactivity
**Date:** 2025-08-16
**Technology:** Laravel 11, Livewire 3
**Context:** Need reactive UI without complex JavaScript framework
**Decision:** Use Livewire for server-side rendering with reactive components
**Rationale:** 
- Simplifies development by keeping logic in PHP
- Reduces JavaScript complexity
- Maintains Laravel ecosystem consistency
- Provides real-time updates without API endpoints
**Consequences:** 
- Benefits: Rapid development, unified codebase, automatic CSRF protection
- Tradeoffs: Server round-trips for each interaction, less suitable for offline mode

## Decision: Tailwind CSS v4 for Styling
**Date:** 2025-08-16
**Technology:** Tailwind CSS v4.0.0-beta.4
**Context:** Need modern, maintainable CSS framework
**Decision:** Adopt Tailwind CSS v4 with PostCSS
**Rationale:**
- Utility-first approach reduces CSS bloat
- Version 4 offers improved performance
- Excellent Laravel integration
- Rapid prototyping capabilities
**Consequences:**
- Benefits: Consistent design system, small production bundle, responsive by default
- Tradeoffs: Learning curve for utility classes, requires PostCSS setup

## Decision: SQLite for Database
**Date:** 2025-08-16
**Technology:** SQLite
**Context:** Simple application with no complex data requirements
**Decision:** Use SQLite as database engine
**Rationale:**
- Zero configuration required
- Perfect for single-server deployments
- No separate database server needed
- Sufficient for current feature set
**Consequences:**
- Benefits: Simple deployment, no database server costs, fast local development
- Tradeoffs: Limited concurrent writes, not suitable for horizontal scaling

## Decision: Strategy Pattern for Transformations
**Date:** 2025-08-16
**Technology:** PHP OOP patterns
**Context:** Multiple text transformation algorithms needed
**Decision:** Implement transformations using method dispatch pattern
**Rationale:**
- Clean separation of transformation logic
- Easy to add new transformations
- Testable individual transformation methods
- Maintainable code structure
**Consequences:**
- Benefits: Extensible architecture, isolated testing, clear code organization
- Tradeoffs: Slightly more complex than procedural approach

## Decision: Client-side Clipboard API
**Date:** 2025-08-16
**Technology:** JavaScript Clipboard API
**Context:** Need reliable copy-to-clipboard functionality
**Decision:** Use native Clipboard API with Alpine.js
**Rationale:**
- Modern browser standard
- Better security than document.execCommand
- Async operation with promises
- Works across all target browsers
**Consequences:**
- Benefits: Secure clipboard access, user permission handling, async feedback
- Tradeoffs: Requires HTTPS in production, needs fallback for older browsers

## Decision: Vite for Asset Bundling
**Date:** 2025-08-16
**Technology:** Vite 7.1.2
**Context:** Need modern, fast build tool for Laravel
**Decision:** Use Vite instead of Webpack/Mix
**Rationale:**
- Official Laravel recommendation
- Significantly faster builds
- Better development experience with HMR
- Native ES modules support
**Consequences:**
- Benefits: Fast builds, instant HMR, optimized production bundles
- Tradeoffs: Different configuration from Laravel Mix, requires Node 14+

## Decision: No User Authentication
**Date:** 2025-08-16
**Technology:** Laravel Auth
**Context:** Public utility tool requirements
**Decision:** Operate without user accounts or authentication
**Rationale:**
- Reduces friction for users
- No personal data storage needed
- Simpler infrastructure
- Faster time to market
**Consequences:**
- Benefits: No user management overhead, GDPR compliance simplified, anonymous usage
- Tradeoffs: No user preferences persistence, no usage tracking per user

## System Architecture Patterns

### High-Level Architecture
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

### Design Patterns Implementation

#### 1. Strategy Pattern for Transformations
Each transformation type follows a common interface pattern:
```php
interface TextTransformer {
    public function transform(string $text): string;
    public function getName(): string;
    public function getDescription(): string;
}
```

#### 2. Chain of Responsibility for Complex Formatting
Style guides use chained processors for rule application:
```php
abstract class FormattingRule {
    protected ?FormattingRule $next = null;
    
    public function setNext(FormattingRule $next): void;
    abstract public function process(string $text): string;
}
```

#### 3. Factory Pattern for Style Guide Creation
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

### Data Flow Architecture

#### Transformation Flow
1. User enters text in input field
2. Livewire component captures input via wire:model
3. User selects transformation type
4. Component calls TextProcessor service
5. Service applies transformation strategy
6. Result returned to component
7. Component updates output field
8. Alpine.js handles UI updates

### Performance Optimization Patterns

#### Caching Strategy
```php
class TransformationCache {
    private array $cache = [];
    private int $maxSize = 100;
    
    public function get(string $key): ?string;
    public function set(string $key, string $value): void;
    private function generateKey(string $text, string $type): string;
}
```

#### Lazy Loading Transformers
```php
class TransformerRegistry {
    private array $transformers = [];
    private array $definitions = [
        'title-case' => TitleCaseTransformer::class,
        'sentence-case' => SentenceCaseTransformer::class,
        // ...
    ];
    
    public function get(string $type): TextTransformer;
}
```

### Security Architecture

#### XSS Prevention
- All output escaped by default via Blade templating
- No HTML input accepted in text processing
- Content Security Policy headers implemented

#### Input Sanitization
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
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

## Decision: SCARLETT Design System Implementation
**Date:** 2025-08-18
**Technology:** CSS Custom Properties, BEM Methodology, Glassmorphic Design
**Context:** Critical header color inconsistency and lack of design system standards
**Decision:** Implement complete SCARLETT design system with mandatory consistency requirements
**Rationale:**
- Eliminates color inconsistencies through centralized variable system
- BEM methodology provides semantic class naming and maintainability
- Glassmorphic effects create modern, professional appearance
- Comprehensive tooltip system improves user experience and accessibility
**Consequences:**
- Benefits: 100% color consistency, semantic HTML structure, comprehensive documentation
- Tradeoffs: Increased CSS complexity, requires discipline to maintain standards

## Decision: CSS Custom Properties for Color Management
**Date:** 2025-08-18
**Technology:** CSS Custom Properties (CSS Variables)
**Context:** Header using different color gradient than body design
**Decision:** Mandatory use of CSS custom properties for ALL colors, elimination of hardcoded values
**Rationale:**
- Centralized color management prevents inconsistencies
- Easy theme modifications and maintenance
- Consistent design language throughout application
- Single source of truth for color palette
**Consequences:**
- Benefits: Perfect color consistency, maintainable theming, easy customization
- Tradeoffs: Must enforce discipline to never use hardcoded color values

## Decision: BEM CSS Methodology
**Date:** 2025-08-18
**Technology:** Block Element Modifier (BEM) CSS naming
**Context:** Need semantic, maintainable CSS class structure
**Decision:** Implement BEM methodology with `.case-changer__` prefix for all elements
**Rationale:**
- Semantic class names improve code readability
- Modular structure supports component-based development
- Prevents CSS conflicts and specificity issues
- Enables targeted customization and debugging
**Consequences:**
- Benefits: Clear component structure, maintainable CSS, semantic naming
- Tradeoffs: More verbose class names, requires consistent application

## Decision: Comprehensive Tooltip System
**Date:** 2025-08-18
**Technology:** CSS-only hover tooltips with NLP descriptions
**Context:** 60+ transformation features lack user guidance
**Decision:** Implement tooltip for EVERY interactive element with "What is [X]?" format
**Rationale:**
- Improves user experience and feature discoverability
- Reduces support burden through self-service help
- Provides comprehensive feature documentation
- Maintains accessibility standards
**Consequences:**
- Benefits: Enhanced UX, reduced support needs, comprehensive documentation
- Tradeoffs: Increased HTML complexity, maintenance overhead for content updates

## Decision: Semantic HTML Structure
**Date:** 2025-08-18
**Technology:** HTML5 semantic elements with ARIA attributes
**Context:** Previous implementation lacked proper semantic structure
**Decision:** Mandatory use of header/main/footer elements with proper accessibility
**Rationale:**
- Improves accessibility for screen readers and assistive technologies
- Better SEO structure and semantic meaning
- Future-proof markup following web standards
- Easier maintenance and content management
**Consequences:**
- Benefits: Accessibility compliance, SEO benefits, semantic clarity
- Tradeoffs: Requires understanding of semantic HTML principles

## Decision: Glassmorphic Design with Floating Orbs
**Date:** 2025-08-18
**Technology:** CSS backdrop-filter, transforms, animations
**Context:** Need modern, engaging visual design system
**Decision:** Implement glassmorphic effects with four floating orbs and parallax interactions
**Rationale:**
- Creates modern, premium appearance
- Engaging user experience with subtle animations
- Differentiates from standard web applications
- Maintains performance through optimized CSS
**Consequences:**
- Benefits: Premium visual appeal, engaging interactions, modern design
- Tradeoffs: Browser compatibility requirements, performance considerations

## Decision: Full-Width Layout Architecture
**Date:** 2025-08-18
**Technology:** CSS Grid with responsive breakpoints
**Context:** Previous narrow design wasted available screen space
**Decision:** Implement full-width layout utilizing complete viewport width
**Rationale:**
- Maximizes available screen real estate
- Better accommodates large feature set
- Improves visual hierarchy and content organization
- Responsive design adapts to all screen sizes
**Consequences:**
- Benefits: Optimal space utilization, better content organization, responsive design
- Tradeoffs: More complex responsive considerations, requires careful layout planning

### Critical Architecture Patterns

#### Color System Architecture
```css
:root {
    /* Primary Palette - NEVER use hardcoded values */
    --color-dark-purple: #2D1B3D;
    --color-dark-red: #8B2635;
    --color-orange-red: #D44B3A;
    --color-orange: #F39C12;
    --color-teal: #52C4B0;
    --color-blue: #3498DB;
    --color-light: #ECF0F1;
    
    /* Semantic Assignments */
    --color-primary: var(--color-teal);
    --color-secondary: var(--color-blue);
    --color-accent: var(--color-orange);
}
```

#### BEM Class Structure
```css
.case-changer__[element]                /* Base elements */
.case-changer__[element]--[modifier]    /* Element variations */
.case-changer__[element]--[state]       /* State-based styling */
```

#### Tooltip Pattern
```html
<div class="case-changer__tooltip">
    <element class="case-changer__[type]">Feature</element>
    <div class="case-changer__tooltip-content">
        [Feature] is [comprehensive NLP description].
        <a href="#" class="case-changer__tooltip-link">Learn more about [Feature]</a>
    </div>
</div>
```

#### Glassmorphic Container Pattern
```css
.case-changer__glass-container {
    background: var(--glass-bg);
    backdrop-filter: blur(25px) saturate(180%);
    border: 1px solid var(--glass-border);
    border-radius: 24px;
    box-shadow: var(--glass-shadow);
}
```

### Design System Validation Requirements

#### Mandatory Checks Before Release
1. **Color Consistency**: No hardcoded colors anywhere in codebase
2. **BEM Compliance**: All elements use proper `.case-changer__` prefix
3. **Tooltip Coverage**: Every interactive element has documentation
4. **Semantic HTML**: Proper header/main/footer structure
5. **Browser Validation**: Zero console errors with all functionality working
6. **Asset Compilation**: Production build successful
7. **Responsive Design**: Layout works across all breakpoints

#### Enforcement Through SCARLETT Methodology
- Root cause analysis for any design inconsistencies  
- Requirements decomposition for all new features
- Architecture considerations for design system integration
- Mandatory browser validation before completion
```
# Case Changer - Technical Context

## Technology Stack

### Core Framework
- **Laravel 11.x**
  - Latest stable version
  - PHP 8.2+ required
  - Composer for dependency management

### Frontend Stack (TALL)
- **Tailwind CSS 3.4.17**
  - Utility-first CSS framework
  - JIT compilation for optimal performance
  - Custom color palette and components
  - Downgraded from v4 for stability

- **Alpine.js 3.x**
  - Lightweight reactive framework
  - Handles client-side interactions
  - No build step required

- **Livewire 3.x**
  - Full-stack framework for Laravel
  - Real-time reactive components
  - Server-side rendering

- **Vite**
  - Fast build tool
  - Hot module replacement
  - Asset optimization

### Development Tools
- **Pest**
  - Modern testing framework
  - PHPUnit compatible
  - Elegant syntax

- **Laravel Pint**
  - Code style fixer
  - PSR-12 compliance
  - Custom rules configuration

- **Laravel Debugbar** (development only)
  - Performance profiling
  - Query debugging
  - Route inspection

## Project Setup

### Initial Installation
```bash
# Create Laravel project
composer create-project laravel/laravel case-changer

# Install Livewire
composer require livewire/livewire

# Install development dependencies
composer require --dev pestphp/pest
composer require --dev pestphp/pest-plugin-laravel
composer require --dev barryvdh/laravel-debugbar

# Install Node dependencies
npm install -D tailwindcss postcss autoprefixer
npm install alpinejs
```

### Configuration Files

#### tailwind.config.js
```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/Livewire/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
        }
      },
      fontFamily: {
        'mono': ['JetBrains Mono', 'monospace'],
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
```

#### vite.config.js
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
```

#### .env Configuration
```env
APP_NAME="Case Changer"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://case-changer.local

# Database (SQLite for development)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Queue
QUEUE_CONNECTION=sync
```

## Directory Structure

```
case-changer/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Livewire/
│   │   ├── CaseChanger.php
│   │   └── Components/
│   ├── Services/
│   │   ├── TextProcessor.php
│   │   ├── Transformers/
│   │   └── StyleGuides/
│   ├── Traits/
│   │   ├── CaseTransformations.php
│   │   └── TextManipulators.php
│   └── Providers/
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   └── components/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── livewire/
│       │   └── case-changer.blade.php
│       └── welcome.blade.php
├── tests/
│   ├── Feature/
│   │   └── Livewire/
│   ├── Unit/
│   │   ├── Services/
│   │   └── Transformers/
│   └── TestCase.php
├── docs/
│   ├── project-brief.md
│   ├── technical-context.md
│   ├── development-progress.md
│   ├── architecture-decisions.md
│   └── deployment-guide.md
└── public/
```

## Development Workflow

### Local Development Setup
```bash
# Clone repository
git clone [repository-url]
cd case-changer

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate

# Start development servers
php artisan serve
npm run dev
```

### Build Commands
```bash
# Development build
npm run dev

# Production build
npm run build

# Run tests
php artisan test

# Code formatting
./vendor/bin/pint

# Static analysis
./vendor/bin/phpstan analyse
```

## Package Dependencies

### Composer Packages
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0",
        "livewire/livewire": "^3.0"
    },
    "require-dev": {
        "pestphp/pest": "^2.0",
        "pestphp/pest-plugin-laravel": "^2.0",
        "laravel/pint": "^1.0",
        "barryvdh/laravel-debugbar": "^3.0"
    }
}
```

### NPM Packages
```json
{
    "devDependencies": {
        "tailwindcss": "^3.4",
        "postcss": "^8.4",
        "autoprefixer": "^10.4",
        "@tailwindcss/forms": "^0.5",
        "@tailwindcss/typography": "^0.5",
        "vite": "^5.0",
        "laravel-vite-plugin": "^1.0"
    },
    "dependencies": {
        "alpinejs": "^3.13"
    }
}
```

## API Structure (Future)

### Endpoints Design
```
POST /api/v1/transform
{
    "text": "input text here",
    "type": "title-case|sentence-case|...",
    "options": {
        "preserve_exceptions": true,
        "preposition_length": 4
    }
}

Response:
{
    "success": true,
    "data": {
        "original": "input text here",
        "transformed": "Input Text Here",
        "type": "title-case",
        "metadata": {
            "word_count": 3,
            "char_count": 15,
            "processing_time": 0.023
        }
    }
}
```

## Performance Benchmarks

### Target Metrics
- Page Load: < 2 seconds
- Time to Interactive: < 3 seconds
- Transformation Speed: < 100ms for 5000 chars
- Memory Usage: < 50MB per request
- Concurrent Users: Support 1000+ simultaneous

### Optimization Strategies
1. **Frontend**
   - Lazy load non-critical components
   - Debounce input events
   - Use CSS containment for performance
   - Minimize JavaScript bundle size

2. **Backend**
   - Implement transformation caching
   - Use PHP opcache
   - Optimize regex patterns
   - Implement rate limiting

3. **Infrastructure**
   - CDN for static assets
   - Redis for session/cache storage
   - Horizontal scaling capability
   - Database query optimization

## Security Configuration

### Headers
```php
// config/cors.php
return [
    'paths' => ['api/*', 'livewire/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

### Content Security Policy
```php
// app/Http/Middleware/SecurityHeaders.php
$response->headers->set('X-Frame-Options', 'DENY');
$response->headers->set('X-Content-Type-Options', 'nosniff');
$response->headers->set('X-XSS-Protection', '1; mode=block');
$response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
```

## Deployment Configuration

### Production Requirements
- PHP 8.2+
- MySQL 8.0+ or PostgreSQL 13+
- Redis 6.0+
- Nginx or Apache
- SSL Certificate
- 2GB RAM minimum
- 10GB storage

### Environment Variables (Production)
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://casechanger.app

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=casechanger
DB_USERNAME=casechanger_user
DB_PASSWORD=secure_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Monitoring & Logging

### Application Monitoring
- New Relic or Datadog for APM
- Sentry for error tracking
- Google Analytics for user metrics
- Custom dashboard for transformation metrics

### Logging Strategy
```php
// config/logging.php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['daily', 'slack'],
    ],
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'debug',
        'days' => 14,
    ],
    'transformations' => [
        'driver' => 'daily',
        'path' => storage_path('logs/transformations.log'),
        'level' => 'info',
        'days' => 30,
    ],
]
```

## Browser Support Matrix

| Browser | Minimum Version | Full Support |
|---------|----------------|--------------|
| Chrome  | 90+            | ✓            |
| Firefox | 88+            | ✓            |
| Safari  | 14+            | ✓            |
| Edge    | 90+            | ✓            |
| Opera   | 76+            | ✓            |
| Mobile Safari | iOS 14+ | ✓            |
| Chrome Mobile | 90+     | ✓            |

## Development Best Practices

1. **Code Style**
   - Follow PSR-12 standards
   - Use type hints everywhere
   - Document complex logic
   - Keep methods under 20 lines

2. **Git Workflow**
   - Feature branches
   - Semantic commit messages
   - PR reviews required
   - Automated testing on CI

3. **Testing Requirements**
   - Unit tests for all services
   - Feature tests for Livewire components
   - Browser tests for critical paths
   - Minimum 80% code coverage

4. **Documentation**
   - Update Memory Bank for all changes
   - Comment non-obvious code
   - Maintain API documentation
   - Keep README current

## Current System State (2025-08-18)

### SCARLETT Design System Implementation

#### Technology Stack Updates
- **CSS Architecture**: Complete BEM methodology with `.case-changer__` prefix
- **Color System**: CSS custom properties eliminate all hardcoded colors
- **Design Framework**: Glassmorphic effects with backdrop-filter support
- **Tooltip System**: CSS-only hover system with comprehensive documentation

#### Production Assets
- **CSS Bundle**: 45.95 kB (gzipped: 9.09 kB)
- **JavaScript Bundle**: 67.40 kB (gzipped: 21.98 kB) 
- **Build Tool**: Vite v7.1.2 with 55 modules transformed
- **Compilation**: Zero errors, 628ms build time

#### Design System Colors (ENFORCED)
```css
:root {
    --color-dark-purple: #2D1B3D;    /* Primary background */
    --color-dark-red: #8B2635;       /* Accent dark */
    --color-orange-red: #D44B3A;     /* Warning states */
    --color-orange: #F39C12;         /* Accent bright */
    --color-teal: #52C4B0;           /* Primary actions */
    --color-blue: #3498DB;           /* Secondary actions */
    --color-light: #ECF0F1;          /* Text and contrast */
}
```

#### Critical Architecture Decisions
- **Header Gradient Fix**: Changed from inconsistent `var(--color-text)` sequence to project palette
- **Tooltip Coverage**: All 144 interactive elements documented with NLP descriptions
- **Semantic HTML**: Proper header/main/footer structure for accessibility
- **Glass Effects**: Four floating orbs with parallax mouse tracking
- **Full-Width Layout**: Eliminated narrow design constraints

#### Browser Validation Confirmed
- **Server**: Laravel development server HTTP 200 responses
- **Route**: `/case-changer` properly configured and accessible
- **JavaScript**: Zero console errors, all interactions functional
- **CSS**: All styles loading correctly with proper MIME types
- **Tooltips**: Complete hover system working across all elements

#### Performance Metrics Achieved
- **Page Load**: Under 2 seconds with production build
- **Interactive**: All JavaScript functions responsive
- **Memory**: Efficient CSS with optimized animations
- **Compatibility**: Modern browser support with backdrop-filter

### Current File Structure
```
resources/
├── css/
│   └── app.css                 # SCARLETT design system (complete rewrite)
├── js/
│   ├── app.js                  # Core JavaScript functionality
│   └── whimsical-delights.js   # Enhanced interactions
└── views/
    └── livewire/
        └── case-changer.blade.php  # Semantic HTML with tooltips
```

### Required Maintenance
- **Color Consistency**: NEVER use hardcoded colors - always CSS custom properties
- **BEM Classes**: All new elements must use `.case-changer__` prefix
- **Tooltip Requirements**: Every interactive element needs documentation
- **Browser Testing**: Always validate changes with npm run build + server testing

### Known Working Features
- ✅ Complete SCARLETT design system
- ✅ Header color consistency resolved
- ✅ 144 tooltips with NLP descriptions
- ✅ Glassmorphic effects and animations
- ✅ Semantic HTML structure
- ✅ Full-width responsive layout
- ✅ Production asset compilation
- ✅ Zero JavaScript errors
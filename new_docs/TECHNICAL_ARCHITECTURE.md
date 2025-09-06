# Technical Architecture Document

## System Architecture Overview

### Architecture Pattern
**Monolithic Server-Side Rendered (SSR) Application**
- Single Laravel application
- Server-side rendering via Blade templates
- Livewire for reactive components (server-side)
- Stateless design (no database)
- RESTful API alongside web routes

### Core Architecture Principles

1. **Server-Side First**
   - All business logic on server
   - No client-side frameworks
   - Minimal JavaScript (CSP-compliant only)

2. **Stateless Operation**
   - No database required
   - No user sessions (except theme preference)
   - No data persistence
   - Ephemeral processing only

3. **Security by Design**
   - Strict Content Security Policy (CSP)
   - No eval() or inline handlers
   - Input sanitization at boundaries
   - HTTPS enforcement

4. **Performance Optimized**
   - Sub-21ms transformation times
   - Efficient algorithms
   - Minimal resource usage
   - CDN for static assets

## Technology Stack

### Backend Technologies

#### Core Framework
- **Laravel 11.x**
  - Modern PHP framework
  - Built-in security features
  - Excellent routing system
  - Middleware pipeline

#### PHP Configuration
- **Version:** 8.2+
- **Extensions Required:**
  - mbstring (Unicode support)
  - openssl (Security)
  - tokenizer (Laravel)
  - xml (Data processing)
  - ctype (Character validation)
  - json (API responses)

#### Livewire 3.x
- **Purpose:** Server-side reactivity
- **Usage:** Interactive components
- **Benefits:** No JavaScript framework needed
- **CSP:** Fully compliant

### Frontend Technologies

#### CSS Framework
- **Tailwind CSS 3.x**
  - Utility-first CSS
  - PurgeCSS for optimization
  - JIT compilation
  - Dark mode support

#### Build Tools
- **Vite**
  - Fast HMR in development
  - Optimized production builds
  - Asset versioning
  - Code splitting

#### Minimal JavaScript
- **Purpose:** Only essential interactions
- **Constraints:** CSP-compliant
- **No Libraries:** No jQuery, Vue, React, Alpine
- **Features:** Theme toggle, PWA support

### Infrastructure

#### Hosting (Production)
- **Platform:** Railway
- **Environment:** Container-based
- **Auto-scaling:** Horizontal scaling
- **SSL:** Automatic HTTPS

#### CDN
- **Provider:** Cloudflare
- **Purpose:** Static asset delivery
- **Benefits:** Global edge locations
- **Caching:** Aggressive for assets

## Application Structure

### Directory Structure
```
case-changer/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   └── TransformationApiController.php
│   │   │   ├── ConversionController.php
│   │   │   └── SitemapController.php
│   │   ├── Middleware/
│   │   │   ├── ForceHttps.php
│   │   │   ├── GenerateCspNonce.php
│   │   │   ├── SecurityHeaders.php
│   │   │   └── ApplyTheme.php
│   │   └── Requests/
│   │       └── TransformationRequest.php
│   ├── Livewire/
│   │   ├── Converter.php
│   │   ├── Navigation.php
│   │   └── ThemeToggle.php
│   ├── Services/
│   │   ├── TransformationService.php
│   │   ├── SchemaService.php
│   │   ├── PlaceholderService.php
│   │   └── ToolService.php
│   └── Providers/
│       └── CspServiceProvider.php
├── resources/
│   ├── views/
│   │   ├── components/
│   │   ├── livewire/
│   │   ├── conversions/
│   │   └── layouts/
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
├── config/
│   └── tools.php
├── public/
│   ├── build/
│   ├── images/
│   └── manifest.json
└── tests/
    ├── Feature/
    └── Unit/
```

### Layer Architecture

#### Presentation Layer
- **Views:** Blade templates
- **Components:** Reusable UI elements
- **Livewire:** Interactive components
- **API:** JSON responses

#### Application Layer
- **Controllers:** Request handling
- **Middleware:** Request pipeline
- **Validation:** Input sanitization
- **Routing:** URL mapping

#### Business Logic Layer
- **Services:** Core business logic
- **Transformations:** Text processing
- **Utilities:** Helper functions
- **Algorithms:** Conversion logic

#### Infrastructure Layer
- **Cache:** File-based caching
- **Logging:** Laravel logging
- **Configuration:** Environment-based
- **Security:** Headers, CSP, CORS

## Core Services

### TransformationService
**Purpose:** Central transformation engine
**Location:** `app/Services/TransformationService.php`

```php
class TransformationService
{
    public function transform(string $text, string $type): string
    {
        // Validate input
        // Apply transformation
        // Return result
    }
    
    private function upperCase(string $text): string
    private function lowerCase(string $text): string
    private function titleCase(string $text): string
    // ... 210+ transformation methods
}
```

**Key Features:**
- 210+ transformation methods
- Unicode support
- Style guide awareness
- Performance optimized

### SchemaService
**Purpose:** SEO and structured data
**Features:**
- JSON-LD generation
- Meta tag management
- Open Graph tags
- Schema.org markup

### PlaceholderService
**Purpose:** Dynamic placeholder text
**Features:**
- Context-aware examples
- Tool-specific placeholders
- Rotating examples
- Educational content

### ToolService
**Purpose:** Tool management and metadata
**Features:**
- Tool categorization
- Description management
- Related tool suggestions
- Usage statistics (anonymous)

## Security Architecture

### Content Security Policy (CSP)

#### Strict CSP Headers
```php
// NO unsafe-eval, NO unsafe-inline
"default-src 'self';
script-src 'self' 'nonce-{$nonce}';
style-src 'self' 'nonce-{$nonce}' https://fonts.bunny.net;
font-src 'self' https://fonts.bunny.net;
img-src 'self' data: https:;
connect-src 'self';
frame-ancestors 'self';
object-src 'none';
base-uri 'self';"
```

#### CSP Implementation
1. **Nonce Generation:** Per-request unique nonces
2. **Middleware Application:** Applied to all responses
3. **Template Integration:** Nonce injection in Blade
4. **Validation:** Automated testing for violations

### Input Validation

#### Validation Strategy
1. **Type Checking:** Strict type validation
2. **Length Limits:** 50,000 character maximum
3. **Encoding:** UTF-8 validation
4. **Sanitization:** XSS prevention
5. **Rate Limiting:** Request throttling

#### Implementation
```php
class TransformationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => 'required|string|max:50000',
            'transformation' => 'required|string|in:' . implode(',', $validTypes),
            'style_guide' => 'nullable|string|in:ap,apa,chicago,mla'
        ];
    }
}
```

### Authentication & Authorization
- **No User Auth:** Public access
- **API Keys:** Optional for API access
- **Rate Limiting:** IP-based throttling
- **CORS:** Configured for API access

## Performance Architecture

### Optimization Strategies

#### Server-Side
1. **Algorithm Efficiency:** O(n) transformations
2. **Memory Management:** Stream processing for large texts
3. **Caching:** Compiled views, route cache
4. **Opcache:** PHP bytecode caching

#### Client-Side
1. **Asset Optimization:** Minification, compression
2. **Lazy Loading:** Below-fold content
3. **Code Splitting:** Route-based chunks
4. **CDN Delivery:** Global edge caching

### Performance Metrics

#### Target Metrics
- **Transformation Time:** < 21ms
- **Page Load:** < 2s on 3G
- **First Contentful Paint:** < 1.5s
- **Time to Interactive:** < 3s
- **Lighthouse Score:** > 95

#### Monitoring
- **Laravel Telescope:** Development debugging
- **Laravel Pulse:** Production monitoring
- **Custom Metrics:** Transformation timing
- **Error Tracking:** Exception monitoring

## API Architecture

### RESTful API Design

#### Endpoints
```
POST /api/transform
GET  /api/tools
GET  /api/tools/{category}
GET  /api/tool/{slug}
```

#### Request/Response Format
```json
// Request
POST /api/transform
{
    "text": "Hello World",
    "transformation": "snake-case",
    "options": {
        "style_guide": "ap"
    }
}

// Response
{
    "success": true,
    "data": {
        "output": "hello_world",
        "transformation": "snake-case",
        "character_count": 11,
        "word_count": 2
    },
    "meta": {
        "processing_time": "18ms",
        "version": "1.0"
    }
}
```

### API Features
- **Versioning:** URL-based (v1, v2)
- **Rate Limiting:** 60 requests/minute
- **CORS Support:** Configurable origins
- **Documentation:** OpenAPI/Swagger
- **Error Handling:** Consistent format

## Deployment Architecture

### Environment Configuration

#### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://casechanger.pro

CACHE_DRIVER=file
SESSION_DRIVER=cookie
QUEUE_CONNECTION=sync

SECURITY_HEADERS_ENABLED=true
CSP_ENABLED=true
FORCE_HTTPS=true
```

### Deployment Pipeline

#### CI/CD Process
1. **Code Push:** GitHub repository
2. **Automated Tests:** PHPUnit suite
3. **Build Assets:** Vite production build
4. **Deploy:** Railway automatic deployment
5. **Cache Clear:** Automated cache refresh
6. **Health Check:** Endpoint verification

### Production Optimizations
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
npm run build
```

## Scalability Architecture

### Horizontal Scaling
- **Stateless Design:** Any instance can handle any request
- **No Session Affinity:** Round-robin load balancing
- **Shared Nothing:** No shared state between instances

### Vertical Scaling
- **Memory Optimization:** Efficient algorithms
- **CPU Optimization:** Minimal processing
- **I/O Optimization:** No database queries

### Caching Strategy

#### Cache Layers
1. **Browser Cache:** Static assets
2. **CDN Cache:** Global edge caching
3. **Application Cache:** Compiled views
4. **OpCode Cache:** PHP bytecode

#### Cache Configuration
```php
'cache' => [
    'default' => 'file',
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],
    ],
];
```

## Testing Architecture

### Testing Strategy

#### Unit Tests
- **Services:** Transformation logic
- **Utilities:** Helper functions
- **Algorithms:** Core conversions
- **Coverage Target:** > 80%

#### Feature Tests
- **Controllers:** Request/Response
- **API Endpoints:** Integration
- **Livewire Components:** Interactions
- **Middleware:** Security headers

#### Browser Tests
- **CSP Compliance:** Zero violations
- **User Workflows:** E2E scenarios
- **Responsive Design:** Multiple viewports
- **Accessibility:** WCAG compliance

### Test Implementation
```php
class TransformationTest extends TestCase
{
    public function test_uppercase_transformation()
    {
        $service = new TransformationService();
        $result = $service->transform('hello world', 'upper-case');
        $this->assertEquals('HELLO WORLD', $result);
    }
}
```

## Monitoring & Observability

### Application Monitoring
- **Laravel Pulse:** Real-time insights
- **Custom Metrics:** Transformation analytics
- **Error Tracking:** Exception monitoring
- **Performance Tracking:** Response times

### Infrastructure Monitoring
- **Uptime Monitoring:** Availability checks
- **Resource Usage:** CPU, Memory, Disk
- **Traffic Analytics:** Request patterns
- **Security Monitoring:** Threat detection

### Logging Strategy
```php
Log::channel('transformations')->info('Transformation completed', [
    'type' => $transformation,
    'input_length' => strlen($input),
    'output_length' => strlen($output),
    'processing_time' => $time
]);
```

## Disaster Recovery

### Backup Strategy
- **Code:** Git repository
- **Configuration:** Environment variables
- **Assets:** CDN cached
- **Data:** No user data to backup

### Recovery Plan
1. **Service Failure:** Auto-restart via Railway
2. **Region Failure:** CDN fallback
3. **Complete Failure:** Deploy to alternative provider
4. **Data Loss:** N/A (stateless)

## Future Architecture Considerations

### Potential Enhancements
1. **Microservices:** Separate transformation engine
2. **Serverless Functions:** Individual transformations
3. **WebAssembly:** Client-side processing option
4. **AI Integration:** Smart suggestions
5. **Batch Processing:** Bulk transformations

### Technology Upgrades
- **PHP 8.3+:** Performance improvements
- **Laravel 12:** Framework updates
- **HTTP/3:** Protocol upgrade
- **Edge Computing:** Distributed processing

## Conclusion

This architecture prioritizes simplicity, security, and performance. By maintaining a stateless, server-side design with strict CSP compliance, the application achieves enterprise-grade security while delivering exceptional performance. The monolithic architecture is appropriate for the current scale while remaining flexible enough to evolve as needs change.
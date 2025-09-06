# Security Implementation Guide

## The Prime Directive: Security First, Features Second

This guide ensures the new project doesn't repeat the catastrophic security failures of the Alpine.js disaster.

## Content Security Policy (CSP) Implementation

### The Mandatory CSP Headers

```nginx
# This is your MINIMUM acceptable CSP
Content-Security-Policy: 
    default-src 'self';
    script-src 'self' 'nonce-{random}';
    style-src 'self' 'nonce-{random}';
    img-src 'self' data: https:;
    font-src 'self' data:;
    connect-src 'self';
    media-src 'none';
    object-src 'none';
    frame-src 'none';
    frame-ancestors 'none';
    base-uri 'self';
    form-action 'self';
    upgrade-insecure-requests;
```

### What Each Directive Means

| Directive | Purpose | NEVER Allow |
|-----------|---------|-------------|
| `default-src` | Fallback for all resources | `*` or `unsafe-inline` |
| `script-src` | JavaScript sources | `unsafe-eval` or `unsafe-inline` |
| `style-src` | CSS sources | `unsafe-inline` without nonce |
| `img-src` | Image sources | `*` without domain |
| `connect-src` | AJAX, WebSocket, EventSource | Unrestricted domains |
| `object-src` | Plugins (Flash, Java) | Anything but `'none'` |

### Nonce Implementation

```php
// Laravel Middleware Example
class CspNonceMiddleware
{
    public function handle($request, $next)
    {
        $nonce = base64_encode(random_bytes(32));
        
        // Store for blade templates
        app()->instance('csp-nonce', $nonce);
        
        $response = $next($request);
        
        // Add CSP header with nonce
        $csp = "script-src 'self' 'nonce-{$nonce}';";
        $response->headers->set('Content-Security-Policy', $csp);
        
        return $response;
    }
}
```

```html
<!-- In Blade templates -->
<script nonce="{{ csp_nonce() }}">
    // This script will execute
</script>

<script>
    // This will be BLOCKED (no nonce)
</script>
```

## Framework-Specific Security

### Vue 3 + Inertia Setup (RECOMMENDED)

```javascript
// vite.config.js - Build-time compilation
export default {
  plugins: [
    vue({
      template: {
        compilerOptions: {
          // NO runtime compilation
          isCustomElement: (tag) => false
        }
      }
    })
  ],
  build: {
    // Generate CSP-compatible output
    rollupOptions: {
      output: {
        manualChunks: undefined,
      }
    }
  }
}
```

```php
// Laravel Inertia Middleware
class HandleInertiaRequests extends Middleware
{
    public function share(Request $request): array
    {
        return [
            'csp_nonce' => app('csp-nonce'),
            // NO user data that could contain XSS
        ];
    }
}
```

### Next.js Setup (ALTERNATIVE)

```javascript
// next.config.js
module.exports = {
  headers: async () => [
    {
      source: '/:path*',
      headers: [
        {
          key: 'Content-Security-Policy',
          value: "default-src 'self'; script-src 'self' 'nonce-{nonce}';"
        }
      ]
    }
  ],
  // Disable runtime JS where not needed
  unstable_runtimeJS: false
}
```

## Input Validation & Sanitization

### Never Trust User Input

```php
// WRONG - Direct usage
$transformed = transform($request->input('text'));

// RIGHT - Validated and sanitized
$validated = $request->validate([
    'text' => 'required|string|max:50000'
]);

$sanitized = htmlspecialchars($validated['text'], ENT_QUOTES, 'UTF-8');
$transformed = transform($sanitized);
```

### Validation Rules

```php
class TransformRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => [
                'required',
                'string',
                'max:50000',
                // Custom rule to block script tags
                function ($attribute, $value, $fail) {
                    if (preg_match('/<script[^>]*>.*?<\/script>/is', $value)) {
                        $fail('Script tags are not allowed.');
                    }
                }
            ],
            'transformation' => 'required|in:' . implode(',', self::ALLOWED_TYPES)
        ];
    }
    
    public function sanitize(): array
    {
        return [
            'text' => strip_tags($this->text),
            'transformation' => $this->transformation
        ];
    }
}
```

## XSS Prevention

### Output Encoding

```php
// Blade - Automatic escaping
{{ $userText }} // Escaped
{!! $userText !!} // DANGEROUS - Never use with user input

// JavaScript context - ALWAYS JSON encode
<script nonce="{{ csp_nonce() }}">
    const userData = @json($userData);
    // Never do: const data = "{{ $userData }}";
</script>
```

### React/Vue Components

```jsx
// React - Automatic escaping
<div>{userText}</div> // Safe

// Vue 3 - Automatic escaping
<template>
  <div>{{ userText }}</div> // Safe
  <div v-html="userText"></div> // DANGEROUS - Avoid
</template>
```

## Security Headers

### Complete Security Headers Set

```php
class SecurityHeaders
{
    public function handle($request, $next)
    {
        $response = $next($request);
        
        // Security headers
        $headers = [
            'X-Frame-Options' => 'DENY',
            'X-Content-Type-Options' => 'nosniff',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
        ];
        
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
        
        return $response;
    }
}
```

## CORS Configuration

```php
// config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['GET', 'POST'],
    'allowed_origins' => [
        'https://casechanger.pro',
        // NO wildcards (*)
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type', 'Authorization'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // Keep false unless needed
];
```

## Authentication & Authorization

### API Security (If Implemented)

```php
// Rate limiting
Route::middleware('throttle:60,1')->group(function () {
    Route::post('/api/transform', 'ApiController@transform');
});

// Optional API keys
class ApiKeyMiddleware
{
    public function handle($request, $next)
    {
        $apiKey = $request->header('X-API-Key');
        
        if (!$apiKey || !$this->isValidApiKey($apiKey)) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }
        
        return $next($request);
    }
    
    private function isValidApiKey($key): bool
    {
        // Constant-time comparison
        return hash_equals(
            hash('sha256', $key),
            hash('sha256', config('api.key'))
        );
    }
}
```

## Security Testing

### Automated Security Tests

```javascript
// tests/security/csp.test.js
describe('CSP Compliance', () => {
    test('Homepage has no CSP violations', async () => {
        const browser = await puppeteer.launch();
        const page = await browser.newPage();
        
        const violations = [];
        page.on('console', msg => {
            if (msg.text().includes('Content Security Policy')) {
                violations.push(msg.text());
            }
        });
        
        await page.goto('http://localhost:3000');
        
        expect(violations).toHaveLength(0);
        await browser.close();
    });
});
```

### Security Checklist Tests

```php
// tests/Security/HeadersTest.php
class HeadersTest extends TestCase
{
    public function test_security_headers_present()
    {
        $response = $this->get('/');
        
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        
        // Ensure no unsafe CSP
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringNotContainsString('unsafe-eval', $csp);
        $this->assertStringNotContainsString('unsafe-inline', $csp);
    }
}
```

## Monitoring & Incident Response

### CSP Violation Reporting

```javascript
// CSP Report endpoint
app.post('/api/csp-report', (req, res) => {
    const violation = req.body['csp-report'];
    
    // Log violation for analysis
    logger.error('CSP Violation', {
        documentUri: violation['document-uri'],
        violatedDirective: violation['violated-directive'],
        blockedUri: violation['blocked-uri'],
        lineNumber: violation['line-number'],
        columnNumber: violation['column-number']
    });
    
    // Alert if critical
    if (violation['violated-directive'].includes('script-src')) {
        alertTeam('Critical CSP violation detected');
    }
    
    res.status(204).send();
});
```

### Security Monitoring

```javascript
// Real-time security monitoring
class SecurityMonitor {
    static checkForViolations() {
        // Check logs for security issues
        const violations = LogParser.findCSPViolations();
        
        if (violations.length > 0) {
            // Immediate alert
            AlertSystem.critical('CSP violations detected', violations);
            
            // Auto-rollback if critical
            if (violations.some(v => v.severity === 'critical')) {
                Deployment.rollback();
            }
        }
    }
}

// Run every minute
setInterval(SecurityMonitor.checkForViolations, 60000);
```

## Security Audit Schedule

### Daily Checks
- [ ] CSP violation logs
- [ ] Error rates
- [ ] Suspicious requests

### Weekly Audits
- [ ] Dependency vulnerabilities
- [ ] Security header verification
- [ ] Rate limit effectiveness

### Monthly Reviews
- [ ] Penetration test results
- [ ] Security policy updates
- [ ] Incident postmortems

## Common Security Mistakes to Avoid

### 1. The Alpine.js Trap
```html
<!-- NEVER DO THIS -->
<div x-data="{ open: false }">
    <!-- Alpine.js requires unsafe-eval -->
</div>

<!-- DO THIS INSTEAD -->
<div>
    <!-- Server-side or compiled framework -->
</div>
```

### 2. The "Temporary" Unsafe-Eval
```nginx
# NEVER DO THIS
Content-Security-Policy: script-src 'self' 'unsafe-eval'; # "just for now"

# There is no "temporary" in security
```

### 3. The innerHTML XSS
```javascript
// NEVER DO THIS
element.innerHTML = userInput;

// DO THIS
element.textContent = userInput;
```

### 4. The Trust-All CORS
```javascript
// NEVER DO THIS
Access-Control-Allow-Origin: *

// DO THIS
Access-Control-Allow-Origin: https://specific-domain.com
```

## Security Resources

### Tools
1. **CSP Evaluator:** Google's CSP analyzer
2. **Security Headers:** securityheaders.com
3. **OWASP ZAP:** Security testing
4. **Snyk:** Dependency scanning

### Documentation
1. **OWASP Top 10:** Essential security risks
2. **MDN CSP Guide:** Complete CSP reference
3. **NIST Cybersecurity:** Framework guidelines

## Final Security Reminder

The previous project failed because:
1. Alpine.js was added (requires unsafe-eval)
2. CSP was compromised to accommodate it
3. Security became optional
4. 500+ violations were ignored

This will NOT happen again because:
1. CSP is configured FIRST
2. Frameworks are validated for CSP
3. Security is MANDATORY
4. One violation = build failure

**Remember: The attackers only need to succeed once. We need to succeed every time.**

---

**Security is not a feature. It's the foundation.**
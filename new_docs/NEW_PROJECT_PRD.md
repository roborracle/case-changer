# Product Requirements Document (PRD) - Case Changer v2.0

## Document Control
- **Version:** 2.0
- **Date:** 2024
- **Status:** Complete Rebuild Required
- **Previous Version:** 1.0 (FAILED - Alpine.js CSP violations)

## Executive Summary

Case Changer v2.0 is a complete rebuild of the text transformation platform after v1.0's catastrophic failure due to Alpine.js requiring `unsafe-eval`. This PRD establishes non-negotiable security requirements and deployment specifications for Railway.

## Critical Constraints (NON-NEGOTIABLE)

### Absolute Prohibitions
1. **NO `unsafe-eval`** - Not even temporarily, not even in development
2. **NO `unsafe-inline`** - All scripts must use nonces or be external
3. **NO Alpine.js** - Fundamentally incompatible with CSP
4. **NO runtime template compilation** - Pre-compile everything
5. **NO eval(), Function(), setTimeout(string)** - Ever

### Railway Deployment Requirements
```yaml
# Railway Production Environment
Environment: Production
Region: US-West
SSL: Automatic via Railway
Headers: Strict CSP enforced
Monitoring: Enabled
Auto-deploy: GitHub main branch
```

## Product Vision

### Mission Statement
Provide the world's most comprehensive, secure, and performant text transformation platform with absolute privacy and zero data persistence.

### Success Metrics
- **Security:** ZERO CSP violations (not one allowed)
- **Performance:** <21ms transformation time
- **Reliability:** 99.9% uptime
- **Scale:** 1M+ transformations/month
- **User Satisfaction:** 4.5+ rating

## User Stories & Requirements

### Core User Stories

#### As a Developer
- I want to transform variable names between conventions
- I want API access for automation
- I want consistent, predictable results
- **I need absolute security with no eval vulnerabilities**

#### As a Content Creator  
- I want to format text for different platforms
- I want professional style guide compliance
- I want instant transformations
- **I need my content to remain private**

#### As a Security-Conscious User
- I want zero data persistence
- I want no tracking or analytics
- I want strict CSP compliance
- **I need proof of security (headers visible)**

## Functional Requirements

### P0 - Critical (Week 1-2)
1. **Security Foundation**
   - Strict CSP headers configured
   - All security headers enabled
   - HTTPS enforcement
   - Zero violations monitoring

2. **Core Transformation Engine**
   - 20 essential transformations
   - Server-side only processing
   - <21ms response time
   - Unicode support

3. **Basic UI**
   - Input/output panels
   - Transform button
   - Copy functionality
   - CSP-compliant implementation

### P1 - Required (Week 3-4)
1. **Complete Transformations**
   - All 210+ transformations
   - Category organization
   - Validation and error handling
   - Performance optimization

2. **Enhanced UI**
   - Responsive design
   - Dark/light themes (cookie only)
   - Keyboard shortcuts (no eval)
   - Accessibility WCAG AA

3. **API v1**
   - RESTful endpoints
   - Rate limiting
   - Documentation
   - Example code

### P2 - Nice to Have (Week 5-6)
1. **Advanced Features**
   - Batch processing
   - History (session only)
   - PWA support
   - Offline capability

2. **Developer Tools**
   - API keys (optional)
   - Webhooks
   - SDKs
   - Playground

## Technical Requirements

### Approved Tech Stacks

#### Option 1: Laravel + Vue 3 + Inertia (RECOMMENDED)
```javascript
// Pre-compiled templates only
// NO runtime compilation
// CSP fully compliant
```

#### Option 2: Next.js + React
```javascript
// Server components preferred
// Static generation for tools
// API routes for transformations
```

### Railway-Specific Configuration

```toml
# railway.toml
[build]
builder = "NIXPACKS"
buildCommand = "npm ci && npm run build && php artisan optimize"

[deploy]
startCommand = "php artisan serve --host=0.0.0.0 --port=${PORT}"
healthcheckPath = "/health"
healthcheckTimeout = 30

[env]
APP_ENV = "production"
APP_DEBUG = "false"
FORCE_HTTPS = "true"
SESSION_SECURE_COOKIE = "true"
CSP_ENABLED = "true"
UNSAFE_EVAL = "NEVER" # Reminder constant
```

### Security Requirements

```php
// Mandatory CSP Header (NO MODIFICATIONS ALLOWED)
Content-Security-Policy: 
    default-src 'self';
    script-src 'self' 'nonce-{random}';
    style-src 'self' 'nonce-{random}' https://fonts.bunny.net;
    font-src 'self' https://fonts.bunny.net;
    img-src 'self' data: https:;
    connect-src 'self';
    frame-ancestors 'none';
    base-uri 'self';
    form-action 'self';
    upgrade-insecure-requests;
    block-all-mixed-content;
```

## Development Phases

### Phase 0: Pre-Flight (Day 1-3)
**Goal:** Validate stack and security

Tasks:
1. [ ] Complete PRE_FLIGHT_CHECKLIST.md
2. [ ] Set up development environment
3. [ ] Configure CSP headers
4. [ ] Build proof of concept
5. [ ] Verify ZERO violations
6. [ ] Deploy to Railway staging

**Exit Criteria:** Zero CSP violations with basic transformation working

### Phase 1: Foundation (Week 1)
**Goal:** Secure, working core

Tasks:
1. [ ] Security headers configured
2. [ ] 20 core transformations
3. [ ] Basic UI (no JavaScript)
4. [ ] Railway deployment pipeline
5. [ ] Automated CSP testing
6. [ ] Performance baseline

**Exit Criteria:** Production-ready security with core features

### Phase 2: Expansion (Week 2-3)
**Goal:** Full feature set

Tasks:
1. [ ] All 210+ transformations
2. [ ] Category system
3. [ ] Enhanced UI (CSP-compliant)
4. [ ] API implementation
5. [ ] Performance optimization
6. [ ] Documentation

**Exit Criteria:** Feature-complete application

### Phase 3: Polish (Week 4)
**Goal:** Production ready

Tasks:
1. [ ] UI/UX refinement
2. [ ] Performance tuning
3. [ ] Security audit
4. [ ] Load testing
5. [ ] Documentation complete
6. [ ] Marketing site

**Exit Criteria:** Ready for public launch

### Phase 4: Launch (Week 5)
**Goal:** Public availability

Tasks:
1. [ ] Production deployment
2. [ ] Monitoring active
3. [ ] Support ready
4. [ ] Analytics (privacy-compliant)
5. [ ] Feedback system
6. [ ] Iteration plan

**Exit Criteria:** Successful public launch

## Testing Requirements

### Mandatory Test Coverage
```javascript
// Every commit must pass these tests
describe('Security Tests', () => {
    test('No CSP violations on any page', async () => {
        // Test all routes for violations
        const violations = await testAllRoutesForCSP();
        expect(violations).toHaveLength(0);
    });
    
    test('No unsafe-eval in any file', async () => {
        const hasEval = await searchForEval();
        expect(hasEval).toBe(false);
    });
    
    test('No Alpine.js references', async () => {
        const hasAlpine = await searchForAlpine();
        expect(hasAlpine).toBe(false);
    });
});
```

### Performance Requirements
- Transformation: <21ms (P95)
- Page Load: <2s (3G)
- First Paint: <1.5s
- Lighthouse: >95

## Railway Deployment Pipeline

### Automated Deployment
```yaml
# .github/workflows/deploy.yml
name: Deploy to Railway

on:
  push:
    branches: [main]

jobs:
  security-check:
    runs-on: ubuntu-latest
    steps:
      - name: Check for unsafe-eval
        run: |
          if grep -r "unsafe-eval" .; then
            echo "FATAL: unsafe-eval detected"
            exit 1
          fi
      
      - name: Check for Alpine.js
        run: |
          if grep -r "Alpine\|x-data\|x-show" .; then
            echo "FATAL: Alpine.js detected"
            exit 1
          fi
  
  deploy:
    needs: security-check
    runs-on: ubuntu-latest
    steps:
      - uses: railwayapp/deploy-action@v1
        with:
          service: case-changer-v2
```

### Environment Variables (Railway)
```bash
# Required in Railway
APP_KEY=base64:... # Laravel key
APP_URL=https://casechanger.app
FORCE_HTTPS=true
CSP_ENABLED=true
STRICT_CSP=true
ALLOW_UNSAFE_EVAL=false # Must be false
CACHE_DRIVER=redis
SESSION_DRIVER=cookie
QUEUE_CONNECTION=sync
```

## Monitoring & Alerts

### Railway Monitoring
- CPU usage < 80%
- Memory usage < 512MB
- Response time < 200ms
- Error rate < 0.1%

### Security Monitoring
```javascript
// Alert if ANY CSP violation
if (cspViolationCount > 0) {
    alert.critical('CSP VIOLATION DETECTED');
    deployment.rollback();
}
```

## Risk Assessment

### Critical Risks
1. **CSP Violation**
   - Mitigation: Automated testing
   - Monitor: Real-time alerts
   - Response: Immediate rollback

2. **Performance Degradation**
   - Mitigation: Performance budget
   - Monitor: Railway metrics
   - Response: Optimization sprint

3. **Security Breach**
   - Mitigation: Security-first design
   - Monitor: WAF + monitoring
   - Response: Incident response plan

## Success Criteria

### Launch Criteria
- [ ] ZERO CSP violations
- [ ] All 210+ transformations working
- [ ] Performance targets met
- [ ] Security audit passed
- [ ] Railway deployment stable
- [ ] Documentation complete
- [ ] Monitoring active

### Post-Launch Success
- 100K+ transformations/week
- Zero security incidents
- <0.1% error rate
- 4.5+ user rating
- Positive feedback

## Lessons from v1.0 Failure

### What Went Wrong
1. Added Alpine.js without understanding CSP implications
2. Compromised security for convenience
3. No validation gates
4. Ignored 500+ CSP violations
5. Tech stack incompatible with requirements

### How v2.0 Prevents This
1. CSP configured before any code
2. Security is non-negotiable
3. Automated validation gates
4. One violation = build failure
5. Pre-validated tech stack

## Approval & Sign-Off

### Required Approvals
- [ ] Product Owner: _____________
- [ ] Technical Lead: _____________
- [ ] Security Lead: _____________
- [ ] DevOps Lead: _____________

### Commitment Statement
"We understand that Alpine.js and unsafe-eval are absolutely forbidden. We commit to maintaining strict CSP compliance with zero violations. Security requirements are non-negotiable."

Signed: _____________ Date: _____________

---

## Appendix A: Forbidden Technologies
- Alpine.js (requires eval)
- Any eval-based framework
- Runtime template engines
- Inline event handlers
- document.write()
- innerHTML with user data

## Appendix B: Railway Resources
- [Railway Documentation](https://docs.railway.app)
- [Railway Security Best Practices](https://docs.railway.app/guides/security)
- [Railway Environment Variables](https://docs.railway.app/guides/variables)

## Appendix C: CSP Resources
- [CSP Evaluator](https://csp-evaluator.withgoogle.com/)
- [MDN CSP Guide](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP)
- [OWASP CSP Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Content_Security_Policy_Cheat_Sheet.html)

---

**This PRD supersedes all previous versions. The failures of v1.0 will not be repeated.**
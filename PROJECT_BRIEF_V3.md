# Case Changer v3.0 - Project Brief

## Executive Summary
Case Changer is a professional text transformation platform offering 200+ conversion tools. Version 1.0 failed catastrophically due to Alpine.js requiring 'unsafe-eval', making strict Content Security Policy (CSP) impossible. This brief outlines v3.0 requirements for a complete rebuild.

## Critical Failure Context
- **v1.0 Status:** Abandoned due to 500+ CSP violations per page
- **Root Cause:** Alpine.js requires eval() for runtime template compilation
- **Impact:** Entire UI layer contaminated, security compromised
- **Decision:** Complete rebuild with CSP-compliant technology

## Core Requirements

### Functional Requirements
- **210+ Text Transformation Tools** organized in 18 categories
- **Instant Processing** (<50ms for most transformations)
- **Copy/Download/Share** functionality for all outputs
- **SEO-Optimized** individual pages for each tool
- **Progressive Enhancement** - works without JavaScript

### Non-Functional Requirements
- **Strict CSP Compliance** - ZERO violations, no unsafe-eval, no unsafe-inline
- **Performance:** <2s page load on 3G, <21ms transformation time
- **Accessibility:** WCAG 2.1 AA compliant
- **Security:** All transformations server-side only
- **Deployment:** Railway-ready with auto-scaling

## Technology Constraints

### ❌ FORBIDDEN (Zero Tolerance)
1. **Alpine.js** - Requires unsafe-eval
2. **Any eval-based framework**
3. **Runtime template compilation**
4. **Inline event handlers**
5. **document.write()**

### ✅ APPROVED OPTIONS
1. **React** - JSX compiles at build time (CSP-safe)
2. **Vue 3** - Template pre-compilation (CSP-safe)
3. **Svelte** - Compile-time framework (CSP-safe)
4. **HTMX** - No evaluation needed (CSP-safe)
5. **Vanilla JS** - With proper CSP headers

## Recommended Stacks

### Option 1: Next.js (Full-Stack React)
```javascript
// Pros: SSR/SSG, API routes, React ecosystem, Railway-optimized
// Cons: Learning curve if unfamiliar with React
```

### Option 2: Laravel + Inertia + React/Vue
```php
// Pros: Laravel backend power, SPA-like experience, familiar PHP
// Cons: Two ecosystems to manage
```

### Option 3: Laravel + HTMX
```html
<!-- Pros: Minimal JavaScript, server-driven, simple -->
<!-- Cons: Less interactive, requires full page updates -->
```

## Implementation Phases

### Phase 1: Foundation (Week 1)
- Technology stack selection
- CSP configuration (MUST be first)
- Basic project structure
- CI/CD pipeline setup

### Phase 2: Core Features (Week 2-3)
- Server-side transformation engine
- Basic UI without any forbidden tech
- 10 pilot transformation tools
- CSP validation (ZERO violations required)

### Phase 3: Scale (Week 4-5)
- Remaining 200+ tools
- Category organization
- Search and navigation
- Performance optimization

### Phase 4: Deploy (Week 6)
- Railway deployment
- Monitoring setup
- Security audit
- Launch

## Success Criteria
1. **ZERO CSP violations** across entire application
2. All 210+ tools functional
3. <2s page load time
4. <21ms transformation time
5. Railway deployment successful
6. No Alpine.js anywhere in codebase

## Budget & Timeline
- **Timeline:** 6 weeks
- **Budget:** Development resources + Railway hosting
- **Team:** 1-2 developers with CSP expertise

## Decision Points Needed

### 1. Frontend Framework
**Question:** Which CSP-compliant framework best balances developer productivity with performance?
- React (Next.js) - Modern, popular, extensive ecosystem
- Vue 3 - Gentler learning curve, excellent DX
- Svelte - Smallest bundle, fastest runtime
- HTMX - Simplest, server-driven

### 2. Backend Architecture
**Question:** Monolithic Laravel or decoupled API?
- Monolithic with Inertia - Simpler deployment
- API + SPA - Better separation of concerns
- Hybrid with partial hydration - Best of both

### 3. Deployment Strategy
**Question:** Railway configuration approach?
- Docker containers
- Nixpacks (Railway default)
- Custom buildpacks

## Risk Mitigation
1. **CSP Testing:** Automated testing before every commit
2. **Technology Validation:** PoC before full implementation
3. **No Alpine.js:** Pre-commit hooks to block Alpine.js
4. **Security First:** CSP headers configured on day one

## Documentation Available
Complete failure analysis and technical specifications available in `/new_docs`:
- Catastrophic failure analysis
- TALL stack incompatibility report
- Security implementation guide
- SCARLETT quality rules
- React implementation guide
- Complete PRD with 210+ tools listed

## Next Steps
1. **Review this brief** with technical decision maker
2. **Select technology stack** based on team expertise
3. **Validate CSP compatibility** with proof of concept
4. **Begin Phase 1** implementation

## Contact
This project requires developers who understand:
- Why Alpine.js killed v1.0
- How to implement strict CSP
- Server-side processing requirements
- Railway deployment

---

**Remember: v1.0 died from Alpine.js. v3.0 must have ZERO CSP violations from day one.**
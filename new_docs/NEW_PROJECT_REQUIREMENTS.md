# New Project Requirements & Tech Stack Specification

## Project Codename: Case Changer v2.0 - Phoenix Edition

## Non-Negotiable Requirements

### Security Requirements (MANDATORY)
1. **Content Security Policy (CSP)**
   - STRICT mode enforced from day one
   - NO `unsafe-eval` - EVER
   - NO `unsafe-inline` - EVER
   - Zero violations tolerance
   - Automated testing for violations

2. **Privacy Requirements**
   - Zero data persistence
   - No user tracking
   - No analytics
   - No cookies (except theme)
   - Complete stateless operation

3. **Performance Requirements**
   - Transformation time: < 21ms
   - Page load: < 2 seconds on 3G
   - Lighthouse score: > 95
   - First Contentful Paint: < 1.5s
   - Zero render-blocking resources

## Recommended Tech Stacks

### Option 1: Laravel + Inertia + Vue 3 (RECOMMENDED)
**Why This Works:**
- Vue templates are pre-compiled (no eval)
- Inertia provides SPA experience with server-side routing
- Full TypeScript support
- CSP compliant with proper configuration
- Progressive enhancement possible

**Stack Components:**
- **Backend:** Laravel 11.x
- **Bridge:** Inertia.js
- **Frontend:** Vue 3 (Composition API)
- **Styling:** Tailwind CSS
- **Build:** Vite
- **Types:** TypeScript

**CSP Configuration:**
```javascript
// All templates pre-compiled, no runtime evaluation
// CSP headers can be strict without issues
```

### Option 2: Next.js Full-Stack (ALTERNATIVE)
**Why This Works:**
- React Server Components
- Built-in API routes
- Static generation for tools
- Excellent performance
- Full TypeScript

**Stack Components:**
- **Framework:** Next.js 14+
- **UI:** React 18+
- **Styling:** Tailwind CSS
- **API:** Next.js API routes
- **Database:** None (stateless)
- **Deployment:** Vercel/Railway

### Option 3: Astro + API (PERFORMANCE FOCUSED)
**Why This Works:**
- Zero JavaScript by default
- Island architecture
- Blazing fast static generation
- Perfect for content-heavy sites
- CSP compliant by design

**Stack Components:**
- **Framework:** Astro
- **API:** Separate Node.js/Go service
- **Interactive:** Solid.js islands (compiled)
- **Styling:** Tailwind CSS
- **Build:** Astro/Vite

### Option 4: Laravel + HTMX (SIMPLE)
**Why This Works:**
- No JavaScript frameworks
- HTML over the wire
- CSP compliant
- Simple mental model
- Progressive enhancement

**Stack Components:**
- **Backend:** Laravel 11.x
- **Interactivity:** HTMX
- **Styling:** Tailwind CSS
- **Enhancement:** Vanilla JS with nonces

## Forbidden Technologies

### NEVER USE THESE:
1. **Alpine.js** - Requires unsafe-eval
2. **Any eval-based framework** - CSP violation
3. **Runtime template compilation** - Security risk
4. **Inline event handlers** - CSP violation
5. **document.write()** - Security risk
6. **innerHTML with user content** - XSS risk

## Development Principles

### 1. Security-First Development
- CSP headers configured on day one
- Automated CSP violation testing
- Security review before any deployment
- Penetration testing before launch

### 2. Test-Driven Development
- Write CSP compliance tests first
- Performance tests from beginning
- Accessibility tests mandatory
- Cross-browser testing automated

### 3. Documentation-Driven Development
- Document before implementing
- API specs before coding
- Security requirements prominent
- Update docs with code

### 4. Progressive Enhancement
- Core functionality without JavaScript
- Enhance with safe JavaScript
- Fallbacks for everything
- Offline-first approach

## Project Structure Requirements

### Monorepo Structure (Recommended)
```
case-changer-v2/
├── apps/
│   ├── web/           # Main web application
│   ├── api/           # API service
│   └── admin/         # Admin panel (if needed)
├── packages/
│   ├── transformers/  # Core transformation logic
│   ├── ui/           # Shared UI components
│   └── types/        # TypeScript types
├── docs/             # All documentation
├── tests/
│   ├── e2e/         # End-to-end tests
│   ├── security/    # Security tests
│   └── performance/ # Performance tests
└── scripts/
    ├── csp-check.js # CSP violation checker
    └── deploy.sh    # Deployment script
```

## Validation Gates (MANDATORY)

### Pre-Commit Hooks
```bash
#!/bin/bash
# Required checks before ANY commit

1. CSP violation check
2. TypeScript compilation
3. Linting pass
4. Unit tests pass
5. Security scan
```

### Pre-Deploy Checks
```bash
#!/bin/bash
# Required before deployment

1. Full test suite pass
2. Zero CSP violations
3. Performance budget met
4. Accessibility audit pass
5. Security headers verified
```

## Development Workflow

### Day 1 Tasks
1. Set up CSP headers with strict policy
2. Configure automated testing
3. Implement basic transformation
4. Verify zero CSP violations
5. Deploy minimal version

### Week 1 Goals
1. Core transformation engine working
2. 10 basic transformations implemented
3. API structure defined
4. CSP compliance verified
5. Performance baseline established

### Month 1 Targets
1. 50+ transformations
2. Full API implementation
3. Complete UI/UX
4. Performance optimized
5. Security audit passed

## Team Requirements

### Required Expertise
1. **Security Engineer** - CSP expert
2. **Backend Developer** - API specialist
3. **Frontend Developer** - Modern framework expert
4. **DevOps Engineer** - Deployment specialist
5. **QA Engineer** - Testing automation

### Knowledge Requirements
- Deep understanding of CSP
- Experience with chosen stack
- Performance optimization skills
- Security best practices
- Accessibility standards

## Success Metrics

### Technical Metrics
- CSP violations: ZERO
- Transformation time: < 21ms
- Lighthouse score: > 95
- Test coverage: > 80%
- Security score: A+

### Business Metrics
- User satisfaction: > 4.5/5
- API adoption rate
- Daily active users
- Transformation volume
- Error rate: < 0.1%

## Migration Strategy

### From Current (Broken) Project
1. Extract transformation logic (PHP)
2. Document all features
3. Identify working components
4. List all tools/categories
5. Abandon everything else

### Data to Preserve
- Transformation algorithms
- Tool definitions
- Category structure
- SEO content
- API specifications

### Data to Abandon
- All Blade templates
- All Alpine.js code
- Livewire components
- Current routing
- Current middleware

## Risk Mitigation

### Technical Risks
1. **CSP Violations**
   - Mitigation: Test from day one
   - Monitor: Automated checking
   - Response: Immediate fixes

2. **Performance Issues**
   - Mitigation: Budget from start
   - Monitor: Continuous testing
   - Response: Optimization sprints

3. **Security Vulnerabilities**
   - Mitigation: Security-first design
   - Monitor: Automated scanning
   - Response: Rapid patching

## Timeline

### Phase 1: Foundation (Week 1-2)
- Tech stack setup
- CSP configuration
- Basic transformation engine
- Automated testing
- Initial deployment

### Phase 2: Core Features (Week 3-6)
- 100+ transformations
- API implementation
- UI development
- Performance optimization
- Security hardening

### Phase 3: Polish (Week 7-8)
- Remaining transformations
- UI refinement
- Documentation
- Testing completion
- Launch preparation

## Budget Considerations

### Development Costs
- 8-week timeline
- 5-person team
- Testing infrastructure
- Security audits
- Performance testing

### Infrastructure Costs
- Hosting (Railway/Vercel)
- CDN (Cloudflare)
- Monitoring tools
- Backup services
- Domain/SSL

## Definition of Done

### Project is complete when:
1. ✅ 210+ transformations working
2. ✅ ZERO CSP violations
3. ✅ Performance targets met
4. ✅ Security audit passed
5. ✅ Accessibility compliant
6. ✅ API documented
7. ✅ Tests passing (>80% coverage)
8. ✅ Documentation complete
9. ✅ Deployed to production
10. ✅ Monitoring active

## Lessons from Previous Failure

### What Went Wrong
1. Chose incompatible tech stack (TALL)
2. Didn't validate CSP early
3. Let Alpine.js contaminate everything
4. No security gates in development
5. Agents lacked requirements understanding

### How This Prevents It
1. Pre-validated tech stack for CSP
2. CSP testing from hour one
3. Forbidden technology list
4. Automated security gates
5. Clear requirements documentation

## Final Notes

This project MUST succeed where the previous one failed. The primary failure was technology selection - Alpine.js was fundamentally incompatible with security requirements.

The new stack must be:
- **CSP compliant by design**
- **Security-first architecture**
- **Performance optimized**
- **Properly tested**
- **Well documented**

No compromises on security. No exceptions to CSP. No evaluation-based frameworks.

**The previous project died because of Alpine.js. This one will succeed because we learned that lesson.**
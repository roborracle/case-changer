# Pre-Flight Checklist: Before Writing ANY Code

## STOP! Complete This Checklist Before Starting

### ⚠️ CRITICAL: Do Not Skip Any Item

## 1. Technology Stack Validation ✓

### CSP Compatibility Check
- [ ] **Question:** Does the framework require `eval()` or `new Function()`?
  - If YES → **REJECT IMMEDIATELY**
- [ ] **Question:** Does it use inline event handlers?
  - If YES → **REJECT IMMEDIATELY**
- [ ] **Question:** Does it compile templates at runtime?
  - If YES → **REJECT IMMEDIATELY**
- [ ] **Question:** Can it work with strict CSP headers?
  - If NO → **REJECT IMMEDIATELY**

### Framework Testing
```bash
# Before choosing a framework, test it:
1. Create minimal app
2. Add strict CSP headers:
   Content-Security-Policy: default-src 'self'; script-src 'self';
3. Check browser console
4. If ANY violations → REJECT THE FRAMEWORK
```

### Specific Technology Checks
- [ ] **Alpine.js?** → ❌ FORBIDDEN (requires eval)
- [ ] **Vue 2 with templates?** → ❌ FORBIDDEN (runtime compilation)
- [ ] **AngularJS (1.x)?** → ❌ FORBIDDEN (uses eval)
- [ ] **Knockout.js?** → ❌ FORBIDDEN (uses eval)
- [ ] **Vue 3 with SFC?** → ✅ ALLOWED (pre-compiled)
- [ ] **React?** → ✅ ALLOWED (JSX compiled)
- [ ] **Svelte?** → ✅ ALLOWED (compiled)
- [ ] **Solid.js?** → ✅ ALLOWED (compiled)

## 2. Security Configuration ✓

### Day Zero Security Setup
```bash
# These MUST be configured before writing features:

1. CSP Headers:
   - [ ] Strict policy configured
   - [ ] No unsafe-eval
   - [ ] No unsafe-inline
   - [ ] Nonce system if needed

2. Security Headers:
   - [ ] X-Frame-Options
   - [ ] X-Content-Type-Options
   - [ ] X-XSS-Protection
   - [ ] Referrer-Policy
   - [ ] Permissions-Policy

3. HTTPS:
   - [ ] Force HTTPS in development
   - [ ] SSL certificates ready
   - [ ] HSTS configured
```

### CSP Testing Setup
- [ ] Browser console open at ALL times
- [ ] CSP violation = build failure
- [ ] Automated CSP checking in CI
- [ ] Pre-commit hook for CSP validation

## 3. Development Environment ✓

### Required Tools
- [ ] **CSP Validator** installed
- [ ] **Security linter** configured
- [ ] **Performance monitor** active
- [ ] **Accessibility checker** ready
- [ ] **Browser DevTools** CSP monitoring enabled

### Git Hooks Configuration
```bash
# .git/hooks/pre-commit
#!/bin/bash

# Required checks:
- [ ] CSP violation check
- [ ] Security scan
- [ ] Linting
- [ ] Type checking
- [ ] Unit tests

# If ANY fail → commit blocked
```

## 4. Team Alignment ✓

### Every Team Member Must Understand
- [ ] CSP is MANDATORY, not optional
- [ ] NO Alpine.js or eval-based frameworks
- [ ] Security > Features > Speed
- [ ] Test CSP compliance continuously
- [ ] Violations = stop everything and fix

### Required Reading
Everyone must read these documents:
- [ ] CATASTROPHIC_FAILURE_ANALYSIS.md
- [ ] TALL_STACK_ANALYSIS.md  
- [ ] CSP_RECOVERY_PLAN.md
- [ ] NEW_PROJECT_REQUIREMENTS.md

### Sign-Off Required
```
I understand that:
1. CSP compliance is mandatory
2. Alpine.js is forbidden
3. No eval-based frameworks allowed
4. Security violations block deployment
5. I will test CSP compliance continuously

Name: _________________ Date: _______
```

## 5. Architecture Validation ✓

### Before Architecture Approval
- [ ] Security architect review
- [ ] CSP compliance verified
- [ ] Performance budget defined
- [ ] Accessibility plan approved
- [ ] Deployment strategy validated

### Proof of Concept Required
Before full development:
- [ ] Build minimal version with chosen stack
- [ ] Implement one transformation
- [ ] Verify ZERO CSP violations
- [ ] Test performance
- [ ] Deploy to staging

## 6. Testing Strategy ✓

### Test Types Required from Day 1
- [ ] **CSP Compliance Tests**
  ```javascript
  test('no CSP violations on homepage', async () => {
    const violations = await getCSPViolations('/');
    expect(violations).toHaveLength(0);
  });
  ```

- [ ] **Security Tests**
- [ ] **Performance Tests**
- [ ] **Accessibility Tests**
- [ ] **Cross-browser Tests**

### Continuous Monitoring
- [ ] CSP violations dashboard
- [ ] Performance metrics tracking
- [ ] Error rate monitoring
- [ ] Security scanning scheduled

## 7. Documentation Requirements ✓

### Before Coding Starts
- [ ] API specification complete
- [ ] Security requirements documented
- [ ] Performance budgets defined
- [ ] Architecture diagrams created
- [ ] Data flow documented

### Living Documentation
- [ ] README with security section
- [ ] CSP compliance guide
- [ ] Deployment checklist
- [ ] Troubleshooting guide
- [ ] Postmortem template

## 8. Deployment Preparation ✓

### Infrastructure Ready
- [ ] Hosting environment selected
- [ ] CDN configured
- [ ] SSL certificates obtained
- [ ] Monitoring tools setup
- [ ] Backup strategy defined

### Security Hardening
- [ ] WAF configured
- [ ] DDoS protection enabled
- [ ] Rate limiting implemented
- [ ] Security headers verified
- [ ] Penetration test scheduled

## 9. Failure Prevention ✓

### Lessons Applied
- [ ] No TALL stack (Alpine.js forbidden)
- [ ] No runtime template evaluation
- [ ] No client-side template compilation
- [ ] No inline event handlers
- [ ] No unsafe CSP directives

### Red Flags to Watch
If you see these, STOP immediately:
- [ ] "Just add unsafe-eval temporarily"
- [ ] "We'll fix CSP later"
- [ ] "Alpine makes this so easy"
- [ ] "Let's disable CSP for development"
- [ ] "The tutorial uses Alpine"

## 10. Success Criteria ✓

### Definition of Ready
Project can start when:
- [ ] All checklist items completed
- [ ] Stack validated for CSP
- [ ] Security configured
- [ ] Team aligned
- [ ] POC shows zero violations

### Definition of Done
Feature is complete when:
- [ ] Zero CSP violations
- [ ] Tests passing
- [ ] Performance budget met
- [ ] Security scan clean
- [ ] Documentation updated

## Final Validation Gate

### DO NOT PROCEED Unless:
✅ Every checkbox above is checked
✅ CSP compliance verified with POC
✅ No eval-based frameworks in stack
✅ Security headers configured
✅ Team understands requirements

### Sign-Off to Proceed

**Project Manager:** _________________ Date: _______
**Tech Lead:** _________________ Date: _______
**Security Lead:** _________________ Date: _______

## Emergency Procedures

### If CSP Violations Detected
1. **STOP** all development
2. **IDENTIFY** source of violation
3. **REMOVE** offending code/library
4. **VERIFY** zero violations
5. **DOCUMENT** incident

### If Alpine.js Is Suggested
1. **REJECT** immediately
2. **EXPLAIN** CSP incompatibility
3. **PROVIDE** alternatives
4. **DOCUMENT** attempt
5. **EDUCATE** team

## Remember

The previous project failed because:
- Alpine.js was added without understanding CSP implications
- No validation gates were in place
- Security was treated as optional
- CSP compliance was checked too late

This checklist prevents those failures.

**NO EXCEPTIONS. NO COMPROMISES. NO ALPINE.JS.**

---

### Checklist Status: 
- [ ] **NOT STARTED**
- [ ] **IN PROGRESS**
- [ ] **COMPLETED**

### Validated By: _________________
### Date: _________________
### Ready to Proceed: YES / NO
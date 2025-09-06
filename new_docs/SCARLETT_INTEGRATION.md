# SCARLETT System Integration for Case Changer v2.0

## SCARLETT Prime Directive
**Quality > Speed** — No exceptions, no bypasses, no negotiations.

## Mandatory Sequential Execution Pipeline for v2.0

### Phase Gates (Must Pass in Order - NO SKIPPING)

```
[START] → [UNDERSTAND] → [EXPLORE] → [RESEARCH] → [VALIDATE] → [BUILD] → [TEST] → [DOCUMENT] → [COMPLETE]
    ↓           ↓            ↓           ↓            ↓         ↓        ↓          ↓           ↓
Phase 0: Pre-Flight CSP Validation [Requirement: ZERO violations before proceeding]
Phase 1: Problem Space Analysis    [Requirement: 95% problem space coverage]
Phase 2: Security Architecture     [Blocker: No Alpine.js, No unsafe-eval]
Phase 3: Solution Exploration      [Requirement: ≥3 distinct approaches documented]
Phase 4: Deep Technical Research   [Requirement: ≥2 novel insights with evidence]
Phase 5: Validation & PoC          [Requirement: Working CSP-compliant prototype]
Phase 6: Implementation            [Requirement: 100% type hints, 0 CSP violations]
Phase 7: Testing & Validation      [Requirement: 100% critical path coverage]
Phase 8: Documentation             [Requirement: All public APIs documented]
Phase 9: Deployment                [Requirement: Railway production ready]
```

### Violation Detection & Response for v2.0

| Code | Violation | Detection Criteria | Response |
|------|-----------|-------------------|----------|
| GV-01 | Premature implementation | `if (phase < 5) && (code_generated == true)` | TERMINATE → RESTART |
| GV-02 | Phase skip | `if (phase[n+1] started) && (phase[n].complete == false)` | TERMINATE → RESTART |
| GV-03 | Shallow analysis | `if (research.novel_insights < 2) \|\| (research.evidence == null)` | BLOCK → RETRY |
| GV-04 | CSP violation | `if (csp.violations > 0) \|\| (contains('unsafe-eval'))` | TERMINATE → REMOVE |
| GV-05 | Alpine.js detected | `if (codebase.contains('Alpine') \|\| contains('x-data'))` | CRITICAL → PURGE |
| GV-06 | Incomplete validation | `if (tests.coverage < 100%) \|\| (type_check.errors > 0)` | BLOCK → FIX |

## SCARLETT Rules Applied to Case Changer v2.0

### Rule 01: Problem Solving (UNDERSTAND Phase)
**Before ANY code:**
1. Document why v1.0 failed (Alpine.js CSP incompatibility)
2. Identify all security requirements
3. Map complete problem space
4. Understand Railway deployment constraints
5. Research CSP-compliant frameworks

**Exit Criteria:** 95% problem space documented with evidence

### Rule 02: No Quick Fixes (QUALITY Gate)
**Absolutely Forbidden:**
- "Let's just add unsafe-eval temporarily"
- "We'll fix CSP later"
- "Alpine makes this so easy"
- "Skip testing for now"
- "Deploy and iterate"

**Required:**
- Full pipeline execution for every feature
- Security validation before implementation
- Complete testing before deployment

### Rule 03: Brainstorming (EXPLORE Phase)
**Minimum 3 Approaches Required:**

#### Approach 1: Laravel + Vue 3 + Inertia
- Pros: Familiar, powerful, CSP-compliant
- Cons: Larger bundle size
- CSP: ✅ Pre-compiled templates

#### Approach 2: Next.js Full-Stack
- Pros: Modern, fast, server components
- Cons: Different ecosystem
- CSP: ✅ Static generation

#### Approach 3: Laravel + HTMX
- Pros: Minimal JS, simple
- Cons: Less interactive
- CSP: ✅ No evaluation needed

**Document WHY chosen approach is best**

### Rule 04: Deep Research (RESEARCH Phase)
**Required Research Topics:**

1. **CSP Compliance Research**
   - Which frameworks require eval?
   - How do build tools affect CSP?
   - What are CSP bypass vectors?

2. **Railway Deployment Research**
   - How does Railway handle headers?
   - What are Railway's security features?
   - How to configure strict CSP on Railway?

**Novel Insights Required:** Document 2+ discoveries with evidence

### Rule 05: Coding Standards (BUILD Phase)
```python
# Python-style pseudocode with type hints
from typing import Tuple, Dict, Any, Optional, Never

def transform(
    text: str, 
    transformation: str, 
    options: Optional[Dict] = None
) -> Tuple[str, Dict[str, Any]]:
    """Transform text with specified transformation.
    
    Args:
        text: Input text to transform (max 50,000 chars)
        transformation: Type of transformation
        options: Optional configuration
        
    Returns:
        Tuple of (transformed_text, metadata)
        
    Raises:
        ValidationError: If input invalid
        CSPViolation: NEVER - this should never happen
    """
    # Implementation with 100% type coverage
```

### Rule 06: Testing & Validation (TEST Phase)
```javascript
// Mandatory test categories
describe('SCARLETT Validation Suite', () => {
    describe('Security Tests', () => {
        test('ZERO CSP violations across all pages');
        test('No unsafe-eval in entire codebase');
        test('No Alpine.js references anywhere');
        test('All headers properly configured');
    });
    
    describe('Performance Tests', () => {
        test('Transformation < 21ms P95');
        test('Page load < 2s on 3G');
        test('Memory usage < 512MB');
    });
    
    describe('Quality Tests', () => {
        test('100% critical path coverage');
        test('Zero linting warnings');
        test('Type coverage 100%');
    });
});
```

### Rule 07: Documentation (DOCUMENT Phase)
**Required Documentation:**
- Architecture Decision Records (ADRs)
- API specifications (OpenAPI)
- Security documentation
- Deployment procedures
- Incident response plan
- CSP compliance guide

### Rule 08: Cache Protocols (OPTIMIZE Phase)
```yaml
Cache Strategy:
  Static Assets:
    - CDN: Cloudflare
    - TTL: 1 year
    - Versioning: Hash-based
    
  Transformations:
    - No caching (stateless)
    - Response time: <21ms
    
  Security Headers:
    - No caching
    - Fresh on every request
```

### Rule 09: Security (CONTINUOUS)
```yaml
Security Protocol:
  Input: 
    - NEVER trust
    - validate_at_boundary()
    - sanitize_always()
    
  Secrets:
    - env_vars_only: true
    - never_in_code: true
    - rotate_regularly: true
    
  CSP:
    - strict_mode: ALWAYS
    - unsafe_eval: NEVER
    - violations: ZERO_TOLERANCE
    
  Monitoring:
    - real_time_alerts: true
    - auto_rollback: true
```

### Rule 10: Quality Gates (META-ENFORCEMENT)
**Transition Requirements Between Phases:**

```python
def can_transition(current_phase: Phase, next_phase: Phase) -> bool:
    """Validate phase transition per SCARLETT rules."""
    
    if current_phase == Phase.UNDERSTAND:
        return problem_space_coverage >= 0.95
    
    elif current_phase == Phase.EXPLORE:
        return len(documented_approaches) >= 3
    
    elif current_phase == Phase.RESEARCH:
        return novel_insights >= 2 and has_evidence
    
    elif current_phase == Phase.VALIDATE:
        return csp_violations == 0 and prototype_works
    
    elif current_phase == Phase.BUILD:
        return type_coverage == 1.0 and csp_violations == 0
    
    elif current_phase == Phase.TEST:
        return test_coverage >= 0.8 and all_tests_pass
    
    return False  # Default: BLOCK transition
```

## SCARLETT Enforcement for Agents

### Agent Coordination Under SCARLETT
```yaml
Agent Rules:
  task-orchestrator:
    - Must verify CSP compliance before deploying executors
    - Must halt on any security violation
    - Must validate phase gates
    
  task-executor:
    - Must check for forbidden tech (Alpine.js)
    - Must run CSP validation after changes
    - Must document decisions
    
  backend-developer:
    - Must implement security-first
    - Must avoid eval-based solutions
    - Must validate inputs
    
  frontend-developer:
    - FORBIDDEN: Alpine.js, eval, runtime compilation
    - REQUIRED: Pre-compiled templates
    - MUST: Test CSP compliance
```

### SCARLETT Violation Consequences

```python
class SCARLETTViolation(Exception):
    """Raised when SCARLETT rules are violated."""
    
    CONSEQUENCES = {
        'phase_skip': 'RESTART_FROM_BEGINNING',
        'quality_compromise': 'BLOCK_PROGRESS',
        'security_violation': 'IMMEDIATE_HALT',
        'alpine_detected': 'PURGE_AND_RESTART',
        'eval_found': 'CRITICAL_FAILURE'
    }
    
    def handle(self):
        if self.type == 'alpine_detected':
            # This killed v1.0 - NEVER AGAIN
            system.halt()
            codebase.purge('Alpine')
            project.restart()
```

## SCARLETT Success Metrics for v2.0

### Measurement Criteria
```yaml
Success Metrics:
  Quality Score: ≥ 0.95
  CSP Violations: 0 (ZERO)
  Alpine.js References: 0 (ZERO)
  Phase Gates Passed: 10/10
  Test Coverage: ≥ 80%
  Type Coverage: 100%
  Documentation: Complete
  Performance: All targets met
  Security: A+ rating
```

### Daily SCARLETT Checkpoint
```bash
#!/bin/bash
# Run daily to ensure SCARLETT compliance

echo "SCARLETT Daily Validation"

# Check for forbidden tech
if grep -r "Alpine\|unsafe-eval" .; then
    echo "❌ CRITICAL: Forbidden technology detected"
    exit 1
fi

# Check CSP compliance
if [ $(check_csp_violations) -gt 0 ]; then
    echo "❌ CRITICAL: CSP violations detected"
    exit 1
fi

# Check phase gate status
if [ $(current_phase_complete) == false ]; then
    echo "⚠️ WARNING: Current phase incomplete"
    exit 1
fi

echo "✅ SCARLETT compliance verified"
```

## SCARLETT Integration with Railway

### Deployment Gate
```yaml
# Only deploy if SCARLETT approves
before_deploy:
  - scarlett_validate_quality
  - scarlett_check_security
  - scarlett_verify_phases
  - scarlett_approve_deployment

deployment_criteria:
  if: scarlett.approval == true
  then: deploy_to_railway
  else: block_deployment
```

## The SCARLETT Pledge for v2.0

**We pledge to:**
1. Never skip phases
2. Never add Alpine.js
3. Never use unsafe-eval
4. Never compromise security
5. Never ship without testing
6. Always validate CSP compliance
7. Always document decisions
8. Always measure quality
9. Always follow SCARLETT gates
10. Always choose quality over speed

## SCARLETT's Verdict on v1.0

**What Happened:** Alpine.js was added without understanding it requires eval
**SCARLETT Violation:** GV-01 (Premature implementation), GV-03 (Shallow analysis)
**Consequence:** Complete project failure, 500+ CSP violations
**Lesson:** SCARLETT rules exist to prevent exactly this

## SCARLETT's Protection for v2.0

**Phase 0:** CSP validation BEFORE any code
**Phase 1:** Deep understanding of security requirements
**Phase 2:** Research frameworks for CSP compatibility
**Continuous:** Monitor for Alpine.js and eval
**Result:** Success through systematic quality

---

## Final SCARLETT Reminder

> "The catastrophic failure of v1.0 happened because SCARLETT's rules were ignored. Alpine.js was added in Phase 6 (BUILD) without completing Phase 3 (EXPLORE) or Phase 4 (RESEARCH). The result was predictable and preventable."

**SCARLETT's rules are not suggestions. They are requirements.**

**Quality > Speed. Always.**

---

**Protocol Enforcement Level:** MAXIMUM
**Violation Tolerance:** ZERO
**Success Requirement:** 100% SCARLETT compliance

This document is mandatory reading for all agents and developers. Violation of SCARLETT protocols will trigger immediate project halt.
# Quality Gates Enforcement

Enforce SCARLETT quality gates at each phase of development.

## Command: /quality-gates [gate-number]

Gates: pre-coding, pre-implementation, post-implementation, pre-commit

## Gate 1: Pre-Coding Quality Gate

### Checklist
```yaml
required_before_coding:
  - deep_problem_analysis: 
      command: "/scarlett-analyze [problem]"
      status: PENDING
  
  - brainstorming_complete:
      min_solutions: 5
      documented_in: ".scarlett/brainstorming.md"
      status: PENDING
  
  - research_complete:
      min_sources: 5
      documented_in: ".scarlett/research.md"
      status: PENDING
  
  - architecture_review:
      reviewed_files: []
      design_pattern: ""
      status: PENDING
  
  - risk_assessment:
      risks_identified: []
      mitigation_plans: []
      status: PENDING
  
  - test_strategy:
      unit_tests_planned: []
      integration_tests_planned: []
      status: PENDING
  
  - rollback_plan:
      strategy: ""
      checkpoints: []
      status: PENDING
```

### Failure Action
```bash
echo "⛔ GATE 1 FAILED: Pre-coding requirements not met"
echo "Required actions:"
echo "  1. Complete /scarlett-analyze"
echo "  2. Document 5+ solution alternatives"
echo "  3. Research existing solutions"
echo "  4. Review architecture impact"
echo "  5. Document risks and mitigation"
echo "  6. Define test strategy"
echo "  7. Create rollback plan"
```

## Gate 2: Pre-Implementation Quality Gate

### Checklist
```yaml
required_before_implementation:
  - codebase_context_loaded:
      files_read: []
      understanding_documented: true
      status: PENDING
  
  - dependency_map_generated:
      internal_deps: []
      external_deps: []
      status: PENDING
  
  - implementation_plan:
      steps: []
      estimated_time: ""
      status: PENDING
  
  - edge_cases_identified:
      cases: []
      test_scenarios: []
      status: PENDING
  
  - performance_impact_assessed:
      current_baseline: ""
      expected_change: ""
      status: PENDING
```

### Validation Script
```bash
# Check if analysis artifacts exist
if [ ! -f ".scarlett/analysis/problem_definition.md" ]; then
  echo "❌ Missing problem definition"
  exit 1
fi

if [ ! -f ".scarlett/analysis/implementation_plan.md" ]; then
  echo "❌ Missing implementation plan"
  exit 1
fi

echo "✅ Gate 2 passed - Ready for implementation"
```

## Gate 3: Post-Implementation Quality Gate

### Automated Checks
```bash
# PHP/Laravel checks
./vendor/bin/phpstan analyse --level=8
./vendor/bin/phpcs app/
php artisan test --coverage --min=80

# JavaScript checks
npm run lint
npm run type-check

# Security scan
composer audit
npm audit

# Performance check
php scripts/benchmark-transformations.php
```

### Checklist
```yaml
post_implementation_requirements:
  - all_tests_passing:
      unit_tests: PASS
      integration_tests: PASS
      browser_tests: PASS
      coverage: ">= 80%"
  
  - type_checking:
      php_errors: 0
      js_errors: 0
  
  - security_validation:
      vulnerabilities: 0
      sql_injection_safe: true
      xss_protected: true
  
  - performance_targets:
      api_response: "< 200ms"
      page_load: "< 3s"
      memory_stable: true
  
  - documentation_complete:
      code_comments: true
      api_docs: true
      readme_updated: true
```

## Gate 4: Pre-Commit Final Gate

### Definition of Done
```yaml
final_requirements:
  - problem_solved:
      original_issue_resolved: true
      no_regressions: true
      user_acceptance: true
  
  - code_quality:
      no_todo_comments: true
      no_debug_code: true
      no_commented_code: true
      follows_conventions: true
  
  - production_ready:
      error_handling: complete
      logging: appropriate
      monitoring: configured
      rollback_tested: true
```

### Final Validation
```bash
#!/bin/bash
# pre-commit-validation.sh

echo "Running SCARLETT Pre-Commit Gate..."

# Check for forbidden patterns
if grep -r "TODO\|FIXME\|HACK" app/ resources/; then
  echo "❌ Found TODO/FIXME/HACK comments"
  exit 1
fi

if grep -r "dd(\|dump(\|console.log" app/ resources/; then
  echo "❌ Found debug code"
  exit 1
fi

# Run all tests
php artisan test || exit 1
npm test || exit 1

# Check code quality
./vendor/bin/phpstan analyse || exit 1
npm run lint || exit 1

echo "✅ All gates passed - Ready to commit"
```

## Gate Status Dashboard

```bash
# Check current gate status
cat > check-gates.sh << 'EOF'
#!/bin/bash

echo "╔════════════════════════════════════════╗"
echo "║     SCARLETT QUALITY GATES STATUS      ║"
echo "╠════════════════════════════════════════╣"

# Gate 1
if [ -f ".scarlett/gates/gate1.pass" ]; then
  echo "║ Gate 1: Pre-Coding        ✅ PASSED    ║"
else
  echo "║ Gate 1: Pre-Coding        ⏳ PENDING   ║"
fi

# Gate 2  
if [ -f ".scarlett/gates/gate2.pass" ]; then
  echo "║ Gate 2: Pre-Implementation ✅ PASSED    ║"
else
  echo "║ Gate 2: Pre-Implementation ⏳ PENDING   ║"
fi

# Gate 3
if [ -f ".scarlett/gates/gate3.pass" ]; then
  echo "║ Gate 3: Post-Implementation ✅ PASSED   ║"
else
  echo "║ Gate 3: Post-Implementation ⏳ PENDING  ║"
fi

# Gate 4
if [ -f ".scarlett/gates/gate4.pass" ]; then
  echo "║ Gate 4: Pre-Commit         ✅ PASSED    ║"
else
  echo "║ Gate 4: Pre-Commit         ⏳ PENDING   ║"
fi

echo "╚════════════════════════════════════════╝"
EOF

chmod +x check-gates.sh
```

## Usage Examples

```bash
# Check pre-coding gate
/quality-gates pre-coding

# Validate before implementation
/quality-gates pre-implementation

# Post-implementation checks
/quality-gates post-implementation

# Final pre-commit validation
/quality-gates pre-commit

# Check all gates
/quality-gates all
```

## Enforcement

**⚠️ IMPORTANT:** Attempting to skip gates will trigger:
1. Immediate work stoppage
2. Artifact purge
3. Full workflow restart
4. Violation logged to `.scarlett/violations.log`

Quality > Speed. Always.
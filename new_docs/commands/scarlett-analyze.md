# SCARLETT Deep Analysis Protocol

Execute the mandatory SCARLETT Phase 1 & 2 analysis before any implementation work.

## Command: /scarlett-analyze [problem-description]

## Phase 1: Deep Understanding (MANDATORY)

### Required Actions
1. **Ingest All Relevant Files**
   ```bash
   # Map entire codebase structure
   find . -type f -name "*.php" -o -name "*.js" -o -name "*.blade.php" | head -50
   
   # Analyze dependencies
   composer show --tree
   npm list --depth=2
   ```

2. **Generate System Architecture Map**
   - Create visual representation of components
   - Document data flow
   - Map API endpoints to controllers
   - Trace Livewire component interactions

3. **Root Cause Analysis**
   - Distinguish symptoms from causes
   - Identify affected components
   - Trace error propagation paths
   - Document hypothesis

4. **Dependency Audit**
   ```bash
   # Check for vulnerabilities
   composer audit
   npm audit
   
   # Analyze coupling
   grep -r "use App\\" app/ | wc -l
   ```

### Exit Criteria Checklist
- [ ] All relevant files read and analyzed
- [ ] System architecture map generated
- [ ] Root cause hypothesis documented
- [ ] Dependencies and interactions documented

## Phase 2: Comprehensive Analysis

### Required Deliverables

1. **problem_definition.md**
   ```markdown
   # Problem Definition
   
   ## Symptom
   [What the user sees/experiences]
   
   ## Root Cause
   [Underlying technical issue]
   
   ## Affected Components
   - Component A: [impact]
   - Component B: [impact]
   
   ## Success Criteria
   - [ ] Criterion 1
   - [ ] Criterion 2
   ```

2. **system_interaction_map.md**
   ```markdown
   # System Interaction Map
   
   ## Request Flow
   User → Route → Controller → Service → Model → Database
   
   ## Component Dependencies
   - Converter.php depends on:
     - TransformationEngine
     - CategoryRepository
   ```

3. **dependency_report.json**
   ```json
   {
     "internal_dependencies": {},
     "external_dependencies": {},
     "circular_dependencies": [],
     "vulnerability_scan": {}
   }
   ```

4. **impact_assessment.md**
   ```markdown
   # Impact Assessment
   
   ## Direct Impact
   - Files to modify: []
   - Tests to update: []
   
   ## Indirect Impact
   - Related features: []
   - Performance implications: []
   ```

5. **risk_matrix.csv**
   ```csv
   Risk,Probability,Impact,Mitigation
   Breaking changes,Medium,High,Feature flag
   Performance degradation,Low,Medium,Benchmark tests
   ```

### Analysis Tools

```bash
# Code complexity analysis
php artisan code:analyze --complexity

# Dependency visualization
composer show --tree > dependencies.txt

# Performance profiling
php artisan debugbar:clear
# Run operation
php artisan debugbar:analyze

# Security scanning
./vendor/bin/security-checker security:check
```

## Violation Protocol

**IF ATTEMPTING IMPLEMENTATION WITHOUT COMPLETING ANALYSIS:**
```
⚠️ SCARLETT VIOLATION DETECTED ⚠️
- Action: HALT
- Violation: Premature implementation attempt
- Resolution: Complete all analysis phases
- Status: RESTART REQUIRED
```

## Enforcement Tracking

Create `.scarlett/analysis/` directory with:
```bash
mkdir -p .scarlett/analysis
touch .scarlett/analysis/phase1_complete.flag
touch .scarlett/analysis/phase2_complete.flag
```

## Example Usage

```bash
# Start analysis for a bug
/scarlett-analyze Converter component not updating after text input

# Start analysis for a feature
/scarlett-analyze Add real-time collaboration feature

# Start analysis for optimization
/scarlett-analyze Improve transformation performance for large texts
```

## Quality Gates

Before proceeding to implementation:
1. ✅ Phase 1 Deep Understanding - COMPLETE
2. ✅ Phase 2 Comprehensive Analysis - COMPLETE
3. ✅ All deliverables generated
4. ✅ Risk assessment documented
5. ✅ Test strategy defined

Only after ALL gates pass can implementation begin.
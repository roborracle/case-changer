# Project Survey & Recommendations

Comprehensive project survey to determine current state and recommend next steps with specific commands.

## Command: /survey [aspect]

Aspects: all, health, development, deployment, security, performance

## Survey Process

### Phase 1: Project Health Check

```bash
#!/bin/bash
# survey-health.sh

echo "╔════════════════════════════════════════════╗"
echo "║         PROJECT HEALTH SURVEY              ║"
echo "╚════════════════════════════════════════════╝"

# Check git status
UNCOMMITTED=$(git status --porcelain | wc -l)
CURRENT_BRANCH=$(git branch --show-current)
BEHIND_MAIN=$(git rev-list --count HEAD..origin/main)

# Check test status
TESTS_PASS=$(php artisan test --quiet && echo "YES" || echo "NO")
TEST_COVERAGE=$(php artisan test --coverage --min=0 2>/dev/null | grep "Total Coverage" | awk '{print $3}')

# Check for errors
LARAVEL_ERRORS=$(tail -100 storage/logs/laravel.log 2>/dev/null | grep -c "ERROR\|CRITICAL")
CONSOLE_ERRORS=$(grep -c "console.error" storage/logs/*.log 2>/dev/null)

# Check dependencies
OUTDATED_COMPOSER=$(composer outdated --direct 2>/dev/null | wc -l)
OUTDATED_NPM=$(npm outdated 2>/dev/null | wc -l)
SECURITY_ISSUES_COMPOSER=$(composer audit 2>&1 | grep -c "advisories")
SECURITY_ISSUES_NPM=$(npm audit --json 2>/dev/null | jq '.metadata.vulnerabilities.total' 2>/dev/null)

# Check performance
RESPONSE_TIME=$(curl -o /dev/null -s -w "%{time_total}" http://localhost:8000)
BUILD_SIZE=$(du -sh public/build 2>/dev/null | cut -f1)
```

### Phase 2: Development State Analysis

```yaml
development_survey:
  scarlett_compliance:
    - analysis_phase_complete: CHECK
    - quality_gates_passed: CHECK
    - testing_requirements_met: CHECK
    - documentation_current: CHECK
    
  task_master_status:
    - active_tasks: COUNT
    - blocked_tasks: LIST
    - completion_rate: PERCENTAGE
    
  code_quality:
    - phpstan_errors: COUNT
    - eslint_warnings: COUNT
    - code_complexity: MEASURE
    - duplicate_code: DETECT
```

### Phase 3: Intelligent Recommendations

## Survey Report Template

```markdown
# PROJECT SURVEY REPORT
Generated: [timestamp]

## 🏥 HEALTH STATUS: [HEALTHY|WARNING|CRITICAL]

### Critical Issues (Fix Immediately)
❌ [Issue description]
   → Run: `/quick-fix [issue-type]`
   → Or: `[specific command]`

### Warnings (Fix Soon)
⚠️ [Warning description]
   → Run: `/[recommended-command]`

### Optimization Opportunities
💡 [Opportunity description]
   → Run: `/[optimization-command]`

## 📊 METRICS SUMMARY

| Metric | Current | Target | Status |
|--------|---------|---------|--------|
| Test Coverage | X% | 80% | ❌/✅ |
| Response Time | Xms | 200ms | ❌/✅ |
| Security Issues | X | 0 | ❌/✅ |
| Code Quality | X/10 | 8/10 | ❌/✅ |

## 🎯 RECOMMENDED ACTIONS

### Priority 1: Immediate Actions
1. [Action description]
   ```bash
   /command-to-run
   ```

2. [Action description]
   ```bash
   /another-command
   ```

### Priority 2: Short-term (This Week)
- [ ] Task description → `/command`
- [ ] Task description → `/command`

### Priority 3: Long-term Planning
- [ ] Strategic item → `/command`
```

## Intelligent Command Recommendations

### Scenario-Based Recommendations

```javascript
function recommendCommands(surveyResults) {
    const recommendations = [];
    
    // Git/Version Control Issues
    if (surveyResults.uncommitted_changes > 0) {
        recommendations.push({
            priority: 1,
            issue: "Uncommitted changes detected",
            commands: [
                "/git-workflow feature",
                "git add -p",
                "git commit -m 'type: description'"
            ]
        });
    }
    
    // Testing Issues
    if (surveyResults.test_coverage < 80) {
        recommendations.push({
            priority: 1,
            issue: `Test coverage is ${surveyResults.test_coverage}% (target: 80%)`,
            commands: [
                "/test-validation unit",
                "/use-agent test-writer-fixer",
                "php artisan test --coverage"
            ]
        });
    }
    
    // Quality Issues
    if (!surveyResults.scarlett_analysis_complete) {
        recommendations.push({
            priority: 1,
            issue: "SCARLETT analysis not complete",
            commands: [
                "/scarlett-analyze [current-task]",
                "/quality-gates pre-coding"
            ]
        });
    }
    
    // Performance Issues
    if (surveyResults.response_time > 200) {
        recommendations.push({
            priority: 2,
            issue: "Response time exceeds target",
            commands: [
                "/performance-audit backend",
                "/orchestrate optimize transformation engine",
                "php artisan optimize"
            ]
        });
    }
    
    // Security Issues
    if (surveyResults.security_vulnerabilities > 0) {
        recommendations.push({
            priority: 1,
            issue: "Security vulnerabilities detected",
            commands: [
                "composer audit",
                "npm audit fix",
                "/quick-fix security"
            ]
        });
    }
    
    // Dependencies
    if (surveyResults.outdated_packages > 10) {
        recommendations.push({
            priority: 3,
            issue: "Multiple outdated packages",
            commands: [
                "composer update --dry-run",
                "npm update --dry-run",
                "/use-agent tool-evaluator"
            ]
        });
    }
    
    // Database Issues
    if (surveyResults.pending_migrations > 0) {
        recommendations.push({
            priority: 1,
            issue: "Pending database migrations",
            commands: [
                "php artisan migrate:status",
                "/database-refresh local",
                "php artisan migrate"
            ]
        });
    }
    
    // Documentation
    if (!surveyResults.documentation_current) {
        recommendations.push({
            priority: 3,
            issue: "Documentation needs updating",
            commands: [
                "/use-agent update documentation",
                "Update README.md",
                "Generate API docs"
            ]
        });
    }
    
    return recommendations;
}
```

## Quick Survey Commands

### Health Check Only
```bash
# Quick health check
echo "=== QUICK HEALTH CHECK ==="
php artisan about
php artisan test --quiet && echo "✅ Tests: PASS" || echo "❌ Tests: FAIL"
git status -sb
composer audit 2>&1 | grep "found" || echo "✅ Composer: Secure"
npm audit 2>/dev/null | grep "found" || echo "✅ NPM: Secure"
```

### Development Readiness
```bash
# Check if ready to code
echo "=== DEVELOPMENT READINESS ==="
[ -f ".scarlett/analysis/phase1_complete.flag" ] && echo "✅ Analysis: Complete" || echo "❌ Analysis: Incomplete"
[ -f ".scarlett/gates/gate1.pass" ] && echo "✅ Gate 1: Passed" || echo "❌ Gate 1: Not passed"
php artisan test --quiet && echo "✅ Tests: Passing" || echo "❌ Tests: Failing"
```

### Deployment Readiness
```bash
# Check if ready to deploy
echo "=== DEPLOYMENT READINESS ==="
/deploy-check
/quality-gates pre-commit
```

## Context-Aware Recommendations

### Based on Current Branch
```bash
BRANCH=$(git branch --show-current)

if [[ $BRANCH == feature/* ]]; then
    echo "📌 Feature Branch Recommendations:"
    echo "  1. Complete feature implementation"
    echo "     → /orchestrate complete feature"
    echo "  2. Write tests"
    echo "     → /test-validation all"
    echo "  3. Create PR"
    echo "     → /git-workflow create-pr"
    
elif [[ $BRANCH == hotfix/* ]]; then
    echo "🔥 Hotfix Branch Recommendations:"
    echo "  1. Fix and test immediately"
    echo "     → /quick-fix [issue]"
    echo "  2. Deploy to production"
    echo "     → /deploy-check"
fi
```

### Based on Time of Day
```bash
HOUR=$(date +%H)

if [ $HOUR -lt 10 ]; then
    echo "🌅 Morning Recommendations:"
    echo "  1. Review overnight issues"
    echo "     → /analyze-logs"
    echo "  2. Pull latest changes"
    echo "     → git pull origin main"
    echo "  3. Start fresh environment"
    echo "     → /fresh-start"
    
elif [ $HOUR -gt 17 ]; then
    echo "🌆 End of Day Recommendations:"
    echo "  1. Commit current work"
    echo "     → /git-workflow commit"
    echo "  2. Update task status"
    echo "     → task-master list"
    echo "  3. Document progress"
    echo "     → task-master update-subtask"
fi
```

### Based on Task Master Status
```bash
# Check active tasks
NEXT_TASK=$(task-master next 2>/dev/null)

if [ ! -z "$NEXT_TASK" ]; then
    echo "📋 Task Recommendations:"
    echo "  Current task: $NEXT_TASK"
    echo "  1. Analyze task requirements"
    echo "     → /scarlett-analyze task"
    echo "  2. Implement solution"
    echo "     → /use-agent task-executor"
    echo "  3. Validate implementation"
    echo "     → /test-validation all"
fi
```

## Survey Automation

### Scheduled Survey (Add to crontab)
```bash
# Daily morning survey
0 9 * * * /path/to/project/.claude/scripts/morning-survey.sh

# Weekly comprehensive survey  
0 10 * * 1 /path/to/project/.claude/scripts/weekly-survey.sh
```

### Git Hook Survey
```bash
#!/bin/sh
# .git/hooks/post-checkout
# Run survey when switching branches

echo "Running project survey..."
/survey quick

if [ $? -ne 0 ]; then
    echo "⚠️ Issues detected. Run '/survey all' for details"
fi
```

## Usage Examples

```bash
# Complete survey with recommendations
/survey all

# Quick health check
/survey health

# Development readiness check
/survey development

# Deployment readiness check
/survey deployment

# Security-focused survey
/survey security

# Performance-focused survey
/survey performance

# Get recommendations only
/survey recommend
```

## Survey Output Actions

After survey completes, it will:
1. Generate comprehensive report
2. List prioritized recommendations
3. Provide exact commands to run
4. Save results to `.scarlett/surveys/[timestamp].md`
5. Compare with previous survey for trends
6. Alert on critical issues

The survey adapts recommendations based on:
- Current project state
- Active development phase
- Detected issues
- Time of day
- Git branch context
- Task Master status
- Previous survey results
# Comprehensive Code Review

Perform a thorough code review using multiple specialized agents to ensure quality, security, and best practices.

## Command: /code-review [file-or-feature]

## Review Process

### Phase 1: Multi-Agent Analysis
Deploy these agents concurrently for different aspects:

1. **backend-architect** - Review architecture and design patterns
2. **test-writer-fixer** - Check test coverage and quality
3. **ui-designer** - Review UI consistency and accessibility
4. **tool-evaluator** - Assess library usage and dependencies
5. **devops-automator** - Review deployment and infrastructure code

### Phase 2: Specific Checks

#### Laravel/PHP Review
- PSR standards compliance
- Security vulnerabilities (SQL injection, XSS)
- Performance bottlenecks
- Proper use of Laravel features
- Database query optimization

#### Livewire Review
- Component lifecycle usage
- Wire directive efficiency
- Proper state management
- Security of public properties
- Event handling patterns

#### Frontend Review
- JavaScript best practices
- CSS organization (Tailwind classes)
- Accessibility compliance
- Performance optimizations
- Cross-browser compatibility

#### Security Review
- Input validation
- Authentication/authorization
- CSRF protection
- XSS prevention
- Sensitive data handling

### Phase 3: Generate Report

Create a comprehensive report with:
- Critical issues (must fix)
- Recommendations (should fix)
- Suggestions (nice to have)
- Performance metrics
- Test coverage gaps

## Example Usage

```bash
# Review specific file
/code-review app/Livewire/Converter.php

# Review entire feature
/code-review transformation-engine

# Review recent changes
/code-review git-diff

# Review before deployment
/code-review pre-deploy
```

## Automated Checks

Run these tools automatically:
```bash
# PHP checks
./vendor/bin/phpstan analyse
./vendor/bin/phpcs app/

# JavaScript checks
npm run lint

# Security audit
npm audit
composer audit
```

## Review Checklist

- [ ] Code follows project conventions
- [ ] No duplicated code
- [ ] Proper error handling
- [ ] Adequate logging
- [ ] Performance considered
- [ ] Security validated
- [ ] Tests written/updated
- [ ] Documentation updated
- [ ] Accessibility checked
- [ ] Mobile responsive
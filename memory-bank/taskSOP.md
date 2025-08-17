# Task Standard Operating Procedures (SOP)
**Project:** Case Changer - TALL Stack Implementation
**Created:** 2025-01-16
**SCARLETT Protocol Version:** 1.0

## 🎯 Core Directive

**THE-MOST-IMPORTANT-RULE:** ALWAYS think carefully and deliberately. ALWAYS prioritize quality and security over speed or quick responses - NO SHORTCUTS. Address ONLY the assigned task, not symptoms. Find the minimal, elegant solution. No quick fixes, shortcuts, or scope creep. Quality over speed.

## 📋 Problem Analysis Requirements

### Pre-Implementation Checklist (MANDATORY)
Before ANY implementation, ALL of the following MUST be completed:

#### 1. Root Cause Analysis
- [ ] What is the ACTUAL problem vs symptoms?
- [ ] Has the core issue been identified?
- [ ] Are we solving the right problem?
- **Current Task:** Building text transformation system from scratch
- **Root Problem:** Need comprehensive text case/style conversion tool

#### 2. Requirements Decomposition
- [ ] Functional requirements documented?
- [ ] Non-functional requirements identified?
- [ ] Edge cases considered?
- [ ] User stories validated?
- **Reference:** See projectbrief.md for complete requirements

#### 3. Constraint Identification
- [ ] Technical constraints identified?
- [ ] Business constraints understood?
- [ ] Performance requirements defined?
- [ ] Security requirements specified?
- **Key Constraints:**
  - Must handle large text inputs (up to 100KB)
  - Real-time transformation (<100ms response)
  - Browser compatibility (last 2 versions)
  - WCAG 2.1 AA accessibility

#### 4. Dependency Mapping
- [ ] External libraries identified?
- [ ] API dependencies documented?
- [ ] System dependencies verified?
- [ ] Version compatibility checked?
- **Dependencies:**
  - Laravel 11.x
  - Livewire 3.x
  - Tailwind CSS 3.x
  - Alpine.js 3.x
  - PHP 8.2+

#### 5. Failure Mode Analysis
- [ ] Potential failure points identified?
- [ ] Error handling strategy defined?
- [ ] Rollback procedures documented?
- [ ] Monitoring points established?
- **Critical Failure Points:**
  - Large text input handling
  - Unicode character processing
  - Style guide rule conflicts
  - Browser memory limits

#### 6. Architecture Considerations
- [ ] Design patterns selected?
- [ ] Component relationships mapped?
- [ ] Data flow documented?
- [ ] Integration points identified?
- **Architecture:** See systemPatterns.md for complete architecture

## 🔍 Implementation Requirements

### Logging and Validation Protocol
1. **Pre-Implementation Logging**
   ```php
   Log::info('Starting implementation', [
       'task' => $taskName,
       'assumptions' => $assumptions,
       'constraints' => $constraints
   ]);
   ```

2. **Assumption Validation**
   - Add debug logs before each major decision
   - Validate inputs at every boundary
   - Log state changes explicitly

3. **Early Issue Detection**
   - Monitor logs during implementation
   - Set up error boundaries
   - Implement circuit breakers for external calls

### Code Implementation Standards
```php
/**
 * SCARLETT Documentation Standard
 * Purpose: [Clear description]
 * Assumptions: [List all assumptions]
 * Constraints: [Technical/business constraints]
 * Failure Modes: [How this can fail]
 * @param type $param Description
 * @return type Description
 * @throws Exception When/why
 */
```

## ✅ Solution Validation Requirements

### Browser Validation Protocol (MANDATORY)
Every task MUST conclude with:

1. **Cache Clearing**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   npm run build
   ```

2. **Browser Testing**
   - [ ] Open in Chrome DevTools
   - [ ] Check Console for errors
   - [ ] Verify Network tab for failed requests
   - [ ] Test in Firefox for cross-browser compatibility
   - [ ] Mobile responsive testing

3. **Log Inspection**
   - [ ] Check Laravel logs: `storage/logs/laravel.log`
   - [ ] Review browser console logs
   - [ ] Verify no JavaScript errors
   - [ ] Check for performance warnings

4. **Functional Validation**
   - [ ] All features work as specified
   - [ ] Edge cases handled properly
   - [ ] Error messages display correctly
   - [ ] Data persists as expected

## 📝 Task Structure Template

```markdown
# Task: [Task Name]
**Date:** YYYY-MM-DD
**Session:** [Session ID]
**Status:** Planning | In Progress | Blocked | Complete

## Problem Analysis
### Root Cause
[Actual problem identification]

### Requirements
- Functional: [List]
- Non-functional: [List]

### Constraints
- Technical: [List]
- Business: [List]

### Dependencies
- External: [List]
- Internal: [List]

### Failure Modes
- [Potential failure]: [Mitigation]

## Implementation Plan
1. [Step with validation criteria]
2. [Step with validation criteria]
3. [Step with validation criteria]

## Progress Tracking
- [ ] Problem analysis complete
- [ ] Implementation started
- [ ] Unit tests passing
- [ ] Integration tests passing
- [ ] Browser validation complete
- [ ] Logs inspected and clean
- [ ] Documentation updated

## Validation Results
- Browser tested: ✅/❌
- Console errors: None/[List]
- Log errors: None/[List]
- Performance: [Metrics]
```

## 🚨 Critical Rules

### Non-Negotiable Requirements
1. **NEVER** implement without completing problem analysis
2. **NEVER** skip browser validation
3. **NEVER** ignore console or log errors
4. **NEVER** modify existing production functions (use Non-Destructive Extension Pattern)
5. **ALWAYS** document before coding
6. **ALWAYS** validate assumptions with logs
7. **ALWAYS** test with real data, never mocked

### Non-Destructive Extension Pattern
```php
// NEVER modify existing function
public function existingFunction() { /* original */ }

// CREATE new extended function
public function existingFunctionExtended() {
    $result = $this->existingFunction();
    // Add new logic here
    return $enhancedResult;
}
```

## 🔄 Workflow Phases

### Phase 1: Planning
1. Read ALL Memory Bank files
2. Complete problem analysis checklist
3. Create implementation plan
4. Get user validation
5. Document approach in activeContext.md

### Phase 2: Implementation
1. Set up logging points
2. Implement in small, testable chunks
3. Validate each chunk with logs
4. Run tests after each component
5. Update progress.md after each step

### Phase 3: Validation
1. Clear all caches
2. Build production assets
3. Open browser DevTools
4. Test all functionality
5. Inspect all logs
6. Document validation results

### Phase 4: Handoff
1. Update all Memory Bank files
2. Document any unresolved issues
3. Create clear next steps
4. Ensure another developer can continue

## 📊 Progress Indicators

During implementation, display progress as:
```
[### 25%] Task: Setting up Livewire components
[### 50%] Task: Implementing text transformations
[### 75%] Task: Adding style guide formatters
[### 100%] Task: Browser validation complete
```

Update every 30 seconds if step is long-running.

## 🔴 Error Handling Protocol

When errors occur:
1. **STOP** immediately
2. Document error in progress.md:
   ```markdown
   ## Error Encountered
   **Time:** [Timestamp]
   **Component:** [Where it occurred]
   **Error:** [Exact message]
   **Context:** [What was being attempted]
   **Stack Trace:** [If applicable]
   **Attempted Solutions:** [What was tried]
   **Status:** Resolved/Pending
   ```
3. Analyze if continuing creates more problems
4. Present options to user
5. Wait for user confirmation before proceeding

## 📚 Reference Documents

- **Requirements:** memory-bank/projectbrief.md
- **User Context:** memory-bank/productContext.md
- **Architecture:** memory-bank/systemPatterns.md
- **Technical Setup:** memory-bank/techContext.md
- **Current Work:** memory-bank/activeContext.md
- **Progress Log:** memory-bank/progress.md

## 🎯 Success Criteria

Task is complete when:
- [ ] All problem analysis items checked
- [ ] Implementation matches requirements exactly
- [ ] Browser validation shows no errors
- [ ] All logs are clean
- [ ] Documentation is complete
- [ ] Another developer can continue without questions
- [ ] User confirms with "hell yeah, motherfucker"

## 🔒 Security Validation Checklist

Before ANY data handling:
- [ ] Input validation implemented
- [ ] XSS protection verified
- [ ] CSRF tokens in place
- [ ] SQL injection prevented
- [ ] Rate limiting configured
- [ ] Error messages don't leak system info

## 📈 Performance Validation

Required metrics:
- Text transformation: <100ms for 10KB input
- Page load: <2 seconds
- Memory usage: <50MB for typical session
- API response: <200ms

---

**Remember:** Quality over speed. Every shortcut creates technical debt. Document everything. Validate thoroughly. The next developer depends on your diligence.

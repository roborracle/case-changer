# CSP Recovery Plan: Complete Alpine.js Removal

## Mission Critical Tasks for All Agents

### ABSOLUTE RULES - VIOLATION = TERMINATION
1. **NO Alpine.js** - Not one directive, not one reference
2. **NO unsafe-eval** - Never in CSP headers
3. **NO unsafe-inline** - Never in CSP headers  
4. **NO client-side evaluation** - Everything server-side
5. **ALL transformations server-side** - PHP only, no JavaScript transformations

## Task List for Recovery

### Phase 1: Immediate CSP Header Fix ✅ COMPLETE
- [x] Remove 'unsafe-eval' from GenerateCspNonce.php
- [x] Ensure CSP headers are strict and correct

### Phase 2: Alpine.js Identification ✅ COMPLETE
- [x] Scan entire codebase for Alpine.js usage
- [x] Document all infected files
- [x] Count violations per file

### Phase 3: Core Layout Cleanup ✅ COMPLETE
- [x] Remove Alpine.js from app.blade.php
- [x] Remove Alpine stores
- [x] Remove Alpine component initialization
- [x] Delete keyboard-shortcuts.blade.php (fully Alpine-based)

### Phase 4: Component Migration 🔄 IN PROGRESS
- [x] Create Livewire ThemeToggle component
- [x] Remove Alpine theme-toggle.blade.php
- [ ] Convert converter.blade.php (55 Alpine directives)
- [ ] Remove all x-data directives
- [ ] Remove all x-show directives  
- [ ] Remove all x-on directives
- [ ] Remove all :class bindings
- [ ] Remove all @click handlers

### Phase 5: Feature Rewrites - PENDING
Each feature must be rewritten server-side:

#### 5.1 Tab System
- [ ] Create Livewire property for activeTab
- [ ] Use wire:click for tab switching
- [ ] Use PHP conditionals for active state
- [ ] Remove all Alpine tab logic

#### 5.2 Style Guide Selector
- [ ] Move selection to Livewire property
- [ ] Use wire:click for selection
- [ ] Handle state server-side
- [ ] Remove Alpine style guide component

#### 5.3 Copy Functionality
- [ ] Implement copy via Livewire method
- [ ] Use wire:click for copy button
- [ ] Flash message via Livewire
- [ ] Remove Alpine copy handlers

#### 5.4 Input/Output Management
- [ ] Handle via Livewire properties
- [ ] Clear via wire:click
- [ ] Transform via wire:click
- [ ] Remove all Alpine input handlers

#### 5.5 History Panel
- [ ] Implement as Livewire component
- [ ] Server-side session storage
- [ ] Wire:click for interactions
- [ ] Remove Alpine history component

### Phase 6: Validation & Testing - PENDING
- [ ] Clear all view caches
- [ ] Clear browser cache
- [ ] Test every page for CSP violations
- [ ] Verify console has ZERO violations
- [ ] Run full test suite
- [ ] Fix any tests that expect violations

### Phase 7: Final Verification - PENDING
- [ ] Grep for any remaining Alpine references
- [ ] Verify no 'unsafe-eval' in codebase
- [ ] Verify no 'unsafe-inline' in codebase
- [ ] Check every blade file manually
- [ ] Document clean state

## Specific File Fixes Required

### Critical Files Needing Complete Rewrite
1. `/resources/views/livewire/converter.blade.php` - 55 violations
2. `/resources/views/components/primary-tabs.blade.php` - Tab system
3. `/resources/views/components/style-guide-selector.blade.php` - Style selector
4. `/resources/views/components/auto-resize-textarea.blade.php` - Textarea component

### Files Needing Cleanup
1. `/resources/views/conversions/category.blade.php`
2. `/resources/views/conversions/tool.blade.php`
3. `/resources/views/pages/*.blade.php` - All page templates
4. `/resources/views/errors/*.blade.php` - Error pages

### Files to Delete
1. All compiled views in `/storage/framework/views/`
2. Any Alpine.js related JavaScript files
3. Any component depending on Alpine.js

## Implementation Guidelines for Agents

### For Backend Developers
1. **Enhance Livewire Components**
   - Add all necessary properties
   - Implement all methods server-side
   - Handle all state transitions
   - No JavaScript logic

2. **Response Format**
   - Return JSON for API
   - Return Blade views for web
   - Use Livewire events for updates
   - Flash messages for notifications

### For Frontend Developers  
1. **Use Only These Directives**
   - `wire:click` - For clicks
   - `wire:model` - For binding
   - `wire:submit` - For forms
   - `@if/@else` - For conditionals
   - `@foreach` - For loops

2. **Forbidden Directives**
   - No `x-data`
   - No `x-show`
   - No `x-on`
   - No `:class`
   - No `@click`
   - No `Alpine.*`

### For All Agents
1. **Before Writing Code**
   - Check: Will this work without JavaScript?
   - Check: Is this server-side only?
   - Check: Zero CSP violations?

2. **After Writing Code**
   - Test in browser
   - Open console
   - Verify ZERO CSP violations
   - If any violations, START OVER

## Validation Checklist

### Per-File Validation
- [ ] No Alpine.js directives
- [ ] No inline event handlers
- [ ] No inline styles
- [ ] All interactions via wire:click
- [ ] All state via Livewire properties

### Global Validation
- [ ] CSP headers strict
- [ ] No 'unsafe-eval'
- [ ] No 'unsafe-inline'  
- [ ] Browser console clean
- [ ] All tests passing

## Success Criteria

### Minimum Acceptable State
1. **ZERO CSP violations** in browser console
2. **NO Alpine.js** anywhere in codebase
3. **ALL features working** via Livewire
4. **Clean git status** after fixes

### Verification Commands
```bash
# Check for Alpine.js
grep -r "x-data\|x-show\|x-on\|Alpine\|@click" resources/views/

# Check CSP headers
grep -r "unsafe-eval\|unsafe-inline" app/

# Clear caches
php artisan view:clear
php artisan cache:clear

# Test application
php artisan test
```

## Recovery Timeline

### Immediate (Now)
- CSP header fix ✅
- Alpine.js identification ✅
- Core layout cleanup ✅

### Short-term (Next 2 hours)
- Converter.blade.php rewrite
- Component migrations
- Feature rewrites

### Validation (Final hour)
- Complete testing
- Verification
- Documentation

## Agent Instructions

### EVERY Agent MUST:
1. **Read this document completely**
2. **Understand CSP requirements**
3. **Never add Alpine.js**
4. **Never add unsafe-eval**
5. **Test for violations**
6. **Fix any violations immediately**

### If You Don't Understand:
1. **ASK before implementing**
2. **Default to server-side**
3. **When in doubt, use Livewire**
4. **Never use Alpine.js**

## Final Warning

**This is not optional. This is not negotiable. This is the requirement.**

Any agent that adds Alpine.js or unsafe-eval will be considered to have failed catastrophically. There are no exceptions, no workarounds, and no compromises.

The application MUST be 100% CSP compliant with ZERO violations.

**Current Status:** RECOVERY IN PROGRESS - ALPINE.JS REMOVAL UNDERWAY
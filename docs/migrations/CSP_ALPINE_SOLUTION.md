# Alpine.js CSP-Compatible Solution (No unsafe-eval)

## The Problem & Solution

### The Problem
Alpine.js by default uses string evaluation when you write `x-data="componentName()"`. This triggers CSP violations because the string "componentName()" needs to be evaluated as JavaScript code.

### The Industry Solution
The Alpine.js community and other developers solve this by:
1. **Pre-registering components** with `Alpine.data()`
2. **Using string references** instead of function calls
3. **Avoiding inline JavaScript expressions** where possible

## How Other Frameworks Handle This

### 1. **Vue.js**
- Uses template compilation at build time
- No runtime eval needed

### 2. **React**
- JSX compiles to pure JavaScript
- No string evaluation

### 3. **Svelte**
- Compiles to vanilla JavaScript
- No runtime overhead

### 4. **Alpine.js (Our Solution)**
- Pre-register all components
- Use declarative references
- Leverage Alpine's CSP mode

## Implementation Pattern

### ❌ OLD WAY (Requires eval)
```html
<!-- This requires eval() to execute the function -->
<div x-data="navigationDropdown()">
    ...
</div>
```

### ✅ NEW WAY (CSP-Safe)
```html
<!-- This uses a simple string reference -->
<div x-data="navigationDropdown">
    ...
</div>
```

## The Key Files

### 1. Component Registration (`alpine-components.js`)
```javascript
// Register BEFORE Alpine starts
document.addEventListener('alpine:init', () => {
    Alpine.data('navigationDropdown', () => ({
        // Component logic here
    }));
});
```

### 2. Blade Templates
```blade
<!-- Use string names, not function calls -->
<div x-data="navigationDropdown">
    <button @click="toggle()">Menu</button>
</div>
```

### 3. CSP Header Configuration
```php
// No unsafe-eval needed!
"script-src" => [
    "'self'",
    "'nonce-{$nonce}'",
    "'strict-dynamic'"
    // NO 'unsafe-eval' required
]
```

## Why This Works

### Alpine.js Internal Mechanism
When Alpine encounters `x-data="componentName"`:
1. It looks up the pre-registered component by name
2. No string-to-code evaluation needed
3. The component function is already in memory

### Security Benefits
- **No eval()** - Eliminates string injection vectors
- **No Function()** - No dynamic code generation
- **Pre-compiled** - All code validated at build time
- **CSP Level 3** - Full compliance with strict CSP

## Common Patterns & Solutions

### 1. **Simple Components**
```javascript
Alpine.data('dropdown', () => ({
    open: false,
    toggle() { this.open = !this.open }
}));
```

### 2. **Components with Parameters**
```javascript
// Register a factory function
Alpine.data('modal', (initialOpen = false) => ({
    open: initialOpen,
    show() { this.open = true },
    hide() { this.open = false }
}));

// Use in template
<div x-data="modal">
```

### 3. **Persisted State**
```javascript
Alpine.data('settings', () => ({
    theme: Alpine.$persist('light').as('theme'),
    // Persistence works without eval
}));
```

### 4. **Global Stores**
```javascript
// Define store
Alpine.store('navigation', {
    menuOpen: false,
    toggle() { this.menuOpen = !this.menuOpen }
});

// Use in template
<div x-data @click="$store.navigation.toggle()">
```

## Migration Guide

### Step 1: Identify Function Calls
```bash
# Find all x-data with parentheses
grep -r 'x-data=".*()' resources/views/
```

### Step 2: Create Component File
```javascript
// resources/js/alpine-components.js
document.addEventListener('alpine:init', () => {
    // Register all components here
});
```

### Step 3: Update Templates
```diff
- <div x-data="component()">
+ <div x-data="component">
```

### Step 4: Import in app.js
```javascript
import './alpine-components';
```

### Step 5: Remove unsafe-eval from CSP
```php
// Remove this completely
'unsafe-eval'
```

## Testing CSP Compliance

### 1. Browser Console
- Should show NO CSP violations
- Alpine components should work normally

### 2. CSP Evaluator
```bash
# Test your CSP header
curl -I https://yoursite.com | grep Content-Security-Policy
```
Paste the header at: https://csp-evaluator.withgoogle.com/

### 3. Security Headers
Check at: https://securityheaders.com/

## Best Practices

### DO ✅
- Pre-register all Alpine components
- Use simple string references
- Keep component logic in JavaScript files
- Use Alpine stores for global state
- Test without unsafe-eval

### DON'T ❌
- Use function calls in x-data
- Write inline JavaScript in attributes
- Use eval() or new Function()
- Mix registration patterns
- Add unsafe-eval "just to make it work"

## Performance Benefits

### Faster Initialization
- Components pre-compiled
- No runtime parsing
- Reduced JavaScript overhead

### Better Caching
- Static JavaScript files
- CDN-friendly
- Browser can optimize

### Smaller Payload
- No eval() polyfills
- Cleaner HTML
- Reduced inline scripts

## Real-World Examples

### Laravel Breeze
Uses this exact pattern for Alpine components

### Tailwind UI
All Alpine examples use pre-registration

### Alpine.js Documentation
Recommends this pattern for CSP compliance

## Troubleshooting

### Component Not Found
```javascript
// Make sure it's registered BEFORE Alpine.start()
document.addEventListener('alpine:init', () => {
    Alpine.data('myComponent', () => ({}));
});
```

### Parameters Needed
```javascript
// Use initialization function
Alpine.data('component', (param = 'default') => ({
    value: param
}));
```

### Dynamic Components
```javascript
// Use x-data with object syntax
<div x-data="{ open: false }">
```

## Conclusion

This pattern is:
- **Secure** - No eval required
- **Standard** - Used by the Alpine community
- **Performant** - Better than eval
- **Maintainable** - Clear separation of concerns
- **CSP-Compliant** - Works with strictest policies

This is how professional Laravel/Alpine applications handle CSP requirements without compromising security or functionality.
# Alpine.js to Stimulus.js Migration Guide

## Why Migrate from Alpine.js to Stimulus.js?

### The CSP Problem with Alpine.js
Alpine.js requires `unsafe-eval` in your Content Security Policy because it:
- Uses `Function()` constructors to evaluate expressions in HTML attributes
- Creates `AsyncFunction` instances for every `@click`, `x-show`, `x-if` expression
- Cannot be made CSP-compliant without severely limiting functionality

### Stimulus.js Solution
Stimulus.js is **100% CSP-compliant** because it:
- Uses pre-defined controller classes (no runtime evaluation)
- Connects behavior through data attributes (no inline JavaScript)
- Follows progressive enhancement principles
- Works with standard DOM APIs

## Migration Patterns

### 1. Basic Component Structure

**Alpine.js (Requires unsafe-eval):**
```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Content</div>
</div>
```

**Stimulus.js (CSP-Safe):**
```html
<div data-controller="dropdown">
    <button data-action="click->dropdown#toggle">Toggle</button>
    <div data-dropdown-target="content" class="hidden">Content</div>
</div>
```

### 2. Navigation Dropdown

**Alpine.js:**
```html
<div x-data="navigationDropdown">
    <button @click="toggle()">Menu</button>
    <div x-show="open" @click.outside="close()">
        <!-- dropdown content -->
    </div>
</div>
```

**Stimulus.js:**
```html
<div data-controller="navigation-dropdown"
     data-action="click@window->navigation-dropdown#clickOutside">
    <button data-action="click->navigation-dropdown#toggle">Menu</button>
    <div data-navigation-dropdown-target="menu" class="hidden">
        <!-- dropdown content -->
    </div>
</div>
```

### 3. Text Converter

**Alpine.js:**
```html
<div x-data="textConverter">
    <textarea x-model="input" @input="convert()"></textarea>
    <select x-model="selectedTool" @change="convert()">
        <option value="uppercase">UPPERCASE</option>
    </select>
    <textarea x-text="output" readonly></textarea>
    <button @click="copyOutput()">Copy</button>
</div>
```

**Stimulus.js:**
```html
<div data-controller="text-converter">
    <textarea data-text-converter-target="input" 
              data-action="input->text-converter#convert"></textarea>
    <select data-text-converter-target="tool"
            data-action="change->text-converter#selectTool">
        <option value="uppercase">UPPERCASE</option>
    </select>
    <textarea data-text-converter-target="output" readonly></textarea>
    <button data-action="click->text-converter#copyOutput">Copy</button>
</div>
```

### 4. Theme Toggle

**Alpine.js:**
```html
<div x-data="themeToggle">
    <button @click="toggleMenu()">
        <span x-show="theme === 'light'">☀️</span>
        <span x-show="theme === 'dark'">🌙</span>
    </button>
    <div x-show="showMenu">
        <button @click="setTheme('light')">Light</button>
        <button @click="setTheme('dark')">Dark</button>
    </div>
</div>
```

**Stimulus.js:**
```html
<div data-controller="theme-toggle">
    <button data-action="click->theme-toggle#toggleMenu">
        <span data-theme-toggle-target="currentIcon">☀️</span>
    </button>
    <div data-theme-toggle-target="menu" class="hidden">
        <button data-action="click->theme-toggle#setTheme" 
                data-theme="light">Light</button>
        <button data-action="click->theme-toggle#setTheme" 
                data-theme="dark">Dark</button>
    </div>
</div>
```

## Key Differences

### Data Management

| Alpine.js | Stimulus.js |
|-----------|-------------|
| `x-data="{ count: 0 }"` | Properties in controller class |
| `x-model="value"` | Two-way binding via targets |
| `$persist()` | localStorage in controller |
| Reactive by default | Explicit updates needed |

### Event Handling

| Alpine.js | Stimulus.js |
|-----------|-------------|
| `@click="handler()"` | `data-action="click->controller#handler"` |
| `@click.outside` | `click@window->controller#clickOutside` |
| `@keydown.escape` | `keydown.escape@window->controller#escape` |
| Magic properties (`$el`, `$refs`) | Targets system |

### Conditionals & Loops

| Alpine.js | Stimulus.js |
|-----------|-------------|
| `x-show="condition"` | Toggle classes in controller |
| `x-if="condition"` | DOM manipulation in controller |
| `x-for="item in items"` | Generate HTML in controller |

## Migration Steps

### 1. Install Stimulus
```bash
npm install @hotwired/stimulus
```

### 2. Setup Stimulus Application
```javascript
// resources/js/stimulus-app.js
import { Application } from "@hotwired/stimulus"
import NavigationDropdownController from "./controllers/navigation_dropdown_controller"

window.Stimulus = Application.start()
Stimulus.register("navigation-dropdown", NavigationDropdownController)
```

### 3. Create Controllers
```javascript
// resources/js/controllers/navigation_dropdown_controller.js
import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["menu"]
    
    connect() {
        this.open = false
    }
    
    toggle() {
        this.open = !this.open
        this.updateMenu()
    }
    
    updateMenu() {
        if (this.hasMenuTarget) {
            this.menuTarget.classList.toggle('hidden', !this.open)
        }
    }
}
```

### 4. Update Vite Config
```javascript
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/stimulus-app.js'  // Use Stimulus instead of Alpine
            ],
            refresh: true,
        }),
    ],
});
```

### 5. Update Blade Templates
Replace Alpine directives with Stimulus data attributes throughout your templates.

### 6. Remove Alpine.js
```bash
npm uninstall alpinejs @alpinejs/persist
```

### 7. Update CSP Policy
Remove `unsafe-eval` from your Content Security Policy - it's no longer needed!

## Testing CSP Compliance

### 1. Strict CSP Test
```php
// Temporarily use very strict CSP for testing
"script-src" => ["'self'", "'nonce-{$nonce}'"],
```

### 2. Browser Console Check
- Open Developer Tools
- Look for CSP violations in Console
- With Stimulus.js, there should be ZERO violations

### 3. CSP Evaluator
Test your headers at: https://csp-evaluator.withgoogle.com/

## Benefits After Migration

✅ **Security**: No `unsafe-eval` required - true CSP Level 3 compliance  
✅ **Performance**: No runtime expression evaluation  
✅ **Debugging**: Standard JavaScript debugging tools work perfectly  
✅ **Type Safety**: Full TypeScript support if needed  
✅ **Testing**: Easy to unit test controller classes  
✅ **Future-Proof**: Following web standards and progressive enhancement  

## Common Gotchas

1. **No Reactive Data Binding**: Unlike Alpine's automatic reactivity, Stimulus requires explicit DOM updates
2. **More Verbose**: Stimulus requires more setup code but provides better structure
3. **Different Mental Model**: Think in terms of controllers and targets, not reactive data
4. **CSS Classes**: You'll manage showing/hiding elements with CSS classes rather than x-show

## Resources

- [Stimulus Documentation](https://stimulus.hotwired.dev/)
- [Stimulus Reference](https://stimulus.hotwired.dev/reference/controllers)
- [Stimulus Handbook](https://stimulus.hotwired.dev/handbook/introduction)
- [Migration Examples](https://github.com/hotwired/stimulus-examples)

## Conclusion

While Alpine.js offers a simpler syntax, its fundamental architecture makes it incompatible with strict Content Security Policies. Stimulus.js provides a robust, CSP-compliant alternative that maintains similar ease of use while ensuring your application meets modern security standards.

The migration requires some initial effort, but the security benefits and peace of mind are worth it - especially for applications handling sensitive data or requiring PCI-DSS compliance.
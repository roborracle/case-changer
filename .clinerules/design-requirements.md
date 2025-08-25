# Design Requirements - Case Changer Pro

## SCARLETT Design System Standards

### MANDATORY Color Consistency Requirements

**ALL design elements MUST use CSS custom properties - NO hardcoded colors permitted**

#### Primary Color Palette
```css
:root {
    --color-dark-purple: #2D1B3D;
    --color-dark-red: #8B2635;
    --color-orange-red: #D44B3A;
    --color-orange: #F39C12;
    --color-teal: #52C4B0;
    --color-blue: #3498DB;
    --color-light: #ECF0F1;
}
```

#### Semantic Color Assignments
```css
--color-primary: var(--color-teal);
--color-secondary: var(--color-blue);
--color-accent: var(--color-orange);
--color-warning: var(--color-orange-red);
--color-danger: var(--color-dark-red);
--color-text: var(--color-light);
--color-background: var(--color-dark-purple);
```

### MANDATORY CSS Class Requirements

**ALL elements MUST use BEM methodology with `.case-changer__` prefix**

#### Required Class Structure
- **Elements**: `.case-changer__[element-name]`
- **Modifiers**: `.case-changer__[element-name]--[modifier]`
- **States**: `.case-changer__[element-name]--[state]`

#### Examples
```css
.case-changer__title                    /* Header title */
.case-changer__transform-btn            /* Transform buttons */
.case-changer__transform-btn--code      /* Coding style modifier */
.case-changer__transform-btn--creative  /* Creative style modifier */
.case-changer__glass-container          /* Glassmorphic containers */
.case-changer__tooltip                  /* Tooltip wrapper */
.case-changer__tooltip-content          /* Tooltip content */
```

### MANDATORY Tooltip Requirements

**EVERY interactive element MUST have comprehensive tooltip documentation**

#### Tooltip Format Requirements
1. **Question Format**: "What is [Feature Name]?"
2. **NLP Description**: Comprehensive explanation in natural language
3. **Learn More Link**: "Learn more about [Feature Name]" linking to dedicated page

#### Tooltip Implementation
```html
<div class="case-changer__tooltip">
    <button class="case-changer__transform-btn">Feature Name</button>
    <div class="case-changer__tooltip-content">
        [Feature Name] is a [comprehensive description explaining what the feature does, how it works, and when to use it].
        <a href="#" class="case-changer__tooltip-link">Learn more about [Feature Name]</a>
    </div>
</div>
```

#### Required Tooltip Coverage
- **ALL transformation buttons** (60+ features)
- **ALL utility functions** (spaces, quotes, underscores)
- **ALL interface sections** (input, output, advanced options)
- **ALL action buttons** (copy, clear, transfer)

### MANDATORY Semantic HTML Requirements

**ALL pages MUST use proper semantic structure**

#### Required HTML Structure
```html
<body class="case-changer-body">
    <div class="case-changer__main-container">
        <header class="case-changer__header">
            <!-- Page header content -->
        </header>
        <main class="case-changer__main">
            <!-- Main application content -->
        </main>
        <footer class="case-changer__footer">
            <!-- Footer content -->
        </footer>
    </div>
</body>
```

### MANDATORY Glassmorphic Design Requirements

#### Glass Container System
```css
.case-changer__glass-container {
    background: var(--glass-bg);
    backdrop-filter: blur(25px) saturate(180%);
    -webkit-backdrop-filter: blur(25px) saturate(180%);
    border-radius: 24px;
    border: 1px solid var(--glass-border);
    box-shadow: var(--glass-shadow);
}
```

#### Floating Orb System
- **Four orbs minimum** with different sizes and colors
- **Parallax mouse tracking** for interactive effects
- **Blur effects** with `filter: blur(80px)`
- **Animation cycles** with staggered delays

### MANDATORY Layout Requirements

#### Full-Width Design
- **NO narrow constraints** - must use complete viewport width
- **Responsive grid system** adapting to screen sizes
- **Optimal space utilization** across all breakpoints

#### Workspace Layout
```css
.case-changer__workspace {
    display: grid;
    grid-template-columns: 0.8fr 1.2fr 0.8fr;
    gap: var(--space-xl);
    width: 100%;
}
```

### MANDATORY Typography Requirements

#### Font System
```css
--font-size-xs: 0.75rem;
--font-size-sm: 0.875rem;
--font-size-base: 1rem;
--font-size-lg: 1.125rem;
--font-size-xl: 1.25rem;
--font-size-2xl: 1.5rem;
--font-size-3xl: 1.875rem;
--font-size-4xl: 2.25rem;
--font-size-5xl: 3rem;
```

#### Header Typography
- **Title**: Clamp sizing with consistent color gradient
- **Gradient**: Uses ALL project colors in proper sequence
- **Text Effects**: Drop-shadow and text-shadow using consistent colors

### MANDATORY Spacing Requirements

#### Spacing Scale
```css
--space-xs: 0.25rem;
--space-sm: 0.5rem;
--space-md: 1rem;
--space-lg: 1.5rem;
--space-xl: 2rem;
--space-2xl: 3rem;
--space-3xl: 4rem;
```

### MANDATORY Animation Requirements

#### Required Animations
- **Floating orbs**: 30-second infinite cycles with rotation and scaling
- **Button interactions**: Ripple effects on click
- **Hover effects**: Transform and color transitions
- **Page load**: Fade-in-up animation for main container

### PROHIBITED Design Elements

#### NEVER USE
- ❌ Hardcoded colors (always use CSS custom properties)
- ❌ Inline styles (always use CSS classes)
- ❌ Non-semantic HTML elements
- ❌ Missing tooltips on interactive elements
- ❌ Inconsistent color schemes between sections
- ❌ Non-BEM class naming conventions

### Design Validation Checklist

Before considering ANY design complete:

- [ ] **Color Consistency**: Header matches body design perfectly
- [ ] **CSS Classes**: All elements use proper BEM methodology
- [ ] **Tooltips**: Every interactive element has comprehensive documentation
- [ ] **Semantic HTML**: Proper header/main/footer structure
- [ ] **Glass Effects**: Backdrop-filter and blur effects working
- [ ] **Responsive Layout**: Full-width design at all breakpoints
- [ ] **Typography**: Consistent font sizing and color gradients
- [ ] **Animations**: Floating orbs and button interactions functional
- [ ] **Asset Compilation**: Production build successful
- [ ] **Browser Validation**: Tested with zero console errors

### Critical Success Factors

1. **NO COLOR INCONSISTENCIES** - Header and body must use identical color system
2. **COMPLETE TOOLTIP COVERAGE** - Every feature must be documented
3. **SEMANTIC ACCESSIBILITY** - Proper HTML structure for all users
4. **VISUAL CONSISTENCY** - Same design language throughout application
5. **PERFORMANCE OPTIMIZATION** - Efficient CSS and smooth animations

## Enforcement

**ANY deviation from these requirements is considered a CRITICAL ERROR that must be immediately resolved following SCARLETT methodology:**

1. Root cause analysis
2. Requirements decomposition
3. Constraint identification
4. Dependency mapping
5. Failure mode analysis
6. Architecture considerations
7. Implementation
8. Browser validation

**Design is NOT complete until ALL requirements are verified working in browser with zero console errors.**
# Case Changer Pro - Tech Stack Documentation

## Core Technologies

### Backend
- **Framework**: Laravel 12.26.4
- **PHP Version**: 8.4.11
- **Database**: MySQL/SQLite
- **Cache**: File-based (configurable to Redis)
- **Queue**: Sync (configurable to Redis/Database)

### Frontend JavaScript Framework
- **Framework**: Stimulus.js 3.x
- **Why Stimulus**: 
  - CSP-compliant (no inline styles, no eval)
  - HTML-first approach
  - No virtual DOM
  - Works with server-rendered HTML
  - Lightweight and performant

### CSS Framework
- **Framework**: Tailwind CSS 3.x
- **Build Tool**: PostCSS
- **Approach**: Utility-first CSS
- **Theme**: Dark/Light mode support

### Build Tools
- **Bundler**: Vite 5.x
- **Package Manager**: npm
- **Assets**: Compiled to public/build/

## Security Configuration

### Content Security Policy (CSP)
**CRITICAL RULES**:
- **NO inline styles** without nonce
- **NO unsafe-inline** directives
- **NO unsafe-eval** directives
- **NO Alpine.js** (uses inline styles)

### CSP Headers
```
style-src 'self' 'nonce-{dynamic}' https://fonts.googleapis.com https://cdn.jsdelivr.net;
script-src 'self' 'nonce-{dynamic}' https://cdn.jsdelivr.net https://unpkg.com;
```

## File Structure

```
case-changer/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── ConversionController.php
│   │   └── Middleware/
│   │       └── ContentSecurityPolicy.php
│   ├── Services/
│   │   ├── TransformationService.php (210+ methods)
│   │   └── BaseTransformationService.php
│   ├── Traits/
│   │   ├── TransformationErrorHandling.php
│   │   └── TransformationValidation.php
│   └── Contracts/
│       └── TransformationInterface.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php (main layout)
│   │   └── conversions/
│   │       ├── index.blade.php (Stimulus-based)
│   │       ├── category.blade.php
│   │       └── tool.blade.php
│   ├── js/
│   │   ├── stimulus-app.js (main entry)
│   │   └── controllers/
│   │       ├── universal_converter_controller.js
│   │       ├── text_converter_controller.js
│   │       ├── navigation_dropdown_controller.js
│   │       └── theme_toggle_controller.js
│   └── css/
│       └── app.css (Tailwind imports)
└── public/
    └── build/ (compiled assets)
```

## JavaScript Architecture

### Stimulus Controllers
All interactive functionality uses Stimulus controllers:
- `universal-converter`: Main text transformation tool
- `text-converter`: Individual tool pages
- `navigation-dropdown`: Navigation menus
- `theme-toggle`: Dark/light mode switcher
- `copy-to-clipboard`: Copy functionality

### Data Attributes Pattern
```html
<div data-controller="universal-converter">
  <input data-universal-converter-target="input" 
         data-action="input->universal-converter#transform">
  <div data-universal-converter-target="output"></div>
</div>
```

## API Endpoints

### Transformation API
- **POST** `/api/transform`
  - Body: `{ text: string, transformation: string }`
  - Response: `{ success: boolean, result: string }`

## Development Commands

### Build Assets
```bash
npm run dev    # Development with HMR
npm run build  # Production build
```

### Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Serve Application
```bash
php artisan serve --port=8001
```

## Deployment Requirements

### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### Railway.app Specific
- Automatic HTTPS enforcement
- CSP headers configured in middleware
- Static assets served from /public/build/

## Critical Rules

1. **NEVER use inline styles** - Always use CSS classes
2. **NEVER use Alpine.js** - It creates inline styles
3. **NEVER add unsafe-* CSP directives**
4. **ALWAYS use Stimulus.js** for interactivity
5. **ALWAYS add nonce to any `<style>` tags**
6. **ALWAYS use type hints** in PHP methods
7. **ALWAYS validate and sanitize inputs**

## Testing Checklist

- [ ] All 210+ transformation tools work
- [ ] No CSP violations in browser console
- [ ] Dark/Light theme switching works
- [ ] Copy to clipboard functionality works
- [ ] No inline styles anywhere
- [ ] All Stimulus controllers load properly
- [ ] API endpoints return proper JSON
- [ ] Error handling displays user-friendly messages

## Performance Optimizations

- Vite bundles and minifies all assets
- Tailwind CSS purges unused styles
- Stimulus controllers are lazy-loaded
- No jQuery or heavy libraries
- Server-side rendering for SEO
- Efficient transformation algorithms

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- No IE11 support

---

**Last Updated**: December 2024
**Maintained By**: Case Changer Pro Team
# Case Changer Pro - Claude Code Context

## Project Overview
This is a Laravel-based text transformation application with 200+ conversion tools. The application is stateless, secure, and optimized for performance.

## Key Technologies
- **Laravel 11** - PHP framework
- **Livewire 3** - Reactive components (replaced Alpine.js for CSP compliance)
- **Tailwind CSS** - Utility-first CSS
- **Vite** - Build tool
- **Railway** - Deployment platform

## Important Files
- `app/Services/TransformationService.php` - Core transformation logic (210 methods)
- `app/Http/Controllers/TransformationController.php` - Main controller
- `app/Livewire/Converter.php` - Main converter component
- `resources/views/home.blade.php` - Homepage template
- `routes/web.php` - Route definitions

## Current State
- ✅ CSP-compliant (migrated from Alpine.js to Livewire)
- ✅ 210 transformations implemented
- ✅ Responsive design
- ✅ API endpoints working
- ✅ Security headers configured

## Development Guidelines
1. **NO inline styles** - Use Tailwind classes only
2. **CSP compliance** - No inline JavaScript
3. **Stateless design** - No data persistence
4. **Security first** - Validate and sanitize all inputs
5. **Test everything** - Unit and integration tests

## Common Commands
```bash
# Development
php artisan serve
npm run dev

# Testing
php artisan test
php test-transformations.php

# Production
npm run build
php artisan config:cache

# Clear caches
php artisan cache:clear
php artisan view:clear
```

## Task Management
Using Task Master for project management:
```bash
task-master list
task-master next
task-master show <id>
```

## Security Considerations
- CSRF protection enabled
- XSS prevention through output escaping
- Rate limiting configured
- CSP headers properly set
- Input validation on all endpoints

## Performance Targets
- Response time: <21ms
- Page load: <1 second
- API response: <200ms
- Handle 1000+ concurrent users
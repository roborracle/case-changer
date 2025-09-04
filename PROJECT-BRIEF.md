# Case Changer Pro - Project Brief

## Overview
Case Changer Pro is a comprehensive text transformation web application providing 200+ conversion tools for developers, writers, and content creators.

## Core Requirements

### Functional Requirements
- **172+ Text Transformation Tools** across 18 categories (as per PRD)
- **Stateless Architecture** - No data persistence
- **Real-time Processing** - Instant transformations
- **API Access** - RESTful API for all transformations
- **Mobile Responsive** - Works on all devices

### Technical Stack
- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Livewire (for reactivity), Tailwind CSS (styling)
- **Security**: CSP-compliant, XSS protection, CSRF tokens
- **Deployment**: Railway-ready, Nixpacks compatible
- **Performance**: Sub-21ms response times

### Security Requirements
- Content Security Policy (CSP) compliance
- XSS prevention through output escaping
- CSRF protection on all forms
- Rate limiting (60 req/min web, 30 req/min API)
- No data persistence (stateless)
- Input validation and sanitization

### Current Status
- ✅ 210 transformations implemented
- ✅ CSP-compliant with Livewire
- ✅ Basic transformations working
- ✅ Responsive design implemented
- ⚠️ Documentation needs updating
- ⚠️ Some test files need cleanup

## Project Structure
```
case-changer/
├── app/               # Laravel application
│   ├── Http/         # Controllers, Middleware
│   ├── Livewire/     # Livewire components
│   └── Services/     # Business logic
├── resources/        # Frontend resources
│   ├── views/        # Blade templates
│   ├── css/          # Stylesheets
│   └── js/           # JavaScript
├── public/           # Public assets
├── routes/           # Route definitions
├── .claude/          # Claude Code config
└── .taskmaster/      # Task management
```

## Key Files
- `app/Services/TransformationService.php` - Core transformation logic
- `app/Http/Controllers/TransformationController.php` - Main controller
- `resources/views/home.blade.php` - Main UI
- `.claude/CLAUDE.md` - Claude Code instructions
- `scripts/PRD.txt` - Original requirements

## Development Workflow
1. Use Claude Code for development
2. Task Master for project management
3. Git for version control
4. Laravel Artisan for tasks
5. npm/Vite for asset building

## Testing
- Unit tests for transformations
- Browser testing for UI
- API endpoint testing
- Security vulnerability testing

## Deployment
- Railway platform ready
- Environment-based configuration
- Automated builds via Nixpacks
- Zero-downtime deployments
# Dependency Versions Documentation
**Last Updated:** September 1, 2025

## Runtime Environments

| Component | Version | Status |
|-----------|---------|--------|
| **Node.js** | v24.5.0 | Latest Stable |
| **npm** | 11.5.1 | Latest Stable |
| **PHP** | 8.4.11 | Latest Stable |
| **Composer** | 2.8.6 | Latest Stable |

## Backend Dependencies (Composer)

### Production Dependencies
| Package | Version | Purpose |
|---------|---------|---------|
| **Laravel Framework** | ^12.0 | Core framework (Latest) |
| **Laravel Tinker** | ^2.10.1 | REPL for Laravel |
| **PHP** | ^8.2 | Minimum PHP version |

### Development Dependencies
| Package | Version | Purpose |
|---------|---------|---------|
| **fakerphp/faker** | ^1.23 | Fake data generation |
| **laravel/pail** | ^1.2.2 | Log viewer |
| **laravel/pint** | ^1.13 | Code style fixer |
| **laravel/sail** | ^1.41 | Docker development |
| **mockery/mockery** | ^1.6 | Testing mocks |
| **nunomaduro/collision** | ^8.6 | Error handling |
| **phpunit/phpunit** | ^11.5.3 | Testing framework |

## Frontend Dependencies (npm)

### Production Dependencies
| Package | Version | Purpose |
|---------|---------|---------|
| **Alpine.js** | ^3.14.9 | Reactive framework |
| **@alpinejs/persist** | ^3.14.9 | Alpine persistence plugin |

### Development Dependencies
| Package | Version | Purpose |
|---------|---------|---------|
| **Tailwind CSS** | ^3.4.7 | Utility-first CSS framework |
| **@tailwindcss/forms** | ^0.5.8 | Form styles plugin |
| **@tailwindcss/typography** | ^0.5.13 | Typography plugin |
| **Vite** | ^5.3.4 | Build tool |
| **Laravel Vite Plugin** | ^1.0.5 | Laravel integration |
| **PostCSS** | ^8.4.39 | CSS processing |
| **Autoprefixer** | ^10.4.19 | CSS vendor prefixes |
| **Axios** | ^1.7.2 | HTTP client |

## Version Notes

### Laravel 12
- Using the latest Laravel 12.x which was released in 2025
- Includes all latest security patches and performance improvements
- Native support for PHP 8.2+ features

### Tailwind CSS 3.4
- Latest v3 stable release
- Includes container queries, dynamic viewport units
- Enhanced performance with JIT compilation

### Alpine.js 3.14
- Latest stable version with persistence plugin
- Lightweight reactive framework ideal for Laravel
- No build step required for basic usage

### Vite 5.3
- Latest v5 stable (not v6 beta)
- Proven stability with Laravel projects
- Fast HMR and optimized production builds

## Removed Dependencies
The following were NOT installed as they're not needed for this project:
- **Livewire** - Not using server-side components
- **Vue/React** - Using Alpine.js instead
- **Sass/Less** - Using PostCSS with Tailwind

## Build Configuration

### Vite Configuration
```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

### PostCSS Configuration
```javascript
// postcss.config.js
export default {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
};
```

## Update Commands

To update all dependencies to latest stable versions:

```bash
# Update composer packages
composer update

# Update npm packages
npm update

# Or for major version updates
npm upgrade
```

## Verification Commands

```bash
# Check Laravel version
php artisan --version

# Check installed composer packages
composer show

# Check installed npm packages
npm list

# Check for outdated packages
composer outdated
npm outdated
```

## Security

All dependencies are at their latest stable versions with no known security vulnerabilities as of September 1, 2025.

Run security audits with:
```bash
# PHP packages
composer audit

# npm packages
npm audit
```
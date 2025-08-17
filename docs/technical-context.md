# Case Changer - Technical Context

## Technology Stack

### Backend
- **Framework:** Laravel 11.39.0
- **PHP Version:** 8.2+
- **Database:** SQLite
- **Real-time:** Livewire 3.x

### Frontend
- **CSS Framework:** Tailwind CSS v4.0
- **JavaScript:** Alpine.js 3.x
- **Build Tool:** Vite 7.1.2
- **PostCSS:** 8.4.49

### Development Tools
- **Package Manager:** npm 10.x
- **Composer:** 2.x
- **Testing:** PHPUnit 11.x

## Project Structure
```
case-changer/
├── app/
│   ├── Livewire/
│   │   └── CaseChanger.php    # Main transformation component
│   ├── Http/
│   └── Models/
├── resources/
│   ├── views/
│   │   ├── livewire/
│   │   │   └── case-changer.blade.php  # Component UI
│   │   └── layouts/
│   │       └── app.blade.php          # Main layout
│   ├── css/
│   │   └── app.css                    # Tailwind imports
│   └── js/
│       └── app.js                     # Alpine & Livewire
├── routes/
│   └── web.php                        # Application routes
├── public/
│   └── build/                         # Compiled assets
└── memory-bank/                       # Documentation
```

## Key Dependencies

### Composer Packages
- laravel/framework: ^11.39
- livewire/livewire: ^3.0
- laravel/tinker: ^2.10

### NPM Packages
- @tailwindcss/postcss: ^4.0.0-beta.4
- tailwindcss: ^4.0.0-beta.4
- alpinejs: ^3.14.8
- axios: ^1.7.9
- vite: ^7.0.0
- laravel-vite-plugin: ^1.0

## Configuration

### Environment Setup
```bash
# Development server
php artisan serve

# Asset compilation
npm run dev    # Development with HMR
npm run build  # Production build
```

### Cache Management
```bash
php artisan config:cache   # Configuration
php artisan route:cache    # Routes
php artisan view:cache     # Views
```

## API Endpoints
- `GET /case-changer` - Main application interface
- Livewire endpoints handled automatically

## Security Considerations
- CSRF protection enabled
- XSS prevention via Blade escaping
- Input sanitization in Livewire component
- No database writes in current implementation

## Performance Optimizations
- Server-side rendering with Livewire
- Lazy loading for advanced options
- Efficient string manipulation algorithms
- Production asset minification

## Browser Requirements
- ES6+ JavaScript support
- CSS Grid and Flexbox
- Clipboard API support
- Modern form controls
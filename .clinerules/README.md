# Case Changer Pro

A comprehensive, professional text transformation tool built with Laravel and Livewire. Convert text between 50+ case styles, format according to 16 professional style guides, and process text with advanced intelligent features.

## Features

### Core Text Transformations
- **Basic Cases**: lowercase, UPPERCASE, Title Case, Sentence case, camelCase, PascalCase, snake_case, CONSTANT_CASE, kebab-case, and more
- **Style Guides**: APA, MLA, Chicago, AP, Bluebook, AMA, NYT, Wikipedia, IEEE, Harvard, Vancouver, OSCOLA, Reuters, Bloomberg, Oxford, Cambridge
- **Advanced Features**: Smart quotes, space management, underscore conversion, preposition fixing

### Intelligent Processing
- Real-time text statistics (characters, words, sentences)
- Copy to clipboard functionality with fallbacks
- Responsive design for all devices
- Input validation and security measures
- UTF-8 support for international users

## Technology Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Livewire 3, Alpine.js, Tailwind CSS 3.4.17
- **Build Tools**: Vite, PostCSS
- **Database**: SQLite (development)
- **Testing**: PHPUnit

## Quick Start

```bash
# Clone repository
git clone https://github.com/yourusername/case-changer.git
cd case-changer

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate

# Start development servers
php artisan serve
npm run dev
```

## Usage

1. Navigate to `http://localhost:8000/case-changer`
2. Enter your text in the input field
3. Select your desired transformation
4. Copy the result with one click

## Architecture

Built with modern Laravel patterns:
- **Strategy Pattern** for text transformations
- **Livewire Components** for reactive UI
- **Service Layer** for business logic
- **Security First** approach with input validation

## Documentation

Complete documentation is available in the `/docs` directory:
- [Project Brief](docs/project-brief.md) - Features and requirements
- [Technical Context](docs/technical-context.md) - Technology stack and setup
- [Development Progress](docs/development-progress.md) - Implementation status
- [Architecture Decisions](docs/architecture-decisions.md) - Design patterns and decisions
- [Deployment Guide](docs/deployment-guide.md) - Production deployment

## Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
```

## Production Deployment

```bash
# Build production assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For questions or issues, please open an issue on GitHub or contact the development team.

---

**Built with ❤️ using Laravel, Livewire, and modern web technologies.**

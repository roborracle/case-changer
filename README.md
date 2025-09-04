# Case Changer Pro 🚀

A professional text transformation platform with 200+ conversion tools, built with Laravel and Livewire.

![Version](https://img.shields.io/badge/version-3.0.0-blue.svg)
![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-purple.svg)
![CSP](https://img.shields.io/badge/CSP-Compliant-success.svg)

## ✨ Features

### 200+ Text Transformation Tools
Comprehensive text conversion across 18 categories including:
- **Case Conversions** - UPPERCASE, lowercase, Title Case, camelCase, snake_case
- **Developer Formats** - PascalCase, kebab-case, dot.case, CONSTANT_CASE
- **Content Styles** - AP, NYT, Chicago, Guardian, BBC, Reuters
- **Academic Formats** - APA, MLA, Harvard, IEEE citations
- **Creative Formats** - Aesthetic, Bubble Text, Emoji Case
- **Technical Tools** - API docs, README, Markdown formatting
- **And many more...**

### Core Capabilities
- ⚡ **Real-time Processing** - Instant transformations
- 🔒 **Secure by Design** - CSP-compliant, XSS protected
- 📱 **Mobile Responsive** - Works on all devices
- 🚀 **High Performance** - Sub-21ms response times
- 🔌 **API Access** - RESTful API for integrations
- ♿ **Accessible** - WCAG 2.1 compliant

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer 2.x
- Node.js 18+
- npm or yarn

### Installation

```bash
# Clone repository
git clone https://github.com/yourusername/case-changer.git
cd case-changer

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Build assets
npm run build

# Start development server
php artisan serve
```

Visit `http://localhost:8000`

## 🛠️ Development

### Development Server
```bash
# Terminal 1 - Vite for HMR
npm run dev

# Terminal 2 - Laravel server
php artisan serve
```

### Building for Production
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Testing
```bash
# Run tests
php artisan test

# Test transformations
php test-transformations.php
```

## 📦 Deployment

### Railway Deployment
1. Connect GitHub repository
2. Set environment variables
3. Deploy with automatic builds

### Environment Variables
```env
APP_NAME="Case Changer Pro"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Security
SECURITY_HEADERS_ENABLED=true
CSP_ENABLED=true
RATE_LIMIT_PER_MINUTE=60
```

## 🔧 API Usage

### Transform Endpoint
```http
POST /api/transform
Content-Type: application/json

{
  "text": "Hello World",
  "transformation": "snake-case"
}
```

**Response:**
```json
{
  "output": "hello_world"
}
```

## 📚 Project Structure

```
case-changer/
├── app/
│   ├── Http/Controllers/    # Request handlers
│   ├── Livewire/            # Reactive components
│   └── Services/            # Business logic
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Styles
│   └── js/                  # Scripts
├── routes/                  # Route definitions
├── public/                  # Public assets
└── .claude/                 # Claude Code config
```

## 🔒 Security

- **CSP Compliant** - Strict Content Security Policy
- **XSS Protection** - Output escaping and sanitization
- **CSRF Protection** - Token validation on forms
- **Rate Limiting** - Request throttling
- **Input Validation** - Comprehensive validation
- **Stateless Design** - No data persistence

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing`)
3. Commit changes (`git commit -m 'Add feature'`)
4. Push branch (`git push origin feature/amazing`)
5. Open Pull Request

## 📝 License

MIT License - see [LICENSE](LICENSE) file

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com/)
- Reactive with [Livewire](https://livewire.laravel.com/)
- Styled with [Tailwind CSS](https://tailwindcss.com/)
- Icons by [Heroicons](https://heroicons.com/)

---

**Built with clean code principles and zero-tolerance for inline styles**
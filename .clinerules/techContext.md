# Technical Context

## Project: Case Changer Pro - Architectural Rebuild

## Core Technologies:
-   **PHP 8.x:** Primary backend language.
-   **Laravel 10.x:** Web application framework.
-   **Blade:** Templating engine for server-rendered UI.
-   **Composer:** PHP dependency management.
-   **NPM/Yarn:** Frontend asset management (for Vite).
-   **Vite:** Frontend build tool (for CSS/JS compilation).
-   **Tailwind CSS:** Utility-first CSS framework for styling.
-   **Git:** Version control.
-   **Railway:** Deployment platform.

## Development Environment Setup:
1.  **Clone Repository:** `git clone [repository-url]`
2.  **Install PHP Dependencies:** `composer install`
3.  **Install JavaScript Dependencies:** `npm install` (or `yarn install`)
4.  **Copy Environment File:** `cp .env.example .env`
5.  **Generate Application Key:** `php artisan key:generate`
6.  **Build Frontend Assets:** `npm run build` (or `yarn build`)
7.  **Start Local Server:** `php artisan serve --port=8000`

## Key Dependencies:
-   `laravel/framework`
-   `laravel/pint` (for code style)
-   `phpunit/phpunit` (for testing)
-   `spatie/laravel-ignition` (for error reporting)

## Architectural Decisions:
-   **Statelessness:** No server-side state for user interactions.
-   **Server-Side Rendering:** All UI is rendered by the server.
-   **Minimal JavaScript:** Only essential JavaScript (e.g., `bootstrap.js`) is used.
-   **No Database:** Application is purely computational; no data persistence.
-   **Middleware for Cross-Cutting Concerns:** Security, rate limiting, HTTPS handled by middleware.

## Future Considerations:
-   Full Unicode support for transformations (currently basic `strlen`, `ucfirst`, `ucwords` are byte-safe in PHP 8+ but more complex transformations might need `mb_` functions).
-   Dedicated NLP/style guide libraries for advanced journalistic/academic styles.
-   Client-side progressive enhancement for instant feedback (if complexity budget allows).

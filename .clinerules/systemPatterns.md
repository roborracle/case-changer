# System Patterns

## Project: Case Changer Pro - Architectural Rebuild

## Architecture: Stateless, Server-Rendered PHP

## Core Principles:
-   **Statelessness:** No server-side state persistence for user interactions. Each request is independent.
-   **Separation of Concerns:** Clear boundaries between presentation (Blade), control (Controller), and business logic (Service).
-   **Minimal JavaScript:** Client-side interactivity is limited to basic form submission and visual feedback, avoiding complex reactive frameworks.
-   **Testability:** Components are designed for isolated unit testing.

## Key Components:

### 1. `TransformationService.php`
-   **Role:** The single source of truth for all text transformation logic.
-   **Pattern:** Pure functions, no side effects, receives input, returns transformed output.
-   **Dependencies:** None (pure PHP functions).

### 2. `TransformationController.php`
-   **Role:** Handles HTTP requests (GET/POST for the homepage), orchestrates calls to `TransformationService`, and renders the `home.blade.php` view.
-   **Pattern:** Thin controller, delegates business logic, passes data to the view.
-   **Dependencies:** `TransformationService`, `Illuminate\Http\Request`.

### 3. `home.blade.php`
-   **Role:** The primary user interface for the universal text converter.
-   **Pattern:** Standard HTML form, server-rendered, displays input, output, and transformation options.
-   **Dependencies:** Data passed from `TransformationController` (`$input`, `$output`, `$transformations`, `$selectedTransformation`).

### 4. Routing (`routes/web.php`)
-   **Pattern:** Simple GET/POST routes for the homepage, directing to `TransformationController::transform`.
-   **Dependencies:** `TransformationController`.

### 5. Middleware
-   **Role:** Handles cross-cutting concerns like HTTPS enforcement (production), DDoS protection, security headers, and rate limiting.
-   **Pattern:** Standard Laravel middleware, configured in `bootstrap/app.php`.

## Data Flow:
1.  User accesses `http://127.0.0.1:8000` (GET request).
2.  `routes/web.php` directs to `TransformationController::transform`.
3.  `TransformationController` fetches available transformations from `TransformationService` and renders `home.blade.php` with initial empty data.
4.  User inputs text, selects a transformation, and clicks "Transform Text" (POST request).
5.  `routes/web.php` directs to `TransformationController::transform`.
6.  `TransformationController` validates input, calls `TransformationService::transform` with input text and selected transformation.
7.  `TransformationService` performs the transformation and returns the result.
8.  `TransformationController` re-renders `home.blade.php` with the original input, transformed output, and selected transformation.

## Design Decisions:
-   **Elimination of Livewire/Alpine.js:** Removed to resolve state management complexity, untestability, and performance issues.
-   **Server-Side Rendering:** Ensures predictability, simplifies debugging, and improves initial page load performance.
-   **Single Universal Converter:** Centralizes all 172 transformations into one accessible form, simplifying user experience and maintenance.
-   **Placeholder Style Implementations:** For complex style guides (e.g., AP Style), initial implementations return a prefixed title-cased string. Full implementation would require dedicated NLP/style guide libraries, which are outside the scope of this architectural rebuild.

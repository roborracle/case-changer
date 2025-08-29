# Template Audit

## Unique Blade Templates

- `resources/views/welcome.blade.php`
- `resources/views/conversions/index.blade.php`
- `resources/views/conversions/layout.blade.php`
- `resources/views/conversions/category.blade.php`
- `resources/views/conversions/tool.blade.php`
- `resources/views/qa/dashboard.blade.php`
- `resources/views/components/tool-grid-item.blade.php`
- `resources/views/components/navigation.blade.php`
- `resources/views/components/google-analytics.blade.php`
- `resources/views/components/navigation-alpine.blade.php`
- `resources/views/components/layouts/app.blade.php`
- `resources/views/components/footer.blade.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/hubs/show.blade.php`
- `resources/views/style-test.blade.php`
- `resources/views/home-grid.blade.php`
- `resources/views/sitemap.blade.php`
- `resources/views/legal/cookies.blade.php`
- `resources/views/legal/privacy.blade.php`
- `resources/views/legal/terms.blade.php`
- `resources/views/pages/faq.blade.php`
- `resources/views/pages/about.blade.php`
- `resources/views/pages/contact.blade.php`
- `resources/views/home.blade.php`
- `resources/views/test.blade.php`

## Template Usage

- **`layouts/app.blade.php`**: Main layout file.
- **`components/layouts/app.blade.php`**: Appears to be a duplicate or alternative layout.
- **`welcome.blade.php`**: Main entry point of the application.
- **`home-grid.blade.php`**: Renders the main grid of tools on the homepage.
- **`conversions/layout.blade.php`**: Layout for the conversion tool pages.
- **`conversions/index.blade.php`**: Displays the list of all conversion tools.
- **`conversions/category.blade.php`**: Displays the tools within a specific category.
- **`conversions/tool.blade.php`**: The main view for a single conversion tool.
- **`hubs/show.blade.php`**: Displays a content hub page.
- **`qa/dashboard.blade.php`**: The QA dashboard.
- **`style-test.blade.php` and `test.blade.php`**: Appear to be for testing purposes and should be removed.

## Inconsistencies

- There are two main layouts: `layouts/app.blade.php` and `components/layouts/app.blade.php`. This should be consolidated into a single layout file.
- The homepage is split between `welcome.blade.php` and `home-grid.blade.php`. This should be consolidated.
- The `conversions` directory has its own layout file, which is inconsistent with the rest of the application.
- The `style-test.blade.php` and `test.blade.php` files are not used in production and should be removed.

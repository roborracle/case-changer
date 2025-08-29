# Railway Environment Variables

This document outlines the required environment variables for deploying the Case Changer Pro application to Railway.

## Application

- `APP_NAME`: The name of the application (e.g., "Case Changer Pro")
- `APP_ENV`: The application environment (should be `production`)
- `APP_KEY`: A 32-character random string. Generate with `php artisan key:generate --show`
- `APP_DEBUG`: Should be `false` in production.
- `APP_URL`: The production URL of the application.

## Database (PostgreSQL)

- `DB_CONNECTION`: `pgsql`
- `DB_HOST`: `${{PostgreSQL.DB_HOST}}`
- `DB_PORT`: `${{PostgreSQL.DB_PORT}}`
- `DB_DATABASE`: `${{PostgreSQL.DB_DATABASE}}`
- `DB_USERNAME`: `${{PostgreSQL.DB_USER}}`
- `DB_PASSWORD`: `${{PostgreSQL.DB_PASSWORD}}`

## Cache (Redis)

- `CACHE_DRIVER`: `redis`
- `REDIS_HOST`: `${{Redis.REDIS_HOST}}`
- `REDIS_PORT`: `${{Redis.REDIS_PORT}}`
- `REDIS_PASSWORD`: `${{Redis.REDIS_PASSWORD}}`

## Security

- `FORCE_HTTPS`: `true`
- `SECURE_COOKIES`: `true`
- `SESSION_SECURE_COOKIE`: `true`

## Sentry

- `SENTRY_LARAVEL_DSN`: Your Sentry DSN.

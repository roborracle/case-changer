# Quick Fix for Common Issues

Quickly diagnose and fix the most common issues in the Case Changer Pro project.

## Command: /quick-fix [issue-type]

Issue types: csp, performance, 500-error, blank-page, transformation-fail, deployment

## Steps

1. Identify the issue type from user description
2. Run diagnostic commands
3. Apply the appropriate fix
4. Verify the fix worked

## Common Fixes

### CSP Violations
```bash
# Check for inline scripts
grep -r "<script>" resources/views/
# Rebuild assets with proper nonces
npm run build
php artisan view:clear
```

### 500 Errors
```bash
# Check logs
tail -50 storage/logs/laravel.log
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
# Check permissions
chmod -R 775 storage bootstrap/cache
```

### Transformation Not Working
```bash
# Test transformation directly
php scripts/verify-transformations.php
# Check Livewire component
php artisan livewire:discover
# Verify JavaScript build
npm run dev
```

### Blank Page
```bash
# Check PHP syntax
php -l app/Http/Controllers/*.php
# Check .env file
cat .env | grep APP_
# Enable debug mode temporarily
php artisan config:clear
```

### Performance Issues
```bash
# Check query performance
php artisan debugbar:clear
# Optimize autoloader
composer dump-autoload -o
# Cache routes and config
php artisan route:cache
php artisan config:cache
```

### Deployment Issues
```bash
# Production optimizations
php artisan optimize
npm run build
# Check Railway logs
railway logs
```
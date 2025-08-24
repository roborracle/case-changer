# Railway Deployment Checklist for Case Changer Pro

## Pre-Deployment Verification

### 1. Environment Variables (CRITICAL)
Ensure these environment variables are set in Railway:

```env
# Application Settings
APP_NAME="Case Changer Pro"
APP_ENV=production
APP_KEY=[your-app-key]
APP_DEBUG=false
APP_URL=${RAILWAY_PUBLIC_DOMAIN}

# Session & Cache (MUST USE THESE VALUES)
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

CACHE_STORE=array

# Database (In-memory only for framework)
DB_CONNECTION=sqlite
DB_DATABASE=:memory:

# Logging
LOG_CHANNEL=stderr
LOG_LEVEL=error

# Filesystem (Disabled)
FILESYSTEM_DISK=null

# Broadcasting & Queue
BROADCAST_CONNECTION=null
QUEUE_CONNECTION=sync
```

### 2. Build Configuration (nixpacks.toml)
Verify nixpacks.toml contains:
- ✅ NPM build command for Vite assets
- ✅ Composer install with --optimize-autoloader
- ✅ Laravel cache commands (config, routes, views)
- ✅ NO database migrations (no database!)

### 3. Code Verification

#### Livewire Components
All Livewire components MUST use getter methods for services:
- ❌ WRONG: `protected TransformationService $service;`
- ✅ RIGHT: `protected function getTransformationService(): TransformationService`

#### File Operations
- ✅ HistoryService: Persistence disabled in production (line 68)
- ✅ Logging: Using stderr, not file-based
- ✅ Sessions: Using cookies, not files
- ✅ Cache: Using array driver, not files

### 4. Proxy Configuration
- ✅ public/index.php: Railway proxy detection before Request::capture()
- ✅ bootstrap/app.php: Trust all proxies with `$middleware->trustProxies(at: '*')`
- ✅ ForceHttps middleware: Handles X-Forwarded-Proto header

## Deployment Steps

### 1. Final Local Verification
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Build assets
npm run build

# Test with production-like settings
APP_ENV=production php artisan serve
```

### 2. Git Commit
```bash
git add .
git commit -m "Railway deployment configuration - stateless, no database"
git push origin production
```

### 3. Railway Deployment
1. Push to production branch triggers deployment
2. Monitor build logs for:
   - NPM build success
   - Composer install success
   - Cache generation success
3. Check runtime logs for any 500 errors

### 4. Post-Deployment Verification

#### Test Core Functionality
1. **Homepage Load**: Should display without 500 error
2. **Universal Converter**: Should auto-convert text as you type
3. **All Case Tools**: Should work without debounce delay
4. **Category Pages**: Should load and convert properly
5. **No Persistence Tests**: 
   - History should NOT persist between page reloads
   - Preferences should NOT persist
   - All state should be request-scoped

#### Monitor Logs
Check Railway logs for:
- ❌ File write attempts
- ❌ Database connection errors
- ❌ Session file errors
- ❌ Cache file errors
- ✅ Clean stderr output only

## Common Issues & Solutions

### Issue: 500 Error on Homepage
**Cause**: Livewire serialization failure
**Solution**: Ensure all components use getter methods for services

### Issue: Text Not Auto-Converting
**Cause**: Debounce delay or wire:model configuration
**Solution**: Remove `.debounce` modifier from wire:model

### Issue: Session Errors
**Cause**: File-based sessions on ephemeral filesystem
**Solution**: Use SESSION_DRIVER=cookie

### Issue: Cache Errors
**Cause**: File-based cache on ephemeral filesystem
**Solution**: Use CACHE_STORE=array

### Issue: HTTPS Redirect Loop
**Cause**: Proxy configuration issue
**Solution**: Check public/index.php proxy detection

## Production Principles

### What This App IS:
- ✅ A stateless text converter
- ✅ A single-page tool
- ✅ Request-scoped processing
- ✅ Client-side state only

### What This App IS NOT:
- ❌ A database-driven application
- ❌ A user account system
- ❌ A data persistence platform
- ❌ A file storage service

## Emergency Rollback

If deployment fails:
1. Revert to previous deployment in Railway dashboard
2. Check environment variables haven't changed
3. Verify nixpacks.toml is present
4. Ensure git branch is clean

## Success Criteria

Deployment is successful when:
- ✅ All pages load without 500 errors
- ✅ All converters work instantly
- ✅ No file/database errors in logs
- ✅ HTTPS works correctly
- ✅ Performance is acceptable (<2s page load)

---

**Remember**: This is a SIMPLE TEXT CONVERTER. Don't over-engineer it!
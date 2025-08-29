# RAILWAY ENVIRONMENT VARIABLES - MUST SET THESE!

## CRITICAL - MUST SET IN RAILWAY DASHBOARD

### 1. APPLICATION BASICS
```
APP_NAME=Case Changer Pro
APP_ENV=production
APP_KEY=base64:CFGY5k5e/EloHx5JRmec7HU8V3jE6mbVH1eWn7cpxGE=
APP_DEBUG=false
APP_URL=https://casechangerpro.com
```

### 2. DATABASE (Use Railway's PostgreSQL)
```
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}
DATABASE_URL=${{Postgres.DATABASE_URL}}
```

### 3. LOGGING
```
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

### 4. SESSION & CACHE
```
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
CACHE_STORE=array
CACHE_PREFIX=
```

### 5. ADDITIONAL
```
BROADCAST_CONNECTION=log
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
```

## HOW TO ADD IN RAILWAY:

1. Go to your Railway project
2. Click on your service (case-changer)
3. Go to "Variables" tab
4. Click "Add Variable"
5. Copy-paste each line above
6. For PostgreSQL variables, use Railway's reference variables (with ${{...}} syntax)

## VERIFICATION CHECKLIST:

- [ ] APP_KEY is set (REQUIRED or app won't start)
- [ ] DB_CONNECTION is set to 'pgsql' (not sqlite)
- [ ] PostgreSQL service is added to Railway project
- [ ] All DB_* variables use Railway's PostgreSQL references
- [ ] APP_ENV is 'production'
- [ ] APP_DEBUG is 'false'
- [ ] LOG_CHANNEL is 'stderr' (for Railway logs)

## COMMON MISTAKES:

1. **Not setting APP_KEY** - Laravel won't start without this
2. **Using sqlite in production** - Data won't persist
3. **Not adding PostgreSQL service** - Database won't connect
4. **APP_DEBUG=true** - Exposes sensitive info
5. **Wrong PHP version** - We need PHP 8.2+
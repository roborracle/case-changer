# Deployment Guide - Case Changer

## Prerequisites
- PHP 8.2 or higher
- Composer 2.x
- Node.js 18+ and npm
- Web server (Apache/Nginx)
- SQLite support

## Production Deployment Steps

### 1. Clone Repository
```bash
git clone [repository-url] case-changer
cd case-changer
```

### 2. Install Dependencies
```bash
# PHP dependencies
composer install --optimize-autoloader --no-dev

# Node dependencies
npm ci
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure environment variables
nano .env
```

Required `.env` settings:
```env
APP_NAME="Case Changer"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### 4. Database Setup
```bash
# Create SQLite database
touch database/database.sqlite

# Run migrations
php artisan migrate --force
```

### 5. Build Assets
```bash
# Production build
npm run build

# Verify build output
ls -la public/build/
```

### 6. Optimize Application
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache  

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### 7. File Permissions
```bash
# Storage and cache directories
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# SQLite database
chmod 664 database/database.sqlite
chown www-data:www-data database/database.sqlite
```

### 8. Web Server Configuration

#### Nginx Configuration
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/case-changer/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Apache Configuration
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/case-changer/public

    <Directory /path/to/case-changer/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 9. SSL Configuration
```bash
# Using Certbot for Let's Encrypt
certbot --nginx -d yourdomain.com
# or
certbot --apache -d yourdomain.com
```

### 10. Health Checks
```bash
# Verify application key
php artisan key:display

# Check configuration
php artisan config:show app

# Test routes
php artisan route:list

# Verify Livewire
php artisan livewire:discover
```

## Maintenance

### Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Update Application
```bash
# Pull latest changes
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm ci

# Rebuild assets
npm run build

# Run migrations if any
php artisan migrate --force

# Re-cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Monitoring

### Application Logs
```bash
tail -f storage/logs/laravel.log
```

### Performance Monitoring
- Monitor response times < 200ms
- Check memory usage < 128MB
- Verify CPU usage < 50%

### Health Endpoint
Access `/case-changer` and verify:
- Page loads successfully
- All transformations work
- Copy to clipboard functions
- Statistics update in real-time

## Backup Strategy

### Daily Backups
```bash
# Backup database
cp database/database.sqlite backups/db-$(date +%Y%m%d).sqlite

# Backup .env file
cp .env backups/env-$(date +%Y%m%d)

# Backup storage
tar -czf backups/storage-$(date +%Y%m%d).tar.gz storage/
```

## Troubleshooting

### Common Issues

1. **500 Error**
   - Check storage permissions
   - Verify .env file exists
   - Review error logs

2. **Livewire not working**
   - Clear view cache
   - Check CSRF token
   - Verify APP_URL matches actual URL

3. **Assets not loading**
   - Run `npm run build`
   - Check public/build directory
   - Verify manifest.json exists

4. **Slow performance**
   - Enable opcache
   - Increase PHP memory_limit
   - Cache all configurations

## Security Checklist
- [ ] APP_DEBUG=false in production
- [ ] HTTPS enabled
- [ ] File permissions correct
- [ ] Database not web-accessible
- [ ] Error reporting disabled
- [ ] CORS configured if needed
- [ ] Rate limiting enabled
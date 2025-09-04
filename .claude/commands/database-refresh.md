# Database Refresh and Seed

Safely refresh the database with fresh migrations and seed data.

## Command: /database-refresh [environment]

Environments: local, staging, testing

## Safety Checks

### Pre-Refresh Validation
1. Confirm environment is NOT production
2. Create database backup if needed
3. Check for uncommitted changes
4. Verify migration files are valid

## Refresh Process

### Step 1: Backup Current Data (Optional)
```bash
# Export current database
php artisan db:backup

# Or manually with mysqldump
mysqldump -u root -p case_changer > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Step 2: Fresh Migration
```bash
# Drop all tables and re-run migrations
php artisan migrate:fresh

# With seed data
php artisan migrate:fresh --seed

# Specific seeder
php artisan migrate:fresh --seeder=TransformationSeeder
```

### Step 3: Seed Data

#### Development Seeds
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=TransformationSeeder
php artisan db:seed --class=CategorySeeder

# Generate test data
php artisan db:seed --class=TestDataSeeder
```

#### Production Seeds
```bash
# Only essential data
php artisan db:seed --class=ProductionSeeder
```

### Step 4: Verify Data
```bash
# Check database state
php artisan tinker
>>> \App\Models\Transformation::count()
>>> \App\Models\Category::count()

# Test transformations
php scripts/verify-transformations.php
```

## Quick Commands

### Full Reset (Local Only)
```bash
# Complete refresh with all test data
php artisan migrate:fresh --seed && \
php artisan cache:clear && \
php artisan config:clear

echo "✅ Database refreshed with seed data"
```

### Minimal Reset
```bash
# Fresh migrations only
php artisan migrate:fresh

echo "✅ Database structure reset (no data)"
```

### Add Test Data
```bash
# Add sample data without migration
php artisan db:seed --class=TestDataSeeder

echo "✅ Test data added"
```

## Transformation Categories Seed

Ensure all transformation categories are seeded:
- Text Case (UPPERCASE, lowercase, Title Case, etc.)
- Text Style (Reverse, Mirror, Aesthetic, etc.)  
- Developer Tools (JSON, Base64, URL encode, etc.)
- Typography (Subscript, Superscript, etc.)
- International (Cyrillic, Greek, Arabic, etc.)
- Fun & Creative (Emoji, Zalgo, Bubble text, etc.)

## Post-Refresh Tasks

- [ ] Clear all caches
- [ ] Restart queue workers
- [ ] Update search index
- [ ] Verify API endpoints
- [ ] Test user authentication
- [ ] Check file uploads directory
- [ ] Verify transformation engine

## Troubleshooting

### Migration Errors
```bash
# Check migration status
php artisan migrate:status

# Rollback if needed
php artisan migrate:rollback

# Fix and retry
php artisan migrate
```

### Seeding Errors
```bash
# Verbose output
php artisan db:seed -vvv

# Skip specific seeder
php artisan db:seed --except=ProblematicSeeder
```

### Connection Issues
```bash
# Test database connection
php artisan db:show

# Clear config cache
php artisan config:clear
```
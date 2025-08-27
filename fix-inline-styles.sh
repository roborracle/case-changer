#!/bin/bash

# Fix all inline styles that are breaking the theme system
# These hardcoded colors override CSS variables and prevent proper theming

echo "Fixing inline styles in all blade templates..."

# Remove all inline background styles that use hardcoded colors
find resources/views -name "*.blade.php" -type f -exec sed -i '' \
    -e 's/ style="background: rgba([^)]*)[^"]*"//g' \
    -e 's/ style="background-color: rgba([^)]*)[^"]*"//g' \
    {} \;

# Remove problematic inline styles but keep var() based ones
find resources/views -name "*.blade.php" -type f -exec sed -i '' \
    -e 's/style="background: rgba(15,23,42,0.95); color: white;"//g' \
    {} \;

echo "Fixed inline styles. Rebuilding assets..."

# Rebuild assets
npm run build

# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize:clear

echo "Done! All inline styles fixed and caches cleared."
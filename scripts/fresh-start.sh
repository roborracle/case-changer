#!/bin/bash

# ============================================
# FRESH START SCRIPT
# Complete reset and rebuild of the application
# ============================================

echo ""
echo "╔════════════════════════════════════════════════════════╗"
echo "║              🔄 FRESH START SCRIPT                      ║"
echo "║     Clearing caches, rebuilding assets, restarting     ║"
echo "╔════════════════════════════════════════════════════════╗"
echo ""

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored status
print_status() {
    echo -e "${BLUE}🔧 $1${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

# ============================================
# 1. KILL RUNNING PROCESSES
# ============================================
echo "═══ 1. STOPPING RUNNING PROCESSES ═══"

print_status "Killing PHP artisan serve processes..."
# Find and kill all php artisan serve processes
if pgrep -f "artisan serve" > /dev/null; then
    pkill -f "artisan serve"
    print_success "Killed all artisan serve processes"
else
    print_warning "No artisan serve processes found"
fi

print_status "Killing npm/node dev processes..."
# Kill any vite or npm dev processes
if pgrep -f "vite" > /dev/null; then
    pkill -f "vite"
    print_success "Killed vite processes"
else
    print_warning "No vite processes found"
fi

echo ""

# ============================================
# 2. CLEAR ALL CACHES
# ============================================
echo "═══ 2. CLEARING ALL CACHES ═══"

print_status "Clearing Laravel application cache..."
php artisan cache:clear
print_success "Application cache cleared"

print_status "Clearing configuration cache..."
php artisan config:clear
print_success "Configuration cache cleared"

print_status "Clearing route cache..."
php artisan route:clear
print_success "Route cache cleared"

print_status "Clearing view cache..."
php artisan view:clear
print_success "View cache cleared"

print_status "Clearing all optimizations..."
php artisan optimize:clear
print_success "All optimizations cleared"

echo ""

# ============================================
# 3. CLEAN BUILD ARTIFACTS
# ============================================
echo "═══ 3. CLEANING BUILD ARTIFACTS ═══"

print_status "Removing old build files..."
if [ -d "public/build" ]; then
    rm -rf public/build
    print_success "Removed public/build directory"
else
    print_warning "No public/build directory found"
fi

if [ -f "public/hot" ]; then
    rm -f public/hot
    print_success "Removed hot reload file"
fi

print_status "Clearing storage caches..."
# Clear framework caches
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
print_success "Storage caches cleared"

print_status "Clearing bootstrap cache..."
# Clear bootstrap cache except .gitignore
find bootstrap/cache -type f ! -name '.gitignore' -delete 2>/dev/null
print_success "Bootstrap cache cleared"

echo ""

# ============================================
# 4. REBUILD NODE DEPENDENCIES AND ASSETS
# ============================================
echo "═══ 4. REBUILDING ASSETS ═══"

print_status "Checking Node.js and npm..."
node_version=$(node -v 2>/dev/null)
npm_version=$(npm -v 2>/dev/null)

if [ -z "$node_version" ]; then
    print_error "Node.js is not installed!"
    exit 1
else
    print_success "Node.js $node_version detected"
fi

if [ -z "$npm_version" ]; then
    print_error "npm is not installed!"
    exit 1
else
    print_success "npm $npm_version detected"
fi

print_status "Installing Node dependencies (clean install)..."
npm ci
if [ $? -eq 0 ]; then
    print_success "Node dependencies installed"
else
    print_warning "npm ci failed, trying npm install..."
    npm install
    if [ $? -eq 0 ]; then
        print_success "Node dependencies installed with npm install"
    else
        print_error "Failed to install Node dependencies"
        exit 1
    fi
fi

print_status "Building production assets..."
npm run build
if [ $? -eq 0 ]; then
    print_success "Assets built successfully"
else
    print_error "Asset build failed"
    exit 1
fi

echo ""

# ============================================
# 5. OPTIMIZE LARAVEL
# ============================================
echo "═══ 5. OPTIMIZING LARAVEL ═══"

print_status "Caching configuration..."
php artisan config:cache
print_success "Configuration cached"

print_status "Caching routes..."
php artisan route:cache
print_success "Routes cached"

print_status "Caching views..."
php artisan view:cache
print_success "Views cached"

print_status "Running Laravel optimize..."
php artisan optimize
print_success "Laravel optimized"

echo ""

# ============================================
# 6. START FRESH DEVELOPMENT SERVER
# ============================================
echo "═══ 6. STARTING DEVELOPMENT SERVER ═══"

print_status "Starting Laravel development server..."
# Start server in background and capture output
php artisan serve > /tmp/artisan-serve.log 2>&1 &
SERVER_PID=$!

# Wait a moment for server to start
sleep 2

# Check if server started successfully
if kill -0 $SERVER_PID 2>/dev/null; then
    # Extract the port from the log
    PORT=$(grep -o "http://[0-9.]*:[0-9]*" /tmp/artisan-serve.log | grep -o ":[0-9]*" | tr -d ':' | head -1)
    if [ -z "$PORT" ]; then
        PORT="8000"  # Default port
    fi
    
    print_success "Laravel server started on http://localhost:$PORT (PID: $SERVER_PID)"
    
    # Save PID for future reference
    echo $SERVER_PID > .artisan-serve.pid
else
    print_error "Failed to start Laravel server"
    cat /tmp/artisan-serve.log
fi

echo ""

# ============================================
# 7. VERIFY EVERYTHING IS WORKING
# ============================================
echo "═══ 7. VERIFICATION ═══"

print_status "Waiting for server to be ready..."
sleep 2

print_status "Testing server response..."
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:$PORT 2>/dev/null)

if [ "$HTTP_STATUS" = "200" ]; then
    print_success "Server is responding (HTTP $HTTP_STATUS)"
else
    print_warning "Server returned HTTP $HTTP_STATUS"
fi

print_status "Checking if assets are compiled..."
if [ -f "public/build/manifest.json" ]; then
    print_success "Build manifest found"
else
    print_error "Build manifest not found"
fi

if [ -d "public/build/assets" ]; then
    CSS_COUNT=$(ls -1 public/build/assets/*.css 2>/dev/null | wc -l)
    JS_COUNT=$(ls -1 public/build/assets/*.js 2>/dev/null | wc -l)
    print_success "Found $CSS_COUNT CSS and $JS_COUNT JS files"
else
    print_error "No build assets found"
fi

echo ""

# ============================================
# 8. OPEN IN BROWSER
# ============================================
echo "═══ 8. OPENING IN BROWSER ═══"

print_status "Opening application in browser for visual inspection..."

# Detect OS and open browser accordingly
if [[ "$OSTYPE" == "darwin"* ]]; then
    # macOS
    open "http://localhost:$PORT"
    print_success "Opened in default browser (macOS)"
elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
    # Linux
    if command -v xdg-open > /dev/null; then
        xdg-open "http://localhost:$PORT"
        print_success "Opened in default browser (Linux)"
    elif command -v gnome-open > /dev/null; then
        gnome-open "http://localhost:$PORT"
        print_success "Opened in default browser (Linux)"
    else
        print_warning "Could not auto-open browser on Linux"
    fi
elif [[ "$OSTYPE" == "cygwin" ]] || [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "win32" ]]; then
    # Windows
    start "http://localhost:$PORT"
    print_success "Opened in default browser (Windows)"
else
    print_warning "Unknown OS - please open http://localhost:$PORT manually"
fi

echo ""

# ============================================
# FINAL REPORT
# ============================================
echo "╔════════════════════════════════════════════════════════╗"
echo "║                   ✨ FRESH START COMPLETE              ║"
echo "╔════════════════════════════════════════════════════════╗"
echo ""
print_success "All caches cleared"
print_success "Assets rebuilt"
print_success "Laravel optimized"
print_success "Server running on http://localhost:$PORT"
print_success "Browser opened for visual inspection"
echo ""
echo "Next steps:"
echo "  • Check the browser for visual inspection"
echo "  • Test transformations to ensure functionality"
echo "  • Run 'npm run dev' in another terminal for hot reload"
echo "  • Run 'php scripts/ui-validation.php' for full validation"
echo ""
echo "To stop the server: kill $SERVER_PID"
echo "Or use: pkill -f 'artisan serve'"
echo ""
echo "═══════════════════════════════════════════════════════════"
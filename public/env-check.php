<?php
// Comprehensive environment check
header('Content-Type: text/plain');

echo "=== RAILWAY ENVIRONMENT CHECK ===\n\n";

// Check various ways environment variables might be set
echo "1. ENV VARIABLES (getenv):\n";
echo "   APP_KEY: " . (getenv('APP_KEY') ?: 'NOT SET') . "\n";
echo "   APP_ENV: " . (getenv('APP_ENV') ?: 'NOT SET') . "\n";
echo "   DB_CONNECTION: " . (getenv('DB_CONNECTION') ?: 'NOT SET') . "\n";
echo "   DB_DATABASE: " . (getenv('DB_DATABASE') ?: 'NOT SET') . "\n";
echo "   SESSION_DRIVER: " . (getenv('SESSION_DRIVER') ?: 'NOT SET') . "\n";
echo "   CACHE_STORE: " . (getenv('CACHE_STORE') ?: 'NOT SET') . "\n\n";

echo "2. SERVER VARIABLES (\$_SERVER):\n";
echo "   APP_KEY: " . ($_SERVER['APP_KEY'] ?? 'NOT SET') . "\n";
echo "   APP_ENV: " . ($_SERVER['APP_ENV'] ?? 'NOT SET') . "\n";
echo "   DB_CONNECTION: " . ($_SERVER['DB_CONNECTION'] ?? 'NOT SET') . "\n";
echo "   DB_DATABASE: " . ($_SERVER['DB_DATABASE'] ?? 'NOT SET') . "\n";
echo "   SESSION_DRIVER: " . ($_SERVER['SESSION_DRIVER'] ?? 'NOT SET') . "\n";
echo "   CACHE_STORE: " . ($_SERVER['CACHE_STORE'] ?? 'NOT SET') . "\n\n";

echo "3. ENV VARIABLES (\$_ENV):\n";
echo "   APP_KEY: " . ($_ENV['APP_KEY'] ?? 'NOT SET') . "\n";
echo "   APP_ENV: " . ($_ENV['APP_ENV'] ?? 'NOT SET') . "\n";
echo "   DB_CONNECTION: " . ($_ENV['DB_CONNECTION'] ?? 'NOT SET') . "\n";
echo "   DB_DATABASE: " . ($_ENV['DB_DATABASE'] ?? 'NOT SET') . "\n";
echo "   SESSION_DRIVER: " . ($_ENV['SESSION_DRIVER'] ?? 'NOT SET') . "\n";
echo "   CACHE_STORE: " . ($_ENV['CACHE_STORE'] ?? 'NOT SET') . "\n\n";

echo "4. .env FILE CHECK:\n";
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    echo "   .env file EXISTS\n";
    $envContent = file_get_contents($envFile);
    // Show first few lines to check what's being used
    $lines = explode("\n", $envContent);
    echo "   First 5 lines:\n";
    for ($i = 0; $i < min(5, count($lines)); $i++) {
        // Mask the APP_KEY value for security
        $line = $lines[$i];
        if (strpos($line, 'APP_KEY=') === 0) {
            $line = 'APP_KEY=[MASKED]';
        }
        echo "     " . $line . "\n";
    }
} else {
    echo "   .env file DOES NOT EXIST\n";
}

echo "\n5. RAILWAY SPECIFIC:\n";
echo "   RAILWAY_ENVIRONMENT: " . (getenv('RAILWAY_ENVIRONMENT') ?: 'NOT SET') . "\n";
echo "   PORT: " . (getenv('PORT') ?: 'NOT SET') . "\n";

echo "\n=== END CHECK ===\n";
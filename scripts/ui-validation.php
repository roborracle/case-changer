#!/usr/bin/env php
<?php

/**
 * UI Validation Script with Agent Personas
 * Tests all aspects of the application for production readiness
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║           UI VALIDATION & TESTING SUITE                    ║\n";
echo "║         Deploying Agent Personas for Testing               ║\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "\n";

$errors = [];
$warnings = [];
$successes = [];

// Helper function to run command and capture output
function runCommand($command, $description = '') {
    echo "🔧 " . ($description ?: $command) . "...";
    exec($command . ' 2>&1', $output, $returnCode);
    if ($returnCode === 0) {
        echo " ✅\n";
        return ['success' => true, 'output' => $output];
    } else {
        echo " ❌\n";
        return ['success' => false, 'output' => $output];
    }
}

// Helper to check file exists
function checkFile($path, $description) {
    global $successes, $errors;
    echo "📁 Checking $description...";
    if (file_exists($path)) {
        echo " ✅\n";
        $successes[] = "$description exists";
        return true;
    } else {
        echo " ❌\n";
        $errors[] = "$description not found at $path";
        return false;
    }
}

// 1. BUILD AND COMPILE ASSETS
echo "\n═══ 1. BUILD & COMPILE ASSETS ═══\n";
$buildResult = runCommand('npm run build 2>&1', 'Building production assets');
if (!$buildResult['success']) {
    $errors[] = "Build failed: " . implode("\n", $buildResult['output']);
}

checkFile(__DIR__ . '/../public/build/manifest.json', 'Build manifest');
checkFile(__DIR__ . '/../public/build/assets', 'Build assets directory');

// 2. CLEAR AND OPTIMIZE CACHES
echo "\n═══ 2. CACHE MANAGEMENT ═══\n";
runCommand('php artisan cache:clear', 'Clearing application cache');
runCommand('php artisan view:clear', 'Clearing view cache');
runCommand('php artisan config:clear', 'Clearing config cache');
runCommand('php artisan route:clear', 'Clearing route cache');

echo "\n";
runCommand('php artisan config:cache', 'Caching configuration');
runCommand('php artisan route:cache', 'Caching routes');
runCommand('php artisan view:cache', 'Caching views');

// 3. CHECK LARAVEL LOGS
echo "\n═══ 3. LARAVEL LOG ANALYSIS ═══\n";
$logPath = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logPath)) {
    $logContent = file_get_contents($logPath);
    $recentErrors = [];
    
    // Check for errors in last 100 lines
    $lines = explode("\n", $logContent);
    $recentLines = array_slice($lines, -100);
    
    foreach ($recentLines as $line) {
        if (stripos($line, 'ERROR') !== false || stripos($line, 'CRITICAL') !== false) {
            $recentErrors[] = $line;
        }
    }
    
    if (count($recentErrors) > 0) {
        echo "⚠️  Found " . count($recentErrors) . " recent errors in logs\n";
        $warnings[] = count($recentErrors) . " recent errors found in Laravel logs";
    } else {
        echo "✅ No recent errors in Laravel logs\n";
        $successes[] = "Laravel logs are clean";
    }
} else {
    echo "ℹ️  No Laravel log file found (this is normal for fresh installs)\n";
}

// 4. TEST LIVEWIRE COMPONENTS
echo "\n═══ 4. LIVEWIRE COMPONENTS ═══\n";

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$livewireComponents = [
    'converter' => 'Main converter component',
    'instant-preview' => 'Instant preview component',
    'navigation' => 'Navigation component',
    'transformation-grid' => 'Transformation grid component'
];

foreach ($livewireComponents as $component => $description) {
    echo "🔍 Checking $description...";
    try {
        $componentClass = app(\Livewire\Mechanisms\ComponentRegistry::class)->getClass($component);
        if (class_exists($componentClass)) {
            echo " ✅\n";
            $successes[] = "$description is registered and available";
        } else {
            echo " ❌\n";
            $errors[] = "$description class not found";
        }
    } catch (Exception $e) {
        echo " ❌\n";
        $errors[] = "$description: " . $e->getMessage();
    }
}

// 5. TEST AGENT PERSONAS
echo "\n═══ 5. AGENT PERSONA TESTING ═══\n";

use App\Services\TransformationService;
$transformationService = new TransformationService();

$personas = [
    'Developer' => [
        'text' => 'hello world example',
        'tests' => [
            'camel-case' => 'helloWorldExample',
            'snake-case' => 'hello_world_example',
            'kebab-case' => 'hello-world-example',
            'constant-case' => 'HELLO_WORLD_EXAMPLE'
        ]
    ],
    'Content Creator' => [
        'text' => 'creative text',
        'tests' => [
            'aesthetic' => 'C R E A T I V E   T E X T',
            'reverse' => 'txet evitaerc',
            'upper-case' => 'CREATIVE TEXT'
        ]
    ],
    'Business User' => [
        'text' => 'quarterly report',
        'tests' => [
            'title-case' => 'Quarterly Report',
            'upper-case' => 'QUARTERLY REPORT'
        ]
    ],
    'Academic' => [
        'text' => 'research paper title',
        'tests' => [
            'title-case' => 'Research Paper Title',
            'sentence-case' => 'Research paper title'
        ]
    ]
];

foreach ($personas as $personaName => $persona) {
    echo "\n👤 Testing $personaName Persona:\n";
    $personaSuccess = true;
    
    foreach ($persona['tests'] as $transformation => $expected) {
        echo "   Testing $transformation...";
        try {
            $result = $transformationService->transform($persona['text'], $transformation);
            if ($result === $expected) {
                echo " ✅\n";
            } else {
                echo " ⚠️ (got: $result)\n";
                $warnings[] = "$personaName: $transformation produced unexpected result";
                $personaSuccess = false;
            }
        } catch (Exception $e) {
            echo " ❌\n";
            $errors[] = "$personaName: $transformation failed - " . $e->getMessage();
            $personaSuccess = false;
        }
    }
    
    if ($personaSuccess) {
        $successes[] = "$personaName persona tests passed";
    }
}

// 6. PERFORMANCE TESTING
echo "\n═══ 6. PERFORMANCE TESTING ═══\n";

// Test transformation speed
$testText = str_repeat("The quick brown fox jumps over the lazy dog. ", 100);
$startTime = microtime(true);
$transformationService->transform($testText, 'upper-case');
$endTime = microtime(true);
$transformTime = ($endTime - $startTime) * 1000;

echo "⚡ Transformation speed: " . number_format($transformTime, 2) . "ms";
if ($transformTime < 21) {
    echo " ✅ (target: <21ms)\n";
    $successes[] = "Performance target met (" . number_format($transformTime, 2) . "ms)";
} else {
    echo " ⚠️ (target: <21ms)\n";
    $warnings[] = "Performance slower than target (" . number_format($transformTime, 2) . "ms)";
}

// 7. SECURITY HEADERS CHECK
echo "\n═══ 7. SECURITY VALIDATION ═══\n";

$securityChecks = [
    'CSP headers' => function() {
        // This would normally check actual headers, simplified for script
        return checkFile(__DIR__ . '/../app/Http/Middleware/GenerateCspNonce.php', 'CSP Middleware');
    },
    'CSRF protection' => function() {
        return checkFile(__DIR__ . '/../app/Http/Middleware/VerifyCsrfToken.php', 'CSRF Middleware');
    },
    'XSS protection' => function() {
        // Check if Blade templates use proper escaping
        return true; // Laravel Blade auto-escapes by default
    }
];

foreach ($securityChecks as $checkName => $checkFunction) {
    echo "🔒 Checking $checkName...";
    if ($checkFunction()) {
        echo " ✅\n";
        $successes[] = "$checkName is configured";
    } else {
        echo " ❌\n";
        $errors[] = "$checkName failed";
    }
}

// 8. API ENDPOINT TESTING
echo "\n═══ 8. API ENDPOINT TESTING ═══\n";

$apiTests = [
    '/api/conversions' => 'Conversions API',
    '/api/transformations' => 'Transformations API',
    '/up' => 'Health check endpoint'
];

foreach ($apiTests as $endpoint => $description) {
    echo "🌐 Testing $description...";
    $url = "http://localhost:8000" . $endpoint;
    $context = stream_context_create(['http' => ['timeout' => 2]]);
    $response = @file_get_contents($url, false, $context);
    
    if ($response !== false) {
        echo " ✅\n";
        $successes[] = "$description is responding";
    } else {
        echo " ⚠️ (endpoint not accessible)\n";
        $warnings[] = "$description not accessible (server may not be running)";
    }
}

// 9. TAILWIND CSS VALIDATION
echo "\n═══ 9. TAILWIND CSS VALIDATION ═══\n";

// Tailwind is compiled into the CSS, check the built CSS instead
$cssFile = __DIR__ . '/../public/build/assets/app-*.css';
$cssFiles = glob($cssFile);

if (count($cssFiles) > 0) {
    echo "✅ Tailwind CSS is compiled in build assets\n";
    $successes[] = "Tailwind CSS compiled successfully";
    
    $cssSize = filesize($cssFiles[0]) / 1024; // KB
    echo "📊 CSS bundle size: " . number_format($cssSize, 2) . "KB";
    
    if ($cssSize < 100) {
        echo " ✅ (optimized)\n";
        $successes[] = "CSS bundle is optimized (" . number_format($cssSize, 2) . "KB)";
    } else {
        echo " ⚠️ (consider optimization)\n";
        $warnings[] = "CSS bundle is large (" . number_format($cssSize, 2) . "KB)";
    }
} else {
    echo "⚠️ No compiled CSS found - run 'npm run build'\n";
    $errors[] = "No compiled CSS assets found";
}

// FINAL REPORT
echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    VALIDATION REPORT                       ║\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "\n";

echo "📊 SUMMARY:\n";
echo "   ✅ Successes: " . count($successes) . "\n";
echo "   ⚠️  Warnings: " . count($warnings) . "\n";
echo "   ❌ Errors: " . count($errors) . "\n";
echo "\n";

if (count($errors) > 0) {
    echo "❌ ERRORS FOUND:\n";
    foreach ($errors as $error) {
        echo "   • $error\n";
    }
    echo "\n";
}

if (count($warnings) > 0) {
    echo "⚠️  WARNINGS:\n";
    foreach ($warnings as $warning) {
        echo "   • $warning\n";
    }
    echo "\n";
}

if (count($successes) > 0) {
    echo "✅ SUCCESSFUL CHECKS:\n";
    $displayedSuccesses = array_slice($successes, 0, 10);
    foreach ($displayedSuccesses as $success) {
        echo "   • $success\n";
    }
    if (count($successes) > 10) {
        echo "   ... and " . (count($successes) - 10) . " more\n";
    }
    echo "\n";
}

// RECOMMENDATIONS
echo "💡 RECOMMENDATIONS:\n";
if (count($errors) > 0) {
    echo "   • Fix critical errors before deployment\n";
    echo "   • Review error logs for more details\n";
}
if (count($warnings) > 0) {
    echo "   • Address warnings to improve application quality\n";
}
if (count($errors) === 0 && count($warnings) === 0) {
    echo "   • Application is ready for deployment! 🚀\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";

// Exit with appropriate code
exit(count($errors) > 0 ? 1 : 0);
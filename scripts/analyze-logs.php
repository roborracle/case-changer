#!/usr/bin/env php
<?php

/**
 * Comprehensive Log Analysis and Cleanup Script
 * Analyzes all error logs and provides actionable insights
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║              📊 LOG ANALYSIS & CLEANUP TOOL                ║\n";
echo "║         Analyzing all error logs and console outputs       ║\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "\n";

$errors = [];
$warnings = [];
$info = [];
$criticalIssues = [];
$commonPatterns = [];
$errorCounts = [];

// ============================================
// 1. ANALYZE LARAVEL LOGS
// ============================================
echo "═══ 1. ANALYZING LARAVEL LOGS ═══\n";

$logPath = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logPath)) {
    $logContent = file_get_contents($logPath);
    $lines = explode("\n", $logContent);
    
    // Get file size
    $logSize = filesize($logPath) / 1024 / 1024; // MB
    echo "📁 Log file size: " . number_format($logSize, 2) . " MB\n";
    
    if ($logSize > 10) {
        $warnings[] = "Laravel log file is large (" . number_format($logSize, 2) . " MB) - consider archiving";
    }
    
    // Parse last 1000 lines for recent errors
    $recentLines = array_slice($lines, -1000);
    
    $errorTypes = [
        'CRITICAL' => 0,
        'ERROR' => 0,
        'WARNING' => 0,
        'INFO' => 0,
        'DEBUG' => 0
    ];
    
    $errorMessages = [];
    $last24Hours = strtotime('-24 hours');
    
    foreach ($recentLines as $line) {
        // Check log level
        if (preg_match('/\[([\d-]+\s[\d:]+)\].*?\.(CRITICAL|ERROR|WARNING|INFO|DEBUG):(.*)/', $line, $matches)) {
            $timestamp = strtotime($matches[1]);
            $level = $matches[2];
            $message = trim($matches[3]);
            
            $errorTypes[$level]++;
            
            // Track recent errors (last 24 hours)
            if ($timestamp > $last24Hours) {
                if ($level === 'CRITICAL' || $level === 'ERROR') {
                    // Clean up the message for grouping
                    $cleanMessage = preg_replace('/\{.*?\}/', '{...}', $message);
                    $cleanMessage = preg_replace('/\d+/', 'N', $cleanMessage);
                    
                    if (!isset($errorMessages[$cleanMessage])) {
                        $errorMessages[$cleanMessage] = 0;
                    }
                    $errorMessages[$cleanMessage]++;
                    
                    if ($level === 'CRITICAL') {
                        $criticalIssues[] = $message;
                    }
                }
            }
        }
        
        // Check for specific error patterns
        if (stripos($line, 'Failed to open stream') !== false) {
            if (!isset($commonPatterns['File not found errors'])) {
                $commonPatterns['File not found errors'] = 0;
            }
            $commonPatterns['File not found errors']++;
        }
        if (preg_match('/Class.*not found/', $line)) {
            if (!isset($commonPatterns['Class not found errors'])) {
                $commonPatterns['Class not found errors'] = 0;
            }
            $commonPatterns['Class not found errors']++;
        }
        if (stripos($line, 'SQLSTATE') !== false) {
            if (!isset($commonPatterns['Database errors'])) {
                $commonPatterns['Database errors'] = 0;
            }
            $commonPatterns['Database errors']++;
        }
        if (stripos($line, 'TokenMismatchException') !== false) {
            if (!isset($commonPatterns['CSRF token errors'])) {
                $commonPatterns['CSRF token errors'] = 0;
            }
            $commonPatterns['CSRF token errors']++;
        }
        if (stripos($line, 'MethodNotAllowedHttpException') !== false) {
            if (!isset($commonPatterns['HTTP method errors'])) {
                $commonPatterns['HTTP method errors'] = 0;
            }
            $commonPatterns['HTTP method errors']++;
        }
    }
    
    echo "\n📊 Error Level Summary:\n";
    foreach ($errorTypes as $type => $count) {
        if ($count > 0) {
            $icon = match($type) {
                'CRITICAL' => '🔴',
                'ERROR' => '❌',
                'WARNING' => '⚠️',
                'INFO' => 'ℹ️',
                'DEBUG' => '🔍',
                default => '•'
            };
            echo "   $icon $type: $count occurrences\n";
        }
    }
    
    if (count($errorMessages) > 0) {
        echo "\n📋 Most Common Errors (Last 24 Hours):\n";
        arsort($errorMessages);
        $displayed = 0;
        foreach ($errorMessages as $message => $count) {
            if ($displayed >= 5) break;
            echo "   • [$count times] " . substr($message, 0, 80) . "...\n";
            $displayed++;
        }
    }
    
} else {
    echo "ℹ️  No Laravel log file found\n";
}

// ============================================
// 2. CHECK NPM/BUILD WARNINGS
// ============================================
echo "\n═══ 2. CHECKING BUILD/COMPILATION LOGS ═══\n";

// Check package.json for outdated packages
exec('npm outdated --json 2>/dev/null', $npmOutput, $returnCode);
if ($returnCode === 0 && !empty($npmOutput)) {
    $outdated = json_decode(implode('', $npmOutput), true);
    if (count($outdated) > 0) {
        echo "⚠️  " . count($outdated) . " outdated npm packages found\n";
        $warnings[] = count($outdated) . " npm packages need updating";
        
        // Show first 3 outdated packages
        $shown = 0;
        foreach ($outdated as $package => $info) {
            if ($shown >= 3) break;
            echo "   • $package: " . ($info['current'] ?? 'N/A') . " → " . ($info['wanted'] ?? 'N/A') . "\n";
            $shown++;
        }
    } else {
        echo "✅ All npm packages are up to date\n";
    }
}

// Check for npm vulnerabilities
exec('npm audit --json 2>/dev/null', $auditOutput, $auditCode);
if (!empty($auditOutput)) {
    $audit = json_decode(implode('', $auditOutput), true);
    if (isset($audit['metadata']['vulnerabilities'])) {
        $vulns = $audit['metadata']['vulnerabilities'];
        $total = $vulns['total'] ?? 0;
        
        if ($total > 0) {
            echo "🔒 Security Vulnerabilities Found:\n";
            echo "   • Critical: " . ($vulns['critical'] ?? 0) . "\n";
            echo "   • High: " . ($vulns['high'] ?? 0) . "\n";
            echo "   • Moderate: " . ($vulns['moderate'] ?? 0) . "\n";
            echo "   • Low: " . ($vulns['low'] ?? 0) . "\n";
            
            if (($vulns['critical'] ?? 0) > 0 || ($vulns['high'] ?? 0) > 0) {
                $criticalIssues[] = "Critical/High security vulnerabilities in npm packages";
            }
        } else {
            echo "✅ No npm vulnerabilities found\n";
        }
    }
}

// ============================================
// 3. CHECK LIVEWIRE COMPONENT ERRORS
// ============================================
echo "\n═══ 3. CHECKING LIVEWIRE COMPONENTS ═══\n";

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check for missing Livewire components
$viewsPath = __DIR__ . '/../resources/views';
$livewireReferences = [];

// Scan blade files for @livewire directives
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsPath, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        
        // Find @livewire directives
        if (preg_match_all("/@livewire\(['\"]([\w\-\.]+)['\"]/", $content, $matches)) {
            foreach ($matches[1] as $component) {
                $livewireReferences[$component] = $file->getPathname();
            }
        }
        
        // Find Livewire components in wire:model, wire:click etc
        if (preg_match_all("/wire:[a-z]+/", $content, $wireMatches)) {
            // Just count to see if Livewire is being used
        }
    }
}

$missingComponents = [];
foreach ($livewireReferences as $component => $file) {
    try {
        $componentClass = app(\Livewire\Mechanisms\ComponentRegistry::class)->getClass($component);
        if (!class_exists($componentClass)) {
            $missingComponents[] = $component;
        }
    } catch (Exception $e) {
        $missingComponents[] = $component;
    }
}

if (count($missingComponents) > 0) {
    echo "❌ Missing Livewire Components:\n";
    foreach ($missingComponents as $component) {
        echo "   • $component (referenced in " . basename($livewireReferences[$component]) . ")\n";
        $errors[] = "Missing Livewire component: $component";
    }
} else {
    echo "✅ All referenced Livewire components exist\n";
}

// ============================================
// 4. CHECK FOR COMMON ISSUES
// ============================================
echo "\n═══ 4. COMMON ISSUES CHECK ═══\n";

// Check .env file
if (!file_exists(__DIR__ . '/../.env')) {
    echo "❌ .env file is missing\n";
    $criticalIssues[] = ".env file is missing";
} else {
    echo "✅ .env file exists\n";
}

// Check storage permissions
$storageDir = __DIR__ . '/../storage';
if (!is_writable($storageDir)) {
    echo "❌ Storage directory is not writable\n";
    $criticalIssues[] = "Storage directory is not writable";
} else {
    echo "✅ Storage directory is writable\n";
}

// Check for debug mode in production
$env = file_get_contents(__DIR__ . '/../.env');
if (strpos($env, 'APP_ENV=production') !== false && strpos($env, 'APP_DEBUG=true') !== false) {
    echo "⚠️  Debug mode is enabled in production\n";
    $warnings[] = "Debug mode is enabled in production environment";
}

// ============================================
// 5. GENERATE ACTION ITEMS
// ============================================
echo "\n═══ 5. ACTION ITEMS ═══\n";

$actions = [];

if (count($criticalIssues) > 0) {
    echo "\n🔴 CRITICAL ISSUES (Fix immediately):\n";
    foreach ($criticalIssues as $issue) {
        echo "   • $issue\n";
    }
}

// Generate fix suggestions
if (isset($commonPatterns['File not found errors']) && $commonPatterns['File not found errors'] > 0) {
    $actions[] = "Run 'composer dump-autoload' to fix autoloading issues";
}

if (isset($commonPatterns['CSRF token errors']) && $commonPatterns['CSRF token errors'] > 0) {
    $actions[] = "Clear cookies and sessions: 'php artisan session:clear'";
}

if (isset($vulns['total']) && $vulns['total'] > 0) {
    $actions[] = "Run 'npm audit fix' to fix npm vulnerabilities";
}

if ($logSize > 10) {
    $actions[] = "Archive large log file: 'cp storage/logs/laravel.log storage/logs/laravel.log.backup && echo '' > storage/logs/laravel.log'";
}

if (count($actions) > 0) {
    echo "\n💡 RECOMMENDED FIXES:\n";
    foreach ($actions as $action) {
        echo "   → $action\n";
    }
}

// ============================================
// 6. CLEANUP OPTIONS
// ============================================
echo "\n═══ 6. CLEANUP COMMANDS ═══\n";
echo "To clean up logs and resolve issues, run:\n";
echo "\n";
echo "# Clear Laravel logs (archive first if needed):\n";
echo "cp storage/logs/laravel.log storage/logs/laravel.log." . date('Y-m-d') . "\n";
echo "echo '' > storage/logs/laravel.log\n";
echo "\n";
echo "# Fix permissions:\n";
echo "chmod -R 775 storage bootstrap/cache\n";
echo "\n";
echo "# Clear all caches:\n";
echo "php artisan cache:clear && php artisan config:clear && php artisan view:clear\n";
echo "\n";
echo "# Fix npm issues:\n";
echo "npm audit fix\n";
echo "npm update\n";

// ============================================
// FINAL SUMMARY
// ============================================
echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    📊 ANALYSIS SUMMARY                      ║\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "\n";

$totalIssues = count($criticalIssues) + count($errors) + count($warnings);

if ($totalIssues === 0) {
    echo "🎉 No significant issues found! Application logs are clean.\n";
} else {
    echo "Found $totalIssues total issues:\n";
    echo "   🔴 Critical: " . count($criticalIssues) . "\n";
    echo "   ❌ Errors: " . count($errors) . "\n";
    echo "   ⚠️  Warnings: " . count($warnings) . "\n";
    echo "\n";
    
    if (count($criticalIssues) > 0) {
        echo "⚠️  CRITICAL ISSUES REQUIRE IMMEDIATE ATTENTION\n";
    } else {
        echo "✅ No critical issues found\n";
    }
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";

// Exit with appropriate code
exit(count($criticalIssues) > 0 ? 1 : 0);
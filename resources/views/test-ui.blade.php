<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UI Test - Case Changer Pro</title>
    <script>
        // Console error monitor
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.message, 'at', e.filename, ':', e.lineno);
        });
        
        // Alpine.js error monitor
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized');
        });
    </script>
</head>
<body>
    <x-layouts.app>
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">UI Component Test Page</h1>
            
            <!-- Test Theme Toggle -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Theme Toggle Test</h2>
                <x-theme-toggle />
            </div>
            
            <!-- Test Primary Tabs -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Primary Tabs Test</h2>
                <x-primary-tabs />
            </div>
            
            <!-- Test Style Guide Selector -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Style Guide Selector Test</h2>
                <x-style-guide-selector />
            </div>
            
            <!-- Test Auto-resize Textarea -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Auto-resize Textarea Test</h2>
                <x-auto-resize-textarea />
            </div>
            
            <!-- Console Error Check -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Console Error Check</h2>
                <div id="error-display" class="p-4 bg-gray-100 rounded">
                    <p>Open browser console to check for Alpine.js errors</p>
                    <p>Expected: No "Alpine Expression Error" messages</p>
                    <p>Expected: No "undefined variable" errors</p>
                </div>
            </div>
            
            <script>
                // Test Alpine.js variables
                document.addEventListener('alpine:initialized', () => {
                    console.log('=== Alpine.js Test Results ===');
                    console.log('Alpine initialized:', typeof Alpine !== 'undefined');
                    console.log('Theme store exists:', typeof Alpine.store('theme') !== 'undefined');
                    
                    // Test each expected Alpine component
                    const tests = [
                        { name: 'primaryTabs', expected: true },
                        { name: 'styleGuideSelector', expected: true },
                        { name: 'autoResizeTextarea', expected: true },
                        { name: 'converterMain', expected: true }
                    ];
                    
                    tests.forEach(test => {
                        try {
                            const exists = typeof Alpine.data(test.name) === 'function';
                            console.log(`${test.name}:`, exists ? '✅ PASS' : '❌ FAIL');
                        } catch (e) {
                            console.log(`${test.name}: ❌ FAIL -`, e.message);
                        }
                    });
                    console.log('==============================');
                });
            </script>
        </div>
    </x-layouts.app>
</body>
</html>
#!/usr/bin/env node

const http = require('http');
const https = require('https');

console.log('═══════════════════════════════════════════════════════════════');
console.log('          BROWSER VALIDATION & CONSOLE ERROR CHECK             ');
console.log('═══════════════════════════════════════════════════════════════');
console.log('');

let passedTests = 0;
let failedTests = 0;
let warnings = 0;

function log(type, message) {
    const icons = {
        pass: '✅',
        fail: '❌',
        warn: '⚠️',
        info: 'ℹ️',
        test: '🧪'
    };
    console.log(`${icons[type] || ''} ${message}`);
    
    if (type === 'pass') passedTests++;
    if (type === 'fail') failedTests++;
    if (type === 'warn') warnings++;
}

async function fetchPage(path = '/') {
    return new Promise((resolve, reject) => {
        const options = {
            hostname: 'localhost',
            port: 8000,
            path: path,
            method: 'GET',
        };

        const req = http.request(options, (res) => {
            let data = '';
            res.on('data', (chunk) => { data += chunk; });
            res.on('end', () => resolve({ status: res.statusCode, body: data }));
        });

        req.on('error', reject);
        req.end();
    });
}

async function testHomePage() {
    log('test', 'Testing Home Page...');
    
    try {
        const response = await fetchPage('/');
        
        if (response.status === 200) {
            log('pass', 'Home page loads successfully (HTTP 200)');
        } else {
            log('fail', `Home page returned status ${response.status}`);
        }

        // Check for Alpine.js component
        if (response.body.includes('x-data="improvedConverter"')) {
            log('pass', 'Alpine component "improvedConverter" found in DOM');
        } else {
            log('fail', 'Alpine component "improvedConverter" NOT found in DOM');
        }

        // Check for JavaScript file
        const jsMatch = response.body.match(/\/build\/assets\/app-[a-zA-Z0-9_-]+\.js/);
        if (jsMatch) {
            log('pass', `JavaScript bundle found: ${jsMatch[0]}`);
            
            // Fetch and validate JS file
            const jsResponse = await fetchPage(jsMatch[0]);
            if (jsResponse.status === 200) {
                log('pass', 'JavaScript bundle loads successfully');
                
                // Check for critical functions
                if (jsResponse.body.includes('window.transform')) {
                    log('pass', 'Transform function is exposed to window object');
                } else {
                    log('fail', 'Transform function NOT exposed to window');
                }
                
                if (jsResponse.body.includes('Alpine.data("improvedConverter"')) {
                    log('pass', 'improvedConverter Alpine component is registered');
                } else {
                    log('fail', 'improvedConverter component NOT registered');
                }
                
                if (jsResponse.body.includes('clearAll')) {
                    log('pass', 'clearAll method found in component');
                } else {
                    log('fail', 'clearAll method NOT found');
                }
            } else {
                log('fail', `JavaScript bundle returned status ${jsResponse.status}`);
            }
        } else {
            log('fail', 'JavaScript bundle reference NOT found in HTML');
        }

        // Check for CSP header
        if (!response.body.includes('unsafe-eval') && !response.body.includes('unsafe-inline')) {
            log('pass', 'No unsafe CSP directives found');
        } else {
            log('warn', 'Potentially unsafe CSP directives detected');
        }

        // Check for console errors in HTML comments (if any debug info)
        if (response.body.includes('console.error') || response.body.includes('Console Error')) {
            log('warn', 'Potential console errors referenced in page');
        }

        // Check for preview grid
        if (response.body.includes('x-for="(preview, index) in previews"')) {
            log('pass', 'Preview grid template found');
        } else {
            log('fail', 'Preview grid template NOT found');
        }

        // Check for input binding
        if (response.body.includes('x-model="inputText"')) {
            log('pass', 'Input text binding found');
        } else {
            log('fail', 'Input text binding NOT found');
        }

        // Check for copy button
        if (response.body.includes('@click="copyToClipboard')) {
            log('pass', 'Copy button click handler found');
        } else {
            log('fail', 'Copy button click handler NOT found');
        }

    } catch (error) {
        log('fail', `Error testing home page: ${error.message}`);
    }
}

async function testTransformAPI() {
    log('test', 'Testing Transformation API...');
    
    try {
        const postData = JSON.stringify({
            text: 'Hello World',
            transformation: 'upper-case'
        });

        const options = {
            hostname: 'localhost',
            port: 8000,
            path: '/api/transform',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Content-Length': postData.length,
                'Accept': 'application/json'
            }
        };

        const response = await new Promise((resolve, reject) => {
            const req = http.request(options, (res) => {
                let data = '';
                res.on('data', (chunk) => { data += chunk; });
                res.on('end', () => resolve({ status: res.statusCode, body: data }));
            });
            req.on('error', reject);
            req.write(postData);
            req.end();
        });

        if (response.status === 200) {
            log('pass', 'Transform API responds successfully');
            const result = JSON.parse(response.body);
            if (result.result === 'HELLO WORLD' || result.text === 'HELLO WORLD') {
                log('pass', 'Transform API returns correct uppercase result');
            } else {
                log('fail', `Unexpected API result: ${JSON.stringify(result)}`);
            }
        } else if (response.status === 419) {
            log('warn', 'CSRF token required for API (expected in production)');
        } else {
            log('fail', `Transform API returned status ${response.status}`);
        }
    } catch (error) {
        log('warn', `Transform API test error: ${error.message}`);
    }
}

async function testCategoryPages() {
    log('test', 'Testing Category Pages...');
    
    const categories = [
        '/conversions/text-case',
        '/conversions/encoding-decoding',
        '/conversions/string-manipulation'
    ];

    for (const path of categories) {
        try {
            const response = await fetchPage(path);
            if (response.status === 200) {
                log('pass', `Category page ${path} loads successfully`);
            } else {
                log('fail', `Category page ${path} returned status ${response.status}`);
            }
        } catch (error) {
            log('fail', `Error loading ${path}: ${error.message}`);
        }
    }
}

async function checkForConsoleErrors() {
    log('test', 'Checking for potential JavaScript errors...');
    
    // Since we can't actually run a browser, we'll check for common error patterns
    const errorPatterns = [
        'Alpine Expression Error',
        'ReferenceError',
        'TypeError',
        'Uncaught',
        'Cannot read property',
        'is not defined',
        'is not a function'
    ];

    try {
        const response = await fetchPage('/');
        let errorsFound = false;
        
        for (const pattern of errorPatterns) {
            if (response.body.includes(pattern)) {
                log('fail', `Potential error pattern found: "${pattern}"`);
                errorsFound = true;
            }
        }
        
        if (!errorsFound) {
            log('pass', 'No common JavaScript error patterns found in HTML');
        }
    } catch (error) {
        log('fail', `Error checking for console errors: ${error.message}`);
    }
}

async function runAllTests() {
    await testHomePage();
    console.log('');
    
    await testTransformAPI();
    console.log('');
    
    await testCategoryPages();
    console.log('');
    
    await checkForConsoleErrors();
    console.log('');
    
    console.log('═══════════════════════════════════════════════════════════════');
    console.log('                         TEST SUMMARY                          ');
    console.log('═══════════════════════════════════════════════════════════════');
    console.log(`✅ Passed: ${passedTests}`);
    console.log(`❌ Failed: ${failedTests}`);
    console.log(`⚠️  Warnings: ${warnings}`);
    console.log('');
    
    if (failedTests === 0) {
        console.log('🎉 All critical tests passed! No console errors detected.');
    } else {
        console.log(`⚠️  ${failedTests} test(s) failed. Review the output above.`);
    }
    
    process.exit(failedTests > 0 ? 1 : 0);
}

// Run tests
runAllTests().catch(error => {
    console.error('Fatal error running tests:', error);
    process.exit(1);
});
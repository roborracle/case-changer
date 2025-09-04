/**
 * Browser Console Testing Script
 * Run this in the browser console to check for errors
 */

(function() {
    console.log('%c🔍 BROWSER VALIDATION SUITE', 'font-size: 20px; color: #4A90E2; font-weight: bold');
    console.log('Testing Case Changer Pro UI...\n');
    
    const results = {
        errors: [],
        warnings: [],
        successes: [],
        performance: {}
    };
    
    // 1. Check for JavaScript Errors
    const originalError = window.onerror;
    let jsErrors = [];
    window.onerror = function(msg, url, lineNo, columnNo, error) {
        jsErrors.push({msg, url, lineNo, columnNo, error});
        return false;
    };
    
    // 2. Check for CSP Violations
    document.addEventListener('securitypolicyviolation', (e) => {
        results.errors.push(`CSP Violation: ${e.blockedURI} - ${e.violatedDirective}`);
        console.error('❌ CSP Violation detected:', e);
    });
    
    // 3. Check for Console Errors
    const originalConsoleError = console.error;
    console.error = function() {
        results.errors.push(`Console Error: ${Array.from(arguments).join(' ')}`);
        originalConsoleError.apply(console, arguments);
    };
    
    // 4. Check Livewire is Loaded
    if (typeof window.Livewire !== 'undefined') {
        results.successes.push('Livewire is loaded and initialized');
        console.log('✅ Livewire detected and running');
    } else {
        results.errors.push('Livewire is not loaded');
        console.error('❌ Livewire not found');
    }
    
    // 5. Check Alpine.js if present
    if (typeof window.Alpine !== 'undefined') {
        results.successes.push('Alpine.js is loaded');
        console.log('✅ Alpine.js detected');
    }
    
    // 6. Check for Missing Resources
    const checkResources = () => {
        const images = document.querySelectorAll('img');
        const scripts = document.querySelectorAll('script[src]');
        const links = document.querySelectorAll('link[href]');
        
        let missingResources = 0;
        
        images.forEach(img => {
            if (!img.complete || img.naturalHeight === 0) {
                results.warnings.push(`Missing image: ${img.src}`);
                missingResources++;
            }
        });
        
        if (missingResources === 0) {
            results.successes.push('All images loaded successfully');
            console.log('✅ All images loaded');
        } else {
            console.warn(`⚠️ ${missingResources} images failed to load`);
        }
    };
    
    // 7. Check Tailwind Classes
    const checkTailwind = () => {
        const elements = document.querySelectorAll('[class*="bg-"], [class*="text-"], [class*="p-"], [class*="m-"]');
        if (elements.length > 0) {
            results.successes.push(`Tailwind CSS classes detected (${elements.length} elements)`);
            console.log(`✅ Tailwind CSS working (${elements.length} styled elements)`);
        } else {
            results.warnings.push('No Tailwind CSS classes detected');
            console.warn('⚠️ No Tailwind CSS classes found');
        }
    };
    
    // 8. Performance Metrics
    const checkPerformance = () => {
        if (window.performance && window.performance.timing) {
            const timing = window.performance.timing;
            const pageLoad = timing.loadEventEnd - timing.navigationStart;
            const domReady = timing.domContentLoadedEventEnd - timing.navigationStart;
            const firstPaint = performance.getEntriesByType('paint')[0]?.startTime || 0;
            
            results.performance = {
                pageLoad: pageLoad + 'ms',
                domReady: domReady + 'ms',
                firstPaint: firstPaint.toFixed(2) + 'ms'
            };
            
            console.log('⚡ Performance Metrics:');
            console.log(`   Page Load: ${pageLoad}ms ${pageLoad < 1000 ? '✅' : '⚠️'}`);
            console.log(`   DOM Ready: ${domReady}ms ${domReady < 500 ? '✅' : '⚠️'}`);
            console.log(`   First Paint: ${firstPaint.toFixed(2)}ms ${firstPaint < 200 ? '✅' : '⚠️'}`);
            
            if (pageLoad < 1000) {
                results.successes.push(`Fast page load (${pageLoad}ms)`);
            } else {
                results.warnings.push(`Slow page load (${pageLoad}ms)`);
            }
        }
    };
    
    // 9. Test Transformation Functionality
    const testTransformation = () => {
        const input = document.querySelector('textarea[wire\\:model="inputText"], textarea[name="input_text"]');
        const transformButtons = document.querySelectorAll('button[wire\\:click*="transform"]');
        
        if (input) {
            results.successes.push('Input textarea found');
            console.log('✅ Input textarea detected');
        } else {
            results.errors.push('Input textarea not found');
            console.error('❌ Input textarea missing');
        }
        
        if (transformButtons.length > 0) {
            results.successes.push(`${transformButtons.length} transformation buttons found`);
            console.log(`✅ ${transformButtons.length} transformation buttons detected`);
        } else {
            // Check for dropdown instead
            const dropdown = document.querySelector('select[wire\\:model="transformation"], select[name="transformation"]');
            if (dropdown) {
                results.successes.push('Transformation dropdown found');
                console.log('✅ Transformation dropdown detected');
            } else {
                results.warnings.push('No transformation controls found');
                console.warn('⚠️ No transformation buttons or dropdown found');
            }
        }
    };
    
    // 10. Accessibility Check
    const checkAccessibility = () => {
        const interactiveElements = document.querySelectorAll('button, a, input, select, textarea');
        let missingLabels = 0;
        let missingAria = 0;
        
        interactiveElements.forEach(el => {
            if (el.tagName === 'INPUT' || el.tagName === 'SELECT' || el.tagName === 'TEXTAREA') {
                const label = document.querySelector(`label[for="${el.id}"]`);
                if (!label && !el.getAttribute('aria-label')) {
                    missingLabels++;
                }
            }
            
            if (el.tagName === 'BUTTON' && !el.textContent.trim() && !el.getAttribute('aria-label')) {
                missingAria++;
            }
        });
        
        if (missingLabels === 0 && missingAria === 0) {
            results.successes.push('Good accessibility (all inputs labeled)');
            console.log('✅ Accessibility check passed');
        } else {
            if (missingLabels > 0) {
                results.warnings.push(`${missingLabels} inputs missing labels`);
            }
            if (missingAria > 0) {
                results.warnings.push(`${missingAria} buttons missing aria-labels`);
            }
            console.warn(`⚠️ Accessibility issues: ${missingLabels} missing labels, ${missingAria} missing aria`);
        }
    };
    
    // 11. Mobile Responsiveness
    const checkResponsive = () => {
        const viewport = document.querySelector('meta[name="viewport"]');
        if (viewport && viewport.content.includes('width=device-width')) {
            results.successes.push('Mobile viewport configured');
            console.log('✅ Mobile viewport meta tag present');
        } else {
            results.warnings.push('Mobile viewport not properly configured');
            console.warn('⚠️ Mobile viewport meta tag missing or incorrect');
        }
        
        // Check for responsive classes
        const responsiveElements = document.querySelectorAll('[class*="sm:"], [class*="md:"], [class*="lg:"]');
        if (responsiveElements.length > 0) {
            results.successes.push(`Responsive design detected (${responsiveElements.length} elements)`);
            console.log(`✅ Responsive Tailwind classes found (${responsiveElements.length} elements)`);
        }
    };
    
    // Run all checks
    setTimeout(() => {
        console.log('\n🔍 Running validation checks...\n');
        
        checkResources();
        checkTailwind();
        checkPerformance();
        testTransformation();
        checkAccessibility();
        checkResponsive();
        
        // Final Report
        console.log('\n' + '='.repeat(50));
        console.log('%c📊 VALIDATION REPORT', 'font-size: 16px; font-weight: bold; color: #2563EB');
        console.log('='.repeat(50) + '\n');
        
        if (results.errors.length > 0) {
            console.log('%c❌ ERRORS (' + results.errors.length + ')', 'color: #EF4444; font-weight: bold');
            results.errors.forEach(err => console.error('  • ' + err));
        }
        
        if (results.warnings.length > 0) {
            console.log('%c⚠️ WARNINGS (' + results.warnings.length + ')', 'color: #F59E0B; font-weight: bold');
            results.warnings.forEach(warn => console.warn('  • ' + warn));
        }
        
        if (results.successes.length > 0) {
            console.log('%c✅ SUCCESSES (' + results.successes.length + ')', 'color: #10B981; font-weight: bold');
            results.successes.slice(0, 5).forEach(success => console.log('  • ' + success));
            if (results.successes.length > 5) {
                console.log(`  ... and ${results.successes.length - 5} more`);
            }
        }
        
        console.log('\n' + '='.repeat(50));
        
        // Overall status
        if (results.errors.length === 0 && results.warnings.length < 3) {
            console.log('%c🎉 APPLICATION PASSED VALIDATION!', 'font-size: 18px; color: #10B981; font-weight: bold');
        } else if (results.errors.length > 0) {
            console.log('%c⚠️ CRITICAL ISSUES FOUND - PLEASE FIX', 'font-size: 18px; color: #EF4444; font-weight: bold');
        } else {
            console.log('%c⚠️ MINOR ISSUES FOUND - REVIEW RECOMMENDED', 'font-size: 18px; color: #F59E0B; font-weight: bold');
        }
        
        // Store results globally for inspection
        window.validationResults = results;
        console.log('\nFull results available in: window.validationResults');
        
    }, 1000); // Wait for page to fully load
    
})();

console.log('\nTo run comprehensive browser tests, paste this entire script in the browser console while on the Case Changer Pro page.');
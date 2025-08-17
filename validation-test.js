// Automated validation script for Case Changer
// To be executed in the browser console

console.log("=== CASE CHANGER VALIDATION PROTOCOL ===");
console.log("Starting comprehensive feature testing...");

// Test data
const testCases = {
    basic: "the QUICK brown FOX jumps OVER the lazy DOG",
    styleGuide: "the art of war by sun tzu",
    prepositions: "the cat is ON the mat IN the house",
    underscores: "hello_world_test",
    spaces: "hello world test",
    quotes: 'She said "hello" and \'goodbye\''
};

// Get the input and buttons
const input = document.querySelector('textarea[wire\\:model\\.live="inputText"]');
const output = document.querySelector('textarea[readonly]');

if (!input || !output) {
    console.error("❌ CRITICAL ERROR: Could not find input/output textareas");
    throw new Error("Page elements not found");
}

// Helper function to simulate button click
async function testTransformation(buttonText, inputValue, expectedPattern) {
    console.log(`\nTesting: ${buttonText}`);
    
    // Set input value
    input.value = inputValue;
    input.dispatchEvent(new Event('input', { bubbles: true }));
    
    // Find and click button
    const buttons = Array.from(document.querySelectorAll('button'));
    const button = buttons.find(btn => btn.textContent.trim() === buttonText);
    
    if (!button) {
        console.error(`❌ Button "${buttonText}" not found`);
        return false;
    }
    
    button.click();
    
    // Wait for Livewire to process
    await new Promise(resolve => setTimeout(resolve, 500));
    
    const result = output.value;
    console.log(`   Input: "${inputValue}"`);
    console.log(`   Output: "${result}"`);
    
    if (expectedPattern && !result.match(expectedPattern)) {
        console.error(`   ❌ FAILED: Output doesn't match expected pattern`);
        return false;
    }
    
    console.log(`   ✅ PASSED`);
    return true;
}

// Run all tests
async function runValidation() {
    const results = {
        passed: 0,
        failed: 0,
        errors: []
    };
    
    console.log("\n=== BASIC TRANSFORMATIONS ===");
    
    // Test basic transformations
    const basicTests = [
        { button: "Title Case", input: testCases.basic, pattern: /^The Quick Brown Fox/ },
        { button: "Sentence case", input: testCases.basic, pattern: /^The quick brown fox/ },
        { button: "UPPERCASE", input: testCases.basic, pattern: /^THE QUICK BROWN FOX/ },
        { button: "lowercase", input: testCases.basic, pattern: /^the quick brown fox/ },
        { button: "First Letter", input: testCases.basic, pattern: /^The quick brown fox/ },
        { button: "Alternating Case", input: testCases.basic, pattern: /^[tT][hH][eE]/ }
    ];
    
    for (const test of basicTests) {
        const success = await testTransformation(test.button, test.input, test.pattern);
        if (success) results.passed++; else results.failed++;
    }
    
    console.log("\n=== STYLE GUIDE FORMATTERS ===");
    
    // Test style guides
    const styleTests = [
        { button: "APA", input: testCases.styleGuide, pattern: /^The Art/ },
        { button: "Chicago", input: testCases.styleGuide, pattern: /^The Art/ },
        { button: "MLA", input: testCases.styleGuide, pattern: /^The Art/ },
        { button: "Bluebook", input: testCases.styleGuide, pattern: /^THE ART/ }
    ];
    
    for (const test of styleTests) {
        const success = await testTransformation(test.button, test.input, test.pattern);
        if (success) results.passed++; else results.failed++;
    }
    
    console.log("\n=== ADVANCED FEATURES ===");
    
    // Test advanced features
    const advancedTests = [
        { button: "Fix Prepositions", input: testCases.prepositions, pattern: /on.*in/i },
        { button: "Add Spaces", input: testCases.underscores, pattern: /hello world test/ },
        { button: "Remove Spaces", input: testCases.spaces, pattern: /helloworldtest/ },
        { button: "Add Underscores", input: testCases.spaces, pattern: /hello_world_test/ },
        { button: "Remove Underscores", input: testCases.underscores, pattern: /hello world test/ }
    ];
    
    for (const test of advancedTests) {
        const success = await testTransformation(test.button, test.input, test.pattern);
        if (success) results.passed++; else results.failed++;
    }
    
    // Check for console errors
    console.log("\n=== CONSOLE ERROR CHECK ===");
    const errors = window.__livewireErrorMessages || [];
    if (errors.length > 0) {
        console.error("❌ Livewire errors detected:", errors);
        results.errors = errors;
    } else {
        console.log("✅ No Livewire errors detected");
    }
    
    // Final report
    console.log("\n=== VALIDATION SUMMARY ===");
    console.log(`Tests Passed: ${results.passed}`);
    console.log(`Tests Failed: ${results.failed}`);
    console.log(`Console Errors: ${results.errors.length}`);
    
    if (results.failed === 0 && results.errors.length === 0) {
        console.log("✅ ALL VALIDATIONS PASSED!");
        return true;
    } else {
        console.error("❌ VALIDATION FAILED - Issues detected");
        return false;
    }
}

// Execute validation
runValidation().then(success => {
    if (success) {
        console.log("\n🎉 Case Changer is fully functional and validated!");
    } else {
        console.log("\n⚠️ Case Changer has issues that need to be addressed");
    }
});

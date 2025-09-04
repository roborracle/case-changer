# SCARLETT Test Validation Protocol

Comprehensive testing validation following SCARLETT's mandatory testing requirements.

## Command: /test-validation [test-type]

Test types: unit, integration, browser, security, performance, all

## Testing Pipelines

### Unit Testing Pipeline (80% Coverage Required)
```bash
# Run unit tests with coverage
php artisan test --testsuite=Unit --coverage --min=80

# Test scenarios that MUST be covered:
# - Happy path functionality
# - Edge cases (empty inputs, max values)
# - Boundary conditions
# - Error handling and exceptions

# Check transformation tests
php artisan test tests/Unit/TransformationTest.php --coverage
```

#### Required Unit Test Structure
```php
/**
 * Test that uppercase transformation works correctly.
 * 
 * Given: A string with mixed case characters
 * When: The uppercase transformation is applied
 * Then: All characters should be converted to uppercase
 * 
 * @test
 */
public function it_transforms_text_to_uppercase(): void
{
    // Arrange (Given)
    $input = 'Hello World';
    $expected = 'HELLO WORLD';
    
    // Act (When)
    $result = $this->transformer->transform($input, 'uppercase');
    
    // Assert (Then)
    $this->assertEquals($expected, $result);
    
    // Edge cases
    $this->assertEquals('', $this->transformer->transform('', 'uppercase'));
    $this->assertEquals('123', $this->transformer->transform('123', 'uppercase'));
}
```

### Integration Testing Pipeline
```bash
# API endpoint tests
php artisan test tests/Feature/Api/

# Livewire component tests  
php artisan test tests/Feature/Livewire/

# Database integration tests
php artisan test tests/Feature/Database/

# Required scenarios:
# - API request/response cycles
# - Database CRUD operations  
# - Cross-service communication
# - Authentication/authorization flows
```

### Browser Testing Pipeline
```bash
# Setup Dusk if not installed
php artisan dusk:install

# Run browser tests
php artisan dusk

# Required browser checks:
# - Latest Chrome Desktop
# - Latest Firefox Desktop
# - Safari Desktop & Mobile
# - Mobile viewport (360x800)
```

#### Browser Test Template
```php
public function testTransformationInterfaceWorks()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertSee('Case Changer Pro')
                ->type('@input-text', 'test text')
                ->select('@transformation-type', 'uppercase')
                ->press('@transform-button')
                ->assertSee('TEST TEXT')
                ->assertNoJavascriptErrors()
                ->assertNetworkRequestsSuccessful();
    });
}
```

### Security Validation Testing
```bash
#!/bin/bash
# security-validation.sh

echo "🔒 Running Security Validation Tests..."

# Input sanitization tests
php artisan test tests/Security/InputSanitizationTest.php

# SQL injection prevention
php artisan test tests/Security/SqlInjectionTest.php

# XSS prevention
php artisan test tests/Security/XssProtectionTest.php

# CSRF validation
php artisan test tests/Security/CsrfTest.php

# Authentication tests
php artisan test tests/Security/AuthenticationTest.php

# Authorization tests
php artisan test tests/Security/AuthorizationTest.php

# Rate limiting tests
php artisan test tests/Security/RateLimitingTest.php
```

### Performance Testing
```bash
#!/bin/bash
# performance-testing.sh

echo "⚡ Running Performance Tests..."

# Frontend Load Time (LCP < 3000ms)
npm run lighthouse -- --preset=desktop --only-categories=performance

# API Response Time (p95 < 200ms)
ab -n 1000 -c 10 http://localhost:8000/api/transform

# Database Query Time (p95 < 50ms)
php artisan tinker --execute="
    \DB::enableQueryLog();
    // Run test queries
    \App\Models\Transformation::all();
    $queries = \DB::getQueryLog();
    foreach(\$queries as \$query) {
        if (\$query['time'] > 50) {
            echo 'SLOW QUERY: ' . \$query['query'] . ' (' . \$query['time'] . 'ms)';
        }
    }
"

# Memory Usage (stable over 5 minutes)
php artisan serve &
SERVER_PID=$!
for i in {1..300}; do
    ps aux | grep $SERVER_PID | awk '{print $4}' >> memory_usage.log
    sleep 1
done
kill $SERVER_PID

# Check for memory leaks
if [ $(tail -1 memory_usage.log) > $(head -1 memory_usage.log) ]; then
    echo "⚠️ Potential memory leak detected"
fi
```

## Test Documentation Requirements

### Required Test Documentation Format
```php
/**
 * Test Category: Unit/Integration/Browser
 * Component: [Component being tested]
 * Requirement: [Business requirement reference]
 * 
 * Test that [specific behavior].
 * 
 * Given: [Initial state/preconditions]
 * When: [Action/event being tested]  
 * Then: [Expected outcome]
 * 
 * @test
 * @group [test-group]
 * @covers [method-being-covered]
 */
```

## Quality Metrics Validation

### Coverage Report Generation
```bash
# Generate HTML coverage report
php artisan test --coverage-html=coverage

# Generate text coverage summary
php artisan test --coverage-text

# Check specific class coverage
php artisan test --coverage --filter=TransformationEngine
```

### Test Quality Checks
```bash
# Check for test smells
./vendor/bin/phpunit-test-smells analyze tests/

# Mutation testing
./vendor/bin/infection --min-msi=80

# Test execution time
php artisan test --profile
```

## Continuous Testing Setup

### Pre-Commit Hook
```bash
#!/bin/sh
# .git/hooks/pre-commit

# Run fast tests
php artisan test --testsuite=Unit --stop-on-failure

if [ $? -ne 0 ]; then
    echo "❌ Unit tests failed. Commit aborted."
    exit 1
fi

echo "✅ Tests passed"
```

### CI Pipeline Configuration
```yaml
# .github/workflows/tests.yml
name: Tests
on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Run Unit Tests
        run: php artisan test --testsuite=Unit --coverage --min=80
      
      - name: Run Integration Tests
        run: php artisan test --testsuite=Feature
      
      - name: Run Browser Tests
        run: php artisan dusk
      
      - name: Security Scan
        run: |
          composer audit
          npm audit
```

## Test Failure Protocol

### When Tests Fail
1. **STOP** - Do not continue development
2. **DIAGNOSE** - Identify root cause
3. **FIX** - Resolve the issue
4. **VERIFY** - Ensure all tests pass
5. **DOCUMENT** - Update test documentation

### Test Debt Tracking
```yaml
# .scarlett/test-debt.yaml
test_debt:
  - file: "tests/Unit/TransformationTest.php"
    issue: "Missing edge case for Unicode"
    priority: "HIGH"
    deadline: "2024-01-15"
```

## Validation Checklist

Before marking any work as complete:

- [ ] Unit test coverage ≥ 80%
- [ ] All integration tests passing
- [ ] Browser tests passing on all targets
- [ ] Security validation complete
- [ ] Performance benchmarks met
- [ ] No console errors in browser
- [ ] Test documentation complete
- [ ] No skipped/incomplete tests
- [ ] Mutation score ≥ 80%
- [ ] No test smells detected

## Usage Examples

```bash
# Run all validations
/test-validation all

# Run specific test type
/test-validation unit
/test-validation integration
/test-validation browser

# Run security tests
/test-validation security

# Run performance tests
/test-validation performance

# Generate full report
/test-validation all --report
```

**Remember:** Testing is not optional. Incomplete testing = incomplete work.
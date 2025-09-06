# Enforce SCARLETT Coding Standards

Validate code against SCARLETT's strict coding standards and automatically fix violations.

## Command: /enforce-standards [file-or-directory]

## File Structure Rules

### Maximum Lines Check
```bash
# Check for files exceeding 350 lines
find app/ -name "*.php" -exec wc -l {} \; | awk '$1 > 350 {print $2 ": " $1 " lines (VIOLATION: max 350)"}'

# Auto-split large files
php artisan make:service SplitLargeFiles
```

### Single Responsibility Check
```bash
# Detect files with multiple classes
grep -l "^class " app/**/*.php | while read file; do
  count=$(grep -c "^class " "$file")
  if [ $count -gt 1 ]; then
    echo "❌ $file: Multiple classes detected (SRP violation)"
  fi
done
```

## Laravel/PHP Standards

### Naming Conventions
```php
// Enforce via PHP CS Fixer config
return [
    'rules' => [
        // Classes: PascalCase
        'class_definition' => ['single_line' => false],
        
        // Methods: camelCase (Laravel convention)
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        
        // Constants: UPPER_SNAKE_CASE
        'constant_case' => ['case' => 'upper'],
        
        // Properties: camelCase
        'visibility_required' => ['elements' => ['property', 'method']],
    ]
];
```

### Type Safety Enforcement
```bash
# Check for missing type hints
grep -n "function [^(]*(" app/**/*.php | grep -v ": *[a-zA-Z?]*"

# PHPStan strict mode check
./vendor/bin/phpstan analyse --level=max --error-format=json app/
```

### Required Documentation
```php
/**
 * Transform text according to the specified type.
 * 
 * @param string $text The input text to transform
 * @param string $type The transformation type to apply
 * @return string The transformed text
 * @throws InvalidTransformationException If transformation type is invalid
 * 
 * @example
 * $result = $transformer->transform("hello", "uppercase");
 * // Returns: "HELLO"
 */
public function transform(string $text, string $type): string
{
    // Implementation
}
```

## JavaScript/TypeScript Standards

### Forbidden Patterns
```bash
# Check for console.log
grep -rn "console.log" resources/js/ && echo "❌ console.log found"

# Check for 'any' type in TypeScript
grep -rn ": any" resources/js/ && echo "❌ 'any' type found"

# Check for var usage (use const/let)
grep -rn "^[[:space:]]*var " resources/js/ && echo "❌ 'var' keyword found"
```

### Auto-fix with ESLint
```json
{
  "rules": {
    "no-console": "error",
    "no-debugger": "error",
    "no-var": "error",
    "prefer-const": "error",
    "@typescript-eslint/no-any": "error",
    "@typescript-eslint/explicit-function-return-type": "error"
  }
}
```

## Livewire Standards

### Component Structure
```php
class Converter extends Component
{
    // 1. Properties (public first, then protected/private)
    public string $inputText = '';
    protected array $cache = [];
    
    // 2. Lifecycle hooks
    public function mount(): void {}
    
    // 3. Computed properties
    public function getTransformationsProperty(): Collection {}
    
    // 4. Actions
    public function transform(): void {}
    
    // 5. Validation rules
    protected function rules(): array {}
    
    // 6. Render method (always last)
    public function render(): View {}
}
```

## Automated Standards Enforcement

### Pre-Implementation Check
```bash
#!/bin/bash
# enforce-standards.sh

echo "🔍 Enforcing SCARLETT Standards..."

# PHP Standards
echo "Checking PHP standards..."
./vendor/bin/phpcs --standard=PSR12 app/
./vendor/bin/php-cs-fixer fix --dry-run --diff

# JavaScript Standards  
echo "Checking JavaScript standards..."
npm run lint

# Blade Templates
echo "Checking Blade templates..."
php artisan view:cache
php artisan view:clear

# Database
echo "Checking migrations..."
php artisan migrate:status

# Tests
echo "Checking test coverage..."
php artisan test --coverage --min=80

echo "✅ Standards check complete"
```

### Auto-Fix Violations
```bash
#!/bin/bash
# auto-fix-standards.sh

echo "🔧 Auto-fixing standard violations..."

# PHP
./vendor/bin/php-cs-fixer fix
./vendor/bin/phpcbf app/

# JavaScript
npm run lint:fix

# Blade formatting
php artisan blade:format

# Sort imports
php artisan imports:sort

echo "✅ Auto-fix complete"
```

## Prohibited Patterns Scanner

```bash
#!/bin/bash
# scan-prohibited.sh

VIOLATIONS=0

# Check for TODOs
if grep -r "TODO\|FIXME" app/ resources/; then
  echo "❌ TODO/FIXME comments found"
  ((VIOLATIONS++))
fi

# Check for hardcoded values
if grep -rE "['\"]http://localhost|127\.0\.0\.1['\"]" app/; then
  echo "❌ Hardcoded URLs found"
  ((VIOLATIONS++))
fi

# Check for generic exception handling
if grep -r "catch.*Exception.*\$e" app/ | grep -v "\\\\Exception"; then
  echo "❌ Generic exception catching found"
  ((VIOLATIONS++))
fi

# Check for dd() or dump()
if grep -r "dd(\|dump(" app/ resources/; then
  echo "❌ Debug functions found"
  ((VIOLATIONS++))
fi

# Check for inline styles/scripts in Blade
if grep -r "<style>\|<script>" resources/views/; then
  echo "❌ Inline styles/scripts found (CSP violation)"
  ((VIOLATIONS++))
fi

if [ $VIOLATIONS -eq 0 ]; then
  echo "✅ No prohibited patterns found"
else
  echo "⛔ $VIOLATIONS violation(s) found - Fix required"
  exit 1
fi
```

## Quality Metrics

### Code Complexity Check
```bash
# PHP Metrics
./vendor/bin/phpmetrics --report-html=metrics app/

# Cyclomatic complexity
./vendor/bin/phpmnd app/ --non-zero-exit-on-violation

# Copy-paste detection
./vendor/bin/phpcpd app/
```

### Performance Standards
```php
// Required performance attributes
#[Benchmark(iterations: 100, maxTime: 0.1)]
public function transform(string $text, string $type): string
{
    // Must complete in < 100ms
}
```

## Usage Examples

```bash
# Check entire project
/enforce-standards .

# Check specific directory
/enforce-standards app/Livewire

# Check single file
/enforce-standards app/Livewire/Converter.php

# Auto-fix violations
/enforce-standards . --fix

# Generate report
/enforce-standards . --report=html
```

## Enforcement Levels

1. **ERROR** - Must fix immediately
2. **WARNING** - Should fix before commit  
3. **INFO** - Consider improving

Non-negotiable: ERROR level violations block all progress.
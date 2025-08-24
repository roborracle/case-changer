# Tool Page Content & Schema Template

## Standardized Tool Page Structure

Every tool page must include the following components to ensure consistency, SEO optimization, and proper Schema.org markup:

## 1. Tool Service Method Template
```php
// app/Services/TransformationService.php

/**
 * [Tool Name] - [Brief description]
 * 
 * @param string $text Input text to transform
 * @param array $options Optional configuration
 * @return string Transformed text
 */
public function to[ToolName](string $text, array $options = []): string
{
    // Implementation
    return $transformedText;
}
```

## 2. Route Definition Template
```php
// routes/web.php

Route::get('/tools/[category-slug]/[tool-slug]', function() {
    return view('tools.[category].[tool]', [
        'schemaData' => app(SchemaService::class)->getToolSchema('[tool-name]')
    ]);
})->name('tools.[category].[tool]');
```

## 3. Blade View Template
```blade
{{-- resources/views/tools/[category]/[tool].blade.php --}}

@extends('conversions.layout')

@section('title', '[Tool Name] - Free Online [Tool Purpose] | Case Changer Pro')
@section('description', '[Tool meta description 150-160 chars covering main functionality and benefits]')
@section('keywords', '[tool-name], [variations], online [tool], free [tool category], text [transformation type]')

@section('content')
<div class="min-h-screen" style="background-color: var(--bg-secondary);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Hero Section --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold mb-4" style="color: var(--text-primary);">
                [Tool Name]
            </h1>
            <p class="text-xl" style="color: var(--text-secondary);">
                [Tool tagline - what it does in one sentence]
            </p>
        </div>

        {{-- Tool Component --}}
        <livewire:tool-component tool="[tool-identifier]" />

        {{-- Features Section --}}
        <div class="mt-12 grid md:grid-cols-3 gap-6">
            <div class="text-center p-6 rounded-lg" style="background-color: var(--bg-primary);">
                <div class="text-3xl mb-3">[Icon]</div>
                <h3 class="font-semibold mb-2" style="color: var(--text-primary);">[Feature 1]</h3>
                <p style="color: var(--text-secondary);">[Feature 1 description]</p>
            </div>
            <div class="text-center p-6 rounded-lg" style="background-color: var(--bg-primary);">
                <div class="text-3xl mb-3">[Icon]</div>
                <h3 class="font-semibold mb-2" style="color: var(--text-primary);">[Feature 2]</h3>
                <p style="color: var(--text-secondary);">[Feature 2 description]</p>
            </div>
            <div class="text-center p-6 rounded-lg" style="background-color: var(--bg-primary);">
                <div class="text-3xl mb-3">[Icon]</div>
                <h3 class="font-semibold mb-2" style="color: var(--text-primary);">[Feature 3]</h3>
                <p style="color: var(--text-secondary);">[Feature 3 description]</p>
            </div>
        </div>

        {{-- How to Use Section --}}
        <div class="mt-12 rounded-xl p-8" style="background-color: var(--bg-primary);">
            <h2 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">
                How to Use [Tool Name]
            </h2>
            <ol class="space-y-4" style="color: var(--text-secondary);">
                <li class="flex">
                    <span class="font-bold mr-3">1.</span>
                    <span>[Step 1 instruction]</span>
                </li>
                <li class="flex">
                    <span class="font-bold mr-3">2.</span>
                    <span>[Step 2 instruction]</span>
                </li>
                <li class="flex">
                    <span class="font-bold mr-3">3.</span>
                    <span>[Step 3 instruction]</span>
                </li>
            </ol>
        </div>

        {{-- Examples Section --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">
                Examples
            </h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="p-6 rounded-lg" style="background-color: var(--bg-primary);">
                    <h3 class="font-semibold mb-3" style="color: var(--text-primary);">Input:</h3>
                    <pre class="p-4 rounded" style="background-color: var(--bg-secondary);"><code>[Example input]</code></pre>
                </div>
                <div class="p-6 rounded-lg" style="background-color: var(--bg-primary);">
                    <h3 class="font-semibold mb-3" style="color: var(--text-primary);">Output:</h3>
                    <pre class="p-4 rounded" style="background-color: var(--bg-secondary);"><code>[Example output]</code></pre>
                </div>
            </div>
        </div>

        {{-- Use Cases Section --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">
                Common Use Cases
            </h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold" style="color: var(--text-primary);">[Use Case 1]</h3>
                        <p style="color: var(--text-secondary);">[Description]</p>
                    </div>
                </div>
                {{-- Repeat for 4-6 use cases --}}
            </div>
        </div>

        {{-- FAQ Section --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">
                Frequently Asked Questions
            </h2>
            <div class="space-y-6">
                <div>
                    <h3 class="font-semibold mb-2" style="color: var(--text-primary);">
                        [Question 1]?
                    </h3>
                    <p style="color: var(--text-secondary);">[Answer 1]</p>
                </div>
                {{-- Repeat for 3-5 FAQs --}}
            </div>
        </div>

        {{-- Related Tools --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">
                Related Tools
            </h2>
            <div class="grid md:grid-cols-4 gap-4">
                @foreach($relatedTools as $tool)
                <a href="{{ $tool['url'] }}" class="p-4 rounded-lg text-center hover:shadow-lg transition-shadow" style="background-color: var(--bg-primary);">
                    <div class="text-2xl mb-2">{{ $tool['icon'] }}</div>
                    <div class="font-medium" style="color: var(--text-primary);">{{ $tool['name'] }}</div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
```

## 4. Schema.org Service Method Template
```php
// app/Services/SchemaService.php

public function getToolSchema(string $toolName): array
{
    $baseUrl = config('app.url');
    
    return [
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => '[Tool Name] - Case Changer Pro',
        'description' => '[Tool description for schema]',
        'url' => $baseUrl . '/tools/[category]/[tool]',
        'applicationCategory' => 'UtilitiesApplication',
        'operatingSystem' => 'Any',
        'permissions' => 'browser',
        'offers' => [
            '@type' => 'Offer',
            'price' => '0',
            'priceCurrency' => 'USD'
        ],
        'featureList' => [
            '[Feature 1]',
            '[Feature 2]',
            '[Feature 3]'
        ],
        'screenshot' => $baseUrl . '/images/tools/[tool-name]-screenshot.png',
        'softwareVersion' => '1.0',
        'aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => '4.8',
            'ratingCount' => '[number]',
            'bestRating' => '5',
            'worstRating' => '1'
        ],
        'author' => [
            '@type' => 'Organization',
            'name' => 'Case Changer Pro',
            'url' => $baseUrl
        ],
        'breadcrumb' => [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => $baseUrl
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => '[Category Name]',
                    'item' => $baseUrl . '/tools/[category]'
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => '[Tool Name]',
                    'item' => $baseUrl . '/tools/[category]/[tool]'
                ]
            ]
        ],
        'mainEntity' => [
            '@type' => 'SoftwareApplication',
            'name' => '[Tool Name]',
            'applicationSubCategory' => '[Specific Category]',
            'screenshot' => $baseUrl . '/images/tools/[tool-name].png',
            'datePublished' => '2024-01-01',
            'dateModified' => date('Y-m-d'),
            'inLanguage' => ['en', 'es', 'fr', 'de', 'it', 'pt', 'ru', 'ja', 'zh'],
            'isAccessibleForFree' => true,
            'keywords' => '[tool keywords comma separated]'
        ]
    ];
}
```

## 5. Content Requirements Checklist

### SEO Requirements
- [ ] Unique title (50-60 characters)
- [ ] Meta description (150-160 characters)
- [ ] H1 tag with tool name
- [ ] H2 tags for major sections
- [ ] Alt text for any images
- [ ] Internal links to related tools
- [ ] Canonical URL if needed

### Content Requirements
- [ ] Tool name and purpose clearly stated
- [ ] 3 key features/benefits
- [ ] Step-by-step instructions
- [ ] At least 2 examples (input/output)
- [ ] 4-6 use cases
- [ ] 3-5 FAQs
- [ ] Related tools section

### Schema Requirements
- [ ] WebApplication schema
- [ ] BreadcrumbList schema
- [ ] AggregateRating schema
- [ ] SoftwareApplication schema
- [ ] Offer schema (free)
- [ ] Author/Organization schema

### Technical Requirements
- [ ] Responsive design
- [ ] Dark/light mode support
- [ ] Keyboard accessibility
- [ ] Loading states
- [ ] Error handling
- [ ] Copy to clipboard
- [ ] Download option
- [ ] Character/word count

## 6. Example Content Sets

### Example 1: Bold Text Generator
```php
$toolContent = [
    'name' => 'Bold Text Generator',
    'title' => 'Bold Text Generator - Create Bold Unicode Text Online Free',
    'description' => 'Generate bold text that works anywhere online. Convert normal text to bold Unicode characters for social media, messaging apps, and more.',
    'keywords' => 'bold text, bold font, unicode bold, bold letters, bold text generator',
    'tagline' => 'Create bold text that works everywhere - no HTML or formatting needed',
    'features' => [
        ['icon' => '⚡', 'title' => 'Instant Conversion', 'desc' => 'See bold text as you type'],
        ['icon' => '📱', 'title' => 'Works Everywhere', 'desc' => 'Compatible with all platforms'],
        ['icon' => '🔤', 'title' => 'Unicode Based', 'desc' => 'Uses special Unicode characters']
    ],
    'examples' => [
        'input' => 'Hello World',
        'output' => '𝗛𝗲𝗹𝗹𝗼 𝗪𝗼𝗿𝗹𝗱'
    ],
    'useCases' => [
        'Social media posts that stand out',
        'Discord and Slack messages',
        'YouTube comments and descriptions',
        'WhatsApp and Telegram messages',
        'Email subjects (where supported)',
        'Username and bio formatting'
    ],
    'faqs' => [
        ['q' => 'How does bold text work without formatting?', 'a' => 'It uses special Unicode characters that look like bold letters.'],
        ['q' => 'Will it work on all websites?', 'a' => 'Yes, anywhere that supports Unicode text.'],
        ['q' => 'Can I use it in usernames?', 'a' => 'Most platforms allow it, but check their specific rules.']
    ]
];
```

## 7. Automation Script Template
```php
// app/Console/Commands/GenerateToolPage.php

class GenerateToolPage extends Command
{
    protected $signature = 'make:tool {name} {category}';
    
    public function handle()
    {
        $name = $this->argument('name');
        $category = $this->argument('category');
        
        // Generate service method
        $this->generateServiceMethod($name);
        
        // Generate route
        $this->generateRoute($name, $category);
        
        // Generate view from template
        $this->generateView($name, $category);
        
        // Update schema service
        $this->updateSchemaService($name, $category);
        
        // Add to sitemap
        $this->updateSitemap($name, $category);
        
        $this->info("Tool page generated for: $name");
    }
}
```

## 8. Quality Assurance Checklist

Before deploying any tool page:

### Content QA
- [ ] Spelling and grammar checked
- [ ] Examples tested and accurate
- [ ] Links all working
- [ ] Instructions clear and complete
- [ ] Mobile responsive

### SEO QA
- [ ] Title unique and optimized
- [ ] Description compelling
- [ ] Schema validates (Google Rich Results Test)
- [ ] Page loads < 2 seconds
- [ ] Images optimized

### Functionality QA
- [ ] Tool works correctly
- [ ] Copy button works
- [ ] Download works
- [ ] Error handling works
- [ ] Character limits respected

### Accessibility QA
- [ ] Keyboard navigable
- [ ] Screen reader compatible
- [ ] Color contrast sufficient
- [ ] Focus indicators visible
- [ ] Error messages clear

## 9. Bulk Generation Strategy

For efficient creation of 87 new tools:

1. **Group by similarity** - Tools with similar logic together
2. **Create base classes** - Shared functionality in parent classes
3. **Use factories** - Generate boilerplate automatically
4. **Batch testing** - Test multiple tools at once
5. **Progressive rollout** - Deploy in phases, monitor each

## 10. Monitoring & Maintenance

Post-launch requirements:

- Google Analytics events for tool usage
- Error tracking for transformation failures
- User feedback collection
- Performance monitoring
- Regular content updates
- A/B testing for conversions
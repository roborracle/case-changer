@php
$allCategories = [
    'case-conversions' => [
        'title' => 'Case Conversions',
        'tools' => [
            'uppercase' => 'UPPERCASE',
            'lowercase' => 'lowercase',
            'title-case' => 'Title Case',
            'sentence-case' => 'Sentence case',
            'capitalize-words' => 'Capitalize Words',
            'alternating-case' => 'aLtErNaTiNg CaSe',
            'inverse-case' => 'iNVERSE cASE',
        ]
    ],
    'developer-formats' => [
        'title' => 'Developer Formats',
        'tools' => [
            'camel-case' => 'camelCase',
            'pascal-case' => 'PascalCase',
            'snake-case' => 'snake_case',
            'constant-case' => 'CONSTANT_CASE',
            'kebab-case' => 'kebab-case',
            'dot-case' => 'dot.case',
            'path-case' => 'path/case',
            'namespace-case' => 'namespace\\case',
            'ada-case' => 'Ada_Case',
            'cobol-case' => 'COBOL-CASE',
            'train-case' => 'Train-Case',
            'http-header-case' => 'Http-Header-Case',
        ]
    ],
    'journalistic-styles' => [
        'title' => 'Journalistic Styles',
        'tools' => [
            'ap-style' => 'AP Style',
            'nyt-style' => 'NY Times Style',
            'chicago-style' => 'Chicago Style',
            'guardian-style' => 'Guardian Style',
            'bbc-style' => 'BBC Style',
            'reuters-style' => 'Reuters Style',
            'economist-style' => 'Economist Style',
            'wsj-style' => 'WSJ Style',
        ]
    ],
    'academic-styles' => [
        'title' => 'Academic Styles',
        'tools' => [
            'apa-style' => 'APA Style',
            'mla-style' => 'MLA Style',
            'chicago-author-date' => 'Chicago Author-Date',
            'chicago-notes' => 'Chicago Notes',
            'harvard-style' => 'Harvard Style',
            'vancouver-style' => 'Vancouver Style',
            'ieee-style' => 'IEEE Style',
            'ama-style' => 'AMA Style',
            'bluebook-style' => 'Bluebook Style',
        ]
    ],
    'creative-formats' => [
        'title' => 'Creative Formats',
        'tools' => [
            'reverse' => 'Reverse',
            'aesthetic' => 'Aesthetic',
            'sarcasm' => 'Sarcasm Case',
            'smallcaps' => 'Small Caps',
            'bubble' => 'Bubble Text',
            'square' => 'Square Text',
            'script' => 'Script',
            'double-struck' => 'Double Struck',
            'bold' => 'Bold',
            'italic' => 'Italic',
            'emoji-case' => 'Emoji Case',
        ]
    ],
    'business-formats' => [
        'title' => 'Business Formats',
        'tools' => [
            'email-style' => 'Email Style',
            'legal-style' => 'Legal Style',
            'marketing-headline' => 'Marketing Headline',
            'press-release' => 'Press Release',
            'memo-style' => 'Memo Style',
            'report-style' => 'Report Style',
            'proposal-style' => 'Proposal Style',
            'invoice-style' => 'Invoice Style',
        ]
    ],
    'social-media-formats' => [
        'title' => 'Social Media',
        'tools' => [
            'twitter-style' => 'Twitter/X Style',
            'instagram-style' => 'Instagram Style',
            'linkedin-style' => 'LinkedIn Style',
            'facebook-style' => 'Facebook Style',
            'youtube-title' => 'YouTube Title',
            'tiktok-style' => 'TikTok Style',
            'hashtag-style' => 'Hashtag Style',
            'mention-style' => 'Mention Style',
        ]
    ],
    'technical-documentation' => [
        'title' => 'Tech Docs',
        'tools' => [
            'api-docs' => 'API Documentation',
            'readme-style' => 'README Style',
            'changelog-style' => 'Changelog Style',
            'user-manual' => 'User Manual',
            'technical-spec' => 'Technical Spec',
            'code-comments' => 'Code Comments',
            'wiki-style' => 'Wiki Style',
            'markdown-style' => 'Markdown Style',
        ]
    ],
    'international-formats' => [
        'title' => 'International',
        'tools' => [
            'british-english' => 'British English',
            'american-english' => 'American English',
            'canadian-english' => 'Canadian English',
            'australian-english' => 'Australian English',
            'eu-format' => 'EU Format',
            'iso-format' => 'ISO Format',
            'unicode-normalize' => 'Unicode Normalize',
            'ascii-convert' => 'ASCII Convert',
        ]
    ],
    'utility-transformations' => [
        'title' => 'Utilities',
        'tools' => [
            'remove-spaces' => 'Remove Spaces',
            'remove-extra-spaces' => 'Remove Extra Spaces',
            'add-dashes' => 'Add Dashes',
            'add-underscores' => 'Add Underscores',
            'add-periods' => 'Add Periods',
            'remove-punctuation' => 'Remove Punctuation',
            'extract-letters' => 'Extract Letters',
            'extract-numbers' => 'Extract Numbers',
            'remove-duplicates' => 'Remove Duplicates',
            'sort-words' => 'Sort Words',
            'shuffle-words' => 'Shuffle Words',
            'word-frequency' => 'Word Frequency',
        ]
    ],
];
@endphp

<footer class="mt-auto" style="background-color: var(--bg-tertiary); color: var(--text-secondary); border-top: 1px solid var(--border-primary);">
    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Top Section with Logo and Description -->
        <div class="mb-12 pb-8" style="border-bottom: 1px solid var(--border-primary);">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1">
                    <h2 class="text-2xl font-bold mb-3" style="color: var(--accent-primary);">
                        Case Changer Pro
                    </h2>
                    <p class="text-sm mb-4" style="color: var(--text-tertiary);">
                        Professional text transformation tools for developers, writers, and content creators. 
                        Convert between 90+ text formats instantly.
                    </p>
                    <div class="flex space-x-4">
                        <a href="{{ route('modern-case-changer') }}" 
                           class="px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors" 
                           style="background-color: var(--accent-primary);" 
                           onmouseover="this.style.filter = 'brightness(1.1)';" 
                           onmouseout="this.style.filter = '';">
                            Quick Convert
                        </a>
                        <a href="{{ route('conversions.index') }}" 
                           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors" 
                           style="background-color: var(--bg-secondary); color: var(--text-secondary); border: 1px solid var(--border-primary);" 
                           onmouseover="this.style.backgroundColor = 'var(--bg-primary)';" 
                           onmouseout="this.style.backgroundColor = 'var(--bg-secondary)';">
                            Browse All Tools
                        </a>
                    </div>
                </div>
                
                <!-- Popular Tools -->
                <div class="md:col-span-1">
                    <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary);">Most Popular Tools</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">UPPERCASE Converter</a></li>
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">lowercase Converter</a></li>
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'title-case']) }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">Title Case Converter</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">camelCase Converter</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">snake_case Converter</a></li>
                        <li><a href="{{ route('conversions.tool', ['journalistic-styles', 'ap-style']) }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">AP Style Guide</a></li>
                    </ul>
                </div>
                
                <!-- Quick Links -->
                <div class="md:col-span-1">
                    <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary);">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">Home</a></li>
                        <li><a href="{{ route('conversions.index') }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">All Conversion Tools</a></li>
                        <li><a href="{{ route('modern-case-changer') }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">Modern Interface</a></li>
                        <li><a href="{{ route('case-changer') }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">Classic Interface</a></li>
                        <li><a href="{{ route('sitemap') }}" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">Sitemap</a></li>
                        <li><a href="#" class="text-sm transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">API Documentation</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- All Categories Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach(array_slice($allCategories, 0, 5) as $catSlug => $category)
            <div>
                <h4 class="text-sm font-semibold mb-3">
                    <a href="{{ route('conversions.category', $catSlug) }}" class="transition-colors" style="color: var(--text-primary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-primary)';">
                        {{ $category['title'] }}
                    </a>
                </h4>
                <ul class="space-y-1.5">
                    @foreach(array_slice($category['tools'], 0, 6) as $toolSlug => $toolName)
                    <li>
                        <a href="{{ route('conversions.tool', [$catSlug, $toolSlug]) }}" 
                           class="text-xs transition-colors" 
                           style="color: var(--text-tertiary);" 
                           onmouseover="this.style.color = 'var(--text-primary)';" 
                           onmouseout="this.style.color = 'var(--text-tertiary)';">
                            {{ $toolName }}
                        </a>
                    </li>
                    @endforeach
                    @if(count($category['tools']) > 6)
                    <li>
                        <a href="{{ route('conversions.category', $catSlug) }}" 
                           class="text-xs font-medium transition-colors"
                           style="color: var(--accent-primary);" 
                           onmouseover="this.style.filter = 'brightness(1.2)';" 
                           onmouseout="this.style.filter = '';">
                            View all →
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @endforeach
        </div>
        
        <!-- Second Row of Categories -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mt-6">
            @foreach(array_slice($allCategories, 5, 5) as $catSlug => $category)
            <div>
                <h4 class="text-sm font-semibold mb-3">
                    <a href="{{ route('conversions.category', $catSlug) }}" class="transition-colors" style="color: var(--text-primary);" onmouseover="this.style.color = 'var(--accent-primary)';" onmouseout="this.style.color = 'var(--text-primary)';">
                        {{ $category['title'] }}
                    </a>
                </h4>
                <ul class="space-y-1.5">
                    @foreach(array_slice($category['tools'], 0, 6) as $toolSlug => $toolName)
                    <li>
                        <a href="{{ route('conversions.tool', [$catSlug, $toolSlug]) }}" 
                           class="text-xs transition-colors" 
                           style="color: var(--text-tertiary);" 
                           onmouseover="this.style.color = 'var(--text-primary)';" 
                           onmouseout="this.style.color = 'var(--text-tertiary)';">
                            {{ $toolName }}
                        </a>
                    </li>
                    @endforeach
                    @if(count($category['tools']) > 6)
                    <li>
                        <a href="{{ route('conversions.category', $catSlug) }}" 
                           class="text-xs font-medium transition-colors"
                           style="color: var(--accent-primary);" 
                           onmouseover="this.style.filter = 'brightness(1.2)';" 
                           onmouseout="this.style.filter = '';">
                            View all →
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Bottom Bar -->
    <div style="background-color: var(--bg-secondary); border-top: 1px solid var(--border-primary);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm" style="color: var(--text-tertiary);">
                    © 2025 Case Changer Pro. Professional Text Transformation Tools.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="{{ route('privacy') }}" class="text-sm transition-colors" style="color: var(--text-tertiary);" onmouseover="this.style.color = 'var(--text-primary)';" onmouseout="this.style.color = 'var(--text-tertiary)';">Privacy Policy</a>
                    <a href="{{ route('terms') }}" class="text-sm transition-colors" style="color: var(--text-tertiary);" onmouseover="this.style.color = 'var(--text-primary)';" onmouseout="this.style.color = 'var(--text-tertiary)';">Terms of Service</a>
                    <a href="{{ route('about') }}" class="text-sm transition-colors" style="color: var(--text-tertiary);" onmouseover="this.style.color = 'var(--text-primary)';" onmouseout="this.style.color = 'var(--text-tertiary)';">About</a>
                    <a href="{{ route('contact') }}" class="text-sm transition-colors" style="color: var(--text-tertiary);" onmouseover="this.style.color = 'var(--text-primary)';" onmouseout="this.style.color = 'var(--text-tertiary)';">Contact</a>
                    <a href="/sitemap.xml" class="text-sm transition-colors" style="color: var(--text-tertiary);" onmouseover="this.style.color = 'var(--text-primary)';" onmouseout="this.style.color = 'var(--text-tertiary)';">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>
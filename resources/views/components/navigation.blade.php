@php
$categories = [
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
        ]
    ],
    'academic-styles' => [
        'title' => 'Academic Styles',
        'tools' => [
            'apa-style' => 'APA Style',
            'mla-style' => 'MLA Style',
            'chicago-author-date' => 'Chicago Author-Date',
            'harvard-style' => 'Harvard Style',
            'ieee-style' => 'IEEE Style',
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
        ]
    ],
];
@endphp

<nav class="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo and Desktop Navigation -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent">
                        Case Changer Pro
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:ml-10 md:flex md:items-center md:space-x-1">
                    <!-- Home -->
                    <a href="/" class="inline-flex items-center h-full px-4 py-2 text-sm font-medium rounded-md transition-colors"
                       style="color: var(--text-secondary);"
                       onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';"
                       onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
                        Home
                    </a>

                    <!-- All Tools Dropdown -->
                    <div class="relative">
                        <a href="/" 
                           class="inline-flex items-center h-full px-4 py-2 text-sm font-medium rounded-md transition-colors"
                           style="color: var(--text-secondary);"
                           onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';"
                           onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
                            All Tools
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        
                        <!-- Mega Dropdown (functionality disabled) -->
                        <div class="absolute left-0 mt-2 w-screen max-w-4xl shadow-xl rounded-lg border"
                             style="background-color: var(--bg-primary); border-color: var(--border-primary); display: none;">
                            <div class="p-6">
                                <div class="grid grid-cols-3 gap-8">
                                    @foreach(array_slice($categories, 0, 3) as $catSlug => $category)
                                    <div>
                                        <a href="{{ route('conversions.category', $catSlug) }}" 
                                           class="text-sm font-semibold transition-colors"
                                           style="color: var(--text-primary);"
                                           onmouseover="this.style.color = 'var(--accent-primary)';"
                                           onmouseout="this.style.color = 'var(--text-primary)';">
                                            {{ $category['title'] }}
                                        </a>
                                        <ul class="mt-3 space-y-2">
                                            @foreach(array_slice($category['tools'], 0, 5) as $toolSlug => $toolName)
                                            <li>
                                                <a href="{{ route('conversions.tool', [$catSlug, $toolSlug]) }}" 
                                                   class="text-sm transition-colors"
                                                   style="color: var(--text-secondary);"
                                                   onmouseover="this.style.color = 'var(--accent-primary)';"
                                                   onmouseout="this.style.color = 'var(--text-secondary)';">
                                                    {{ $toolName }}
                                                </a>
                                            </li>
                                            @endforeach
                                            @if(count($category['tools']) > 5)
                                            <li>
                                                <a href="{{ route('conversions.category', $catSlug) }}" 
                                                   class="text-sm font-medium transition-colors"
                                                   style="color: var(--accent-primary);">
                                                    View all →
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <div class="grid grid-cols-4 gap-4">
                                        @foreach(array_slice($categories, 3, 2) as $catSlug => $category)
                                        <a href="{{ route('conversions.category', $catSlug) }}" 
                                           class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                            {{ $category['title'] }}
                                            <span class="ml-auto text-xs text-gray-500">{{ count($category['tools']) }}</span>
                                        </a>
                                        @endforeach
                                        <a href="/" 
                                           class="flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            View All Categories
                                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Access -->
                    <a href="/#converter" 
                       class="inline-flex items-center h-full px-4 py-2 text-sm font-medium rounded-md transition-colors"
                       style="color: var(--text-secondary);"
                       onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';"
                       onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
                        Quick Convert
                    </a>

                    <!-- Popular Tools Dropdown -->
                    <div class="relative">
                        <button class="inline-flex items-center h-full px-4 py-2 text-sm font-medium rounded-md transition-colors"
                                style="color: var(--text-secondary);"
                                onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';"
                                onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
                            Popular
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-64 shadow-xl rounded-lg border"
                             style="background-color: var(--bg-primary); border-color: var(--border-primary); display: none;">
                            <div class="p-2">
                                <a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}" 
                                   class="block px-4 py-2.5 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">UPPERCASE</a>
                                <a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}" 
                                   class="block px-4 py-2.5 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">lowercase</a>
                                <a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" 
                                   class="block px-4 py-2.5 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">camelCase</a>
                                <a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" 
                                   class="block px-4 py-2.5 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">snake_case</a>
                                <a href="{{ route('conversions.tool', ['journalistic-styles', 'ap-style']) }}" 
                                   class="block px-4 py-2.5 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">AP Style</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Theme Toggle, Search and Mobile Menu -->
            <div class="flex items-center space-x-2">
                <!-- Theme Toggle (functionality disabled) -->
                <div class="relative">
                    <button class="p-2 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700">
                        <!-- Theme Icon -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Search Button (functionality disabled) -->
                <button class="p-2 rounded-md transition-colors"
                        style="color: var(--text-secondary);"
                        onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';"
                        onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Mobile menu button (functionality disabled) -->
                <button class="md:hidden p-2 rounded-md transition-colors"
                        style="color: var(--text-secondary);"
                        onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';"
                        onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation (functionality disabled) -->
    <div class="md:hidden border-t shadow-lg"
         style="background-color: var(--bg-primary); border-color: var(--border-primary); display: none;">
        <div class="px-4 py-3 space-y-1">
            <a href="/" class="block px-4 py-2.5 text-base font-medium rounded-md transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';" onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">Home</a>
            <span class="block px-4 py-2.5 text-base font-medium rounded-md transition-colors" style="color: var(--text-secondary);">All Tools</span>
            <span class="block px-4 py-2.5 text-base font-medium rounded-md transition-colors" style="color: var(--text-secondary);">Quick Convert</span>
            
            <div class="pt-3 mt-3 border-t" style="border-color: var(--border-primary);">
                <p class="px-4 py-2 text-xs font-semibold uppercase tracking-wider" style="color: var(--text-tertiary);">Categories</p>
                @foreach($categories as $catSlug => $category)
                <span class="block px-4 py-2 text-sm rounded-md transition-colors" style="color: var(--text-secondary);">
                    {{ $category['title'] }}
                    <span class="text-xs ml-1" style="color: var(--text-tertiary);">({{ count($category['tools']) }})</span>
                </span>
                @endforeach
            </div>
        </div>
    </div>
</nav>

<!-- Search Modal (functionality disabled) -->
<div class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-start justify-center min-h-screen pt-20 px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="relative rounded-lg shadow-xl max-w-2xl w-full"
             style="background-color: var(--bg-primary);">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 mr-3" style="color: var(--text-tertiary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" 
                           placeholder="Search for conversion tools..." 
                           class="flex-1 text-lg outline-none"
                           style="background-color: transparent; color: var(--text-primary);">
                    <button style="color: var(--text-tertiary);" onmouseover="this.style.color = 'var(--text-secondary)';" onmouseout="this.style.color = 'var(--text-tertiary)';">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Quick Links -->
                <div class="border-t pt-4" style="border-color: var(--border-primary);">
                    <p class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: var(--text-tertiary);">Quick Access</p>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="px-3 py-2 text-sm rounded-lg transition-colors" style="color: var(--text-secondary);">UPPERCASE</span>
                        <span class="px-3 py-2 text-sm rounded-lg transition-colors" style="color: var(--text-secondary);">lowercase</span>
                        <span class="px-3 py-2 text-sm rounded-lg transition-colors" style="color: var(--text-secondary);">camelCase</span>
                        <span class="px-3 py-2 text-sm rounded-lg transition-colors" style="color: var(--text-secondary);">snake_case</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

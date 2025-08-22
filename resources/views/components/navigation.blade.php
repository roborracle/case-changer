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

<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40" x-data="{ mobileMenu: false, openDropdown: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Desktop Navigation -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Case Changer Pro
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:ml-8 md:flex md:space-x-4 lg:space-x-6">
                    <!-- Home -->
                    <a href="/" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        Home
                    </a>

                    <!-- All Tools Dropdown -->
                    <div class="relative" @mouseenter="openDropdown = 'tools'" @mouseleave="openDropdown = null">
                        <a href="{{ route('conversions.index') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            All Tools
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        
                        <!-- Mega Dropdown -->
                        <div x-show="openDropdown === 'tools'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-0 w-screen max-w-4xl bg-white shadow-lg rounded-b-lg border border-gray-200"
                             style="display: none;">
                            <div class="p-6">
                                <div class="grid grid-cols-3 gap-8">
                                    @foreach(array_slice($categories, 0, 3) as $catSlug => $category)
                                    <div>
                                        <a href="{{ route('conversions.category', $catSlug) }}" 
                                           class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                            {{ $category['title'] }}
                                        </a>
                                        <ul class="mt-3 space-y-2">
                                            @foreach(array_slice($category['tools'], 0, 5) as $toolSlug => $toolName)
                                            <li>
                                                <a href="{{ route('conversions.tool', [$catSlug, $toolSlug]) }}" 
                                                   class="text-sm text-gray-600 hover:text-blue-600 transition-colors">
                                                    {{ $toolName }}
                                                </a>
                                            </li>
                                            @endforeach
                                            @if(count($category['tools']) > 5)
                                            <li>
                                                <a href="{{ route('conversions.category', $catSlug) }}" 
                                                   class="text-sm text-blue-600 hover:text-blue-700 font-medium">
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
                                        <a href="{{ route('conversions.index') }}" 
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
                    <a href="{{ route('modern-case-changer') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        Quick Convert
                    </a>

                    <!-- Popular Tools Dropdown -->
                    <div class="relative" @mouseenter="openDropdown = 'popular'" @mouseleave="openDropdown = null">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            Popular
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="openDropdown === 'popular'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-0 w-64 bg-white shadow-lg rounded-b-lg border border-gray-200"
                             style="display: none;">
                            <div class="p-2">
                                <a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">UPPERCASE</a>
                                <a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">lowercase</a>
                                <a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">camelCase</a>
                                <a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">snake_case</a>
                                <a href="{{ route('conversions.tool', ['journalistic-styles', 'ap-style']) }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">AP Style</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Mobile Menu -->
            <div class="flex items-center space-x-4">
                <!-- Search Button -->
                <button @click="$dispatch('open-search')" 
                        class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Mobile menu button -->
                <button @click="mobileMenu = !mobileMenu" 
                        class="md:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-show="mobileMenu" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="md:hidden bg-white border-t border-gray-200"
         style="display: none;">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="/" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Home</a>
            <a href="{{ route('conversions.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 rounded-lg">All Tools</a>
            <a href="{{ route('modern-case-changer') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Quick Convert</a>
            
            <div class="pt-2 border-t border-gray-200">
                <p class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Categories</p>
                @foreach($categories as $catSlug => $category)
                <a href="{{ route('conversions.category', $catSlug) }}" 
                   class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                    {{ $category['title'] }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div x-data="{ open: false }" 
     x-show="open" 
     @open-search.window="open = true"
     @keydown.escape.window="open = false"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-start justify-center min-h-screen pt-20 px-4">
        <div x-show="open" 
             @click="open = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full"
             @click.stop>
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" 
                           placeholder="Search for conversion tools..." 
                           class="flex-1 text-lg outline-none"
                           x-ref="searchInput"
                           x-init="$watch('open', value => { if (value) $nextTick(() => $refs.searchInput.focus()) })">
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Quick Links -->
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Quick Access</p>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}" 
                           class="px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">UPPERCASE</a>
                        <a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}" 
                           class="px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">lowercase</a>
                        <a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" 
                           class="px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">camelCase</a>
                        <a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" 
                           class="px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">snake_case</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
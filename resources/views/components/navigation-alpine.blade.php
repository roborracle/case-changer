@php
$categories = [
    'case-conversions' => [
        'title' => 'Case Conversions',
        'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
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
        'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
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
        'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
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
        'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
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
        'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
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

<nav class="nav-glass sticky top-0 z-50 border-b border-white/10" x-data role="navigation" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo and Desktop Navigation -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="text-xl font-bold bg-gradient-to-r from-apple-blue to-apple-cyan bg-clip-text text-transparent hover:opacity-80 transition-opacity">
                        Case Changer Pro
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:ml-10 md:flex md:items-center md:space-x-1">
                    <!-- Home -->
                    <a href="/" class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        Home
                    </a>

                    <!-- All Tools Dropdown -->
                    <div class="relative" x-data="navigationDropdown">
                        <button @click="toggle()"
                            @click.away="close()"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800"
                            :aria-expanded="open.toString()"
                            aria-haspopup="true"
                            aria-label="All tools dropdown">
                            All Tools
                            <svg class="ml-1 w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Mega Dropdown -->
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute left-0 mt-2 w-screen max-w-4xl dropdown-glass"
                            x-cloak>
                            <div class="p-6">
                                <div class="grid grid-cols-3 gap-8">
                                    @foreach(array_slice($categories, 0, 3) as $catSlug => $category)
                                    <div>
                                        <a href="{{ route('conversions.category', $catSlug) }}"
                                            class="text-sm font-semibold text-gray-900 dark:text-white hover:text-apple-blue dark:hover:text-apple-cyan transition-colors">
                                            {{ $category['title'] }}
                                        </a>
                                        <ul class="mt-3 space-y-2">
                                            @foreach(array_slice($category['tools'], 0, 5) as $toolSlug => $toolName)
                                            <li>
                                                <a href="{{ route('conversions.tool', [$catSlug, $toolSlug]) }}"
                                                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-apple-blue dark:hover:text-apple-cyan transition-colors">
                                                    {{ $toolName }}
                                                </a>
                                            </li>
                                            @endforeach
                                            @if(count($category['tools']) > 5)
                                            <li>
                                                <a href="{{ route('conversions.category', $catSlug) }}"
                                                    class="text-sm font-medium text-apple-blue hover:text-apple-blue-darker transition-colors">
                                                    View all →
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <div class="grid grid-cols-4 gap-4">
                                        @foreach(array_slice($categories, 3, 2) as $catSlug => $category)
                                        <a href="{{ route('conversions.category', $catSlug) }}"
                                            class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                            {{ $category['title'] }}
                                            <span class="ml-auto text-xs text-gray-500">{{ count($category['tools']) }}</span>
                                        </a>
                                        @endforeach
                                        <a href="{{ route('conversions.index') }}"
                                            class="flex items-center px-3 py-2 text-sm font-medium text-apple-blue hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
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
                        class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        Quick Convert
                    </a>

                    <!-- Popular Tools Dropdown -->
                    <div class="relative" x-data="navigationDropdown">
                        <button @click="toggle()"
                            @click.away="close()"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800"
                            :aria-expanded="open.toString()"
                            aria-haspopup="true"
                            aria-label="Popular tools dropdown">
                            Popular
                            <svg class="ml-1 w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute right-0 mt-2 w-64 dropdown-glass"
                            x-cloak>
                            <div class="p-2">
                                <a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}"
                                    class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors">UPPERCASE</a>
                                <a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}"
                                    class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors">lowercase</a>
                                <a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}"
                                    class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors">camelCase</a>
                                <a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}"
                                    class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors">snake_case</a>
                                <a href="{{ route('conversions.tool', ['journalistic-styles', 'ap-style']) }}"
                                    class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors">AP Style</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Theme Toggle, Search and Mobile Menu -->
            <div class="flex items-center space-x-2">
                <!-- Theme Toggle -->
                <div class="relative" x-data="themeToggle">
                    <button @click="toggleMenu()"
                        @click.away="showMenu = false"
                        class="p-2 rounded-md transition-colors text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-apple-blue"
                        aria-label="Theme toggle">
                        <!-- Sun Icon (Light Mode) -->
                        <svg x-show="getIcon() === 'sun'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <!-- Moon Icon (Dark Mode) -->
                        <svg x-show="getIcon() === 'moon'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <!-- System Icon -->
                        <svg x-show="getIcon() === 'system'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </button>

                    <!-- Theme Menu -->
                    <div x-show="showMenu"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-36 dropdown-glass"
                        x-cloak>
                        <div class="py-1">
                            <button @click="setTheme('light')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Light
                            </button>
                            <button @click="setTheme('dark')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                                Dark
                            </button>
                            <button @click="setTheme('system')" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                System
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search Button -->
                <button @click="$store.navigation.toggleSearchModal()"
                    class="p-2 rounded-md transition-colors text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-apple-blue"
                    aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Mobile menu button -->
                <button @click="$store.navigation.toggleMobileMenu()"
                    class="md:hidden p-2 rounded-md transition-colors text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-apple-blue"
                    aria-label="Toggle mobile menu"
                    :aria-expanded="$store.navigation.mobileMenuOpen.toString()">
                    <svg x-show="!$store.navigation.mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="$store.navigation.mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-show="$store.navigation.mobileMenuOpen"
        role="dialog"
        aria-label="Mobile navigation menu"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900"
        x-cloak>
        <div class="px-4 py-3 space-y-1" x-data="{ expandedCategory: null }">
            <a href="/" class="block px-4 py-2.5 text-base font-medium rounded-md transition-colors text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Home</a>
            <a href="{{ route('conversions.index') }}" class="block px-4 py-2.5 text-base font-medium rounded-md transition-colors text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">All Tools</a>
            <a href="{{ route('modern-case-changer') }}" class="block px-4 py-2.5 text-base font-medium rounded-md transition-colors text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Quick Convert</a>

            <div class="pt-3 mt-3 border-t border-gray-200 dark:border-gray-700">
                <p class="px-4 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Categories</p>
                @foreach($categories as $catSlug => $category)
                <div>
                    <button @click="expandedCategory = expandedCategory === '{{ $catSlug }}' ? null : '{{ $catSlug }}'"
                        class="flex items-center justify-between w-full px-4 py-2 text-sm rounded-md transition-colors text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <span>{{ $category['title'] }}</span>
                        <span class="flex items-center">
                            <span class="text-xs mr-2 text-gray-500">({{ count($category['tools']) }})</span>
                            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': expandedCategory === '{{ $catSlug }}'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </span>
                    </button>
                    <div x-show="expandedCategory === '{{ $catSlug }}'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-cloak
                        class="pl-8 pr-4 py-2 space-y-1">
                        @foreach($category['tools'] as $toolSlug => $toolName)
                        <a href="{{ route('conversions.tool', [$catSlug, $toolSlug]) }}"
                            class="block px-3 py-1.5 text-sm text-gray-600 dark:text-gray-400 hover:text-apple-blue dark:hover:text-apple-cyan transition-colors">
                            {{ $toolName }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div x-show="$store.navigation.searchModalOpen"
    @keydown.escape.window="$store.navigation.closeSearchModal()"
    class="fixed inset-0 z-50 overflow-y-auto"
    role="dialog"
    aria-modal="true"
    aria-label="Search for conversion tools"
    x-cloak>
    <div class="flex items-start justify-center min-h-screen pt-20 px-4">
        <!-- Overlay -->
        <div @click="$store.navigation.closeSearchModal()"
            x-show="$store.navigation.searchModalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 modal-overlay-glass"></div>

        <!-- Modal -->
        <div x-show="$store.navigation.searchModalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative glass-card max-w-2xl w-full"
            x-data="searchModal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text"
                        x-ref="searchInput"
                        x-model="query"
                        @input.debounce.300ms="search()"
                        @keydown="handleKeydown($event)"
                        placeholder="Search for conversion tools..."
                        class="flex-1 text-lg outline-none bg-transparent text-gray-900 dark:text-white placeholder-gray-500"
                        id="search-input"
                        aria-label="Search for conversion tools"
                        aria-describedby="search-hint">
                    <button @click="$store.navigation.closeSearchModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                        aria-label="Close search modal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Search Results -->
                <div x-show="results.length > 0" class="border-t border-gray-200 dark:border-gray-700 pt-4" x-cloak>
                    <p class="text-xs font-semibold uppercase tracking-wider mb-3 text-gray-500">Search Results</p>
                    <div class="space-y-1">
                        <template x-for="(result, index) in results" :key="index">
                            <a :href="result.url"
                                @click="selectResult(index)"
                                @mouseover="selectedIndex = index"
                                :class="{'bg-gray-100 dark:bg-gray-800': selectedIndex === index} block px-3 py-2 rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-800">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="result.name"></span>
                                    <span class="text-xs text-gray-500" x-text="result.category"></span>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Loading State -->
                <div x-show="loading" class="border-t border-gray-200 dark:border-gray-700 pt-4" x-cloak>
                    <div class="flex items-center justify-center py-8">
                        <div class="spinner"></div>
                        <span class="ml-3 text-sm text-gray-500">Searching...</span>
                    </div>
                </div>

                <!-- Quick Links (when no search) -->
                <div x-show="query.length === 0" class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <p class="text-xs font-semibold uppercase tracking-wider mb-3 text-gray-500">Quick Access</p>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}" class="px-3 py-2 text-sm rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">UPPERCASE</a>
                        <a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}" class="px-3 py-2 text-sm rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">lowercase</a>
                        <a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" class="px-3 py-2 text-sm rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">camelCase</a>
                        <a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" class="px-3 py-2 text-sm rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">snake_case</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
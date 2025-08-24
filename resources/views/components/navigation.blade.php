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

<nav class="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40" x-data="{ mobileMenu: false, openDropdown: null }">
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
                    <div class="relative" @mouseenter="openDropdown = 'tools'" @mouseleave="openDropdown = null">
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
                        
                        <!-- Mega Dropdown -->
                        <div x-show="openDropdown === 'tools'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-2 w-screen max-w-4xl shadow-xl rounded-lg border"
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
                    <div class="relative" @mouseenter="openDropdown = 'popular'" @mouseleave="openDropdown = null">
                        <button class="inline-flex items-center h-full px-4 py-2 text-sm font-medium rounded-md transition-colors"
                                style="color: var(--text-secondary);"
                                onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';"
                                onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
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
                             class="absolute right-0 mt-2 w-64 shadow-xl rounded-lg border"
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
                <!-- Theme Toggle -->
                <div x-data="{
                    isOpen: false,
                    themes: ['light', 'dark', 'auto'],
                    currentTheme: localStorage.getItem('case-changer-theme') || 'auto',
                    toggleDropdown() {
                        this.isOpen = !this.isOpen;
                    },
                    setTheme(theme) {
                        this.currentTheme = theme;
                        localStorage.setItem('case-changer-theme', theme);
                        
                        if (theme === 'auto') {
                            localStorage.removeItem('case-changer-theme');
                            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                            document.documentElement.classList.toggle('dark', prefersDark);
                        } else if (theme === 'dark') {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                        
                        // Set cookie for server-side persistence
                        document.cookie = 'case-changer-theme=' + theme + '; path=/; max-age=' + (365 * 24 * 60 * 60) + '; SameSite=Lax';
                        
                        this.isOpen = false;
                    },
                    getCurrentThemeIcon() {
                        const icons = {
                            light: '<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z\"></path></svg>',
                            dark: '<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z\"></path></svg>',
                            auto: '<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z\"></path></svg>'
                        };
                        return icons[this.currentTheme] || icons.auto;
                    },
                    getCurrentThemeDescription() {
                        const descriptions = {
                            light: 'Light',
                            dark: 'Dark',
                            auto: 'System'
                        };
                        return descriptions[this.currentTheme] || 'System';
                    }
                }" x-cloak class="relative">
                    <button @click="toggleDropdown()" 
                            class="p-2 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700"
                            :aria-expanded="isOpen"
                            :aria-label="'Current theme: ' + getCurrentThemeDescription()">
                        <span x-html="getCurrentThemeIcon()"></span>
                    </button>
                    
                    <!-- Theme Dropdown -->
                    <div x-show="isOpen" 
                         @click.away="isOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
                         x-cloak>
                        <div class="py-1">
                            <template x-for="theme in themes" :key="theme">
                                <button @click="selectTheme(theme)"
                                        class="w-full px-4 py-2.5 text-sm text-left transition-colors flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        :class="{ 'font-semibold bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400': currentTheme === theme }">
                                    <span x-html="getThemeIcon(theme)" class="w-5 h-5 flex-shrink-0"></span>
                                    <div class="flex-1">
                                        <div x-text="getThemeLabel(theme)" class="font-medium"></div>
                                        <div x-show="theme === 'system'" class="text-xs opacity-75" x-text="'Auto (' + (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'Dark' : 'Light') + ')'"></div>
                                    </div>
                                    <span x-show="currentTheme === theme" class="flex-shrink-0">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
                
                <!-- Search Button -->
                <button @click="$dispatch('open-search')" 
                        class="p-2 rounded-md transition-colors"
                        style="color: var(--text-secondary);"
                        onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';"
                        onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Mobile menu button -->
                <button @click="mobileMenu = !mobileMenu" 
                        class="md:hidden p-2 rounded-md transition-colors"
                        style="color: var(--text-secondary);"
                        onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';"
                        onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
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
         class="md:hidden border-t shadow-lg"
         style="background-color: var(--bg-primary); border-color: var(--border-primary); display: none;">
        <div class="px-4 py-3 space-y-1">
            <a href="/" class="block px-4 py-2.5 text-base font-medium rounded-md transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';" onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">Home</a>
            <a href="{{ route('conversions.index') }}" class="block px-4 py-2.5 text-base font-medium rounded-md transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';" onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">All Tools</a>
            <a href="{{ route('modern-case-changer') }}" class="block px-4 py-2.5 text-base font-medium rounded-md transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';" onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">Quick Convert</a>
            
            <div class="pt-3 mt-3 border-t" style="border-color: var(--border-primary);">
                <p class="px-4 py-2 text-xs font-semibold uppercase tracking-wider" style="color: var(--text-tertiary);">Categories</p>
                @foreach($categories as $catSlug => $category)
                <a href="{{ route('conversions.category', $catSlug) }}" 
                   class="block px-4 py-2 text-sm rounded-md transition-colors" 
                   style="color: var(--text-secondary);" 
                   onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';" 
                   onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">
                    {{ $category['title'] }}
                    <span class="text-xs ml-1" style="color: var(--text-tertiary);">({{ count($category['tools']) }})</span>
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
             class="relative rounded-lg shadow-xl max-w-2xl w-full"
             style="background-color: var(--bg-primary);"
             @click.stop>
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 mr-3" style="color: var(--text-tertiary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" 
                           placeholder="Search for conversion tools..." 
                           class="flex-1 text-lg outline-none"
                           style="background-color: transparent; color: var(--text-primary);"
                           x-ref="searchInput"
                           x-init="$watch('open', value => { if (value) $nextTick(() => $refs.searchInput.focus()) })">
                    <button @click="open = false" style="color: var(--text-tertiary);" onmouseover="this.style.color = 'var(--text-secondary)';" onmouseout="this.style.color = 'var(--text-tertiary)';">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Quick Links -->
                <div class="border-t pt-4" style="border-color: var(--border-primary);">
                    <p class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: var(--text-tertiary);">Quick Access</p>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}" 
                           class="px-3 py-2 text-sm rounded-lg transition-colors" 
                           style="color: var(--text-secondary);" 
                           onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';" 
                           onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">UPPERCASE</a>
                        <a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}" 
                           class="px-3 py-2 text-sm rounded-lg transition-colors" 
                           style="color: var(--text-secondary);" 
                           onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';" 
                           onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">lowercase</a>
                        <a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" 
                           class="px-3 py-2 text-sm rounded-lg transition-colors" 
                           style="color: var(--text-secondary);" 
                           onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';" 
                           onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">camelCase</a>
                        <a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" 
                           class="px-3 py-2 text-sm rounded-lg transition-colors" 
                           style="color: var(--text-secondary);" 
                           onmouseover="this.style.backgroundColor = 'var(--bg-tertiary)'; this.style.color = 'var(--text-primary)';" 
                           onmouseout="this.style.backgroundColor = 'transparent'; this.style.color = 'var(--text-secondary)';">snake_case</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
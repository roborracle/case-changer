@props(['sticky' => true])

<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 {{ $sticky ? 'sticky top-0 z-50' : '' }}" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Desktop Navigation -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-bold text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                        Case Changer Pro
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:ml-8 sm:flex sm:items-center sm:space-x-8">
                    <a href="/" 
                       class="border-b-2 {{ request()->routeIs('home') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium"
                       {{ request()->routeIs('home') ? 'aria-current="page"' : '' }}>
                        Home
                    </a>
                    
                    <!-- Tools Dropdown -->
                    <div x-data="dropdown" class="relative inline-flex items-center">
                        <button @click="toggle"
                                @keydown.escape="close"
                                :aria-expanded="open"
                                class="border-b-2 {{ request()->is('conversions*') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm h-full">
                            Tools
                            <svg class="ml-2 h-4 w-4 transition-transform" :class="rotateClass" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             @click.away="open = false"
                             x-cloak
                             class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100">
                            <div class="py-1">
                                <a href="/conversions" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    All Tools
                                </a>
                                <a href="/conversions/case-conversions" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    Case Conversions
                                </a>
                                <a href="/conversions/developer-formats" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    Developer Formats
                                </a>
                                <a href="/conversions/text-effects" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    Text Effects
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="/pages/about" 
                       class="border-b-2 {{ request()->routeIs('pages.about') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        About
                    </a>
                    
                    <a href="/pages/faq" 
                       class="border-b-2 {{ request()->routeIs('pages.faq') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        FAQ
                    </a>
                    
                    <a href="/pages/contact" 
                       class="border-b-2 {{ request()->routeIs('pages.contact') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        Contact
                    </a>
                </div>
            </div>

            <!-- Right side items -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                <!-- Theme Toggle -->
                <button x-data="themeToggle"
                        @click="toggleTheme"
                        class="p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md"
                        aria-label="Toggle theme">
                    <svg x-show="isLight" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg x-show="isDark" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button x-data="mobileMenu"
                        @click="toggle"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        :aria-expanded="open"
                        aria-label="Main menu">
                    <svg :class="menuIconClass" class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg :class="closeIconClass" class="hidden h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-data="mobileMenuPanel"
         x-show="open"
         @mobile-menu-toggle.window="open = $event.detail.open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-1"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-1"
         x-cloak
         class="sm:hidden bg-white border-b">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900' }} text-base font-medium">
                Home
            </a>
            
            <a href="/conversions" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('conversions*') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900' }} text-base font-medium">
                All Tools
            </a>
            
            <a href="/pages/about" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('pages.about') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900' }} text-base font-medium">
                About
            </a>
            
            <a href="/pages/faq" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('pages.faq') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900' }} text-base font-medium">
                FAQ
            </a>
            
            <a href="/pages/contact" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('pages.contact') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900' }} text-base font-medium">
                Contact
            </a>
        </div>
        
        <!-- Mobile Theme Toggle -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <button x-data="themeToggle"
                    @click="toggleTheme"
                    class="flex items-center w-full px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                <svg x-show="isLight" class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <svg x-show="isDark" x-cloak class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <span x-text="themeLabel"></span>
            </button>
        </div>
    </div>
</nav>
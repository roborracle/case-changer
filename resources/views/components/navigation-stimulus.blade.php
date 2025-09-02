<!-- Navigation with Stimulus.js - CSP Compliant -->
<nav class="border-b bg-primary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Desktop Navigation -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-xl font-bold flex items-center text-primary">
                        <span class="mr-2">🔄</span>
                        Case Changer Pro
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:ml-6 md:flex md:space-x-8">
                    <a href="/" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->is('/') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-secondary hover:text-primary' }}">
                        Home
                    </a>
                    
                    <!-- Tools Dropdown -->
                    <div class="relative inline-flex items-center" 
                         data-controller="navigation-dropdown"
                         data-action="click@window->navigation-dropdown#clickOutside keydown.escape@window->navigation-dropdown#closeOnEscape">
                        <button type="button" 
                                data-action="click->navigation-dropdown#toggle"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium text-secondary hover:text-primary">
                            Tools
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <div data-navigation-dropdown-target="menu" 
                             class="hidden absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-primary border top-full left-0">
                            <div class="py-1">
                                <a href="/tools/text-case" class="block px-4 py-2 text-sm text-secondary hover:bg-secondary">
                                    Text Case Converter
                                </a>
                                <a href="/tools/developer" class="block px-4 py-2 text-sm text-secondary hover:bg-secondary">
                                    Developer Tools
                                </a>
                                <a href="/tools/style-guides" class="block px-4 py-2 text-sm text-secondary hover:bg-secondary">
                                    Style Guides
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <a href="/about" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->is('about') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-secondary hover:text-primary' }}">
                        About
                    </a>
                    
                    <a href="/api" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->is('api') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-secondary hover:text-primary' }}">
                        API
                    </a>
                </div>
            </div>

            <!-- Right Side Navigation -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <div class="relative" 
                     data-controller="theme-toggle"
                     data-action="click@window->theme-toggle#clickOutside">
                    <button type="button"
                            data-action="click->theme-toggle#toggleMenu"
                            class="p-2 rounded-md text-secondary hover:text-primary hover:bg-secondary">
                        <span data-theme-toggle-target="currentIcon">
                            <!-- Icon will be dynamically updated -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                    </button>
                    
                    <div data-theme-toggle-target="menu"
                         class="hidden absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-primary border">
                        <div class="py-1">
                            <button data-action="click->theme-toggle#setTheme"
                                    data-theme="light"
                                    class="w-full text-left px-4 py-2 text-sm text-secondary hover:bg-secondary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Light
                            </button>
                            <button data-action="click->theme-toggle#setTheme"
                                    data-theme="dark"
                                    class="w-full text-left px-4 py-2 text-sm text-secondary hover:bg-secondary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                Dark
                            </button>
                            <button data-action="click->theme-toggle#setTheme"
                                    data-theme="system"
                                    class="w-full text-left px-4 py-2 text-sm text-secondary hover:bg-secondary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                System
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden" data-controller="mobile-menu">
                    <button type="button"
                            data-action="click->mobile-menu#toggle"
                            class="p-2 rounded-md text-secondary hover:text-primary hover:bg-secondary">
                        <span data-mobile-menu-target="openIcon">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </span>
                        <span data-mobile-menu-target="closeIcon" class="hidden">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </span>
                    </button>
                    
                    <!-- Mobile Menu Panel -->
                    <div data-mobile-menu-target="menu" 
                         class="hidden absolute top-16 left-0 right-0 bg-primary border-b shadow-lg z-50">
                        <div class="px-4 pt-2 pb-3 space-y-1">
                            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('/') ? 'bg-blue-50 text-blue-600' : 'text-secondary hover:bg-secondary' }}">
                                Home
                            </a>
                            <a href="/tools" class="block px-3 py-2 rounded-md text-base font-medium text-secondary hover:bg-secondary">
                                Tools
                            </a>
                            <a href="/about" class="block px-3 py-2 rounded-md text-base font-medium text-secondary hover:bg-secondary">
                                About
                            </a>
                            <a href="/api" class="block px-3 py-2 rounded-md text-base font-medium text-secondary hover:bg-secondary">
                                API
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
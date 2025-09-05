<nav class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo and Brand -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-2xl">📝</span>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">Case Changer Pro</span>
                </a>
            </div>

            <!-- Main Navigation Links (Desktop) -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" 
                   class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                    Home
                </a>
                <a href="{{ route('conversions.index') }}" 
                   class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('conversions.*') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                    All Tools
                </a>
                <a href="{{ route('pages.about') }}" 
                   class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('pages.about') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                    About
                </a>
                <a href="{{ route('pages.faq') }}" 
                   class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('pages.faq') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                    FAQ
                </a>
            </div>

            <!-- Theme Toggle Button -->
            <div class="flex items-center space-x-4">
                <button onclick="toggleTheme()" 
                        class="p-2 rounded-lg text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors"
                        aria-label="Toggle theme">
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" 
                        class="md:hidden p-2 rounded-lg text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors"
                        aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" 
                   class="block px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30' : 'text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    Home
                </a>
                <a href="{{ route('conversions.index') }}" 
                   class="block px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('conversions.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30' : 'text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    All Tools
                </a>
                <a href="{{ route('pages.about') }}" 
                   class="block px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('pages.about') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30' : 'text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    About
                </a>
                <a href="{{ route('pages.faq') }}" 
                   class="block px-3 py-2 text-base font-medium rounded-md transition-colors {{ request()->routeIs('pages.faq') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30' : 'text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    FAQ
                </a>
            </div>
        </div>
    </div>
</nav>

<script nonce="{{ csp_nonce() }}">
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.classList.contains('dark') ? 'dark' : 'light';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    if (newTheme === 'dark') {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }
    
    // Save preference
    localStorage.setItem('theme', newTheme);
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

// Load theme preference on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});
</script>
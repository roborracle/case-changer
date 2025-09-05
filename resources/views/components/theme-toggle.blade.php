{{-- Theme Toggle Component --}}
<div 
    x-data="$store.theme"
    class="fixed top-4 right-4 z-50"
>
    {{-- Segmented Control --}}
    <div class="flex items-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg p-1">
        {{-- Auto Mode --}}
        <button
            @click="setTheme('auto')"
            :class="{
                'bg-blue-500 text-white': theme === 'auto',
                'text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200': theme !== 'auto'
            }"
            class="flex items-center justify-center px-3 py-2 rounded-md transition-all duration-200"
            title="Auto"
            aria-label="Auto theme"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </button>

        {{-- Light Mode --}}
        <button
            @click="setTheme('light')"
            :class="{
                'bg-blue-500 text-white': theme === 'light',
                'text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200': theme !== 'light'
            }"
            class="flex items-center justify-center px-3 py-2 rounded-md transition-all duration-200"
            title="Light"
            aria-label="Light theme"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </button>

        {{-- Dark Mode --}}
        <button
            @click="setTheme('dark')"
            :class="{
                'bg-blue-500 text-white': theme === 'dark',
                'text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200': theme !== 'dark'
            }"
            class="flex items-center justify-center px-3 py-2 rounded-md transition-all duration-200"
            title="Dark"
            aria-label="Dark theme"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
    </div>

    {{-- Transition Overlay --}}
    <div 
        x-show="transitioning"
        x-transition:enter="transition-opacity duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 pointer-events-none"
        style="z-index: 9999;"
    ></div>
</div>
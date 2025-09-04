<x-layouts.app 
    title="404 - Page Not Found | Case Changer Pro"
    description="The page you're looking for doesn't exist. Return to Case Changer Pro to access our 210+ text transformation tools."
    keywords="404, page not found, error, case changer pro"
>
    @push('styles')
    <meta name="robots" content="noindex, nofollow">
    @endpush

    <div class="min-h-[70vh] flex items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <!-- Glass Panel Container -->
            <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-2xl p-8 sm:p-12 shadow-2xl text-center">
                <!-- 404 Animation -->
                <div class="mb-8">
                    <div class="relative inline-block">
                        <div class="text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 animate-pulse">
                            404
                        </div>
                        <div class="absolute inset-0 blur-3xl opacity-30 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                    </div>
                </div>

                <!-- Error Message -->
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Page Not Found
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                    Oops! The page you're looking for doesn't exist or has been moved.
                </p>

                <!-- Search Box -->
                <div class="mb-8">
                    <div class="relative max-w-md mx-auto">
                        <input 
                            type="search" 
                            placeholder="Search for tools..."
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white/50 dark:bg-gray-800/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            x-data
                            x-on:keyup.enter="window.location.href = '/conversions?search=' + encodeURIComponent($event.target.value)"
                        >
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <a href="/" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Go to Homepage
                    </a>
                    <button 
                        x-data @click="history.back()"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Go Back
                    </button>
                </div>

                <!-- Helpful Links -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Popular Tools You Might Be Looking For
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-lg mx-auto">
                        <a href="/conversions/case-conversions" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            → Case Conversions
                        </a>
                        <a href="/conversions/developer-formats" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            → Developer Formats
                        </a>
                        <a href="/conversions/text-effects" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            → Text Effects
                        </a>
                        <a href="/conversions/social-media-formats" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            → Social Media Tools
                        </a>
                    </div>
                </div>

                <!-- Error ID for debugging -->
                @if(app()->hasDebugModeEnabled())
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Error ID: {{ Str::uuid() }} | {{ now()->toIso8601String() }}
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
    @endpush
</x-layouts.app>
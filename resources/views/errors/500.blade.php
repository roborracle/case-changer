<x-layouts.app 
    title="500 - Internal Server Error | Case Changer Pro"
    description="We're experiencing technical difficulties. Please try again later."
    keywords="500, server error, technical issues, case changer pro"
>
    @push('styles')
    <meta name="robots" content="noindex, nofollow">
    @endpush

    <div class="min-h-[70vh] flex items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <!-- Glass Panel Container -->
            <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-2xl p-8 sm:p-12 shadow-2xl text-center">
                <!-- Error Icon -->
                <div class="mb-8">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 mx-auto bg-gradient-to-br from-red-100 to-red-200 dark:from-red-900/30 dark:to-red-800/30 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="absolute inset-0 blur-3xl opacity-20 bg-gradient-to-r from-red-600 to-orange-600"></div>
                    </div>
                </div>

                <!-- Error Message -->
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Something Went Wrong
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                    We're experiencing technical difficulties. Our team has been notified and is working to fix the issue.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <button 
                        x-data @click="window.location.reload()"
                        class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Try Again
                    </button>
                    <a 
                        href="/"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Go to Homepage
                    </a>
                </div>

                <!-- What to Do Section -->
                <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-800/50 rounded-lg p-6 text-left">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        What You Can Do:
                    </h2>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Wait a few moments and try refreshing the page</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Clear your browser cache and cookies</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Try using a different browser</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Contact support if the problem persists</span>
                        </li>
                    </ul>
                </div>

                <!-- Contact Support -->
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        Still having issues?
                    </p>
                    <a href="/contact" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                        Contact Support →
                    </a>
                </div>

                <!-- Error Reference -->
                @php
                    $errorId = Str::uuid();
                    // Log the error with ID for tracking
                    if (!app()->hasDebugModeEnabled()) {
                        logger()->error('500 Error Page Displayed', [
                            'error_id' => $errorId,
                            'url' => request()->fullUrl(),
                            'user_agent' => request()->userAgent(),
                            'ip' => request()->ip()
                        ]);
                    }
                @endphp
                
                <div class="mt-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Error Reference: <code class="font-mono bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $errorId }}</code>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ now()->format('F j, Y, g:i a') }} UTC
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
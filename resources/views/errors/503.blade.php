<x-layouts.app 
    title="503 - Service Temporarily Unavailable | Case Changer Pro"
    description="Case Changer Pro is temporarily unavailable for maintenance. We'll be back shortly."
    keywords="503, service unavailable, maintenance, case changer pro"
>
    @push('styles')
    <meta name="robots" content="noindex, nofollow">
    @if(isset($retryAfter))
    <meta http-equiv="refresh" content="{{ $retryAfter }}">
    @endif
    @endpush

    <div class="min-h-[70vh] flex items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <!-- Glass Panel Container -->
            <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-2xl p-8 sm:p-12 shadow-2xl text-center">
                <!-- Maintenance Icon -->
                <div class="mb-8">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 mx-auto bg-gradient-to-br from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center animate-pulse">
                            <svg class="w-16 h-16 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="absolute inset-0 blur-3xl opacity-20 bg-gradient-to-r from-yellow-500 to-orange-500"></div>
                    </div>
                </div>

                <!-- Maintenance Message -->
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    We'll Be Right Back!
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                    We're performing scheduled maintenance to improve your experience. 
                    Our service will be back online shortly.
                </p>

                <!-- Progress Indicator -->
                <div class="mb-8">
                    <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-800/50 rounded-lg p-6">
                        <div class="flex items-center justify-center mb-4">
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce"></div>
                                <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce [animation-delay:150ms]"></div>
                                <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce [animation-delay:300ms]"></div>
                            </div>
                        </div>
                        
                        @if(isset($retryAfter))
                        <div class="text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                Estimated time remaining:
                            </p>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white" x-data="countdownTimer({{ $retryAfter }})" x-init="init()">
                                <span x-text="minutes"></span>:<span x-text="seconds"></span>
                            </div>
                        </div>
                        @else
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Our team is working hard to bring the service back online.
                        </p>
                        @endif
                    </div>
                </div>

                <!-- What's Happening -->
                <div class="backdrop-blur-lg bg-blue-50/50 dark:bg-blue-900/20 rounded-lg p-6 text-left mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        What We're Doing:
                    </h2>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Upgrading our servers for better performance</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Adding exciting new features</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Enhancing security and reliability</span>
                        </li>
                    </ul>
                </div>

                <!-- Stay Updated -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Want to stay updated on our status?
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a 
                            href="https://twitter.com/casechangerpro" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                        >
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Follow on Twitter
                        </a>
                        <button 
                            x-data @click="window.location.reload()"
                            class="inline-flex items-center justify-center text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Refresh Page
                        </button>
                    </div>
                </div>

                <!-- Auto-refresh Notice -->
                @if(isset($retryAfter))
                <div class="mt-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        This page will automatically refresh in {{ $retryAfter }} seconds
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.app>
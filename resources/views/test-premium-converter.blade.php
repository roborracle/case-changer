<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="flex justify-center items-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-4">
                    Premium Text <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Converter</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Experience the next generation of text transformation with our Smart Text Editor featuring auto-expanding height, 
                    fade gradients, character badges, and seamless paste-from-rich-text support.
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="grid md:grid-cols-4 gap-6 mb-12">
                <div class="backdrop-blur-md bg-white/60 dark:bg-gray-800/60 rounded-xl p-6 border border-gray-200/30 dark:border-gray-700/30 text-center">
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4a1 1 0 011-1h4M4 16v4a1 1 0 001 1h4M20 16v4a1 1 0 01-1 1h-4M20 8V4a1 1 0 00-1-1h-4"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Auto-Expanding</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Text area grows automatically from 40vh to 60vh</p>
                </div>
                <div class="backdrop-blur-md bg-white/60 dark:bg-gray-800/60 rounded-xl p-6 border border-gray-200/30 dark:border-gray-700/30 text-center">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Two-Pane Layout</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Side-by-side editing on desktop, stacked on mobile</p>
                </div>
                <div class="backdrop-blur-md bg-white/60 dark:bg-gray-800/60 rounded-xl p-6 border border-gray-200/30 dark:border-gray-700/30 text-center">
                    <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Smart Paste</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Automatically converts rich text to plain text</p>
                </div>
                <div class="backdrop-blur-md bg-white/60 dark:bg-gray-800/60 rounded-xl p-6 border border-gray-200/30 dark:border-gray-700/30 text-center">
                    <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2M7 4h6M7 4L5 6m14-2V2a1 1 0 00-1-1h-4a1 1 0 00-1 1v2m6 0h-6m6 0l2 2M5 6v12a2 2 0 002 2h10a2 2 0 002-2V6M5 6h14"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Character Badge</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Real-time character count that appears on focus</p>
                </div>
            </div>
            
            <!-- Premium Converter Component -->
            @livewire('premium-converter')
        </div>
    </div>
</x-layouts.app>
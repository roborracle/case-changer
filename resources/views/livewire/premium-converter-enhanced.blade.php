<div class="w-full" x-data="premiumConverter()" x-init="init()">
    <!-- Primary Transformation Tabs (Always Visible) -->
    <div class="sticky top-0 z-30 backdrop-blur-xl bg-white/80 dark:bg-gray-900/80 border-b border-gray-200/50 dark:border-gray-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-3">
                <!-- Left: Transformation Tabs -->
                <div class="flex-1 flex items-center space-x-1 overflow-x-auto scrollbar-hide">
                    <!-- Primary Tabs -->
                    @foreach($primaryTransformations as $key => $label)
                    <button
                        wire:click="applyTransformation('{{ $key }}')"
                        class="group relative px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 whitespace-nowrap
                               {{ $selectedTransformation === $key 
                                  ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg transform scale-105' 
                                  : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                        <span>{{ $label }}</span>
                        @if($selectedTransformation === $key)
                        <div class="absolute inset-x-0 -bottom-px h-0.5 bg-gradient-to-r from-blue-400 to-blue-600"></div>
                        @endif
                    </button>
                    @endforeach
                    
                    <!-- Explore All Button with Badge -->
                    <button
                        wire:click="toggleSecondaryDrawer"
                        class="group relative px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 whitespace-nowrap
                               bg-gradient-to-r from-purple-500/10 to-pink-500/10 text-purple-700 dark:text-purple-400 
                               hover:from-purple-500/20 hover:to-pink-500/20 border border-purple-300/30 dark:border-purple-700/30">
                        <span class="flex items-center space-x-2">
                            <span>Explore All</span>
                            <span class="px-1.5 py-0.5 text-xs bg-purple-500 text-white rounded-full">210+</span>
                        </span>
                    </button>
                </div>
                
                <!-- Right: Controls -->
                <div class="flex items-center space-x-3 ml-4">
                    <!-- Style Guide Selector -->
                    <div class="relative" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            @click.away="open = false"
                            class="flex items-center space-x-2 px-3 py-2 text-sm bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="hidden sm:inline">{{ $selectedStyleGuide ? $styleGuides[$selectedStyleGuide] : 'Style Guide' }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="py-1">
                                @foreach($styleGuides as $key => $label)
                                <button
                                    wire:click="applyStyleGuide('{{ $key }}')"
                                    @click="open = false"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 
                                           {{ $selectedStyleGuide === $key ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300' }}">
                                    {{ $label }}
                                </button>
                                @endforeach
                                @if($selectedStyleGuide)
                                <hr class="my-1 border-gray-200 dark:border-gray-700">
                                <button
                                    wire:click="applyStyleGuide('')"
                                    @click="open = false"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Clear Style Guide
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Theme Toggle (Tri-state) -->
                    <div class="flex items-center bg-gray-100 dark:bg-gray-800 rounded-lg p-1">
                        <button
                            wire:click="setThemeMode('auto')"
                            class="p-1.5 rounded transition-all duration-200 {{ $themeMode === 'auto' ? 'bg-white dark:bg-gray-700 shadow-sm' : '' }}">
                            <svg class="w-4 h-4 {{ $themeMode === 'auto' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>
                        <button
                            wire:click="setThemeMode('light')"
                            class="p-1.5 rounded transition-all duration-200 {{ $themeMode === 'light' ? 'bg-white shadow-sm' : '' }}">
                            <svg class="w-4 h-4 {{ $themeMode === 'light' ? 'text-yellow-500' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>
                        <button
                            wire:click="setThemeMode('dark')"
                            class="p-1.5 rounded transition-all duration-200 {{ $themeMode === 'dark' ? 'bg-gray-700 shadow-sm' : '' }}">
                            <svg class="w-4 h-4 {{ $themeMode === 'dark' ? 'text-indigo-400' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Input/Output Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Input Panel -->
            <div class="relative">
                <div class="backdrop-blur-md bg-white/90 dark:bg-gray-800/90 rounded-xl shadow-xl border border-gray-200/50 dark:border-gray-700/50">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-4 border-b border-gray-200/50 dark:border-gray-700/50">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wide">Input</h3>
                        <div class="flex items-center space-x-2">
                            @if($charCount > 0)
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ number_format($charCount) }} chars • {{ $wordCount }} words
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Textarea with Auto-resize -->
                    <div class="p-4">
                        <textarea
                            wire:model.live.debounce.300ms="inputText"
                            x-ref="inputTextarea"
                            @input="autoResize($refs.inputTextarea)"
                            class="w-full min-h-[200px] max-h-[600px] p-3 text-base border-0 bg-transparent resize-none focus:outline-none focus:ring-0 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                            placeholder="{{ $showEmptyStateAnimation ? $animatedPlaceholders[$currentPlaceholderIndex] : 'Type or paste your text here...' }}"
                            style="field-sizing: content">{{ $inputText }}</textarea>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between p-4 border-t border-gray-200/50 dark:border-gray-700/50">
                        <div class="flex items-center space-x-2">
                            <button
                                wire:click="loadExample"
                                class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Example
                            </button>
                            <button
                                wire:click="pasteFromClipboard"
                                class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Paste
                            </button>
                        </div>
                        <button
                            wire:click="clear"
                            class="px-3 py-1.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                            Clear
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Output Panel -->
            <div class="relative">
                <div class="backdrop-blur-md bg-gray-50/90 dark:bg-gray-900/90 rounded-xl shadow-xl border-2 {{ $outputText ? 'border-green-500/50' : 'border-gray-300/50 dark:border-gray-600/50 border-dashed' }}">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-4 border-b {{ $outputText ? 'border-green-500/20' : 'border-gray-200/50 dark:border-gray-700/50' }}">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wide">Output</h3>
                        @if($outputText)
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $transformationTime }}ms
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    @if($outputText)
                    <!-- Output Text -->
                    <div class="p-4">
                        <div class="min-h-[200px] max-h-[600px] overflow-y-auto p-3 bg-white/50 dark:bg-gray-800/50 rounded-lg">
                            <pre class="text-base text-gray-900 dark:text-white whitespace-pre-wrap break-words font-sans">{{ $outputText }}</pre>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between p-4 border-t border-gray-200/50 dark:border-gray-700/50">
                        <div class="flex items-center space-x-2">
                            <button
                                wire:click="copyToClipboard"
                                class="px-3 py-1.5 text-sm bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Copy
                            </button>
                            <button
                                wire:click="swapInputOutput"
                                class="px-3 py-1.5 text-sm bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                                Swap
                            </button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button
                                wire:click="exportText('txt')"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                Export
                            </button>
                        </div>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Your transformed text will appear here</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Select a transformation above to get started</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Discovery Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Discover More Tools</h2>
            
            <!-- Category Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Writing Styles Card -->
                <div class="group relative overflow-hidden backdrop-blur-md bg-white/90 dark:bg-gray-800/90 rounded-xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200/50 dark:border-gray-700/50 cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 mb-4 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Writing Styles</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Professional formatting for academic and journalistic writing</p>
                        <div class="flex items-center text-blue-600 dark:text-blue-400 text-sm font-medium">
                            Explore 45+ styles
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Developer Cases Card -->
                <div class="group relative overflow-hidden backdrop-blur-md bg-white/90 dark:bg-gray-800/90 rounded-xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200/50 dark:border-gray-700/50 cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 mb-4 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Developer Cases</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Code formatting for all programming languages</p>
                        <div class="flex items-center text-purple-600 dark:text-purple-400 text-sm font-medium">
                            Explore 60+ formats
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Creative Formats Card -->
                <div class="group relative overflow-hidden backdrop-blur-md bg-white/90 dark:bg-gray-800/90 rounded-xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200/50 dark:border-gray-700/50 cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 to-red-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 mb-4 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Creative Formats</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Fun text effects and social media styles</p>
                        <div class="flex items-center text-orange-600 dark:text-orange-400 text-sm font-medium">
                            Explore 100+ effects
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Secondary Transformations Drawer -->
    <div x-show="$wire.showSecondaryDrawer"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.away="$wire.showSecondaryDrawer = false"
         class="fixed inset-0 z-50 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
            
            <!-- Drawer panel -->
            <div x-show="$wire.showSecondaryDrawer"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-4"
                 class="inline-block w-full max-w-4xl my-8 text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl">
                
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">All Transformations</h3>
                    <button
                        wire:click="toggleSecondaryDrawer"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Search -->
                <div class="p-6 pb-0">
                    <input
                        type="text"
                        x-model="searchQuery"
                        placeholder="Search transformations..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Transformations Grid -->
                <div class="p-6 max-h-[60vh] overflow-y-auto">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach($secondaryTransformations as $key => $label)
                        <button
                            wire:click="applyTransformation('{{ $key }}')"
                            class="px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                                   {{ $selectedTransformation === $key 
                                      ? 'bg-blue-500 text-white' 
                                      : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script nonce="{{ csp_nonce() }}">
function premiumConverter() {
    return {
        searchQuery: '',
        
        init() {
            // Auto-resize textareas on load
            this.autoResize(this.$refs.inputTextarea);
        },
        
        autoResize(element) {
            if (!element) return;
            element.style.height = 'auto';
            element.style.height = element.scrollHeight + 'px';
        }
    }
}
</script>
@endpush
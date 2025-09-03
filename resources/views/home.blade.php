<x-layouts.app title="Case Changer Pro - 210+ Text Transformation Tools">
    <!-- Quick Access Tab Strip -->
    <section class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center py-2 px-4 overflow-x-auto scrollbar-hide">
                <!-- Quick convert label -->
                <span class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mr-4 font-semibold">
                    Quick Tools:
                </span>
                
                <!-- Primary formats in a compact row -->
                @php
                $quickTools = [
                    ['key' => 'upper-case', 'label' => 'UPPERCASE', 'style' => 'font-bold'],
                    ['key' => 'lower-case', 'label' => 'lowercase', 'style' => ''],
                    ['key' => 'title-case', 'label' => 'Title Case', 'style' => ''],
                    ['key' => 'sentence-case', 'label' => 'Sentence', 'style' => ''],
                    ['key' => 'camel-case', 'label' => 'camelCase', 'style' => ''],
                    ['key' => 'pascal-case', 'label' => 'PascalCase', 'style' => ''],
                    ['key' => 'snake-case', 'label' => 'snake_case', 'style' => ''],
                    ['key' => 'kebab-case', 'label' => 'kebab-case', 'style' => ''],
                    ['key' => 'constant-case', 'label' => 'CONSTANT', 'style' => 'font-bold'],
                    ['key' => 'dot-case', 'label' => 'dot.case', 'style' => ''],
                    ['key' => 'path-case', 'label' => 'path/case', 'style' => ''],
                    ['key' => 'reverse', 'label' => '↻ Reverse', 'style' => ''],
                ];
                @endphp
                
                <div class="flex items-center space-x-1">
                    @foreach($quickTools as $tool)
                    <button @click="$dispatch('quick-convert', { transformation: '{{ $tool['key'] }}' })"
                            class="px-3 py-1 text-xs {{ $tool['style'] }}
                                   text-gray-600 hover:text-gray-900 hover:bg-gray-100
                                   dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800
                                   rounded transition-all whitespace-nowrap">
                        {{ $tool['label'] }}
                    </button>
                    @endforeach
                    
                    <!-- Separator -->
                    <div class="w-px h-5 bg-gray-300 dark:bg-gray-600 mx-3"></div>
                    
                    <!-- See all link -->
                    <a href="/conversions" 
                       class="text-xs text-blue-600 hover:text-blue-700 
                              dark:text-blue-400 dark:hover:text-blue-300 
                              whitespace-nowrap font-medium px-2">
                        All 210+ Tools →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    Case Changer Pro
                </h1>
                <p class="text-xl md:text-2xl text-gray-700 dark:text-gray-200 mb-8 max-w-3xl mx-auto">
                    Transform text instantly with 210+ professional tools. Fast, free, and easy to use.
                </p>
            </div>
        </div>
    </section>

    <!-- Universal Converter with Multi-Output Preview -->
    <section class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-900 dark:text-white">Quick Text Converter</h2>
            
            <div x-data="improvedConverter" class="space-y-6">
                <!-- How to Use Instructions - Elegant Integration -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-2">How to use this tool:</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                <div class="flex items-center space-x-2">
                                    <span class="flex-shrink-0 w-6 h-6 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                    <span class="text-sm text-blue-800 dark:text-blue-200">Type or paste text below</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="flex-shrink-0 w-6 h-6 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                    <span class="text-sm text-blue-800 dark:text-blue-200">See instant previews</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="flex-shrink-0 w-6 h-6 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                    <span class="text-sm text-blue-800 dark:text-blue-200">Click copy on any format</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="flex-shrink-0 w-6 h-6 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">4</span>
                                    <span class="text-sm text-blue-800 dark:text-blue-200">Or use quick tools above</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input Area with Helper Buttons -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <label class="text-lg font-semibold text-gray-900 dark:text-white">Your Text</label>
                        <div class="flex items-center space-x-2">
                            <button @click="pasteFromClipboard"
                                    class="inline-flex items-center px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 bg-white hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg border border-gray-300 dark:border-gray-600 transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Paste
                            </button>
                            <button @click="clearText"
                                    class="inline-flex items-center px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 bg-white hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg border border-gray-300 dark:border-gray-600 transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Clear
                            </button>
                            <button @click="loadExample"
                                    class="inline-flex items-center px-3 py-1.5 text-sm text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 rounded-lg border border-blue-300 dark:border-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Example
                            </button>
                        </div>
                    </div>
                    <textarea
                        x-model="inputText"
                        @input="generateAllPreviews"
                        rows="6"
                        class="w-full px-4 py-3 text-base border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 resize-none"
                        placeholder="Type or paste your text here to see instant transformations in multiple formats..."
                    ></textarea>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="characterCountText"></span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">All transformations happen instantly in your browser</span>
                    </div>
                </div>

                <!-- Multi-Output Preview Grid -->
                <div x-show="hasInput" x-cloak class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Instant Results</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Click any result to copy</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3">
                        <template x-for="(preview, index) in previews" :key="index">
                            <div class="group relative bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-600 transition-all cursor-pointer"
                                 @click="copyToClipboard(preview.output, preview.key)">
                                <!-- Format Label -->
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider" x-text="preview.label"></h4>
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span x-show="shouldShowCopyButton(preview.key)" class="text-xs text-blue-600 dark:text-blue-400">Copy</span>
                                        <span x-show="isFormatCopied(preview.key)" class="text-xs text-green-600 dark:text-green-400">✓ Copied</span>
                                    </div>
                                </div>
                                
                                <!-- Preview Output -->
                                <div class="bg-gray-50 dark:bg-gray-900 rounded px-3 py-2 min-h-[60px]">
                                    <span x-text="getPreviewOutput(preview)" 
                                          class="text-sm font-mono text-gray-800 dark:text-gray-200 break-all line-clamp-3"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Empty State -->
                <div x-show="noInput" class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <p class="text-lg font-medium text-gray-600 dark:text-gray-400 mb-2">
                        Start typing to see magic happen!
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-500">
                        Your text will be instantly transformed into 12+ different formats
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Why Choose Case Changer Pro?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Lightning Fast</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Instant text transformation with no delays. Process text of any length in milliseconds.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">100% Secure</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        All conversions happen in your browser. Your text never leaves your device.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">210+ Tools</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Comprehensive collection of text transformation tools for every need.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Grid -->
    @if(isset($categories))
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Explore All Categories</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">Find the perfect text transformation tool for your needs</p>
            </div>
            
            <!-- Compact Categories Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
                @foreach($categories as $slug => $category)
                <a href="{{ route('conversions.category', $slug) }}" 
                   class="group bg-white dark:bg-gray-900 rounded-xl p-4 hover:shadow-lg hover:scale-105 transition-all border border-gray-200 dark:border-gray-700 text-center">
                    <span class="text-3xl block mb-2">{{ $category['emoji'] ?? '📝' }}</span>
                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                        {{ $category['name'] }}
                    </p>
                    <p class="text-[10px] text-gray-500 dark:text-gray-500 mt-1">
                        {{ $category['tool_count'] ?? 0 }} tools
                    </p>
                </a>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="/conversions" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-full hover:from-blue-700 hover:to-indigo-700 transition-all shadow-xl transform hover:scale-105">
                    Browse All Tools
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Transform Your Text?</h2>
            <p class="text-xl text-blue-100 mb-8">
                Join thousands of users who trust Case Changer Pro for their text transformation needs.
            </p>
            <a href="#" @click="window.scrollTo({top: 0, behavior: 'smooth'})" class="inline-block px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                Start Converting Now
            </a>
        </div>
    </section>

    @push('styles')
    <style nonce="{{ csp_nonce() }}">
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        /* Line clamp utility */
        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        [x-cloak] { 
            display: none !important; 
        }
    </style>
    @endpush
</x-layouts.app>
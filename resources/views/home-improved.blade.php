<x-layouts.app title="Case Changer Pro - 210+ Text Transformation Tools">
    <!-- Minimal Tab Strip - Super Compact -->
    <section class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center py-1.5 px-4 overflow-x-auto scrollbar-hide">
                <!-- Quick convert label -->
                <span class="text-[10px] uppercase tracking-wider text-gray-400 dark:text-gray-500 mr-3 font-semibold">
                    Quick:
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
                
                <div class="flex items-center space-x-0.5">
                    @foreach($quickTools as $index => $tool)
                    <button @click="$dispatch('quick-convert', { transformation: '{{ $tool['key'] }}' })"
                            class="px-2 py-0.5 text-[11px] {{ $tool['style'] }}
                                   text-gray-500 hover:text-gray-900 hover:bg-gray-50
                                   dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800/50
                                   rounded transition-all whitespace-nowrap
                                   border-r border-gray-200 dark:border-gray-700 last:border-r-0">
                        {{ $tool['label'] }}
                    </button>
                    @endforeach
                    
                    <!-- Separator -->
                    <div class="w-px h-4 bg-gray-300 dark:bg-gray-600 mx-2"></div>
                    
                    <!-- See all link -->
                    <a href="/conversions" 
                       class="text-[11px] text-blue-600 hover:text-blue-700 
                              dark:text-blue-400 dark:hover:text-blue-300 
                              whitespace-nowrap font-medium px-2">
                        All 210+ →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Universal Converter with Multi-Output Preview -->
    <section class="py-6 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-data="improvedConverter" class="space-y-4">
                <!-- Compact Input Area -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Your Text</h2>
                        <div class="flex items-center space-x-2">
                            <button @click="pasteFromClipboard"
                                    class="text-xs px-2 py-1 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                📋 Paste
                            </button>
                            <button @click="clearText"
                                    class="text-xs px-2 py-1 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                Clear
                            </button>
                            <button @click="loadExample"
                                    class="text-xs px-2 py-1 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                Example
                            </button>
                        </div>
                    </div>
                    <textarea
                        x-model="inputText"
                        @input="generateAllPreviews"
                        rows="4"
                        class="w-full px-3 py-2 text-sm border rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600"
                        placeholder="Type or paste your text here to see instant transformations..."
                    ></textarea>
                </div>

                <!-- Compact Multi-Output Preview Grid -->
                <div x-show="hasInput" x-cloak>
                    <h3 class="text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Results</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-2">
                        <template x-for="(preview, index) in previews" :key="index">
                            <div class="bg-white dark:bg-gray-800 rounded-md p-2.5 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                                <!-- Format Label -->
                                <div class="flex items-center justify-between mb-1.5">
                                    <h4 class="text-[10px] font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider" x-text="preview.label"></h4>
                                    <button @click="copyToClipboard(preview.output, preview.key)"
                                            :disabled="copyStates[preview.key]?.isDisabled"
                                            class="text-[10px] text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        <span x-show="copyStates[preview.key]?.shouldShowCopy">Copy</span>
                                        <span x-show="copyStates[preview.key]?.isCopied" x-cloak>✓</span>
                                    </button>
                                </div>
                                
                                <!-- Preview Output -->
                                <div class="bg-gray-50 dark:bg-gray-900 rounded px-2 py-1.5 text-xs font-mono overflow-x-auto">
                                    <span x-text="copyStates[preview.key]?.output || '...'" 
                                          class="text-gray-800 dark:text-gray-200 break-all"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Compact Empty State -->
                <div x-show="noInput" class="text-center py-6 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        ↑ Start typing above for instant transformations
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Compact Browse More Tools -->
    <section class="py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <a href="/conversions" 
               class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                Browse all 210+ transformation tools
                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- Compact Categories Grid -->
    @if(isset($categories))
    <section class="py-8 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 text-center">All Categories</h2>
            
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-9 gap-2">
                @foreach($categories as $slug => $category)
                <a href="{{ route('conversions.category', $slug) }}" 
                   class="group text-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <span class="text-2xl block mb-1">{{ $category['emoji'] ?? '📝' }}</span>
                    <p class="text-[10px] font-medium text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                        {{ Str::limit($category['name'], 12) }}
                    </p>
                    <p class="text-[9px] text-gray-400 dark:text-gray-500">
                        {{ $category['tool_count'] ?? 0 }}
                    </p>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

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
    </style>
    @endpush

</x-layouts.app>
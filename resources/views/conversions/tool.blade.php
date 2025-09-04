<x-layouts.app 
    :title="$toolData['name'] . ' - ' . $categoryData['name'] . ' Tools | Case Changer Pro'"
    :description="$toolData['description'] ?? 'Transform your text with ' . $toolData['name'] . ' tool. Part of our ' . $categoryData['name'] . ' collection.'"
    :keywords="strtolower($toolData['name']) . ', ' . strtolower($categoryData['name']) . ', text converter, case changer'"
>
    <!-- Breadcrumb Navigation -->
    <nav class="bg-gray-50 dark:bg-gray-900 py-3" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="/" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Home</a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <a href="/conversions" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Conversions</a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <a href="{{ route('conversions.category', $category) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">{{ $categoryData['name'] }}</a>
                </li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 dark:text-white font-medium">{{ $toolData['name'] }}</li>
            </ol>
        </div>
    </nav>

    <!-- Tool Header Section -->
    <section class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-2xl p-8 shadow-xl border border-white/30 dark:border-gray-700/30">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                                {{ $toolData['name'] }}
                            </h1>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ $categoryData['name'] }}
                            </span>
                            @if(isset($toolData['is_popular']) && $toolData['is_popular'])
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                Popular
                            </span>
                            @endif
                        </div>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                            {{ $toolData['description'] ?? 'Transform your text with this powerful ' . $toolData['name'] . ' tool.' }}
                        </p>
                        
                        <!-- Quick Action Buttons -->
                        <div class="flex flex-wrap gap-3">
                            <button @click="copyLink()" class="inline-flex items-center px-4 py-2 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Copy Link
                            </button>
                            <button @click="shareToolDeux()" class="inline-flex items-center px-4 py-2 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m9.032 4.026a9.001 9.001 0 01-1.519 1.523m-5.197-1.523a9.001 9.001 0 101.519 1.523"/>
                                </svg>
                                Share
                            </button>
                            @if(isset($toolData['usage_count']))
                            <span class="inline-flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($toolData['usage_count']) }} uses
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Tool Interface -->
    <section class="py-8" x-data="toolConverter" data-transformation="{{ $tool }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                
                <!-- Transformation Controls -->
                <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg border border-white/30 dark:border-gray-700/30">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <button 
                                data-action="click->text-converter#transform"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg transform hover:scale-105"
                            >
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Transform Text
                                </span>
                            </button>
                            
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" data-text-converter-target="realTimeToggle" data-action="change->text-converter#toggleRealTime" class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Real-time Preview</span>
                            </label>
                        </div>
                        
                        @if(isset($toolData['options']) && count($toolData['options']) > 0)
                        <button class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300" @click="toggleOptions()">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            Options
                        </button>
                        @endif
                    </div>
                    
                    <!-- Options Panel (Hidden by default) -->
                    @if(isset($toolData['options']) && count($toolData['options']) > 0)
                    <div id="options-panel" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($toolData['options'] as $option)
                            <label class="flex items-center">
                                <input type="{{ $option['type'] }}" name="{{ $option['name'] }}" class="mr-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $option['label'] }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Input/Output Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Input Section -->
                    <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg border border-white/30 dark:border-gray-700/30">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Input Text</h2>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    <span data-text-converter-target="charCount">0</span> characters
                                </span>
                                <button 
                                    data-action="click->text-converter#clearInput"
                                    class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                >
                                    Clear
                                </button>
                            </div>
                        </div>
                        <textarea
                            data-text-converter-target="input"
                            data-action="input->text-converter#updateCharCount input->text-converter#updatePreview"
                            rows="12"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 font-mono text-sm"
                            placeholder="Enter or paste your text here..."
                        ></textarea>
                        <div class="mt-3 flex items-center gap-3">
                            <button 
                                @click="pasteFromClipboard()"
                                class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                            >
                                📋 Paste from clipboard
                            </button>
                            <label class="text-sm text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 cursor-pointer">
                                <input type="file" accept=".txt" class="hidden" @change="loadFile($event)">
                                📁 Upload file
                            </label>
                        </div>
                    </div>

                    <!-- Output Section -->
                    <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg border border-white/30 dark:border-gray-700/30">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Output</h2>
                            <div class="flex items-center gap-2">
                                <button 
                                    data-action="click->text-converter#copyToClipboard"
                                    data-text-converter-target="copyButton"
                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    Copy
                                </button>
                                <button 
                                    data-action="click->text-converter#downloadResult"
                                    class="px-3 py-1 bg-gray-600 text-white text-sm rounded-lg hover:bg-gray-700 transition-colors"
                                >
                                    Download
                                </button>
                            </div>
                        </div>
                        <textarea
                            data-text-converter-target="output"
                            rows="12"
                            readonly
                            class="w-full px-4 py-3 border rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 font-mono text-sm"
                            placeholder="Transformed text will appear here..."
                        ></textarea>
                        <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                            <span data-text-converter-target="processingTime" class="hidden">
                                Processed in <span class="font-medium">0ms</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Examples Section -->
                @if(isset($examples) && count($examples) > 0)
                <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg border border-white/30 dark:border-gray-700/30">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Examples</h3>
                    <div class="space-y-4">
                        @foreach($examples as $example)
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">{{ $example['title'] }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Input</span>
                                    <div class="mt-1 p-2 bg-white dark:bg-gray-900 rounded border border-gray-200 dark:border-gray-700 font-mono text-sm">
                                        {{ $example['input'] }}
                                    </div>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Output</span>
                                    <div class="mt-1 p-2 bg-white dark:bg-gray-900 rounded border border-gray-200 dark:border-gray-700 font-mono text-sm">
                                        {{ $example['output'] }}
                                    </div>
                                </div>
                            </div>
                            <button 
                                @click="tryExample('{{ $example['input'] }}')"
                                class="mt-3 text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                            >
                                Try this example →
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tabs Section -->
                <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl shadow-lg border border-white/30 dark:border-gray-700/30 overflow-hidden">
                    <!-- Tab Headers -->
                    <div class="flex border-b border-gray-200 dark:border-gray-700">
                        <button @click="switchTab('documentation')" id="tab-documentation" class="px-6 py-3 text-sm font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 bg-white/50 dark:bg-gray-800/50">
                            Documentation
                        </button>
                        <button @click="switchTab('api')" id="tab-api" class="px-6 py-3 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                            API Reference
                        </button>
                        <button @click="switchTab('keyboard')" id="tab-keyboard" class="px-6 py-3 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                            Keyboard Shortcuts
                        </button>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Documentation Tab -->
                        <div id="content-documentation" class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">How to Use {{ $toolData['name'] }}</h3>
                            <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                <li>Enter or paste your text in the input field on the left</li>
                                <li>Configure any options if available (click Options button)</li>
                                <li>Click "Transform Text" or enable real-time preview</li>
                                <li>Copy the result from the output field on the right</li>
                                <li>Use the Download button to save as a text file</li>
                            </ol>
                            
                            @if(isset($toolData['documentation']))
                            <div class="mt-6 prose prose-blue dark:prose-invert max-w-none">
                                {!! $toolData['documentation'] !!}
                            </div>
                            @endif
                        </div>

                        <!-- API Tab -->
                        <div id="content-api" class="hidden space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">API Endpoint</h3>
                            <div class="bg-gray-900 rounded-lg p-4 text-gray-100 font-mono text-sm overflow-x-auto">
                                <div class="text-green-400">POST</div>
                                <div>https://casechanger.pro/api/transform/{{ $tool }}</div>
                            </div>
                            
                            <h4 class="font-medium text-gray-900 dark:text-white">Request Format</h4>
                            <pre class="bg-gray-900 rounded-lg p-4 text-gray-100 font-mono text-sm overflow-x-auto"><code>{
  "text": "Your text here",
  "options": {
    "preserveFormatting": true
  }
}</code></pre>

                            <h4 class="font-medium text-gray-900 dark:text-white">cURL Example</h4>
                            <pre class="bg-gray-900 rounded-lg p-4 text-gray-100 font-mono text-sm overflow-x-auto"><code>curl -X POST https://casechanger.pro/api/transform/{{ $tool }} \
  -H 'Content-Type: application/json' \
  -H 'X-API-Key: your-api-key' \
  -d '{"text": "Your text here"}'</code></pre>

                            <h4 class="font-medium text-gray-900 dark:text-white">Rate Limiting</h4>
                            <p class="text-gray-700 dark:text-gray-300">
                                API requests are limited to 60 requests per minute per IP address.
                            </p>
                        </div>

                        <!-- Keyboard Shortcuts Tab -->
                        <div id="content-keyboard" class="hidden space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Keyboard Shortcuts</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Transform Text</span>
                                    <kbd class="px-2 py-1 bg-white dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600 text-xs">Ctrl + Enter</kbd>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Copy Output</span>
                                    <kbd class="px-2 py-1 bg-white dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600 text-xs">Ctrl + C</kbd>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Clear Input</span>
                                    <kbd class="px-2 py-1 bg-white dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600 text-xs">Ctrl + Shift + X</kbd>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Toggle Real-time</span>
                                    <kbd class="px-2 py-1 bg-white dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600 text-xs">Ctrl + R</kbd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Desktop Only) -->
            <div class="hidden lg:block lg:col-span-1">
                <!-- Related Tools -->
                @if(isset($relatedTools) && count($relatedTools) > 0)
                <div class="sticky top-24 space-y-6">
                    <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg border border-white/30 dark:border-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Related Tools</h3>
                        <div class="space-y-3">
                            @foreach($relatedTools as $relatedTool)
                            <a href="{{ route('conversions.tool', ['category' => $category, 'tool' => $relatedTool['slug']]) }}" 
                               class="block p-3 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $relatedTool['name'] }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ Str::limit($relatedTool['description'] ?? '', 60) }}
                                </p>
                            </a>
                            @endforeach
                        </div>
                        <a href="{{ route('conversions.category', $category) }}" 
                           class="block mt-4 text-center text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            View all in {{ $categoryData['name'] }} →
                        </a>
                    </div>

                    <!-- Performance Metrics -->
                    <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg border border-white/30 dark:border-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance</h3>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-gray-600 dark:text-gray-400">Avg. Processing</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">&lt; 50ms</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600 dark:text-gray-400">Max Input Size</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">1 MB</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600 dark:text-gray-400">Supported Formats</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">Plain Text</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    @push('scripts')
    <script nonce="{{ csp_nonce() }}">
        // Tab switching
        function switchTab(tabName) {
            // Hide all content
            document.querySelectorAll('[id^="content-"]').forEach(el => el.classList.add('hidden'));
            // Remove active from all tabs
            document.querySelectorAll('[id^="tab-"]').forEach(el => {
                el.classList.remove('text-blue-600', 'dark:text-blue-400', 'border-b-2', 'border-blue-600', 'dark:border-blue-400', 'bg-white/50', 'dark:bg-gray-800/50');
                el.classList.add('text-gray-600', 'dark:text-gray-400');
            });
            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            // Activate selected tab
            const tab = document.getElementById('tab-' + tabName);
            tab.classList.add('text-blue-600', 'dark:text-blue-400', 'border-b-2', 'border-blue-600', 'dark:border-blue-400', 'bg-white/50', 'dark:bg-gray-800/50');
            tab.classList.remove('text-gray-600', 'dark:text-gray-400');
        }

        // Copy link function
        function copyLink() {
            navigator.clipboard.writeText(window.location.href);
            // Show toast notification
            showToast('Link copied to clipboard!');
        }

        // Share function
        function shareToolDeux() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $toolData['name'] }} - Case Changer Pro',
                    text: '{{ $toolData['description'] ?? 'Check out this awesome text transformation tool!' }}',
                    url: window.location.href
                });
            } else {
                copyLink();
            }
        }

        // Toggle options panel
        function toggleOptions() {
            const panel = document.getElementById('options-panel');
            panel.classList.toggle('hidden');
        }

        // Try example function
        function tryExample(text) {
            const input = document.querySelector('[data-text-converter-target="input"]');
            input.value = text;
            input.dispatchEvent(new Event('input'));
        }

        // Paste from clipboard
        async function pasteFromClipboard() {
            try {
                const text = await navigator.clipboard.readText();
                const input = document.querySelector('[data-text-converter-target="input"]');
                input.value = text;
                input.dispatchEvent(new Event('input'));
            } catch (err) {
                console.error('Failed to read clipboard:', err);
            }
        }

        // Load file
        function loadFile(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const input = document.querySelector('[data-text-converter-target="input"]');
                    input.value = e.target.result;
                    input.dispatchEvent(new Event('input'));
                };
                reader.readAsText(file);
            }
        }

        // Toast notification
        function showToast(message) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.classList.add('animate-fade-out');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+Enter to transform
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                document.querySelector('[data-action*="transform"]').click();
            }
            // Ctrl+Shift+X to clear
            if (e.ctrlKey && e.shiftKey && e.key === 'X') {
                e.preventDefault();
                document.querySelector('[data-action*="clearInput"]').click();
            }
            // Ctrl+R to toggle real-time
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                document.querySelector('[data-text-converter-target="realTimeToggle"]').click();
            }
        });
    </script>
    @endpush

    @push('styles')
    <style nonce="{{ csp_nonce() }}">
        /* Animation classes */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-out {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(10px); }
        }
        .animate-fade-in { animation: fade-in 0.3s ease-out; }
        .animate-fade-out { animation: fade-out 0.3s ease-out; }
    </style>
    @endpush
</x-layouts.app>
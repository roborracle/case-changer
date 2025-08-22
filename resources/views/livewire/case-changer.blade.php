<div class="min-h-screen bg-gray-50" style="background: linear-gradient(180deg, #ffffff 0%, #f5f5f7 100%);">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        {{-- Header - Apple Style --}}
        <header class="text-center mb-10">
            <h1 class="text-5xl font-semibold text-gray-900 mb-2" style="font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', sans-serif; letter-spacing: -0.02em;">Case Changer Pro</h1>
            <p class="text-gray-500 text-lg">Professional Text Transformation Tool</p>
        </header>

        {{-- Error/Success Messages --}}
        @if($errorMessage)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errorMessage }}
            </div>
        @endif
        
        @if($successMessage)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ $successMessage }}
            </div>
        @endif

        {{-- Main Grid Layout - Apple Style --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Input Section --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-900">Input Text</h2>
                <textarea
                    wire:model.live="inputText"
                    class="w-full h-64 p-4 border border-gray-200 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 placeholder-gray-400"
                    placeholder="Enter or paste your text here..."
                    style="font-family: -apple-system, BlinkMacSystemFont, 'SF Mono', 'Monaco', monospace;"
                ></textarea>
                <div class="mt-3 text-xs text-gray-500 font-medium tracking-wide">
                    {{ $stats['characters'] }} CHARACTERS • {{ $stats['words'] }} WORDS • {{ $stats['lines'] }} LINES
                </div>
            </div>

            {{-- Output Section --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-900">Output Text</h2>
                <div class="w-full h-64 p-4 border border-gray-200 rounded-lg bg-gray-50 overflow-auto">
                    <pre class="whitespace-pre-wrap" style="font-family: -apple-system, BlinkMacSystemFont, 'SF Mono', 'Monaco', monospace;">{{ $outputText }}</pre>
                </div>
                <div class="mt-3 text-xs text-gray-500 font-medium tracking-wide">
                    {{ strlen($outputText) }} CHARACTERS • {{ str_word_count($outputText) }} WORDS
                </div>
            </div>
        </div>

        {{-- Action Buttons - Apple Style --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-wrap gap-3">
                <button 
                    wire:click="copyToClipboard" 
                    class="px-6 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium text-sm"
                >
                    @if($copied) ✓ Copied! @else Copy Output @endif
                </button>
                <button 
                    wire:click="clearAll" 
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm border border-gray-200"
                >
                    Clear All
                </button>
                <button 
                    wire:click="swapTexts" 
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm border border-gray-200"
                >
                    Output → Input
                </button>
                <button 
                    wire:click="undo" 
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors disabled:opacity-40 disabled:cursor-not-allowed font-medium text-sm border border-gray-200"
                    @if(!$historyInfo['can_undo']) disabled @endif
                >
                    ↶ Undo
                </button>
                <button 
                    wire:click="redo" 
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors disabled:opacity-40 disabled:cursor-not-allowed font-medium text-sm border border-gray-200"
                    @if(!$historyInfo['can_redo']) disabled @endif
                >
                    ↷ Redo
                </button>
            </div>
        </div>

        {{-- Transformations - Apple Style --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-2xl font-semibold mb-6 text-gray-900">Text Transformations</h2>
            
            @foreach($transformationGroups as $groupKey => $group)
                <div class="mb-8">
                    <h3 class="text-sm font-medium mb-4 text-gray-500 uppercase tracking-wider">{{ $group['title'] }}</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                        @foreach($group['transformations'] as $key => $label)
                            <button 
                                wire:click="applyTransformation('{{ $key }}')"
                                class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors @if($selectedTransformation === $key) !bg-blue-500 !text-white @endif"
                            >
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Style Guides - Apple Style --}}
            <div class="border-t border-gray-200 pt-8 mt-8">
                <h2 class="text-2xl font-semibold mb-6 text-gray-900">Style Guides</h2>
                
                @foreach($styleGuides as $categoryKey => $category)
                    <div class="mb-8">
                        <h3 class="text-sm font-medium mb-4 text-gray-500 uppercase tracking-wider">{{ $category['title'] }}</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                            @foreach($category['guides'] as $key => $label)
                                <button 
                                    wire:click="applyStyleGuide('{{ $key }}')"
                                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors @if($selectedStyleGuide === $key) !bg-blue-500 !text-white @endif"
                                >
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Preservation Settings - Apple Style --}}
            <div class="border-t border-gray-200 pt-8 mt-8">
                <button 
                    wire:click="togglePreservationSettings"
                    class="flex items-center justify-between w-full text-left group"
                >
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-500 transition-colors">Smart Preservation Settings</h3>
                    <svg class="w-5 h-5 transition-transform text-gray-400 @if($showPreservationSettings) rotate-180 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                @if($showPreservationSettings)
                    <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model="preservationSettings.urls" class="mr-3 w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm text-gray-700 group-hover:text-gray-900">Preserve URLs</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model="preservationSettings.emails" class="mr-3 w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm text-gray-700 group-hover:text-gray-900">Preserve Emails</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model="preservationSettings.brands" class="mr-3 w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm text-gray-700 group-hover:text-gray-900">Preserve Brands</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model="preservationSettings.code_blocks" class="mr-3 w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm text-gray-700 group-hover:text-gray-900">Preserve Code</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model="preservationSettings.markdown" class="mr-3 w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm text-gray-700 group-hover:text-gray-900">Preserve Markdown</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model="preservationSettings.mentions" class="mr-3 w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm text-gray-700 group-hover:text-gray-900">Preserve @mentions</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model="preservationSettings.hashtags" class="mr-3 w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm text-gray-700 group-hover:text-gray-900">Preserve #hashtags</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model="preservationSettings.file_paths" class="mr-3 w-4 h-4 text-blue-500 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-sm text-gray-700 group-hover:text-gray-900">Preserve Paths</span>
                        </label>
                    </div>
                @endif
            </div>
        </div>

        {{-- Footer - Apple Style --}}
        <footer class="text-center mt-16 pb-8">
            <p class="text-gray-400 text-xs font-medium">&copy; 2025 Case Changer Pro</p>
            <p class="mt-1 text-gray-400 text-xs">Professional Text Transformation Tool</p>
        </footer>
    </div>

    {{-- Copy Success Toast - Apple Style --}}
    @if($copied)
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 2000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed bottom-6 right-6 bg-gray-900 text-white px-5 py-3 rounded-xl shadow-2xl backdrop-blur-xl"
            style="background: rgba(0, 0, 0, 0.85);"
        >
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium text-sm">Copied to clipboard</span>
            </div>
        </div>
    @endif
</div>

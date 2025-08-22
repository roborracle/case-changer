<div class="min-h-screen" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    {{-- Floating Card Design --}}
    <div class="container mx-auto px-4 py-12 max-w-4xl">
        {{-- Minimal Header --}}
        <header class="text-center mb-8">
            <h1 class="text-3xl font-light text-white/90 tracking-wide">Case Changer</h1>
            <p class="text-white/60 text-sm mt-1">Transform text intelligently</p>
        </header>

        {{-- Single Unified Text Card --}}
        <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 overflow-hidden">
            {{-- Smart Command Bar --}}
            <div class="bg-white/5 border-b border-white/10 px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        {{-- Quick Actions --}}
                        <button 
                            wire:click="applyTransformation('uppercase')"
                            class="text-xs text-white/70 hover:text-white transition-colors"
                            title="UPPERCASE"
                        >
                            AA
                        </button>
                        <button 
                            wire:click="applyTransformation('lowercase')"
                            class="text-xs text-white/70 hover:text-white transition-colors"
                            title="lowercase"
                        >
                            aa
                        </button>
                        <button 
                            wire:click="applyTransformation('title')"
                            class="text-xs text-white/70 hover:text-white transition-colors"
                            title="Title Case"
                        >
                            Aa
                        </button>
                        <div class="w-px h-4 bg-white/20"></div>
                        <button 
                            wire:click="toggleCommandPalette"
                            class="text-xs text-white/70 hover:text-white transition-colors flex items-center space-x-1"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <span>All Transforms</span>
                            <kbd class="ml-2 px-1.5 py-0.5 text-[10px] bg-white/10 rounded">⌘K</kbd>
                        </button>
                    </div>
                    <div class="flex items-center space-x-3 text-white/50 text-xs">
                        <span>{{ $stats['words'] }} words</span>
                        <span>•</span>
                        <span>{{ $stats['characters'] }} chars</span>
                    </div>
                </div>
            </div>

            {{-- Unified Text Area with In-Place Transformation --}}
            <div class="relative">
                <textarea
                    wire:model.live="currentText"
                    class="w-full min-h-[400px] p-8 bg-transparent text-white placeholder-white/30 resize-none focus:outline-none text-lg leading-relaxed"
                    placeholder="Type or paste your text here..."
                    style="font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Text', sans-serif;"
                ></textarea>

                {{-- Floating Action Button --}}
                @if(strlen($currentText) > 0)
                <div class="absolute bottom-6 right-6 flex items-center space-x-2">
                    <button
                        wire:click="copyToClipboard"
                        class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-full text-sm backdrop-blur-xl transition-all duration-200 border border-white/20"
                    >
                        @if($copied)
                            <span class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Copied</span>
                            </span>
                        @else
                            Copy
                        @endif
                    </button>
                    @if($canUndo)
                    <button
                        wire:click="undo"
                        class="p-2 bg-white/10 hover:bg-white/20 text-white rounded-full backdrop-blur-xl transition-all duration-200 border border-white/10"
                        title="Undo"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                    </button>
                    @endif
                </div>
                @endif
            </div>

            {{-- History Timeline (if there's history) --}}
            @if(count($transformationHistory) > 0)
            <div class="border-t border-white/10 px-6 py-4">
                <div class="flex items-center space-x-2 overflow-x-auto">
                    <span class="text-xs text-white/50 mr-2">History:</span>
                    @foreach($transformationHistory as $index => $history)
                    <button
                        wire:click="jumpToHistory({{ $index }})"
                        class="px-3 py-1 text-xs bg-white/10 hover:bg-white/20 text-white/70 hover:text-white rounded-full whitespace-nowrap transition-all duration-200"
                    >
                        {{ $history['transformation'] }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Intelligent Suggestions (Context-Aware) --}}
        @if($suggestions && count($suggestions) > 0)
        <div class="mt-4">
            <p class="text-white/60 text-xs mb-2">Suggested for your content:</p>
            <div class="flex flex-wrap gap-2">
                @foreach($suggestions as $suggestion)
                <button
                    wire:click="applyTransformation('{{ $suggestion['key'] }}')"
                    class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white/80 hover:text-white rounded-lg text-sm backdrop-blur-xl transition-all duration-200 border border-white/10"
                >
                    {{ $suggestion['label'] }}
                </button>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Command Palette Overlay --}}
    @if($showCommandPalette)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-start justify-center pt-20">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[70vh] overflow-hidden">
            {{-- Search Bar --}}
            <div class="border-b border-gray-200 px-6 py-4">
                <input
                    type="text"
                    wire:model.live="commandSearch"
                    class="w-full px-3 py-2 bg-gray-50 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500"
                    placeholder="Search transformations..."
                    autofocus
                />
            </div>

            {{-- Transformation List --}}
            <div class="overflow-y-auto max-h-[50vh]">
                @foreach($filteredTransformations as $category => $transforms)
                    @if(count($transforms) > 0)
                    <div class="px-6 py-3">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ $category }}</h3>
                        <div class="space-y-1">
                            @foreach($transforms as $key => $label)
                            <button
                                wire:click="applyAndClose('{{ $key }}')"
                                class="w-full text-left px-3 py-2 rounded-lg hover:bg-purple-50 text-gray-700 hover:text-purple-700 transition-colors duration-150 flex items-center justify-between group"
                            >
                                <span>{{ $label }}</span>
                                <span class="text-xs text-gray-400 group-hover:text-purple-500">Apply</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            {{-- Close Button --}}
            <div class="border-t border-gray-200 px-6 py-3 bg-gray-50">
                <button
                    wire:click="toggleCommandPalette"
                    class="text-sm text-gray-500 hover:text-gray-700"
                >
                    Press <kbd class="px-2 py-1 bg-white rounded border border-gray-300 text-xs">ESC</kbd> to close
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Minimal Toast Notification --}}
    @if($notification)
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
        class="fixed bottom-8 left-1/2 transform -translate-x-1/2 px-6 py-3 bg-black/80 text-white rounded-full backdrop-blur-xl"
    >
        {{ $notification }}
    </div>
    @endif

    {{-- Keyboard Shortcut Handler --}}
    <script>
        document.addEventListener('keydown', function(e) {
            // Cmd/Ctrl + K for command palette
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                @this.toggleCommandPalette();
            }
            // Escape to close command palette
            if (e.key === 'Escape') {
                @this.closeCommandPalette();
            }
            // Cmd/Ctrl + Z for undo
            if ((e.metaKey || e.ctrlKey) && e.key === 'z') {
                e.preventDefault();
                @this.undo();
            }
            // Cmd/Ctrl + C to copy when text is not selected
            if ((e.metaKey || e.ctrlKey) && e.key === 'c' && !window.getSelection().toString()) {
                e.preventDefault();
                @this.copyToClipboard();
            }
        });
    </script>
</div>

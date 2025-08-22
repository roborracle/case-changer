<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900 relative overflow-hidden">
    {{-- Animated background elements --}}
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 container mx-auto px-4 py-8 max-w-5xl">
        {{-- Header --}}
        <header class="text-center mb-12">
            <h1 class="text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-400 to-indigo-400 mb-3">
                Case Changer Pro
            </h1>
            <p class="text-gray-300 text-lg">Modern Text Transformation</p>
            <div class="mt-4 flex justify-center gap-2 text-sm text-gray-400">
                <kbd class="px-2 py-1 bg-gray-800 rounded border border-gray-700">⌘K</kbd>
                <span>Command Palette</span>
                <span class="mx-2">•</span>
                <kbd class="px-2 py-1 bg-gray-800 rounded border border-gray-700">⌘Z</kbd>
                <span>Undo</span>
                <span class="mx-2">•</span>
                <kbd class="px-2 py-1 bg-gray-800 rounded border border-gray-700">⌘C</kbd>
                <span>Copy</span>
            </div>
        </header>

        {{-- Main Text Area --}}
        <div class="relative group">
            {{-- Contextual Suggestions Bar --}}
            @if(count($suggestions) > 0 && strlen($text) > 0)
            <div class="absolute -top-14 left-0 right-0 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                 wire:transition.opacity.duration.200ms>
                <span class="text-xs text-gray-400 mr-2">Suggested:</span>
                @foreach($suggestions as $index => $suggestion)
                    <button 
                        wire:click="applyQuickAction({{ $index }})"
                        class="px-3 py-1.5 text-xs font-medium bg-gray-800/80 backdrop-blur-sm text-gray-300 rounded-lg hover:bg-purple-600/50 hover:text-white transition-all duration-200 border border-gray-700/50 hover:border-purple-500/50"
                        style="{{ $this->getTransformationStyle($suggestion) }}"
                    >
                        {{ $this->getTransformationLabel($suggestion) }}
                    </button>
                @endforeach
            </div>
            @endif

            {{-- Main Textarea --}}
            <div class="relative">
                <textarea
                    wire:model.live="text"
                    placeholder="Type or paste your text here... Press ⌘K for transformations"
                    class="w-full h-96 p-8 bg-gray-900/50 backdrop-blur-xl rounded-2xl border border-gray-700/50 text-white placeholder-gray-500 resize-none focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent transition-all duration-300 text-lg leading-relaxed font-mono"
                    @if($isTransforming) 
                        x-data="{ text: @entangle('text') }"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-50 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                    @endif
                ></textarea>

                {{-- Character count --}}
                <div class="absolute bottom-4 right-4 text-xs text-gray-500">
                    {{ strlen($text) }} characters • {{ str_word_count($text) }} words
                </div>

                {{-- Content type indicator --}}
                @if($contentType && strlen($text) > 0)
                <div class="absolute top-4 right-4">
                    <span class="px-2 py-1 text-xs bg-purple-600/20 text-purple-300 rounded-full border border-purple-500/30">
                        {{ ucfirst($contentType) }} detected
                    </span>
                </div>
                @endif
            </div>

            {{-- Action buttons --}}
            <div class="absolute -bottom-16 left-0 right-0 flex justify-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                <button 
                    wire:click="copyToClipboard"
                    class="px-4 py-2 bg-purple-600/80 backdrop-blur-sm text-white rounded-lg hover:bg-purple-500 transition-all duration-200 flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Copy
                </button>
                
                <button 
                    wire:click="undo"
                    @if(!$canUndo) disabled @endif
                    class="px-4 py-2 bg-gray-800/80 backdrop-blur-sm text-gray-300 rounded-lg hover:bg-gray-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Undo
                </button>
                
                <button 
                    wire:click="redo"
                    @if(!$canRedo) disabled @endif
                    class="px-4 py-2 bg-gray-800/80 backdrop-blur-sm text-gray-300 rounded-lg hover:bg-gray-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6"></path>
                    </svg>
                    Redo
                </button>
                
                <button 
                    wire:click="clearText"
                    class="px-4 py-2 bg-gray-800/80 backdrop-blur-sm text-gray-300 rounded-lg hover:bg-red-600/50 hover:text-white transition-all duration-200 flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Clear
                </button>
            </div>
        </div>

        {{-- Quick Access Transformations --}}
        <div class="mt-24 mb-8">
            <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-4">Quick Transformations</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-2">
                @foreach($quickTransformations as $key => $label)
                    <button 
                        wire:click="executeTransformation('{{ $key }}')"
                        wire:mouseenter="previewTransformation('{{ $key }}')"
                        wire:mouseleave="$set('previewText', '')"
                        class="relative px-4 py-3 bg-gray-800/50 backdrop-blur-sm text-gray-300 rounded-lg hover:bg-purple-600/30 hover:text-white hover:border-purple-500/50 transition-all duration-200 border border-gray-700/50 font-medium text-sm transform-button"
                        style="{{ $this->getTransformationStyle($key) }}"
                    >
                        {{ $label }}
                        
                        {{-- Preview tooltip --}}
                        @if($hoveredTransformation === $key && $previewText)
                        <div class="absolute z-50 bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg shadow-xl max-w-xs whitespace-nowrap overflow-hidden text-ellipsis">
                            {{ $previewText }}
                        </div>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Recent & Frequent --}}
        @if(count($recentTransformations) > 0 || count($frequentTransformations) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @if(count($recentTransformations) > 0)
            <div>
                <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-3">Recent</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(array_slice($recentTransformations, 0, 5) as $transformation)
                        <button 
                            wire:click="executeTransformation('{{ $transformation }}')"
                            class="px-3 py-1.5 text-xs bg-gray-800/50 backdrop-blur-sm text-gray-400 rounded-lg hover:bg-purple-600/30 hover:text-white transition-all duration-200 border border-gray-700/50"
                        >
                            {{ $this->getTransformationLabel($transformation) }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            @if(count($frequentTransformations) > 0)
            <div>
                <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-3">Most Used</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($frequentTransformations as $transformation)
                        <button 
                            wire:click="executeTransformation('{{ $transformation }}')"
                            class="px-3 py-1.5 text-xs bg-purple-600/20 backdrop-blur-sm text-purple-300 rounded-lg hover:bg-purple-600/30 hover:text-white transition-all duration-200 border border-purple-500/30"
                        >
                            {{ $this->getTransformationLabel($transformation) }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- Command Palette Modal --}}
    @if($commandPaletteOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto"
         x-data="{ open: @entangle('commandPaletteOpen') }"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="$wire.closeCommandPalette()"
         @keydown.arrow-up.prevent="$wire.navigateUp()"
         @keydown.arrow-down.prevent="$wire.navigateDown()"
         @keydown.enter.prevent="$wire.selectCurrent()">
        
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" wire:click="closeCommandPalette"></div>
        
        <div class="relative min-h-screen flex items-start justify-center pt-20">
            <div class="relative w-full max-w-2xl bg-gray-900/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-700/50"
                 @click.stop>
                
                {{-- Search Input --}}
                <div class="border-b border-gray-700/50 p-4">
                    <input 
                        type="text"
                        wire:model.live="searchQuery"
                        placeholder="Search transformations..."
                        class="w-full px-4 py-2 bg-gray-800/50 text-white rounded-lg border border-gray-700/50 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent"
                        autofocus
                    >
                </div>
                
                {{-- Transformation List --}}
                <div class="max-h-96 overflow-y-auto p-4">
                    @foreach($transformations as $category => $categoryTransformations)
                        <div class="mb-6">
                            <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">{{ str_replace('_', ' ', $category) }}</h4>
                            <div class="space-y-1">
                                @foreach($categoryTransformations as $key => $label)
                                    <button 
                                        wire:click="executeTransformation('{{ $key }}')"
                                        wire:mouseenter="previewTransformation('{{ $key }}')"
                                        class="w-full text-left px-4 py-2.5 rounded-lg hover:bg-purple-600/20 transition-all duration-200 flex items-center justify-between group {{ $selectedIndex === $loop->parent->index * 100 + $loop->index ? 'bg-purple-600/20' : '' }}"
                                    >
                                        <span class="text-gray-300 group-hover:text-white" style="{{ $this->getTransformationStyle($key) }}">
                                            {{ $label }}
                                        </span>
                                        <kbd class="hidden group-hover:inline-block text-xs text-gray-500 bg-gray-800 px-2 py-1 rounded">↵</kbd>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Preview Section --}}
                @if($previewText)
                <div class="border-t border-gray-700/50 p-4">
                    <p class="text-xs text-gray-500 mb-2">Preview:</p>
                    <p class="text-sm text-gray-300 font-mono">{{ $previewText }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Copy Success Toast --}}
    <div 
        x-data="{ 
            show: false,
            message: ''
        }"
        x-on:copy-to-clipboard.window="
            navigator.clipboard.writeText($event.detail.text);
            message = 'Copied to clipboard';
            show = true;
            setTimeout(() => show = false, 2000);
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-6 right-6 bg-green-600 text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-2"
        style="display: none;"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span x-text="message"></span>
    </div>
</div>

{{-- Keyboard shortcut handler --}}
<script>
document.addEventListener('keydown', function(e) {
    // Cmd/Ctrl + K to open command palette
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        @this.openCommandPalette();
    }
    
    // Cmd/Ctrl + Z for undo
    if ((e.metaKey || e.ctrlKey) && e.key === 'z' && !e.shiftKey) {
        e.preventDefault();
        @this.undo();
    }
    
    // Cmd/Ctrl + Shift + Z for redo
    if ((e.metaKey || e.ctrlKey) && e.shiftKey && e.key === 'z') {
        e.preventDefault();
        @this.redo();
    }
    
    // Cmd/Ctrl + C to copy when text is selected
    if ((e.metaKey || e.ctrlKey) && e.key === 'c') {
        const textarea = document.querySelector('textarea');
        if (textarea && textarea.value && document.activeElement === textarea) {
            if (textarea.selectionStart === 0 && textarea.selectionEnd === textarea.value.length) {
                e.preventDefault();
                @this.copyToClipboard();
            }
        }
    }
});
</script>

<style>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 20s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

/* Transformation-specific styles */
.transform-button[style*="uppercase"] {
    text-transform: uppercase !important;
}

.transform-button[style*="lowercase"] {
    text-transform: lowercase !important;
}

.transform-button[style*="capitalize"] {
    text-transform: capitalize !important;
}

.transform-button[style*="monospace"] {
    font-family: ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace !important;
}

.transform-button[style*="reverse"] {
    unicode-bidi: bidi-override;
    direction: rtl;
}

.transform-button[style*="letter-spacing"] {
    letter-spacing: 0.3em !important;
}
</style>
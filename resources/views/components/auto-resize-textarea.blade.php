@props([
    'wire:model' => null,
    'placeholder' => 'Enter or paste your text here...',
    'minRows' => 4,
    'maxRows' => 20,
    'id' => 'auto-resize-textarea',
    'showCounter' => true,
    'showClear' => true,
    'showSettings' => true,
    'label' => 'Input Text'
])

<div 
    x-data="autoResizeTextarea()"
    class="w-full"
>
    {{-- Header with label and options --}}
    <div class="flex items-center justify-between mb-3">
        <label for="{{ $id }}" class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            {{ $label }}
        </label>
        
        <div class="flex items-center gap-2">
            {{-- Settings Toggle --}}
            @if($showSettings)
            <button 
                @click="toggleMonospace()"
                :title="monospace ? 'Switch to normal font' : 'Switch to monospace font'"
                class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
            >
                <svg x-show="!monospace" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                <svg x-show="monospace" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
            @endif
            
            {{-- Clear Button --}}
            @if($showClear)
            <button 
                x-show="text.length > 0"
                @click="clearText()"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="inline-flex items-center px-3 py-1.5 text-sm bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors"
            >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Clear
            </button>
            @endif
        </div>
    </div>
    
    {{-- Textarea Container --}}
    <div class="relative">
        <textarea
            x-ref="textarea"
            id="{{ $id }}"
            @if($attributes->has('wire:model'))
                wire:model="{{ $attributes->get('wire:model') }}"
            @endif
            x-model="text"
            @input="handleInput"
            @paste="handlePaste"
            :class="{
                'font-mono': monospace,
                'font-sans': !monospace
            }"
            placeholder="{{ $placeholder }}"
            class="w-full p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:border-blue-500 dark:focus:border-blue-400 focus:outline-none transition-all duration-200 resize-none overflow-y-auto"
            :style="`min-height: ${minHeight}px; max-height: ${maxHeight}px; height: ${currentHeight}px;`"
            {{ $attributes->except(['wire:model', 'class']) }}
        ></textarea>
    </div>
    
    {{-- Character Counter and Stats --}}
    @if($showCounter)
    <div class="flex items-center justify-between mt-2 text-sm text-gray-600 dark:text-gray-400">
        <div class="flex items-center gap-4">
            <span>
                <span x-text="characterCount"></span> characters
            </span>
            <span>
                <span x-text="wordCount"></span> words
            </span>
            <span>
                <span x-text="lineCount"></span> lines
            </span>
        </div>
        
        {{-- Progress indicator for large texts --}}
        <div x-show="characterCount > 1000" class="flex items-center gap-2">
            <span class="text-xs">Large text</span>
            <div class="w-20 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div 
                    class="h-full bg-gradient-to-r from-blue-500 to-purple-600 transition-all duration-300"
                    :style="`width: ${Math.min(100, (characterCount / 10000) * 100)}%`"
                ></div>
            </div>
        </div>
    </div>
    @endif
</div>
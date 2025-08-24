<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Input Section -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <label class="text-sm font-semibold" style="color: var(--text-primary);">Input Text</label>
                <span class="text-xs" style="color: var(--text-tertiary);">
                    {{ $stats['inputChars'] }} chars • {{ $stats['inputWords'] }} words
                </span>
            </div>
            <textarea
                wire:model.live="inputText"
                placeholder="Enter or paste your text here..."
                class="w-full h-96 p-4 border rounded-lg resize-none focus:ring-2"
                style="border-color: var(--border-primary); background-color: var(--bg-primary); color: var(--text-primary); --tw-ring-color: var(--accent-primary);"
                onfocus="this.style.borderColor='var(--accent-primary)'"
                onblur="this.style.borderColor='var(--border-primary)'"
                autofocus
            ></textarea>
            
            <div class="mt-4 flex gap-2">
                <button
                    wire:click="clearAll"
                    class="px-4 py-2 text-sm font-medium border rounded-lg transition-colors"
                    style="background-color: var(--bg-primary); border-color: var(--border-primary); color: var(--text-primary);"
                    onmouseover="this.style.backgroundColor='var(--bg-secondary)'"
                    onmouseout="this.style.backgroundColor='var(--bg-primary)'"
                >
                    Clear All
                </button>
                <button
                    wire:click="swapTexts"
                    class="px-4 py-2 text-sm font-medium border rounded-lg transition-colors"
                    style="background-color: var(--bg-primary); border-color: var(--border-primary); color: var(--text-primary);"
                    onmouseover="this.style.backgroundColor='var(--bg-secondary)'"
                    onmouseout="this.style.backgroundColor='var(--bg-primary)'"
                >
                    ⇄ Swap
                </button>
            </div>
        </div>

        <!-- Output Section -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <label class="text-sm font-semibold" style="color: var(--text-primary);">Output Text</label>
                <span class="text-xs" style="color: var(--text-tertiary);">
                    {{ $stats['outputChars'] }} chars • {{ $stats['outputWords'] }} words
                </span>
            </div>
            <div class="relative">
                <textarea
                    readonly
                    wire:model="outputText"
                    placeholder="Transformed text will appear here..."
                    class="w-full h-96 p-4 border rounded-lg resize-none"
                    style="border-color: var(--border-primary); background-color: var(--bg-secondary); color: var(--text-primary);"
                ></textarea>
                
                @if($outputText)
                <div class="absolute top-2 right-2 flex gap-2">
                    <button
                        wire:click="copyToClipboard"
                        class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors flex items-center gap-1"
                        style="background-color: var(--accent-primary); color: white;"
                        onmouseover="this.style.opacity='0.8'"
                        onmouseout="this.style.opacity='1'"
                    >
                        @if($copied)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Copied!
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Copy
                        @endif
                    </button>
                    <button
                        wire:click="downloadOutput"
                        class="px-3 py-1.5 text-xs font-medium border rounded-lg transition-colors flex items-center gap-1"
                        style="background-color: var(--bg-primary); border-color: var(--border-primary); color: var(--text-primary);"
                        onmouseover="this.style.backgroundColor='var(--bg-secondary)'"
                        onmouseout="this.style.backgroundColor='var(--bg-primary)'"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Preservation Settings -->
    <div class="mt-8 rounded-lg p-6" style="background-color: var(--bg-secondary);">
        <h3 class="text-sm font-semibold mb-4" style="color: var(--text-primary);">Smart Preservation Settings</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="preservationSettings.urls" class="mr-2 rounded" style="color: var(--accent-primary); --tw-ring-color: var(--accent-primary);">
                <span class="text-sm" style="color: var(--text-primary);">Preserve URLs</span>
            </label>
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="preservationSettings.emails" class="mr-2 rounded" style="color: var(--accent-primary); --tw-ring-color: var(--accent-primary);">
                <span class="text-sm" style="color: var(--text-primary);">Preserve Emails</span>
            </label>
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="preservationSettings.brands" class="mr-2 rounded" style="color: var(--accent-primary); --tw-ring-color: var(--accent-primary);">
                <span class="text-sm" style="color: var(--text-primary);">Preserve Brands</span>
            </label>
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="preservationSettings.code_blocks" class="mr-2 rounded" style="color: var(--accent-primary); --tw-ring-color: var(--accent-primary);">
                <span class="text-sm" style="color: var(--text-primary);">Preserve Code</span>
            </label>
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="preservationSettings.markdown" class="mr-2 rounded" style="color: var(--accent-primary); --tw-ring-color: var(--accent-primary);">
                <span class="text-sm" style="color: var(--text-primary);">Preserve Markdown</span>
            </label>
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="preservationSettings.mentions" class="mr-2 rounded" style="color: var(--accent-primary); --tw-ring-color: var(--accent-primary);">
                <span class="text-sm" style="color: var(--text-primary);">Preserve @mentions</span>
            </label>
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="preservationSettings.hashtags" class="mr-2 rounded" style="color: var(--accent-primary); --tw-ring-color: var(--accent-primary);">
                <span class="text-sm" style="color: var(--text-primary);">Preserve #hashtags</span>
            </label>
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="preservationSettings.file_paths" class="mr-2 rounded" style="color: var(--accent-primary); --tw-ring-color: var(--accent-primary);">
                <span class="text-sm" style="color: var(--text-primary);">Preserve Paths</span>
            </label>
        </div>
    </div>
</div>

<script>
    window.addEventListener('copy-to-clipboard', event => {
        navigator.clipboard.writeText(event.detail.text);
    });
    
    window.addEventListener('reset-copied', event => {
        setTimeout(() => {
            @this.set('copied', false);
        }, 2000);
    });
</script>
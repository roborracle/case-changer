<div class="rounded-xl shadow-sm border p-6" style="background-color: var(--bg-primary); border-color: var(--border-primary);">
    <div class="space-y-6">
        <!-- Format Selector -->
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                Select {{ $categoryData['title'] }} Format:
            </label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                @foreach($categoryData['tools'] as $key => $tool)
                <button 
                    wire:click="$set('selectedFormat', '{{ $key }}')"
                    class="px-4 py-2 text-sm font-medium rounded-lg border transition-all"
                    style="@if($selectedFormat === $key) 
                               background-color: var(--accent-primary); color: white; border-color: var(--accent-primary);
                           @else 
                               background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-primary);
                           @endif"
                    @if($selectedFormat !== $key)
                    onmouseover="this.style.borderColor='var(--accent-primary)'; this.style.backgroundColor='var(--bg-secondary)';"
                    onmouseout="this.style.borderColor='var(--border-primary)'; this.style.backgroundColor='var(--bg-primary)';"
                    @endif
                >
                    {{ $tool['name'] }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Current Tool Description -->
        @if(isset($categoryData['tools'][$selectedFormat]))
        <div class="rounded-lg p-4" style="background-color: var(--bg-secondary);">
            <h3 class="text-sm font-semibold mb-1" style="color: var(--accent-primary);">
                {{ $categoryData['tools'][$selectedFormat]['name'] }}
            </h3>
            <p class="text-sm" style="color: var(--text-secondary);">
                {{ $categoryData['tools'][$selectedFormat]['description'] }}
            </p>
        </div>
        @endif

        <!-- Input/Output Areas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Input -->
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                    <span>Input Text</span>
                    <span class="text-xs ml-2" style="color: var(--text-tertiary);">(Type or paste)</span>
                </label>
                <textarea 
                    wire:model.live.debounce.300ms="inputText"
                    class="w-full h-48 px-4 py-3 border rounded-lg focus:ring-2 resize-none"
                    style="border-color: var(--border-primary); background-color: var(--bg-primary); color: var(--text-primary); --tw-ring-color: var(--accent-primary);"
                    onfocus="this.style.borderColor='var(--accent-primary)'"
                    onblur="this.style.borderColor='var(--border-primary)'"
                    placeholder="Enter your text here..."
                ></textarea>
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-xs" style="color: var(--text-tertiary);">
                        {{ strlen($inputText) }} characters | {{ str_word_count($inputText) }} words
                    </span>
                    <button 
                        wire:click="clearText"
                        class="text-xs font-medium transition-colors"
                        style="color: #dc2626;"
                        onmouseover="this.style.color='#b91c1c'"
                        onmouseout="this.style.color='#dc2626'"
                        @if(empty($inputText)) disabled opacity-50 @endif
                    >
                        Clear All
                    </button>
                </div>
            </div>

            <!-- Output -->
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                    <span>Converted Text</span>
                    @if($outputText)
                    <span class="text-xs ml-2" style="color: #16a34a;">✓ Ready</span>
                    @endif
                </label>
                <div class="relative">
                    <textarea 
                        readonly
                        wire:model="outputText"
                        class="w-full h-48 px-4 py-3 border rounded-lg resize-none"
                        style="border-color: var(--border-primary); background-color: var(--bg-secondary); color: var(--text-primary);"
                        placeholder="Converted text will appear here..."
                    ></textarea>
                    
                    @if($outputText)
                    <!-- Action Buttons -->
                    <div class="absolute top-2 right-2 flex gap-2">
                        <button 
                            onclick="navigator.clipboard.writeText(this.closest('.relative').querySelector('textarea').value); 
                                     this.innerHTML = '<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'></path></svg> Copied!'; 
                                     setTimeout(() => this.innerHTML = '<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z\'></path></svg> Copy', 2000);"
                            class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium border rounded-md transition-colors"
                            style="background-color: var(--bg-primary); border-color: var(--border-primary); color: var(--text-primary);"
                            onmouseover="this.style.backgroundColor='var(--bg-secondary)'"
                            onmouseout="this.style.backgroundColor='var(--bg-primary)'"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Copy
                        </button>
                        <button 
                            wire:click="downloadText"
                            class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium border rounded-md transition-colors"
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
                <div class="mt-2">
                    <span class="text-xs" style="color: var(--text-tertiary);">
                        {{ strlen($outputText) }} characters | {{ str_word_count($outputText) }} words
                    </span>
                </div>
            </div>
        </div>

        <!-- Preservation Options -->
        @if($showPreservationOptions)
        <div class="rounded-lg p-4" style="background-color: var(--bg-secondary);">
            <h3 class="text-sm font-medium mb-3" style="color: var(--text-primary);">Smart Preservation:</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                <label class="flex items-center text-sm cursor-pointer" style="color: var(--text-primary);">
                    <input type="checkbox" wire:model.live="preserveUrls" class="mr-2 rounded" style="color: var(--accent-primary);">
                    <span>Preserve URLs</span>
                </label>
                <label class="flex items-center text-sm cursor-pointer" style="color: var(--text-primary);">
                    <input type="checkbox" wire:model.live="preserveEmails" class="mr-2 rounded" style="color: var(--accent-primary);">
                    <span>Preserve Emails</span>
                </label>
                <label class="flex items-center text-sm cursor-pointer" style="color: var(--text-primary);">
                    <input type="checkbox" wire:model.live="preserveHashtags" class="mr-2 rounded" style="color: var(--accent-primary);">
                    <span>Preserve #hashtags</span>
                </label>
                <label class="flex items-center text-sm cursor-pointer" style="color: var(--text-primary);">
                    <input type="checkbox" wire:model.live="preserveMentions" class="mr-2 rounded" style="color: var(--accent-primary);">
                    <span>Preserve @mentions</span>
                </label>
                <label class="flex items-center text-sm cursor-pointer" style="color: var(--text-primary);">
                    <input type="checkbox" wire:model.live="preserveCodeBlocks" class="mr-2 rounded" style="color: var(--accent-primary);">
                    <span>Preserve Code</span>
                </label>
            </div>
        </div>
        @endif
    </div>
</div>
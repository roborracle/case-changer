<div class="space-y-6">
    <!-- Format Selector -->
    <div>
        <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Select Conversion Format:</label>
        <div class="relative">
            <select wire:model.live="selectedFormat" 
                    class="w-full px-4 py-3 pr-10 border rounded-lg focus:ring-2 appearance-none"
                    style="border-color: var(--border-primary); background-color: var(--bg-primary); color: var(--text-primary); --tw-ring-color: var(--accent-primary);"
                    onfocus="this.style.borderColor='var(--accent-primary)'"
                    onblur="this.style.borderColor='var(--border-primary)'">
            @foreach($formats as $category => $categoryFormats)
                <optgroup label="{{ $category }}">
                    @foreach($categoryFormats as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5" style="color: var(--text-tertiary);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Input/Output Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Input -->
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Input Text:</label>
            <textarea 
                wire:model.live="inputText"
                class="w-full h-64 px-4 py-3 border rounded-lg focus:ring-2 font-mono text-sm"
                style="border-color: var(--border-primary); background-color: var(--bg-primary); color: var(--text-primary); --tw-ring-color: var(--accent-primary);"
                onfocus="this.style.borderColor='var(--accent-primary)'"
                onblur="this.style.borderColor='var(--border-primary)'"
                placeholder="Type or paste your text here..."
            ></textarea>
            <div class="mt-2 flex items-center justify-between">
                <span class="text-xs" style="color: var(--text-tertiary);">
                    {{ strlen($inputText) }} characters
                </span>
                <button 
                    wire:click="clearText"
                    class="text-xs font-medium"
                    style="color: #dc2626;"
                    onmouseover="this.style.color='#b91c1c'"
                    onmouseout="this.style.color='#dc2626'"
                    @if(empty($inputText)) disabled @endif
                >
                    Clear
                </button>
            </div>
        </div>

        <!-- Output -->
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Converted Text:</label>
            <div class="relative">
                <textarea 
                    readonly
                    wire:model="outputText"
                    class="w-full h-64 px-4 py-3 border rounded-lg font-mono text-sm"
                    style="border-color: var(--border-primary); background-color: var(--bg-secondary); color: var(--text-primary);"
                    placeholder="Converted text will appear here..."
                ></textarea>
                
                <!-- Action Buttons -->
                <div class="absolute top-2 right-2 flex gap-2">
                    <button 
                        onclick="navigator.clipboard.writeText(this.closest('.relative').querySelector('textarea').value); 
                                 this.textContent = 'Copied!'; 
                                 setTimeout(() => this.textContent = 'Copy', 2000);"
                        class="px-3 py-1 text-xs border rounded transition-colors"
                        style="background-color: var(--bg-primary); border-color: var(--border-primary); color: var(--text-primary);"
                        onmouseover="this.style.backgroundColor='var(--bg-secondary)'"
                        onmouseout="this.style.backgroundColor='var(--bg-primary)'"
                        @if(empty($outputText)) disabled @endif
                    >
                        Copy
                    </button>
                    <button 
                        wire:click="downloadText"
                        class="px-3 py-1 text-xs border rounded transition-colors"
                        style="background-color: var(--bg-primary); border-color: var(--border-primary); color: var(--text-primary);"
                        onmouseover="this.style.backgroundColor='var(--bg-secondary)'"
                        onmouseout="this.style.backgroundColor='var(--bg-primary)'"
                        @if(empty($outputText)) disabled @endif
                    >
                        Download
                    </button>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs" style="color: var(--text-tertiary);">
                    {{ strlen($outputText) }} characters
                </span>
            </div>
        </div>
    </div>

    <!-- Preservation Options (for developer formats) -->
    @if($showPreservationOptions)
    <div class="rounded-lg p-4" style="background-color: var(--bg-secondary);">
        <h3 class="text-sm font-medium mb-3" style="color: var(--text-primary);">Preservation Options:</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <label class="flex items-center text-sm" style="color: var(--text-primary);">
                <input type="checkbox" wire:model.live="preserveUrls" class="mr-2 rounded" style="color: var(--accent-primary);">
                <span>URLs</span>
            </label>
            <label class="flex items-center text-sm" style="color: var(--text-primary);">
                <input type="checkbox" wire:model.live="preserveEmails" class="mr-2 rounded" style="color: var(--accent-primary);">
                <span>Emails</span>
            </label>
            <label class="flex items-center text-sm" style="color: var(--text-primary);">
                <input type="checkbox" wire:model.live="preserveHashtags" class="mr-2 rounded" style="color: var(--accent-primary);">
                <span>Hashtags</span>
            </label>
            <label class="flex items-center text-sm" style="color: var(--text-primary);">
                <input type="checkbox" wire:model.live="preserveMentions" class="mr-2 rounded" style="color: var(--accent-primary);">
                <span>@mentions</span>
            </label>
            <label class="flex items-center text-sm" style="color: var(--text-primary);">
                <input type="checkbox" wire:model.live="preserveCodeBlocks" class="mr-2 rounded" style="color: var(--accent-primary);">
                <span>Code Blocks</span>
            </label>
        </div>
    </div>
    @endif

    <!-- Quick Examples -->
    <div class="rounded-lg p-4 border" style="background-color: var(--bg-secondary); border-color: var(--border-primary);">
        <h3 class="text-sm font-semibold mb-2" style="color: var(--accent-primary);">Quick Tips:</h3>
        <ul class="text-sm space-y-1" style="color: var(--text-secondary);">
            <li>• Select any format from 91 different conversion options</li>
            <li>• Real-time conversion as you type</li>
            <li>• Preservation options available for developer formats</li>
            <li>• Copy or download your converted text instantly</li>
        </ul>
    </div>
</div>
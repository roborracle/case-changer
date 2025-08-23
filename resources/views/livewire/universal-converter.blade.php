<div class="space-y-6">
    <!-- Format Selector -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Conversion Format:</label>
        <select wire:model.live="selectedFormat" 
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @foreach($formats as $category => $categoryFormats)
                <optgroup label="{{ $category }}">
                    @foreach($categoryFormats as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>

    <!-- Input/Output Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Input Text:</label>
            <textarea 
                wire:model.live.debounce.300ms="inputText"
                class="w-full h-64 px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                placeholder="Type or paste your text here..."
            ></textarea>
            <div class="mt-2 flex items-center justify-between">
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ strlen($inputText) }} characters
                </span>
                <button 
                    wire:click="clearText"
                    class="text-xs text-red-600 hover:text-red-700 font-medium"
                    @if(empty($inputText)) disabled @endif
                >
                    Clear
                </button>
            </div>
        </div>

        <!-- Output -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Converted Text:</label>
            <div class="relative">
                <textarea 
                    readonly
                    wire:model="outputText"
                    class="w-full h-64 px-4 py-3 border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg font-mono text-sm"
                    placeholder="Converted text will appear here..."
                ></textarea>
                
                <!-- Action Buttons -->
                <div class="absolute top-2 right-2 flex gap-2">
                    <button 
                        onclick="navigator.clipboard.writeText(this.closest('.relative').querySelector('textarea').value); 
                                 this.textContent = 'Copied!'; 
                                 setTimeout(() => this.textContent = 'Copy', 2000);"
                        class="px-3 py-1 text-xs bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors"
                        @if(empty($outputText)) disabled @endif
                    >
                        Copy
                    </button>
                    <button 
                        wire:click="downloadText"
                        class="px-3 py-1 text-xs bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors"
                        @if(empty($outputText)) disabled @endif
                    >
                        Download
                    </button>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ strlen($outputText) }} characters
                </span>
            </div>
        </div>
    </div>

    <!-- Preservation Options (for developer formats) -->
    @if($showPreservationOptions)
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-700 mb-3">Preservation Options:</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <label class="flex items-center text-sm">
                <input type="checkbox" wire:model.live="preserveUrls" class="mr-2 rounded">
                <span>URLs</span>
            </label>
            <label class="flex items-center text-sm">
                <input type="checkbox" wire:model.live="preserveEmails" class="mr-2 rounded">
                <span>Emails</span>
            </label>
            <label class="flex items-center text-sm">
                <input type="checkbox" wire:model.live="preserveHashtags" class="mr-2 rounded">
                <span>Hashtags</span>
            </label>
            <label class="flex items-center text-sm">
                <input type="checkbox" wire:model.live="preserveMentions" class="mr-2 rounded">
                <span>@mentions</span>
            </label>
            <label class="flex items-center text-sm">
                <input type="checkbox" wire:model.live="preserveCodeBlocks" class="mr-2 rounded">
                <span>Code Blocks</span>
            </label>
        </div>
    </div>
    @endif

    <!-- Quick Examples -->
    <div class="bg-blue-50 rounded-lg p-4">
        <h3 class="text-sm font-semibold text-blue-900 mb-2">Quick Tips:</h3>
        <ul class="text-sm text-blue-700 space-y-1">
            <li>• Select any format from 91 different conversion options</li>
            <li>• Real-time conversion as you type</li>
            <li>• Preservation options available for developer formats</li>
            <li>• Copy or download your converted text instantly</li>
        </ul>
    </div>
</div>
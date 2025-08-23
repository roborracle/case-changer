<div class="space-y-6">
    <!-- Format Selector -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Conversion Format:</label>
        <div class="relative">
            <select wire:model.live="selectedFormat" 
                    class="w-full px-4 py-3 pr-10 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
            @foreach($formats as $category => $categoryFormats)
                <optgroup label="{{ $category }}">
                    @foreach($categoryFormats as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
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
                        class="px-3 py-1 text-xs bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors"
                        @if(empty($outputText)) disabled @endif
                    >
                        Copy
                    </button>
                    <button 
                        wire:click="downloadText"
                        class="px-3 py-1 text-xs bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors"
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
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Preservation Options:</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                <input type="checkbox" wire:model.live="preserveUrls" class="mr-2 rounded">
                <span>URLs</span>
            </label>
            <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                <input type="checkbox" wire:model.live="preserveEmails" class="mr-2 rounded">
                <span>Emails</span>
            </label>
            <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                <input type="checkbox" wire:model.live="preserveHashtags" class="mr-2 rounded">
                <span>Hashtags</span>
            </label>
            <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                <input type="checkbox" wire:model.live="preserveMentions" class="mr-2 rounded">
                <span>@mentions</span>
            </label>
            <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                <input type="checkbox" wire:model.live="preserveCodeBlocks" class="mr-2 rounded">
                <span>Code Blocks</span>
            </label>
        </div>
    </div>
    @endif

    <!-- Quick Examples -->
    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
        <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-2">Quick Tips:</h3>
        <ul class="text-sm text-blue-700 dark:text-blue-400 space-y-1">
            <li>• Select any format from 91 different conversion options</li>
            <li>• Real-time conversion as you type</li>
            <li>• Preservation options available for developer formats</li>
            <li>• Copy or download your converted text instantly</li>
        </ul>
    </div>
</div>
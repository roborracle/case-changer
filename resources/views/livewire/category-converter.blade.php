<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="space-y-6">
        <!-- Format Selector -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Select {{ $categoryData['title'] }} Format:
            </label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                @foreach($categoryData['tools'] as $key => $tool)
                <button 
                    wire:click="$set('selectedFormat', '{{ $key }}')"
                    class="px-4 py-2 text-sm font-medium rounded-lg border transition-all
                           @if($selectedFormat === $key) 
                               bg-blue-500 text-white border-blue-500
                           @else 
                               bg-white text-gray-700 border-gray-300 hover:border-blue-500 hover:bg-blue-50
                           @endif"
                >
                    {{ $tool['name'] }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Current Tool Description -->
        @if(isset($categoryData['tools'][$selectedFormat]))
        <div class="bg-blue-50 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-blue-900 mb-1">
                {{ $categoryData['tools'][$selectedFormat]['name'] }}
            </h3>
            <p class="text-sm text-blue-700">
                {{ $categoryData['tools'][$selectedFormat]['description'] }}
            </p>
        </div>
        @endif

        <!-- Input/Output Areas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <span>Input Text</span>
                    <span class="text-xs text-gray-500 ml-2">(Type or paste)</span>
                </label>
                <textarea 
                    wire:model.live.debounce.300ms="inputText"
                    class="w-full h-48 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                    placeholder="Enter your text here..."
                ></textarea>
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-xs text-gray-500">
                        {{ strlen($inputText) }} characters | {{ str_word_count($inputText) }} words
                    </span>
                    <button 
                        wire:click="clearText"
                        class="text-xs text-red-600 hover:text-red-700 font-medium transition-colors"
                        @if(empty($inputText)) disabled opacity-50 @endif
                    >
                        Clear All
                    </button>
                </div>
            </div>

            <!-- Output -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <span>Converted Text</span>
                    @if($outputText)
                    <span class="text-xs text-green-600 ml-2">✓ Ready</span>
                    @endif
                </label>
                <div class="relative">
                    <textarea 
                        readonly
                        wire:model="outputText"
                        class="w-full h-48 px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 resize-none"
                        placeholder="Converted text will appear here..."
                    ></textarea>
                    
                    @if($outputText)
                    <!-- Action Buttons -->
                    <div class="absolute top-2 right-2 flex gap-2">
                        <button 
                            onclick="navigator.clipboard.writeText(this.closest('.relative').querySelector('textarea').value); 
                                     this.innerHTML = '<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'></path></svg> Copied!'; 
                                     setTimeout(() => this.innerHTML = '<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z\'></path></svg> Copy', 2000);"
                            class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Copy
                        </button>
                        <button 
                            wire:click="downloadText"
                            class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
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
                    <span class="text-xs text-gray-500">
                        {{ strlen($outputText) }} characters | {{ str_word_count($outputText) }} words
                    </span>
                </div>
            </div>
        </div>

        <!-- Preservation Options -->
        @if($showPreservationOptions)
        <div class="bg-gray-50 rounded-lg p-4">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Smart Preservation:</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                <label class="flex items-center text-sm cursor-pointer">
                    <input type="checkbox" wire:model.live="preserveUrls" class="mr-2 rounded text-blue-500">
                    <span>Preserve URLs</span>
                </label>
                <label class="flex items-center text-sm cursor-pointer">
                    <input type="checkbox" wire:model.live="preserveEmails" class="mr-2 rounded text-blue-500">
                    <span>Preserve Emails</span>
                </label>
                <label class="flex items-center text-sm cursor-pointer">
                    <input type="checkbox" wire:model.live="preserveHashtags" class="mr-2 rounded text-blue-500">
                    <span>Preserve #hashtags</span>
                </label>
                <label class="flex items-center text-sm cursor-pointer">
                    <input type="checkbox" wire:model.live="preserveMentions" class="mr-2 rounded text-blue-500">
                    <span>Preserve @mentions</span>
                </label>
                <label class="flex items-center text-sm cursor-pointer">
                    <input type="checkbox" wire:model.live="preserveCodeBlocks" class="mr-2 rounded text-blue-500">
                    <span>Preserve Code</span>
                </label>
            </div>
        </div>
        @endif
    </div>
</div>
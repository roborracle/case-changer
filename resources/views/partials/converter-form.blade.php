<div class="space-y-6">
    <!-- Input Area with Helper Buttons -->
    <form method="POST" action="{{ route('home.post') }}" id="transformation-form">
        @csrf
        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <label for="input-text" class="text-lg font-semibold text-gray-900 dark:text-white">Your Text</label>
                <div class="flex items-center space-x-2">
                    <button type="button" onclick="loadExample()"
                            class="inline-flex items-center px-3 py-1.5 text-sm text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 rounded-lg border border-blue-300 dark:border-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Example
                    </button>
                    <button type="button" onclick="clearText()"
                            class="inline-flex items-center px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 bg-white hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg border border-gray-300 dark:border-gray-600 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear
                    </button>
                </div>
            </div>
            <textarea
                name="input"
                id="input-text"
                rows="6"
                aria-label="Input text for transformation"
                class="w-full px-4 py-3 text-base border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 resize-none"
                placeholder="Type or paste your text here..."
            >{{ old('input', $input ?? '') }}</textarea>
            @error('input')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Hidden field for transformation type -->
        <input type="hidden" name="transformation" id="transformation-type" value="{{ old('transformation', $selectedTransformation ?? 'upper-case') }}">
        
        <!-- Transformation Buttons -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @php
            $popularTools = [
                ['key' => 'upper-case', 'label' => 'UPPERCASE'],
                ['key' => 'lower-case', 'label' => 'lowercase'],
                ['key' => 'title-case', 'label' => 'Title Case'],
                ['key' => 'sentence-case', 'label' => 'Sentence Case'],
                ['key' => 'camel-case', 'label' => 'camelCase'],
                ['key' => 'pascal-case', 'label' => 'PascalCase'],
                ['key' => 'snake-case', 'label' => 'snake_case'],
                ['key' => 'kebab-case', 'label' => 'kebab-case'],
            ];
            @endphp
            
            @foreach($popularTools as $tool)
                <button type="submit" 
                        onclick="setTransformation('{{ $tool['key'] }}')"
                        class="px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200
                               @if(($selectedTransformation ?? '') === $tool['key'])
                                   bg-blue-600 text-white shadow-lg scale-105
                               @else
                                   bg-gray-100 hover:bg-gray-200 text-gray-800
                                   dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white
                               @endif">
                    {{ $tool['label'] }}
                </button>
            @endforeach
        </div>
    </form>

    <!-- Output Area -->
    @if(!empty($output))
        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <label class="text-lg font-semibold text-gray-900 dark:text-white">Result</label>
                <button type="button" onclick="copyToClipboard()"
                        class="inline-flex items-center px-3 py-1.5 text-sm text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 rounded-lg border border-green-300 dark:border-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copy
                </button>
            </div>
            <div id="output-text"
                 class="w-full px-4 py-3 text-base border rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 min-h-[150px] whitespace-pre-wrap"
            >{{ $output }}</div>
        </div>
    @endif
</div>

<!-- Vanilla JavaScript for form interactions -->
<script nonce="{{ csp_nonce() }}">
function setTransformation(type) {
    document.getElementById('transformation-type').value = type;
}

function loadExample() {
    document.getElementById('input-text').value = 'Hello World - This is a Sample Text';
}

function clearText() {
    document.getElementById('input-text').value = '';
    const outputEl = document.getElementById('output-text');
    if (outputEl) {
        outputEl.parentElement.parentElement.style.display = 'none';
    }
}

function copyToClipboard() {
    const outputText = document.getElementById('output-text').innerText;
    navigator.clipboard.writeText(outputText).then(function() {
        // Show feedback
        const button = event.currentTarget;
        const originalHTML = button.innerHTML;
        button.innerHTML = '<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Copied!';
        button.classList.remove('text-green-600', 'hover:text-green-700');
        button.classList.add('text-green-700');
        
        setTimeout(function() {
            button.innerHTML = originalHTML;
            button.classList.add('text-green-600', 'hover:text-green-700');
            button.classList.remove('text-green-700');
        }, 2000);
    }).catch(function(err) {
        console.error('Failed to copy text: ', err);
    });
}
</script>
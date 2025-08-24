<div class="w-full max-w-7xl mx-auto">
    <!-- Tool Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold mb-3" style="color: var(--text-primary);">
            {{ $toolInfo['name'] }}
        </h1>
        @if($toolInfo['description'])
        <p class="text-lg" style="color: var(--text-secondary);">
            {{ $toolInfo['description'] }}
        </p>
        @endif
    </div>

    <!-- Main Tool Interface -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <!-- Input Section -->
        @if($category !== 'generators')
        <div>
            <div class="flex justify-between items-center mb-3">
                <label class="text-sm font-semibold" style="color: var(--text-primary);">
                    Input Text
                </label>
                <div class="flex space-x-2">
                    <button wire:click="clearText" 
                            class="text-xs px-3 py-1 rounded-md transition-colors"
                            style="background-color: var(--bg-tertiary); color: var(--text-secondary);"
                            onmouseover="this.style.backgroundColor='var(--bg-quaternary)'"
                            onmouseout="this.style.backgroundColor='var(--bg-tertiary)'">
                        Clear
                    </button>
                    <span class="text-xs" style="color: var(--text-tertiary);">
                        {{ strlen($input) }} chars
                    </span>
                </div>
            </div>
            <textarea 
                wire:model.live="input"
                rows="12"
                class="w-full p-4 rounded-lg font-mono text-sm transition-all"
                style="background-color: var(--bg-primary); color: var(--text-primary); border: 1px solid var(--border-primary);"
                placeholder="Enter or paste your text here..."
            ></textarea>
        </div>
        @endif

        <!-- Output Section -->
        <div class="{{ $category === 'generators' ? 'md:col-span-2' : '' }}">
            <div class="flex justify-between items-center mb-3">
                <label class="text-sm font-semibold" style="color: var(--text-primary);">
                    {{ $category === 'generators' ? 'Generated Output' : 'Output' }}
                </label>
                <div class="flex space-x-2">
                    @if($category === 'generators')
                    <button wire:click="generateOutput" 
                            class="text-xs px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Generate New
                    </button>
                    @endif
                    <button onclick="copyToClipboard()" 
                            class="text-xs px-3 py-1 rounded-md transition-colors"
                            style="background-color: var(--accent-primary); color: white;">
                        Copy
                    </button>
                    <button wire:click="downloadText" 
                            class="text-xs px-3 py-1 rounded-md transition-colors"
                            style="background-color: var(--bg-tertiary); color: var(--text-secondary);"
                            onmouseover="this.style.backgroundColor='var(--bg-quaternary)'"
                            onmouseout="this.style.backgroundColor='var(--bg-tertiary)'">
                        Download
                    </button>
                </div>
            </div>
            <textarea 
                readonly
                rows="12"
                id="output-text"
                class="w-full p-4 rounded-lg font-mono text-sm transition-all"
                style="background-color: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--border-primary);"
                placeholder="{{ $category === 'generators' ? 'Click Generate New to create output...' : 'Your transformed text will appear here...' }}"
            >{{ $output }}</textarea>
        </div>
    </div>

    <!-- Tool Options (if applicable) -->
    @if(!empty($toolInfo['options']))
    <div class="mb-8 p-6 rounded-lg" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);">
        <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary);">Options</h3>
        <div class="grid md:grid-cols-3 gap-4">
            @foreach($toolInfo['options'] as $optionKey => $option)
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                    {{ $option['label'] }}
                </label>
                @if($option['type'] === 'checkbox')
                <input type="checkbox" 
                       wire:model.live="options.{{ $optionKey }}"
                       class="rounded">
                @elseif($option['type'] === 'select')
                <select wire:model.live="options.{{ $optionKey }}"
                        class="w-full px-3 py-2 rounded-md"
                        style="background-color: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--border-primary);">
                    @foreach($option['values'] as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @elseif($option['type'] === 'number')
                <input type="number" 
                       wire:model.live="options.{{ $optionKey }}"
                       min="{{ $option['min'] ?? 0 }}"
                       max="{{ $option['max'] ?? 100 }}"
                       class="w-full px-3 py-2 rounded-md"
                       style="background-color: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--border-primary);">
                @else
                <input type="text" 
                       wire:model.live="options.{{ $optionKey }}"
                       class="w-full px-3 py-2 rounded-md"
                       style="background-color: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--border-primary);">
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Features -->
    @if(!empty($toolInfo['features']))
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        @foreach($toolInfo['features'] as $feature)
        <div class="text-center p-6 rounded-lg" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);">
            <div class="text-3xl mb-3">{{ $feature['icon'] ?? '✨' }}</div>
            <h3 class="font-semibold mb-2" style="color: var(--text-primary);">{{ $feature['title'] }}</h3>
            <p class="text-sm" style="color: var(--text-secondary);">{{ $feature['description'] }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Example -->
    @if($toolInfo['example_input'] && $toolInfo['example_output'])
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary);">Example</h3>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="p-4 rounded-lg" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);">
                <h4 class="text-sm font-medium mb-2" style="color: var(--text-secondary);">Input:</h4>
                <pre class="text-sm font-mono" style="color: var(--text-primary);">{{ $toolInfo['example_input'] }}</pre>
            </div>
            <div class="p-4 rounded-lg" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);">
                <h4 class="text-sm font-medium mb-2" style="color: var(--text-secondary);">Output:</h4>
                <pre class="text-sm font-mono" style="color: var(--text-primary);">{{ $toolInfo['example_output'] }}</pre>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function copyToClipboard() {
    const output = document.getElementById('output-text');
    output.select();
    output.setSelectionRange(0, 99999);
    
    try {
        document.execCommand('copy');
        
        // Show notification
        const notification = document.createElement('div');
        notification.textContent = 'Copied to clipboard!';
        notification.className = 'fixed top-4 right-4 px-4 py-2 bg-green-600 text-white rounded-lg shadow-lg z-50';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 2000);
    } catch (err) {
        console.error('Failed to copy text: ', err);
    }
}
</script>
@endpush
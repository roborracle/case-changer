{{-- Global Keyboard Shortcuts Component --}}
<div 
    x-data="keyboardShortcuts()"
    x-init="init()"
    @keydown.window="handleKeydown($event)"
    class="hidden"
>
    {{-- Help Modal --}}
    <div 
        x-show="showHelp"
        x-cloak
        @click.away="showHelp = false"
        @keydown.escape.window="showHelp = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >
        {{-- Backdrop --}}
        <div 
            x-show="showHelp"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        ></div>
        
        {{-- Modal Content --}}
        <div 
            x-show="showHelp"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden"
        >
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Keyboard Shortcuts
                    </h2>
                    <button 
                        @click="showHelp = false"
                        class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            {{-- Shortcuts List --}}
            <div class="px-6 py-4 overflow-y-auto max-h-[60vh]">
                <div class="space-y-6">
                    {{-- General Shortcuts --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">General</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Show this help</span>
                                <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">?</kbd>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Focus input</span>
                                <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">/</kbd>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Clear input</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Ctrl</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Shift</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">K</kbd>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Transformation Shortcuts --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Quick Transformations</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">UPPERCASE</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Ctrl</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Shift</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">U</kbd>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">lowercase</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Ctrl</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Shift</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">L</kbd>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Title Case</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Ctrl</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Shift</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">T</kbd>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Sentence case</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Ctrl</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Shift</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">S</kbd>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">camelCase</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Ctrl</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Shift</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">C</kbd>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Clipboard Shortcuts --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Clipboard</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Copy output</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Ctrl</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Shift</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">C</kbd>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Swap input/output</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Ctrl</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Shift</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">X</kbd>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Navigation Shortcuts --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Tab Navigation</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Next tab</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Tab</kbd>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Previous tab</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Shift</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Tab</kbd>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Go to tab (1-5)</span>
                                <div class="flex gap-1">
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Alt</kbd>
                                    <kbd class="px-2 py-1 text-sm font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">1-5</kbd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Press <kbd class="px-2 py-1 text-xs font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded">Esc</kbd> to close
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function keyboardShortcuts() {
    return {
        showHelp: false,
        shortcuts: {},
        
        init() {
            // Register shortcuts
            this.shortcuts = {
                '?': () => this.showHelp = true,
                '/': () => this.focusInput(),
                'ctrl+shift+k': () => this.clearInput(),
                'ctrl+shift+u': () => this.transform('upper-case'),
                'ctrl+shift+l': () => this.transform('lower-case'),
                'ctrl+shift+t': () => this.transform('title-case'),
                'ctrl+shift+s': () => this.transform('sentence-case'),
                'ctrl+shift+c': () => this.copyOutput(),
                'ctrl+shift+x': () => this.swapInputOutput(),
                'alt+1': () => this.selectTab(0),
                'alt+2': () => this.selectTab(1),
                'alt+3': () => this.selectTab(2),
                'alt+4': () => this.selectTab(3),
                'alt+5': () => this.selectTab(4),
            };
            
            // Show help on first visit
            if (!localStorage.getItem('keyboard-shortcuts-seen')) {
                setTimeout(() => {
                    this.showHelp = true;
                    localStorage.setItem('keyboard-shortcuts-seen', 'true');
                }, 2000);
            }
        },
        
        handleKeydown(event) {
            // Don't trigger shortcuts when typing in input/textarea
            if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
                // Allow slash key for focus
                if (event.key === '/' && !event.ctrlKey && !event.altKey) {
                    return;
                }
                // Allow other shortcuts only with modifiers
                if (!event.ctrlKey && !event.altKey) {
                    return;
                }
            }
            
            // Build shortcut key string
            let key = '';
            if (event.ctrlKey || event.metaKey) key += 'ctrl+';
            if (event.shiftKey) key += 'shift+';
            if (event.altKey) key += 'alt+';
            key += event.key.toLowerCase();
            
            // Execute shortcut if exists
            if (this.shortcuts[key]) {
                event.preventDefault();
                this.shortcuts[key]();
            }
        },
        
        focusInput() {
            const input = document.querySelector('textarea[wire\\:model*="inputText"], #auto-resize-textarea');
            if (input) {
                input.focus();
                input.select();
            }
        },
        
        clearInput() {
            window.Livewire.dispatch('clearText');
        },
        
        transform(type) {
            window.Livewire.dispatch('transform', { type });
        },
        
        copyOutput() {
            window.Livewire.dispatch('copyOutput');
        },
        
        swapInputOutput() {
            window.Livewire.dispatch('swapInputOutput');
        },
        
        selectTab(index) {
            const tabs = document.querySelectorAll('[role="tab"]');
            if (tabs[index]) {
                tabs[index].click();
            }
        }
    };
}
</script>
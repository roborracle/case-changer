/**
 * Alpine.js Universal Converter Component
 * Provides unified transformation functionality across all tool pages
 */

import { 
    transform, 
    getMethod, 
    hasMethod,
    getAllMethods, 
    getGroupedMethods,
    getCategory,
    getAllCategories 
} from './transformations/index.js';

/**
 * Main converter component with comprehensive state management
 */
export function converterComponent() {
    return {
        // Core state
        inputText: '',
        outputText: '',
        selectedTransformation: 'upper-case',
        
        // UI state
        isProcessing: false,
        error: null,
        showCopySuccess: false,
        showOptions: false,
        
        // Transformation options
        options: {},
        defaultOptions: {},
        
        // History management
        history: [],
        historyIndex: -1,
        maxHistorySize: 50,
        
        // Performance tracking
        lastTransformTime: 0,
        
        // Available transformations
        transformations: {},
        categories: [],
        
        // Debounce timer
        debounceTimer: null,
        
        /**
         * Initialize component
         */
        init() {
            console.log('Universal converter initialized');
            this.loadTransformations();
            this.loadSavedState();
            this.setupKeyboardShortcuts();
            
            // Watch for input changes with debounce
            this.$watch('inputText', () => {
                this.debouncedTransform();
            });
            
            // Watch for transformation changes
            this.$watch('selectedTransformation', () => {
                this.loadTransformationOptions();
                this.transform();
            });
        },
        
        /**
         * Load all available transformations
         */
        loadTransformations() {
            this.transformations = getGroupedMethods();
            this.categories = getAllCategories();
            console.log(`Loaded ${getAllMethods().length} transformations across ${this.categories.length} categories`);
        },
        
        /**
         * Load saved state from localStorage
         */
        loadSavedState() {
            try {
                const saved = localStorage.getItem('converterState');
                if (saved) {
                    const state = JSON.parse(saved);
                    if (state.selectedTransformation) {
                        this.selectedTransformation = state.selectedTransformation;
                    }
                    if (state.options) {
                        this.options = state.options;
                    }
                }
            } catch (error) {
                console.error('Failed to load saved state:', error);
            }
        },
        
        /**
         * Save current state to localStorage
         */
        saveState() {
            try {
                localStorage.setItem('converterState', JSON.stringify({
                    selectedTransformation: this.selectedTransformation,
                    options: this.options
                }));
            } catch (error) {
                console.error('Failed to save state:', error);
            }
        },
        
        /**
         * Load options for current transformation
         */
        loadTransformationOptions() {
            const method = getMethod(this.selectedTransformation);
            if (method && method.getOptions) {
                this.defaultOptions = method.getOptions();
                this.options = { ...this.defaultOptions };
            } else {
                this.defaultOptions = {};
                this.options = {};
            }
        },
        
        /**
         * Debounced transform for input changes
         */
        debouncedTransform() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.transform();
            }, 300);
        },
        
        /**
         * Main transformation method
         */
        async transform() {
            if (!this.inputText) {
                this.outputText = '';
                this.error = null;
                return;
            }
            
            this.isProcessing = true;
            this.error = null;
            const startTime = performance.now();
            
            try {
                // Check if transformation exists
                if (!hasMethod(this.selectedTransformation)) {
                    throw new Error(`Transformation '${this.selectedTransformation}' not found`);
                }
                
                // Perform transformation
                const result = await transform(
                    this.selectedTransformation, 
                    this.inputText, 
                    this.options
                );
                
                this.outputText = result;
                this.addToHistory();
                
                // Track performance
                this.lastTransformTime = performance.now() - startTime;
                console.log(`Transformation completed in ${this.lastTransformTime.toFixed(2)}ms`);
                
            } catch (error) {
                console.error('Transformation error:', error);
                this.error = error.message || 'Transformation failed';
                this.outputText = '';
            } finally {
                this.isProcessing = false;
            }
        },
        
        /**
         * Add current state to history
         */
        addToHistory() {
            // Remove any future history if we're not at the end
            if (this.historyIndex < this.history.length - 1) {
                this.history = this.history.slice(0, this.historyIndex + 1);
            }
            
            // Add new entry
            this.history.push({
                input: this.inputText,
                output: this.outputText,
                transformation: this.selectedTransformation,
                options: { ...this.options },
                timestamp: Date.now()
            });
            
            // Limit history size
            if (this.history.length > this.maxHistorySize) {
                this.history.shift();
            } else {
                this.historyIndex++;
            }
        },
        
        /**
         * Undo last transformation
         */
        undo() {
            if (this.historyIndex > 0) {
                this.historyIndex--;
                this.restoreFromHistory();
            }
        },
        
        /**
         * Redo transformation
         */
        redo() {
            if (this.historyIndex < this.history.length - 1) {
                this.historyIndex++;
                this.restoreFromHistory();
            }
        },
        
        /**
         * Restore state from history
         */
        restoreFromHistory() {
            const entry = this.history[this.historyIndex];
            if (entry) {
                this.inputText = entry.input;
                this.outputText = entry.output;
                this.selectedTransformation = entry.transformation;
                this.options = { ...entry.options };
            }
        },
        
        /**
         * Copy output to clipboard
         */
        async copyToClipboard() {
            if (!this.outputText) return;
            
            try {
                await navigator.clipboard.writeText(this.outputText);
                this.showCopySuccess = true;
                setTimeout(() => {
                    this.showCopySuccess = false;
                }, 2000);
            } catch (error) {
                console.error('Copy failed:', error);
                this.error = 'Failed to copy to clipboard';
            }
        },
        
        /**
         * Paste from clipboard
         */
        async pasteFromClipboard() {
            try {
                const text = await navigator.clipboard.readText();
                this.inputText = text;
            } catch (error) {
                console.error('Paste failed:', error);
                this.error = 'Failed to paste from clipboard';
            }
        },
        
        /**
         * Clear all text
         */
        clearAll() {
            this.inputText = '';
            this.outputText = '';
            this.error = null;
        },
        
        /**
         * Swap input and output
         */
        swapTexts() {
            const temp = this.inputText;
            this.inputText = this.outputText;
            this.outputText = temp;
            this.transform();
        },
        
        /**
         * Download output as file
         */
        downloadOutput() {
            if (!this.outputText) return;
            
            const blob = new Blob([this.outputText], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${this.selectedTransformation}-${Date.now()}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        },
        
        /**
         * Load file into input
         */
        async loadFile(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            try {
                const text = await file.text();
                this.inputText = text;
            } catch (error) {
                console.error('File load failed:', error);
                this.error = 'Failed to load file';
            }
        },
        
        /**
         * Setup keyboard shortcuts
         */
        setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                // Ctrl/Cmd + Enter to transform
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    e.preventDefault();
                    this.transform();
                }
                
                // Ctrl/Cmd + Z for undo
                if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
                    e.preventDefault();
                    this.undo();
                }
                
                // Ctrl/Cmd + Shift + Z for redo
                if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'z') {
                    e.preventDefault();
                    this.redo();
                }
                
                // Ctrl/Cmd + C to copy output (when output is focused)
                if ((e.ctrlKey || e.metaKey) && e.key === 'c' && document.activeElement.id === 'output') {
                    e.preventDefault();
                    this.copyToClipboard();
                }
            });
        },
        
        /**
         * Get transformation info
         */
        getTransformationInfo() {
            const method = getMethod(this.selectedTransformation);
            if (method) {
                return {
                    name: method.name,
                    description: method.description,
                    category: method.category
                };
            }
            return null;
        },
        
        /**
         * Check if can undo
         */
        get canUndo() {
            return this.historyIndex > 0;
        },
        
        /**
         * Check if can redo
         */
        get canRedo() {
            return this.historyIndex < this.history.length - 1;
        },
        
        /**
         * Get character count
         */
        get inputCharCount() {
            return this.inputText ? this.inputText.length : 0;
        },
        
        /**
         * Get output character count
         */
        get outputCharCount() {
            return this.outputText ? this.outputText.length : 0;
        },
        
        /**
         * Get word count
         */
        get inputWordCount() {
            return this.inputText ? this.inputText.split(/\s+/).filter(w => w.length > 0).length : 0;
        },
        
        /**
         * Get output word count
         */
        get outputWordCount() {
            return this.outputText ? this.outputText.split(/\s+/).filter(w => w.length > 0).length : 0;
        }
    };
}

/**
 * Export as default for Alpine.js registration
 */
export default converterComponent;
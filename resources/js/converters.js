// Alpine.js converter components for replacing Livewire functionality
// This provides real-time text conversion without page reloads

document.addEventListener('alpine:init', () => {
    // Universal converter component
    Alpine.data('universalConverter', () => ({
        inputText: '',
        outputText: '',
        selectedTransformation: 'uppercase',
        transformations: {},
        isLoading: false,
        error: null,

        async init() {
            // Load available transformations
            try {
                const response = await fetch('/api/transformations');
                const data = await response.json();
                this.transformations = data.transformations;
            } catch (error) {
                console.error('Failed to load transformations:', error);
                this.transformations = {
                    'uppercase': 'UPPERCASE',
                    'lowercase': 'lowercase',
                    'title-case': 'Title Case',
                    'sentence-case': 'Sentence case',
                    'camel-case': 'camelCase',
                    'snake-case': 'snake_case',
                };
            }
        },

        async transform() {
            if (!this.inputText) {
                this.outputText = '';
                return;
            }

            this.isLoading = true;
            this.error = null;

            try {
                const response = await fetch('/api/transform', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        text: this.inputText,
                        transformation: this.selectedTransformation,
                    }),
                });

                const data = await response.json();
                
                if (data.success) {
                    this.outputText = data.output;
                } else {
                    this.error = data.error || 'Transformation failed';
                }
            } catch (error) {
                console.error('Transformation error:', error);
                this.error = 'Failed to transform text. Please try again.';
            } finally {
                this.isLoading = false;
            }
        },

        copyToClipboard() {
            if (this.outputText) {
                navigator.clipboard.writeText(this.outputText).then(() => {
                    // Show success message
                    this.showCopySuccess = true;
                    setTimeout(() => {
                        this.showCopySuccess = false;
                    }, 2000);
                });
            }
        },

        downloadResult() {
            if (this.outputText) {
                const blob = new Blob([this.outputText], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `converted-text-${Date.now()}.txt`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        },

        showCopySuccess: false,
    }));

    // Category converter component
    Alpine.data('categoryConverter', (category, tools) => ({
        inputText: '',
        outputText: '',
        selectedTool: Object.keys(tools)[0] || '',
        category: category,
        tools: tools,
        isLoading: false,
        error: null,

        async transform() {
            if (!this.inputText) {
                this.outputText = '';
                return;
            }

            this.isLoading = true;
            this.error = null;

            try {
                const response = await fetch('/api/transform', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        text: this.inputText,
                        transformation: this.selectedTool,
                    }),
                });

                const data = await response.json();
                
                if (data.success) {
                    this.outputText = data.output;
                } else {
                    this.error = data.error || 'Transformation failed';
                }
            } catch (error) {
                console.error('Transformation error:', error);
                this.error = 'Failed to transform text. Please try again.';
            } finally {
                this.isLoading = false;
            }
        },

        copyToClipboard() {
            if (this.outputText) {
                navigator.clipboard.writeText(this.outputText);
            }
        },

        showCopySuccess: false,
    }));

    // Individual tool converter component
    Alpine.data('toolConverter', (toolType) => ({
        inputText: '',
        outputText: '',
        transformation: toolType,
        isLoading: false,
        error: null,
        charCount: 0,
        wordCount: 0,

        init() {
            // Auto-transform on input change with debounce
            this.$watch('inputText', () => {
                this.updateCounts();
                this.debouncedTransform();
            });
        },

        updateCounts() {
            this.charCount = this.inputText.length;
            this.wordCount = this.inputText.trim() ? this.inputText.trim().split(/\s+/).length : 0;
        },

        debouncedTransform: Alpine.debounce(function() {
            this.transform();
        }, 300),

        async transform() {
            if (!this.inputText) {
                this.outputText = '';
                return;
            }

            this.isLoading = true;
            this.error = null;

            try {
                const response = await fetch('/api/transform', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        text: this.inputText,
                        transformation: this.transformation,
                    }),
                });

                const data = await response.json();
                
                if (data.success) {
                    this.outputText = data.output;
                } else {
                    this.error = data.error || 'Transformation failed';
                }
            } catch (error) {
                console.error('Transformation error:', error);
                this.error = 'Failed to transform text. Please try again.';
            } finally {
                this.isLoading = false;
            }
        },

        copyToClipboard() {
            if (this.outputText) {
                navigator.clipboard.writeText(this.outputText).then(() => {
                    this.showCopySuccess = true;
                    setTimeout(() => {
                        this.showCopySuccess = false;
                    }, 2000);
                });
            }
        },

        downloadResult() {
            if (this.outputText) {
                const blob = new Blob([this.outputText], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `${this.transformation}-${Date.now()}.txt`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        },

        clearText() {
            this.inputText = '';
            this.outputText = '';
        },

        showCopySuccess: false,
    }));
});

// Utility function for Alpine debounce if not available
if (!window.Alpine || !window.Alpine.debounce) {
    window.Alpine = window.Alpine || {};
    window.Alpine.debounce = function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };
}
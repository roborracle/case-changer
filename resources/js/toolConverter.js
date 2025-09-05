// Tool Converter JavaScript Controller
// Handles all text transformation functionality for individual tool pages

window.toolConverter = function() {
    return {
        input: '',
        output: '',
        realTime: false,
        processing: false,
        transformation: '',
        charCount: 0,
        processingTime: 0,

        init() {
            // Get transformation type from data attribute
            this.transformation = this.$el.getAttribute('data-transformation') || '';
            
            // Set up event listeners
            this.setupEventListeners();
        },

        setupEventListeners() {
            const inputElement = this.$el.querySelector('[data-text-converter-target="input"]');
            const realTimeToggle = this.$el.querySelector('[data-text-converter-target="realTimeToggle"]');
            
            if (inputElement) {
                inputElement.addEventListener('input', (e) => {
                    this.input = e.target.value;
                    this.updateCharCount();
                    if (this.realTime) {
                        this.transform();
                    }
                });
            }

            if (realTimeToggle) {
                realTimeToggle.addEventListener('change', (e) => {
                    this.realTime = e.target.checked;
                    if (this.realTime && this.input) {
                        this.transform();
                    }
                });
            }

            // Transform button
            const transformBtn = this.$el.querySelector('[data-action*="transform"]');
            if (transformBtn) {
                transformBtn.addEventListener('click', () => this.transform());
            }

            // Clear button
            const clearBtn = this.$el.querySelector('[data-action*="clearInput"]');
            if (clearBtn) {
                clearBtn.addEventListener('click', () => this.clearInput());
            }

            // Copy button
            const copyBtn = this.$el.querySelector('[data-action*="copyToClipboard"]');
            if (copyBtn) {
                copyBtn.addEventListener('click', () => this.copyToClipboard());
            }

            // Download button
            const downloadBtn = this.$el.querySelector('[data-action*="downloadResult"]');
            if (downloadBtn) {
                downloadBtn.addEventListener('click', () => this.downloadResult());
            }
        },

        updateCharCount() {
            this.charCount = this.input.length;
            const charCountElement = this.$el.querySelector('[data-text-converter-target="charCount"]');
            if (charCountElement) {
                charCountElement.textContent = this.charCount;
            }
        },

        clearInput() {
            this.input = '';
            this.output = '';
            const inputElement = this.$el.querySelector('[data-text-converter-target="input"]');
            const outputElement = this.$el.querySelector('[data-text-converter-target="output"]');
            
            if (inputElement) inputElement.value = '';
            if (outputElement) outputElement.value = '';
            
            this.updateCharCount();
        },

        async transform() {
            if (!this.input || this.processing) return;
            
            this.processing = true;
            const startTime = performance.now();
            
            try {
                // Show loading state
                const outputElement = this.$el.querySelector('[data-text-converter-target="output"]');
                if (outputElement) {
                    outputElement.value = 'Processing...';
                }

                // Make API call
                const response = await fetch('/api/transform', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        text: this.input,
                        transformation: this.transformation
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    this.output = data.output;
                    if (outputElement) {
                        outputElement.value = this.output;
                    }
                } else {
                    this.output = data.error || 'Transformation failed';
                    if (outputElement) {
                        outputElement.value = this.output;
                    }
                }

                // Calculate and show processing time
                this.processingTime = Math.round(performance.now() - startTime);
                this.showProcessingTime();
                
            } catch (error) {
                console.error('Transformation error:', error);
                this.output = 'Error: Unable to transform text. Please try again.';
                const outputElement = this.$el.querySelector('[data-text-converter-target="output"]');
                if (outputElement) {
                    outputElement.value = this.output;
                }
            } finally {
                this.processing = false;
            }
        },

        showProcessingTime() {
            const timeElement = this.$el.querySelector('[data-text-converter-target="processingTime"]');
            if (timeElement) {
                timeElement.classList.remove('hidden');
                const timeSpan = timeElement.querySelector('span.font-medium');
                if (timeSpan) {
                    timeSpan.textContent = `${this.processingTime}ms`;
                }
            }
        },

        async copyToClipboard() {
            if (!this.output) return;
            
            try {
                await navigator.clipboard.writeText(this.output);
                
                // Update button text temporarily
                const copyBtn = this.$el.querySelector('[data-text-converter-target="copyButton"]');
                if (copyBtn) {
                    const originalText = copyBtn.textContent;
                    copyBtn.textContent = 'Copied!';
                    copyBtn.classList.add('bg-green-600');
                    copyBtn.classList.remove('bg-blue-600');
                    
                    setTimeout(() => {
                        copyBtn.textContent = originalText;
                        copyBtn.classList.remove('bg-green-600');
                        copyBtn.classList.add('bg-blue-600');
                    }, 2000);
                }
            } catch (error) {
                console.error('Failed to copy:', error);
            }
        },

        downloadResult() {
            if (!this.output) return;
            
            const blob = new Blob([this.output], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${this.transformation}-output.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        },

        // Helper function for Alpine.js compatibility
        toggleRealTime() {
            this.realTime = !this.realTime;
            if (this.realTime && this.input) {
                this.transform();
            }
        },

        updatePreview() {
            if (this.realTime) {
                this.transform();
            }
        }
    };
};

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all tool converters on the page
    document.querySelectorAll('[x-data="toolConverter"]').forEach(element => {
        // Alpine.js will handle the initialization if it's loaded
        // Otherwise, we can initialize manually
        if (!window.Alpine) {
            const converter = toolConverter.call({ $el: element });
            converter.init();
        }
    });
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = toolConverter;
}
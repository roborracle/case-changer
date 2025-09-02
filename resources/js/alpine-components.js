/**
 * Alpine.js Components - CSP-Safe Registration
 * 
 * This pattern avoids eval() by pre-registering all components
 * and using simple string references instead of function calls
 */

// Register all components BEFORE Alpine starts
document.addEventListener('alpine:init', () => {
    
    // Navigation Dropdown Component
    Alpine.data('navigationDropdown', () => ({
        open: false,
        
        toggle() {
            this.open = !this.open;
        },
        
        close() {
            this.open = false;
        },
        
        // Close on click outside
        clickOutside() {
            this.close();
        },
        
        // Close on escape key
        escapeKey() {
            this.close();
        }
    }));
    
    // Mobile Menu Component
    Alpine.data('mobileMenu', () => ({
        isOpen: false,
        
        init() {
            // Watch for screen size changes
            this.handleResize();
            window.addEventListener('resize', () => this.handleResize());
        },
        
        toggle() {
            this.isOpen = !this.isOpen;
            document.body.style.overflow = this.isOpen ? 'hidden' : '';
        },
        
        close() {
            this.isOpen = false;
            document.body.style.overflow = '';
        },
        
        handleResize() {
            if (window.innerWidth >= 768) {
                this.close();
            }
        }
    }));
    
    // Theme Toggle Component
    Alpine.data('themeToggle', () => ({
        theme: Alpine.$persist('system').as('case-changer-theme'),
        showMenu: false,
        
        init() {
            this.applyTheme();
            
            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (this.theme === 'system') {
                    this.applyTheme();
                }
            });
        },
        
        setTheme(newTheme) {
            this.theme = newTheme;
            this.showMenu = false;
            this.applyTheme();
        },
        
        applyTheme() {
            const root = document.documentElement;
            root.classList.remove('light', 'dark');
            
            if (this.theme === 'dark' || 
                (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                root.classList.add('dark');
            } else if (this.theme === 'light') {
                root.classList.add('light');
            }
        },
        
        getIcon() {
            if (this.theme === 'light') return 'sun';
            if (this.theme === 'dark') return 'moon';
            return 'system';
        },
        
        toggleMenu() {
            this.showMenu = !this.showMenu;
        }
    }));
    
    // Search Modal Component
    Alpine.data('searchModal', () => ({
        open: false,
        query: '',
        results: [],
        loading: false,
        
        showModal() {
            this.open = true;
            document.body.style.overflow = 'hidden';
            this.$nextTick(() => {
                this.$refs.searchInput?.focus();
            });
        },
        
        hideModal() {
            this.open = false;
            this.query = '';
            this.results = [];
            document.body.style.overflow = '';
        },
        
        async search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }
            
            this.loading = true;
            
            // Simulate search - replace with actual search endpoint
            await new Promise(resolve => setTimeout(resolve, 300));
            
            // Mock results - replace with actual search
            this.results = this.getMockResults(this.query);
            this.loading = false;
        },
        
        getMockResults(query) {
            const tools = [
                'UPPERCASE', 'lowercase', 'Title Case', 'camelCase',
                'snake_case', 'kebab-case', 'CONSTANT_CASE'
            ];
            
            return tools
                .filter(tool => tool.toLowerCase().includes(query.toLowerCase()))
                .map(tool => ({
                    name: tool,
                    url: `/tools/${tool.toLowerCase().replace(/[\s_]/g, '-')}`
                }));
        }
    }));
    
    // Copy to Clipboard Component
    Alpine.data('copyToClipboard', () => ({
        copied: false,
        
        async copy(text) {
            try {
                await navigator.clipboard.writeText(text);
                this.copied = true;
                
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
                
                return true;
            } catch (err) {
                console.error('Failed to copy:', err);
                return false;
            }
        }
    }));
    
    // Text Converter Component
    Alpine.data('textConverter', () => ({
        input: '',
        output: '',
        selectedTool: 'uppercase',
        processing: false,
        
        init() {
            // Auto-convert on input change
            this.$watch('input', () => this.convert());
            this.$watch('selectedTool', () => this.convert());
        },
        
        async convert() {
            if (!this.input) {
                this.output = '';
                return;
            }
            
            this.processing = true;
            
            // Apply transformation based on selected tool
            this.output = this.applyTransformation(this.input, this.selectedTool);
            
            this.processing = false;
        },
        
        applyTransformation(text, tool) {
            const transformations = {
                'uppercase': text => text.toUpperCase(),
                'lowercase': text => text.toLowerCase(),
                'title-case': text => text.replace(/\w\S*/g, txt => 
                    txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
                ),
                'camel-case': text => text.replace(/(?:^\w|[A-Z]|\b\w)/g, (word, index) => 
                    index === 0 ? word.toLowerCase() : word.toUpperCase()
                ).replace(/\s+/g, ''),
                'snake-case': text => text.toLowerCase().replace(/\s+/g, '_'),
                'kebab-case': text => text.toLowerCase().replace(/\s+/g, '-'),
                'constant-case': text => text.toUpperCase().replace(/\s+/g, '_'),
                'sentence-case': text => text.charAt(0).toUpperCase() + text.slice(1).toLowerCase(),
                'reverse': text => text.split('').reverse().join(''),
                'capitalize': text => text.replace(/\b\w/g, l => l.toUpperCase())
            };
            
            const transform = transformations[tool] || transformations['uppercase'];
            return transform(text);
        },
        
        async copyOutput() {
            if (!this.output) return;
            
            try {
                await navigator.clipboard.writeText(this.output);
                // Trigger copied state in UI
                this.$dispatch('copied');
            } catch (err) {
                console.error('Copy failed:', err);
            }
        },
        
        clearAll() {
            this.input = '';
            this.output = '';
        }
    }));
    
    // Lazy Loading Component
    Alpine.data('lazyLoading', () => ({
        loaded: false,
        
        init() {
            // Use Intersection Observer for lazy loading
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.loaded = true;
                        observer.disconnect();
                    }
                });
            }, {
                threshold: 0.1
            });
            
            observer.observe(this.$el);
        }
    }));
    
    // Category Accordion Component
    Alpine.data('categoryAccordion', () => ({
        expanded: false,
        
        toggle() {
            this.expanded = !this.expanded;
        }
    }));
    
    // Tool Card Component
    Alpine.data('toolCard', () => ({
        hovered: false,
        selected: false,
        
        select() {
            this.selected = !this.selected;
            this.$dispatch('tool-selected', { 
                selected: this.selected,
                tool: this.$el.dataset.tool 
            });
        }
    }));
});

// Export for use in app.js if needed
export default {};
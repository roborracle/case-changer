/**
 * Navigation Components for Case Changer Pro
 * Alpine.js data components for interactive navigation
 */

// Navigation Store - Global state management
document.addEventListener('alpine:init', () => {
    Alpine.store('navigation', {
        mobileMenuOpen: false,
        searchModalOpen: false,
        activeDropdown: null,
        theme: localStorage.getItem('theme') || 'system',
        
        toggleMobileMenu() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
            document.body.style.overflow = this.mobileMenuOpen ? 'hidden' : '';
        },
        
        closeMobileMenu() {
            this.mobileMenuOpen = false;
            document.body.style.overflow = '';
        },
        
        toggleDropdown(name) {
            this.activeDropdown = this.activeDropdown === name ? null : name;
        },
        
        closeDropdowns() {
            this.activeDropdown = null;
        },
        
        toggleSearchModal() {
            this.searchModalOpen = !this.searchModalOpen;
            document.body.style.overflow = this.searchModalOpen ? 'hidden' : '';
        },
        
        closeSearchModal() {
            this.searchModalOpen = false;
            document.body.style.overflow = '';
        },
        
        setTheme(newTheme) {
            this.theme = newTheme;
            localStorage.setItem('theme', newTheme);
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
        
        init() {
            this.applyTheme();
            
            // Watch for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (this.theme === 'system') {
                    this.applyTheme();
                }
            });
            
            // Close dropdowns on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (this.searchModalOpen) {
                        this.closeSearchModal();
                    } else if (this.mobileMenuOpen) {
                        this.closeMobileMenu();
                    } else if (this.activeDropdown) {
                        this.closeDropdowns();
                    }
                }
            });
        }
    });
});

// Navigation Dropdown Component
export function navigationDropdown() {
    return {
        open: false,
        
        toggle() {
            this.open = !this.open;
        },
        
        close() {
            this.open = false;
        },
        
        init() {
            // Close on click outside
            document.addEventListener('click', (e) => {
                if (!this.$el.contains(e.target)) {
                    this.close();
                }
            });
        }
    };
}

// Mobile Menu Component
export function mobileMenu() {
    return {
        open: false,
        expandedCategories: [],
        
        toggle() {
            this.open = !this.open;
            document.body.style.overflow = this.open ? 'hidden' : '';
        },
        
        close() {
            this.open = false;
            document.body.style.overflow = '';
        },
        
        toggleCategory(category) {
            const index = this.expandedCategories.indexOf(category);
            if (index > -1) {
                this.expandedCategories.splice(index, 1);
            } else {
                this.expandedCategories.push(category);
            }
        },
        
        isExpanded(category) {
            return this.expandedCategories.includes(category);
        }
    };
}

// Search Modal Component
export function searchModal() {
    return {
        open: false,
        query: '',
        results: [],
        loading: false,
        selectedIndex: -1,
        
        toggle() {
            this.open = !this.open;
            if (this.open) {
                document.body.style.overflow = 'hidden';
                this.$nextTick(() => {
                    this.$refs.searchInput?.focus();
                });
            } else {
                document.body.style.overflow = '';
            }
        },
        
        close() {
            this.open = false;
            this.query = '';
            this.results = [];
            this.selectedIndex = -1;
            document.body.style.overflow = '';
        },
        
        async search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }
            
            this.loading = true;
            
            // Simulate search with static data - replace with API call
            const allTools = [
                // Case Conversions
                { name: 'UPPERCASE', category: 'Case Conversions', url: '/conversions/case-conversions/uppercase' },
                { name: 'lowercase', category: 'Case Conversions', url: '/conversions/case-conversions/lowercase' },
                { name: 'Title Case', category: 'Case Conversions', url: '/conversions/case-conversions/title-case' },
                { name: 'Sentence case', category: 'Case Conversions', url: '/conversions/case-conversions/sentence-case' },
                { name: 'Capitalize Words', category: 'Case Conversions', url: '/conversions/case-conversions/capitalize-words' },
                { name: 'aLtErNaTiNg CaSe', category: 'Case Conversions', url: '/conversions/case-conversions/alternating-case' },
                { name: 'iNVERSE cASE', category: 'Case Conversions', url: '/conversions/case-conversions/inverse-case' },
                // Developer Formats
                { name: 'camelCase', category: 'Developer Formats', url: '/conversions/developer-formats/camel-case' },
                { name: 'PascalCase', category: 'Developer Formats', url: '/conversions/developer-formats/pascal-case' },
                { name: 'snake_case', category: 'Developer Formats', url: '/conversions/developer-formats/snake-case' },
                { name: 'CONSTANT_CASE', category: 'Developer Formats', url: '/conversions/developer-formats/constant-case' },
                { name: 'kebab-case', category: 'Developer Formats', url: '/conversions/developer-formats/kebab-case' },
                { name: 'dot.case', category: 'Developer Formats', url: '/conversions/developer-formats/dot-case' },
                { name: 'path/case', category: 'Developer Formats', url: '/conversions/developer-formats/path-case' },
                // Journalistic Styles
                { name: 'AP Style', category: 'Journalistic Styles', url: '/conversions/journalistic-styles/ap-style' },
                { name: 'NY Times Style', category: 'Journalistic Styles', url: '/conversions/journalistic-styles/nyt-style' },
                { name: 'Chicago Style', category: 'Journalistic Styles', url: '/conversions/journalistic-styles/chicago-style' },
                // Academic Styles
                { name: 'APA Style', category: 'Academic Styles', url: '/conversions/academic-styles/apa-style' },
                { name: 'MLA Style', category: 'Academic Styles', url: '/conversions/academic-styles/mla-style' },
                // Creative Formats
                { name: 'Reverse', category: 'Creative Formats', url: '/conversions/creative-formats/reverse' },
                { name: 'Aesthetic', category: 'Creative Formats', url: '/conversions/creative-formats/aesthetic' },
                { name: 'Sarcasm Case', category: 'Creative Formats', url: '/conversions/creative-formats/sarcasm' },
            ];
            
            // Filter results
            setTimeout(() => {
                const searchTerm = this.query.toLowerCase();
                this.results = allTools.filter(tool => 
                    tool.name.toLowerCase().includes(searchTerm) ||
                    tool.category.toLowerCase().includes(searchTerm)
                ).slice(0, 8); // Limit to 8 results
                
                this.loading = false;
                this.selectedIndex = -1;
            }, 300);
        },
        
        selectResult(index) {
            if (this.results[index]) {
                window.location.href = this.results[index].url;
            }
        },
        
        navigateResults(direction) {
            if (direction === 'down') {
                this.selectedIndex = Math.min(this.results.length - 1, this.selectedIndex + 1);
            } else {
                this.selectedIndex = Math.max(-1, this.selectedIndex - 1);
            }
        },
        
        handleKeydown(event) {
            switch(event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    this.navigateResults('down');
                    break;
                case 'ArrowUp':
                    event.preventDefault();
                    this.navigateResults('up');
                    break;
                case 'Enter':
                    event.preventDefault();
                    if (this.selectedIndex >= 0) {
                        this.selectResult(this.selectedIndex);
                    }
                    break;
                case 'Escape':
                    this.close();
                    break;
            }
        }
    };
}

// Theme Toggle Component
export function themeToggle() {
    return {
        theme: localStorage.getItem('theme') || 'system',
        showMenu: false,
        
        init() {
            this.applyTheme();
            
            // Watch for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (this.theme === 'system') {
                    this.applyTheme();
                }
            });
        },
        
        setTheme(newTheme) {
            this.theme = newTheme;
            localStorage.setItem('theme', newTheme);
            this.applyTheme();
            this.showMenu = false;
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
        
        toggleMenu() {
            this.showMenu = !this.showMenu;
        },
        
        getIcon() {
            if (this.theme === 'light') {
                return 'sun';
            } else if (this.theme === 'dark') {
                return 'moon';
            } else {
                return 'system';
            }
        }
    };
}

// Copy to Clipboard Component
export function copyToClipboard() {
    return {
        copied: false,
        
        async copy(text, event) {
            const button = event.target.closest('button');
            
            try {
                await navigator.clipboard.writeText(text);
                this.handleSuccess(button);
            } catch (err) {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                
                this.handleSuccess(button);
            }
        },
        
        handleSuccess(button) {
            this.copied = true;
            
            if (button) {
                const originalText = button.innerHTML;
                button.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg> Copied!';
                button.classList.add('bg-green-500', 'text-white', 'border-green-500');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-500', 'text-white', 'border-green-500');
                    this.copied = false;
                }, 2000);
            }
        }
    };
}

// Initialize navigation store when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if (window.Alpine && Alpine.store('navigation')) {
            Alpine.store('navigation').init();
        }
    });
} else {
    if (window.Alpine && Alpine.store('navigation')) {
        Alpine.store('navigation').init();
    }
}
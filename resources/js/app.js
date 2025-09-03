import './bootstrap';
import Alpine from '@alpinejs/csp';
import { transform, getMethod, getAllMethods, getGroupedMethods } from './transformations/index.js';
import converterComponent from './alpine-converter.js';

// Register the new comprehensive converter component
Alpine.data('converter', converterComponent);

// Define the universal converter component BEFORE Alpine starts
Alpine.data('universalConverter', () => ({
    inputText: '',
    outputText: '',
    selectedTransformation: 'upper-case',
    transformations: {},
    isLoading: false,
    error: null,
    showCopySuccess: false,

    init() {
        console.log('universalConverter initialized');
        // Load transformations immediately
        this.loadTransformations();
    },

    async loadTransformations() {
        console.log('Loading transformations...');
        try {
            const response = await fetch('/api/transformations');
            const data = await response.json();
            this.transformations = data.transformations || {};
            console.log('Loaded', Object.keys(this.transformations).length, 'transformations');
        } catch (error) {
            console.error('Failed to load transformations:', error);
            // Use fallback transformations
            this.transformations = {
                'upper-case': 'UPPERCASE',
                'lower-case': 'lowercase',
                'title-case': 'Title Case',
                'sentence-case': 'Sentence case',
                'camel-case': 'camelCase',
                'snake-case': 'snake_case',
                'kebab-case': 'kebab-case',
                'constant-case': 'CONSTANT_CASE',
                'pascal-case': 'PascalCase',
                'dot-case': 'dot.case'
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
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            const response = await fetch('/api/transform', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    text: this.inputText,
                    transformation: this.selectedTransformation
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.outputText = data.output;
            } else {
                this.error = data.error || 'Transformation failed';
            }
        } catch (error) {
            console.error('Transform error:', error);
            this.error = 'Failed to transform text';
        } finally {
            this.isLoading = false;
        }
    },

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
        }
    },

    downloadResult() {
        if (!this.outputText) return;
        
        const blob = new Blob([this.outputText], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `converted-${Date.now()}.txt`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }
}));

// Theme toggle component
Alpine.data('themeToggle', () => ({
    isDark: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    
    // Computed properties for CSP build
    get isLight() {
        return !this.isDark;
    },
    
    get themeLabel() {
        return this.isDark ? 'Dark Mode' : 'Light Mode';
    },
    
    toggleTheme() {
        this.isDark = !this.isDark;
        const theme = this.isDark ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
        document.documentElement.classList.toggle('dark', this.isDark);
    },
    
    init() {
        document.documentElement.classList.toggle('dark', this.isDark);
    }
}));

// Dropdown component for navigation
Alpine.data('dropdown', () => ({
    open: false,
    
    // Computed property for rotate class
    get rotateClass() {
        return this.open ? 'rotate-180' : '';
    },
    
    toggle() {
        this.open = !this.open;
    },
    
    close() {
        this.open = false;
    }
}));

// Mobile menu component
Alpine.data('mobileMenu', () => ({
    open: false,
    
    // Computed properties for icon visibility
    get menuIconClass() {
        return this.open ? 'hidden' : 'block';
    },
    
    get closeIconClass() {
        return this.open ? 'block' : 'hidden';
    },
    
    toggle() {
        this.open = !this.open;
        this.$dispatch('mobile-menu-toggle', { open: this.open });
    }
}));

// Mobile menu panel component (listens to toggle events)
Alpine.data('mobileMenuPanel', () => ({
    open: false,
    
    init() {
        // Listen for toggle events from the mobile menu button
        this.$el.addEventListener('mobile-menu-toggle', (event) => {
            this.open = event.detail.open;
        });
    }
}));

// Search component for category page
Alpine.data('categorySearch', () => ({
    query: '',
    
    filterTools() {
        const cards = document.querySelectorAll('[data-tool-name]');
        cards.forEach(card => {
            const name = card.dataset.toolName.toLowerCase();
            card.style.display = name.includes(this.query.toLowerCase()) ? '' : 'none';
        });
    }
}));

// Contact form component
Alpine.data('contactForm', () => ({
    formData: {
        name: '',
        email: '',
        subject: '',
        message: ''
    },
    errors: {},
    isSubmitting: false,
    showSuccess: false,
    showError: false,
    
    validateField(field) {
        this.errors[field] = '';
        
        if (!this.formData[field]) {
            this.errors[field] = 'This field is required';
            return false;
        }
        
        if (field === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(this.formData.email)) {
                this.errors.email = 'Please enter a valid email address';
                return false;
            }
        }
        
        if (field === 'message' && this.formData.message.length < 10) {
            this.errors.message = 'Message must be at least 10 characters';
            return false;
        }
        
        return true;
    },
    
    async submitForm() {
        // Validate all fields
        let isValid = true;
        for (const field in this.formData) {
            if (!this.validateField(field)) {
                isValid = false;
            }
        }
        
        if (!isValid) return;
        
        this.isSubmitting = true;
        this.showSuccess = false;
        this.showError = false;
        
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            const response = await fetch('/api/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(this.formData)
            });
            
            if (response.ok) {
                this.showSuccess = true;
                this.formData = { name: '', email: '', subject: '', message: '' };
                this.errors = {};
            } else {
                this.showError = true;
            }
        } catch (error) {
            console.error('Contact form error:', error);
            this.showError = true;
        } finally {
            this.isSubmitting = false;
        }
    }
}));

// FAQ accordion component  
Alpine.data('faqAccordion', () => ({
    activeCategory: 0,
    openItems: [],
    categories: [
        {
            name: 'General',
            faqs: [
                {
                    question: 'What is Case Changer Pro?',
                    answer: 'Case Changer Pro is a comprehensive text transformation toolkit with 210+ professional tools for converting text between different formats, cases, and styles. It works entirely in your browser for maximum privacy and speed.'
                },
                {
                    question: 'Is Case Changer Pro free to use?',
                    answer: 'Yes! Case Changer Pro is completely free to use with no limitations. All 210+ tools are available without registration, payment, or usage limits.'
                },
                {
                    question: 'Do I need to create an account?',
                    answer: 'No account is required. You can use all features immediately without signing up. Just visit the site and start transforming your text.'
                }
            ]
        },
        {
            name: 'Privacy & Security',
            faqs: [
                {
                    question: 'Is my text data secure?',
                    answer: 'Absolutely! All text transformations happen locally in your browser using JavaScript. Your text never leaves your device and is never sent to our servers. We have no way to see or store your data.'
                },
                {
                    question: 'Do you track or store my conversions?',
                    answer: 'No. Since all processing happens in your browser, we cannot and do not track, store, or have access to any text you convert. Your privacy is guaranteed by design.'
                },
                {
                    question: 'Can I use this for sensitive data?',
                    answer: 'Yes. Because everything runs locally in your browser, it\'s safe to use for any type of text, including sensitive or confidential information. Your data never leaves your device.'
                }
            ]
        },
        {
            name: 'Features',
            faqs: [
                {
                    question: 'How many transformation tools are available?',
                    answer: 'We offer 210+ text transformation tools across 18 categories including case conversions, developer formats, academic styles, creative text effects, and specialized utilities.'
                },
                {
                    question: 'Can I process large amounts of text?',
                    answer: 'Yes! Our tools can handle text of any length. Since processing happens in your browser, the only limitation is your device\'s memory, which is typically more than sufficient for even very large documents.'
                },
                {
                    question: 'Do the tools work offline?',
                    answer: 'Once the page is loaded, many tools work offline since they run entirely in your browser. However, you need an internet connection to initially load the website.'
                }
            ]
        },
        {
            name: 'Technical',
            faqs: [
                {
                    question: 'What browsers are supported?',
                    answer: 'Case Changer Pro works on all modern browsers including Chrome, Firefox, Safari, Edge, and Opera. We recommend using the latest version of your browser for the best experience.'
                },
                {
                    question: 'Does it work on mobile devices?',
                    answer: 'Yes! Our site is fully responsive and works perfectly on smartphones and tablets. All tools are optimized for touch interfaces and mobile screens.'
                },
                {
                    question: 'Is there an API available?',
                    answer: 'Currently, we don\'t offer a public API since all transformations run client-side. However, you can bookmark specific tools for quick access or integrate them into your workflow using browser automation tools.'
                }
            ]
        },
        {
            name: 'Usage',
            faqs: [
                {
                    question: 'How do I use the universal converter?',
                    answer: 'Simply paste or type your text in the input field, select the desired transformation from the dropdown menu, and your converted text appears instantly in the output field. You can then copy it or download it as a file.'
                },
                {
                    question: 'Can I convert multiple texts at once?',
                    answer: 'Each tool processes one text at a time, but you can quickly switch between transformations using the same input text. For batch processing, you can open multiple browser tabs.'
                },
                {
                    question: 'How do I report a bug or suggest a feature?',
                    answer: 'We welcome feedback! Use our <a href="/pages/contact" class="text-blue-600 dark:text-blue-400 hover:underline">contact form</a> to report bugs or suggest new features. We actively develop new tools based on user feedback.'
                }
            ]
        }
    ],
    
    get currentCategoryFaqs() {
        return this.categories[this.activeCategory]?.faqs || [];
    },
    
    toggleItem(index) {
        const itemIndex = this.openItems.indexOf(index);
        if (itemIndex > -1) {
            this.openItems.splice(itemIndex, 1);
        } else {
            this.openItems.push(index);
        }
    },
    
    isOpen(index) {
        return this.openItems.includes(index);
    }
}));

// Newsletter form component
Alpine.data('newsletterForm', () => ({
    email: '',
    
    submitForm() {
        console.log('Newsletter signup:', this.email);
        // Add actual submission logic here
    }
}));

// Admin sidebar component
Alpine.data('adminLayout', () => ({
    sidebarOpen: false,
    
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
    }
}));

// Admin dropdown component
Alpine.data('adminDropdown', () => ({
    open: false,
    
    toggle() {
        this.open = !this.open;
    },
    
    close() {
        this.open = false;
    }
}));

// Improved converter component for home page
Alpine.data('improvedConverter', () => ({
    inputText: '',
    copiedFormat: null,
    previews: [
        { key: 'upper-case', label: 'UPPERCASE', output: '' },
        { key: 'lower-case', label: 'lowercase', output: '' },
        { key: 'title-case', label: 'Title Case', output: '' },
        { key: 'sentence-case', label: 'Sentence', output: '' },
        { key: 'camel-case', label: 'camelCase', output: '' },
        { key: 'pascal-case', label: 'PascalCase', output: '' },
        { key: 'snake-case', label: 'snake_case', output: '' },
        { key: 'kebab-case', label: 'kebab-case', output: '' },
        { key: 'constant-case', label: 'CONSTANT', output: '' },
        { key: 'dot-case', label: 'dot.case', output: '' },
        { key: 'path-case', label: 'path/case', output: '' },
        { key: 'reverse', label: 'Reverse', output: '' }
    ],
    
    // Computed properties for CSP build
    get hasInput() {
        return this.inputText && this.inputText.length > 0;
    },
    
    get noInput() {
        return !this.inputText || this.inputText.length === 0;
    },
    
    get characterCount() {
        return this.inputText ? this.inputText.length : 0;
    },
    
    get characterCountText() {
        return this.characterCount + ' characters';
    },
    
    init() {
        console.log('improvedConverter initialized');
        // Listen for quick convert events
        window.addEventListener('quick-convert', (e) => {
            if (e.detail && e.detail.transformation) {
                this.quickTransform(e.detail.transformation);
            }
        });
    },
    
    async generateAllPreviews() {
        if (!this.inputText) {
            this.previews.forEach(preview => {
                preview.output = '';
            });
            return;
        }
        
        // Transform all previews in parallel for better performance
        await Promise.all(this.previews.map(async (preview) => {
            preview.output = await this.transformText(this.inputText, preview.key);
        }));
    },
    
    async transformText(text, transformation) {
        if (!text) return '';
        
        try {
            // Try to use the new transformation system
            const method = getMethod(transformation);
            if (method) {
                return await method.transform(text);
            }
        } catch (error) {
            console.warn(`Transformation ${transformation} failed, using fallback`, error);
        }
        
        // Fallback to basic transformations
        switch (transformation) {
            case 'upper-case':
                return text.toUpperCase();
            case 'lower-case':
                return text.toLowerCase();
            case 'title-case':
                return text.replace(/\w\S*/g, (txt) => 
                    txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
                );
            case 'sentence-case':
                return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
            case 'camel-case':
                return text.replace(/(?:^\w|[A-Z]|\b\w)/g, (word, index) => 
                    index === 0 ? word.toLowerCase() : word.toUpperCase()
                ).replace(/\s+/g, '');
            case 'pascal-case':
                return text.replace(/(?:^\w|[A-Z]|\b\w)/g, (word) => 
                    word.toUpperCase()
                ).replace(/\s+/g, '');
            case 'snake-case':
                return text.toLowerCase().replace(/\s+/g, '_');
            case 'kebab-case':
                return text.toLowerCase().replace(/\s+/g, '-');
            case 'constant-case':
                return text.toUpperCase().replace(/\s+/g, '_');
            case 'dot-case':
                return text.toLowerCase().replace(/\s+/g, '.');
            case 'path-case':
                return text.toLowerCase().replace(/\s+/g, '/');
            case 'reverse':
                return text.split('').reverse().join('');
            default:
                return text;
        }
    },
    
    async copyToClipboard(text, format) {
        if (!text) return;
        
        try {
            await navigator.clipboard.writeText(text);
            this.copiedFormat = format;
            setTimeout(() => {
                this.copiedFormat = null;
            }, 2000);
        } catch (error) {
            console.error('Copy failed:', error);
        }
    },
    
    isFormatCopied(format) {
        return this.copiedFormat === format;
    },
    
    shouldShowCopyButton(format) {
        return !this.copiedFormat || this.copiedFormat !== format;
    },
    
    getPreviewOutput(preview) {
        return preview && preview.output ? preview.output : '...';
    },
    
    isPreviewDisabled(preview) {
        return !preview || !preview.output;
    },
    
    async pasteFromClipboard() {
        try {
            const text = await navigator.clipboard.readText();
            this.inputText = text;
            this.generateAllPreviews();
        } catch (error) {
            console.error('Paste failed:', error);
        }
    },
    
    clearText() {
        this.inputText = '';
        this.generateAllPreviews();
    },
    
    loadExample() {
        this.inputText = 'Hello World - This is a Sample Text';
        this.generateAllPreviews();
    },
    
    quickTransform(transformation) {
        if (!this.inputText) {
            this.inputText = 'Hello World - This is a Sample Text';
        }
        this.generateAllPreviews();
        
        // Find and copy the specific transformation
        const preview = this.previews.find(p => p.key === transformation);
        if (preview && preview.output) {
            this.copyToClipboard(preview.output, preview.key);
        }
    }
}));

// Countdown timer component for maintenance page
Alpine.data('countdownTimer', (retryAfter) => ({
    retryAfter: retryAfter || 60,
    minutes: '00',
    seconds: '00',
    interval: null,
    
    init() {
        this.startCountdown();
    },
    
    startCountdown() {
        const updateTimer = () => {
            if (this.retryAfter <= 0) {
                clearInterval(this.interval);
                window.location.reload();
                return;
            }
            
            const mins = Math.floor(this.retryAfter / 60);
            const secs = this.retryAfter % 60;
            
            this.minutes = String(mins).padStart(2, '0');
            this.seconds = String(secs).padStart(2, '0');
            
            this.retryAfter--;
        };
        
        updateTimer();
        this.interval = setInterval(updateTimer, 1000);
    },
    
    destroy() {
        if (this.interval) {
            clearInterval(this.interval);
        }
    }
}));

// Admin-specific Alpine.js stores
Alpine.store('admin', {
    notifications: [],
    addNotification(notification) {
        this.notifications.push(notification);
        setTimeout(() => {
            this.removeNotification(notification);
        }, 5000);
    },
    removeNotification(notification) {
        const index = this.notifications.indexOf(notification);
        if (index > -1) {
            this.notifications.splice(index, 1);
        }
    }
});

// Make Alpine available globally
window.Alpine = Alpine;

// Start Alpine
console.log('Starting Alpine.js');
Alpine.start();
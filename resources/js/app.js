import './bootstrap';
import Alpine from '@alpinejs/csp';
import { transform, getMethod, getAllMethods, getGroupedMethods } from './transformations/index.js';
// Removed unused converter component import and registration

// Make transform functions globally available for Alpine components
window.transform = transform;
window.getMethod = getMethod;
window.getAllMethods = getAllMethods;
window.getGroupedMethods = getGroupedMethods;

// Removed universalConverter component definition - using improvedConverter instead

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
    selectedTransformation: null,
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
    
    isPreviewCopied(previewKey) {
        return this.copiedFormat === previewKey;
    },
    
    shouldShowCopyText(previewKey) {
        return !this.copiedFormat || this.copiedFormat !== previewKey;
    },
    
    init() {
        console.log('improvedConverter initialized');
        // Listen for quick convert events
        window.addEventListener('quick-convert', (e) => {
            if (e.detail && e.detail.transformation) {
                this.quickTransform(e.detail.transformation);
            }
        });
        
        // Listen for transformation selector events
        window.addEventListener('transformation-selected', (e) => {
            if (e.detail && e.detail.toolId) {
                this.selectedTransformation = e.detail.toolId;
                // If there's text, apply the transformation immediately
                if (this.inputText) {
                    this.applySelectedTransformation(e.detail.toolId);
                }
            }
        });
        
        // Watch for inputText changes and generate previews
        this.$watch('inputText', () => {
            this.generateAllPreviews();
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
            // Use the transform function directly
            return await transform(transformation, text);
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
    
    handlePreviewClick(index) {
        const preview = this.previews[index];
        if (preview && preview.output && preview.key) {
            this.copyToClipboard(preview.output, preview.key);
        }
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
    
    clearAll() {
        this.inputText = '';
        this.copiedFormat = null;
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
    },
    
    async applySelectedTransformation(toolId) {
        if (!this.inputText || !toolId) return;
        
        try {
            // Transform the text using the selected tool
            const result = await window.transform(toolId, this.inputText);
            
            // Find or create a preview for this transformation
            let preview = this.previews.find(p => p.key === toolId);
            if (!preview) {
                // Add a new preview for this transformation
                preview = { 
                    key: toolId, 
                    label: toolId.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
                    output: result
                };
                this.previews.unshift(preview); // Add to beginning
                // Keep only the latest 12 previews
                if (this.previews.length > 12) {
                    this.previews = this.previews.slice(0, 12);
                }
            } else {
                preview.output = result;
            }
            
            // Copy the result to clipboard
            this.copyToClipboard(result, toolId);
        } catch (error) {
            console.error('Transformation failed:', error);
        }
    }
}));

// Tool page component for conversion tools
Alpine.data('toolConverter', () => ({
    inputText: '',
    outputText: '',
    realTimePreview: false,
    showOptions: false,
    copiedLink: false,
    copiedOutput: false,
    transformation: '',
    
    init() {
        // Get transformation from data attribute if available
        this.transformation = this.$el.dataset.transformation || '';
    },
    
    async transform() {
        if (!this.inputText) {
            this.outputText = '';
            return;
        }
        
        try {
            // Use the transform function from transformations module
            this.outputText = await transform(this.transformation, this.inputText);
        } catch (error) {
            console.error('Transformation error:', error);
            this.outputText = this.inputText; // Fallback to original text
        }
    },
    
    async copyLink() {
        try {
            await navigator.clipboard.writeText(window.location.href);
            this.copiedLink = true;
            this.showToast('Link copied to clipboard!');
            setTimeout(() => {
                this.copiedLink = false;
            }, 2000);
        } catch (error) {
            console.error('Copy failed:', error);
        }
    },
    
    async shareToolDeux() {
        if (navigator.share) {
            try {
                await navigator.share({
                    title: document.title,
                    url: window.location.href
                });
            } catch (error) {
                console.error('Share failed:', error);
            }
        } else {
            // Fallback to copy link
            await this.copyLink();
        }
    },
    
    toggleOptions() {
        this.showOptions = !this.showOptions;
    },
    
    async pasteFromClipboard() {
        try {
            const text = await navigator.clipboard.readText();
            this.inputText = text;
            if (this.realTimePreview) {
                await this.transform();
            }
        } catch (error) {
            console.error('Paste failed:', error);
        }
    },
    
    async loadFile(event) {
        const file = event.target.files[0];
        if (file && file.type === 'text/plain') {
            const reader = new FileReader();
            reader.onload = async (e) => {
                this.inputText = e.target.result;
                if (this.realTimePreview) {
                    await this.transform();
                }
            };
            reader.readAsText(file);
        }
    },
    
    async copyOutput() {
        if (!this.outputText) return;
        
        try {
            await navigator.clipboard.writeText(this.outputText);
            this.copiedOutput = true;
            this.showToast('Output copied to clipboard!');
            setTimeout(() => {
                this.copiedOutput = false;
            }, 2000);
        } catch (error) {
            console.error('Copy failed:', error);
        }
    },
    
    clearAll() {
        this.inputText = '';
        this.outputText = '';
    },
    
    toggleRealTime() {
        this.realTimePreview = !this.realTimePreview;
    },
    
    showToast(message) {
        // Create a simple toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    },
    
    // Watch for input changes in real-time mode
    handleInputChange() {
        if (this.realTimePreview) {
            this.transform();
        }
    }
}));

// Transformation selector component for tool selection UI
Alpine.data('transformationSelector', (allToolsData = {}, currentToolId = null) => ({
    // State management
    dropdownOpen: false,
    searchQuery: '',
    selectedTool: currentToolId,
    selectedToolName: '',
    allTools: {},
    filteredTools: {},
    filteredToolsCount: 0,
    selectedIndex: -1,
    
    init() {
        // Process the tools data into a structured format
        this.allTools = this.processToolsData(allToolsData);
        this.filteredTools = { ...this.allTools };
        this.countFilteredTools();
        
        // Set initial selected tool name if provided
        if (currentToolId) {
            this.findAndSetToolName(currentToolId);
        }
        
        // Setup keyboard navigation
        this.$el.addEventListener('keydown', this.handleKeyNavigation.bind(this));
    },
    
    processToolsData(data) {
        // Convert flat or API response format to categorized format
        const processed = {};
        
        if (Array.isArray(data)) {
            // If data is an array, group by category
            data.forEach(tool => {
                const category = tool.category || 'General';
                if (!processed[category]) {
                    processed[category] = [];
                }
                processed[category].push({
                    id: tool.id,
                    name: tool.name,
                    description: tool.description || ''
                });
            });
        } else if (typeof data === 'object') {
            // If data is already categorized, ensure proper structure
            Object.keys(data).forEach(category => {
                if (data[category].tools) {
                    // API format with nested tools
                    processed[data[category].title || category] = Object.keys(data[category].tools).map(toolId => ({
                        id: toolId,
                        name: data[category].tools[toolId].name,
                        description: data[category].tools[toolId].description || ''
                    }));
                } else if (Array.isArray(data[category])) {
                    // Already in correct format
                    processed[category] = data[category];
                }
            });
        }
        
        return processed;
    },
    
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
        if (this.dropdownOpen) {
            // Focus search input when opening
            this.$nextTick(() => {
                if (this.$refs.searchInput) {
                    this.$refs.searchInput.focus();
                }
            });
        } else {
            this.resetSearch();
            // Return focus to trigger button
            this.$nextTick(() => {
                const trigger = this.$el.querySelector('[aria-haspopup="true"]');
                if (trigger) trigger.focus();
            });
        }
    },
    
    closeDropdown() {
        this.dropdownOpen = false;
        this.resetSearch();
    },
    
    resetSearch() {
        this.searchQuery = '';
        this.filteredTools = { ...this.allTools };
        this.countFilteredTools();
        this.selectedIndex = -1;
    },
    
    filterTools() {
        const query = this.searchQuery.toLowerCase().trim();
        
        if (!query) {
            this.filteredTools = { ...this.allTools };
        } else {
            this.filteredTools = {};
            
            Object.keys(this.allTools).forEach(category => {
                const matchingTools = this.allTools[category].filter(tool => {
                    return tool.name.toLowerCase().includes(query) ||
                           tool.id.toLowerCase().includes(query) ||
                           (tool.description && tool.description.toLowerCase().includes(query));
                });
                
                if (matchingTools.length > 0) {
                    this.filteredTools[category] = matchingTools;
                }
            });
        }
        
        this.countFilteredTools();
        this.selectedIndex = -1;
    },
    
    countFilteredTools() {
        this.filteredToolsCount = Object.values(this.filteredTools)
            .reduce((count, tools) => count + tools.length, 0);
    },
    
    selectTool(toolId, toolName) {
        this.selectedTool = toolId;
        this.selectedToolName = toolName;
        
        // Dispatch custom event for parent components to handle
        this.$dispatch('tool-selected', { 
            toolId: toolId, 
            toolName: toolName 
        });
        
        // Also dispatch a window event for non-nested components
        window.dispatchEvent(new CustomEvent('transformation-selected', {
            detail: { toolId: toolId, toolName: toolName }
        }));
    },
    
    findAndSetToolName(toolId) {
        Object.values(this.allTools).forEach(category => {
            const tool = category.find(t => t.id === toolId);
            if (tool) {
                this.selectedToolName = tool.name;
            }
        });
    },
    
    handleKeyNavigation(event) {
        if (!this.dropdownOpen) return;
        
        const allTools = this.getFlatToolsList();
        
        switch(event.key) {
            case 'ArrowDown':
                event.preventDefault();
                this.selectedIndex = Math.min(this.selectedIndex + 1, allTools.length - 1);
                this.scrollToSelected();
                break;
                
            case 'ArrowUp':
                event.preventDefault();
                this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
                this.scrollToSelected();
                break;
                
            case 'Enter':
                event.preventDefault();
                if (this.selectedIndex >= 0 && this.selectedIndex < allTools.length) {
                    const tool = allTools[this.selectedIndex];
                    this.selectTool(tool.id, tool.name);
                    this.closeDropdown();
                }
                break;
                
            case 'Escape':
                event.preventDefault();
                this.closeDropdown();
                break;
        }
    },
    
    getFlatToolsList() {
        const tools = [];
        Object.values(this.filteredTools).forEach(category => {
            tools.push(...category);
        });
        return tools;
    },
    
    scrollToSelected() {
        this.$nextTick(() => {
            const buttons = this.$el.querySelectorAll('[role="menuitem"]');
            if (buttons[this.selectedIndex]) {
                buttons[this.selectedIndex].scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
                
                // Update visual selection
                buttons.forEach((btn, idx) => {
                    if (idx === this.selectedIndex) {
                        btn.classList.add('bg-gray-100', 'dark:bg-gray-800');
                    } else {
                        btn.classList.remove('bg-gray-100', 'dark:bg-gray-800');
                    }
                });
            }
        });
    },
    
    // Method to handle external tool selection events
    handleToolSelection(event) {
        if (event.detail && event.detail.toolId) {
            this.selectedTool = event.detail.toolId;
            this.selectedToolName = event.detail.toolName || '';
            this.findAndSetToolName(event.detail.toolId);
        }
    },
    
    // Additional keyboard navigation methods
    navigateDown() {
        const allTools = this.getFlatToolsList();
        this.selectedIndex = Math.min(this.selectedIndex + 1, allTools.length - 1);
        this.scrollToSelected();
    },
    
    navigateUp() {
        this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
        this.scrollToSelected();
    },
    
    selectHighlighted() {
        const allTools = this.getFlatToolsList();
        if (this.selectedIndex >= 0 && this.selectedIndex < allTools.length) {
            const tool = allTools[this.selectedIndex];
            this.selectTool(tool.id, tool.name);
            this.closeDropdown();
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
import './bootstrap';
import Alpine from '@alpinejs/csp';
import { transform, getMethod, getAllMethods, getGroupedMethods } from './transformations/index.js';

// Make transform functions globally available
window.transform = transform;
window.getMethod = getMethod;
window.getAllMethods = getAllMethods;
window.getGroupedMethods = getGroupedMethods;

// Theme toggle component (already CSP-compliant)
Alpine.data('themeToggle', () => ({
    isDark: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    
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

// Improved converter component - FULLY CSP COMPLIANT
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
    
    // Computed properties for CSP compliance
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
    
    // Methods for template conditionals (CSP-safe)
    isPreviewCopied(index) {
        const preview = this.previews[index];
        return preview && this.copiedFormat === preview.key;
    },
    
    shouldShowCopyText(index) {
        const preview = this.previews[index];
        return preview && (!this.copiedFormat || this.copiedFormat !== preview.key);
    },
    
    getPreviewLabel(index) {
        const preview = this.previews[index];
        return preview ? preview.label : '';
    },
    
    getPreviewOutput(index) {
        const preview = this.previews[index];
        return preview ? preview.output : '';
    },
    
    init() {
        console.log('improvedConverter initialized');
        
        // Listen for events
        window.addEventListener('quick-convert', (e) => {
            if (e.detail && e.detail.transformation) {
                this.quickTransform(e.detail.transformation);
            }
        });
        
        window.addEventListener('transformation-selected', (e) => {
            if (e.detail && e.detail.toolId) {
                this.selectedTransformation = e.detail.toolId;
                if (this.inputText) {
                    this.applySelectedTransformation(e.detail.toolId);
                }
            }
        });
        
        // Watch for input changes
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
        
        await Promise.all(this.previews.map(async (preview) => {
            preview.output = await this.transformText(this.inputText, preview.key);
        }));
    },
    
    async transformText(text, transformation) {
        if (!text) return '';
        
        try {
            return await transform(transformation, text);
        } catch (error) {
            console.warn(`Transformation ${transformation} failed`, error);
            // Fallback implementations...
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
    
    loadExample() {
        this.inputText = 'Hello World - This is a Sample Text';
        this.generateAllPreviews();
    },
    
    quickTransform(transformation) {
        if (!this.inputText) {
            this.inputText = 'Hello World - This is a Sample Text';
        }
        this.generateAllPreviews();
        
        const preview = this.previews.find(p => p.key === transformation);
        if (preview && preview.output) {
            this.copyToClipboard(preview.output, preview.key);
        }
    },
    
    async applySelectedTransformation(toolId) {
        if (!this.inputText || !toolId) return;
        
        try {
            const result = await window.transform(toolId, this.inputText);
            
            let preview = this.previews.find(p => p.key === toolId);
            if (!preview) {
                preview = { 
                    key: toolId, 
                    label: toolId.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
                    output: result
                };
                this.previews.unshift(preview);
                if (this.previews.length > 12) {
                    this.previews = this.previews.slice(0, 12);
                }
            } else {
                preview.output = result;
            }
            
            this.copyToClipboard(result, toolId);
        } catch (error) {
            console.error('Transformation failed:', error);
        }
    }
}));

// Transformation selector component - FULLY CSP COMPLIANT
Alpine.data('transformationSelector', () => ({
    // State
    dropdownOpen: false,
    searchQuery: '',
    selectedTool: null,
    selectedToolName: '',
    allTools: {},
    filteredTools: {},
    filteredToolsCount: 0,
    selectedIndex: -1,
    
    // Computed properties for CSP compliance
    get toolsCount() {
        return Object.keys(this.allTools).reduce((count, category) => {
            return count + (Array.isArray(this.allTools[category]) ? this.allTools[category].length : 0);
        }, 0);
    },
    
    get isDropdownOpen() {
        return this.dropdownOpen === true;
    },
    
    get hasNoResults() {
        return this.filteredToolsCount === 0;
    },
    
    get dropdownRotateClass() {
        return this.dropdownOpen ? 'rotate-180' : '';
    },
    
    get searchQueryValue() {
        return this.searchQuery || '';
    },
    
    get selectedToolDisplay() {
        return this.selectedTool ? `${this.selectedToolName} transformation selected` : '';
    },
    
    get hasSelectedTool() {
        return this.selectedTool !== null && this.selectedTool !== undefined;
    },
    
    // Initialize with passed data
    initWithData(allToolsData, currentToolId) {
        // Process tools data
        if (allToolsData) {
            this.allTools = this.processToolsData(allToolsData);
        }
        
        // Set current tool
        if (currentToolId) {
            this.selectedTool = currentToolId;
            this.findAndSetToolName(currentToolId);
        }
        
        this.filteredTools = { ...this.allTools };
        this.countFilteredTools();
    },
    
    init() {
        console.log('transformationSelector initialized');
        
        // The data will be passed via x-init in the template
        // Setup keyboard navigation
        this.$refs.searchInput && this.$refs.searchInput.addEventListener('keydown', (e) => {
            this.handleKeyNavigation(e);
        });
    },
    
    processToolsData(data) {
        const processed = {};
        
        if (Array.isArray(data)) {
            // Handle array format
            data.forEach(tool => {
                const category = tool.category || 'General';
                if (!processed[category]) {
                    processed[category] = [];
                }
                processed[category].push({
                    id: tool.id || tool.key,
                    name: tool.name || tool.label,
                    description: tool.description || ''
                });
            });
        } else if (typeof data === 'object') {
            // Handle object format
            Object.keys(data).forEach(category => {
                if (Array.isArray(data[category])) {
                    processed[category] = data[category].map(tool => ({
                        id: tool.id || tool.key,
                        name: tool.name || tool.label,
                        description: tool.description || ''
                    }));
                }
            });
        }
        
        return processed;
    },
    
    findAndSetToolName(toolId) {
        for (const category in this.allTools) {
            const tools = this.allTools[category];
            if (Array.isArray(tools)) {
                const tool = tools.find(t => t.id === toolId);
                if (tool) {
                    this.selectedToolName = tool.name;
                    return;
                }
            }
        }
    },
    
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
        if (this.dropdownOpen && this.$refs.searchInput) {
            this.$nextTick(() => {
                this.$refs.searchInput.focus();
            });
        }
    },
    
    closeDropdown() {
        this.dropdownOpen = false;
        this.searchQuery = '';
        this.filterTools();
    },
    
    filterTools() {
        if (!this.searchQuery) {
            this.filteredTools = { ...this.allTools };
        } else {
            const query = this.searchQuery.toLowerCase();
            this.filteredTools = {};
            
            for (const category in this.allTools) {
                const tools = this.allTools[category];
                if (Array.isArray(tools)) {
                    const filtered = tools.filter(tool => 
                        tool.name.toLowerCase().includes(query) ||
                        tool.id.toLowerCase().includes(query) ||
                        (tool.description && tool.description.toLowerCase().includes(query))
                    );
                    
                    if (filtered.length > 0) {
                        this.filteredTools[category] = filtered;
                    }
                }
            }
        }
        
        this.countFilteredTools();
        this.selectedIndex = -1;
    },
    
    countFilteredTools() {
        this.filteredToolsCount = Object.keys(this.filteredTools).reduce((count, category) => {
            return count + (Array.isArray(this.filteredTools[category]) ? this.filteredTools[category].length : 0);
        }, 0);
    },
    
    selectTool(toolId, toolName) {
        this.selectedTool = toolId;
        this.selectedToolName = toolName;
        
        // Dispatch events
        window.dispatchEvent(new CustomEvent('transformation-selected', {
            detail: { toolId, toolName }
        }));
        
        this.$dispatch('tool-selected', { toolId, toolName });
        this.closeDropdown();
    },
    
    // CSP-safe methods for template
    isToolSelected(toolId) {
        return this.selectedTool === toolId;
    },
    
    getQuickToolClasses(toolId) {
        if (this.selectedTool === toolId) {
            return 'ring-2 ring-blue-500 bg-blue-500/20';
        }
        return 'bg-white/10 hover:bg-white/20';
    },
    
    handleKeyNavigation(event) {
        const allTools = [];
        for (const category in this.filteredTools) {
            if (Array.isArray(this.filteredTools[category])) {
                allTools.push(...this.filteredTools[category]);
            }
        }
        
        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                this.selectedIndex = Math.min(this.selectedIndex + 1, allTools.length - 1);
                break;
                
            case 'ArrowUp':
                event.preventDefault();
                this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
                break;
                
            case 'Enter':
                event.preventDefault();
                if (this.selectedIndex >= 0 && this.selectedIndex < allTools.length) {
                    const tool = allTools[this.selectedIndex];
                    this.selectTool(tool.id, tool.name);
                }
                break;
                
            case 'Escape':
                event.preventDefault();
                this.closeDropdown();
                break;
        }
    },
    
    navigateDown() {
        const allTools = [];
        for (const category in this.filteredTools) {
            if (Array.isArray(this.filteredTools[category])) {
                allTools.push(...this.filteredTools[category]);
            }
        }
        this.selectedIndex = Math.min(this.selectedIndex + 1, allTools.length - 1);
    },
    
    navigateUp() {
        this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
    },
    
    selectHighlighted() {
        const allTools = [];
        for (const category in this.filteredTools) {
            if (Array.isArray(this.filteredTools[category])) {
                allTools.push(...this.filteredTools[category]);
            }
        }
        
        if (this.selectedIndex >= 0 && this.selectedIndex < allTools.length) {
            const tool = allTools[this.selectedIndex];
            this.selectTool(tool.id, tool.name);
        }
    },
    
    handleToolSelection(event) {
        if (event.detail && event.detail.toolId) {
            this.selectedTool = event.detail.toolId;
            this.selectedToolName = event.detail.toolName || '';
        }
    }
}));

// Initialize Alpine
window.Alpine = Alpine;
Alpine.start();

console.log('Text Transformations loaded:', Object.keys(getGroupedMethods()).length, 'methods across', Object.keys(getGroupedMethods()).length, 'categories');
console.log('Starting Alpine.js');
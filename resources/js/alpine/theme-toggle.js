export default () => ({
    currentTheme: 'system',
    themes: ['light', 'dark', 'system'],
    isOpen: false,
    
    init() {
        // Sync with ThemeManager on component initialization
        if (window.themeManager) {
            this.currentTheme = window.themeManager.currentTheme;
            this.themes = window.themeManager.themes;
        }
        
        // Watch for currentTheme changes from the UI
        this.$watch('currentTheme', (value) => {
            if (window.themeManager && window.themeManager.currentTheme !== value) {
                window.themeManager.setTheme(value);
            }
        });

        // Listen for theme changes from ThemeManager
        window.addEventListener('themeChanged', (event) => {
            this.currentTheme = window.themeManager.currentTheme;
        });

        // Listen for theme changes from ThemeManager (new event)
        window.addEventListener('themeManagerChanged', (event) => {
            this.currentTheme = event.detail.theme;
        });
        
        // Listen for system theme changes when in system mode
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', () => {
            if (this.currentTheme === 'system' && window.themeManager) {
                // Force a refresh of the effective theme
                window.themeManager.applyTheme('system');
            }
        });
    },
    
    toggleDropdown() {
        this.isOpen = !this.isOpen;
    },
    
    selectTheme(theme) {
        this.currentTheme = theme;
        this.isOpen = false;
    },
    
    getCurrentThemeIcon() {
        // Show the effective theme icon, not just the setting
        const effectiveTheme = window.themeManager ? window.themeManager.getEffectiveTheme() : this.currentTheme;
        return this.getThemeIcon(effectiveTheme);
    },
    
    getThemeIcon(theme) {
        const icons = {
            light: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>`,
            dark: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>`,
            system: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>`
        };
        return icons[theme] || icons.system;
    },
    
    getThemeLabel(theme) {
        const labels = {
            light: 'Light',
            dark: 'Dark',
            system: 'System'
        };
        return labels[theme] || 'System';
    },
    
    // Get descriptive text for current selection
    getCurrentThemeDescription() {
        const effectiveTheme = window.themeManager ? window.themeManager.getEffectiveTheme() : 'light';
        if (this.currentTheme === 'system') {
            return `System (${effectiveTheme === 'dark' ? 'Dark' : 'Light'})`;
        }
        return this.getThemeLabel(this.currentTheme);
    }
});

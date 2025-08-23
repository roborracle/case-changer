/**
 * Theme Management System for Case Changer Pro
 * Handles light/dark/system theme switching with smooth transitions
 * CRITICAL: This must run before Alpine.js initializes to prevent FOUC
 */

class ThemeManager {
    constructor() {
        this.themes = ['light', 'dark', 'system'];
        this.currentTheme = this.getStoredTheme() || 'system';
        this.mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Apply theme immediately to prevent FOUC
        this.applyThemeImmediately(this.currentTheme);
        this.init();
    }

    init() {
        // Listen for system theme changes
        this.mediaQuery.addEventListener('change', () => {
            if (this.currentTheme === 'system') {
                this.updateSystemTheme();
            }
        });
    }

    // Apply theme immediately without transitions to prevent FOUC
    applyThemeImmediately(theme) {
        const html = document.documentElement;
        
        // Remove existing theme classes
        html.classList.remove('light', 'dark');
        
        if (theme === 'system') {
            // Apply system preference immediately
            const isDark = this.mediaQuery.matches;
            html.classList.add(isDark ? 'dark' : 'light');
        } else {
            // Apply specific theme immediately
            html.classList.add(theme);
        }
    }

    getStoredTheme() {
        try {
            return localStorage.getItem('case-changer-theme');
        } catch {
            return null;
        }
    }

    setStoredTheme(theme) {
        try {
            localStorage.setItem('case-changer-theme', theme);
            // Also set cookie for server-side rendering
            document.cookie = `case-changer-theme=${theme}; path=/; max-age=31536000; SameSite=Lax`;
        } catch {
            // LocalStorage not available
        }
    }

    setTheme(theme) {
        if (!this.themes.includes(theme)) {
            theme = 'system';
        }
        
        this.currentTheme = theme;
        this.setStoredTheme(theme);
        this.applyTheme(theme);
        
        // Notify Alpine components of theme change
        this.notifyAlpineComponents();
    }

    // Notify Alpine components that theme has changed
    notifyAlpineComponents() {
        window.dispatchEvent(new CustomEvent('themeManagerChanged', {
            detail: { 
                theme: this.currentTheme,
                effectiveTheme: this.getEffectiveTheme()
            }
        }));
    }

    applyTheme(theme) {
        const html = document.documentElement;
        
        // Remove existing theme classes
        html.classList.remove('light', 'dark');
        
        if (theme === 'system') {
            // Apply system preference
            this.updateSystemTheme();
        } else {
            // Apply specific theme
            html.classList.add(theme);
        }
        
        // Dispatch custom event for components that need to know about theme changes
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme: this.getEffectiveTheme() }
        }));
    }

    updateSystemTheme() {
        const html = document.documentElement;
        const isDark = this.mediaQuery.matches;
        
        html.classList.remove('light', 'dark');
        html.classList.add(isDark ? 'dark' : 'light');
    }

    getEffectiveTheme() {
        if (this.currentTheme === 'system') {
            return this.mediaQuery.matches ? 'dark' : 'light';
        }
        return this.currentTheme;
    }

    toggle() {
        const currentIndex = this.themes.indexOf(this.currentTheme);
        const nextIndex = (currentIndex + 1) % this.themes.length;
        this.setTheme(this.themes[nextIndex]);
    }
}

// CRITICAL: Apply theme IMMEDIATELY on script load to minimize FOUC
// This runs synchronously before any other code
(function() {
    const stored = localStorage.getItem('case-changer-theme') || 'system';
    const html = document.documentElement;
    html.classList.remove('light', 'dark');
    
    if (stored === 'system') {
        const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        html.classList.add(isDark ? 'dark' : 'light');
    } else {
        html.classList.add(stored);
    }
})();

// Initialize theme manager after immediate application
if (!window.themeManager) {
    window.themeManager = new ThemeManager();
}

// Export for use in other modules
export default ThemeManager;

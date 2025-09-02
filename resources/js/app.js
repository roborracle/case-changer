import './bootstrap';
// Use Alpine.js ESM build for CSP compatibility
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// Register the persist plugin BEFORE Alpine starts
Alpine.plugin(persist);

// Import and register all components
import './alpine-components';
import './converters';

// Make Alpine available globally (required for inline x-data)
window.Alpine = Alpine;

// Start Alpine
Alpine.start();

// After Alpine starts, apply initial theme
document.addEventListener('DOMContentLoaded', () => {
    // Apply theme from localStorage or system preference
    const theme = localStorage.getItem('case-changer-theme') || 'system';
    const root = document.documentElement;
    
    root.classList.remove('light', 'dark');
    
    if (theme === 'dark' || 
        (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        root.classList.add('dark');
    } else if (theme === 'light') {
        root.classList.add('light');
    }
});
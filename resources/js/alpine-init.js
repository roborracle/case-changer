/**
 * Alpine.js Initialization
 * Proper setup with store support
 */

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// Register plugins before anything else
Alpine.plugin(persist);

// Create stores
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

// Initialize the store
Alpine.store('navigation').init();

export default Alpine;
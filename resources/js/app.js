import './bootstrap';
import Alpine from 'alpinejs';

// Make Alpine available globally
window.Alpine = Alpine;

// Import application-specific components
import { 
    navigationDropdown, 
    mobileMenu, 
    searchModal, 
    themeToggle,
    copyToClipboard 
} from './navigation';
import lazyLoading from './lazy-loading';

// Initialize stores
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
        
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (this.theme === 'system') {
                this.applyTheme();
            }
        });
    }
});

// Register components
Alpine.data('navigationDropdown', navigationDropdown);
Alpine.data('mobileMenu', mobileMenu);
Alpine.data('searchModal', searchModal);
Alpine.data('themeToggle', themeToggle);
Alpine.data('copyToClipboard', copyToClipboard);
Alpine.data('lazyLoading', lazyLoading);

// Start Alpine
Alpine.start();

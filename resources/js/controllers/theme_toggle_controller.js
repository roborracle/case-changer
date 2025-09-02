import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["menu", "currentIcon"]
    
    connect() {
        this.theme = localStorage.getItem('case-changer-theme') || 'system'
        this.showMenu = false
        
        // Listen for system theme changes - initialize BEFORE using
        this.mediaQuery = window.matchMedia('(prefers-color-scheme: dark)')
        this.handleSystemThemeChange = this.handleSystemThemeChange.bind(this)
        this.mediaQuery.addEventListener('change', this.handleSystemThemeChange)
        
        // Now safe to call applyTheme which uses this.mediaQuery
        this.applyTheme()
        this.updateIcon()
    }
    
    setTheme(event) {
        const theme = event.currentTarget.dataset.theme
        this.theme = theme
        localStorage.setItem('case-changer-theme', theme)
        this.showMenu = false
        this.applyTheme()
        this.updateIcon()
        this.updateMenu()
    }
    
    toggleMenu() {
        this.showMenu = !this.showMenu
        this.updateMenu()
    }
    
    applyTheme() {
        const root = document.documentElement
        root.classList.remove('light', 'dark')
        
        if (this.theme === 'dark' || 
            (this.theme === 'system' && this.mediaQuery.matches)) {
            root.classList.add('dark')
        } else if (this.theme === 'light') {
            root.classList.add('light')
        }
    }
    
    updateIcon() {
        if (!this.hasCurrentIconTarget) return
        
        // Update icon based on current theme
        const iconHTML = this.getIconHTML()
        this.currentIconTarget.innerHTML = iconHTML
    }
    
    updateMenu() {
        if (this.hasMenuTarget) {
            if (this.showMenu) {
                this.menuTarget.classList.remove('hidden')
            } else {
                this.menuTarget.classList.add('hidden')
            }
        }
    }
    
    getIconHTML() {
        if (this.theme === 'light') {
            return `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>`
        } else if (this.theme === 'dark') {
            return `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>`
        } else {
            return `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>`
        }
    }
    
    handleSystemThemeChange() {
        if (this.theme === 'system') {
            this.applyTheme()
        }
    }
    
    // Close menu when clicking outside
    clickOutside(event) {
        if (!this.element.contains(event.target)) {
            this.showMenu = false
            this.updateMenu()
        }
    }
    
    disconnect() {
        this.mediaQuery.removeEventListener('change', this.handleSystemThemeChange)
    }
}
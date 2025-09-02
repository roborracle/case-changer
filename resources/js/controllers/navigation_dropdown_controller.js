import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["menu"]
    
    connect() {
        this.open = false
        this.updateMenu()
    }
    
    toggle(event) {
        event.stopPropagation()
        this.open = !this.open
        this.updateMenu()
    }
    
    close() {
        this.open = false
        this.updateMenu()
    }
    
    updateMenu() {
        if (this.hasMenuTarget) {
            if (this.open) {
                this.menuTarget.classList.remove('hidden')
            } else {
                this.menuTarget.classList.add('hidden')
            }
        }
    }
    
    // Close dropdown when clicking outside
    clickOutside(event) {
        if (!this.element.contains(event.target)) {
            this.close()
        }
    }
    
    // Close on escape key
    closeOnEscape(event) {
        if (event.key === "Escape") {
            this.close()
        }
    }
    
    disconnect() {
        // Cleanup if needed
        this.close()
    }
}
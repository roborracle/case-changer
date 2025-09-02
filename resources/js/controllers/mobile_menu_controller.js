import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["menu", "openIcon", "closeIcon"]
    
    connect() {
        this.isOpen = false
        this.updateState()
        
        // Handle resize events
        this.handleResize = this.handleResize.bind(this)
        window.addEventListener('resize', this.handleResize)
    }
    
    toggle() {
        this.isOpen = !this.isOpen
        this.updateState()
    }
    
    close() {
        this.isOpen = false
        this.updateState()
    }
    
    updateState() {
        // Update menu visibility
        if (this.hasMenuTarget) {
            if (this.isOpen) {
                this.menuTarget.classList.remove('hidden')
                document.body.style.overflow = 'hidden'
            } else {
                this.menuTarget.classList.add('hidden')
                document.body.style.overflow = ''
            }
        }
        
        // Update icon visibility
        if (this.hasOpenIconTarget && this.hasCloseIconTarget) {
            if (this.isOpen) {
                this.openIconTarget.classList.add('hidden')
                this.closeIconTarget.classList.remove('hidden')
            } else {
                this.openIconTarget.classList.remove('hidden')
                this.closeIconTarget.classList.add('hidden')
            }
        }
    }
    
    handleResize() {
        if (window.innerWidth >= 768) {
            this.close()
        }
    }
    
    disconnect() {
        window.removeEventListener('resize', this.handleResize)
        document.body.style.overflow = ''
    }
}
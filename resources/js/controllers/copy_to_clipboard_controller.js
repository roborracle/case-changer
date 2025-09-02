import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static values = { text: String }
    static targets = ["button"]
    
    async copy(event) {
        // Get text from data attribute or value
        const text = this.textValue || event.currentTarget.dataset.text || ''
        
        if (!text) {
            console.error('No text to copy')
            return
        }
        
        try {
            await navigator.clipboard.writeText(text)
            this.showSuccess()
        } catch (err) {
            console.error('Failed to copy:', err)
            this.showError()
        }
    }
    
    showSuccess() {
        if (this.hasButtonTarget) {
            const originalText = this.buttonTarget.textContent
            const originalClasses = this.buttonTarget.className
            
            this.buttonTarget.textContent = 'Copied!'
            this.buttonTarget.classList.add('bg-green-600', 'text-white')
            
            setTimeout(() => {
                this.buttonTarget.textContent = originalText
                this.buttonTarget.className = originalClasses
            }, 2000)
        }
        
        // Dispatch custom event for other components to listen to
        this.dispatch('copied', { detail: { text: this.textValue } })
    }
    
    showError() {
        if (this.hasButtonTarget) {
            const originalText = this.buttonTarget.textContent
            
            this.buttonTarget.textContent = 'Failed!'
            this.buttonTarget.classList.add('bg-red-600', 'text-white')
            
            setTimeout(() => {
                this.buttonTarget.textContent = originalText
                this.buttonTarget.classList.remove('bg-red-600', 'text-white')
            }, 2000)
        }
    }
}
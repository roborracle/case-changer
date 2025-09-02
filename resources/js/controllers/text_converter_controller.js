import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["input", "output", "tool", "copyButton"]
    
    connect() {
        this.selectedTool = 'uppercase'
        this.processing = false
        
        // Auto-convert on load if there's input
        if (this.hasInputTarget && this.inputTarget.value) {
            this.convert()
        }
    }
    
    convert() {
        if (!this.hasInputTarget || !this.hasOutputTarget) return
        
        const input = this.inputTarget.value
        
        if (!input) {
            this.outputTarget.value = ''
            return
        }
        
        this.processing = true
        const output = this.applyTransformation(input, this.selectedTool)
        this.outputTarget.value = output
        this.processing = false
    }
    
    selectTool(event) {
        const tool = event.currentTarget.value || event.currentTarget.dataset.tool
        this.selectedTool = tool
        this.convert()
    }
    
    applyTransformation(text, tool) {
        const transformations = {
            'uppercase': text => text.toUpperCase(),
            'lowercase': text => text.toLowerCase(),
            'title-case': text => text.replace(/\w\S*/g, txt => 
                txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
            ),
            'camel-case': text => text.replace(/(?:^\w|[A-Z]|\b\w)/g, (word, index) => 
                index === 0 ? word.toLowerCase() : word.toUpperCase()
            ).replace(/\s+/g, ''),
            'pascal-case': text => text.replace(/(?:^\w|[A-Z]|\b\w)/g, word => 
                word.toUpperCase()
            ).replace(/\s+/g, ''),
            'snake-case': text => text.toLowerCase().replace(/\s+/g, '_'),
            'kebab-case': text => text.toLowerCase().replace(/\s+/g, '-'),
            'constant-case': text => text.toUpperCase().replace(/\s+/g, '_'),
            'sentence-case': text => text.charAt(0).toUpperCase() + text.slice(1).toLowerCase(),
            'reverse': text => text.split('').reverse().join(''),
            'capitalize': text => text.replace(/\b\w/g, l => l.toUpperCase()),
            'alternate-case': text => text.split('').map((char, i) => 
                i % 2 === 0 ? char.toLowerCase() : char.toUpperCase()
            ).join(''),
            'inverse-case': text => text.split('').map(char => 
                char === char.toUpperCase() ? char.toLowerCase() : char.toUpperCase()
            ).join('')
        }
        
        const transform = transformations[tool] || transformations['uppercase']
        return transform(text)
    }
    
    async copyOutput() {
        if (!this.hasOutputTarget) return
        
        const output = this.outputTarget.value
        if (!output) return
        
        try {
            await navigator.clipboard.writeText(output)
            
            // Update button text temporarily
            if (this.hasCopyButtonTarget) {
                const originalText = this.copyButtonTarget.textContent
                this.copyButtonTarget.textContent = 'Copied!'
                this.copyButtonTarget.classList.add('bg-green-600')
                
                setTimeout(() => {
                    this.copyButtonTarget.textContent = originalText
                    this.copyButtonTarget.classList.remove('bg-green-600')
                }, 2000)
            }
        } catch (err) {
            console.error('Copy failed:', err)
        }
    }
    
    clearAll() {
        if (this.hasInputTarget) this.inputTarget.value = ''
        if (this.hasOutputTarget) this.outputTarget.value = ''
    }
}
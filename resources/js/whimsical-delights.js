// Minimal functional JavaScript for Case Changer Pro
// All interactive functionality is handled by Livewire

document.addEventListener('DOMContentLoaded', function() {
    // Copy to clipboard functionality with browser API
    window.addEventListener('copy-to-clipboard', event => {
        const text = event.detail.text;
        
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(() => {
                console.log('Text copied to clipboard');
            }).catch(err => {
                console.error('Failed to copy text: ', err);
                fallbackCopyTextToClipboard(text);
            });
        } else {
            fallbackCopyTextToClipboard(text);
        }
    });
    
    // Fallback copy method for older browsers
    function fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            const msg = successful ? 'successful' : 'unsuccessful';
            console.log('Fallback: Copying text command was ' + msg);
        } catch (err) {
            console.error('Fallback: Unable to copy', err);
        }
        
        document.body.removeChild(textArea);
    }
    
    // Reset copied state after delay
    window.addEventListener('reset-copied', event => {
        setTimeout(() => {
            Livewire.dispatch('resetCopied');
        }, 2000);
    });
    
    // Auto-resize textareas based on content
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        // Set initial height
        adjustTextareaHeight(textarea);
        
        // Adjust on input
        textarea.addEventListener('input', function() {
            adjustTextareaHeight(this);
        });
    });
    
    function adjustTextareaHeight(textarea) {
        // Reset height to recalculate
        textarea.style.height = 'auto';
        // Set new height based on content
        const newHeight = Math.max(256, Math.min(textarea.scrollHeight, 600));
        textarea.style.height = newHeight + 'px';
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Cmd/Ctrl + Enter to copy output
        if ((e.metaKey || e.ctrlKey) && e.key === 'Enter') {
            e.preventDefault();
            Livewire.dispatch('copyToClipboard');
        }
        
        // Cmd/Ctrl + Shift + C to clear all
        if ((e.metaKey || e.ctrlKey) && e.shiftKey && e.key === 'C') {
            e.preventDefault();
            Livewire.dispatch('clearAll');
        }
        
        // Cmd/Ctrl + Z for undo
        if ((e.metaKey || e.ctrlKey) && !e.shiftKey && e.key === 'z') {
            e.preventDefault();
            Livewire.dispatch('undo');
        }
        
        // Cmd/Ctrl + Shift + Z for redo
        if ((e.metaKey || e.ctrlKey) && e.shiftKey && e.key === 'z') {
            e.preventDefault();
            Livewire.dispatch('redo');
        }
    });
});
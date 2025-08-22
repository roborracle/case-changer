/**
 * Glassmorphism Micro-Interactions
 * Enhances the Case Changer Pro interface with delightful animations
 */

// Magnetic Button Effect
class MagneticButton {
    constructor(element) {
        this.element = element;
        this.boundingRect = element.getBoundingClientRect();
        this.magnetStrength = 0.25;
        this.init();
    }

    init() {
        this.element.addEventListener('mousemove', (e) => this.magnetize(e));
        this.element.addEventListener('mouseleave', () => this.reset());
    }

    magnetize(e) {
        const { left, top, width, height } = this.boundingRect;
        const centerX = left + width / 2;
        const centerY = top + height / 2;
        
        const deltaX = (e.clientX - centerX) * this.magnetStrength;
        const deltaY = (e.clientY - centerY) * this.magnetStrength;
        
        this.element.style.transform = `translate(${deltaX}px, ${deltaY}px) scale(1.05)`;
        this.element.style.transition = 'transform 0.2s cubic-bezier(0.33, 1, 0.68, 1)';
    }

    reset() {
        this.element.style.transform = 'translate(0, 0) scale(1)';
        this.element.style.transition = 'transform 0.3s cubic-bezier(0.33, 1, 0.68, 1)';
    }
}

// Glass Ripple Effect
class GlassRipple {
    constructor(element) {
        this.element = element;
        this.init();
    }

    init() {
        this.element.addEventListener('click', (e) => this.createRipple(e));
    }

    createRipple(e) {
        const ripple = document.createElement('span');
        ripple.classList.add('glass-ripple');
        
        const rect = this.element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        
        this.element.appendChild(ripple);
        
        ripple.addEventListener('animationend', () => {
            ripple.remove();
        });
    }
}

// Floating Orbs Animation Enhancement
class FloatingOrbs {
    constructor() {
        this.orbs = document.querySelectorAll('.orb');
        this.mouseX = 0;
        this.mouseY = 0;
        this.init();
    }

    init() {
        if (!this.orbs.length) return;
        
        document.addEventListener('mousemove', (e) => {
            this.mouseX = e.clientX / window.innerWidth;
            this.mouseY = e.clientY / window.innerHeight;
            this.parallaxOrbs();
        });

        // Add gentle pulsing to orbs
        this.orbs.forEach((orb, index) => {
            orb.style.animationDelay = `${index * 0.5}s`;
        });
    }

    parallaxOrbs() {
        this.orbs.forEach((orb, index) => {
            const speed = (index + 1) * 10;
            const x = (this.mouseX - 0.5) * speed;
            const y = (this.mouseY - 0.5) * speed;
            
            orb.style.transform = `translate(${x}px, ${y}px)`;
            orb.style.transition = 'transform 0.3s ease-out';
        });
    }
}

// Contextual Suggestion Animation
class ContextualSuggestions {
    constructor() {
        this.suggestionBar = document.querySelector('.context-suggestions');
        this.init();
    }

    init() {
        if (!this.suggestionBar) return;
        
        // Animate suggestions appearing
        const suggestions = this.suggestionBar.querySelectorAll('.suggestion-pill');
        suggestions.forEach((pill, index) => {
            pill.style.animationDelay = `${index * 0.05}s`;
            pill.classList.add('fade-in-up');
        });
    }
}

// Typography Button Hover Effects
class TypographyButtons {
    constructor() {
        this.buttons = document.querySelectorAll('.typography-button');
        this.init();
    }

    init() {
        this.buttons.forEach(button => {
            // Add magnetic effect
            new MagneticButton(button);
            
            // Add glass ripple
            new GlassRipple(button);
            
            // Add custom hover based on type
            this.addCustomHover(button);
        });
    }

    addCustomHover(button) {
        const type = button.classList[1]; // Get typography-{type} class
        
        button.addEventListener('mouseenter', () => {
            switch(type) {
                case 'typography-reverse':
                    button.style.transform = 'scaleX(-1)';
                    break;
                case 'typography-upper':
                    button.style.letterSpacing = '2px';
                    break;
                case 'typography-random':
                    this.randomizeText(button);
                    break;
                case 'typography-zalgo':
                    this.addZalgoEffect(button);
                    break;
            }
        });

        button.addEventListener('mouseleave', () => {
            button.style.transform = '';
            button.style.letterSpacing = '';
            if (button.dataset.originalText) {
                button.textContent = button.dataset.originalText;
                delete button.dataset.originalText;
            }
        });
    }

    randomizeText(button) {
        if (!button.dataset.originalText) {
            button.dataset.originalText = button.textContent;
        }
        
        const text = button.textContent;
        const randomized = text.split('').map(char => {
            return Math.random() > 0.5 ? char.toUpperCase() : char.toLowerCase();
        }).join('');
        
        button.textContent = randomized;
    }

    addZalgoEffect(button) {
        if (!button.dataset.originalText) {
            button.dataset.originalText = button.textContent;
        }
        
        const zalgoChars = ['̸', '̀', '́', '̂', '̃', '̄', '̅', '̆', '̇', '̈', '̉'];
        const text = button.textContent;
        const zalgofied = text.split('').map(char => {
            const zalgoCount = Math.floor(Math.random() * 3) + 1;
            let result = char;
            for (let i = 0; i < zalgoCount; i++) {
                result += zalgoChars[Math.floor(Math.random() * zalgoChars.length)];
            }
            return result;
        }).join('');
        
        button.textContent = zalgofied;
    }
}

// Smooth Scroll for Category Links
class SmoothScroll {
    constructor() {
        this.links = document.querySelectorAll('a[href^="#"]');
        this.init();
    }

    init() {
        this.links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }
}

// Text Analysis Visualizer
class TextAnalyzer {
    constructor() {
        this.textarea = document.querySelector('textarea[wire\\:model\\.live="inputText"]');
        this.init();
    }

    init() {
        if (!this.textarea) return;
        
        this.textarea.addEventListener('input', () => {
            this.visualizeFeedback();
        });
    }

    visualizeFeedback() {
        // Add subtle glow when typing
        this.textarea.style.boxShadow = '0 0 20px rgba(59, 130, 246, 0.3)';
        
        setTimeout(() => {
            this.textarea.style.boxShadow = '';
        }, 500);
    }
}

// Notification Toast Animation
class NotificationToast {
    static show(message, duration = 3000) {
        const toast = document.createElement('div');
        toast.className = 'glass-notification';
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            animation: slideInRight 0.3s ease-out;
            z-index: 9999;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease-out';
            toast.addEventListener('animationend', () => {
                toast.remove();
            });
        }, duration);
    }
}

// Copy to Clipboard Enhancement
class ClipboardEnhancement {
    constructor() {
        this.copyButtons = document.querySelectorAll('[wire\\:click="copyToClipboard"]');
        this.init();
    }

    init() {
        this.copyButtons.forEach(button => {
            button.addEventListener('click', () => {
                this.animateCopy(button);
                NotificationToast.show('Copied to clipboard!');
            });
        });
    }

    animateCopy(button) {
        const icon = button.querySelector('svg');
        if (icon) {
            icon.style.animation = 'checkmark 0.5s ease-out';
            setTimeout(() => {
                icon.style.animation = '';
            }, 500);
        }
    }
}

// Performance Observer
class PerformanceMonitor {
    constructor() {
        this.init();
    }

    init() {
        // Monitor animation performance
        if ('PerformanceObserver' in window) {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (entry.duration > 16.67) { // Slower than 60fps
                        console.warn('Performance issue detected:', entry.name);
                        this.reduceAnimations();
                    }
                }
            });
            
            observer.observe({ entryTypes: ['measure'] });
        }
    }

    reduceAnimations() {
        // Reduce animation complexity if performance issues detected
        document.body.classList.add('reduce-motion');
    }
}

// Accessibility Enhancements
class AccessibilityEnhancements {
    constructor() {
        this.init();
    }

    init() {
        // Respect prefers-reduced-motion
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.body.classList.add('reduce-motion');
        }

        // Add keyboard navigation helpers
        this.addKeyboardShortcuts();
        
        // Enhance focus visibility
        this.enhanceFocusIndicators();
    }

    addKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('input[wire\\:model\\.live="searchTerm"]');
                if (searchInput) searchInput.focus();
            }

            // Ctrl/Cmd + Enter to apply transformation
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                const primaryButton = document.querySelector('.typography-button.primary');
                if (primaryButton) primaryButton.click();
            }

            // Escape to close advanced drawer
            if (e.key === 'Escape') {
                const drawer = document.querySelector('.glass-tertiary');
                if (drawer && drawer.style.display !== 'none') {
                    document.querySelector('[wire\\:click="toggleAdvancedDrawer"]').click();
                }
            }
        });
    }

    enhanceFocusIndicators() {
        // Add visible focus indicators for keyboard navigation
        const focusableElements = document.querySelectorAll('button, input, textarea, select, a');
        
        focusableElements.forEach(element => {
            element.addEventListener('focus', () => {
                element.classList.add('keyboard-focus');
            });
            
            element.addEventListener('blur', () => {
                element.classList.remove('keyboard-focus');
            });
        });
    }
}

// Initialize all enhancements when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Core interactions
    new FloatingOrbs();
    new TypographyButtons();
    new ContextualSuggestions();
    new SmoothScroll();
    
    // Enhanced features
    new TextAnalyzer();
    new ClipboardEnhancement();
    
    // Performance & Accessibility
    new PerformanceMonitor();
    new AccessibilityEnhancements();
    
    // Add CSS for ripple effect
    const style = document.createElement('style');
    style.textContent = `
        .glass-ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        @keyframes checkmark {
            0% { transform: scale(1); }
            50% { transform: scale(1.2) rotate(5deg); }
            100% { transform: scale(1); }
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }
        
        .keyboard-focus {
            outline: 2px solid #3b82f6 !important;
            outline-offset: 4px !important;
        }
        
        .reduce-motion * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
        
        .magnetic-hover {
            position: relative;
            transition: all 0.3s cubic-bezier(0.33, 1, 0.68, 1);
        }
    `;
    document.head.appendChild(style);
    
    console.log('✨ Glassmorphism interactions initialized');
});

// Livewire integration hooks
if (typeof Livewire !== 'undefined') {
    Livewire.on('textTransformed', () => {
        NotificationToast.show('Text transformed successfully!');
    });
    
    Livewire.on('copiedToClipboard', () => {
        NotificationToast.show('Copied to clipboard!');
    });
    
    Livewire.on('contextDetected', (context) => {
        console.log('Context detected:', context);
        new ContextualSuggestions();
    });
}

// Export for use in other modules
export {
    MagneticButton,
    GlassRipple,
    FloatingOrbs,
    NotificationToast,
    AccessibilityEnhancements
};

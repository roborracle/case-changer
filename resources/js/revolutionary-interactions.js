/**
 * Revolutionary Magnetic Interaction System
 * Enhances Case Changer Pro with performance art-level interface dynamics
 */

class MagneticInterface {
    constructor() {
        this.magneticButtons = [];
        this.isReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        this.init();
    }

    init() {
        if (this.isReduced) return;
        
        this.setupMagneticButtons();
        this.setupTextTransformAnimations();
        this.setupLivePreview();
        this.setupPerformanceOptimizations();
    }

    setupMagneticButtons() {
        const buttons = document.querySelectorAll('.btn-transform');
        
        buttons.forEach(button => {
            this.magneticButtons.push(button);
            
            button.addEventListener('mouseenter', this.onButtonMouseEnter.bind(this));
            button.addEventListener('mouseleave', this.onButtonMouseLeave.bind(this));
            button.addEventListener('mousemove', this.onButtonMouseMove.bind(this));
            button.addEventListener('click', this.onButtonClick.bind(this));
        });
    }

    onButtonMouseEnter(event) {
        const button = event.currentTarget;
        
        // Add magnetic attraction
        button.style.transition = 'transform 400ms cubic-bezier(0.25, 1, 0.5, 1)';
        button.style.transform = 'translateY(-2px) scale(1.02)';
        
        // Add glow effect
        button.style.boxShadow = `
            var(--shadow-medium), 
            var(--shadow-primary),
            0 0 20px var(--accent-glow)
        `;
    }

    onButtonMouseLeave(event) {
        const button = event.currentTarget;
        
        // Reset transforms
        button.style.transform = '';
        button.style.boxShadow = '';
    }

    onButtonMouseMove(event) {
        const button = event.currentTarget;
        const rect = button.getBoundingClientRect();
        const x = event.clientX - rect.left - rect.width / 2;
        const y = event.clientY - rect.top - rect.height / 2;
        
        // Subtle magnetic pull effect
        const distance = Math.sqrt(x * x + y * y);
        const maxDistance = 50;
        
        if (distance < maxDistance) {
            const strength = (maxDistance - distance) / maxDistance;
            const magneticX = x * strength * 0.1;
            const magneticY = y * strength * 0.1;
            
            button.style.transform = `
                translateY(-2px) 
                scale(1.02) 
                translate(${magneticX}px, ${magneticY}px)
            `;
        }
    }

    onButtonClick(event) {
        const button = event.currentTarget;
        
        // Add clicked state
        button.classList.add('clicked');
        
        // Create ripple effect
        this.createRippleEffect(button, event);
        
        // Remove clicked state after animation
        setTimeout(() => {
            button.classList.remove('clicked');
        }, 600);
    }

    createRippleEffect(button, event) {
        const ripple = document.createElement('div');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            animation: ripple 600ms cubic-bezier(0.25, 1, 0.5, 1);
            z-index: 0;
        `;
        
        button.style.position = 'relative';
        button.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    setupTextTransformAnimations() {
        // Add keyframe for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                0% {
                    opacity: 1;
                    transform: scale(0);
                }
                100% {
                    opacity: 0;
                    transform: scale(2);
                }
            }
            
            .btn-transform.clicked {
                animation: textTransform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            }
        `;
        document.head.appendChild(style);
    }

    setupLivePreview() {
        const inputTextarea = document.getElementById('inputText');
        const buttons = document.querySelectorAll('.btn-transform');
        
        if (!inputTextarea) return;
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                const sampleText = inputTextarea.value || 'Sample Text';
                const preview = this.generatePreview(button, sampleText);
                this.showPreview(button, preview);
            });
            
            button.addEventListener('mouseleave', () => {
                this.hidePreview(button);
            });
        });
    }

    generatePreview(button, text) {
        const buttonText = button.textContent.trim();
        const shortText = text.substring(0, 20) + (text.length > 20 ? '...' : '');
        
        // Simple preview based on button type
        switch (buttonText) {
            case 'UPPERCASE':
                return shortText.toUpperCase();
            case 'lowercase':
                return shortText.toLowerCase();
            case 'Title Case':
                return this.toTitleCase(shortText);
            case 'camelCase':
                return this.toCamelCase(shortText);
            case 'snake_case':
                return this.toSnakeCase(shortText);
            case 'kebab-case':
                return this.toKebabCase(shortText);
            default:
                return shortText;
        }
    }

    toTitleCase(str) {
        return str.replace(/\w\S*/g, (txt) => 
            txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
        );
    }

    toCamelCase(str) {
        return str.replace(/(?:^\w|[A-Z]|\b\w)/g, (word, index) => 
            index === 0 ? word.toLowerCase() : word.toUpperCase()
        ).replace(/\s+/g, '');
    }

    toSnakeCase(str) {
        return str.replace(/\W+/g, ' ')
            .split(/ |\B(?=[A-Z])/)
            .map(word => word.toLowerCase())
            .join('_');
    }

    toKebabCase(str) {
        return str.replace(/\W+/g, ' ')
            .split(/ |\B(?=[A-Z])/)
            .map(word => word.toLowerCase())
            .join('-');
    }

    showPreview(button, preview) {
        let previewElement = button.querySelector('.preview-overlay');
        
        if (!previewElement) {
            previewElement = document.createElement('div');
            previewElement.className = 'preview-overlay';
            button.appendChild(previewElement);
        }
        
        previewElement.textContent = preview;
        previewElement.style.opacity = '0.95';
    }

    hidePreview(button) {
        const previewElement = button.querySelector('.preview-overlay');
        if (previewElement) {
            previewElement.style.opacity = '0';
        }
    }

    setupPerformanceOptimizations() {
        // Use requestAnimationFrame for smooth animations
        this.magneticButtons.forEach(button => {
            button.style.willChange = 'transform';
        });
        
        // Intersection Observer for efficient rendering
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.willChange = 'transform';
                } else {
                    entry.target.style.willChange = 'auto';
                }
            });
        });
        
        this.magneticButtons.forEach(button => {
            observer.observe(button);
        });
    }
}

// Enhanced Input/Output Interactions
class TextAreaEnhancements {
    constructor() {
        this.init();
    }

    init() {
        this.setupTextAreas();
        this.setupCopyFeedback();
        this.setupProgressiveBlur();
    }

    setupTextAreas() {
        const textAreas = document.querySelectorAll('.text-input');
        
        textAreas.forEach(textarea => {
            textarea.addEventListener('focus', this.onFocus.bind(this));
            textarea.addEventListener('blur', this.onBlur.bind(this));
            textarea.addEventListener('input', this.onInput.bind(this));
        });
    }

    onFocus(event) {
        const textarea = event.currentTarget;
        const container = textarea.closest('.io-container');
        
        container.style.transform = 'translateY(-2px)';
        container.style.boxShadow = 'var(--shadow-high), var(--shadow-primary)';
        
        // Add subtle glow animation
        textarea.style.animation = 'glowPulse 2s ease-in-out infinite';
    }

    onBlur(event) {
        const textarea = event.currentTarget;
        const container = textarea.closest('.io-container');
        
        container.style.transform = '';
        container.style.boxShadow = '';
        textarea.style.animation = '';
    }

    onInput(event) {
        const textarea = event.currentTarget;
        
        // Add subtle text transform animation
        textarea.style.animation = 'textTransform 0.3s cubic-bezier(0.25, 1, 0.5, 1)';
        
        setTimeout(() => {
            textarea.style.animation = '';
        }, 300);
    }

    setupCopyFeedback() {
        const copyButtons = document.querySelectorAll('.btn-copy');
        
        copyButtons.forEach(button => {
            button.addEventListener('click', this.onCopyClick.bind(this));
        });
    }

    onCopyClick(event) {
        const button = event.currentTarget;
        
        // Create success particle effect
        this.createParticleEffect(button);
    }

    createParticleEffect(button) {
        for (let i = 0; i < 6; i++) {
            const particle = document.createElement('div');
            const angle = (i / 6) * Math.PI * 2;
            const distance = 30;
            const x = Math.cos(angle) * distance;
            const y = Math.sin(angle) * distance;
            
            particle.style.cssText = `
                position: absolute;
                width: 4px;
                height: 4px;
                background: var(--accent-primary);
                border-radius: 50%;
                pointer-events: none;
                left: 50%;
                top: 50%;
                animation: particle 800ms cubic-bezier(0.25, 1, 0.5, 1) forwards;
                --x: ${x}px;
                --y: ${y}px;
            `;
            
            button.style.position = 'relative';
            button.appendChild(particle);
            
            setTimeout(() => {
                particle.remove();
            }, 800);
        }
        
        // Add particle animation keyframe
        if (!document.querySelector('#particle-style')) {
            const style = document.createElement('style');
            style.id = 'particle-style';
            style.textContent = `
                @keyframes particle {
                    0% {
                        opacity: 1;
                        transform: translate(-50%, -50%) scale(1);
                    }
                    100% {
                        opacity: 0;
                        transform: translate(calc(-50% + var(--x)), calc(-50% + var(--y))) scale(0);
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    setupProgressiveBlur() {
        // Add progressive blur effect when scrolling
        let ticking = false;
        
        function updateBlur() {
            const scrolled = window.pageYOffset;
            const parallax = scrolled * 0.5;
            const containers = document.querySelectorAll('.io-container');
            
            containers.forEach(container => {
                const rect = container.getBoundingClientRect();
                const distance = Math.abs(rect.top + rect.height / 2 - window.innerHeight / 2);
                const maxDistance = window.innerHeight;
                const blurAmount = Math.min(distance / maxDistance * 3, 3);
                
                container.style.filter = `blur(${blurAmount}px)`;
                container.style.opacity = Math.max(1 - blurAmount / 3, 0.7);
            });
            
            ticking = false;
        }
        
        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateBlur);
                ticking = true;
            }
        }
        
        window.addEventListener('scroll', requestTick);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Check for reduced motion preference
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    
    if (!prefersReducedMotion.matches) {
        new MagneticInterface();
        new TextAreaEnhancements();
    }
    
    // Add stagger animation to buttons
    const buttons = document.querySelectorAll('.btn-transform');
    buttons.forEach((button, index) => {
        button.style.animationDelay = `${index * 50}ms`;
        button.classList.add('animate-slide-up');
    });
});

// Export for potential external use
window.CaseChangerPro = {
    MagneticInterface,
    TextAreaEnhancements
};
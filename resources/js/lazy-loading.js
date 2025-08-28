/**
 * Lazy Loading for Images
 * Implements Intersection Observer for efficient image loading
 */

// Initialize lazy loading
document.addEventListener('DOMContentLoaded', function() {
    // Check if Intersection Observer is supported
    if ('IntersectionObserver' in window) {
        const lazyImages = document.querySelectorAll('img[data-src], img[loading="lazy"]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    
                    // Load the image
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    
                    // Add loaded class for animations
                    img.classList.add('loaded');
                    
                    // Stop observing this image
                    observer.unobserve(img);
                }
            });
        }, {
            // Start loading when image is 50px away from viewport
            rootMargin: '50px 0px',
            threshold: 0.01
        });
        
        // Observe all lazy images
        lazyImages.forEach(img => {
            imageObserver.observe(img);
        });
        
        // Also handle background images
        const lazyBackgrounds = document.querySelectorAll('[data-bg]');
        
        const bgObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const elem = entry.target;
                    elem.style.backgroundImage = `url(${elem.dataset.bg})`;
                    elem.removeAttribute('data-bg');
                    elem.classList.add('loaded');
                    observer.unobserve(elem);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });
        
        lazyBackgrounds.forEach(elem => {
            bgObserver.observe(elem);
        });
        
    } else {
        // Fallback for browsers that don't support Intersection Observer
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
        
        const lazyBackgrounds = document.querySelectorAll('[data-bg]');
        lazyBackgrounds.forEach(elem => {
            elem.style.backgroundImage = `url(${elem.dataset.bg})`;
            elem.removeAttribute('data-bg');
        });
    }
});

// Add loading placeholder styles
const style = document.createElement('style');
style.textContent = `
    img[data-src],
    img[loading="lazy"]:not(.loaded) {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    
    img.loaded {
        opacity: 1;
    }
    
    [data-bg] {
        background-color: #f0f0f0;
        background-image: linear-gradient(90deg, #f0f0f0 0%, #f8f8f8 50%, #f0f0f0 100%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
    
    [data-bg].loaded {
        animation: none;
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
`;
document.head.appendChild(style);

// Export for use in other modules
export default {
    init() {
        // Can be called manually if needed
        const event = new Event('DOMContentLoaded');
        document.dispatchEvent(event);
    }
};
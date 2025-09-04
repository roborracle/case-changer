// Web Worker for handling large text transformations
// This worker processes text transformations off the main thread for better performance

self.addEventListener('message', function(e) {
    const { text, transformation, chunkSize = 10000 } = e.data;
    
    if (!text || !transformation) {
        self.postMessage({ 
            error: 'Invalid input: text and transformation are required' 
        });
        return;
    }
    
    try {
        // Post progress updates for large texts
        const textLength = text.length;
        const shouldShowProgress = textLength > 100000; // 100KB
        
        if (shouldShowProgress) {
            self.postMessage({ 
                type: 'progress', 
                progress: 0, 
                message: 'Starting transformation...' 
            });
        }
        
        let result = '';
        let processed = 0;
        
        // Process text in chunks for very large texts
        if (textLength > chunkSize) {
            const chunks = Math.ceil(textLength / chunkSize);
            
            for (let i = 0; i < chunks; i++) {
                const start = i * chunkSize;
                const end = Math.min(start + chunkSize, textLength);
                const chunk = text.slice(start, end);
                
                // Apply transformation to chunk
                const transformedChunk = applyTransformation(chunk, transformation);
                result += transformedChunk;
                
                processed = end;
                
                // Update progress for large files
                if (shouldShowProgress) {
                    const progress = Math.round((processed / textLength) * 100);
                    self.postMessage({ 
                        type: 'progress', 
                        progress,
                        message: `Processing... ${progress}%` 
                    });
                }
                
                // Small delay to prevent blocking
                if (i % 10 === 0) {
                    // Use setTimeout instead of async/await in web worker
                    setTimeout(() => {}, 1);
                }
            }
        } else {
            // Process smaller texts directly
            result = applyTransformation(text, transformation);
        }
        
        // Send final result
        self.postMessage({ 
            type: 'complete',
            result,
            originalLength: textLength,
            resultLength: result.length
        });
        
    } catch (error) {
        self.postMessage({ 
            type: 'error',
            error: error.message 
        });
    }
});

// Text transformation functions (client-side implementations)
function applyTransformation(text, transformation) {
    switch (transformation) {
        case 'upper-case':
            return text.toUpperCase();
            
        case 'lower-case':
            return text.toLowerCase();
            
        case 'sentence-case':
            return text.toLowerCase().replace(/(^\w|\.\s+\w)/g, match => match.toUpperCase());
            
        case 'title-case':
            return text.toLowerCase().replace(/\b\w+/g, word => {
                // Articles, prepositions, and conjunctions to keep lowercase (unless first/last word)
                const minorWords = ['a', 'an', 'the', 'and', 'but', 'or', 'for', 'nor', 'as', 'at', 'by', 'to', 'up', 'in', 'of', 'on'];
                const firstChar = word.charAt(0).toUpperCase();
                const restChars = word.slice(1);
                
                if (minorWords.includes(word.toLowerCase()) && word !== text.split(' ')[0] && word !== text.split(' ').pop()) {
                    return word.toLowerCase();
                }
                return firstChar + restChars;
            });
            
        case 'camel-case':
            return text.toLowerCase()
                .replace(/[^a-zA-Z0-9]+(.)/g, (match, char) => char.toUpperCase())
                .replace(/^[A-Z]/, char => char.toLowerCase());
                
        case 'pascal-case':
            return text.toLowerCase()
                .replace(/[^a-zA-Z0-9]+(.)/g, (match, char) => char.toUpperCase())
                .replace(/^[a-z]/, char => char.toUpperCase());
                
        case 'snake-case':
            return text.toLowerCase()
                .replace(/[^a-zA-Z0-9]+/g, '_')
                .replace(/^_+|_+$/g, '');
                
        case 'kebab-case':
            return text.toLowerCase()
                .replace(/[^a-zA-Z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
                
        case 'constant-case':
            return text.toUpperCase()
                .replace(/[^a-zA-Z0-9]+/g, '_')
                .replace(/^_+|_+$/g, '');
                
        case 'alternating-case':
            return text.split('').map((char, index) => {
                return index % 2 === 0 ? char.toLowerCase() : char.toUpperCase();
            }).join('');
            
        case 'inverse-case':
            return text.split('').map(char => {
                return char === char.toUpperCase() ? char.toLowerCase() : char.toUpperCase();
            }).join('');
            
        case 'reverse':
            return text.split('').reverse().join('');
            
        case 'aesthetic':
            return text.split('').join(' ').toUpperCase();
            
        case 'sarcasm':
            return text.split('').map((char, index) => {
                if (char.match(/[a-zA-Z]/)) {
                    return index % 2 === 0 ? char.toLowerCase() : char.toUpperCase();
                }
                return char;
            }).join('');
            
        default:
            return text;
    }
}

// Helper function to create artificial delay for demonstration
function delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
import { TransformationMethod, Validators } from './base.js';

/**
 * Base class for encoding/decoding transformations
 */
class EncodingTransformation extends TransformationMethod {
    constructor(name, description) {
        super(name, 'Encoding & Decoding', description);
        this.addValidator(Validators.required);
    }
}

/**
 * Base64 Encode transformation
 */
export class Base64Encode extends EncodingTransformation {
    constructor() {
        super('base64-encode', 'Encode text to Base64');
    }

    execute(input) {
        try {
            return btoa(unescape(encodeURIComponent(input)));
        } catch (e) {
            // Fallback for Node.js environment
            if (typeof Buffer !== 'undefined') {
                return Buffer.from(input).toString('base64');
            }
            throw e;
        }
    }
}

/**
 * Base64 Decode transformation
 */
export class Base64Decode extends EncodingTransformation {
    constructor() {
        super('base64-decode', 'Decode Base64 to text');
    }

    execute(input) {
        try {
            return decodeURIComponent(escape(atob(input)));
        } catch (e) {
            // Fallback for Node.js environment
            if (typeof Buffer !== 'undefined') {
                return Buffer.from(input, 'base64').toString();
            }
            throw new Error('Invalid Base64 input');
        }
    }
}

/**
 * URL Encode transformation
 */
export class URLEncode extends EncodingTransformation {
    constructor() {
        super('url-encode', 'Encode text for URLs');
    }

    execute(input) {
        return encodeURIComponent(input);
    }
}

/**
 * URL Decode transformation
 */
export class URLDecode extends EncodingTransformation {
    constructor() {
        super('url-decode', 'Decode URL-encoded text');
    }

    execute(input) {
        try {
            return decodeURIComponent(input);
        } catch (e) {
            throw new Error('Invalid URL-encoded input');
        }
    }
}

/**
 * HTML Entity Encode transformation
 */
export class HTMLEncode extends EncodingTransformation {
    constructor() {
        super('html-encode', 'Encode HTML entities');
    }

    execute(input) {
        const entities = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
            '/': '&#x2F;'
        };
        
        return input.replace(/[&<>"'\/]/g, char => entities[char]);
    }
}

/**
 * HTML Entity Decode transformation
 */
export class HTMLDecode extends EncodingTransformation {
    constructor() {
        super('html-decode', 'Decode HTML entities');
    }

    execute(input) {
        const entities = {
            '&amp;': '&',
            '&lt;': '<',
            '&gt;': '>',
            '&quot;': '"',
            '&#39;': "'",
            '&#x2F;': '/'
        };
        
        return input.replace(/&[a-z]+;|&#x[0-9a-f]+;|&#[0-9]+;/gi, entity => {
            if (entities[entity]) return entities[entity];
            
            // Numeric entities
            if (entity.startsWith('&#x')) {
                const code = parseInt(entity.slice(3, -1), 16);
                return String.fromCharCode(code);
            }
            if (entity.startsWith('&#')) {
                const code = parseInt(entity.slice(2, -1), 10);
                return String.fromCharCode(code);
            }
            
            return entity;
        });
    }
}

/**
 * Unicode Escape transformation
 */
export class UnicodeEscape extends EncodingTransformation {
    constructor() {
        super('unicode-escape', 'Escape text to Unicode');
    }

    execute(input) {
        return input.split('').map(char => {
            const code = char.charCodeAt(0);
            if (code < 128) return char;
            return '\\u' + ('0000' + code.toString(16)).slice(-4);
        }).join('');
    }
}

/**
 * Unicode Unescape transformation
 */
export class UnicodeUnescape extends EncodingTransformation {
    constructor() {
        super('unicode-unescape', 'Unescape Unicode to text');
    }

    execute(input) {
        return input.replace(/\\u([0-9a-fA-F]{4})/g, (match, code) => {
            return String.fromCharCode(parseInt(code, 16));
        });
    }
}

/**
 * Hexadecimal Encode transformation
 */
export class HexEncode extends EncodingTransformation {
    constructor() {
        super('hex-encode', 'Encode text to hexadecimal');
    }

    execute(input) {
        return input.split('').map(char => {
            return char.charCodeAt(0).toString(16).padStart(2, '0');
        }).join('');
    }
}

/**
 * Hexadecimal Decode transformation
 */
export class HexDecode extends EncodingTransformation {
    constructor() {
        super('hex-decode', 'Decode hexadecimal to text');
    }

    execute(input) {
        // Remove spaces and validate
        input = input.replace(/\s/g, '');
        if (!/^[0-9a-fA-F]*$/.test(input) || input.length % 2 !== 0) {
            throw new Error('Invalid hexadecimal input');
        }
        
        let result = '';
        for (let i = 0; i < input.length; i += 2) {
            result += String.fromCharCode(parseInt(input.substr(i, 2), 16));
        }
        return result;
    }
}

/**
 * Binary Encode transformation
 */
export class BinaryEncode extends EncodingTransformation {
    constructor() {
        super('binary-encode', 'Encode text to binary');
    }

    execute(input) {
        return input.split('').map(char => {
            return char.charCodeAt(0).toString(2).padStart(8, '0');
        }).join(' ');
    }
}

/**
 * Binary Decode transformation
 */
export class BinaryDecode extends EncodingTransformation {
    constructor() {
        super('binary-decode', 'Decode binary to text');
    }

    execute(input) {
        // Remove non-binary characters and split
        const binary = input.replace(/[^01\s]/g, '').trim().split(/\s+/);
        
        return binary.map(byte => {
            if (byte.length !== 8) {
                throw new Error('Invalid binary input - each byte must be 8 bits');
            }
            return String.fromCharCode(parseInt(byte, 2));
        }).join('');
    }
}

/**
 * ROT13 transformation
 */
export class ROT13 extends EncodingTransformation {
    constructor() {
        super('rot13', 'ROT13 cipher encoding');
    }

    execute(input) {
        return input.replace(/[a-zA-Z]/g, char => {
            const code = char.charCodeAt(0);
            const base = code < 97 ? 65 : 97;
            return String.fromCharCode((code - base + 13) % 26 + base);
        });
    }
}

/**
 * Morse Code Encode transformation
 */
export class MorseEncode extends EncodingTransformation {
    constructor() {
        super('morse-encode', 'Encode text to Morse code');
    }

    execute(input) {
        const morse = {
            'A': '.-', 'B': '-...', 'C': '-.-.', 'D': '-..', 'E': '.', 'F': '..-.',
            'G': '--.', 'H': '....', 'I': '..', 'J': '.---', 'K': '-.-', 'L': '.-..',
            'M': '--', 'N': '-.', 'O': '---', 'P': '.--.', 'Q': '--.-', 'R': '.-.',
            'S': '...', 'T': '-', 'U': '..-', 'V': '...-', 'W': '.--', 'X': '-..-',
            'Y': '-.--', 'Z': '--..', '0': '-----', '1': '.----', '2': '..---',
            '3': '...--', '4': '....-', '5': '.....', '6': '-....', '7': '--...',
            '8': '---..', '9': '----.', '.': '.-.-.-', ',': '--..--', '?': '..--..',
            "'": '.----.', '!': '-.-.--', '/': '-..-.', '(': '-.--.', ')': '-.--.-',
            '&': '.-...', ':': '---...', ';': '-.-.-.', '=': '-...-', '+': '.-.-.',
            '-': '-....-', '_': '..--.-', '"': '.-..-.', '$': '...-..-', '@': '.--.-.',
            ' ': '/'
        };
        
        return input.toUpperCase().split('').map(char => morse[char] || char).join(' ');
    }
}

/**
 * Morse Code Decode transformation
 */
export class MorseDecode extends EncodingTransformation {
    constructor() {
        super('morse-decode', 'Decode Morse code to text');
    }

    execute(input) {
        const morse = {
            '.-': 'A', '-...': 'B', '-.-.': 'C', '-..': 'D', '.': 'E', '..-.': 'F',
            '--.': 'G', '....': 'H', '..': 'I', '.---': 'J', '-.-': 'K', '.-..': 'L',
            '--': 'M', '-.': 'N', '---': 'O', '.--.': 'P', '--.-': 'Q', '.-.': 'R',
            '...': 'S', '-': 'T', '..-': 'U', '...-': 'V', '.--': 'W', '-..-': 'X',
            '-.--': 'Y', '--..': 'Z', '-----': '0', '.----': '1', '..---': '2',
            '...--': '3', '....-': '4', '.....': '5', '-....': '6', '--...': '7',
            '---..': '8', '----.': '9', '.-.-.-': '.', '--..--': ',', '..--..': '?',
            '.----.': "'", '-.-.--': '!', '-..-.': '/', '-.--.': '(', '-.--.-': ')',
            '.-...': '&', '---...': ':', '-.-.-.': ';', '-...-': '=', '.-.-.': '+',
            '-....-': '-', '..--.-': '_', '.-..-.': '"', '...-..-': '$', '.--.-.': '@',
            '/': ' '
        };
        
        return input.split(' ').map(code => morse[code] || code).join('');
    }
}

/**
 * ASCII to Text transformation
 */
export class ASCIIToText extends EncodingTransformation {
    constructor() {
        super('ascii-to-text', 'Convert ASCII codes to text');
    }

    execute(input) {
        const codes = input.match(/\d+/g);
        if (!codes) throw new Error('No ASCII codes found');
        
        return codes.map(code => {
            const num = parseInt(code);
            if (num < 0 || num > 127) throw new Error('Invalid ASCII code: ' + code);
            return String.fromCharCode(num);
        }).join('');
    }
}

/**
 * Text to ASCII transformation
 */
export class TextToASCII extends EncodingTransformation {
    constructor() {
        super('text-to-ascii', 'Convert text to ASCII codes');
    }

    execute(input) {
        return input.split('').map(char => char.charCodeAt(0)).join(' ');
    }
}

// Export all transformations as an array
export const encodingTransformations = [
    new Base64Encode(),
    new Base64Decode(),
    new URLEncode(),
    new URLDecode(),
    new HTMLEncode(),
    new HTMLDecode(),
    new UnicodeEscape(),
    new UnicodeUnescape(),
    new HexEncode(),
    new HexDecode(),
    new BinaryEncode(),
    new BinaryDecode(),
    new ROT13(),
    new MorseEncode(),
    new MorseDecode(),
    new ASCIIToText(),
    new TextToASCII()
];

export default encodingTransformations;
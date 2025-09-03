import { TransformationMethod, Validators } from './base.js';

/**
 * Base class for text case transformations
 */
class TextCaseTransformation extends TransformationMethod {
    constructor(name, description) {
        super(name, 'Text Case', description);
        this.addValidator(Validators.required);
    }
}

/**
 * Upper Case transformation
 */
export class UpperCase extends TextCaseTransformation {
    constructor() {
        super('upper-case', 'Convert text to UPPER CASE');
    }

    execute(input) {
        return input.toUpperCase();
    }
}

/**
 * Lower Case transformation
 */
export class LowerCase extends TextCaseTransformation {
    constructor() {
        super('lower-case', 'Convert text to lower case');
    }

    execute(input) {
        return input.toLowerCase();
    }
}

/**
 * Title Case transformation
 */
export class TitleCase extends TextCaseTransformation {
    constructor() {
        super('title-case', 'Convert Text To Title Case');
    }

    execute(input) {
        const minorWords = new Set(['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'if', 'in', 'nor', 'of', 'on', 'or', 'so', 'the', 'to', 'up', 'yet']);
        
        return input.toLowerCase().replace(/\b\w+/g, (word, index) => {
            // Always capitalize first and last word
            if (index === 0 || !minorWords.has(word)) {
                return word.charAt(0).toUpperCase() + word.slice(1);
            }
            return word;
        });
    }
}

/**
 * Sentence Case transformation
 */
export class SentenceCase extends TextCaseTransformation {
    constructor() {
        super('sentence-case', 'Convert text to sentence case');
    }

    execute(input) {
        return input.toLowerCase().replace(/(^\s*\w|[.!?]\s+\w)/g, match => match.toUpperCase());
    }
}

/**
 * Camel Case transformation
 */
export class CamelCase extends TextCaseTransformation {
    constructor() {
        super('camel-case', 'convertTextToCamelCase');
    }

    execute(input) {
        return input
            .replace(/[^a-zA-Z0-9]+(.)/g, (match, chr) => chr.toUpperCase())
            .replace(/^./, chr => chr.toLowerCase());
    }
}

/**
 * Pascal Case transformation
 */
export class PascalCase extends TextCaseTransformation {
    constructor() {
        super('pascal-case', 'ConvertTextToPascalCase');
    }

    execute(input) {
        return input
            .replace(/[^a-zA-Z0-9]+(.)/g, (match, chr) => chr.toUpperCase())
            .replace(/^./, chr => chr.toUpperCase());
    }
}

/**
 * Snake Case transformation
 */
export class SnakeCase extends TextCaseTransformation {
    constructor() {
        super('snake-case', 'convert_text_to_snake_case');
    }

    execute(input) {
        return input
            .replace(/[A-Z]/g, letter => `_${letter.toLowerCase()}`)
            .replace(/^_/, '')
            .replace(/[^a-zA-Z0-9]+/g, '_')
            .toLowerCase();
    }
}

/**
 * Kebab Case transformation
 */
export class KebabCase extends TextCaseTransformation {
    constructor() {
        super('kebab-case', 'convert-text-to-kebab-case');
    }

    execute(input) {
        return input
            .replace(/[A-Z]/g, letter => `-${letter.toLowerCase()}`)
            .replace(/^-/, '')
            .replace(/[^a-zA-Z0-9]+/g, '-')
            .toLowerCase();
    }
}

/**
 * Constant Case transformation
 */
export class ConstantCase extends TextCaseTransformation {
    constructor() {
        super('constant-case', 'CONVERT_TEXT_TO_CONSTANT_CASE');
    }

    execute(input) {
        return input
            .replace(/[^a-zA-Z0-9]+/g, '_')
            .toUpperCase();
    }
}

/**
 * Dot Case transformation
 */
export class DotCase extends TextCaseTransformation {
    constructor() {
        super('dot-case', 'convert.text.to.dot.case');
    }

    execute(input) {
        return input
            .replace(/[A-Z]/g, letter => `.${letter.toLowerCase()}`)
            .replace(/^\./, '')
            .replace(/[^a-zA-Z0-9]+/g, '.')
            .toLowerCase();
    }
}

/**
 * Path Case transformation
 */
export class PathCase extends TextCaseTransformation {
    constructor() {
        super('path-case', 'convert/text/to/path/case');
    }

    execute(input) {
        return input
            .replace(/[A-Z]/g, letter => `/${letter.toLowerCase()}`)
            .replace(/^\//, '')
            .replace(/[^a-zA-Z0-9]+/g, '/')
            .toLowerCase();
    }
}

/**
 * Alternating Case transformation
 */
export class AlternatingCase extends TextCaseTransformation {
    constructor() {
        super('alternating-case', 'CoNvErT tExT tO aLtErNaTiNg CaSe');
    }

    execute(input) {
        let upper = true;
        return input.split('').map(char => {
            if (/[a-zA-Z]/.test(char)) {
                const result = upper ? char.toUpperCase() : char.toLowerCase();
                upper = !upper;
                return result;
            }
            return char;
        }).join('');
    }
}

/**
 * Inverse Case transformation
 */
export class InverseCase extends TextCaseTransformation {
    constructor() {
        super('inverse-case', 'iNVERT tHE cASE oF tEXT');
    }

    execute(input) {
        return input.split('').map(char => {
            if (char === char.toUpperCase()) {
                return char.toLowerCase();
            } else {
                return char.toUpperCase();
            }
        }).join('');
    }
}

/**
 * Capitalize Words transformation
 */
export class CapitalizeWords extends TextCaseTransformation {
    constructor() {
        super('capitalize-words', 'Capitalize Each Word In Text');
    }

    execute(input) {
        return input.replace(/\b\w/g, char => char.toUpperCase());
    }
}

/**
 * Random Case transformation
 */
export class RandomCase extends TextCaseTransformation {
    constructor() {
        super('random-case', 'RaNdOmLy CaPiTaLiZe LeTtErS');
    }

    execute(input) {
        return input.split('').map(char => {
            if (/[a-zA-Z]/.test(char)) {
                return Math.random() > 0.5 ? char.toUpperCase() : char.toLowerCase();
            }
            return char;
        }).join('');
    }
}

/**
 * Sarcasm Case transformation
 */
export class SarcasmCase extends TextCaseTransformation {
    constructor() {
        super('sarcasm', 'cOnVeRt TeXt To SaRcAsM cAsE');
    }

    execute(input) {
        let upper = false;
        return input.split('').map(char => {
            if (/[a-zA-Z]/.test(char)) {
                upper = !upper;
                return upper ? char.toUpperCase() : char.toLowerCase();
            }
            return char;
        }).join('');
    }
}

// Export all transformations as an array
export const textCaseTransformations = [
    new UpperCase(),
    new LowerCase(),
    new TitleCase(),
    new SentenceCase(),
    new CamelCase(),
    new PascalCase(),
    new SnakeCase(),
    new KebabCase(),
    new ConstantCase(),
    new DotCase(),
    new PathCase(),
    new AlternatingCase(),
    new InverseCase(),
    new CapitalizeWords(),
    new RandomCase(),
    new SarcasmCase()
];

export default textCaseTransformations;
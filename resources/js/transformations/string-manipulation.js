import { TransformationMethod, Validators } from './base.js';

/**
 * Base class for string manipulation transformations
 */
class StringManipulation extends TransformationMethod {
    constructor(name, description) {
        super(name, 'String Manipulation', description);
        this.addValidator(Validators.required);
    }
}

/**
 * Reverse text transformation
 */
export class ReverseText extends StringManipulation {
    constructor() {
        super('reverse', 'txeT esreveR');
    }

    execute(input) {
        return input.split('').reverse().join('');
    }
}

/**
 * Remove spaces transformation
 */
export class RemoveSpaces extends StringManipulation {
    constructor() {
        super('remove-spaces', 'Removealltspacesfromtext');
    }

    execute(input) {
        return input.replace(/\s/g, '');
    }
}

/**
 * Remove extra spaces transformation
 */
export class RemoveExtraSpaces extends StringManipulation {
    constructor() {
        super('remove-extra-spaces', 'Remove extra spaces from text');
    }

    execute(input) {
        return input.replace(/\s+/g, ' ').trim();
    }
}

/**
 * Remove punctuation transformation
 */
export class RemovePunctuation extends StringManipulation {
    constructor() {
        super('remove-punctuation', 'Remove punctuation from text');
    }

    execute(input) {
        return input.replace(/[^\w\s]|_/g, '').replace(/\s+/g, ' ');
    }
}

/**
 * Extract letters transformation
 */
export class ExtractLetters extends StringManipulation {
    constructor() {
        super('extract-letters', 'Extract only letters from text');
    }

    execute(input) {
        return input.replace(/[^a-zA-Z]/g, '');
    }
}

/**
 * Extract numbers transformation
 */
export class ExtractNumbers extends StringManipulation {
    constructor() {
        super('extract-numbers', 'Extract only numbers from text');
    }

    execute(input) {
        return input.replace(/[^0-9]/g, '');
    }
}

/**
 * Remove duplicates transformation
 */
export class RemoveDuplicates extends StringManipulation {
    constructor() {
        super('remove-duplicates', 'Remove duplicate words from text');
    }

    execute(input) {
        const words = input.split(/\s+/);
        const seen = new Set();
        const result = [];
        
        for (const word of words) {
            const normalized = word.toLowerCase();
            if (!seen.has(normalized)) {
                seen.add(normalized);
                result.push(word);
            }
        }
        
        return result.join(' ');
    }
}

/**
 * Sort words transformation
 */
export class SortWords extends StringManipulation {
    constructor() {
        super('sort-words', 'Sort words alphabetically');
    }

    execute(input) {
        return input.split(/\s+/).sort((a, b) => a.toLowerCase().localeCompare(b.toLowerCase())).join(' ');
    }
}

/**
 * Shuffle words transformation
 */
export class ShuffleWords extends StringManipulation {
    constructor() {
        super('shuffle-words', 'Randomly shuffle words');
    }

    execute(input) {
        const words = input.split(/\s+/);
        for (let i = words.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [words[i], words[j]] = [words[j], words[i]];
        }
        return words.join(' ');
    }
}

/**
 * Add dashes transformation
 */
export class AddDashes extends StringManipulation {
    constructor() {
        super('add-dashes', 'Add-dashes-between-words');
    }

    execute(input) {
        return input.trim().replace(/\s+/g, '-');
    }
}

/**
 * Add underscores transformation
 */
export class AddUnderscores extends StringManipulation {
    constructor() {
        super('add-underscores', 'Add_underscores_between_words');
    }

    execute(input) {
        return input.trim().replace(/\s+/g, '_');
    }
}

/**
 * Add periods transformation
 */
export class AddPeriods extends StringManipulation {
    constructor() {
        super('add-periods', 'Add.periods.between.words');
    }

    execute(input) {
        return input.trim().replace(/\s+/g, '.');
    }
}

/**
 * Wrap text transformation
 */
export class WrapText extends StringManipulation {
    constructor() {
        super('wrap-text', 'Wrap text at specified width');
    }

    execute(input, options = {}) {
        const width = options.width || 80;
        const words = input.split(/\s+/);
        const lines = [];
        let currentLine = '';

        for (const word of words) {
            if (currentLine.length + word.length + 1 > width) {
                if (currentLine) lines.push(currentLine);
                currentLine = word;
            } else {
                currentLine = currentLine ? `${currentLine} ${word}` : word;
            }
        }
        if (currentLine) lines.push(currentLine);

        return lines.join('\n');
    }
}

/**
 * Truncate text transformation
 */
export class TruncateText extends StringManipulation {
    constructor() {
        super('truncate', 'Truncate text to specified length');
    }

    execute(input, options = {}) {
        const length = options.length || 100;
        const suffix = options.suffix || '...';
        
        if (input.length <= length) return input;
        
        return input.substring(0, length - suffix.length) + suffix;
    }
}

/**
 * Extract URLs transformation
 */
export class ExtractURLs extends StringManipulation {
    constructor() {
        super('extract-urls', 'Extract URLs from text');
    }

    execute(input) {
        const urlRegex = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/g;
        const urls = input.match(urlRegex) || [];
        return urls.join('\n');
    }
}

/**
 * Extract emails transformation
 */
export class ExtractEmails extends StringManipulation {
    constructor() {
        super('extract-emails', 'Extract email addresses from text');
    }

    execute(input) {
        const emailRegex = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/g;
        const emails = input.match(emailRegex) || [];
        return emails.join('\n');
    }
}

/**
 * Add prefix transformation
 */
export class AddPrefix extends StringManipulation {
    constructor() {
        super('add-prefix', 'Add prefix to each line');
    }

    execute(input, options = {}) {
        const prefix = options.prefix || '> ';
        return input.split('\n').map(line => prefix + line).join('\n');
    }
}

/**
 * Add suffix transformation
 */
export class AddSuffix extends StringManipulation {
    constructor() {
        super('add-suffix', 'Add suffix to each line');
    }

    execute(input, options = {}) {
        const suffix = options.suffix || ';';
        return input.split('\n').map(line => line + suffix).join('\n');
    }
}

/**
 * Remove line breaks transformation
 */
export class RemoveLineBreaks extends StringManipulation {
    constructor() {
        super('remove-line-breaks', 'Remove all line breaks from text');
    }

    execute(input) {
        return input.replace(/[\r\n]+/g, ' ').trim();
    }
}

/**
 * Word frequency transformation
 */
export class WordFrequency extends StringManipulation {
    constructor() {
        super('word-frequency', 'Count word frequency in text');
    }

    execute(input) {
        const words = input.toLowerCase().match(/\b[a-z]+\b/g) || [];
        const frequency = {};
        
        for (const word of words) {
            frequency[word] = (frequency[word] || 0) + 1;
        }
        
        const sorted = Object.entries(frequency)
            .sort((a, b) => b[1] - a[1])
            .map(([word, count]) => `${word}: ${count}`);
        
        return sorted.join('\n');
    }
}

// Export all transformations as an array
export const stringManipulationTransformations = [
    new ReverseText(),
    new RemoveSpaces(),
    new RemoveExtraSpaces(),
    new RemovePunctuation(),
    new ExtractLetters(),
    new ExtractNumbers(),
    new RemoveDuplicates(),
    new SortWords(),
    new ShuffleWords(),
    new AddDashes(),
    new AddUnderscores(),
    new AddPeriods(),
    new WrapText(),
    new TruncateText(),
    new ExtractURLs(),
    new ExtractEmails(),
    new AddPrefix(),
    new AddSuffix(),
    new RemoveLineBreaks(),
    new WordFrequency()
];

export default stringManipulationTransformations;
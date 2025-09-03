import { TransformationMethod, Validators } from './base.js';

/**
 * Base class for formatting transformations
 */
class FormattingTransformation extends TransformationMethod {
    constructor(name, description) {
        super(name, 'Text Formatting', description);
        this.addValidator(Validators.required);
    }
}

/**
 * JSON Format transformation
 */
export class JSONFormat extends FormattingTransformation {
    constructor() {
        super('json-format', 'Format JSON with indentation');
    }

    execute(input) {
        try {
            const parsed = JSON.parse(input);
            return JSON.stringify(parsed, null, 2);
        } catch (e) {
            throw new Error('Invalid JSON input');
        }
    }
}

/**
 * JSON Minify transformation
 */
export class JSONMinify extends FormattingTransformation {
    constructor() {
        super('json-minify', 'Minify JSON by removing whitespace');
    }

    execute(input) {
        try {
            const parsed = JSON.parse(input);
            return JSON.stringify(parsed);
        } catch (e) {
            throw new Error('Invalid JSON input');
        }
    }
}

/**
 * XML Format transformation
 */
export class XMLFormat extends FormattingTransformation {
    constructor() {
        super('xml-format', 'Format XML with indentation');
    }

    execute(input) {
        // Basic XML formatting
        let formatted = '';
        let indent = 0;
        const tab = '  ';
        
        // Remove existing formatting
        input = input.replace(/>\s*</g, '><').trim();
        
        // Split by tags
        const tags = input.split(/(<[^>]+>)/);
        
        for (let tag of tags) {
            if (!tag) continue;
            
            if (tag.startsWith('</')) {
                // Closing tag
                indent--;
                formatted += '\n' + tab.repeat(Math.max(0, indent)) + tag;
            } else if (tag.startsWith('<') && !tag.includes('/>')) {
                // Opening tag
                formatted += '\n' + tab.repeat(Math.max(0, indent)) + tag;
                if (!tag.startsWith('<?') && !tag.startsWith('<!')) {
                    indent++;
                }
            } else if (tag.includes('/>')) {
                // Self-closing tag
                formatted += '\n' + tab.repeat(Math.max(0, indent)) + tag;
            } else if (tag.trim()) {
                // Text content
                formatted += tag;
            }
        }
        
        return formatted.trim();
    }
}

/**
 * CSV to JSON transformation
 */
export class CSVToJSON extends FormattingTransformation {
    constructor() {
        super('csv-to-json', 'Convert CSV to JSON format');
    }

    execute(input, options = {}) {
        const delimiter = options.delimiter || ',';
        const lines = input.trim().split('\n');
        
        if (lines.length === 0) return '[]';
        
        // Parse headers
        const headers = this.parseCSVLine(lines[0], delimiter);
        const result = [];
        
        // Parse data rows
        for (let i = 1; i < lines.length; i++) {
            const values = this.parseCSVLine(lines[i], delimiter);
            if (values.length === headers.length) {
                const obj = {};
                headers.forEach((header, index) => {
                    obj[header] = values[index];
                });
                result.push(obj);
            }
        }
        
        return JSON.stringify(result, null, 2);
    }
    
    parseCSVLine(line, delimiter) {
        const result = [];
        let current = '';
        let inQuotes = false;
        
        for (let i = 0; i < line.length; i++) {
            const char = line[i];
            const nextChar = line[i + 1];
            
            if (char === '"') {
                if (inQuotes && nextChar === '"') {
                    current += '"';
                    i++;
                } else {
                    inQuotes = !inQuotes;
                }
            } else if (char === delimiter && !inQuotes) {
                result.push(current.trim());
                current = '';
            } else {
                current += char;
            }
        }
        
        result.push(current.trim());
        return result;
    }
}

/**
 * JSON to CSV transformation
 */
export class JSONToCSV extends FormattingTransformation {
    constructor() {
        super('json-to-csv', 'Convert JSON to CSV format');
    }

    execute(input) {
        try {
            const data = JSON.parse(input);
            
            if (!Array.isArray(data) || data.length === 0) {
                return '';
            }
            
            // Get headers from first object
            const headers = Object.keys(data[0]);
            const csv = [headers.join(',')];
            
            // Add data rows
            for (const row of data) {
                const values = headers.map(header => {
                    const value = row[header] || '';
                    // Quote values containing commas, quotes, or newlines
                    if (typeof value === 'string' && (value.includes(',') || value.includes('"') || value.includes('\n'))) {
                        return '"' + value.replace(/"/g, '""') + '"';
                    }
                    return value;
                });
                csv.push(values.join(','));
            }
            
            return csv.join('\n');
        } catch (e) {
            throw new Error('Invalid JSON input');
        }
    }
}

/**
 * Markdown to HTML transformation
 */
export class MarkdownToHTML extends FormattingTransformation {
    constructor() {
        super('markdown-to-html', 'Convert Markdown to HTML');
    }

    execute(input) {
        let html = input;
        
        // Headers
        html = html.replace(/^### (.*$)/gim, '<h3>$1</h3>');
        html = html.replace(/^## (.*$)/gim, '<h2>$1</h2>');
        html = html.replace(/^# (.*$)/gim, '<h1>$1</h1>');
        
        // Bold
        html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
        html = html.replace(/__(.+?)__/g, '<strong>$1</strong>');
        
        // Italic
        html = html.replace(/\*(.+?)\*/g, '<em>$1</em>');
        html = html.replace(/_(.+?)_/g, '<em>$1</em>');
        
        // Links
        html = html.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2">$1</a>');
        
        // Code blocks
        html = html.replace(/```([^`]+)```/g, '<pre><code>$1</code></pre>');
        
        // Inline code
        html = html.replace(/`([^`]+)`/g, '<code>$1</code>');
        
        // Line breaks
        html = html.replace(/\n\n/g, '</p><p>');
        html = '<p>' + html + '</p>';
        
        // Lists
        html = html.replace(/^\* (.+)$/gim, '<li>$1</li>');
        html = html.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
        
        return html;
    }
}

/**
 * SQL Format transformation
 */
export class SQLFormat extends FormattingTransformation {
    constructor() {
        super('sql-format', 'Format SQL queries');
    }

    execute(input) {
        const keywords = ['SELECT', 'FROM', 'WHERE', 'JOIN', 'LEFT JOIN', 'RIGHT JOIN', 
                         'INNER JOIN', 'ON', 'GROUP BY', 'ORDER BY', 'HAVING', 
                         'INSERT INTO', 'VALUES', 'UPDATE', 'SET', 'DELETE', 
                         'CREATE TABLE', 'ALTER TABLE', 'DROP TABLE', 'AND', 'OR'];
        
        let formatted = input;
        
        // Add newlines before keywords
        keywords.forEach(keyword => {
            const regex = new RegExp(`\\b${keyword}\\b`, 'gi');
            formatted = formatted.replace(regex, '\n' + keyword);
        });
        
        // Clean up multiple newlines
        formatted = formatted.replace(/\n+/g, '\n');
        
        // Indent subqueries
        formatted = formatted.split('\n').map(line => {
            const trimmed = line.trim();
            if (trimmed.startsWith('AND') || trimmed.startsWith('OR')) {
                return '  ' + trimmed;
            }
            return trimmed;
        }).join('\n');
        
        return formatted.trim();
    }
}

/**
 * CSS Format transformation
 */
export class CSSFormat extends FormattingTransformation {
    constructor() {
        super('css-format', 'Format CSS code');
    }

    execute(input) {
        // Remove existing formatting
        let formatted = input.replace(/\s+/g, ' ').trim();
        
        // Add newlines and indentation
        formatted = formatted.replace(/\{/g, ' {\n  ');
        formatted = formatted.replace(/\}/g, '\n}\n');
        formatted = formatted.replace(/;/g, ';\n  ');
        
        // Clean up
        formatted = formatted.replace(/\n\s*\n/g, '\n');
        formatted = formatted.replace(/\s*\n\}/g, '\n}');
        
        return formatted.trim();
    }
}

/**
 * CSS Minify transformation
 */
export class CSSMinify extends FormattingTransformation {
    constructor() {
        super('css-minify', 'Minify CSS by removing whitespace');
    }

    execute(input) {
        // Remove comments
        let minified = input.replace(/\/\*[\s\S]*?\*\//g, '');
        
        // Remove unnecessary whitespace
        minified = minified.replace(/\s+/g, ' ');
        minified = minified.replace(/\s*([{}:;,])\s*/g, '$1');
        
        // Remove trailing semicolon before closing brace
        minified = minified.replace(/;}/g, '}');
        
        return minified.trim();
    }
}

/**
 * JavaScript Beautify transformation
 */
export class JSBeautify extends FormattingTransformation {
    constructor() {
        super('js-beautify', 'Format JavaScript code');
    }

    execute(input) {
        // Basic JS formatting
        let formatted = input;
        
        // Add newlines after semicolons and braces
        formatted = formatted.replace(/;/g, ';\n');
        formatted = formatted.replace(/\{/g, ' {\n');
        formatted = formatted.replace(/\}/g, '\n}\n');
        
        // Indent based on brace depth
        const lines = formatted.split('\n');
        let indent = 0;
        const result = [];
        
        for (let line of lines) {
            const trimmed = line.trim();
            if (!trimmed) continue;
            
            if (trimmed.includes('}')) indent--;
            result.push('  '.repeat(Math.max(0, indent)) + trimmed);
            if (trimmed.includes('{')) indent++;
        }
        
        return result.join('\n');
    }
}

/**
 * HTML Format transformation
 */
export class HTMLFormat extends FormattingTransformation {
    constructor() {
        super('html-format', 'Format HTML with indentation');
    }

    execute(input) {
        // Similar to XML format but with HTML-specific handling
        let formatted = '';
        let indent = 0;
        const tab = '  ';
        const voidTags = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'];
        
        // Remove existing formatting
        input = input.replace(/>\s*</g, '><').trim();
        
        // Split by tags
        const tags = input.split(/(<[^>]+>)/);
        
        for (let tag of tags) {
            if (!tag) continue;
            
            const tagName = tag.match(/<\/?([a-zA-Z0-9]+)/);
            const isVoid = tagName && voidTags.includes(tagName[1].toLowerCase());
            
            if (tag.startsWith('</')) {
                // Closing tag
                indent--;
                formatted += '\n' + tab.repeat(Math.max(0, indent)) + tag;
            } else if (tag.startsWith('<') && !isVoid && !tag.includes('/>')) {
                // Opening tag
                formatted += '\n' + tab.repeat(Math.max(0, indent)) + tag;
                if (!tag.startsWith('<!')) {
                    indent++;
                }
            } else if (isVoid || tag.includes('/>')) {
                // Self-closing or void tag
                formatted += '\n' + tab.repeat(Math.max(0, indent)) + tag;
            } else if (tag.trim()) {
                // Text content
                formatted += tag.trim();
            }
        }
        
        return formatted.trim();
    }
}

/**
 * Number lines transformation
 */
export class NumberLines extends FormattingTransformation {
    constructor() {
        super('number-lines', 'Add line numbers to text');
    }

    execute(input) {
        const lines = input.split('\n');
        const width = String(lines.length).length;
        
        return lines.map((line, index) => {
            const lineNum = String(index + 1).padStart(width, ' ');
            return `${lineNum}: ${line}`;
        }).join('\n');
    }
}

/**
 * Sort lines transformation
 */
export class SortLines extends FormattingTransformation {
    constructor() {
        super('sort-lines', 'Sort lines alphabetically');
    }

    execute(input, options = {}) {
        const lines = input.split('\n');
        const reverse = options.reverse || false;
        
        lines.sort((a, b) => {
            const comparison = a.toLowerCase().localeCompare(b.toLowerCase());
            return reverse ? -comparison : comparison;
        });
        
        return lines.join('\n');
    }
}

/**
 * Remove empty lines transformation
 */
export class RemoveEmptyLines extends FormattingTransformation {
    constructor() {
        super('remove-empty-lines', 'Remove all empty lines');
    }

    execute(input) {
        return input.split('\n').filter(line => line.trim().length > 0).join('\n');
    }
}

// Export all transformations as an array
export const formattingTransformations = [
    new JSONFormat(),
    new JSONMinify(),
    new XMLFormat(),
    new CSVToJSON(),
    new JSONToCSV(),
    new MarkdownToHTML(),
    new SQLFormat(),
    new CSSFormat(),
    new CSSMinify(),
    new JSBeautify(),
    new HTMLFormat(),
    new NumberLines(),
    new SortLines(),
    new RemoveEmptyLines()
];

export default formattingTransformations;
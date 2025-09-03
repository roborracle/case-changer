/**
 * Base transformation class for all text transformation methods
 */
export class TransformationMethod {
    constructor(name, category, description) {
        this.name = name;
        this.category = category;
        this.description = description;
        this.validators = [];
        this.maxLength = 100000; // Default max length
    }

    /**
     * Add a validator function to this transformation
     */
    addValidator(validator) {
        this.validators.push(validator);
        return this;
    }

    /**
     * Validate input before transformation
     */
    validate(input) {
        // Check for null/undefined
        if (input === null || input === undefined) {
            return { valid: false, message: 'Input cannot be null or undefined' };
        }

        // Check max length
        if (input.length > this.maxLength) {
            return { valid: false, message: `Input exceeds maximum length of ${this.maxLength} characters` };
        }

        // Run custom validators
        for (const validator of this.validators) {
            const result = validator(input);
            if (!result.valid) return result;
        }

        return { valid: true };
    }

    /**
     * Transform input with validation
     */
    async transform(input, options = {}) {
        const validation = this.validate(input);
        if (!validation.valid) {
            throw new ValidationError(validation.message);
        }
        return this.execute(input, options);
    }

    /**
     * Execute the actual transformation (to be implemented by subclasses)
     */
    execute(input, options) {
        throw new Error('Method must be implemented by subclass');
    }

    /**
     * Get metadata about this transformation
     */
    getMetadata() {
        return {
            name: this.name,
            category: this.category,
            description: this.description,
            maxLength: this.maxLength
        };
    }
}

/**
 * Custom error class for validation errors
 */
export class ValidationError extends Error {
    constructor(message) {
        super(message);
        this.name = 'ValidationError';
    }
}

/**
 * Custom error class for transformation errors
 */
export class TransformationError extends Error {
    constructor(message) {
        super(message);
        this.name = 'TransformationError';
    }
}

/**
 * Common validators
 */
export const Validators = {
    required: (input) => {
        if (!input || input.trim().length === 0) {
            return { valid: false, message: 'Input is required' };
        }
        return { valid: true };
    },

    minLength: (min) => (input) => {
        if (input.length < min) {
            return { valid: false, message: `Input must be at least ${min} characters` };
        }
        return { valid: true };
    },

    maxLength: (max) => (input) => {
        if (input.length > max) {
            return { valid: false, message: `Input must not exceed ${max} characters` };
        }
        return { valid: true };
    },

    pattern: (regex, message) => (input) => {
        if (!regex.test(input)) {
            return { valid: false, message: message || 'Input does not match required pattern' };
        }
        return { valid: true };
    }
};
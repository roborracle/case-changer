/**
 * Registry for all transformation methods
 * Provides centralized access to all text transformations
 */
class TransformationRegistry {
    constructor() {
        this.methods = new Map();
        this.categories = new Map();
        this.aliases = new Map();
    }

    /**
     * Register a transformation method
     */
    register(method) {
        // Register the main method
        this.methods.set(method.name, method);
        
        // Add to category map
        if (!this.categories.has(method.category)) {
            this.categories.set(method.category, []);
        }
        this.categories.get(method.category).push(method);
        
        return this;
    }

    /**
     * Register an alias for a method
     */
    registerAlias(alias, methodName) {
        this.aliases.set(alias, methodName);
        return this;
    }

    /**
     * Get a method by name or alias
     */
    getMethod(name) {
        // Check if it's an alias
        if (this.aliases.has(name)) {
            name = this.aliases.get(name);
        }
        return this.methods.get(name);
    }

    /**
     * Check if a method exists
     */
    hasMethod(name) {
        return this.methods.has(name) || this.aliases.has(name);
    }

    /**
     * Get all methods in a category
     */
    getCategory(category) {
        return this.categories.get(category) || [];
    }

    /**
     * Get all category names
     */
    getAllCategories() {
        return Array.from(this.categories.keys());
    }

    /**
     * Get all method names
     */
    getAllMethods() {
        return Array.from(this.methods.keys());
    }

    /**
     * Get methods grouped by category
     */
    getGroupedMethods() {
        const grouped = {};
        for (const [category, methods] of this.categories) {
            grouped[category] = methods.map(m => ({
                name: m.name,
                description: m.description
            }));
        }
        return grouped;
    }

    /**
     * Search methods by keyword
     */
    searchMethods(keyword) {
        keyword = keyword.toLowerCase();
        const results = [];
        
        for (const [name, method] of this.methods) {
            if (name.toLowerCase().includes(keyword) ||
                method.description.toLowerCase().includes(keyword) ||
                method.category.toLowerCase().includes(keyword)) {
                results.push(method);
            }
        }
        
        return results;
    }

    /**
     * Transform text using a named method
     */
    async transform(methodName, input, options = {}) {
        const method = this.getMethod(methodName);
        if (!method) {
            throw new Error(`Transformation method '${methodName}' not found`);
        }
        return method.transform(input, options);
    }

    /**
     * Get statistics about registered methods
     */
    getStatistics() {
        return {
            totalMethods: this.methods.size,
            totalCategories: this.categories.size,
            totalAliases: this.aliases.size,
            categoryCounts: Object.fromEntries(
                Array.from(this.categories.entries()).map(([cat, methods]) => [cat, methods.length])
            )
        };
    }
}

// Create and export singleton instance
export const registry = new TransformationRegistry();

// Helper function to bulk register methods
export function registerMethods(methods) {
    for (const method of methods) {
        registry.register(method);
    }
}

// Helper function to register a single method with builder pattern
export function registerMethod(name, category, description) {
    return {
        withExecutor(executor) {
            const { TransformationMethod } = require('./base.js');
            
            class CustomMethod extends TransformationMethod {
                execute(input, options) {
                    return executor(input, options);
                }
            }
            
            const method = new CustomMethod(name, category, description);
            registry.register(method);
            return method;
        }
    };
}

export default registry;
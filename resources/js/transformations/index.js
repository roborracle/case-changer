/**
 * Main entry point for all text transformations
 * Exports registry with all registered transformation methods
 */

import { registry, registerMethods } from './registry.js';
import textCaseTransformations from './text-case.js';
import stringManipulationTransformations from './string-manipulation.js';
import encodingTransformations from './encoding.js';
import formattingTransformations from './formatting.js';
import textEffectTransformations from './text-effects.js';

// Register all transformation methods
registerMethods(textCaseTransformations);
registerMethods(stringManipulationTransformations);
registerMethods(encodingTransformations);
registerMethods(formattingTransformations);
registerMethods(textEffectTransformations);

// Create convenience functions for common operations
export const transform = (methodName, input, options) => {
    return registry.transform(methodName, input, options);
};

export const getMethod = (name) => {
    return registry.getMethod(name);
};

export const hasMethod = (name) => {
    return registry.hasMethod(name);
};

export const getCategory = (category) => {
    return registry.getCategory(category);
};

export const getAllCategories = () => {
    return registry.getAllCategories();
};

export const getAllMethods = () => {
    return registry.getAllMethods();
};

export const getGroupedMethods = () => {
    return registry.getGroupedMethods();
};

export const searchMethods = (keyword) => {
    return registry.searchMethods(keyword);
};

// Export the registry for direct access if needed
export { registry };

// Export individual category modules for tree-shaking
export { textCaseTransformations };
export { stringManipulationTransformations };
export { encodingTransformations };
export { formattingTransformations };
export { textEffectTransformations };

// Export transformation statistics
export const getStatistics = () => {
    return registry.getStatistics();
};

// Log statistics on load (for debugging)
if (typeof console !== 'undefined' && console.log) {
    const stats = getStatistics();
    console.log(`Text Transformations loaded: ${stats.totalMethods} methods across ${stats.totalCategories} categories`);
}

export default registry;
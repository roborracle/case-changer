// CRITICAL: Import theme-manager FIRST to apply theme immediately
// This MUST be the first import to minimize FOUC
import './theme-manager';

import './bootstrap';

// Import custom Alpine component
import themeToggle from './alpine/theme-toggle';

document.addEventListener('alpine:init', () => {
    Alpine.data('themeToggle', themeToggle)
})

import './glassmorphism-interactions';
import './whimsical-delights';

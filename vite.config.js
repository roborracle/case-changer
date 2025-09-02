import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/stimulus-app.js'  // Using Stimulus.js for CSP compliance
            ],
            refresh: true,
        }),
    ],
});

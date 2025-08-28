// Vite Performance Optimization Configuration
export default {
    // Build optimizations
    build: {
        // Enable minification
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.info']
            }
        },
        // Code splitting
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': [
                        'alpinejs',
                        '@alpinejs/persist'
                    ],
                    'navigation': [
                        './resources/js/navigation.js'
                    ]
                },
                // Asset naming for better caching
                assetFileNames: (assetInfo) => {
                    let extType = assetInfo.name.split('.').at(-1);
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
                        extType = 'img';
                    }
                    return `assets/${extType}/[name]-[hash][extname]`;
                },
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
            }
        },
        // Enable CSS code splitting
        cssCodeSplit: true,
        // Set chunk size warnings
        chunkSizeWarningLimit: 500,
        // Enable source maps for production debugging
        sourcemap: false,
        // Asset inlining threshold
        assetsInlineLimit: 4096,
        // Enable brotli compression
        reportCompressedSize: true,
    },
    // CSS optimizations
    css: {
        postcss: {
            plugins: [
                // Add autoprefixer for browser compatibility
                require('autoprefixer'),
                // Enable CSS purging for production
                require('@fullhuman/postcss-purgecss')({
                    content: [
                        './resources/**/*.blade.php',
                        './resources/**/*.js',
                        './resources/**/*.vue',
                    ],
                    defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
                    safelist: [
                        /^glass/,
                        /^theme/,
                        /^dark/,
                        /^light/,
                        /^system/,
                        'x-cloak',
                        /aria-/,
                        /data-/,
                        /^sr-only/,
                        /^focus/,
                    ]
                }),
                // Optimize CSS
                require('cssnano')({
                    preset: ['default', {
                        discardComments: {
                            removeAll: true,
                        },
                        normalizeWhitespace: false,
                    }]
                })
            ]
        }
    },
    // Server optimizations
    server: {
        hmr: {
            overlay: false
        },
        // Enable compression
        compress: true,
    },
    // Performance optimizations
    optimizeDeps: {
        include: ['alpinejs', '@alpinejs/persist'],
        exclude: []
    }
};
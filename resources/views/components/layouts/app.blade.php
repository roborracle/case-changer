@props(['title' => 'Case Changer Pro - 210+ Text Transformation Tools', 'description' => 'Transform text instantly with 210+ professional tools. Case conversions, developer formats, social media styles, and more. Free online text converter.', 'keywords' => 'text converter, case changer, text transformation, uppercase, lowercase, camelCase, snake_case, title case'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Theme initialization to prevent FOUC --}}
    <script nonce="{{ csp_nonce() }}">
        // Apply theme immediately to prevent flash
        (function() {
            const theme = localStorage.getItem('theme') || 'auto';
            const html = document.documentElement;
            
            if (theme === 'dark') {
                html.classList.add('dark');
            } else if (theme === 'auto') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    html.classList.add('dark');
                }
            }
        })();
    </script>
    
    <!-- SEO Meta Tags -->
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="Case Changer Pro">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#3b82f6">
    <meta name="msapplication-TileColor" content="#3b82f6">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Case Changer">
    <meta name="mobile-web-app-capable" content="yes">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- iOS PWA Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/icon-144x144.png">
    <link rel="apple-touch-icon" sizes="128x128" href="/images/icon-128x128.png">
    
    <!-- Standard Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icon-16x16.png">
    
    <!-- Microsoft Tile -->
    <meta name="msapplication-square150x150logo" content="/images/icon-152x152.png">
    <meta name="msapplication-square310x310logo" content="/images/icon-384x384.png">
    
    <!-- Bunny Fonts Optimization -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Schema.org Markup -->
    <?php 
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Case Changer Pro',
        'url' => url('/'),
        'description' => 'Professional text transformation tools with 210+ converters',
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => url('/search') . '?q={search_term_string}',
            'query-input' => 'required name=search_term_string'
        ]
    ];
    ?>
    <script type="application/ld+json" nonce="{{ csp_nonce() }}">
    {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES) !!}
    </script>
    
    @stack('schema')
    
    <!-- Styles -->
    {{-- Vite with CSP nonce support --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    
    {{-- Alpine.js stores and components initialization --}}
    <script nonce="{{ csp_nonce() }}">
        document.addEventListener('alpine:init', () => {
            // Theme store
            Alpine.store('theme', {
                theme: 'auto',
                transitioning: false,
                darkModeMediaQuery: null,

                init() {
                    // Get stored theme preference
                    this.theme = localStorage.getItem('theme') || 'auto';
                    
                    // Set up media query listener for auto mode
                    this.darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
                    this.darkModeMediaQuery.addEventListener('change', (e) => {
                        if (this.theme === 'auto') {
                            this.applyTheme();
                        }
                    });

                    // Apply theme without transition on init
                    this.applyTheme(false);
                },

                setTheme(newTheme) {
                    if (this.theme === newTheme) return;
                    
                    // Start transition
                    this.transitioning = true;
                    
                    setTimeout(() => {
                        this.theme = newTheme;
                        localStorage.setItem('theme', newTheme);
                        this.applyTheme();
                        
                        // End transition after theme is applied
                        setTimeout(() => {
                            this.transitioning = false;
                        }, 150);
                    }, 150);
                },

                applyTheme(animate = true) {
                    const html = document.documentElement;
                    
                    // Remove existing theme class
                    html.classList.remove('dark');
                    
                    // Determine which theme to apply
                    let shouldBeDark = false;
                    
                    if (this.theme === 'dark') {
                        shouldBeDark = true;
                    } else if (this.theme === 'auto') {
                        shouldBeDark = this.darkModeMediaQuery.matches;
                    }
                    
                    // Apply theme class
                    if (shouldBeDark) {
                        html.classList.add('dark');
                    }
                }
            });
            
            // Primary tabs component
            Alpine.data('primaryTabs', (initialTab) => ({
                activeTab: initialTab || 'title-case',
                tabs: [],
                
                init() {
                    // Get all tab buttons
                    this.tabs = Array.from(this.$el.querySelectorAll('[role="tab"]')).map(tab => {
                        return tab.getAttribute('data-tab-id');
                    });
                    
                    // Set initial focus
                    if (this.activeTab) {
                        const activeButton = this.$refs[`tab-${this.activeTab}`];
                        if (activeButton) {
                            activeButton.focus();
                        }
                    }
                },
                
                selectTab(tabId) {
                    this.activeTab = tabId;
                    
                    // Update focus
                    const tabButton = this.$refs[`tab-${tabId}`];
                    if (tabButton) {
                        tabButton.focus();
                    }
                    
                    // Dispatch event for other components to listen to
                    this.$dispatch('tab-changed', { tabId });
                },
                
                nextTab() {
                    const currentIndex = this.tabs.indexOf(this.activeTab);
                    const nextIndex = (currentIndex + 1) % this.tabs.length;
                    this.selectTab(this.tabs[nextIndex]);
                },
                
                previousTab() {
                    const currentIndex = this.tabs.indexOf(this.activeTab);
                    const prevIndex = currentIndex === 0 ? this.tabs.length - 1 : currentIndex - 1;
                    this.selectTab(this.tabs[prevIndex]);
                },
                
                firstTab() {
                    this.selectTab(this.tabs[0]);
                },
                
                lastTab() {
                    this.selectTab(this.tabs[this.tabs.length - 1]);
                }
            }));
            
            // Style guide selector component
            Alpine.data('styleGuideSelector', () => ({
                selectedStyle: 'general',
                showTooltip: false,
                styleDescription: '',
                
                styleGuides: {
                    general: {
                        description: 'Standard title case: capitalizes first and last words, and all major words',
                        rules: {
                            smallWords: ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'in', 'nor', 'of', 'on', 'or', 'so', 'the', 'to', 'up', 'yet']
                        }
                    },
                    ap: {
                        description: 'AP Style: capitalizes principal words, including prepositions and conjunctions of four or more letters',
                        rules: {
                            smallWords: ['a', 'an', 'and', 'at', 'but', 'by', 'for', 'in', 'nor', 'of', 'on', 'or', 'so', 'the', 'to', 'up', 'yet'],
                            minWordLength: 4
                        }
                    },
                    chicago: {
                        description: 'Chicago Style: capitalizes first and last words, nouns, pronouns, verbs, adjectives, adverbs, and some conjunctions',
                        rules: {
                            smallWords: ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'in', 'nor', 'of', 'on', 'or', 'so', 'the', 'to', 'yet'],
                            alwaysCapitalize: ['is', 'are', 'was', 'were', 'be', 'been', 'being']
                        }
                    },
                    mla: {
                        description: 'MLA Style: similar to Chicago but with specific rules for hyphenated compounds',
                        rules: {
                            smallWords: ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'in', 'nor', 'of', 'on', 'or', 'so', 'the', 'to'],
                            hyphenatedCompounds: true
                        }
                    },
                    apa: {
                        description: 'APA Style: capitalizes major words of four letters or more',
                        rules: {
                            smallWords: ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'in', 'of', 'on', 'or', 'the', 'to'],
                            minWordLength: 4
                        }
                    },
                    ieee: {
                        description: 'IEEE Style: capitalizes all major words including short verbs',
                        rules: {
                            smallWords: ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'from', 'in', 'into', 'nor', 'of', 'on', 'or', 'the', 'to', 'with'],
                            alwaysCapitalize: ['is', 'are', 'was', 'were', 'be', 'been']
                        }
                    }
                },
                
                init() {
                    // Load saved preference
                    const saved = localStorage.getItem('titleCaseStyle');
                    if (saved && this.styleGuides[saved]) {
                        this.selectedStyle = saved;
                    }
                    
                    // Set initial description
                    this.updateDescription();
                },
                
                handleStyleChange() {
                    // Save preference
                    localStorage.setItem('titleCaseStyle', this.selectedStyle);
                    
                    // Update description
                    this.updateDescription();
                    
                    // Dispatch event for transformation service
                    this.$dispatch('style-guide-changed', { 
                        style: this.selectedStyle,
                        rules: this.styleGuides[this.selectedStyle].rules
                    });
                },
                
                updateDescription() {
                    this.styleDescription = this.styleGuides[this.selectedStyle].description;
                },
                
                applyTitleCase(text, style = 'general') {
                    const guide = this.styleGuides[style];
                    const words = text.split(/\s+/);
                    
                    return words.map((word, index) => {
                        // Always capitalize first and last word
                        if (index === 0 || index === words.length - 1) {
                            return this.capitalizeWord(word);
                        }
                        
                        // Check if word is in small words list
                        const lowerWord = word.toLowerCase();
                        if (guide.rules.smallWords.includes(lowerWord)) {
                            // Check minimum word length rule
                            if (guide.rules.minWordLength && lowerWord.length >= guide.rules.minWordLength) {
                                return this.capitalizeWord(word);
                            }
                            return lowerWord;
                        }
                        
                        // Check always capitalize list
                        if (guide.rules.alwaysCapitalize && guide.rules.alwaysCapitalize.includes(lowerWord)) {
                            return this.capitalizeWord(word);
                        }
                        
                        // Handle hyphenated compounds
                        if (guide.rules.hyphenatedCompounds && word.includes('-')) {
                            return word.split('-').map(part => this.capitalizeWord(part)).join('-');
                        }
                        
                        // Default: capitalize the word
                        return this.capitalizeWord(word);
                    }).join(' ');
                },
                
                capitalizeWord(word) {
                    if (!word) return word;
                    return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
                }
            }));
            
            // Auto-resize textarea component
            Alpine.data('autoResizeTextarea', () => ({
                text: '',
                monospace: false,
                characterCount: 0,
                wordCount: 0,
                lineCount: 1,
                minHeight: 0,
                maxHeight: 0,
                currentHeight: 0,
                minRows: 4,
                maxRows: 20,
                
                init() {
                    // Load preferences from localStorage
                    this.monospace = localStorage.getItem('textarea-monospace') === 'true';
                    
                    // Calculate heights based on rows
                    const lineHeight = 24; // Approximate line height in pixels
                    const padding = 32; // Top and bottom padding
                    this.minHeight = (this.minRows * lineHeight) + padding;
                    this.maxHeight = (this.maxRows * lineHeight) + padding;
                    this.currentHeight = this.minHeight;
                    
                    // Set initial text if provided via wire:model
                    this.$nextTick(() => {
                        if (this.$refs.textarea.value) {
                            this.text = this.$refs.textarea.value;
                            this.updateStats();
                            this.resize();
                        }
                    });
                },
                
                handleInput() {
                    this.updateStats();
                    this.resize();
                    
                    // Dispatch custom event for other components
                    this.$dispatch('textarea-changed', { 
                        text: this.text,
                        stats: {
                            characters: this.characterCount,
                            words: this.wordCount,
                            lines: this.lineCount
                        }
                    });
                },
                
                handlePaste(event) {
                    // Allow paste to proceed normally
                    this.$nextTick(() => {
                        this.updateStats();
                        this.resize();
                    });
                },
                
                updateStats() {
                    this.characterCount = this.text.length;
                    this.wordCount = this.text.trim() === '' ? 0 : this.text.trim().split(/\s+/).length;
                    this.lineCount = this.text.split('\n').length;
                },
                
                resize() {
                    const textarea = this.$refs.textarea;
                    
                    // Reset height to recalculate
                    textarea.style.height = 'auto';
                    
                    // Calculate new height
                    let newHeight = textarea.scrollHeight;
                    
                    // Constrain between min and max
                    newHeight = Math.max(this.minHeight, Math.min(this.maxHeight, newHeight));
                    
                    // Apply smooth transition
                    this.currentHeight = newHeight;
                },
                
                toggleMonospace() {
                    this.monospace = !this.monospace;
                    localStorage.setItem('textarea-monospace', this.monospace);
                },
                
                clearText() {
                    if (confirm('Are you sure you want to clear all text?')) {
                        this.text = '';
                        this.updateStats();
                        this.resize();
                        
                        // Trigger wire:model update if using Livewire
                        if (this.$refs.textarea.hasAttribute('wire:model')) {
                            this.$refs.textarea.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    }
                }
            }));
            
            // Converter main component
            Alpine.data('converterMain', () => ({
                activeTab: 'title-case',
                activeTransformation: 'title-case', 
                showStyleGuide: true,
                
                init() {
                    // Listen for tab changes
                    this.$watch('activeTab', (value) => {
                        this.activeTransformation = value;
                        this.showStyleGuide = value === 'title-case';
                    });
                    
                    // Listen for tab-changed event from primary-tabs
                    this.$el.addEventListener('tab-changed', (e) => {
                        this.activeTab = e.detail.tabId;
                    });
                }
            }));
        });
    </script>
</head>
<body class="min-h-screen bg-secondary text-primary">
    <!-- Skip to main content link for keyboard navigation -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        Skip to main content
    </a>
    
    {{-- Theme Toggle Component --}}
    @include('components.theme-toggle')
    
    {{-- Global Keyboard Shortcuts --}}
    @include('components.keyboard-shortcuts')
    
    <header>
        @livewire('navigation')
    </header>
    
    <main id="main-content" tabindex="-1">
        {{ $slot }}
    </main>
    
    <footer>
        @includeIf('components.footer')
    </footer>
    
    <!-- Service Worker Registration -->
    <script nonce="{{ csp_nonce() }}">
        // Service Worker Registration for PWA support
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', async () => {
                try {
                    const registration = await navigator.serviceWorker.register('/sw.js', {
                        scope: '/'
                    });
                    
                    console.log('SW registered successfully:', registration);
                    
                    // Listen for SW updates
                    registration.addEventListener('updatefound', () => {
                        const newWorker = registration.installing;
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                // Show update available notification
                                if (window.showToast) {
                                    window.showToast('App update available! Refresh to get the latest features.', 'info');
                                }
                            }
                        });
                    });
                    
                    // Listen for messages from SW
                    navigator.serviceWorker.addEventListener('message', event => {
                        const { type, message } = event.data;
                        
                        switch (type) {
                            case 'SW_ACTIVATED':
                                if (window.showToast) {
                                    window.showToast(message, 'success');
                                }
                                break;
                                
                            case 'CACHE_UPDATED':
                                console.log('Cache updated:', message);
                                break;
                                
                            default:
                                console.log('SW message:', event.data);
                        }
                    });
                    
                } catch (error) {
                    console.log('SW registration failed:', error);
                }
                
                // Online/Offline status handling
                const updateOnlineStatus = () => {
                    if (navigator.onLine) {
                        document.body.classList.remove('offline');
                        if (window.Livewire) {
                            window.Livewire.dispatch('onlineStatusChanged', { online: true });
                        }
                    } else {
                        document.body.classList.add('offline');
                        if (window.Livewire) {
                            window.Livewire.dispatch('onlineStatusChanged', { online: false });
                        }
                        if (window.showToast) {
                            window.showToast('You are now offline. Limited functionality available.', 'warning');
                        }
                    }
                };
                
                window.addEventListener('online', updateOnlineStatus);
                window.addEventListener('offline', updateOnlineStatus);
                updateOnlineStatus();
            });
        }
        
        // PWA Install Prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button or banner
            const installButton = document.getElementById('pwa-install-button');
            if (installButton) {
                installButton.style.display = 'block';
                installButton.addEventListener('click', () => {
                    installButton.style.display = 'none';
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the PWA install prompt');
                            if (window.showToast) {
                                window.showToast('App installed successfully!', 'success');
                            }
                        }
                        deferredPrompt = null;
                    });
                });
            }
        });
        
        // Auto-save functionality
        let autoSaveTimer;
        const AUTO_SAVE_INTERVAL = 5000; // 5 seconds
        
        // Listen for auto-save events from Livewire
        document.addEventListener('livewire:init', () => {
            // Auto-save on input changes
            let inputChangeTimeout;
            const autoSaveInputs = document.querySelectorAll('[wire\\:model*="inputText"]');
            
            autoSaveInputs.forEach(input => {
                input.addEventListener('input', () => {
                    clearTimeout(inputChangeTimeout);
                    inputChangeTimeout = setTimeout(() => {
                        const data = {
                            inputText: input.value,
                            timestamp: Date.now(),
                            url: window.location.href
                        };
                        localStorage.setItem('case-changer-autosave', JSON.stringify(data));
                    }, 1000); // Save 1 second after user stops typing
                });
            });
            
            // Load auto-save data on page load
            const autoSaveData = localStorage.getItem('case-changer-autosave');
            if (autoSaveData) {
                try {
                    const data = JSON.parse(autoSaveData);
                    const timeDiff = Date.now() - data.timestamp;
                    
                    // Only restore if data is less than 1 hour old and from same page
                    if (timeDiff < 3600000 && data.url === window.location.href && data.inputText) {
                        if (confirm('Restore your previous session?')) {
                            window.Livewire.dispatch('loadFromAutoSave', data);
                        }
                    }
                } catch (e) {
                    console.log('Error parsing auto-save data:', e);
                }
            }
        });
        
        // Haptic feedback support
        window.triggerHaptic = (type = 'light') => {
            if ('vibrate' in navigator) {
                const patterns = {
                    light: [10],
                    medium: [20],
                    heavy: [30],
                    success: [10, 50, 10],
                    error: [100, 50, 100],
                    notification: [10, 10, 10]
                };
                navigator.vibrate(patterns[type] || patterns.light);
            }
        };
        
        // Sound effects support
        window.playSound = (type = 'success') => {
            if ('Audio' in window) {
                const sounds = {
                    success: '/sounds/success.mp3',
                    error: '/sounds/error.mp3',
                    click: '/sounds/click.mp3',
                    notification: '/sounds/notification.mp3'
                };
                
                if (sounds[type]) {
                    const audio = new Audio(sounds[type]);
                    audio.volume = 0.3;
                    audio.play().catch(() => {
                        // Ignore autoplay restrictions
                    });
                }
            }
        };
        
        // Global toast function for backwards compatibility
        window.showToast = (message, type = 'info') => {
            if (window.Livewire) {
                window.Livewire.dispatch('show-toast', { message, type });
            } else {
                console.log(`Toast [${type}]:`, message);
            }
        };
        
        // Enhanced offline/online indicator
        const createOfflineIndicator = () => {
            const indicator = document.createElement('div');
            indicator.id = 'offline-indicator';
            indicator.innerHTML = `
                <div class="offline-banner">
                    <span class="offline-icon">📶</span>
                    <span class="offline-text">You are offline</span>
                </div>
            `;
            indicator.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background: #f59e0b;
                color: white;
                text-align: center;
                padding: 8px;
                z-index: 9999;
                transform: translateY(-100%);
                transition: transform 0.3s ease;
                font-family: system-ui, -apple-system, sans-serif;
                font-size: 14px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            `;
            document.body.appendChild(indicator);
            
            const updateIndicator = () => {
                if (!navigator.onLine) {
                    indicator.style.transform = 'translateY(0)';
                    document.body.style.paddingTop = indicator.offsetHeight + 'px';
                } else {
                    indicator.style.transform = 'translateY(-100%)';
                    document.body.style.paddingTop = '0';
                }
            };
            
            window.addEventListener('online', updateIndicator);
            window.addEventListener('offline', updateIndicator);
            updateIndicator();
        };
        
        // Create offline indicator on load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createOfflineIndicator);
        } else {
            createOfflineIndicator();
        }
    </script>
    
    @stack('scripts')
</body>
</html>

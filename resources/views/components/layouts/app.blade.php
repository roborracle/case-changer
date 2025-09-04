@props(['title' => 'Case Changer Pro - 210+ Text Transformation Tools', 'description' => 'Transform text instantly with 210+ professional tools. Case conversions, developer formats, social media styles, and more. Free online text converter.', 'keywords' => 'text converter, case changer, text transformation, uppercase, lowercase, camelCase, snake_case, title case'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $themeClass ?? 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
</head>
<body class="min-h-screen bg-secondary text-primary">
    <!-- Skip to main content link for keyboard navigation -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        Skip to main content
    </a>
    
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

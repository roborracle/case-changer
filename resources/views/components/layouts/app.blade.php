<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Case Changer - Professional text transformation tool with multiple case styles, style guide formatting (APA, MLA, Chicago, etc.), and advanced text processing features.">
    
    <title>{{ $title ?? 'Case Changer - Professional Text Transformation Tool' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="h-full bg-gray-50 text-gray-900 antialiased">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md">
        Skip to main content
    </a>

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900">
                        <span class="text-blue-600">Case</span>Changer
                    </h1>
                    <span class="ml-3 text-sm text-gray-500">Professional Text Transformer</span>
                </div>

                <!-- Navigation (if needed in future) -->
                <nav class="hidden md:flex space-x-8" aria-label="Main navigation">
                    <a href="#" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">
                        Home
                    </a>
                    <a href="#features" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">
                        Features
                    </a>
                    <a href="#style-guides" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">
                        Style Guides
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="flex-1">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-gray-500 mb-4 md:mb-0">
                    © {{ date('Y') }} Case Changer. Built with Laravel TALL Stack.
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors">
                        Privacy Policy
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors">
                        Terms of Service
                    </a>
                    <a href="https://github.com/yourusername/case-changer" class="text-gray-500 hover:text-blue-600 transition-colors">
                        GitHub
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notifications Container -->
    <div id="toast-container" 
         class="fixed bottom-4 right-4 z-50 space-y-2"
         x-data="{ toasts: [] }"
         @toast.window="
            toasts.push($event.detail);
            setTimeout(() => toasts.shift(), 5000);
         ">
        <template x-for="(toast, index) in toasts" :key="index">
            <div x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <template x-if="toast.type === 'success'">
                                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </template>
                            <template x-if="toast.type === 'error'">
                                <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </template>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900" x-text="toast.message"></p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Copy to clipboard functionality -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('copy-to-clipboard', (event) => {
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(event.text).then(() => {
                        console.log('Text copied to clipboard');
                    }).catch(err => {
                        console.error('Failed to copy text: ', err);
                    });
                } else {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = event.text;
                    document.body.appendChild(textArea);
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        console.log('Text copied to clipboard (fallback)');
                    } catch (err) {
                        console.error('Failed to copy text (fallback): ', err);
                    }
                    document.body.removeChild(textArea);
                }
            });
            
            Livewire.on('reset-copied', () => {
                setTimeout(() => {
                    Livewire.dispatch('reset-copied-state');
                }, 2000);
            });
        });
    </script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
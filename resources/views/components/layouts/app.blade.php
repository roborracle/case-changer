<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full {{ $themeClass ?? 'light' }}">
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

        @if(isset($schemaData))
        <script type="application/ld+json">
            {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
        @endif
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

        <!-- Additional Scripts -->
        @stack('scripts')
    </body>
</html>

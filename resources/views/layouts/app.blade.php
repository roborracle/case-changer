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
<body class="h-full text-gray-900 antialiased smooth-rendering" style="background: linear-gradient(135deg, var(--neutral-50) 0%, var(--neutral-100) 100%);">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md">
        Skip to main content
    </a>

    <!-- Revolutionary Navigation (Minimal) -->
    <nav class="blur-glass" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000; backdrop-filter: blur(12px); background: rgba(255, 255, 255, 0.8); border-bottom: 1px solid var(--neutral-200);">
        <div style="max-width: 1400px; margin: 0 auto; padding: var(--space-md) var(--space-xl);">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <h1 class="text-gradient" style="font-size: var(--type-scale-lg); font-weight: 700; margin: 0;">
                        Case Changer Pro
                    </h1>
                </div>
                <div style="font-size: var(--type-scale-sm); color: var(--neutral-500);">
                    Revolutionary Text Transformation
                </div>
            </div>
        </div>
    </nav>

    <!-- Revolutionary Main Content -->
    <main id="main-content" class="flex-1" style="padding-top: 80px;">
        {{ $slot }}
    </main>

    <!-- Revolutionary Footer -->
    <footer class="blur-glass" style="background: rgba(255, 255, 255, 0.6); border-top: 1px solid var(--neutral-200); margin-top: var(--space-3xl);">
        <div style="max-width: 1400px; margin: 0 auto; padding: var(--space-xl);">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div style="font-size: var(--type-scale-sm); color: var(--neutral-500);">
                    © {{ date('Y') }} Case Changer Pro. Revolutionary interface design.
                </div>
                <div class="flex gap-6" style="font-size: var(--type-scale-sm);">
                    <a href="#" style="color: var(--neutral-500); transition: color 200ms; text-decoration: none;" 
                       onmouseover="this.style.color='var(--accent-primary)'" 
                       onmouseout="this.style.color='var(--neutral-500)'">
                        Privacy
                    </a>
                    <a href="#" style="color: var(--neutral-500); transition: color 200ms; text-decoration: none;"
                       onmouseover="this.style.color='var(--accent-primary)'" 
                       onmouseout="this.style.color='var(--neutral-500)'">
                        Terms
                    </a>
                    <a href="#" style="color: var(--neutral-500); transition: color 200ms; text-decoration: none;"
                       onmouseover="this.style.color='var(--accent-primary)'" 
                       onmouseout="this.style.color='var(--neutral-500)'">
                        GitHub
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Revolutionary Toast System (handled in component) -->

    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>

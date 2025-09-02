<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full {{ $themeClass ?? 'light' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Case Changer Pro - Professional text transformation tool with 45+ case styles, 16 style guides, and smart preservation features.">
        <meta name="keywords" content="text case converter, title case, camel case, snake case, text transformation, style guides">
        <meta name="author" content="Case Changer Pro">
        
        <!-- Performance & SEO Meta -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ url()->current() }}">
        
        <!-- Open Graph -->
        <meta property="og:title" content="{{ $title ?? 'Case Changer Pro - Professional Text Transformation Tool' }}">
        <meta property="og:description" content="Transform text into 170+ formats instantly. Support for developer formats, style guides, and creative text styles.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        
        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? 'Case Changer Pro' }}">
        <meta name="twitter:description" content="Professional text transformation tool with 170+ formats">

        <title>{{ $title ?? 'Case Changer Pro - Professional Text Transformation Tool' }}</title>

        <!-- Preconnect for Performance -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        
        <!-- Fonts with Display Swap for Better Performance -->
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Critical CSS (inline for performance) -->
        <style nonce="{{ csp_nonce() }}">
            /* Critical CSS for above-the-fold content */
            .h-full { height: 100%; }
            .min-h-screen { min-height: 100vh; }
            .antialiased { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
            body { margin: 0; font-family: 'Inter', system-ui, sans-serif; }
            [x-cloak] { display: none !important; }
            
            /* Loading skeleton styles */
            .skeleton { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: loading 1.5s infinite; }
            @keyframes loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        </style>

        <!-- Styles with Preload for Performance -->
        @vite(['resources/css/app.css', 'resources/js/stimulus-app.js'])
        
        <!-- Structured Data -->
        @if(isset($schemaData))
        <script type="application/ld+json" nonce="{{ csp_nonce() }}">
            {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
        @endif
    </head>
    <body class="h-full antialiased bg-secondary text-primary">
        
        <!-- Skip to Main Content Link for Accessibility -->
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded">
            Skip to main content
        </a>

        <!-- Main Content with Proper Landmark -->
        <main id="main-content" class="min-h-screen" role="main">
            {{ $slot }}
        </main>

        <!-- Additional Scripts -->
        @stack('scripts')
        
        <!-- Noscript Fallback -->
        <noscript>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                <p>JavaScript is required for the full functionality of this application. Please enable JavaScript to continue.</p>
            </div>
        </noscript>
    </body>
</html>
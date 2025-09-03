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
    
    <!-- Google Fonts Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Schema.org Markup -->
    <script type="application/ld+json" nonce="{{ csp_nonce() }}">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Case Changer Pro",
        "url": "{{ url('/') }}",
        "description": "Professional text transformation tools with 210+ converters",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/search') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    
    @stack('schema')
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'], '', ['nonce' => csp_nonce()])
    @stack('styles')
</head>
<body class="min-h-screen bg-secondary text-primary flex flex-col">
    <!-- Skip to main content link for keyboard navigation -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        Skip to main content
    </a>
    
    <header>
        <nav class="bg-primary shadow-sm" aria-label="Main navigation">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="text-2xl font-bold text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">Case Changer Pro</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <main id="main-content" tabindex="-1" class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{ $slot }}
        </div>
    </main>
    
    <footer class="bg-primary border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-secondary">
                <p>&copy; {{ date('Y') }} Case Changer Pro. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>
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
    
    @livewireScripts
    @stack('scripts')
</body>
</html>

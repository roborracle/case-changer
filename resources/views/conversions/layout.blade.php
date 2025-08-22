<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Case Changer Pro - Text Transformation Tools')</title>
    <meta name="description" content="@yield('description', 'Professional text transformation tools for developers, writers, and content creators')">
    <meta name="keywords" content="@yield('keywords', 'text converter, case converter, text transformation')">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', 'Case Changer Pro')">
    <meta property="og:description" content="@yield('og_description', 'Professional text transformation tools')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Schema.org markup -->
    <script type="application/ld+json">
    @yield('schema', json_encode([
        "@context" => "https://schema.org",
        "@type" => "WebApplication",
        "name" => "Case Changer Pro",
        "applicationCategory" => "UtilityApplication",
        "operatingSystem" => "Any",
        "offers" => [
            "@type" => "Offer",
            "price" => "0",
            "priceCurrency" => "USD"
        ]
    ]))
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Navigation -->
    @include('components.navigation')

    <!-- Breadcrumbs -->
    @hasSection('breadcrumbs')
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="/" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                        </a>
                    </li>
                    @yield('breadcrumbs')
                </ol>
            </nav>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    @livewireScripts
    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $themeClass ?? 'light' }}">
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
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    @if(isset($schemaData))
    <script type="application/ld+json">
    {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif
</head>
<body class="min-h-screen" style="background-color: var(--bg-secondary);">
    <!-- Navigation -->
    @include('components.navigation')

    <!-- Breadcrumbs -->
    @hasSection('breadcrumbs')
    <div class="border-b" style="background-color: var(--bg-primary); border-color: var(--border-primary);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="/" style="color: var(--text-secondary);" onmouseover="this.style.color = 'var(--text-primary)';" onmouseout="this.style.color = 'var(--text-secondary)';">
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
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $themeClass ?? 'light' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Case Changer Pro - Text Transformation Tools')</title>
        <meta name="description" content="@yield('description', 'Professional text transformation tools for developers, writers, and content creators')">
        <meta name="keywords" content="@yield('keywords', 'text converter, case converter, text transformation')">

        <!-- Open Graph -->
        <meta property="og:title" content="@yield('og_title', 'Case Changer Pro')">
        <meta property="og:description" content="@yield('og_description', 'Professional text transformation tools')">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if(isset($schemaData))
        <script type="application/ld+json">
            {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
        @endif

        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y3D0SMK2BM"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-Y3D0SMK2BM');
        </script>
    </head>
    <body class="min-h-screen bg-secondary" >
        <!-- Navigation -->
        @include('components.navigation-alpine')

        <!-- Breadcrumbs -->
        @hasSection('breadcrumbs')
        <div class="border-b bg-primary" >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                        <a href="/">
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

        @stack('scripts')
    </body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Case Changer Pro - Professional text transformation tool with 45+ case styles, 16 style guides, and smart preservation features.">
    
    <title>{{ $title ?? 'Case Changer Pro - Professional Text Transformation Tool' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="h-full bg-gray-50 text-gray-900 antialiased">
    <!-- Main Content -->
    <main id="main-content" class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Functional JavaScript -->
    <script src="{{ asset('js/whimsical-delights.js') }}"></script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
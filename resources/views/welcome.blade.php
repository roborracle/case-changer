<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Case Changer Pro - Professional Text Transformation Suite</title>
        <meta name="description" content="Professional text transformation suite with 172 conversion tools across 18 specialized categories for developers, writers, academics, and content creators">
        <meta name="keywords" content="text converter, case converter, text transformation, uppercase, lowercase, camelCase, snake_case, title case">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if(isset($schemaData))
        <script type="application/ld+json">
            {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
        @endif
    </head>
    <body class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-sky-900">
        <div class="min-h-screen flex items-center justify-center p-8">
            <div class="max-w-4xl w-full">
                <div class="text-center mb-12">
                    <h1 class="text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-400 to-sky-400 mb-4">
                    Case Changer Pro
                    </h1>
                    <p class="text-xl text-gray-300">Choose Your Interface Experience</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Modern Interface -->
                    <a href="{{ route('modern-case-changer') }}" class="group">
                    <div class="bg-gray-900/50 backdrop-blur-xl rounded-2xl border border-blue-500/30 p-8 transition-all duration-300 hover:border-blue-400 hover:bg-gray-900/70 hover:transform hover:scale-105">
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 text-xs font-medium bg-blue-600/20 text-blue-300 rounded-full border border-blue-500/30">
                            Recommended
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-3">Modern Interface</h2>
                        <p class="text-gray-400 mb-6">
                        Single-area design with command palette, contextual suggestions, and keyboard-first workflow. The future of text transformation.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            In-place transformation
                            </li>
                            <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Command palette (⌘K)
                            </li>
                            <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Smart suggestions
                            </li>
                            <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Visual previews
                            </li>
                        </ul>
                        <div class="mt-6 flex items-center text-blue-400 group-hover:text-blue-300">
                            <span class="text-sm font-medium">Launch Modern Interface</span>
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                    </a>

                    <!-- Classic Interface -->
                    <a href="{{ route('case-changer') }}" class="group">
                    <div class="bg-gray-900/50 backdrop-blur-xl rounded-2xl border border-gray-700/50 p-8 transition-all duration-300 hover:border-gray-600 hover:bg-gray-900/70 hover:transform hover:scale-105">
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 text-xs font-medium bg-gray-700/20 text-gray-400 rounded-full border border-gray-600/30">
                            Classic
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-3">Traditional Interface</h2>
                        <p class="text-gray-400 mb-6">
                        Familiar two-panel layout with comprehensive transformation options and advanced preservation settings.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            45+ transformations
                            </li>
                            <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            16 style guides
                            </li>
                            <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Smart preservation
                            </li>
                            <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            History management
                            </li>
                        </ul>
                        <div class="mt-6 flex items-center text-gray-400 group-hover:text-gray-300">
                            <span class="text-sm font-medium">Launch Classic Interface</span>
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                    </a>
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('conversions.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-sky-600 text-white rounded-lg hover:from-blue-700 hover:to-sky-700 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Browse All Conversion Tools
                    </a>
                    <p class="text-sm text-gray-500 mt-4">
                    Professional Text Transformation Tool • © 2025
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
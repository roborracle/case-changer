<x-layouts.app title="Case Changer Pro - 210+ Text Transformation Tools">
    <!-- Hero Section -->
    <section class="py-8 bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-4 text-gray-900 dark:text-white">
                    Case Changer Pro
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Transform text instantly with 210+ professional tools. Type or paste your text below and click any button to transform.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Converter Section -->
    <section class="py-8 bg-gradient-to-b from-white to-gray-50 dark:from-gray-800 dark:to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Premium Converter with Enhanced Features -->
            <div class="backdrop-blur-lg bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-2xl p-8 border border-gray-200/50 dark:border-gray-700/50">
                @livewire('premium-converter')
            </div>
            
            <!-- Link to Full Tools -->
            <div class="text-center mt-8">
                <a href="{{ route('conversions.index') }}" 
                   class="inline-flex items-center px-6 py-3 text-lg font-semibold text-blue-600 hover:text-blue-700 bg-white/70 hover:bg-white/90 dark:bg-gray-800/70 dark:text-blue-400 dark:hover:bg-gray-800/90 rounded-xl border border-blue-300/50 dark:border-blue-700/50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 backdrop-blur-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Browse All 210+ Tools
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">
                    Need more transformations? Access our complete collection of specialized tools
                </p>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-12 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800 dark:to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4 text-gray-900 dark:text-white">
                    Browse by Category
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Explore our complete collection of 210+ text transformation tools organized by category
                </p>
            </div>
            
            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @php
                $categories = config('categories.categories');
                $featuredCategories = array_slice($categories, 0, 8, true); // Show first 8 categories
                @endphp
                
                @foreach($featuredCategories as $slug => $category)
                <a href="{{ route('conversions.category', $slug) }}"
                   class="group relative overflow-hidden backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200/50 dark:border-gray-700/50">
                    <!-- Background Gradient on Hover -->
                    <div class="absolute inset-0 bg-gradient-to-br {{ $category['gradient'] ?? 'from-blue-500 to-blue-600' }} opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                    
                    <!-- Content -->
                    <div class="relative z-10">
                        <div class="flex items-start gap-4">
                            <span class="text-4xl flex-shrink-0">{{ $category['emoji'] ?? $category['icon'] ?? '📝' }}</span>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $category['name'] }}
                                </h3>
                                <p class="text-sm mb-3 text-gray-600 dark:text-gray-400 line-clamp-2">
                                    {{ $category['description'] }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200">
                                        {{ $category['tool_count'] ?? 0 }} tools
                                    </span>
                                    <span class="text-blue-600 dark:text-blue-400 group-hover:translate-x-1 transition-transform">
                                        →
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            
            <!-- View All Categories -->
            <div class="text-center mt-8">
                <a href="{{ route('conversions.index') }}" 
                   class="inline-flex items-center px-8 py-3 text-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    View All 18 Categories
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Why Choose Case Changer Pro?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Instant Previews</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        See all transformation formats instantly as you type. No need to click multiple buttons.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">100% Secure</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        All conversions happen in your browser. Your text never leaves your device.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Click to Copy</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        One click to copy any transformed text directly to your clipboard. Super efficient workflow.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
    <style nonce="{{ csp_nonce() }}">
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        /* Line clamp utility */
        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        [x-cloak] { 
            display: none !important; 
        }
    </style>
    @endpush
</x-layouts.app>

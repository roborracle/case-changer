@extends('conversions.layout')

@section('title', 'Sitemap - All Text Conversion Tools - Case Changer Pro')
@section('description', 'Complete sitemap of all text transformation tools, categories, and resources available on Case Changer Pro')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-900">Sitemap</span>
</li>
@endsection

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Sitemap</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Complete directory of all text conversion tools and resources
            </p>
        </div>

        <!-- Main Pages -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Main Pages</h2>
            <div class="bg-gray-50 rounded-lg p-6">
                <ul class="space-y-3">
                    <li>
                        <a href="/" class="text-blue-600 hover:text-blue-700 font-medium">Home Page</a>
                        <span class="text-gray-500 text-sm ml-2">- Choose your interface</span>
                    </li>
                    <li>
                        <a href="{{ route('conversions.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">All Conversion Tools</a>
                        <span class="text-gray-500 text-sm ml-2">- Browse all categories</span>
                    </li>
                    <li>
                        <a href="{{ route('modern-case-changer') }}" class="text-blue-600 hover:text-blue-700 font-medium">Modern Interface</a>
                        <span class="text-gray-500 text-sm ml-2">- Quick conversion with command palette</span>
                    </li>
                    <li>
                        <a href="{{ route('case-changer') }}" class="text-blue-600 hover:text-blue-700 font-medium">Classic Interface</a>
                        <span class="text-gray-500 text-sm ml-2">- Traditional two-panel layout</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- All Categories and Tools -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">All Categories & Tools</h2>
            
            @php
            $allCategories = app(\App\Http\Controllers\ConversionController::class)->getAllCategories()->getData(true);
            $totalTools = 0;
            foreach($allCategories as $cat) {
                $totalTools += count($cat['tools']);
            }
            @endphp
            
            <div class="mb-4 text-sm text-gray-600">
                Total: {{ count($allCategories) }} categories, {{ $totalTools }} conversion tools
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($allCategories as $catSlug => $category)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                        <a href="{{ route('conversions.category', $catSlug) }}" class="hover:text-blue-600 transition-colors">
                            {{ $category['title'] }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $category['description'] }}</p>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            {{ count($category['tools']) }} Tools
                        </p>
                        <ul class="grid grid-cols-2 gap-x-4 gap-y-2">
                            @foreach($category['tools'] as $toolSlug => $tool)
                            <li>
                                <a href="{{ route('conversions.tool', [$catSlug, $toolSlug]) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-700 transition-colors">
                                    {{ $tool['name'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Reference -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Reference</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Most Popular -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Most Popular</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}" class="text-sm text-blue-600 hover:text-blue-700">UPPERCASE</a></li>
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}" class="text-sm text-blue-600 hover:text-blue-700">lowercase</a></li>
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'title-case']) }}" class="text-sm text-blue-600 hover:text-blue-700">Title Case</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" class="text-sm text-blue-600 hover:text-blue-700">camelCase</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" class="text-sm text-blue-600 hover:text-blue-700">snake_case</a></li>
                    </ul>
                </div>
                
                <!-- For Developers -->
                <div class="bg-green-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">For Developers</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" class="text-sm text-green-600 hover:text-green-700">camelCase</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'pascal-case']) }}" class="text-sm text-green-600 hover:text-green-700">PascalCase</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" class="text-sm text-green-600 hover:text-green-700">snake_case</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'kebab-case']) }}" class="text-sm text-green-600 hover:text-green-700">kebab-case</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'constant-case']) }}" class="text-sm text-green-600 hover:text-green-700">CONSTANT_CASE</a></li>
                    </ul>
                </div>
                
                <!-- For Writers -->
                <div class="bg-purple-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">For Writers</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('conversions.tool', ['journalistic-styles', 'ap-style']) }}" class="text-sm text-purple-600 hover:text-purple-700">AP Style</a></li>
                        <li><a href="{{ route('conversions.tool', ['journalistic-styles', 'nyt-style']) }}" class="text-sm text-purple-600 hover:text-purple-700">NY Times Style</a></li>
                        <li><a href="{{ route('conversions.tool', ['academic-styles', 'apa-style']) }}" class="text-sm text-purple-600 hover:text-purple-700">APA Style</a></li>
                        <li><a href="{{ route('conversions.tool', ['academic-styles', 'mla-style']) }}" class="text-sm text-purple-600 hover:text-purple-700">MLA Style</a></li>
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'title-case']) }}" class="text-sm text-purple-600 hover:text-purple-700">Title Case</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- SEO URLs List -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">All URLs (For Search Engines)</h2>
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="columns-2 md:columns-3 lg:columns-4 gap-4 text-xs">
                    <div class="break-inside-avoid mb-2">
                        <a href="/" class="text-gray-600 hover:text-gray-900">/</a>
                    </div>
                    <div class="break-inside-avoid mb-2">
                        <a href="/conversions" class="text-gray-600 hover:text-gray-900">/conversions</a>
                    </div>
                    <div class="break-inside-avoid mb-2">
                        <a href="/modern" class="text-gray-600 hover:text-gray-900">/modern</a>
                    </div>
                    <div class="break-inside-avoid mb-2">
                        <a href="/case-changer" class="text-gray-600 hover:text-gray-900">/case-changer</a>
                    </div>
                    @foreach($allCategories as $catSlug => $category)
                        <div class="break-inside-avoid mb-2">
                            <a href="/conversions/{{ $catSlug }}" class="text-gray-600 hover:text-gray-900">
                                /conversions/{{ $catSlug }}
                            </a>
                        </div>
                        @foreach($category['tools'] as $toolSlug => $tool)
                            <div class="break-inside-avoid mb-2">
                                <a href="/conversions/{{ $catSlug }}/{{ $toolSlug }}" class="text-gray-600 hover:text-gray-900">
                                    /conversions/{{ $catSlug }}/{{ $toolSlug }}
                                </a>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
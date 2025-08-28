@extends('conversions.layout')

@section('title', 'Sitemap - All Text Conversion Tools - Case Changer Pro')
@section('description', 'Complete sitemap of all text transformation tools, categories, and resources available on Case Changer Pro')

@section('breadcrumbs')
<li class="flex items-center">
<svg class="w-4 h-4 mx-2 text-secondary"  fill="currentColor" viewBox="0 0 20 20">
<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
</svg>
<span>Sitemap</span>
</li>
@endsection

@section('content')
<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4 text-primary" >Sitemap</h1>
            <p class="text-xl max-w-3xl mx-auto text-secondary" >
            Complete directory of all text conversion tools and resources
            </p>
        </div>

        <!-- Main Pages -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-primary" >Main Pages</h2>
            <div class="rounded-lg p-6 bg-secondary" >
                <ul class="space-y-3">
                    <li>
                    <a href="/" class="font-medium hover:opacity-80 transition-opacity text-accent-primary" >Home Page</a>
                    <span class="text-sm ml-2 text-tertiary" >- Choose your interface</span>
                    </li>
                    <li>
                    <a href="{{ route('conversions.index') }}" class="font-medium hover:opacity-80 transition-opacity text-accent-primary" >All Conversion Tools</a>
                    <span class="text-sm ml-2 text-tertiary" >- Browse all categories</span>
                    </li>
                    <li>
                    <a href="{{ route('modern-case-changer') }}" class="font-medium hover:opacity-80 transition-opacity text-accent-primary" >Modern Interface</a>
                    <span class="text-sm ml-2 text-tertiary" >- Quick conversion with command palette</span>
                    </li>
                    <li>
                    <a href="{{ route('case-changer') }}" class="font-medium hover:opacity-80 transition-opacity text-accent-primary" >Classic Interface</a>
                    <span class="text-sm ml-2 text-tertiary" >- Traditional two-panel layout</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- All Categories and Tools -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-primary" >All Categories & Tools</h2>

            @php
            $allCategories = app(\App\Http\Controllers\ConversionController::class)->getAllCategories()->getData(true);
            $totalTools = 0;
            foreach($allCategories as $cat) {
            $totalTools += count($cat['tools']);
            }
            @endphp

            <div class="mb-4 text-sm text-secondary" >
                Total: {{ count($allCategories) }} categories, {{ $totalTools }} conversion tools
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($allCategories as $catSlug => $category)
                <div class="rounded-lg p-6 bg-primary border" >
                    <h3 class="text-lg font-semibold mb-1 text-primary" >
                    <a href="{{ route('conversions.category', $catSlug) }}" class="hover:opacity-80 transition-opacity text-primary">
                    {{ $category['title'] }}
                    </a>
                    </h3>
                    <p class="text-sm mb-4 text-secondary" >{{ $category['description'] }}</p>

                    <div class="pt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider mb-2 text-tertiary" >
                        {{ count($category['tools']) }} Tools
                        </p>
                        <ul class="grid grid-cols-2 gap-x-4 gap-y-2">
                            @foreach($category['tools'] as $toolSlug => $tool)
                            <li>
                            <a href="{{ route('conversions.tool', [$catSlug, $toolSlug]) }}"
                            class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >
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
            <h2 class="text-2xl font-bold mb-6 text-primary" >Quick Reference</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Most Popular -->
                <div class="rounded-lg p-6 bg-secondary" >
                    <h3 class="text-lg font-semibold mb-4 text-primary" >Most Popular</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >UPPERCASE</a></li>
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >lowercase</a></li>
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'title-case']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >Title Case</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >camelCase</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >snake_case</a></li>
                    </ul>
                </div>

                <!-- For Developers -->
                <div class="rounded-lg p-6 bg-secondary" >
                    <h3 class="text-lg font-semibold mb-4 text-primary" >For Developers</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-secondary" >camelCase</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'pascal-case']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-secondary" >PascalCase</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-secondary" >snake_case</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'kebab-case']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-secondary" >kebab-case</a></li>
                        <li><a href="{{ route('conversions.tool', ['developer-formats', 'constant-case']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-secondary" >CONSTANT_CASE</a></li>
                    </ul>
                </div>

                <!-- For Writers -->
                <div class="rounded-lg p-6 bg-secondary" >
                    <h3 class="text-lg font-semibold mb-4 text-primary" >For Writers</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('conversions.tool', ['journalistic-styles', 'ap-style']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >AP Style</a></li>
                        <li><a href="{{ route('conversions.tool', ['journalistic-styles', 'nyt-style']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >NY Times Style</a></li>
                        <li><a href="{{ route('conversions.tool', ['academic-styles', 'apa-style']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >APA Style</a></li>
                        <li><a href="{{ route('conversions.tool', ['academic-styles', 'mla-style']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >MLA Style</a></li>
                        <li><a href="{{ route('conversions.tool', ['case-conversions', 'title-case']) }}" class="text-sm hover:opacity-80 transition-opacity text-accent-primary" >Title Case</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- SEO URLs List -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-primary" >All URLs (For Search Engines)</h2>
            <div class="rounded-lg p-6 bg-secondary" >
                <div class="columns-2 md:columns-3 lg:columns-4 gap-4 text-xs">
                    <div class="break-inside-avoid mb-2">
                        <a href="/" class="hover:opacity-80 transition-opacity text-secondary nav-link-hover">/</a>
                    </div>
                    <div class="break-inside-avoid mb-2">
                        <a href="/conversions" class="hover:opacity-80 transition-opacity text-secondary nav-link-hover">/conversions</a>
                    </div>
                    <div class="break-inside-avoid mb-2">
                        <a href="/modern" class="hover:opacity-80 transition-opacity text-secondary nav-link-hover">/modern</a>
                    </div>
                    <div class="break-inside-avoid mb-2">
                        <a href="/case-changer" class="hover:opacity-80 transition-opacity text-secondary nav-link-hover">/case-changer</a>
                    </div>
                    @foreach($allCategories as $catSlug => $category)
                    <div class="break-inside-avoid mb-2">
                        <a href="/conversions/{{ $catSlug }}" class="hover:opacity-80 transition-opacity text-secondary nav-link-hover">
                        /conversions/{{ $catSlug }}
                        </a>
                    </div>
                    @foreach($category['tools'] as $toolSlug => $tool)
                    <div class="break-inside-avoid mb-2">
                        <a href="/conversions/{{ $catSlug }}/{{ $toolSlug }}" class="hover:opacity-80 transition-opacity text-secondary nav-link-hover">
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
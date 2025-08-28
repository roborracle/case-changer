@extends('conversions.layout')

@section('title', $categoryData['title'] . ' - Case Changer Pro')
@section('description', $categoryData['description'] . ' - Professional text transformation tools')
@section('keywords', implode(', ', array_column($categoryData['tools'], 'name')))

@section('breadcrumbs')
<li class="flex items-center">
<svg class="w-4 h-4 mx-2 text-tertiary"  fill="currentColor" viewBox="0 0 20 20">
<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
</svg>
<a href="{{ route('conversions.index') }}" class="nav-link-hover">All Tools</a>
</li>
<li class="flex items-center">
<svg class="w-4 h-4 mx-2 text-tertiary"  fill="currentColor" viewBox="0 0 20 20">
<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
</svg>
<span>{{ $categoryData['title'] }}</span>
</li>
@endsection

@section('content')
<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Category Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center p-4 rounded-xl mb-4 bg-secondary" >
                @switch($categoryData['icon'])
                @case('text')
                <svg class="w-10 h-10 text-accent-primary"  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                @break
                @case('code')
                <svg class="w-10 h-10 text-accent-primary"  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                </svg>
                @break
                @case('newspaper')
                <svg class="w-10 h-10 text-accent-primary"  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                @break
                @case('academic')
                <svg class="w-10 h-10 text-accent-primary"  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                </svg>
                @break
                @default
                <svg class="w-10 h-10 text-accent-primary"  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                @endswitch
            </div>
            <h1 class="text-4xl font-bold mb-4 text-primary" >{{ $categoryData['title'] }}</h1>
            <p class="text-xl max-w-3xl mx-auto text-secondary" >
            {{ $categoryData['description'] }}
            </p>
        </div>

        <!-- Category Converter Tool -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-4 text-center text-primary" >{{ $categoryData['title'] }} Converter</h2>
            <p class="text-center mb-6 text-secondary" >Convert text using any {{ $categoryData['title'] }} format</p>
            <div x-data="categoryConverter('{{ $category }}', {{ json_encode(array_map(function($tool) { return $tool['name']; }, $categoryData['tools'])) }})" class="rounded-xl p-6 bg-secondary border" >
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Input Section -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-primary" >Input Text</label>
                        <textarea
                        x-model="inputText"
                        @input="transform"
                        rows="10"
                        class="w-full p-4 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-primary text-primary"
                        
                        placeholder="Enter or paste your text here..."></textarea>
                    </div>

                    <!-- Output Section -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-primary" >Result</label>
                        <textarea
                        x-model="outputText"
                        rows="10"
                        class="w-full p-4 rounded-lg border bg-primary text-primary"
                        
                        readonly></textarea>
                    </div>
                </div>

                <!-- Tool Selection -->
                <div class="mt-6">
                    <label class="block text-sm font-medium mb-2 text-primary" >Select Format</label>
                    <select
                    x-model="selectedTool"
                    @change="transform"
                    class="w-full p-3 rounded-lg border focus:ring-2 focus:ring-blue-500 bg-primary text-primary"
                    >
                    <template x-for="(toolName, toolKey) in tools" :key="toolKey">
                    <option :value="toolKey" x-text="toolName"></option>
                    </template>
                    </select>
                </div>

                <div class="mt-4 flex gap-2">
                    <button
                    @click="copyToClipboard"
                    :disabled="!outputText"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    Copy Result
                    </button>
                </div>

                <!-- Error Message -->
                <div x-show="error" x-text="error" class="mt-4 p-3 bg-red-50 text-red-600 rounded-lg"></div>
            </div>
        </div>

        <!-- Tools Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categoryData['tools'] as $toolSlug => $tool)
            <a href="{{ route('conversions.tool', [$category, $toolSlug]) }}"
            class="group rounded-lg p-6 hover:shadow-lg transition-all duration-200 bg-primary border hover-border-accent">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold transition-colors text-primary">
                {{ $tool['name'] }}
                </h3>
                <svg class="w-5 h-5 transition-colors transform text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <p class="text-sm text-secondary" >
            {{ $tool['description'] }}
            </p>

            <!-- Visual preview of the format -->
            <div class="mt-4 p-3 rounded-lg bg-secondary" >
                <p class="text-xs mb-1 text-tertiary" >Example:</p>
                <p class="font-mono text-sm text-secondary" >
                @switch($toolSlug)
                @case('uppercase')
                SAMPLE TEXT OUTPUT
                @break
                @case('lowercase')
                sample text output
                @break
                @case('title-case')
                Sample Text Output
                @break
                @case('sentence-case')
                Sample text output
                @break
                @case('camel-case')
                sampleTextOutput
                @break
                @case('pascal-case')
                SampleTextOutput
                @break
                @case('snake-case')
                sample_text_output
                @break
                @case('kebab-case')
                sample-text-output
                @break
                @case('constant-case')
                SAMPLE_TEXT_OUTPUT
                @break
                @case('dot-case')
                sample.text.output
                @break
                @case('path-case')
                sample/text/output
                @break
                @case('reverse')
                tuptuO txeT elpmaS
                @break
                @case('aesthetic')
                s a m p l e  t e x t
                @break
                @default
                {{ $tool['name'] }} Format
                @endswitch
                </p>
            </div>
            </a>
            @endforeach
        </div>

        <!-- Related Categories -->
        <div class="mt-16 rounded-xl p-8 bg-secondary" >
            <h2 class="text-2xl font-bold mb-6 text-primary" >Explore Other Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($allCategories as $slug => $cat)
                @if($slug !== $category)
                <a href="{{ route('conversions.category', $slug) }}"
                class="px-4 py-3 rounded-lg text-center hover:shadow transition-all bg-primary border hover-border-accent">
                <span class="text-sm font-medium text-secondary">
                {{ $cat['title'] }}
                </span>
                <span class="block text-xs mt-1 text-tertiary" >
                {{ count($cat['tools']) }} tools
                </span>
                </a>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
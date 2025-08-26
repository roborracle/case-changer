@extends('conversions.layout')

@section('title', 'Case Changer Pro - Universal Text Converter & Transformation Tools')
@section('description', 'The ultimate text transformation tool. Convert text to any case format instantly - uppercase, lowercase, camelCase, snake_case, title case, and 167+ more formats. Free, fast, and professional.')
@section('keywords', 'case converter, text transformer, case changer, uppercase, lowercase, camelCase, snake_case, title case, sentence case, AP style, APA format, text conversion, developer tools, writing tools')

@section('content')
<div style="background-color: var(--bg-primary);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold mb-4" style="color: var(--text-primary);">
                Case Changer Pro
            </h1>
            <p class="text-xl max-w-3xl mx-auto mb-2" style="color: var(--text-secondary);">
                The Ultimate Text Transformation Tool
            </p>
            <p class="text-lg max-w-2xl mx-auto" style="color: var(--text-tertiary);">
                Convert text to any format instantly. 172 conversion styles including case formats, 
                developer conventions, and professional style guides.
            </p>
        </div>

        <!-- Universal Converter Tool - Main Feature -->
        <div class="mb-16 rounded-xl p-8 shadow-lg" style="background: linear-gradient(90deg, var(--bg-secondary), var(--bg-tertiary));">
            <h2 class="text-3xl font-bold mb-4 text-center" style="color: var(--text-primary);">Universal Text Converter</h2>
            <p class="text-center mb-6 text-lg" style="color: var(--text-secondary);">One tool to rule them all - select from 172 conversion formats</p>
            <div x-data="universalConverter()" class="rounded-lg p-6" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Input Section -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Your Text</label>
                        <textarea 
                            x-model="inputText"
                            @input="transform"
                            rows="10" 
                            class="w-full p-4 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            style="background-color: var(--bg-secondary); border-color: var(--border-primary); color: var(--text-primary);"
                            placeholder="Enter or paste your text here..."></textarea>
                    </div>

                    <!-- Output Section -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Result</label>
                        <textarea 
                            x-model="outputText"
                            rows="10" 
                            class="w-full p-4 rounded-lg border"
                            style="background-color: var(--bg-secondary); border-color: var(--border-primary); color: var(--text-primary);"
                            readonly></textarea>
                    </div>
                </div>

                <!-- Transformation Selection -->
                <div class="mt-6">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Select Transformation</label>
                    <div class="flex gap-4">
                        <select 
                            x-model="selectedTransformation"
                            @change="transform"
                            class="flex-1 p-3 rounded-lg border focus:ring-2 focus:ring-blue-500"
                            style="background-color: var(--bg-secondary); border-color: var(--border-primary); color: var(--text-primary);">
                            <template x-for="(label, value) in transformations" :key="value">
                                <option :value="value" x-text="label"></option>
                            </template>
                        </select>
                        <button 
                            @click="copyToClipboard"
                            :disabled="!outputText"
                            class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors font-medium">
                            <span x-show="!showCopySuccess">Copy Result</span>
                            <span x-show="showCopySuccess">✓ Copied!</span>
                        </button>
                        <button 
                            @click="downloadResult"
                            :disabled="!outputText"
                            class="px-6 py-3 border rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            style="border-color: var(--border-primary); color: var(--text-secondary);">
                            Download
                        </button>
                    </div>
                </div>

                <!-- Loading & Error States -->
                <div x-show="isLoading" class="mt-4 text-center" style="color: var(--text-secondary);">Converting...</div>
                <div x-show="error" x-text="error" class="mt-4 p-3 bg-red-50 text-red-600 rounded-lg"></div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $slug => $category)
            <a href="{{ route('conversions.category', $slug) }}" 
               class="group rounded-lg p-6 hover:shadow-lg transition-all duration-200" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);" onmouseover="this.style.borderColor='var(--accent-primary)'" onmouseout="this.style.borderColor='var(--border-primary)'">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 rounded-lg transition-colors" style="background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));" onmouseover="this.style.background='linear-gradient(135deg, var(--bg-tertiary), var(--accent-primary))'" onmouseout="this.style.background='linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary))'">
                        @switch($category['icon'])
                            @case('text')
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                @break
                            @case('code')
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                                @break
                            @case('newspaper')
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                                @break
                            @case('academic')
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                </svg>
                                @break
                            @case('sparkles')
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                                @break
                            @case('briefcase')
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                @break
                            @case('share')
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m9.032 4.026a3 3 0 10-4.631 2.475 5.009 5.009 0 00-2.711-3.784 3.001 3.001 0 10-2.148 0 5.008 5.008 0 00-2.711 3.784 3 3 0 10-4.631-2.475"></path>
                                </svg>
                                @break
                            @case('document')
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                @break
                            @case('globe')
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                @break
                            @default
                                <svg class="w-6 h-6" style="color: var(--accent-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                        @endswitch
                    </div>
                    <span class="text-xs px-2 py-1 rounded" style="color: var(--text-tertiary); background-color: var(--bg-secondary);">
                        {{ count($category['tools']) }} tools
                    </span>
                </div>
                
                <h2 class="text-xl font-semibold mb-2 transition-colors" style="color: var(--text-primary);" onmouseover="this.style.color='var(--accent-primary)'" onmouseout="this.style.color='var(--text-primary)'">
                    {{ $category['title'] }}
                </h2>
                <p class="text-sm mb-4" style="color: var(--text-secondary);">
                    {{ $category['description'] }}
                </p>
                
                <!-- Preview of tools -->
                <div class="flex flex-wrap gap-2">
                    @foreach(array_slice($category['tools'], 0, 4) as $toolSlug => $tool)
                    <span class="text-xs px-2 py-1 rounded" style="background-color: var(--bg-secondary); color: var(--text-secondary);">
                        {{ $tool['name'] }}
                    </span>
                    @endforeach
                    @if(count($category['tools']) > 4)
                    <span class="text-xs" style="color: var(--text-tertiary);">
                        +{{ count($category['tools']) - 4 }} more
                    </span>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        <!-- Quick Access Section -->
        <div class="mt-16 rounded-xl p-8" style="background-color: var(--bg-secondary);">
            <h2 class="text-2xl font-bold mb-6" style="color: var(--text-primary);">Popular Conversions</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                <a href="{{ route('conversions.tool', ['case-conversions', 'uppercase']) }}" 
                   class="px-4 py-2 rounded-lg text-center hover:shadow transition-all" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);" onmouseover="this.style.borderColor='var(--accent-primary)'" onmouseout="this.style.borderColor='var(--border-primary)'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">UPPERCASE</span>
                </a>
                <a href="{{ route('conversions.tool', ['case-conversions', 'lowercase']) }}" 
                   class="px-4 py-2 rounded-lg text-center hover:shadow transition-all" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);" onmouseover="this.style.borderColor='var(--accent-primary)'" onmouseout="this.style.borderColor='var(--border-primary)'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">lowercase</span>
                </a>
                <a href="{{ route('conversions.tool', ['developer-formats', 'camel-case']) }}" 
                   class="px-4 py-2 rounded-lg text-center hover:shadow transition-all" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);" onmouseover="this.style.borderColor='var(--accent-primary)'" onmouseout="this.style.borderColor='var(--border-primary)'">
                    <span class="text-sm font-medium font-mono" style="color: var(--text-primary);">camelCase</span>
                </a>
                <a href="{{ route('conversions.tool', ['developer-formats', 'snake-case']) }}" 
                   class="px-4 py-2 rounded-lg text-center hover:shadow transition-all" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);" onmouseover="this.style.borderColor='var(--accent-primary)'" onmouseout="this.style.borderColor='var(--border-primary)'">
                    <span class="text-sm font-medium font-mono" style="color: var(--text-primary);">snake_case</span>
                </a>
                <a href="{{ route('conversions.tool', ['journalistic-styles', 'ap-style']) }}" 
                   class="px-4 py-2 rounded-lg text-center hover:shadow transition-all" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);" onmouseover="this.style.borderColor='var(--accent-primary)'" onmouseout="this.style.borderColor='var(--border-primary)'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">AP Style</span>
                </a>
                <a href="{{ route('conversions.tool', ['academic-styles', 'apa-style']) }}" 
                   class="px-4 py-2 rounded-lg text-center hover:shadow transition-all" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);" onmouseover="this.style.borderColor='var(--accent-primary)'" onmouseout="this.style.borderColor='var(--border-primary)'">
                    <span class="text-sm font-medium" style="color: var(--text-primary);">APA Style</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
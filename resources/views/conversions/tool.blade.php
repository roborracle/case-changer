@extends('conversions.layout')

@section('title', $toolData['name'] . ' Converter - ' . $categoryData['title'] . ' - Case Changer Pro')
@section('description', $toolData['description'] . ' - Free online ' . $toolData['name'] . ' text converter tool')
@section('keywords', $toolData['name'] . ', ' . $categoryData['title'] . ', text converter, online tool, free converter')

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
<a href="{{ route('conversions.category', $category) }}" class="nav-link-hover">{{ $categoryData['title'] }}</a>
</li>
<li class="flex items-center">
<svg class="w-4 h-4 mx-2 text-tertiary"  fill="currentColor" viewBox="0 0 20 20">
<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
</svg>
<span>{{ $toolData['name'] }}</span>
</li>
@endsection

@section('content')
<div>
    <!-- Tool Header -->
    <div class="border-b bg-secondary" >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold mb-2 text-primary" >{{ $toolData['name'] }} Converter</h1>
                <p class="text-lg text-secondary" >{{ $toolData['description'] }}</p>
            </div>
        </div>
    </div>

    <!-- Previous/Next Navigation -->
    @php
    $toolKeys = array_keys($categoryData['tools']);
    $currentIndex = array_search($tool, $toolKeys);
    $prevTool = $currentIndex > 0 ? $toolKeys[$currentIndex - 1] : null;
    $nextTool = $currentIndex < count($toolKeys) - 1 ? $toolKeys[$currentIndex + 1] : null;
    @endphp

    @if($prevTool || $nextTool)
    <div class="border-b bg-secondary" >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex justify-between items-center">
                @if($prevTool)
                <a href="{{ route('conversions.tool', [$category, $prevTool]) }}"
                class="flex items-center text-sm transition-colors text-secondary nav-link-hover">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ $categoryData['tools'][$prevTool]['name'] }}
                </a>
                @else
                <div></div>
                @endif

                <span class="text-xs text-tertiary" >
                {{ $currentIndex + 1 }} of {{ count($toolKeys) }} tools
                </span>

                @if($nextTool)
                <a href="{{ route('conversions.tool', [$category, $nextTool]) }}"
                class="flex items-center text-sm transition-colors text-secondary nav-link-hover">
                {{ $categoryData['tools'][$nextTool]['name'] }}
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                </a>
                @else
                <div></div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Conversion Tool Component -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="toolConverter('{{ $tool }}')">
        <div class="rounded-xl p-6 bg-secondary border" >
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Input Section -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-primary" >Input Text</label>
                        <div class="text-sm text-secondary" >
                            <span x-text="charCount"></span> chars • <span x-text="wordCount"></span> words
                        </div>
                    </div>
                    <textarea
                    x-model="inputText"
                    rows="12"
                    class="w-full p-4 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-primary text-primary"
                    
                    placeholder="Enter or paste your text here..."></textarea>
                    <div class="mt-2 flex gap-2">
                        <button
                        @click="clearText"
                        class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-50 transition-colors text-secondary"
                        >
                        Clear
                        </button>
                    </div>
                </div>

                <!-- Output Section -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-primary" >{{ $toolData['name'] }} Result</label>
                        <div x-show="isLoading" class="text-sm text-secondary" >Converting...</div>
                    </div>
                    <textarea
                    x-model="outputText"
                    rows="12"
                    class="w-full p-4 rounded-lg border bg-primary text-primary"
                    
                    readonly></textarea>
                    <div class="mt-2 flex gap-2">
                        <button
                        @click="copyToClipboard"
                        :disabled="!outputText"
                        class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        <span x-show="!showCopySuccess">Copy to Clipboard</span>
                        <span x-show="showCopySuccess">✓ Copied!</span>
                        </button>
                        <button
                        @click="downloadResult"
                        :disabled="!outputText"
                        class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-secondary"
                        >
                        Download
                        </button>
                    </div>
                </div>
            </div>

            <!-- Error Message -->
            <div x-show="error" x-text="error" class="mt-4 p-3 bg-red-50 text-red-600 rounded-lg"></div>
        </div>
    </div>

    <!-- Information Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- About This Tool -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold mb-4 text-primary" >About {{ $toolData['name'] }}</h2>
                <div class="prose prose-gray max-w-none">
                    @switch($tool)
                    @case('uppercase')
                    <p>The UPPERCASE converter transforms all letters in your text to capital letters. This is useful for headings, emphasis, legal documents, and creating impactful statements.</p>
                    <h3>Common Uses:</h3>
                    <ul>
                        <li>Legal document headers</li>
                        <li>Warning messages and alerts</li>
                        <li>Headlines and titles</li>
                        <li>Acronym formatting</li>
                    </ul>
                    @break

                    @case('lowercase')
                    <p>The lowercase converter transforms all letters to their lowercase form. Essential for URLs, email addresses, and maintaining consistent formatting.</p>
                    <h3>Common Uses:</h3>
                    <ul>
                        <li>URL normalization</li>
                        <li>Email address formatting</li>
                        <li>Username standardization</li>
                        <li>Code variable names</li>
                    </ul>
                    @break

                    @case('camel-case')
                    <p>camelCase is a naming convention where the first letter is lowercase and each subsequent word starts with a capital letter. Widely used in JavaScript, Java, and other programming languages.</p>
                    <h3>Common Uses:</h3>
                    <ul>
                        <li>JavaScript variable names</li>
                        <li>Method names in Java</li>
                        <li>Property names in JSON</li>
                        <li>Function names in many languages</li>
                    </ul>
                    @break

                    @case('snake-case')
                    <p>snake_case uses underscores to separate words, with all letters in lowercase. Popular in Python, Ruby, and database naming.</p>
                    <h3>Common Uses:</h3>
                    <ul>
                        <li>Python variable and function names</li>
                        <li>Database column names</li>
                        <li>File names in Unix/Linux</li>
                        <li>Configuration keys</li>
                    </ul>
                    @break

                    @case('ap-style')
                    <p>The Associated Press (AP) style guide is the gold standard for news writing and journalism. It provides consistent rules for capitalization, abbreviation, and formatting.</p>
                    <h3>AP Style Rules:</h3>
                    <ul>
                        <li>Capitalize principal words in titles</li>
                        <li>Lowercase articles, conjunctions under 4 letters</li>
                        <li>Capitalize prepositions of 4+ letters</li>
                        <li>Always capitalize first and last words</li>
                    </ul>
                    @break

                    @case('apa-style')
                    <p>APA (American Psychological Association) style is used in psychology, education, and social sciences for academic writing and citations.</p>
                    <h3>APA Title Case Rules:</h3>
                    <ul>
                        <li>Capitalize all major words</li>
                        <li>Capitalize words of 4+ letters</li>
                        <li>Lowercase short conjunctions and prepositions</li>
                        <li>Capitalize both parts of hyphenated compounds</li>
                    </ul>
                    @break

                    @default
                    <p>{{ $toolData['description'] }}</p>
                    <p>This tool provides professional text transformation following industry standards and best practices.</p>
                    @endswitch

                    <h3>Features:</h3>
                    <ul>
                        <li>Real-time conversion as you type</li>
                        <li>Smart preservation of URLs, emails, and special content</li>
                        <li>One-click copy to clipboard</li>
                        <li>Download results as text file</li>
                        <li>Handles large texts efficiently</li>
                    </ul>
                </div>
            </div>

            <!-- Related Tools -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-primary" >Related Tools</h3>
                <div class="space-y-2">
                    @foreach(array_slice($categoryData['tools'], 0, 8) as $relatedSlug => $relatedTool)
                    @if($relatedSlug !== $tool)
                    <a href="{{ route('conversions.tool', [$category, $relatedSlug]) }}"
                    class="block px-4 py-3 rounded-lg transition-colors bg-secondary hover-bg-tertiary">
                    <div class="text-sm font-medium text-primary" >{{ $relatedTool['name'] }}</div>
                    <div class="text-xs mt-1 text-secondary" >{{ Str::limit($relatedTool['description'], 50) }}</div>
                    </a>
                    @endif
                    @endforeach
                </div>

                <div class="mt-6 p-4 rounded-lg bg-tertiary" >
                    <h4 class="text-sm font-semibold mb-2 text-accent-primary" >Quick Tip</h4>
                    <p class="text-sm text-accent-secondary" >
                    You can use keyboard shortcuts for faster workflow:
                    </p>
                    <ul class="text-sm mt-2 space-y-1 text-accent-secondary" >
                        <li>• Ctrl/Cmd + A: Select all</li>
                        <li>• Ctrl/Cmd + C: Copy</li>
                        <li>• Ctrl/Cmd + V: Paste</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Other Categories -->
        <div class="mt-12 pt-12 border-t">
            <h3 class="text-xl font-semibold mb-6 text-primary" >Explore Other Categories</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($allCategories as $catSlug => $cat)
                @if($catSlug !== $category)
                <a href="{{ route('conversions.category', $catSlug) }}"
                class="text-center px-3 py-2 rounded-lg transition-colors bg-secondary hover-bg-tertiary">
                <span class="block text-sm font-medium text-secondary" >{{ $cat['title'] }}</span>
                <span class="text-xs text-tertiary" >{{ count($cat['tools']) }} tools</span>
                </a>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
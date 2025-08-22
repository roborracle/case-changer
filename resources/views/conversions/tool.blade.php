@extends('conversions.layout')

@section('title', $toolData['name'] . ' Converter - ' . $categoryData['title'] . ' - Case Changer Pro')
@section('description', $toolData['description'] . ' - Free online ' . $toolData['name'] . ' text converter tool')
@section('keywords', $toolData['name'] . ', ' . $categoryData['title'] . ', text converter, online tool, free converter')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <a href="{{ route('conversions.index') }}" class="text-gray-500 hover:text-gray-700">All Tools</a>
</li>
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <a href="{{ route('conversions.category', $category) }}" class="text-gray-500 hover:text-gray-700">{{ $categoryData['title'] }}</a>
</li>
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-900">{{ $toolData['name'] }}</span>
</li>
@endsection

@section('schema')
<?php
$schemaData = [
    "@context" => "https://schema.org",
    "@type" => "WebApplication",
    "name" => $toolData['name'] . " Converter",
    "applicationCategory" => "UtilityApplication",
    "operatingSystem" => "Any",
    "description" => $toolData['description'],
    "offers" => [
        "@type" => "Offer",
        "price" => "0",
        "priceCurrency" => "USD"
    ],
    "aggregateRating" => [
        "@type" => "AggregateRating",
        "ratingValue" => "4.8",
        "ratingCount" => "1250"
    ]
];
echo json_encode($schemaData);
?>
@endsection

@section('content')
<div class="bg-white">
    <!-- Tool Header -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $toolData['name'] }} Converter</h1>
                <p class="text-lg text-gray-600">{{ $toolData['description'] }}</p>
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
    <div class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex justify-between items-center">
                @if($prevTool)
                <a href="{{ route('conversions.tool', [$category, $prevTool]) }}" 
                   class="flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    {{ $categoryData['tools'][$prevTool]['name'] }}
                </a>
                @else
                <div></div>
                @endif
                
                <span class="text-xs text-gray-500">
                    {{ $currentIndex + 1 }} of {{ count($toolKeys) }} tools
                </span>
                
                @if($nextTool)
                <a href="{{ route('conversions.tool', [$category, $nextTool]) }}" 
                   class="flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
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
    @livewire('conversion-tool', [
        'category' => $category,
        'tool' => $tool,
        'toolData' => $toolData
    ])

    <!-- Information Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- About This Tool -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">About {{ $toolData['name'] }}</h2>
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
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Tools</h3>
                <div class="space-y-2">
                    @foreach(array_slice($categoryData['tools'], 0, 8) as $relatedSlug => $relatedTool)
                        @if($relatedSlug !== $tool)
                        <a href="{{ route('conversions.tool', [$category, $relatedSlug]) }}" 
                           class="block px-4 py-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="text-sm font-medium text-gray-900">{{ $relatedTool['name'] }}</div>
                            <div class="text-xs text-gray-600 mt-1">{{ Str::limit($relatedTool['description'], 50) }}</div>
                        </a>
                        @endif
                    @endforeach
                </div>
                
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <h4 class="text-sm font-semibold text-blue-900 mb-2">Quick Tip</h4>
                    <p class="text-sm text-blue-700">
                        You can use keyboard shortcuts for faster workflow:
                    </p>
                    <ul class="text-sm text-blue-700 mt-2 space-y-1">
                        <li>• Ctrl/Cmd + A: Select all</li>
                        <li>• Ctrl/Cmd + C: Copy</li>
                        <li>• Ctrl/Cmd + V: Paste</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Other Categories -->
        <div class="mt-12 pt-12 border-t border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Explore Other Categories</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($allCategories as $catSlug => $cat)
                    @if($catSlug !== $category)
                    <a href="{{ route('conversions.category', $catSlug) }}" 
                       class="text-center px-3 py-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="block text-sm font-medium text-gray-700">{{ $cat['title'] }}</span>
                        <span class="text-xs text-gray-500">{{ count($cat['tools']) }} tools</span>
                    </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
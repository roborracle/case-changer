@extends('conversions.layout')

@section('title', 'Case Changer Pro - Text Transformation Tools')
@section('description', 'Transform text instantly with 210+ professional tools')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero -->
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold mb-4 text-primary">Case Changer Pro</h1>
        <p class="text-xl text-secondary">Transform text instantly with 210+ conversion tools</p>
    </div>

    <!-- Universal Converter -->
    <div class="mb-16 rounded-xl p-8 shadow-lg bg-secondary">
        <h2 class="text-3xl font-bold mb-6 text-center text-primary">Universal Text Converter</h2>
        
        <div x-data="universalConverter" class="rounded-lg p-6 bg-primary border">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Input -->
                <div>
                    <label class="block text-sm font-medium mb-2 text-primary">Your Text</label>
                    <textarea
                        x-model="inputText"
                        @input="transform"
                        rows="10"
                        class="w-full p-4 rounded-lg border focus:ring-2 focus:ring-blue-500 bg-secondary text-primary"
                        placeholder="Enter or paste your text here..."></textarea>
                </div>

                <!-- Output -->
                <div>
                    <label class="block text-sm font-medium mb-2 text-primary">Result</label>
                    <textarea
                        x-model="outputText"
                        rows="10"
                        class="w-full p-4 rounded-lg border bg-secondary text-primary"
                        readonly></textarea>
                </div>
            </div>

            <!-- Controls -->
            <div class="mt-6">
                <label class="block text-sm font-medium mb-2 text-primary">Select Transformation</label>
                <div class="flex gap-4">
                    <select
                        x-model="selectedTransformation"
                        @change="transform"
                        class="flex-1 p-3 rounded-lg border focus:ring-2 focus:ring-blue-500 bg-secondary text-primary">
                        <template x-for="(label, value) in transformations" :key="value">
                            <option :value="value" x-text="label"></option>
                        </template>
                    </select>
                    
                    <button
                        @click="copyToClipboard"
                        :disabled="!outputText"
                        class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors font-medium">
                        <span x-show="!showCopySuccess">Copy Result</span>
                        <span x-show="showCopySuccess" x-cloak>✓ Copied!</span>
                    </button>
                    
                    <button
                        @click="downloadResult"
                        :disabled="!outputText"
                        class="px-6 py-3 border rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-secondary">
                        Download
                    </button>
                </div>
            </div>

            <!-- Status -->
            <div x-show="isLoading" class="mt-4 text-center text-secondary" x-cloak>Converting...</div>
            <div x-show="error" x-text="error" class="mt-4 p-3 bg-red-50 text-red-600 rounded-lg" x-cloak></div>
        </div>
    </div>

    <!-- Categories Grid with Glassmorphic Design -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($categories as $slug => $category)
        <a href="{{ route('conversions.category', $slug) }}"
           class="group relative overflow-hidden backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200/50 dark:border-gray-700/50">
            <!-- Background Gradient on Hover -->
            <div class="absolute inset-0 bg-gradient-to-br {{ $category['gradient'] ?? 'from-blue-500 to-blue-600' }} opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
            
            <!-- Content -->
            <div class="relative z-10">
                <div class="flex items-start gap-4">
                    <span class="text-4xl flex-shrink-0">{{ $category['emoji'] ?? $category['icon'] ?? '📝' }}</span>
                    <div class="flex-1">
                        <h2 class="text-lg font-bold mb-2 text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $category['name'] }}
                        </h2>
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
</div>
@endsection
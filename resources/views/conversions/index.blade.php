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
        
        <div x-data="improvedConverter" class="rounded-lg p-6 bg-primary border">
            <!-- Input Section -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2 text-primary">Enter Your Text</label>
                <div class="relative">
                    <textarea
                        x-model="inputText"
                        rows="6"
                        class="w-full p-4 rounded-lg border focus:ring-2 focus:ring-blue-500 bg-secondary text-primary resize-none"
                        placeholder="Type or paste your text here..."
                        :class="{ 'pr-20': hasInput }"
                    ></textarea>
                    <div x-show="hasInput" class="absolute bottom-2 right-2 text-xs text-secondary" x-text="characterCountText" x-cloak></div>
                </div>
                
                <!-- Quick Actions -->
                <div class="mt-3 flex flex-wrap gap-2">
                    <button @click="pasteFromClipboard" class="px-3 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-md hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                        Paste
                    </button>
                    <button @click="clearText" x-show="hasInput" class="px-3 py-1 text-xs bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-md hover:bg-red-200 dark:hover:bg-red-800 transition-colors" x-cloak>
                        Clear
                    </button>
                    <button @click="loadExample" class="px-3 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Load Example
                    </button>
                </div>
            </div>

            <!-- Preview Grid -->
            <div x-show="hasInput" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" x-cloak>
                <template x-for="preview in previews" :key="preview.key">
                    <div class="bg-secondary rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-medium text-primary" x-text="preview.label"></h3>
                            <button 
                                @click="copyToClipboard(preview.output, preview.key)"
                                :disabled="!preview.output"
                                class="p-1 rounded text-xs bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 transition-colors"
                                :class="{ 'bg-green-600 hover:bg-green-700': copiedFormat === preview.key }"
                            >
                                <span x-show="copiedFormat !== preview.key">Copy</span>
                                <span x-show="copiedFormat === preview.key" x-cloak>✓</span>
                            </button>
                        </div>
                        <div class="bg-primary border rounded p-2 min-h-[3rem] break-words text-sm text-secondary">
                            <span x-text="preview.output || '...'"></span>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Empty State -->
            <div x-show="noInput" class="text-center py-12 text-secondary" x-cloak>
                <div class="text-4xl mb-4">📝</div>
                <h3 class="text-lg font-medium mb-2">Ready to Transform Your Text</h3>
                <p class="text-sm mb-4">Enter text above to see instant previews in 12 different formats</p>
                <button @click="loadExample" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Try Example Text
                </button>
            </div>
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
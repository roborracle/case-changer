@extends('layouts.app')

@section('title', 'Case Changer Pro - 172+ Professional Text Transformation Tools')
@section('description', 'Transform text instantly with 172+ professional tools. Case converters, developer formats, academic styles, social media tools, and more. Free, fast, and powerful.')

@php
    $categories = config('categories.categories');
    $featuredCategories = config('categories.featured_categories');
@endphp

@section('content')
<!-- Hero Section with Glassmorphism -->
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600">
    <!-- Animated Background Orbs -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float"></div>
        <div class="absolute top-40 right-20 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float animation-delay-2000"></div>
        <div class="absolute -bottom-20 left-40 w-72 h-72 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float animation-delay-4000"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 animate-fade-in-up">
            Case Changer <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-400">Pro</span>
        </h1>
        <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto animate-fade-in-up animation-delay-200">
            Transform text instantly with <span class="font-bold">172+ professional tools</span>
        </p>
        
        <!-- Universal Converter Card -->
        <div class="max-w-4xl mx-auto animate-fade-in-up animation-delay-400">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl" 
                 data-controller="text-converter">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Input -->
                    <div>
                        <label class="block text-white/80 text-sm font-medium mb-2">Input Text</label>
                        <textarea 
                            data-text-converter-target="input"
                            data-action="input->text-converter#convert"
                            placeholder="Enter or paste your text here..."
                            class="w-full h-32 px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/50"></textarea>
                    </div>
                    
                    <!-- Output -->
                    <div>
                        <label class="block text-white/80 text-sm font-medium mb-2">Transformed Text</label>
                        <textarea 
                            data-text-converter-target="output"
                            readonly
                            placeholder="Result will appear here..."
                            class="w-full h-32 px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white placeholder-white/50"></textarea>
                    </div>
                </div>
                
                <!-- Tool Selector -->
                <div class="mt-6">
                    <select 
                        data-text-converter-target="tool"
                        data-action="change->text-converter#selectTool"
                        class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-white/50">
                        <option value="uppercase">UPPERCASE</option>
                        <option value="lowercase">lowercase</option>
                        <option value="title-case">Title Case</option>
                        <option value="camel-case">camelCase</option>
                        <option value="snake-case">snake_case</option>
                        <option value="kebab-case">kebab-case</option>
                        @foreach($categories as $category)
                            @foreach($category['tools'] ?? [] as $toolSlug => $tool)
                                <option value="{{ $toolSlug }}">{{ $tool['name'] }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 mt-6">
                    <button 
                        data-action="click->text-converter#copyOutput"
                        class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 rounded-lg text-white font-medium transition-all">
                        📋 Copy Result
                    </button>
                    <button 
                        data-action="click->text-converter#clearAll"
                        class="px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-lg text-white/80 font-medium transition-all">
                        🗑️ Clear
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 animate-fade-in-up animation-delay-600">
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-3xl font-bold text-white">172+</div>
                <div class="text-white/70 text-sm">Tools Available</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-3xl font-bold text-white">18</div>
                <div class="text-white/70 text-sm">Categories</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-3xl font-bold text-white">100%</div>
                <div class="text-white/70 text-sm">Free Forever</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-3xl font-bold text-white">⚡</div>
                <div class="text-white/70 text-sm">Instant Results</div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Grid Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">All Text Transformation Categories</h2>
            <p class="text-xl text-gray-600">Choose from 18 professional categories with 172+ tools</p>
        </div>
        
        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $slug => $category)
            <a href="{{ route('conversions.category', $slug) }}" 
               class="group relative overflow-hidden bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <!-- Gradient Background -->
                <div class="absolute inset-0 bg-gradient-to-br {{ $category['gradient'] }} opacity-0 group-hover:opacity-10 transition-opacity"></div>
                
                <div class="relative p-6">
                    <!-- Icon and Title -->
                    <div class="flex items-start space-x-4">
                        <div class="text-4xl">{{ $category['emoji'] }}</div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $category['name'] }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $category['tool_count'] }} tools</p>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <p class="mt-4 text-gray-600 text-sm">{{ $category['description'] }}</p>
                    
                    <!-- Popular Tools Preview -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        @php
                            $tools = $categories[$slug]['tools'] ?? [];
                            $previewTools = array_slice($tools, 0, 3);
                        @endphp
                        @foreach($previewTools as $toolSlug => $tool)
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                {{ $tool['name'] ?? '' }}
                            </span>
                        @endforeach
                        @if(count($tools) > 3)
                            <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs rounded-full">
                                +{{ count($tools) - 3 }} more
                            </span>
                        @endif
                    </div>
                    
                    <!-- Arrow Icon -->
                    <div class="absolute bottom-6 right-6 text-gray-400 group-hover:text-blue-600 transition-colors">
                        <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Case Changer Pro?</h2>
            <p class="text-xl text-gray-600">Professional features for everyone</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">⚡</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lightning Fast</h3>
                <p class="text-gray-600">Instant text transformation with no delays. Process any amount of text in milliseconds.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">🔒</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">100% Secure</h3>
                <p class="text-gray-600">All processing happens in your browser. Your text never leaves your device.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">🎯</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Professional Quality</h3>
                <p class="text-gray-600">Industry-standard formatting rules for journalism, academic, and business use.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h2 class="text-4xl font-bold mb-4">Ready to Transform Your Text?</h2>
        <p class="text-xl mb-8 text-white/90">Join thousands of writers, developers, and professionals using Case Changer Pro daily</p>
        <a href="#hero" class="inline-block px-8 py-4 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition-colors">
            Start Converting Now - It's Free!
        </a>
    </div>
</section>

<!-- Custom Animations -->
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }
    
    .animation-delay-200 {
        animation-delay: 0.2s;
    }
    
    .animation-delay-400 {
        animation-delay: 0.4s;
    }
    
    .animation-delay-600 {
        animation-delay: 0.6s;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endsection
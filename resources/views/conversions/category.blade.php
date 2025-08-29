@extends('layouts.app')

@section('title', $categoryData['title'] . ' - Case Changer Pro')
@section('description', $categoryData['description'])

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $categoryData['title'] }}</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ $categoryData['description'] }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categoryData['tools'] as $toolSlug => $tool)
                <a href="{{ route('conversions.tool', ['category' => $category, 'tool' => $toolSlug]) }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $tool['name'] }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ $tool['description'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endsection

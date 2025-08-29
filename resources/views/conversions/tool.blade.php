@extends('layouts.app')

@section('title', $toolData['name'] . ' - ' . $categoryData['title'] . ' - Case Changer Pro')
@section('description', $toolData['description'])

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $toolData['name'] }}</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ $toolData['description'] }}</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="input" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Input</label>
                        <textarea id="input" name="input" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></textarea>
                    </div>
                    <div>
                        <label for="output" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Output</label>
                        <textarea id="output" name="output" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" readonly></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Transform</button>
                </div>
            </div>
        </div>
    </div>
@endsection

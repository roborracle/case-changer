<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Case Changer Pro</h1>
            <p class="text-lg text-gray-600">Transform your text with precision and style</p>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Input Section --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="mb-4">
                    <label for="inputText" class="block text-sm font-medium text-gray-700 mb-2">
                        Input Text
                    </label>
                    <textarea
                        wire:model.live="inputText"
                        id="inputText"
                        rows="12"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        placeholder="Enter or paste your text here..."
                        aria-label="Input text to transform"
                        aria-describedby="text-stats"
                    ></textarea>
                </div>
                
                {{-- Error Display --}}
                @if($errorMessage)
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-700 text-sm">{{ $errorMessage }}</p>
                    </div>
                @endif

                {{-- Text Statistics --}}
                <div id="text-stats" class="grid grid-cols-3 gap-4 text-center" role="region" aria-label="Text statistics">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Characters</p>
                        <p class="text-2xl font-bold text-gray-900" aria-live="polite">{{ $stats['characters'] }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Words</p>
                        <p class="text-2xl font-bold text-gray-900" aria-live="polite">{{ $stats['words'] }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Sentences</p>
                        <p class="text-2xl font-bold text-gray-900" aria-live="polite">{{ $stats['sentences'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Output Section --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <label for="outputText" class="block text-sm font-medium text-gray-700">
                            Transformed Text
                        </label>
                        <button
                            wire:click="copyToClipboard"
                            class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            @if($copied)
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Copied!
                            @else
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Copy
                            @endif
                        </button>
                    </div>
                    <textarea
                        id="outputText"
                        wire:model="outputText"
                        rows="12"
                        readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 resize-none"
                        placeholder="Transformed text will appear here..."
                        aria-label="Transformed output text"
                        aria-live="polite"
                    ></textarea>
                </div>

                {{-- Clear and Reset Buttons --}}
                <div class="flex gap-2">
                    <button
                        wire:click="$set('text', '')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        Clear Text
                    </button>
                    <button
                        wire:click="$set('transformedText', '')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        Clear Output
                    </button>
                </div>
            </div>
        </div>

        {{-- Transformation Options --}}
        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Transformation Options</h2>

            {{-- Basic Transformations --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Basic Transformations</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <button wire:click="transformToTitleCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600">
                        Title Case
                    </button>
                    <button wire:click="transformToSentenceCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600">
                        Sentence case
                    </button>
                    <button wire:click="transformToUpperCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600">
                        UPPERCASE
                    </button>
                    <button wire:click="transformToLowerCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600">
                        lowercase
                    </button>
                    <button wire:click="transformToFirstLetter" class="btn-transform bg-blue-500 text-white hover:bg-blue-600">
                        First Letter
                    </button>
                    <button wire:click="transformToAlternatingCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600">
                        aLtErNaTiNg
                    </button>
                    <button wire:click="transformToRandomCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600">
                        RaNDoM
                    </button>
                </div>
            </div>

            {{-- Style Guide Formatters --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Style Guide Formatters</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <button wire:click="applyApaStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600">
                        APA Style
                    </button>
                    <button wire:click="applyChicagoStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600">
                        Chicago
                    </button>
                    <button wire:click="applyApStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600">
                        AP Style
                    </button>
                    <button wire:click="applyMlaStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600">
                        MLA Style
                    </button>
                    <button wire:click="applyBluebookStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600">
                        Bluebook
                    </button>
                    <button wire:click="applyAmaStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600">
                        AMA Style
                    </button>
                    <button wire:click="applyNyTimesStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600">
                        NY Times
                    </button>
                    <button wire:click="applyWikipediaStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600">
                        Wikipedia
                    </button>
                </div>
            </div>

            {{-- Advanced Options Toggle --}}
            <div class="border-t pt-4">
                <button
                    wire:click="toggleAdvancedOptions"
                    class="flex items-center justify-between w-full text-left"
                >
                    <span class="text-lg font-semibold text-gray-700">Advanced Options</span>
                    <svg
                        class="w-5 h-5 text-gray-500 transform transition-transform {{ $showAdvancedOptions ? 'rotate-180' : '' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                @if($showAdvancedOptions)
                    <div class="mt-4 space-y-4" x-show="true" x-transition>
                        {{-- Preposition Fixer --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-700">Fix Prepositions</label>
                                <button
                                    wire:click="fixPrepositions"
                                    class="px-3 py-1 bg-purple-500 text-white rounded-md hover:bg-purple-600 text-sm"
                                >
                                    Apply
                                </button>
                            </div>
                            <p class="text-xs text-gray-500">Lowercase prepositions under {{ $prepositionMaxLength }} letters</p>
                            <div class="mt-2">
                                <label class="text-xs text-gray-600">Max Length:</label>
                                <input
                                    type="number"
                                    wire:model="prepositionMaxLength"
                                    min="2"
                                    max="10"
                                    class="ml-2 w-16 px-2 py-1 text-sm border border-gray-300 rounded"
                                >
                            </div>
                        </div>

                        {{-- Smart Quotes --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-700">Smart Quotes</label>
                                <button
                                    wire:click="convertToSmartQuotes"
                                    class="px-3 py-1 bg-purple-500 text-white rounded-md hover:bg-purple-600 text-sm"
                                >
                                    Convert
                                </button>
                            </div>
                            <p class="text-xs text-gray-500">Convert straight quotes to curly quotes</p>
                        </div>

                        {{-- Space Management --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-700">Space Management</label>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    wire:click="removeExtraSpaces"
                                    class="flex-1 px-3 py-1 bg-purple-500 text-white rounded-md hover:bg-purple-600 text-sm"
                                >
                                    Remove Extra
                                </button>
                                <button
                                    wire:click="addSpaces"
                                    class="flex-1 px-3 py-1 bg-purple-500 text-white rounded-md hover:bg-purple-600 text-sm"
                                >
                                    Add Spaces
                                </button>
                            </div>
                        </div>

                        {{-- Underscore Conversion --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-700">Underscore Conversion</label>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    wire:click="spacesToUnderscores"
                                    class="flex-1 px-3 py-1 bg-purple-500 text-white rounded-md hover:bg-purple-600 text-sm"
                                >
                                    Spaces → _
                                </button>
                                <button
                                    wire:click="underscoresToSpaces"
                                    class="flex-1 px-3 py-1 bg-purple-500 text-white rounded-md hover:bg-purple-600 text-sm"
                                >
                                    _ → Spaces
                                </button>
                            </div>
                        </div>

                        {{-- Developer Naming Conventions --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-700">Developer Cases</label>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <button
                                    wire:click="transformToCamelCase"
                                    class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 text-sm"
                                >
                                    camelCase
                                </button>
                                <button
                                    wire:click="transformToSnakeCase"
                                    class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 text-sm"
                                >
                                    snake_case
                                </button>
                                <button
                                    wire:click="transformToKebabCase"
                                    class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 text-sm"
                                >
                                    kebab-case
                                </button>
                                <button
                                    wire:click="transformToPascalCase"
                                    class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 text-sm"
                                >
                                    PascalCase
                                </button>
                                <button
                                    wire:click="transformToConstantCase"
                                    class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 text-sm col-span-2"
                                >
                                    CONSTANT_CASE
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Toast Notification --}}
        @if($copied)
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 2000)"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg"
            >
                Text copied to clipboard!
            </div>
        @endif
    </div>
</div>

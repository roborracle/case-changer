<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Case Changer Pro</h1>
            <p class="text-lg text-gray-600">Transform your text with precision and style</p>
        </div>

        {{-- Development Status Banner --}}
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <h3 class="text-yellow-800 font-semibold mb-2">🚧 Under Active Development</h3>
            <p class="text-yellow-700 text-sm">
                We're actively building 35+ additional case styles, smart features, and a completely redesigned interface. 
                <span class="font-medium">Coming in the next 2 weeks!</span>
            </p>
            <details class="mt-2">
                <summary class="text-yellow-800 font-medium cursor-pointer hover:text-yellow-900">View upcoming features →</summary>
                <ul class="mt-2 text-sm text-yellow-700 space-y-1">
                    <li>• 19 additional case transformations (dot.case, path/case, Header-Case, sPoNgEbOb, etc.)</li>
                    <li>• 8 additional style guides (IEEE, Harvard, Vancouver, OSCOLA, Reuters, Bloomberg, etc.)</li>
                    <li>• Smart preservation system (URLs, emails, brand names like iPhone, eBay)</li>
                    <li>• Undo/redo system with visual timeline (last 20 transformations)</li>
                    <li>• Partial text selection conversion (highlight and convert)</li>
                    <li>• Smart format detection and auto-suggestions</li>
                    <li>• "Fix My Mess" intelligent text repair (caps lock, PDF paste issues)</li>
                    <li>• Visual diff highlighting (split view showing changes)</li>
                    <li>• Recent conversions history sidebar</li>
                    <li>• Batch processing options (line-by-line, paragraph-by-paragraph)</li>
                    <li>• Enhanced copy options (plain text, Markdown, HTML)</li>
                    <li>• Keyboard shortcuts (Cmd+1-5 for quick transforms)</li>
                    <li>• Completely redesigned mobile-first interface</li>
                    <li>• Dark mode and high contrast accessibility options</li>
                    <li>• Progressive Web App (install to home screen)</li>
                </ul>
            </details>
        </div>

        {{-- Implementation Progress Tracker --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="text-blue-800 font-semibold mb-3">📊 Implementation Progress</h3>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-blue-700">Basic Transformations</span>
                        <span class="font-medium text-blue-800">26/26 complete (100%)</span>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 100%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-blue-700">Style Guides</span>
                        <span class="font-medium text-blue-800">16/16 complete (100%)</span>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 100%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-blue-700">Smart Features</span>
                        <span class="font-medium text-blue-800">0/10 complete (0%)</span>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-gray-300 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-blue-700">UI/UX Design</span>
                        <span class="font-medium text-blue-800">2/10 complete (20%)</span>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 20%"></div>
                    </div>
                </div>
            </div>
            <p class="text-xs text-blue-600 mt-2">
                Current status: Core functionality working, expanding to full feature set
            </p>
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
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">Basic Transformations</h3>
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                        26/26 Available
                    </span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    {{-- Working transformations --}}
                    <button wire:click="transformToTitleCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        Title Case
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToSentenceCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        Sentence case
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToUpperCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        UPPERCASE
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToLowerCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        lowercase
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToFirstLetter" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        First Letter
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToAlternatingCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        aLtErNaTiNg
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToRandomCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        RaNDoM
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    
                    {{-- New working transformations --}}
                    <button wire:click="transformToDotCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        dot.case
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToPathCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        path/case
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToHeaderCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        Header-Case
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToTrainCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        Train-Case
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToSpongebobCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        sPoNgEbOb
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToInverseCase" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        InVeRsE
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToReversedText" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        txeT esreveR
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToNoWhitespace" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        RemoveSpaces
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    
                    {{-- Additional working transformations --}}
                    <button wire:click="transformToWideText" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        Ｗｉｄｅ Ｔｅｘｔ
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToSmallCaps" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        SMALL CAPS
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToStrikethrough" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        S̶t̶r̶i̶k̶e̶
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToZalgoText" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        Z̷a̸l̷g̸o̷
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToUpsideDown" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        ɟlᴉԀ
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="transformToBinary" class="btn-transform bg-blue-500 text-white hover:bg-blue-600 relative">
                        01000010
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    ✅ Green dot = Working now • 🚧 "Soon" = Coming in next 2 weeks
                </p>
            </div>

            {{-- Style Guide Formatters --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">Style Guide Formatters</h3>
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                        8/16 Available
                    </span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    {{-- Working style guides --}}
                    <button wire:click="applyApaStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        APA Style
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyChicagoStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        Chicago
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyApStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        AP Style
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyMlaStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        MLA Style
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyBluebookStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        Bluebook
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyAmaStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        AMA Style
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyNyTimesStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        NY Times
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyWikipediaStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        Wikipedia
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    
                    {{-- New working style guides --}}
                    <button wire:click="applyIeeeStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        IEEE
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyHarvardStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        Harvard
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyVancouverStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        Vancouver
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyOscolaStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        OSCOLA
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyReutersStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        Reuters
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyBloombergStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        Bloomberg
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyOxfordStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        Oxford
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                    <button wire:click="applyCambridgeStyle" class="btn-transform bg-green-500 text-white hover:bg-green-600 relative">
                        Cambridge
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Professional style guides for academic, legal, and media writing
                </p>
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

            {{-- Smart Features Coming Soon --}}
            <div class="border-t pt-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">🔮 Smart Features</h3>
                    <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">
                        Coming Soon
                    </span>
                </div>
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-lg p-4">
                    <p class="text-sm text-purple-700 mb-3 font-medium">
                        🚧 Advanced intelligent features currently in development:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div class="flex items-center text-purple-600">
                            <span class="mr-2">🧠</span>
                            Smart Preservation (URLs, emails, brand names)
                        </div>
                        <div class="flex items-center text-purple-600">
                            <span class="mr-2">↩️</span>
                            Undo/Redo with Visual Timeline
                        </div>
                        <div class="flex items-center text-purple-600">
                            <span class="mr-2">🎯</span>
                            Partial Text Selection Conversion
                        </div>
                        <div class="flex items-center text-purple-600">
                            <span class="mr-2">🔍</span>
                            Smart Format Detection & Auto-Suggest
                        </div>
                        <div class="flex items-center text-purple-600">
                            <span class="mr-2">🛠️</span>
                            "Fix My Mess" Intelligent Text Repair
                        </div>
                        <div class="flex items-center text-purple-600">
                            <span class="mr-2">📊</span>
                            Visual Diff Highlighting (Split View)
                        </div>
                        <div class="flex items-center text-purple-600">
                            <span class="mr-2">📋</span>
                            Enhanced Copy Options (Markdown, HTML)
                        </div>
                        <div class="flex items-center text-purple-600">
                            <span class="mr-2">⌨️</span>
                            Keyboard Shortcuts (Cmd+1-5)
                        </div>
                    </div>
                    <p class="text-xs text-purple-600 mt-3 italic">
                        These features will transform Case Changer into the most intelligent text processor available.
                    </p>
                </div>
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

{{-- Style Guide Selector Component for Title Case --}}
@props(['activeTab' => 'title-case'])

<div 
    x-data="styleGuideSelector()"
    x-show="'{{ $activeTab }}' === 'title-case'"
    class="inline-block"
>
    <div class="relative">
        <label for="style-guide" class="sr-only">Style Guide</label>
        <select
            id="style-guide"
            x-model="selectedStyle"
            @change="handleStyleChange"
            class="w-40 px-4 py-2 pr-8 text-sm font-medium bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-2 border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 dark:focus:border-blue-400 focus:outline-none transition-colors appearance-none cursor-pointer"
        >
            <option value="general">General</option>
            <option value="ap">AP Style</option>
            <option value="chicago">Chicago Style</option>
            <option value="mla">MLA Style</option>
            <option value="apa">APA Style</option>
            <option value="ieee">IEEE Style</option>
        </select>
        
        {{-- Custom Dropdown Arrow --}}
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
    
    {{-- Style Guide Info Tooltip --}}
    <div 
        x-show="showTooltip"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.away="showTooltip = false"
        class="absolute z-10 mt-2 p-3 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 max-w-xs"
    >
        <p class="text-sm text-gray-600 dark:text-gray-400" x-text="styleDescription"></p>
    </div>
</div>
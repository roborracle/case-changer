@props([
    'popularTools' => [
        ['id' => 'uppercase', 'name' => 'UPPERCASE', 'icon' => 'A'],
        ['id' => 'lowercase', 'name' => 'lowercase', 'icon' => 'a'],
        ['id' => 'title-case', 'name' => 'Title Case', 'icon' => 'Aa'],
        ['id' => 'camel-case', 'name' => 'camelCase', 'icon' => 'cC'],
        ['id' => 'snake-case', 'name' => 'snake_case', 'icon' => 's_c'],
    ],
    'allTools' => [],
    'currentTool' => null,
    'context' => 'homepage' // 'homepage' or 'category'
])

<div x-data="transformationSelector(@js($allTools), @js($currentTool))" 
     class="transformation-selector w-full"
     role="region"
     aria-label="Text transformation tool selector"
     @tool-selected.window="handleToolSelection($event)">
    
    <!-- Popular Tools Quick Access -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
            Quick Transformations
        </label>
        <div class="flex flex-wrap gap-2">
            @foreach($popularTools as $tool)
                <button
                    @click="selectTool('{{ $tool['id'] }}', '{{ $tool['name'] }}')"
                    :class="{ 
                        'ring-2 ring-blue-500 bg-blue-500/20': selectedTool === '{{ $tool['id'] }}',
                        'bg-white/10 hover:bg-white/20': selectedTool !== '{{ $tool['id'] }}'
                    }"
                    class="px-4 py-2 rounded-lg backdrop-blur-md border border-white/20 dark:border-white/10 
                           text-gray-800 dark:text-white transition-all duration-200 
                           hover:scale-105 hover:shadow-lg group"
                    aria-label="Transform to {{ $tool['name'] }}">
                    <span class="font-mono text-lg mr-2 group-hover:scale-110 inline-block transition-transform">
                        {{ $tool['icon'] }}
                    </span>
                    <span class="text-sm">{{ $tool['name'] }}</span>
                </button>
            @endforeach
            
            <!-- More Tools Dropdown Button -->
            <div class="relative" @keydown.escape="closeDropdown">
                <button
                    @click="toggleDropdown"
                    @keydown.escape="closeDropdown"
                    @keydown.arrow-down.prevent="dropdownOpen && navigateDown()"
                    :aria-expanded="dropdownOpen"
                    aria-haspopup="true"
                    id="transformation-selector-trigger"
                    class="px-4 py-2 rounded-lg backdrop-blur-md bg-gradient-to-r from-purple-500/20 to-pink-500/20
                           border border-purple-500/30 dark:border-purple-400/30 text-gray-800 dark:text-white
                           transition-all duration-200 hover:scale-105 hover:shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                    <span>All Tools</span>
                    <span class="text-xs bg-white/20 dark:bg-white/10 px-2 py-0.5 rounded-full">
                        <span x-text="Object.keys(allTools).length"></span>
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-200" 
                         :class="{'rotate-180': dropdownOpen}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <!-- Dropdown Menu -->
                <div x-show="dropdownOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     @click.outside="closeDropdown"
                     class="absolute right-0 z-50 mt-2 w-96 max-h-96 overflow-auto rounded-xl 
                            backdrop-blur-xl bg-white/95 dark:bg-gray-900/95 
                            border border-gray-200 dark:border-gray-700 shadow-2xl"
                     role="menu"
                     aria-orientation="vertical"
                     aria-labelledby="transformation-menu">
                    
                    <!-- Search Input -->
                    <div class="sticky top-0 p-3 border-b border-gray-200 dark:border-gray-700 bg-white/90 dark:bg-gray-900/90 backdrop-blur">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text"
                                   x-model="searchQuery"
                                   x-ref="searchInput"
                                   @input="filterTools"
                                   @keydown.down.prevent="navigateDown"
                                   @keydown.up.prevent="navigateUp"
                                   @keydown.enter.prevent="selectHighlighted"
                                   @keydown.escape="closeDropdown"
                                   placeholder="Search transformations..."
                                   aria-label="Search transformations"
                                   aria-controls="tools-list"
                                   aria-autocomplete="list"
                                   class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                                          bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                          placeholder-gray-500 dark:placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            <span x-text="filteredToolsCount"></span> tools found
                        </div>
                    </div>
                    
                    <!-- Tools List -->
                    <div class="p-2 max-h-80 overflow-y-auto" id="tools-list" role="group">
                        <template x-for="(category, categoryName) in filteredTools" :key="categoryName">
                            <div class="mb-3">
                                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider px-2 mb-1"
                                    x-text="categoryName"></h3>
                                <div class="space-y-1">
                                    <template x-for="tool in category" :key="tool.id">
                                        <button
                                            @click="selectTool(tool.id, tool.name); closeDropdown()"
                                            :class="{
                                                'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400': selectedTool === tool.id,
                                                'hover:bg-gray-100 dark:hover:bg-gray-800': selectedTool !== tool.id
                                            }"
                                            class="w-full text-left px-3 py-2 rounded-lg transition-colors duration-150
                                                   text-sm text-gray-700 dark:text-gray-300 flex items-center justify-between group"
                                            role="menuitem">
                                            <span>
                                                <span class="font-medium" x-text="tool.name"></span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2" x-text="tool.description"></span>
                                            </span>
                                            <svg x-show="selectedTool === tool.id" 
                                                 class="w-4 h-4 text-blue-500"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                        
                        <!-- No Results Message -->
                        <div x-show="filteredToolsCount === 0" 
                             class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm">No transformations found</p>
                            <p class="text-xs mt-1">Try a different search term</p>
                        </div>
                    </div>
                    
                    <!-- Keyboard Shortcuts Footer -->
                    <div class="sticky bottom-0 px-3 py-2 border-t border-gray-200 dark:border-gray-700 
                                bg-gray-50/90 dark:bg-gray-800/90 backdrop-blur text-xs text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-2">
                            <kbd class="px-1.5 py-0.5 bg-white dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600">↑↓</kbd>
                            Navigate
                            <kbd class="px-1.5 py-0.5 bg-white dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600">Enter</kbd>
                            Select
                            <kbd class="px-1.5 py-0.5 bg-white dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600">Esc</kbd>
                            Close
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Current Selection Display -->
    <div x-show="selectedTool" 
         x-transition
         class="mt-3 px-3 py-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
        <span class="text-sm text-blue-700 dark:text-blue-300">
            Selected: <strong x-text="selectedToolName"></strong>
        </span>
    </div>
    
    <!-- Screen Reader Announcements -->
    <div class="sr-only" aria-live="polite" aria-atomic="true">
        <span x-text="selectedTool ? `${selectedToolName} transformation selected` : ''"></span>
    </div>
</div>
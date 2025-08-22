<div class="glassmorphism-container min-h-screen relative overflow-hidden">
    <!-- Floating Orbs Background -->
    <div class="floating-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
        <div class="orb orb-5"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 container mx-auto px-4 py-8">
        <!-- Header with Smart Context Bar -->
        <header class="glass-secondary mb-8 p-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Case Changer Pro</h1>
                <p class="text-white/70">Transform your text with 50+ professional tools</p>
            </div>
            
            <!-- Context Indicator -->
            @if($detectedContext)
            <div class="context-badge glass-tertiary px-4 py-2">
                <span class="text-white/90 text-sm">Detected: {{ $detectedContext }}</span>
            </div>
            @endif
        </header>

        <!-- Contextual Suggestions Bar -->
        @if(count($suggestions) > 0)
        <div class="glass-tertiary mb-6 p-4">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span class="text-white/90 text-sm font-medium">Quick Actions for Your Text</span>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($suggestions as $suggestion)
                <button wire:click="transform('{{ $suggestion['type'] }}')" 
                        class="typography-button typography-{{ $suggestion['style'] }} magnetic-hover">
                    {{ $suggestion['label'] }}
                </button>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Three-Tier Glass Architecture -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Primary Workspace (Tier 1) - 40% Visual Weight -->
            <div class="lg:col-span-7">
                <div class="glass-primary p-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Your Text</h2>
                    
                    <!-- Input Area -->
                    <div class="mb-6">
                        <textarea 
                            wire:model.live="inputText"
                            wire:input="analyzeText"
                            placeholder="Paste or type your text here..."
                            class="w-full min-h-[300px] p-4 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:border-white/30 transition-all resize-none custom-scrollbar"
                        ></textarea>
                        
                        <!-- Character Count & Analysis -->
                        <div class="mt-3 flex items-center justify-between text-white/60 text-sm">
                            <span>{{ strlen($inputText) }} characters | {{ str_word_count($inputText) }} words</span>
                            @if($textAnalysis)
                            <span class="text-white/80">{{ $textAnalysis }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Output Area -->
                    @if($outputText)
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-lg font-medium text-white">Result</h3>
                            <button wire:click="copyToClipboard" 
                                    class="glass-button-secondary flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Copy
                            </button>
                        </div>
                        <div class="p-4 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl">
                            <pre class="text-white whitespace-pre-wrap break-words">{{ $outputText }}</pre>
                        </div>
                    </div>
                    @endif

                    <!-- History Ribbon -->
                    @if(count($history) > 0)
                    <div class="border-t border-white/10 pt-4">
                        <h4 class="text-sm font-medium text-white/70 mb-2">Recent Transformations</h4>
                        <div class="flex gap-2 overflow-x-auto custom-scrollbar pb-2">
                            @foreach(array_slice($history, -5) as $item)
                            <button wire:click="restoreFromHistory({{ $loop->index }})" 
                                    class="glass-button-tertiary text-xs whitespace-nowrap">
                                {{ $item['transformation'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Secondary Quick Actions (Tier 2) - 35% Visual Weight -->
            <div class="lg:col-span-5">
                <div class="glass-secondary p-5">
                    <h2 class="text-lg font-semibold text-white mb-4">Popular Transformations</h2>
                    
                    <!-- Most Used Tools Grid -->
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        @foreach($popularTransformations as $transform)
                        <button wire:click="transform('{{ $transform['type'] }}')" 
                                class="typography-button typography-{{ $transform['style'] }} h-12 magnetic-hover">
                            {{ $transform['label'] }}
                        </button>
                        @endforeach
                    </div>

                    <!-- Category Filters -->
                    <div class="border-t border-white/10 pt-4">
                        <h3 class="text-sm font-medium text-white/70 mb-3">Categories</h3>
                        <div class="flex flex-wrap gap-2">
                            <button wire:click="$set('activeCategory', 'all')" 
                                    class="category-pill {{ $activeCategory === 'all' ? 'active' : '' }}">
                                All Tools
                            </button>
                            <button wire:click="$set('activeCategory', 'case')" 
                                    class="category-pill {{ $activeCategory === 'case' ? 'active' : '' }}">
                                Case
                            </button>
                            <button wire:click="$set('activeCategory', 'style')" 
                                    class="category-pill {{ $activeCategory === 'style' ? 'active' : '' }}">
                                Style
                            </button>
                            <button wire:click="$set('activeCategory', 'developer')" 
                                    class="category-pill {{ $activeCategory === 'developer' ? 'active' : '' }}">
                                Developer
                            </button>
                            <button wire:click="$set('activeCategory', 'creative')" 
                                    class="category-pill {{ $activeCategory === 'creative' ? 'active' : '' }}">
                                Creative
                            </button>
                        </div>
                    </div>

                    <!-- Batch Operations -->
                    <div class="border-t border-white/10 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-white/70 mb-3">Batch Operations</h3>
                        <div class="space-y-2">
                            <button wire:click="toggleBatchMode" 
                                    class="w-full glass-button-secondary text-left flex items-center justify-between">
                                <span>Process Multiple Files</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </button>
                            <button wire:click="toggleChainMode" 
                                    class="w-full glass-button-secondary text-left flex items-center justify-between">
                                <span>Chain Transformations</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tertiary Advanced Drawer (Tier 3) - 25% Visual Weight -->
        <div class="mt-6">
            <button wire:click="toggleAdvancedDrawer" 
                    class="glass-button-primary mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <span>{{ $showAdvanced ? 'Hide' : 'Show' }} All Tools ({{ $totalTools }})</span>
                <svg class="w-4 h-4 transition-transform {{ $showAdvanced ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            @if($showAdvanced)
            <div class="glass-tertiary p-6" wire:transition.scale.origin.top>
                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input wire:model.live="searchTerm" 
                               type="text" 
                               placeholder="Search all {{ $totalTools }} transformations..."
                               class="w-full pl-10 pr-4 py-3 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:border-white/30">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- All Tools Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                    @foreach($filteredTools as $tool)
                    <button wire:click="transform('{{ $tool['type'] }}')" 
                            class="typography-button typography-{{ $tool['style'] }} h-10 text-sm magnetic-hover"
                            title="{{ $tool['description'] }}">
                        {{ $tool['label'] }}
                    </button>
                    @endforeach
                </div>

                <!-- Advanced Settings -->
                <div class="mt-6 pt-6 border-t border-white/10">
                    <h3 class="text-sm font-medium text-white/70 mb-4">Advanced Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center gap-3 text-white/80">
                            <input type="checkbox" wire:model="preserveFormatting" 
                                   class="w-4 h-4 rounded bg-white/10 border-white/20">
                            <span>Preserve original formatting</span>
                        </label>
                        <label class="flex items-center gap-3 text-white/80">
                            <input type="checkbox" wire:model="smartDetection" 
                                   class="w-4 h-4 rounded bg-white/10 border-white/20">
                            <span>Smart entity detection</span>
                        </label>
                        <label class="flex items-center gap-3 text-white/80">
                            <input type="checkbox" wire:model="autoSuggest" 
                                   class="w-4 h-4 rounded bg-white/10 border-white/20">
                            <span>Auto-suggest transformations</span>
                        </label>
                        <label class="flex items-center gap-3 text-white/80">
                            <input type="checkbox" wire:model="realTimePreview" 
                                   class="w-4 h-4 rounded bg-white/10 border-white/20">
                            <span>Real-time preview</span>
                        </label>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Footer with Stats -->
        <footer class="mt-12 text-center text-white/60 text-sm">
            <p>{{ $totalTransformations }} transformations performed | {{ $uniqueUsersToday }} active users today</p>
            <div class="mt-2 flex justify-center gap-4">
                <a href="/writing-tools" class="hover:text-white/80 transition-colors">Writing Tools</a>
                <a href="/developer-tools" class="hover:text-white/80 transition-colors">Developer Tools</a>
                <a href="/creative-text" class="hover:text-white/80 transition-colors">Creative Text</a>
                <a href="/business-tools" class="hover:text-white/80 transition-colors">Business Tools</a>
            </div>
        </footer>
    </div>

    <!-- Toast Notifications -->
    @if($notification)
    <div class="fixed bottom-4 right-4 glass-notification px-6 py-3" wire:transition.scale>
        <p class="text-white">{{ $notification }}</p>
    </div>
    @endif
</div>

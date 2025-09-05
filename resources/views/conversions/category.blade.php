<x-layouts.app 
    :title="$category['name'] . ' - Case Changer Pro Tools'"
    :description="$category['description'] ?? 'Browse ' . count($tools) . ' professional ' . $category['name'] . ' tools. Transform your text instantly with our free online converters.'"
    :keywords="strtolower($category['name']) . ', text converter, case changer, ' . implode(', ', array_slice(array_column($tools, 'slug'), 0, 5))"
>
    <!-- Breadcrumb Navigation -->
    <nav class="bg-gray-50 dark:bg-gray-900 py-3" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="/" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Home</a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <a href="/conversions" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Conversions</a>
                </li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 dark:text-white font-medium">{{ $category['name'] }}</li>
            </ol>
        </div>
    </nav>

    <!-- Category Header -->
    <section class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ $category['name'] }}
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-300">
                            {{ $category['description'] ?? 'Professional text transformation tools for ' . $category['name'] }}
                        </p>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ count($tools) }} tools available
                            </span>
                        </div>
                    </div>
                    @if(isset($category['icon']))
                    <div class="hidden lg:block">
                        <div class="w-24 h-24 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center">
                            {!! $category['icon'] !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Tools Grid -->
                <div class="lg:col-span-3">
                    <!-- Filters Bar -->
                    <div class="mb-8 backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-lg p-4 shadow-lg">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <label for="sort" class="text-sm font-medium text-gray-700 dark:text-gray-300">Sort by:</label>
                                <select 
                                    id="sort" 
                                    name="sort"
                                    class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm focus:ring-blue-500 focus:border-blue-500"
                                    x-data
                                    x-on:change="window.location.href = '?sort=' + $event.target.value"
                                >
                                    <option value="name">Name</option>
                                    <option value="popular">Most Popular</option>
                                    <option value="newest">Newest</option>
                                </select>
                            </div>
                            <div class="relative">
                                <input 
                                    type="search" 
                                    placeholder="Search in category..."
                                    class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    x-data
                                    x-on:input.debounce.300ms="
                                        const query = $event.target.value;
                                        const cards = document.querySelectorAll('[data-tool-name]');
                                        cards.forEach(card => {
                                            const name = card.dataset.toolName.toLowerCase();
                                            card.style.display = name.includes(query.toLowerCase()) ? '' : 'none';
                                        });
                                    "
                                >
                                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Tools Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($tools as $tool)
                            <div 
                                class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02]"
                                data-tool-name="{{ strtolower($tool['name']) }}"
                            >
                                @if(isset($tool['is_popular']) && $tool['is_popular'])
                                <div class="flex justify-end mb-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                        Popular
                                    </span>
                                </div>
                                @endif
                                
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                    <a href="{{ route('conversions.tool', ['category' => $categorySlug, 'tool' => $tool['slug']]) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        {{ $tool['name'] }}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 dark:text-gray-300 mb-4">
                                    {{ Str::limit($tool['description'] ?? 'Transform your text with ' . $tool['name'], 120) }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <a 
                                        href="{{ route('conversions.tool', ['category' => $categorySlug, 'tool' => $tool['slug']]) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        Try Now
                                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    @if(isset($tool['usage_count']))
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($tool['usage_count']) }} uses
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500 dark:text-gray-400">No tools available in this category yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if(isset($tools) && method_exists($tools, 'links'))
                        <div class="mt-8">
                            {{ $tools->links() }}
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="mt-8 lg:mt-0">
                    <div class="sticky top-24 space-y-6">
                        <!-- Quick Filters -->
                        <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Filters</h3>
                            <div class="space-y-2">
                                <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-700 dark:text-gray-300">
                                    Most Popular
                                </button>
                                <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-700 dark:text-gray-300">
                                    Recently Added
                                </button>
                                <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-700 dark:text-gray-300">
                                    A-Z Alphabetical
                                </button>
                            </div>
                        </div>

                        <!-- Related Categories -->
                        @if(isset($relatedCategories) && count($relatedCategories) > 0)
                        <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Related Categories</h3>
                            <div class="space-y-2">
                                @foreach($relatedCategories as $related)
                                <a 
                                    href="{{ route('conversions.category', $related['slug']) }}"
                                    class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-700 dark:text-gray-300"
                                >
                                    {{ $related['name'] }}
                                    <span class="text-sm text-gray-500 dark:text-gray-400">({{ $related['tool_count'] ?? 0 }})</span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Category Stats -->
                        <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Category Statistics</h3>
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-400">Total Tools:</dt>
                                    <dd class="font-medium text-gray-900 dark:text-white">{{ count($tools) }}</dd>
                                </div>
                                @if(isset($category['total_uses']))
                                <div class="flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-400">Total Uses:</dt>
                                    <dd class="font-medium text-gray-900 dark:text-white">{{ number_format($category['total_uses']) }}</dd>
                                </div>
                                @endif
                                @if(isset($category['avg_rating']))
                                <div class="flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-400">Avg Rating:</dt>
                                    <dd class="font-medium text-gray-900 dark:text-white">
                                        {{ number_format($category['avg_rating'], 1) }}/5.0
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Schema.org Structured Data -->
    @push('schema')
    <script type="application/ld+json" nonce="{{ csp_nonce() }}">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $category['name'],
        'description' => $category['description'] ?? 'Browse ' . count($tools) . ' professional ' . $category['name'] . ' tools.',
        'url' => url()->current(),
        'numberOfItems' => count($tools),
        'itemListElement' => array_map(function($tool, $index) use ($category) {
            return [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $tool['name'],
                'url' => route('conversions.tool', ['category' => $categorySlug, 'tool' => $tool['slug']])
            ];
        }, $tools, array_keys($tools))
    ], JSON_UNESCAPED_SLASHES) !!}
    </script>
    @endpush
</x-layouts.app>
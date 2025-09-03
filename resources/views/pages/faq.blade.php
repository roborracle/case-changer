<x-layouts.app title="FAQ - Case Changer Pro">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-24">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 rounded-3xl p-12 shadow-2xl border border-white/50 dark:border-gray-700/50">
                <h1 class="text-5xl font-bold text-center mb-6 text-gray-900 dark:text-white">
                    Frequently Asked Questions
                </h1>
                <p class="text-xl text-center text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
                    Find answers to common questions about Case Changer Pro
                </p>
            </div>
        </div>
    </section>

    <!-- FAQ Categories -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Category Tabs -->
            <div x-data="faqAccordion" class="space-y-8">
                <!-- Category Navigation -->
                <div class="flex flex-wrap gap-2 justify-center mb-8">
                    <template x-for="(category, index) in categories" :key="index">
                        <button
                            @click="activeCategory = index"
                            :class="activeCategory === index ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                            class="px-4 py-2 rounded-lg font-medium transition-colors"
                            x-text="category.name">
                        </button>
                    </template>
                </div>

                <!-- FAQ Items -->
                <div class="space-y-4">
                    <template x-for="(faq, index) in currentCategoryFaqs" :key="index">
                        <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 rounded-xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                            <button
                                @click="toggleItem(index)"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition-colors">
                                <h3 class="font-semibold text-gray-900 dark:text-white pr-4" x-text="faq.question"></h3>
                                <svg
                                    class="w-5 h-5 text-gray-500 transition-transform duration-200"
                                    :class="{'rotate-180': isOpen(index)}"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div
                                x-show="isOpen(index)"
                                x-collapse
                                x-cloak
                                class="px-6 py-4 border-t border-gray-200/50 dark:border-gray-700/50 bg-gray-50/30 dark:bg-gray-900/30">
                                <p class="text-gray-700 dark:text-gray-300" x-html="faq.answer"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Still Have Questions -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="backdrop-blur-lg bg-gradient-to-br from-blue-100/50 to-purple-100/50 dark:from-gray-800/50 dark:to-gray-700/50 rounded-3xl p-12 shadow-xl border border-gray-200/30 dark:border-gray-700/30 text-center">
                <span class="text-5xl mb-6 block">🤔</span>
                <h2 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">Still Have Questions?</h2>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
                    Can't find the answer you're looking for? We're here to help!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/pages/contact" class="inline-block px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                        Contact Support
                    </a>
                    <a href="/conversions" class="inline-block px-8 py-4 bg-white dark:bg-gray-800 text-blue-600 dark:text-blue-400 font-semibold rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors shadow-lg">
                        Explore Tools
                    </a>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script nonce="{{ csp_nonce() }}">
        // FAQ data will be registered in app.js as Alpine component
    </script>
    @endpush
</x-layouts.app>
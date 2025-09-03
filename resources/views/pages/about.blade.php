<x-layouts.app title="About - Case Changer Pro">
    <!-- Hero Section with Glassmorphism -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-24">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 rounded-3xl p-12 shadow-2xl border border-white/50 dark:border-gray-700/50">
                <h1 class="text-5xl font-bold text-center mb-6 text-gray-900 dark:text-white">
                    About Case Changer Pro
                </h1>
                <p class="text-xl text-center text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
                    Your comprehensive text transformation toolkit with 210+ professional tools, 
                    designed for developers, writers, and content creators worldwide.
                </p>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Our Mission</h2>
                    <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">
                        We believe text transformation should be instant, secure, and accessible to everyone. 
                        Case Changer Pro was built to eliminate the friction in text formatting workflows.
                    </p>
                    <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">
                        Whether you're a developer needing to convert variable names, a writer formatting 
                        citations, or a social media manager creating engaging content, we have the tools you need.
                    </p>
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="backdrop-blur-sm bg-blue-50/50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200/30 dark:border-blue-700/30">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">210+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Text Tools</div>
                        </div>
                        <div class="backdrop-blur-sm bg-green-50/50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200/30 dark:border-green-700/30">
                            <div class="text-3xl font-bold text-green-600 dark:text-green-400">100%</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Client-Side</div>
                        </div>
                        <div class="backdrop-blur-sm bg-purple-50/50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-200/30 dark:border-purple-700/30">
                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">0ms</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Processing Time</div>
                        </div>
                        <div class="backdrop-blur-sm bg-orange-50/50 dark:bg-orange-900/20 rounded-xl p-4 border border-orange-200/30 dark:border-orange-700/30">
                            <div class="text-3xl font-bold text-orange-600 dark:text-orange-400">∞</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Free Uses</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="backdrop-blur-lg bg-gradient-to-br from-blue-100/50 to-purple-100/50 dark:from-gray-700/50 dark:to-gray-800/50 rounded-2xl p-8 shadow-xl border border-gray-200/30 dark:border-gray-700/30">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🚀</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Lightning Fast</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🔒</span>
                                <span class="font-semibold text-gray-900 dark:text-white">100% Private</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🌍</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Works Everywhere</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">💎</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Always Free</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                Why Choose Case Changer Pro?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                $features = [
                    ['icon' => '⚡', 'title' => 'Instant Processing', 'description' => 'All transformations happen instantly in your browser with zero latency.'],
                    ['icon' => '🔐', 'title' => 'Complete Privacy', 'description' => 'Your text never leaves your device. No servers, no tracking, no data storage.'],
                    ['icon' => '🎯', 'title' => 'Professional Tools', 'description' => 'From academic citations to code formatting, we cover every professional need.'],
                    ['icon' => '📱', 'title' => 'Mobile Optimized', 'description' => 'Works perfectly on all devices - desktop, tablet, and mobile.'],
                    ['icon' => '🌙', 'title' => 'Dark Mode', 'description' => 'Easy on the eyes with automatic dark mode support.'],
                    ['icon' => '♾️', 'title' => 'Unlimited Usage', 'description' => 'No limits, no quotas, no registration required. Use as much as you need.'],
                ];
                @endphp
                @foreach($features as $feature)
                <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 rounded-2xl p-6 shadow-lg border border-gray-200/50 dark:border-gray-700/50 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="text-4xl mb-4">{{ $feature['icon'] }}</div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ $feature['title'] }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $feature['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Technology Stack -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                Built with Modern Technology
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                $technologies = [
                    ['name' => 'Laravel', 'icon' => '🔴', 'description' => 'PHP Framework'],
                    ['name' => 'Alpine.js', 'icon' => '🏔️', 'description' => 'Reactive Framework'],
                    ['name' => 'Tailwind CSS', 'icon' => '🎨', 'description' => 'Utility-First CSS'],
                    ['name' => 'Vite', 'icon' => '⚡', 'description' => 'Build Tool'],
                ];
                @endphp
                @foreach($technologies as $tech)
                <div class="backdrop-blur-sm bg-gray-50/50 dark:bg-gray-700/50 rounded-xl p-6 text-center border border-gray-200/30 dark:border-gray-600/30">
                    <div class="text-3xl mb-2">{{ $tech['icon'] }}</div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $tech['name'] }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $tech['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Transform Your Text?</h2>
            <p class="text-xl text-blue-100 mb-8">
                Start using our 210+ professional text transformation tools today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/conversions" class="inline-block px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                    Browse All Tools
                </a>
                <a href="/pages/contact" class="inline-block px-8 py-4 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-400 transition-colors shadow-lg">
                    Get in Touch
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
@props(['showSocial' => true, 'showNewsletter' => false])

<footer class="bg-primary border-t mt-auto" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <h2 class="text-2xl font-bold text-primary mb-4">Case Changer Pro</h2>
                <p class="text-secondary mb-4">
                    Transform text instantly with 210+ professional tools. Fast, free, and easy to use.
                </p>
                <p class="text-sm text-tertiary">
                    &copy; {{ date('Y') }} Case Changer Pro. All rights reserved.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-primary mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/about" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="/contact" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            Contact
                        </a>
                    </li>
                    <li>
                        <a href="/faq" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="/sitemap" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            Sitemap
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Popular Tools -->
            <div>
                <h3 class="text-lg font-semibold text-primary mb-4">Popular Tools</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/conversions/case-conversions" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            Case Conversions
                        </a>
                    </li>
                    <li>
                        <a href="/conversions/developer-formats" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            Developer Formats
                        </a>
                    </li>
                    <li>
                        <a href="/conversions/text-effects" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            Text Effects
                        </a>
                    </li>
                    <li>
                        <a href="/conversions" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            View All Tools →
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="text-lg font-semibold text-primary mb-4">Legal</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/terms" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            Terms of Service
                        </a>
                    </li>
                    <li>
                        <a href="/privacy" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="/cookies" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            Cookie Policy
                        </a>
                    </li>
                    <li>
                        <a href="/disclaimer" class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm">
                            Disclaimer
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        @if($showNewsletter)
        <!-- Newsletter Section -->
        <div class="mt-12 pt-8 border-t">
            <div class="max-w-2xl mx-auto text-center">
                <h3 class="text-lg font-semibold text-primary mb-4">Stay Updated</h3>
                <p class="text-secondary mb-6">
                    Get notified about new tools and features.
                </p>
                <form x-data="newsletterForm" @submit.prevent="submitForm" class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input 
                        type="email" 
                        x-model="email"
                        placeholder="Enter your email"
                        required
                        class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-secondary text-primary"
                        aria-label="Email address for newsletter">
                    <button 
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($showSocial)
        <!-- Social Links -->
        <div class="mt-8 pt-8 border-t">
            <div class="flex justify-center space-x-6">
                <a href="#" 
                   class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm"
                   aria-label="Twitter"
                   rel="noopener noreferrer">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                    </svg>
                </a>

                <a href="#" 
                   class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm"
                   aria-label="GitHub"
                   rel="noopener noreferrer">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                    </svg>
                </a>

                <a href="#" 
                   class="text-secondary hover:text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-sm"
                   aria-label="LinkedIn"
                   rel="noopener noreferrer">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                    </svg>
                </a>
            </div>
        </div>
        @endif

        <!-- Bottom Bar -->
        <div class="mt-8 pt-8 border-t text-center">
            <p class="text-sm text-tertiary">
                Built with Laravel, Tailwind CSS, and Alpine.js
            </p>
            <p class="text-xs text-tertiary mt-2">
                Fast, secure, and privacy-focused text transformation
            </p>
        </div>
    </div>
</footer>
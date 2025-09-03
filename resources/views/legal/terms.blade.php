<x-layouts.app 
    title="Terms of Service - Case Changer Pro"
    description="Read the terms of service for using Case Changer Pro's text transformation tools. Learn about user rights, responsibilities, and service usage guidelines."
    keywords="terms of service, user agreement, legal terms, case changer pro"
>
    <!-- Breadcrumb Navigation -->
    <nav class="bg-gray-50 dark:bg-gray-900 py-3" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="/" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Home</a></li>
                <li class="text-gray-400">/</li>
                <li><span class="text-gray-500 dark:text-gray-400">Legal</span></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 dark:text-white font-medium">Terms of Service</li>
            </ol>
        </div>
    </nav>

    <article class="py-12 bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Table of Contents - Desktop -->
                <aside class="hidden lg:block lg:col-span-1">
                    <div class="sticky top-24">
                        <nav class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-xl p-6 shadow-lg">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Table of Contents</h2>
                            <ul class="space-y-2 text-sm">
                                <li><a href="#introduction" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">1. Introduction</a></li>
                                <li><a href="#acceptance" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">2. Acceptance of Terms</a></li>
                                <li><a href="#service-use" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">3. Use of Service</a></li>
                                <li><a href="#user-accounts" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">4. User Accounts</a></li>
                                <li><a href="#prohibited" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">5. Prohibited Uses</a></li>
                                <li><a href="#intellectual" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">6. Intellectual Property</a></li>
                                <li><a href="#disclaimers" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">7. Disclaimers</a></li>
                                <li><a href="#liability" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">8. Limitation of Liability</a></li>
                                <li><a href="#governing" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">9. Governing Law</a></li>
                                <li><a href="#contact" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">10. Contact Information</a></li>
                            </ul>
                        </nav>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="lg:col-span-3">
                    <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-2xl p-8 shadow-xl">
                        <!-- Header -->
                        <header class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Terms of Service</h1>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600 dark:text-gray-400">
                                <p>Last Updated: {{ config('app.legal.terms_updated', 'January 1, 2024') }}</p>
                                <div class="flex items-center space-x-4 mt-4 sm:mt-0">
                                    <button 
                                        onclick="window.print()"
                                        class="inline-flex items-center text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400"
                                        aria-label="Print this page"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                        </svg>
                                        Print
                                    </button>
                                </div>
                            </div>
                        </header>

                        <!-- Content Sections -->
                        <section id="introduction" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">1. Introduction</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Welcome to Case Changer Pro. These Terms of Service ("Terms") govern your use of our website and services (collectively, the "Service") operated by Case Changer Pro ("we", "us", or "our").
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                By accessing or using our Service, you agree to be bound by these Terms. If you disagree with any part of these terms, then you may not access the Service.
                            </p>
                        </section>

                        <section id="acceptance" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">2. Acceptance of Terms</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                By using Case Changer Pro, you confirm that:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>You are at least 13 years of age</li>
                                <li>You have the legal capacity to enter into binding agreements</li>
                                <li>You will use the Service in compliance with all applicable laws and regulations</li>
                                <li>You will not use the Service for any unlawful or prohibited purposes</li>
                            </ul>
                        </section>

                        <section id="service-use" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">3. Use of Service</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Case Changer Pro provides text transformation tools for personal and commercial use. You may:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4 mb-4">
                                <li>Access and use our text conversion tools</li>
                                <li>Process your own content through our tools</li>
                                <li>Share results from our tools</li>
                                <li>Use the Service for lawful commercial purposes</li>
                            </ul>
                            <p class="text-gray-700 dark:text-gray-300">
                                All text processing occurs in your browser. We do not store, transmit, or have access to the content you process through our tools.
                            </p>
                        </section>

                        <section id="user-accounts" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">4. User Accounts</h2>
                            <p class="text-gray-700 dark:text-gray-300">
                                Case Changer Pro does not require user accounts. The Service is available without registration, and we do not collect or store personal information unless you voluntarily provide it through contact forms.
                            </p>
                        </section>

                        <section id="prohibited" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">5. Prohibited Uses</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">You agree not to:</p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>Use the Service for any illegal or unauthorized purpose</li>
                                <li>Attempt to interfere with or disrupt the Service</li>
                                <li>Attempt to bypass any security measures</li>
                                <li>Use automated scripts to collect information or interact with the Service</li>
                                <li>Upload malicious code or content</li>
                                <li>Impersonate others or provide false information</li>
                                <li>Use the Service to violate others' intellectual property rights</li>
                            </ul>
                        </section>

                        <section id="intellectual" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">6. Intellectual Property</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                The Service and its original content, features, and functionality are owned by Case Changer Pro and are protected by international copyright, trademark, patent, trade secret, and other intellectual property laws.
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                You retain all rights to the content you process through our Service. We claim no ownership or control over your content.
                            </p>
                        </section>

                        <section id="disclaimers" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">7. Disclaimers</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                THE SERVICE IS PROVIDED "AS IS" AND "AS AVAILABLE" WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>Warranties of merchantability</li>
                                <li>Fitness for a particular purpose</li>
                                <li>Non-infringement</li>
                                <li>Accuracy or reliability of results</li>
                            </ul>
                        </section>

                        <section id="liability" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">8. Limitation of Liability</h2>
                            <p class="text-gray-700 dark:text-gray-300">
                                TO THE MAXIMUM EXTENT PERMITTED BY LAW, CASE CHANGER PRO SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, OR ANY LOSS OF PROFITS OR REVENUES, WHETHER INCURRED DIRECTLY OR INDIRECTLY, OR ANY LOSS OF DATA, USE, GOODWILL, OR OTHER INTANGIBLE LOSSES.
                            </p>
                        </section>

                        <section id="governing" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">9. Governing Law</h2>
                            <p class="text-gray-700 dark:text-gray-300">
                                These Terms shall be governed by and construed in accordance with the laws of the United States, without regard to its conflict of law provisions. Any disputes arising from these Terms shall be resolved in the courts of the United States.
                            </p>
                        </section>

                        <section id="contact" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">10. Contact Information</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                If you have any questions about these Terms, please contact us at:
                            </p>
                            <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-800/50 rounded-lg p-4">
                                <p class="text-gray-700 dark:text-gray-300">
                                    <strong>Email:</strong> legal@casechangerpro.com<br>
                                    <strong>Website:</strong> <a href="/" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">casechangerpro.com</a>
                                </p>
                            </div>
                        </section>
                    </div>
                </main>
            </div>
        </div>
    </article>

    @push('schema')
    <script type="application/ld+json" nonce="{{ csp_nonce() }}">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => 'Terms of Service',
        'description' => 'Terms of Service for Case Changer Pro text transformation tools',
        'url' => route('terms'),
        'inLanguage' => 'en-US',
        'dateModified' => config('app.legal.terms_updated', '2024-01-01'),
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Case Changer Pro',
            'url' => url('/')
        ]
    ], JSON_UNESCAPED_SLASHES) !!}
    </script>
    @endpush
</x-layouts.app>
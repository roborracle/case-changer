<x-layouts.app 
    title="Privacy Policy - Case Changer Pro"
    description="Learn how Case Changer Pro protects your privacy. Our privacy policy explains data collection, usage, and your rights regarding personal information."
    keywords="privacy policy, data protection, GDPR, CCPA, personal information, case changer pro"
>
    <!-- Breadcrumb Navigation -->
    <nav class="bg-gray-50 dark:bg-gray-900 py-3" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="/" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Home</a></li>
                <li class="text-gray-400">/</li>
                <li><span class="text-gray-500 dark:text-gray-400">Legal</span></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 dark:text-white font-medium">Privacy Policy</li>
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
                                <li><a href="#overview" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">1. Overview</a></li>
                                <li><a href="#information-collection" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">2. Information Collection</a></li>
                                <li><a href="#use-information" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">3. Use of Information</a></li>
                                <li><a href="#data-sharing" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">4. Data Sharing</a></li>
                                <li><a href="#cookies" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">5. Cookies & Tracking</a></li>
                                <li><a href="#security" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">6. Data Security</a></li>
                                <li><a href="#rights" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">7. Your Rights</a></li>
                                <li><a href="#children" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">8. Children's Privacy</a></li>
                                <li><a href="#international" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">9. International Transfers</a></li>
                                <li><a href="#changes" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">10. Policy Changes</a></li>
                                <li><a href="#contact-privacy" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">11. Contact Us</a></li>
                            </ul>
                        </nav>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="lg:col-span-3">
                    <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-900/70 rounded-2xl p-8 shadow-xl">
                        <!-- Header -->
                        <header class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Privacy Policy</h1>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600 dark:text-gray-400">
                                <p>Last Updated: {{ config('app.legal.privacy_updated', 'January 1, 2024') }}</p>
                                <p class="mt-2 sm:mt-0">GDPR & CCPA Compliant</p>
                            </div>
                        </header>

                        <!-- Privacy Shield Notice -->
                        <div class="backdrop-blur-lg bg-blue-50/50 dark:bg-blue-900/20 rounded-lg p-4 mb-8">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900 dark:text-blue-300">Your Privacy is Protected</p>
                                    <p class="text-sm text-blue-700 dark:text-blue-400">All text processing happens in your browser. We don't store or transmit your content.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Content Sections -->
                        <section id="overview" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">1. Overview</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Case Changer Pro ("we", "us", "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Key Privacy Features:</strong>
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4 mt-2">
                                <li>Client-side processing - your text never leaves your browser</li>
                                <li>No account registration required</li>
                                <li>Minimal data collection</li>
                                <li>No selling of personal data</li>
                            </ul>
                        </section>

                        <section id="information-collection" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">2. Information We Collect</h2>
                            
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Information You Provide</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4 mb-4">
                                <li><strong>Contact Information:</strong> Email address and name (only when you contact us)</li>
                                <li><strong>Feedback:</strong> Any feedback or suggestions you voluntarily provide</li>
                            </ul>

                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Information Collected Automatically</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4 mb-4">
                                <li><strong>Usage Data:</strong> Pages visited, time spent, click patterns</li>
                                <li><strong>Device Information:</strong> Browser type, operating system, screen resolution</li>
                                <li><strong>Location Data:</strong> Country and region (from IP address)</li>
                            </ul>

                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Information We DON'T Collect</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>Text content you process through our tools</li>
                                <li>Personal files or documents</li>
                                <li>Financial information</li>
                                <li>Social media credentials</li>
                            </ul>
                        </section>

                        <section id="use-information" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">3. How We Use Your Information</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">We use collected information for:</p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>Providing and maintaining our Service</li>
                                <li>Improving user experience</li>
                                <li>Analyzing usage patterns to enhance features</li>
                                <li>Responding to your inquiries</li>
                                <li>Sending service-related notifications</li>
                                <li>Detecting and preventing technical issues</li>
                                <li>Complying with legal obligations</li>
                            </ul>
                        </section>

                        <section id="data-sharing" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">4. Data Sharing and Disclosure</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                We do not sell, trade, or rent your personal information. We may share information only in these circumstances:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li><strong>Service Providers:</strong> With trusted third parties who assist in operating our website (e.g., hosting, analytics)</li>
                                <li><strong>Legal Requirements:</strong> When required by law or to protect rights and safety</li>
                                <li><strong>Business Transfers:</strong> In connection with a merger or acquisition</li>
                                <li><strong>Consent:</strong> With your explicit consent</li>
                            </ul>
                        </section>

                        <section id="cookies" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">5. Cookies and Tracking Technologies</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                We use cookies and similar tracking technologies to enhance your experience:
                            </p>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Purpose</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Essential</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Site functionality, security</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Session</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Preferences</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Remember settings (theme, language)</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">1 year</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Analytics</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">Understand usage patterns</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">2 years</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 mt-4">
                                You can control cookies through your browser settings. Note that disabling cookies may affect functionality.
                            </p>
                        </section>

                        <section id="security" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">6. Data Security</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                We implement appropriate technical and organizational measures to protect your information:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300 ml-4">
                                <li>SSL/TLS encryption for data transmission</li>
                                <li>Regular security audits and updates</li>
                                <li>Limited access to personal information</li>
                                <li>Secure hosting infrastructure</li>
                                <li>Client-side text processing (data never transmitted)</li>
                            </ul>
                        </section>

                        <section id="rights" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">7. Your Rights</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                Depending on your location, you may have the following rights:
                            </p>
                            
                            <!-- GDPR Rights -->
                            <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-800/50 rounded-lg p-4 mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">GDPR Rights (European Users)</h3>
                                <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300 ml-4">
                                    <li>Access your personal data</li>
                                    <li>Correct inaccurate data</li>
                                    <li>Request deletion of your data</li>
                                    <li>Object to data processing</li>
                                    <li>Data portability</li>
                                    <li>Withdraw consent</li>
                                </ul>
                            </div>

                            <!-- CCPA Rights -->
                            <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-800/50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">CCPA Rights (California Users)</h3>
                                <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300 ml-4">
                                    <li>Know what personal information is collected</li>
                                    <li>Know if information is sold or disclosed</li>
                                    <li>Say no to the sale of personal information</li>
                                    <li>Request deletion of personal information</li>
                                    <li>Non-discrimination for exercising rights</li>
                                </ul>
                            </div>
                        </section>

                        <section id="children" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">8. Children's Privacy</h2>
                            <p class="text-gray-700 dark:text-gray-300">
                                Our Service is not directed to children under 13. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe your child has provided us with personal information, please contact us immediately.
                            </p>
                        </section>

                        <section id="international" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">9. International Data Transfers</h2>
                            <p class="text-gray-700 dark:text-gray-300">
                                Your information may be transferred to and maintained on servers located outside your jurisdiction. We ensure appropriate safeguards are in place for such transfers in compliance with applicable data protection laws.
                            </p>
                        </section>

                        <section id="changes" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">10. Changes to This Privacy Policy</h2>
                            <p class="text-gray-700 dark:text-gray-300">
                                We may update our Privacy Policy periodically. Changes will be posted on this page with an updated "Last Updated" date. For material changes, we will provide prominent notice on our website.
                            </p>
                        </section>

                        <section id="contact-privacy" class="mb-8 scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">11. Contact Us</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                For questions about this Privacy Policy or to exercise your rights:
                            </p>
                            <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-800/50 rounded-lg p-4">
                                <p class="text-gray-700 dark:text-gray-300">
                                    <strong>Data Protection Officer</strong><br>
                                    Email: privacy@casechangerpro.com<br>
                                    Website: <a href="/" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">casechangerpro.com</a>
                                </p>
                            </div>
                        </section>

                        <!-- FAQ Section -->
                        <section class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Frequently Asked Questions</h2>
                            <div class="space-y-4" x-data="faqAccordion">
                                <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-800/50 rounded-lg">
                                    <button 
                                        x-on:click="toggle(1)"
                                        class="w-full px-4 py-3 text-left flex items-center justify-between hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                    >
                                        <span class="font-medium text-gray-900 dark:text-white">Do you store the text I convert?</span>
                                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{'rotate-180': openFaq === 1}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 1" x-collapse class="px-4 pb-3">
                                        <p class="text-gray-700 dark:text-gray-300">
                                            No. All text processing happens entirely in your browser. We never receive, store, or have access to the content you convert.
                                        </p>
                                    </div>
                                </div>

                                <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-800/50 rounded-lg">
                                    <button 
                                        x-on:click="toggle(2)"
                                        class="w-full px-4 py-3 text-left flex items-center justify-between hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                    >
                                        <span class="font-medium text-gray-900 dark:text-white">How can I delete my data?</span>
                                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{'rotate-180': openFaq === 2}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 2" x-collapse class="px-4 pb-3">
                                        <p class="text-gray-700 dark:text-gray-300">
                                            Since we don't require accounts and process text locally, there's minimal data to delete. To remove cookies and local storage, clear your browser data. For any personal information from contact forms, email us at privacy@casechangerpro.com.
                                        </p>
                                    </div>
                                </div>

                                <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-800/50 rounded-lg">
                                    <button 
                                        x-on:click="toggle(3)"
                                        class="w-full px-4 py-3 text-left flex items-center justify-between hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                    >
                                        <span class="font-medium text-gray-900 dark:text-white">Do you use tracking cookies?</span>
                                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{'rotate-180': openFaq === 3}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 3" x-collapse class="px-4 pb-3">
                                        <p class="text-gray-700 dark:text-gray-300">
                                            We use minimal cookies for essential functions and anonymous analytics to improve our service. We don't use tracking cookies for advertising or share data with third-party advertisers.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </main>
            </div>
        </div>
    </article>

    <!-- Print Styles -->
    @push('styles')
    <style>
        @media print {
            .backdrop-blur-lg {
                backdrop-filter: none;
                background-color: white;
            }
            nav, aside, button {
                display: none !important;
            }
        }
    </style>
    @endpush

    @push('schema')
    <script type="application/ld+json" nonce="{{ csp_nonce() }}">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => 'Privacy Policy',
        'description' => 'Privacy Policy for Case Changer Pro - Learn how we protect your data',
        'url' => route('privacy'),
        'inLanguage' => 'en-US',
        'dateModified' => config('app.legal.privacy_updated', '2024-01-01'),
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Case Changer Pro',
            'url' => url('/')
        ]
    ], JSON_UNESCAPED_SLASHES) !!}
    </script>
    @endpush
</x-layouts.app>
@extends('conversions.layout')

@section('title', 'FAQ - Frequently Asked Questions | Case Changer Pro')
@section('description', 'Find answers to commonly asked questions about Case Changer Pro text transformation tools.')

@section('content')
<div class="min-h-screen bg-secondary" >
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="rounded-xl shadow-sm bg-primary border" >
            <div class="p-8">
                <h1 class="text-3xl font-bold mb-8 text-primary" >Frequently Asked Questions</h1>

                <div class="space-y-8">
                    <!-- General Questions -->
                    <div>
                        <h2 class="text-2xl font-semibold mb-6 text-primary" >General Questions</h2>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >What is Case Changer Pro?</h3>
                                <p>Case Changer Pro is a comprehensive collection of over 100 text transformation tools. From simple case conversions to complex formatting, encoding, and generation tools, we provide everything you need to manipulate text efficiently.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Is Case Changer Pro free to use?</h3>
                                <p>Yes! All our tools are completely free to use. There are no hidden fees, subscriptions, or limits on usage. We believe everyone should have access to quality text transformation tools.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Do I need to create an account?</h3>
                                <p>No account is required. All tools work instantly without any sign-up process. Just visit the site and start transforming your text.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Is there a limit on text length?</h3>
                                <p>Most tools can handle texts up to 100,000 characters. For optimal performance, we recommend keeping texts under 50,000 characters. Very large texts may take a moment to process.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy & Security -->
                    <div>
                        <h2 class="text-2xl font-semibold mb-6 text-primary" >Privacy & Security</h2>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Is my text data stored anywhere?</h3>
                                <p>No. All text transformations happen directly in your browser using JavaScript. Your text never leaves your device and we don't store, log, or have access to any text you input.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Is it safe to use for sensitive information?</h3>
                                <p>Yes. Since all processing happens locally in your browser and no data is transmitted to our servers, it's safe to use for any text. However, always be cautious when working with sensitive information online.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Do you use cookies?</h3>
                                <p>We use minimal cookies only for remembering your theme preference (light/dark mode) and anonymous analytics to improve our service. No personal data is collected.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Questions -->
                    <div>
                        <h2 class="text-2xl font-semibold mb-6 text-primary" >Technical Questions</h2>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Which browsers are supported?</h3>
                                <p>Case Changer Pro works on all modern browsers including Chrome, Firefox, Safari, Edge, and Opera. For the best experience, we recommend using the latest version of your browser.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Does it work on mobile devices?</h3>
                                <p>Yes! Our website is fully responsive and works perfectly on smartphones and tablets. All tools are optimized for touch interfaces.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Can I use the tools offline?</h3>
                                <p>Currently, you need an internet connection to access the website. However, once a page is loaded, most tools will continue to work even if you lose connection since processing happens in your browser.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Why are some Unicode characters showing as boxes?</h3>
                                <p>Some special Unicode characters (like certain text effects) may not display correctly if your device doesn't have fonts that support them. This is a limitation of your device's font support, not our tools.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Features & Tools -->
                    <div>
                        <h2 class="text-2xl font-semibold mb-6 text-primary" >Features & Tools</h2>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >How many tools are available?</h3>
                                <p>We currently offer over 100 different text transformation tools across 18 categories, including case conversions, text effects, encoding/decoding, generators, and analysis tools.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Can I suggest a new tool?</h3>
                                <p>Absolutely! We love hearing from users. Send your tool suggestions to features@casechangerpro.com and we'll consider adding them to our collection.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >How do the text effect generators work?</h3>
                                <p>Text effects like bold, italic, and bubble text use special Unicode characters that look like styled versions of regular letters. These work anywhere that supports Unicode, including social media platforms.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >What's the difference between encoding and encryption?</h3>
                                <p>Encoding (like Base64 or URL encoding) transforms data into a different format for compatibility. Encryption (like our Caesar cipher) is designed to hide information. Our tools include both types for different use cases.</p>
                            </div>
                        </div>
                    </div>

                    <!-- API & Integration -->
                    <div>
                        <h2 class="text-2xl font-semibold mb-6 text-primary" >API & Integration</h2>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Is there an API available?</h3>
                                <p>We're currently developing a RESTful API for developers. It will allow you to integrate our text transformation tools into your own applications. Join our mailing list to be notified when it launches.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Can I embed tools on my website?</h3>
                                <p>We're working on embeddable widgets for our most popular tools. In the meantime, you're welcome to link to any of our tool pages from your website.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Is there a Chrome extension?</h3>
                                <p>A Chrome extension is in development. It will allow you to transform text directly on any webpage without visiting our site.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Support -->
                    <div>
                        <h2 class="text-2xl font-semibold mb-6 text-primary" >Support</h2>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >I found a bug. How do I report it?</h3>
                                <p>Please report bugs to bugs@casechangerpro.com with details about the tool, what you expected to happen, and what actually happened. Screenshots are helpful!</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >How can I contact support?</h3>
                                <p>For general inquiries, email us at hello@casechangerpro.com. For bug reports use bugs@casechangerpro.com, and for feature requests use features@casechangerpro.com.</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2 text-primary" >Do you offer premium support?</h3>
                                <p>Currently, all support is free. We aim to respond to all inquiries within 24-48 hours during business days.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Still have questions? -->
                <div class="mt-12 p-6 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                    <h3 class="text-xl font-semibold mb-3 text-primary" >
                    Still have questions?
                    </h3>
                    <p class="mb-4 text-secondary" >
                    We're here to help! If you couldn't find the answer you're looking for, please don't hesitate to reach out.
                    </p>
                    <a href="{{ route('contact') }}"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Contact Us
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
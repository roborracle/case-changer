@extends('conversions.layout')

@section('title', 'Contact - Case Changer Pro')
@section('description', 'Get in touch with Case Changer Pro team. Report bugs, suggest features, or ask questions.')

@section('content')
<div class="min-h-screen" style="background-color: var(--bg-secondary);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="rounded-xl shadow-sm" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);">
            <div class="p-8">
                <h1 class="text-3xl font-bold mb-8" style="color: var(--text-primary);">Contact Us</h1>
                
                <div class="prose prose-lg max-w-none" style="color: var(--text-secondary);">
                    <p class="text-lg mb-6">
                        We'd love to hear from you! Whether you have a question, suggestion, or just want to say hello, feel free to reach out.
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-8 my-8">
                        <div class="p-6 rounded-lg" style="background-color: var(--bg-secondary);">
                            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">
                                <span class="text-2xl mr-2">🐛</span> Report a Bug
                            </h2>
                            <p class="mb-4">Found something that's not working right? Let us know!</p>
                            <a href="mailto:bugs@casechangerpro.com" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                                bugs@casechangerpro.com
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <div class="p-6 rounded-lg" style="background-color: var(--bg-secondary);">
                            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">
                                <span class="text-2xl mr-2">💡</span> Suggest a Feature
                            </h2>
                            <p class="mb-4">Have an idea for a new tool or improvement?</p>
                            <a href="mailto:features@casechangerpro.com" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                                features@casechangerpro.com
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <div class="p-6 rounded-lg" style="background-color: var(--bg-secondary);">
                            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">
                                <span class="text-2xl mr-2">📧</span> General Inquiries
                            </h2>
                            <p class="mb-4">Questions, comments, or just want to chat?</p>
                            <a href="mailto:hello@casechangerpro.com" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                                hello@casechangerpro.com
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <div class="p-6 rounded-lg" style="background-color: var(--bg-secondary);">
                            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">
                                <span class="text-2xl mr-2">🤝</span> Partnerships
                            </h2>
                            <p class="mb-4">Interested in working together?</p>
                            <a href="mailto:partners@casechangerpro.com" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                                partners@casechangerpro.com
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-semibold mt-12 mb-6" style="color: var(--text-primary);">Frequently Asked Questions</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2" style="color: var(--text-primary);">How quickly will I get a response?</h3>
                            <p>We aim to respond to all inquiries within 24-48 hours during business days. Bug reports and critical issues are prioritized.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-2" style="color: var(--text-primary);">Can I request a custom tool?</h3>
                            <p>Absolutely! We love hearing ideas for new tools. Send your suggestions to features@casechangerpro.com and we'll consider adding them to our roadmap.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-2" style="color: var(--text-primary);">Do you offer an API?</h3>
                            <p>We're currently developing an API for developers. Join our mailing list to be notified when it launches.</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-2" style="color: var(--text-primary);">Is there a mobile app?</h3>
                            <p>Our website is fully responsive and works great on mobile devices. Native iOS and Android apps are in development.</p>
                        </div>
                    </div>
                    
                    <div class="mt-12 p-6 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                        <h3 class="text-lg font-semibold mb-3" style="color: var(--text-primary);">
                            <span class="text-2xl mr-2">💌</span> Stay Updated
                        </h3>
                        <p class="mb-4">Get notified about new tools, features, and updates.</p>
                        <form class="flex gap-3">
                            <input type="email" 
                                   placeholder="Enter your email" 
                                   class="flex-1 px-4 py-2 rounded-lg"
                                   style="background-color: var(--bg-primary); color: var(--text-primary); border: 1px solid var(--border-primary);">
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
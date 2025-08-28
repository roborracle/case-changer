@extends('conversions.layout')

@section('title', 'About - Case Changer Pro')
@section('description', 'Learn about Case Changer Pro - Your comprehensive text transformation toolkit with 172 tools for developers, writers, and content creators.')

@section('content')
<div class="min-h-screen bg-secondary" >
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="rounded-xl shadow-sm bg-primary border" >
            <div class="p-8">
                <h1 class="text-3xl font-bold mb-8 text-primary" >About Case Changer Pro</h1>

                <div class="prose prose-lg max-w-none text-secondary" >
                    <p class="text-lg leading-relaxed mb-6">
                    Case Changer Pro is your ultimate text transformation toolkit, offering over 100 specialized tools for converting, formatting, and manipulating text. Built for developers, writers, students, and content creators who need quick, reliable text transformations without the hassle.
                    </p>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >Why Case Changer Pro?</h2>

                    <div class="grid md:grid-cols-2 gap-6 my-8">
                        <div class="p-4 rounded-lg bg-secondary" >
                            <h3 class="text-lg font-semibold mb-2 text-primary" >🚀 Lightning Fast</h3>
                            <p>All transformations happen instantly in your browser. No server delays, no waiting.</p>
                        </div>

                        <div class="p-4 rounded-lg bg-secondary" >
                            <h3 class="text-lg font-semibold mb-2 text-primary" >🔒 100% Private</h3>
                            <p>Your text never leaves your device. We don't store, log, or see what you transform.</p>
                        </div>

                        <div class="p-4 rounded-lg bg-secondary" >
                            <h3 class="text-lg font-semibold mb-2 text-primary" >📱 Works Everywhere</h3>
                            <p>Responsive design that works perfectly on desktop, tablet, and mobile devices.</p>
                        </div>

                        <div class="p-4 rounded-lg bg-secondary" >
                            <h3 class="text-lg font-semibold mb-2 text-primary" >💰 Completely Free</h3>
                            <p>No subscriptions, no limits, no sign-ups. Just free tools that work.</p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >Our Tools</h2>
                    <p>We offer comprehensive tools across multiple categories:</p>

                    <ul class="list-disc pl-6 mt-4 space-y-2">
                        <li><strong>Case Conversions:</strong> UPPERCASE, lowercase, Title Case, Sentence case, and more</li>
                        <li><strong>Developer Tools:</strong> camelCase, snake_case, kebab-case, PascalCase, and programming formats</li>
                        <li><strong>Text Effects:</strong> Bold, italic, strikethrough, Unicode transformations</li>
                        <li><strong>Code & Data:</strong> JSON formatters, Base64 encoding, URL encoding, and more</li>
                        <li><strong>Academic Styles:</strong> APA, MLA, Chicago, Harvard formatting</li>
                        <li><strong>Social Media:</strong> Platform-specific text generators for Discord, Twitter, Instagram</li>
                        <li><strong>Creative Tools:</strong> Zalgo text, upside down text, mirror text, and fun effects</li>
                        <li><strong>Utility Tools:</strong> Remove duplicates, sort text, count words, and analyze content</li>
                    </ul>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >Who Uses Case Changer Pro?</h2>

                    <div class="space-y-4 my-6">
                        <div>
                            <h3 class="text-lg font-semibold text-primary" >👨‍💻 Developers</h3>
                            <p>Convert between variable naming conventions, format code, encode/decode data</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-primary" >✍️ Writers & Editors</h3>
                            <p>Format titles, apply style guides, clean up text, ensure consistency</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-primary" >🎓 Students & Academics</h3>
                            <p>Format citations, apply academic styles, prepare assignments</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-primary" >📱 Social Media Creators</h3>
                            <p>Generate unique text styles, create eye-catching posts, stand out online</p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >Our Commitment</h2>
                    <p>We believe text transformation tools should be:</p>
                    <ul class="list-disc pl-6 mt-4 space-y-2">
                        <li>Fast and efficient</li>
                        <li>Free and accessible to everyone</li>
                        <li>Private and secure</li>
                        <li>Simple to use without documentation</li>
                        <li>Available whenever you need them</li>
                    </ul>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >Get in Touch</h2>
                    <p>Have a suggestion for a new tool? Found a bug? Want to say hello?</p>
                    <p class="mt-4">
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Contact Us
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                    </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('conversions.layout')

@section('title', 'Terms of Service - Case Changer Pro')
@section('description', 'Terms of Service for Case Changer Pro - Read our terms and conditions for using our text transformation tools.')

@section('content')
<div class="min-h-screen" style="background-color: var(--bg-secondary);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="rounded-xl shadow-sm" style="background-color: var(--bg-primary); border: 1px solid var(--border-primary);">
            <div class="p-8">
                <h1 class="text-3xl font-bold mb-8" style="color: var(--text-primary);">Terms of Service</h1>
                
                <div class="prose prose-lg max-w-none" style="color: var(--text-secondary);">
                    <p class="text-sm mb-6" style="color: var(--text-tertiary);">Last updated: {{ date('F d, Y') }}</p>
                    
                    <h2 class="text-2xl font-semibold mt-8 mb-4" style="color: var(--text-primary);">1. Acceptance of Terms</h2>
                    <p>By accessing and using Case Changer Pro ("the Service"), you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our Service.</p>
                    
                    <h2 class="text-2xl font-semibold mt-8 mb-4" style="color: var(--text-primary);">2. Description of Service</h2>
                    <p>Case Changer Pro provides free online text transformation tools including case conversion, text formatting, and various text manipulation utilities. The Service is provided "as is" without warranties of any kind.</p>
                    
                    <h2 class="text-2xl font-semibold mt-8 mb-4" style="color: var(--text-primary);">3. Privacy and Data</h2>
                    <p>We respect your privacy. Text entered into our tools is processed in real-time and is not stored on our servers. We do not collect, store, or share the content you transform using our tools. For more information, please see our <a href="{{ route('privacy') }}" class="text-blue-600 hover:text-blue-700">Privacy Policy</a>.</p>
                    
                    <h2 class="text-2xl font-semibold mt-8 mb-4" style="color: var(--text-primary);">4. Acceptable Use</h2>
                    <p>You agree to use the Service only for lawful purposes. You may not use the Service to:</p>
                    <ul class="list-disc pl-6 mt-2">
                        <li>Process copyrighted content without permission</li>
                        <li>Generate harmful, offensive, or illegal content</li>
                        <li>Attempt to overload or disrupt our servers</li>
                        <li>Reverse engineer or attempt to extract the source code</li>
                    </ul>
                    
                    <h2 class="text-2xl font-semibold mt-8 mb-4" style="color: var(--text-primary);">5. Intellectual Property</h2>
                    <p>The Service, including its original content, features, and functionality, is owned by Case Changer Pro and is protected by international copyright, trademark, and other intellectual property laws.</p>
                    
                    <h2 class="text-2xl font-semibold mt-8 mb-4" style="color: var(--text-primary);">6. Limitation of Liability</h2>
                    <p>Case Changer Pro shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use or inability to use the Service.</p>
                    
                    <h2 class="text-2xl font-semibold mt-8 mb-4" style="color: var(--text-primary);">7. Changes to Terms</h2>
                    <p>We reserve the right to modify these Terms of Service at any time. Changes will be effective immediately upon posting to the website.</p>
                    
                    <h2 class="text-2xl font-semibold mt-8 mb-4" style="color: var(--text-primary);">8. Contact Information</h2>
                    <p>If you have any questions about these Terms of Service, please contact us at legal@casechangerpro.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
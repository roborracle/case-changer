@extends('conversions.layout')

@section('title', 'Privacy Policy - Case Changer Pro')
@section('description', 'Privacy Policy for Case Changer Pro - Learn how we protect your privacy and handle your data.')

@section('content')
<div class="min-h-screen bg-secondary" >
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="rounded-xl shadow-sm bg-primary border" >
            <div class="p-8">
                <h1 class="text-3xl font-bold mb-8 text-primary" >Privacy Policy</h1>

                <div class="prose prose-lg max-w-none text-secondary" >
                    <p class="text-sm mb-6 text-tertiary" >Last updated: {{ date('F d, Y') }}</p>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >1. Information We Don't Collect</h2>
                    <p>Case Changer Pro is designed with privacy in mind. We do NOT:</p>
                    <ul class="list-disc pl-6 mt-2">
                        <li>Store any text you input into our tools</li>
                        <li>Save your transformation history</li>
                        <li>Require account registration</li>
                        <li>Track individual user behavior</li>
                    </ul>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >2. Information We Collect</h2>
                    <p>We collect minimal, anonymous data to improve our service:</p>

                    <h3 class="text-xl font-semibold mt-6 mb-3 text-primary" >2.1 Analytics Data</h3>
                    <p>We use Google Analytics to understand general usage patterns:</p>
                    <ul class="list-disc pl-6 mt-2">
                        <li>Page views and popular tools</li>
                        <li>General geographic regions (country level)</li>
                        <li>Device types (mobile, desktop, tablet)</li>
                        <li>Browser types</li>
                    </ul>

                    <h3 class="text-xl font-semibold mt-6 mb-3 text-primary" >2.2 Technical Data</h3>
                    <p>Our servers may automatically log:</p>
                    <ul class="list-disc pl-6 mt-2">
                        <li>IP addresses (for security and abuse prevention)</li>
                        <li>Browser user agent strings</li>
                        <li>Referring URLs</li>
                    </ul>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >3. Cookies</h2>
                    <p>We use minimal cookies for:</p>
                    <ul class="list-disc pl-6 mt-2">
                        <li><strong>Theme Preference:</strong> Remembering your light/dark mode choice</li>
                        <li><strong>Analytics:</strong> Google Analytics cookies for anonymous statistics</li>
                    </ul>
                    <p class="mt-3">You can disable cookies in your browser settings without affecting core functionality.</p>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >4. Data Security</h2>
                    <p>All text transformations happen in your browser using JavaScript. Your text never leaves your device unless you explicitly copy and share it elsewhere. We use HTTPS encryption for all connections to our website.</p>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >5. Third-Party Services</h2>
                    <p>We use the following third-party services:</p>
                    <ul class="list-disc pl-6 mt-2">
                        <li><strong>Google Analytics:</strong> For anonymous usage statistics</li>
                        <li><strong>Cloudflare:</strong> For security and performance</li>
                    </ul>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >6. Children's Privacy</h2>
                    <p>Our Service is not directed to children under 13. We do not knowingly collect personal information from children under 13.</p>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >7. Your Rights</h2>
                    <p>Since we don't collect personal data, there's no personal information to access, modify, or delete. You can clear your browser's cookies and local storage at any time to remove any stored preferences.</p>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >8. Changes to This Policy</h2>
                    <p>We may update this Privacy Policy from time to time. Changes will be posted on this page with an updated revision date.</p>

                    <h2 class="text-2xl font-semibold mt-8 mb-4 text-primary" >9. Contact Us</h2>
                    <p>If you have questions about this Privacy Policy, please contact us at privacy@casechangerpro.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
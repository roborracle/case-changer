@extends('conversions.layout')

@section('title', 'Cookie Policy | Case Changer Pro')
@section('description', 'Learn how Case Changer Pro uses cookies to improve your text transformation experience.')

@section('content')
<div class="min-h-screen bg-secondary" >
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="rounded-xl shadow-sm bg-primary border" >
            <div class="p-8">
                <h1 class="text-3xl font-bold mb-8 text-primary" >Cookie Policy</h1>

                <div class="prose max-w-none space-y-6 text-secondary" >
                    <section>
                        <h2 class="text-2xl font-semibold mb-4 text-primary" >What Are Cookies?</h2>
                        <p>Cookies are small text files that are placed on your device when you visit our website. They help us provide you with a better experience by remembering your preferences and understanding how you use our site.</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4 text-primary" >How We Use Cookies</h2>
                        <p>Case Changer Pro uses cookies for the following purposes:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Theme Preferences:</strong> We store your choice of light or dark mode in a cookie so the site remembers your preference on future visits.</li>
                            <li><strong>Analytics:</strong> We use Google Analytics cookies to understand how visitors interact with our website, which helps us improve our services.</li>
                            <li><strong>Security:</strong> Essential cookies help us maintain the security and integrity of our website.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4 text-primary" >Types of Cookies We Use</h2>

                        <h3 class="text-xl font-semibold mb-3 text-primary" >Essential Cookies</h3>
                        <p>These cookies are necessary for the website to function properly:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><code>case-changer-theme</code>: Stores your theme preference (light/dark mode)</li>
                            <li><code>XSRF-TOKEN</code>: Helps prevent cross-site request forgery attacks</li>
                            <li><code>laravel_session</code>: Maintains your session state</li>
                        </ul>

                        <h3 class="text-xl font-semibold mb-3 mt-4 text-primary" >Analytics Cookies</h3>
                        <p>We use Google Analytics to collect anonymous information about how visitors use our site:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><code>_ga</code>: Distinguishes unique users</li>
                            <li><code>_ga_*</code>: Maintains session state</li>
                            <li><code>_gid</code>: Distinguishes users</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4 text-primary" >Your Cookie Choices</h2>
                        <p>You have several options for managing cookies:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Browser Settings:</strong> Most browsers allow you to block or delete cookies through their settings menu.</li>
                            <li><strong>Theme Preference:</strong> You can change your theme preference at any time using the toggle in the navigation bar.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4 text-primary" >Important Notes</h2>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>We do not use cookies to collect personal information</li>
                            <li>All text processing happens locally in your browser - we never store or transmit your text data</li>
                            <li>Disabling cookies may affect the functionality of some features on our website</li>
                            <li>We do not sell or share cookie data with third parties</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4 text-primary" >Updates to This Policy</h2>
                        <p>We may update this Cookie Policy from time to time to reflect changes in our practices or for legal reasons. We will notify you of any significant changes by posting a notice on our website.</p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4 text-primary" >Contact Us</h2>
                        <p>If you have any questions about our use of cookies, please contact us at:</p>
                        <p>Email: privacy@casechangerpro.com</p>
                    </section>

                    <section>
                        <p class="text-sm mt-8 text-tertiary" >
                        Last updated: {{ date('F j, Y') }}
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
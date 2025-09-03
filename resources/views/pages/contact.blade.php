<x-layouts.app title="Contact - Case Changer Pro">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-24">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 rounded-3xl p-12 shadow-2xl border border-white/50 dark:border-gray-700/50">
                <h1 class="text-5xl font-bold text-center mb-6 text-gray-900 dark:text-white">
                    Get in Touch
                </h1>
                <p class="text-xl text-center text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
                    Have questions, suggestions, or feedback? We'd love to hear from you.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="backdrop-blur-lg bg-gray-50/50 dark:bg-gray-900/50 rounded-2xl p-8 shadow-xl border border-gray-200/30 dark:border-gray-700/30">
                    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Send us a Message</h2>
                    
                    <form x-data="contactForm" @submit.prevent="submitForm" class="space-y-6">
                        @csrf
                        
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Your Name
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                x-model="formData.name"
                                @blur="validateField('name')"
                                class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                :class="{'border-red-500': errors.name, 'border-gray-300 dark:border-gray-600': !errors.name}"
                                required>
                            <p x-show="errors.name" x-text="errors.name" class="mt-1 text-sm text-red-600" x-cloak></p>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email Address
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                x-model="formData.email"
                                @blur="validateField('email')"
                                class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                :class="{'border-red-500': errors.email, 'border-gray-300 dark:border-gray-600': !errors.email}"
                                required>
                            <p x-show="errors.email" x-text="errors.email" class="mt-1 text-sm text-red-600" x-cloak></p>
                        </div>

                        <!-- Subject Field -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Subject
                            </label>
                            <select
                                id="subject"
                                name="subject"
                                x-model="formData.subject"
                                @blur="validateField('subject')"
                                class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                :class="{'border-red-500': errors.subject, 'border-gray-300 dark:border-gray-600': !errors.subject}"
                                required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="feature">Feature Request</option>
                                <option value="bug">Bug Report</option>
                                <option value="feedback">Feedback</option>
                                <option value="partnership">Partnership</option>
                            </select>
                            <p x-show="errors.subject" x-text="errors.subject" class="mt-1 text-sm text-red-600" x-cloak></p>
                        </div>

                        <!-- Message Field -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Message
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                x-model="formData.message"
                                @blur="validateField('message')"
                                rows="6"
                                class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                :class="{'border-red-500': errors.message, 'border-gray-300 dark:border-gray-600': !errors.message}"
                                required></textarea>
                            <p x-show="errors.message" x-text="errors.message" class="mt-1 text-sm text-red-600" x-cloak></p>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="w-full px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                <span x-show="!isSubmitting">Send Message</span>
                                <span x-show="isSubmitting" x-cloak>Sending...</span>
                            </button>
                        </div>

                        <!-- Success Message -->
                        <div x-show="showSuccess" x-cloak class="p-4 bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200 rounded-lg">
                            Thank you for your message! We'll get back to you soon.
                        </div>

                        <!-- Error Message -->
                        <div x-show="showError" x-cloak class="p-4 bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-200 rounded-lg">
                            There was an error sending your message. Please try again.
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Quick Contact -->
                    <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 rounded-2xl p-8 shadow-xl border border-gray-200/50 dark:border-gray-700/50">
                        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Quick Contact</h2>
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <span class="text-2xl">📧</span>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Email</h3>
                                    <p class="text-gray-600 dark:text-gray-400">support@casechangerpro.com</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <span class="text-2xl">💬</span>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Response Time</h3>
                                    <p class="text-gray-600 dark:text-gray-400">We typically respond within 24 hours</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <span class="text-2xl">🌍</span>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Available</h3>
                                    <p class="text-gray-600 dark:text-gray-400">Monday - Friday, 9 AM - 5 PM EST</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQs Link -->
                    <div class="backdrop-blur-lg bg-gradient-to-br from-blue-100/50 to-purple-100/50 dark:from-gray-700/50 dark:to-gray-800/50 rounded-2xl p-8 shadow-xl border border-gray-200/30 dark:border-gray-700/30">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Need Quick Answers?</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Check out our frequently asked questions for instant answers to common queries.
                        </p>
                        <a href="/pages/faq" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            View FAQs →
                        </a>
                    </div>

                    <!-- Social Links -->
                    <div class="backdrop-blur-lg bg-white/70 dark:bg-gray-800/70 rounded-2xl p-8 shadow-xl border border-gray-200/50 dark:border-gray-700/50">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Follow Us</h3>
                        <div class="flex gap-4">
                            <a href="#" class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-colors">
                                <span class="text-xl">𝕏</span>
                            </a>
                            <a href="#" class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-colors">
                                <span class="text-xl">📘</span>
                            </a>
                            <a href="#" class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-colors">
                                <span class="text-xl">💼</span>
                            </a>
                            <a href="#" class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-colors">
                                <span class="text-xl">🐙</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
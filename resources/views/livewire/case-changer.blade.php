<div class="min-h-screen smooth-rendering" style="background: linear-gradient(135deg, var(--neutral-50) 0%, var(--neutral-100) 100%);">
    {{-- Revolutionary Header --}}
    <header class="text-center py-12 animate-slide-up">
        <h1 class="text-gradient" style="font-size: var(--type-scale-4xl); font-weight: 800; margin-bottom: var(--space-md); line-height: 1.1;">
            Case Changer Pro
        </h1>
        <p style="font-size: var(--type-scale-lg); color: var(--neutral-600); font-weight: 400; letter-spacing: 0.02em;">
            Transform text with revolutionary magnetic interface design
        </p>
    </header>

    {{-- Revolutionary Transformation Grid --}}
    <div class="transformation-grid">


        {{-- Revolutionary Input/Output Interface --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-12 animate-slide-up">
            {{-- Input Section with Revolutionary Design --}}
            <div class="io-container animate-scale-in">
                <div class="flex items-center justify-between mb-6">
                    <h2 style="font-size: var(--type-scale-xl); font-weight: 600; color: var(--neutral-900);">Input Text</h2>
                    <div class="flex gap-2">
                        <button
                            wire:click="$set('text', '')"
                            class="btn-copy"
                            title="Clear input text"
                        >
                            Clear
                        </button>
                    </div>
                </div>
                
                <div class="relative">
                    <textarea
                        wire:model.live="inputText"
                        id="inputText"
                        class="text-input smooth-rendering"
                        placeholder="Enter or paste your text here..."
                        aria-label="Input text to transform"
                        aria-describedby="text-stats"
                        style="font-family: 'Inter', system-ui, sans-serif;"
                    ></textarea>
                </div>
                
                {{-- Error Display with Revolutionary Styling --}}
                @if($errorMessage)
                    <div class="mt-4 p-4 border border-red-200 rounded-lg" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(239, 68, 68, 0.02) 100%);">
                        <p style="color: #dc2626; font-size: var(--type-scale-sm);">{{ $errorMessage }}</p>
                    </div>
                @endif

                {{-- Revolutionary Statistics --}}
                <div id="text-stats" class="grid grid-cols-3 gap-4 mt-6" role="region" aria-label="Text statistics">
                    <div class="stat-card">
                        <div class="stat-label">Characters</div>
                        <div class="stat-number" aria-live="polite">{{ $stats['characters'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Words</div>
                        <div class="stat-number" aria-live="polite">{{ $stats['words'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Sentences</div>
                        <div class="stat-number" aria-live="polite">{{ $stats['sentences'] }}</div>
                    </div>
                </div>
            </div>

            {{-- Output Section with Revolutionary Design --}}
            <div class="io-container animate-scale-in" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between mb-6">
                    <h2 style="font-size: var(--type-scale-xl); font-weight: 600; color: var(--neutral-900);">Transformed Text</h2>
                    <div class="flex gap-2">
                        <button
                            wire:click="copyToClipboard"
                            class="btn-copy {{ $copied ? 'copied' : '' }}"
                            title="Copy to clipboard"
                        >
                            @if($copied)
                                <svg style="width: 16px; height: 16px; margin-right: var(--space-xs);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Copied!
                            @else
                                <svg style="width: 16px; height: 16px; margin-right: var(--space-xs);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Copy
                            @endif
                        </button>
                        <button
                            wire:click="$set('transformedText', '')"
                            class="btn-copy"
                            title="Clear output text"
                        >
                            Clear
                        </button>
                    </div>
                </div>
                
                <div class="relative">
                    <textarea
                        id="outputText"
                        wire:model="outputText"
                        readonly
                        class="text-input smooth-rendering"
                        placeholder="Transformed text will appear here..."
                        aria-label="Transformed output text"
                        aria-live="polite"
                        style="font-family: 'Inter', system-ui, sans-serif; background: var(--neutral-50);"
                    ></textarea>
                </div>
            </div>
        </div>

        {{-- PRIMARY MAGNETIC ZONE (40% Visual Weight) --}}
        <section class="animate-slide-up" style="animation-delay: 0.2s;">
            <div class="text-center mb-8">
                <h2 style="font-size: var(--type-scale-2xl); font-weight: 700; color: var(--neutral-900); margin-bottom: var(--space-sm);">Core Transformations</h2>
                <p style="font-size: var(--type-scale-base); color: var(--neutral-600);">Essential text case transformations with magnetic attraction</p>
            </div>
            
            <div class="primary-zone">
                <button wire:click="transformToUpperCase" class="btn-transform primary demo-uppercase gpu-accelerated animate-magnetic-float">
                    UPPERCASE
                </button>
                <button wire:click="transformToLowerCase" class="btn-transform primary demo-lowercase gpu-accelerated animate-magnetic-float" style="animation-delay: 0.5s;">
                    lowercase
                </button>
                <button wire:click="transformToTitleCase" class="btn-transform primary demo-title gpu-accelerated animate-magnetic-float" style="animation-delay: 1s;">
                    Title Case
                </button>
            </div>
        </section>

        {{-- SECONDARY RING (35% Visual Weight) --}}
        <section class="animate-slide-up" style="animation-delay: 0.4s;">
            <div class="text-center mb-8">
                <h3 style="font-size: var(--type-scale-xl); font-weight: 600; color: var(--neutral-800); margin-bottom: var(--space-sm);">Professional & Developer Tools</h3>
                <p style="font-size: var(--type-scale-sm); color: var(--neutral-600);">Code transformations and style guides for professional use</p>
            </div>
            
            {{-- Code Transformations --}}
            <div class="mb-8">
                <h4 style="font-size: var(--type-scale-lg); font-weight: 600; color: var(--neutral-700); margin-bottom: var(--space-md);">Code Formats</h4>
                <div class="secondary-ring">
                    <button wire:click="transformToCamelCase" class="btn-transform gpu-accelerated" style="font-family: 'JetBrains Mono', monospace;">
                        camelCase
                    </button>
                    <button wire:click="transformToSnakeCase" class="btn-transform gpu-accelerated" style="font-family: 'JetBrains Mono', monospace;">
                        snake_case
                    </button>
                    <button wire:click="transformToKebabCase" class="btn-transform gpu-accelerated" style="font-family: 'JetBrains Mono', monospace;">
                        kebab-case
                    </button>
                    <button wire:click="transformToPascalCase" class="btn-transform gpu-accelerated" style="font-family: 'JetBrains Mono', monospace;">
                        PascalCase
                    </button>
                    <button wire:click="transformToConstantCase" class="btn-transform gpu-accelerated" style="font-family: 'JetBrains Mono', monospace;">
                        CONSTANT_CASE
                    </button>
                    <button wire:click="transformToDotCase" class="btn-transform gpu-accelerated" style="font-family: 'JetBrains Mono', monospace;">
                        dot.case
                    </button>
                    <button wire:click="transformToPathCase" class="btn-transform gpu-accelerated" style="font-family: 'JetBrains Mono', monospace;">
                        path/case
                    </button>
                    <button wire:click="transformToHeaderCase" class="btn-transform gpu-accelerated" style="font-family: 'JetBrains Mono', monospace;">
                        Header-Case
                    </button>
                </div>
            </div>

            {{-- Style Guides --}}
            <div class="mb-8">
                <h4 style="font-size: var(--type-scale-lg); font-weight: 600; color: var(--neutral-700); margin-bottom: var(--space-md);">Academic & Professional Style Guides</h4>
                <div class="secondary-ring">
                    <button wire:click="applyApaStyle" class="btn-transform btn-style-guide gpu-accelerated">
                        APA Style
                        <div style="font-size: var(--type-scale-sm); color: var(--neutral-500); margin-top: 2px;">Academic</div>
                    </button>
                    <button wire:click="applyMlaStyle" class="btn-transform btn-style-guide gpu-accelerated">
                        MLA Style
                        <div style="font-size: var(--type-scale-sm); color: var(--neutral-500); margin-top: 2px;">Literature</div>
                    </button>
                    <button wire:click="applyChicagoStyle" class="btn-transform btn-style-guide gpu-accelerated">
                        Chicago
                        <div style="font-size: var(--type-scale-sm); color: var(--neutral-500); margin-top: 2px;">History</div>
                    </button>
                    <button wire:click="applyApStyle" class="btn-transform btn-style-guide gpu-accelerated">
                        AP Style
                        <div style="font-size: var(--type-scale-sm); color: var(--neutral-500); margin-top: 2px;">Journalism</div>
                    </button>
                    <button wire:click="applyBluebookStyle" class="btn-transform btn-style-guide gpu-accelerated">
                        Bluebook
                        <div style="font-size: var(--type-scale-sm); color: var(--neutral-500); margin-top: 2px;">Legal</div>
                    </button>
                    <button wire:click="applyIeeeStyle" class="btn-transform btn-style-guide gpu-accelerated">
                        IEEE
                        <div style="font-size: var(--type-scale-sm); color: var(--neutral-500); margin-top: 2px;">Engineering</div>
                    </button>
                    <button wire:click="applyAmaStyle" class="btn-transform btn-style-guide gpu-accelerated">
                        AMA Style
                        <div style="font-size: var(--type-scale-sm); color: var(--neutral-500); margin-top: 2px;">Medical</div>
                    </button>
                    <button wire:click="applyHarvardStyle" class="btn-transform btn-style-guide gpu-accelerated">
                        Harvard
                        <div style="font-size: var(--type-scale-sm); color: var(--neutral-500); margin-top: 2px;">Business</div>
                    </button>
                </div>
            </div>
        </section>

        {{-- TERTIARY LAYER (25% Visual Weight) --}}
        <section class="animate-slide-up" style="animation-delay: 0.6s;">
            <div class="text-center mb-8">
                <h3 style="font-size: var(--type-scale-xl); font-weight: 600; color: var(--neutral-700); margin-bottom: var(--space-sm); opacity: 0.8;">Creative & Utility Transformations</h3>
                <p style="font-size: var(--type-scale-sm); color: var(--neutral-500);">Fun and utility transformations for special use cases</p>
            </div>
            
            <div class="tertiary-layer" style="opacity: 0.75;">
                <button wire:click="transformToSentenceCase" class="btn-transform gpu-accelerated">
                    Sentence case
                </button>
                <button wire:click="transformToFirstLetter" class="btn-transform gpu-accelerated">
                    First Letter
                </button>
                <button wire:click="transformToTrainCase" class="btn-transform gpu-accelerated">
                    Train-Case
                </button>
                <button wire:click="transformToAlternatingCase" class="btn-transform gpu-accelerated">
                    aLtErNaTiNg
                </button>
                <button wire:click="transformToSpongebobCase" class="btn-transform gpu-accelerated">
                    sPoNgEbOb
                </button>
                <button wire:click="transformToInverseCase" class="btn-transform gpu-accelerated">
                    InVeRsE
                </button>
                <button wire:click="transformToRandomCase" class="btn-transform gpu-accelerated">
                    RaNDoM
                </button>
                <button wire:click="transformToReversedText" class="btn-transform gpu-accelerated">
                    txeT esreveR
                </button>
                <button wire:click="transformToWideText" class="btn-transform gpu-accelerated">
                    Ｗｉｄｅ Ｔｅｘｔ
                </button>
                <button wire:click="transformToSmallCaps" class="btn-transform gpu-accelerated">
                    SMALL CAPS
                </button>
                <button wire:click="transformToStrikethrough" class="btn-transform gpu-accelerated">
                    S̶t̶r̶i̶k̶e̶
                </button>
                <button wire:click="transformToZalgoText" class="btn-transform gpu-accelerated">
                    Z̷a̸l̷g̸o̷
                </button>
                <button wire:click="transformToUpsideDown" class="btn-transform gpu-accelerated">
                    ɟlᴉԀ
                </button>
                <button wire:click="transformToBinary" class="btn-transform gpu-accelerated">
                    01000010
                </button>
                <button wire:click="transformToNoWhitespace" class="btn-transform gpu-accelerated">
                    RemoveSpaces
                </button>
            </div>
        </section>

        {{-- ADVANCED UTILITIES SECTION --}}
        <section class="animate-slide-up" style="animation-delay: 0.8s;">
            <div class="io-container" style="margin-top: var(--space-3xl);">
                <button
                    wire:click="toggleAdvancedOptions"
                    class="flex items-center justify-between w-full text-left mb-6 p-0 bg-transparent border-none cursor-pointer"
                >
                    <h3 style="font-size: var(--type-scale-xl); font-weight: 600; color: var(--neutral-800);">Advanced Text Utilities</h3>
                    <svg
                        style="width: 20px; height: 20px; color: var(--neutral-500); transform: {{ $showAdvancedOptions ? 'rotate(180deg)' : 'rotate(0deg)' }}; transition: transform 300ms var(--spring-smooth);"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                @if($showAdvancedOptions)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-slide-up">
                        {{-- Preposition Fixer --}}
                        <div class="io-container" style="padding: var(--space-lg);">
                            <div class="flex items-center justify-between mb-4">
                                <h4 style="font-size: var(--type-scale-base); font-weight: 600; color: var(--neutral-700);">Fix Prepositions</h4>
                                <button
                                    wire:click="fixPrepositions"
                                    class="btn-copy"
                                >
                                    Apply
                                </button>
                            </div>
                            <p style="font-size: var(--type-scale-sm); color: var(--neutral-500); margin-bottom: var(--space-md);">Lowercase prepositions under {{ $prepositionMaxLength }} letters</p>
                            <div class="flex items-center gap-2">
                                <label style="font-size: var(--type-scale-sm); color: var(--neutral-600);">Max Length:</label>
                                <input
                                    type="number"
                                    wire:model="prepositionMaxLength"
                                    min="2"
                                    max="10"
                                    style="width: 60px; padding: var(--space-xs) var(--space-sm); border: 1px solid var(--neutral-300); border-radius: 6px; font-size: var(--type-scale-sm);"
                                >
                            </div>
                        </div>

                        {{-- Smart Quotes --}}
                        <div class="io-container" style="padding: var(--space-lg);">
                            <div class="flex items-center justify-between mb-4">
                                <h4 style="font-size: var(--type-scale-base); font-weight: 600; color: var(--neutral-700);">Smart Quotes</h4>
                                <button
                                    wire:click="convertToSmartQuotes"
                                    class="btn-copy"
                                >
                                    Convert
                                </button>
                            </div>
                            <p style="font-size: var(--type-scale-sm); color: var(--neutral-500);">Convert straight quotes to curly quotes</p>
                        </div>

                        {{-- Space Management --}}
                        <div class="io-container" style="padding: var(--space-lg);">
                            <h4 style="font-size: var(--type-scale-base); font-weight: 600; color: var(--neutral-700); margin-bottom: var(--space-md);">Space Management</h4>
                            <div class="flex gap-2">
                                <button
                                    wire:click="removeExtraSpaces"
                                    class="btn-copy" style="flex: 1;"
                                >
                                    Remove Extra
                                </button>
                                <button
                                    wire:click="addSpaces"
                                    class="btn-copy" style="flex: 1;"
                                >
                                    Add Spaces
                                </button>
                            </div>
                        </div>

                        {{-- Underscore Conversion --}}
                        <div class="io-container" style="padding: var(--space-lg);">
                            <h4 style="font-size: var(--type-scale-base); font-weight: 600; color: var(--neutral-700); margin-bottom: var(--space-md);">Underscore Conversion</h4>
                            <div class="flex gap-2">
                                <button
                                    wire:click="spacesToUnderscores"
                                    class="btn-copy" style="flex: 1; font-family: 'JetBrains Mono', monospace;"
                                >
                                    Spaces → _
                                </button>
                                <button
                                    wire:click="underscoresToSpaces"
                                    class="btn-copy" style="flex: 1; font-family: 'JetBrains Mono', monospace;"
                                >
                                    _ → Spaces
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

    </div>

    {{-- Revolutionary Toast Notification --}}
    @if($copied)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            x-transition:enter="transition ease-out duration-400"
            x-transition:enter-start="opacity-0 transform translate-y-8 scale-0.95"
            x-transition:enter-end="opacity-100 transform translate-y-0 scale-1"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0 scale-1"
            x-transition:leave-end="opacity-0 transform translate-y-8 scale-0.95"
            class="fixed bottom-6 right-6 blur-glass animate-glow-pulse"
            style="background: var(--accent-primary); color: var(--neutral-0); padding: var(--space-md) var(--space-lg); border-radius: 12px; box-shadow: var(--shadow-high), var(--shadow-primary); font-weight: 500; z-index: 1000;"
        >
            <div class="flex items-center gap-2">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Text copied to clipboard!
            </div>
        </div>
    @endif

    {{-- Revolutionary Interaction System --}}
    @push('scripts')
        <script>
            // Revolutionary Magnetic Interface System
            document.addEventListener('DOMContentLoaded', function() {
                // Check for reduced motion preference
                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (prefersReducedMotion) return;
                
                // Enhanced button interactions
                const buttons = document.querySelectorAll('.btn-transform');
                
                buttons.forEach((button, index) => {
                    // Stagger animation
                    button.style.animationDelay = `${index * 50}ms`;
                    button.classList.add('animate-slide-up');
                    
                    // Magnetic hover effects
                    button.addEventListener('mouseenter', function() {
                        this.style.transition = 'transform 400ms cubic-bezier(0.25, 1, 0.5, 1)';
                        this.style.transform = 'translateY(-2px) scale(1.02)';
                    });
                    
                    button.addEventListener('mouseleave', function() {
                        this.style.transform = '';
                    });
                    
                    // Click animation
                    button.addEventListener('click', function() {
                        this.style.animation = 'textTransform 0.6s cubic-bezier(0.25, 1, 0.5, 1)';
                        setTimeout(() => {
                            this.style.animation = '';
                        }, 600);
                    });
                });
                
                // Enhanced text area interactions
                const textAreas = document.querySelectorAll('.text-input');
                textAreas.forEach(textarea => {
                    textarea.addEventListener('focus', function() {
                        const container = this.closest('.io-container');
                        container.style.transform = 'translateY(-2px)';
                        container.style.boxShadow = 'var(--shadow-high), var(--shadow-primary)';
                    });
                    
                    textarea.addEventListener('blur', function() {
                        const container = this.closest('.io-container');
                        container.style.transform = '';
                        container.style.boxShadow = '';
                    });
                });
                
                // Copy button enhancements
                const copyButtons = document.querySelectorAll('.btn-copy');
                copyButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Create particle effect
                        for (let i = 0; i < 6; i++) {
                            const particle = document.createElement('div');
                            const angle = (i / 6) * Math.PI * 2;
                            const distance = 30;
                            const x = Math.cos(angle) * distance;
                            const y = Math.sin(angle) * distance;
                            
                            particle.style.cssText = `
                                position: absolute;
                                width: 4px;
                                height: 4px;
                                background: var(--accent-primary);
                                border-radius: 50%;
                                pointer-events: none;
                                left: 50%;
                                top: 50%;
                                z-index: 10;
                            `;
                            
                            this.style.position = 'relative';
                            this.appendChild(particle);
                            
                            // Animate particle
                            particle.animate([
                                { transform: 'translate(-50%, -50%) scale(1)', opacity: 1 },
                                { transform: `translate(calc(-50% + ${x}px), calc(-50% + ${y}px)) scale(0)`, opacity: 0 }
                            ], {
                                duration: 800,
                                easing: 'cubic-bezier(0.25, 1, 0.5, 1)'
                            }).onfinish = () => particle.remove();
                        }
                    });
                });
            });
        </script>
    @endpush
</div>

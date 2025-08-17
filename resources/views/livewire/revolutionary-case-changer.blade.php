{{-- Revolutionary UI for Case Changer Pro --}}
{{-- Magnetic Hierarchy & 2.5D Spatial Computing Interface --}}

<div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-neutral-50 to-neutral-100" 
     x-data="{ 
        isTransforming: false,
        hoveredButton: null,
        previewText: @entangle('inputText').defer
     }">
    
    {{-- Revolutionary Header with Kinetic Typography --}}
    <header class="relative z-10 text-center py-16 px-6">
        <h1 class="text-6xl font-bold text-gradient mb-4 animate-slide-up whimsy-title"
            style="animation-delay: 0.1s;"
            x-data="{ clickCount: 0 }"
            x-on:click="
                clickCount++;
                if (clickCount >= 3) {
                    $dispatch('party-mode');
                    clickCount = 0;
                }
            "
            title="Click me 3 times for a surprise!">
            Case Changer Pro
        </h1>
        <p class="text-xl text-neutral-600 mb-8 animate-slide-up whimsy-subtitle"
           style="animation-delay: 0.2s;"
           x-data="{ 
               phrases: [
                   'Transform text into performance art',
                   'Where words become magic',
                   'Text transformation made delightful',
                   'Your personal typography wizard',
                   'Making boring text absolutely brilliant'
               ],
               currentPhrase: 0
           }"
           x-text="phrases[currentPhrase]"
           x-init="
               setInterval(() => {
                   currentPhrase = (currentPhrase + 1) % phrases.length;
               }, 4000)
           ">
        </p>
        
        {{-- Live Statistics with Magnetic Float --}}
        <div class="flex justify-center gap-8 animate-slide-up"
             style="animation-delay: 0.3s;">
            <div class="stat-card animate-magnetic-float gpu-accelerated">
                <div class="stat-number">{{ number_format($stats['characters']) }}</div>
                <div class="stat-label">Characters</div>
            </div>
            <div class="stat-card animate-magnetic-float gpu-accelerated" 
                 style="animation-delay: 1s;">
                <div class="stat-number">{{ number_format($stats['words']) }}</div>
                <div class="stat-label">Words</div>
            </div>
            <div class="stat-card animate-magnetic-float gpu-accelerated"
                 style="animation-delay: 2s;">
                <div class="stat-number">{{ number_format($stats['sentences']) }}</div>
                <div class="stat-label">Sentences</div>
            </div>
        </div>
    </header>

    {{-- Main Interface Grid --}}
    <main class="transformation-grid">
        
        {{-- Single-Field Interaction Model --}}
        <section class="io-container mb-12 animate-scale-in" style="animation-delay: 0.4s;">
            <div class="mb-6">
                <label for="inputText" class="block text-lg font-semibold text-neutral-700 mb-4">
                    Enter Your Text
                </label>
                <div class="relative">
                    <textarea
                        wire:model.live="inputText"
                        id="inputText"
                        class="text-input smooth-rendering whimsy-input"
                        placeholder="Type or paste your text here and watch it transform..."
                        rows="8"
                        aria-label="Input text for transformation"
                        x-on:input="previewText = $event.target.value"
                        x-data="{ 
                            placeholders: [
                                'Type something magical here...',
                                'Your text transformation adventure begins...',
                                'What would you like to transform today?',
                                'Let your words take new forms...',
                                'Ready to make text dance?'
                            ],
                            currentPlaceholder: 0
                        }"
                        x-init="
                            setInterval(() => {
                                if (!$el.value) {
                                    currentPlaceholder = (currentPlaceholder + 1) % placeholders.length;
                                    $el.placeholder = placeholders[currentPlaceholder];
                                }
                            }, 3000)
                        "
                    ></textarea>
                    
                    {{-- Live Preview Overlay --}}
                    <div class="preview-overlay" 
                         x-show="hoveredButton" 
                         x-text="previewText"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                    </div>
                </div>
            </div>
            
            {{-- Error Display with Kinetic Feedback --}}
            @if($errorMessage)
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl animate-slide-up">
                    <p class="text-red-700">{{ $errorMessage }}</p>
                </div>
            @endif
            
            {{-- Output Section --}}
            @if($outputText)
                <div class="mt-8 animate-slide-up">
                    <div class="flex justify-between items-center mb-4">
                        <label class="block text-lg font-semibold text-neutral-700">
                            Transformed Result
                        </label>
                        <button
                            wire:click="copyToClipboard"
                            class="btn-copy {{ $copied ? 'copied' : '' }}"
                            x-on:click="
                                setTimeout(() => $wire.set('copied', false), 2000);
                                $dispatch('copy-success');
                            "
                        >
                            <span x-show="!{{ $copied ? 'true' : 'false' }}">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Copy
                            </span>
                            <span x-show="{{ $copied ? 'true' : 'false' }}" class="animate-scale-in">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Copied!
                            </span>
                        </button>
                    </div>
                    <div class="relative">
                        <textarea
                            readonly
                            class="text-input bg-neutral-100"
                            rows="6"
                            aria-label="Transformed output text"
                        >{{ $outputText }}</textarea>
                    </div>
                </div>
            @endif
        </section>

        {{-- Primary Magnetic Zone - Core Transformations --}}
        <section class="animate-slide-up" style="animation-delay: 0.5s;">
            <h2 class="text-2xl font-bold text-neutral-800 mb-6 text-center">
                Primary Transformations
            </h2>
            <div class="primary-zone">
                <button 
                    wire:click="transformToUpperCase"
                    class="btn-transform primary demo-uppercase magnetic-zone gpu-accelerated whimsy-uppercase"
                    x-on:mouseenter="hoveredButton = 'uppercase'"
                    x-on:mouseleave="hoveredButton = null"
                    x-on:click="isTransforming = true; setTimeout(() => isTransforming = false, 600)"
                    :class="{ 'animate-text-transform': isTransforming && hoveredButton === 'uppercase' }"
                    data-personality="shout"
                    title="Make your text SHOUT with confidence!"
                >
                    UPPERCASE
                </button>
                
                <button 
                    wire:click="transformToLowerCase"
                    class="btn-transform primary demo-lowercase magnetic-zone gpu-accelerated whimsy-lowercase"
                    x-on:mouseenter="hoveredButton = 'lowercase'"
                    x-on:mouseleave="hoveredButton = null"
                    x-on:click="isTransforming = true; setTimeout(() => isTransforming = false, 600)"
                    :class="{ 'animate-text-transform': isTransforming && hoveredButton === 'lowercase' }"
                    data-personality="whisper"
                    title="Gentle and understated, like a whisper"
                >
                    lowercase
                </button>
                
                <button 
                    wire:click="transformToTitleCase"
                    class="btn-transform primary demo-title magnetic-zone gpu-accelerated"
                    x-on:mouseenter="hoveredButton = 'title'"
                    x-on:mouseleave="hoveredButton = null"
                    x-on:click="isTransforming = true; setTimeout(() => isTransforming = false, 600)"
                    :class="{ 'animate-text-transform': isTransforming && hoveredButton === 'title' }"
                >
                    Title Case
                </button>
            </div>
        </section>

        {{-- Secondary Ring - Code & Writing --}}
        <section class="animate-slide-up" style="animation-delay: 0.6s;">
            <h3 class="text-xl font-semibold text-neutral-700 mb-4 text-center">
                Code & Development
            </h3>
            <div class="secondary-ring">
                <button 
                    wire:click="transformToCamelCase"
                    class="btn-transform magnetic-zone gpu-accelerated"
                    x-on:mouseenter="hoveredButton = 'camel'"
                    x-on:mouseleave="hoveredButton = null"
                >
                    camelCase
                </button>
                
                <button 
                    wire:click="transformToSnakeCase"
                    class="btn-transform magnetic-zone gpu-accelerated"
                    x-on:mouseenter="hoveredButton = 'snake'"
                    x-on:mouseleave="hoveredButton = null"
                >
                    snake_case
                </button>
                
                <button 
                    wire:click="transformToKebabCase"
                    class="btn-transform magnetic-zone gpu-accelerated"
                    x-on:mouseenter="hoveredButton = 'kebab'"
                    x-on:mouseleave="hoveredButton = null"
                >
                    kebab-case
                </button>
                
                <button 
                    wire:click="transformToPascalCase"
                    class="btn-transform magnetic-zone gpu-accelerated"
                    x-on:mouseenter="hoveredButton = 'pascal'"
                    x-on:mouseleave="hoveredButton = null"
                >
                    PascalCase
                </button>
                
                <button 
                    wire:click="transformToConstantCase"
                    class="btn-transform magnetic-zone gpu-accelerated"
                    x-on:mouseenter="hoveredButton = 'constant'"
                    x-on:mouseleave="hoveredButton = null"
                >
                    CONSTANT_CASE
                </button>
            </div>
        </section>

        {{-- Style Guide Ring --}}
        <section class="animate-slide-up" style="animation-delay: 0.7s;">
            <h3 class="text-xl font-semibold text-neutral-700 mb-4 text-center">
                Professional Style Guides
            </h3>
            <div class="secondary-ring">
                <button 
                    wire:click="applyApaStyle"
                    class="btn-transform btn-style-guide magnetic-zone gpu-accelerated"
                >
                    APA Style
                </button>
                
                <button 
                    wire:click="applyChicagoStyle"
                    class="btn-transform btn-style-guide magnetic-zone gpu-accelerated"
                >
                    Chicago
                </button>
                
                <button 
                    wire:click="applyApStyle"
                    class="btn-transform btn-style-guide magnetic-zone gpu-accelerated"
                >
                    AP Style
                </button>
                
                <button 
                    wire:click="applyMlaStyle"
                    class="btn-transform btn-style-guide magnetic-zone gpu-accelerated"
                >
                    MLA Style
                </button>
                
                <button 
                    wire:click="applyOxfordStyle"
                    class="btn-transform btn-style-guide magnetic-zone gpu-accelerated"
                >
                    Oxford
                </button>
            </div>
        </section>

        {{-- Tertiary Layer - Creative Transformations --}}
        <section class="animate-slide-up" style="animation-delay: 0.8s;">
            <h3 class="text-xl font-semibold text-neutral-700 mb-4 text-center">
                Creative & Special Effects
            </h3>
            <div class="tertiary-layer">
                <button 
                    wire:click="transformToSentenceCase"
                    class="btn-transform magnetic-zone gpu-accelerated"
                >
                    Sentence case
                </button>
                
                <button 
                    wire:click="transformToAlternatingCase"
                    class="btn-transform magnetic-zone gpu-accelerated"
                >
                    aLtErNaTiNg
                </button>
                
                <button 
                    wire:click="transformToRandomCase"
                    class="btn-transform magnetic-zone gpu-accelerated"
                >
                    RaNDoM
                </button>
                
                <button 
                    wire:click="transformToSpongebobCase"
                    class="btn-transform magnetic-zone gpu-accelerated whimsy-spongebob"
                    data-personality="mocking"
                    title="Perfect for that mocking tone... sUrE tHiNg!"
                >
                    sPoNgEbOb
                </button>
                
                <button 
                    wire:click="transformToInverseCase"
                    class="btn-transform magnetic-zone gpu-accelerated"
                >
                    InVeRsE
                </button>
                
                <button 
                    wire:click="transformToReversedText"
                    class="btn-transform magnetic-zone gpu-accelerated"
                >
                    txeT esreveR
                </button>
                
                <button 
                    wire:click="transformToUpsideDown"
                    class="btn-transform magnetic-zone gpu-accelerated"
                >
                    ɹǝpᴉsdn ᴜp
                </button>
                
                <button 
                    wire:click="transformToWideText"
                    class="btn-transform magnetic-zone gpu-accelerated"
                >
                    Ｗｉｄｅ
                </button>
                
                <button 
                    wire:click="transformToSmallCaps"
                    class="btn-transform magnetic-zone gpu-accelerated"
                >
                    ꜱᴍᴀʟʟ ᴄᴀᴘꜱ
                </button>
                
                <button 
                    wire:click="transformToStrikethrough"
                    class="btn-transform magnetic-zone gpu-accelerated"
                >
                    S̶t̶r̶i̶k̶e̶
                </button>
                
                <button 
                    wire:click="transformToZalgoText"
                    class="btn-transform magnetic-zone gpu-accelerated whimsy-zalgo"
                    data-personality="glitch"
                    title="H̷e̷ ̷c̷o̷m̷e̷s̷.̷.̷.̷ ̷Z̷a̷l̷g̷o̷ ̷a̷w̷a̷i̷t̷s̷"
                >
                    Z̴a̸l̷g̵o̶
                </button>
                
                <button 
                    wire:click="transformToBinary"
                    class="btn-transform magnetic-zone gpu-accelerated whimsy-binary"
                    data-personality="matrix"
                    title="Welcome to the Matrix... 010001110100111001000101"
                >
                    01000010
                </button>
            </div>
        </section>

        {{-- Advanced Options Panel (Collapsible) --}}
        <section class="animate-slide-up" style="animation-delay: 0.9s;">
            <div class="io-container">
                <button
                    wire:click="toggleAdvancedOptions"
                    class="flex items-center justify-between w-full text-left mb-4"
                >
                    <span class="text-xl font-semibold text-neutral-700">Advanced Features</span>
                    <svg
                        class="w-6 h-6 text-neutral-500 transform transition-transform duration-300 {{ $showAdvancedOptions ? 'rotate-180' : '' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                @if($showAdvancedOptions)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-slide-up">
                        {{-- Space Management --}}
                        <div class="space-y-3">
                            <h4 class="font-semibold text-neutral-700">Space Management</h4>
                            <div class="space-y-2">
                                <button wire:click="removeExtraSpaces" class="btn-transform w-full">
                                    Remove Extra Spaces
                                </button>
                                <button wire:click="addSpaces" class="btn-transform w-full">
                                    Add Missing Spaces
                                </button>
                                <button wire:click="spacesToUnderscores" class="btn-transform w-full">
                                    Spaces → Underscores
                                </button>
                                <button wire:click="underscoresToSpaces" class="btn-transform w-full">
                                    Underscores → Spaces
                                </button>
                            </div>
                        </div>

                        {{-- Typography Enhancement --}}
                        <div class="space-y-3">
                            <h4 class="font-semibold text-neutral-700">Typography</h4>
                            <div class="space-y-2">
                                <button wire:click="convertToSmartQuotes" class="btn-transform w-full">
                                    Smart Quotes
                                </button>
                                <button wire:click="fixPrepositions" class="btn-transform w-full">
                                    Fix Prepositions
                                </button>
                                <button wire:click="transformToNoWhitespace" class="btn-transform w-full">
                                    Remove All Spaces
                                </button>
                            </div>
                        </div>

                        {{-- Special Cases --}}
                        <div class="space-y-3">
                            <h4 class="font-semibold text-neutral-700">Special Cases</h4>
                            <div class="space-y-2">
                                <button wire:click="transformToDotCase" class="btn-transform w-full">
                                    dot.case
                                </button>
                                <button wire:click="transformToPathCase" class="btn-transform w-full">
                                    path/case
                                </button>
                                <button wire:click="transformToHeaderCase" class="btn-transform w-full">
                                    Header-Case
                                </button>
                                <button wire:click="transformToTrainCase" class="btn-transform w-full">
                                    Train-Case
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    {{-- Toast Notifications with Physics --}}
    @if($copied)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 transform translate-y-2 scale-95"
            class="fixed bottom-8 right-8 bg-neutral-900 text-neutral-0 px-6 py-4 rounded-xl shadow-high z-50"
        >
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">Text copied to clipboard!</span>
            </div>
        </div>
    @endif

    {{-- Background Ambient Animation with Whimsy --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden opacity-30">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-accent-primary rounded-full mix-blend-multiply filter blur-xl animate-magnetic-float whimsy-orb-1"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-magnetic-float whimsy-orb-2" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl animate-magnetic-float whimsy-orb-3" style="animation-delay: 4s;"></div>
        
        {{-- Magical Sparkles --}}
        <div class="sparkle-container" x-data="{ sparkles: [] }" x-init="
            setInterval(() => {
                if (Math.random() < 0.1) {
                    const sparkle = {
                        id: Date.now(),
                        x: Math.random() * 100,
                        y: Math.random() * 100,
                        size: Math.random() * 3 + 2
                    };
                    sparkles.push(sparkle);
                    setTimeout(() => {
                        sparkles = sparkles.filter(s => s.id !== sparkle.id);
                    }, 2000);
                }
            }, 500)
        ">
            <template x-for="sparkle in sparkles" :key="sparkle.id">
                <div class="absolute pointer-events-none animate-ping"
                     :style="`left: ${sparkle.x}%; top: ${sparkle.y}%; width: ${sparkle.size}px; height: ${sparkle.size}px;`"
                     style="background: radial-gradient(circle, #ffd700, transparent); border-radius: 50%;"></div>
            </template>
        </div>
    </div>
    
    {{-- Floating Magic Wand --}}
    <div class="fixed bottom-8 left-8 pointer-events-none z-20 opacity-60"
         x-data="{ isActive: false }"
         x-on:transformation-start.window="isActive = true; setTimeout(() => isActive = false, 1000)"
         :class="{ 'animate-bounce': isActive }">
        <div class="text-2xl transform rotate-45">✨</div>
    </div>
</div>

{{-- Enhanced Alpine.js Effects with Whimsy --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('magneticCursor', () => ({
        init() {
            this.setupMagneticEffect();
            this.setupHapticFeedback();
        },
        
        setupMagneticEffect() {
            const magneticElements = document.querySelectorAll('.magnetic-zone');
            
            magneticElements.forEach(element => {
                element.addEventListener('mousemove', (e) => {
                    const rect = element.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;
                    
                    const strength = 0.1;
                    const translateX = x * strength;
                    const translateY = y * strength;
                    
                    element.style.transform = `translate(${translateX}px, ${translateY}px) scale(1.02)`;
                });
                
                element.addEventListener('mouseleave', () => {
                    element.style.transform = 'translate(0px, 0px) scale(1)';
                });
                
                // Add click feedback
                element.addEventListener('click', () => {
                    window.dispatchEvent(new CustomEvent('transformation-start'));
                });
            });
        },
        
        setupHapticFeedback() {
            // Add haptic feedback for mobile devices
            const buttons = document.querySelectorAll('.btn-transform');
            buttons.forEach(button => {
                button.addEventListener('touchstart', () => {
                    if (navigator.vibrate) {
                        navigator.vibrate(10); // Light haptic feedback
                    }
                });
                
                button.addEventListener('click', () => {
                    if (navigator.vibrate) {
                        navigator.vibrate([25, 10, 25]); // Success pattern
                    }
                });
            });
        }
    }));
});
</script>

<style>
/* Additional component-specific styles */
.animate-slide-up {
    animation-fill-mode: both;
}

/* Magnetic attraction zones */
.magnetic-zone {
    will-change: transform;
}

/* Enhanced focus states for accessibility */
.btn-transform:focus-visible {
    outline: 2px solid var(--accent-primary);
    outline-offset: 2px;
    box-shadow: 0 0 0 4px var(--accent-glow);
}

/* Performance optimizations */
.gpu-accelerated {
    transform: translateZ(0);
    backface-visibility: hidden;
    perspective: 1000px;
}
</style>
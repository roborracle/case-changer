/**
 * Whimsical Delights Enhancement System
 * Transform functional interactions into magical moments that users want to share
 * Adds personality, celebration, and joy to the Case Changer Pro interface
 */

class WhimsicalDelights {
    constructor() {
        this.isReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        this.konamiCode = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; // ↑↑↓↓←→←→BA
        this.konamiIndex = 0;
        this.sounds = {};
        this.particleSettings = {
            confetti: { count: 30, spread: 60, colors: ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7'] },
            sparkles: { count: 8, spread: 30, colors: ['#ffd700', '#ffff00', '#fffacd'] },
            matrix: { count: 20, chars: ['0', '1'] }
        };
        
        this.init();
    }

    init() {
        if (this.isReduced) return;
        
        this.setupSoundEffects();
        this.setupTransformationMagic();
        this.setupCursorPersonality();
        this.setupSuccessCelebrations();
        this.setupContextualResponses();
        this.setupPlayfulPhysics();
        this.setupEmotionalFeedback();
        this.setupEasterEggs();
        this.setupShareableElements();
    }

    // Sound Effects System
    setupSoundEffects() {
        this.sounds = {
            click: this.createTone(800, 'sine', 0.1, 0.1),
            success: this.createTone(523.25, 'sine', 0.2, 0.3), // C5
            uppercase: this.createTone(659.25, 'square', 0.15, 0.2), // E5 - assertive
            lowercase: this.createTone(392, 'sine', 0.1, 0.2), // G4 - gentle
            sparkle: this.createTone(1046.5, 'triangle', 0.05, 0.1), // C6 - delicate
            whoosh: this.createTone(220, 'sawtooth', 0.1, 0.3) // A3 - transformation
        };
    }

    createTone(frequency, wave, volume, duration) {
        return () => {
            if (!window.AudioContext && !window.webkitAudioContext) return;
            
            const context = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = context.createOscillator();
            const gainNode = context.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(context.destination);
            
            oscillator.frequency.value = frequency;
            oscillator.type = wave;
            gainNode.gain.setValueAtTime(0, context.currentTime);
            gainNode.gain.linearRampToValueAtTime(volume, context.currentTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.001, context.currentTime + duration);
            
            oscillator.start(context.currentTime);
            oscillator.stop(context.currentTime + duration);
        };
    }

    // Transformation Magic Moments
    setupTransformationMagic() {
        // UPPERCASE "SHOUT" effect
        this.setupTransformEffect('UPPERCASE', () => {
            this.shoutyTransform();
            this.sounds.uppercase();
        });

        // lowercase "whisper" effect
        this.setupTransformEffect('lowercase', () => {
            this.whisperTransform();
            this.sounds.lowercase();
        });

        // sPoNgEbOb "mocking" animation
        this.setupTransformEffect('sPoNgEbOb', () => {
            this.mockingAnimation();
        });

        // Binary matrix rain
        this.setupTransformEffect('01000010', () => {
            this.matrixRainEffect();
        });

        // Zalgo glitch effect
        this.setupTransformEffect('Z̴a̸l̷g̵o̶', () => {
            this.zalgoGlitchEffect();
        });
    }

    setupTransformEffect(buttonText, callback) {
        const buttons = document.querySelectorAll('.btn-transform');
        buttons.forEach(button => {
            if (button.textContent.trim() === buttonText) {
                button.addEventListener('click', callback);
            }
        });
    }

    shoutyTransform() {
        const interface = document.querySelector('.transformation-grid');
        interface.style.animation = 'shoutPulse 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
        
        // Make text bigger temporarily
        const allText = document.querySelectorAll('h1, h2, h3, label, .btn-transform');
        allText.forEach(el => {
            el.style.transform = 'scale(1.05)';
            el.style.fontWeight = 'bolder';
        });
        
        setTimeout(() => {
            interface.style.animation = '';
            allText.forEach(el => {
                el.style.transform = '';
                el.style.fontWeight = '';
            });
        }, 800);
    }

    whisperTransform() {
        const interface = document.querySelector('.transformation-grid');
        
        // Reduce visual weight
        const allText = document.querySelectorAll('h1, h2, h3, label, .btn-transform');
        allText.forEach(el => {
            el.style.transform = 'scale(0.98)';
            el.style.opacity = '0.8';
            el.style.fontWeight = 'lighter';
        });
        
        // Gentle fade back
        setTimeout(() => {
            allText.forEach(el => {
                el.style.transition = 'all 0.6s ease-out';
                el.style.transform = '';
                el.style.opacity = '';
                el.style.fontWeight = '';
            });
        }, 300);
    }

    mockingAnimation() {
        const nearbyElements = document.querySelectorAll('.btn-transform:not(:hover)');
        const randomElements = Array.from(nearbyElements).slice(0, 3);
        
        randomElements.forEach((el, index) => {
            setTimeout(() => {
                el.style.animation = 'mockingWobble 0.5s ease-in-out';
                setTimeout(() => el.style.animation = '', 500);
            }, index * 100);
        });
    }

    matrixRainEffect() {
        const container = document.querySelector('.transformation-grid');
        
        for (let i = 0; i < this.particleSettings.matrix.count; i++) {
            setTimeout(() => {
                this.createMatrixCharacter(container);
            }, i * 50);
        }
    }

    createMatrixCharacter(container) {
        const char = document.createElement('div');
        const binary = this.particleSettings.matrix.chars[Math.floor(Math.random() * 2)];
        
        char.textContent = binary;
        char.style.cssText = `
            position: absolute;
            color: #00ff00;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            pointer-events: none;
            z-index: 1000;
            left: ${Math.random() * 100}%;
            top: -20px;
            animation: matrixFall 2s linear forwards;
        `;
        
        container.appendChild(char);
        setTimeout(() => char.remove(), 2000);
    }

    zalgoGlitchEffect() {
        const elements = document.querySelectorAll('.btn-transform, h1, h2');
        const randomElements = Array.from(elements).slice(0, 4);
        
        randomElements.forEach((el, index) => {
            setTimeout(() => {
                el.style.animation = 'zalgoGlitch 0.6s ease-in-out';
                setTimeout(() => el.style.animation = '', 600);
            }, index * 150);
        });
    }

    // Cursor Personality
    setupCursorPersonality() {
        this.createCursorTrail();
        this.setupMagneticAttraction();
        this.setupCursorBounce();
    }

    createCursorTrail() {
        const trail = [];
        const trailLength = 8;
        
        document.addEventListener('mousemove', (e) => {
            trail.push({ x: e.clientX, y: e.clientY, time: Date.now() });
            
            if (trail.length > trailLength) {
                trail.shift();
            }
            
            // Update trail particles
            this.updateCursorTrail(trail);
        });
    }

    updateCursorTrail(trail) {
        // Remove old particles
        document.querySelectorAll('.cursor-particle').forEach(p => p.remove());
        
        trail.forEach((point, index) => {
            const particle = document.createElement('div');
            const age = Date.now() - point.time;
            const opacity = Math.max(0, 1 - age / 500);
            const size = Math.max(2, 8 - index);
            
            particle.className = 'cursor-particle';
            particle.style.cssText = `
                position: fixed;
                width: ${size}px;
                height: ${size}px;
                background: radial-gradient(circle, var(--accent-primary), transparent);
                border-radius: 50%;
                pointer-events: none;
                z-index: 10000;
                left: ${point.x}px;
                top: ${point.y}px;
                opacity: ${opacity};
                transition: opacity 0.1s ease-out;
            `;
            
            document.body.appendChild(particle);
            
            setTimeout(() => particle.remove(), 500);
        });
    }

    setupMagneticAttraction() {
        const buttons = document.querySelectorAll('.btn-transform.primary');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                document.body.style.cursor = 'none';
                this.createMagneticCursor(button);
            });
            
            button.addEventListener('mouseleave', () => {
                document.body.style.cursor = '';
                document.querySelectorAll('.magnetic-cursor').forEach(c => c.remove());
            });
        });
    }

    createMagneticCursor(target) {
        const cursor = document.createElement('div');
        cursor.className = 'magnetic-cursor';
        cursor.style.cssText = `
            position: fixed;
            width: 20px;
            height: 20px;
            border: 2px solid var(--accent-primary);
            border-radius: 50%;
            pointer-events: none;
            z-index: 10001;
            background: radial-gradient(circle, var(--accent-glow), transparent);
            animation: magneticPulse 1s infinite ease-in-out;
        `;
        
        document.body.appendChild(cursor);
        
        const updateCursorPosition = (e) => {
            cursor.style.left = e.clientX - 10 + 'px';
            cursor.style.top = e.clientY - 10 + 'px';
        };
        
        document.addEventListener('mousemove', updateCursorPosition);
        
        setTimeout(() => {
            document.removeEventListener('mousemove', updateCursorPosition);
        }, 5000);
    }

    setupCursorBounce() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.btn-transform')) return;
            
            this.createBounceEffect(e.clientX, e.clientY);
        });
    }

    createBounceEffect(x, y) {
        const bounce = document.createElement('div');
        bounce.style.cssText = `
            position: fixed;
            width: 30px;
            height: 30px;
            border: 2px solid var(--accent-primary);
            border-radius: 50%;
            left: ${x - 15}px;
            top: ${y - 15}px;
            pointer-events: none;
            z-index: 9999;
            animation: cursorBounce 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        `;
        
        document.body.appendChild(bounce);
        setTimeout(() => bounce.remove(), 400);
    }

    // Success Celebrations
    setupSuccessCelebrations() {
        // Override the copy success to add confetti
        const originalCopyButton = document.querySelector('.btn-copy');
        if (originalCopyButton) {
            originalCopyButton.addEventListener('click', () => {
                setTimeout(() => this.celebrateSuccess(), 100);
            });
        }

        // Add celebration for transformations
        this.setupTransformationCelebrations();
    }

    setupTransformationCelebrations() {
        document.addEventListener('livewire:updated', () => {
            const outputText = document.querySelector('[wire\\:model\\.live="inputText"]');
            if (outputText && outputText.value) {
                this.createTransformationRipple();
                this.sounds.success();
            }
        });
    }

    celebrateSuccess() {
        this.createConfetti();
        this.showSparkleText();
        this.sounds.sparkle();
    }

    createConfetti() {
        const { count, spread, colors } = this.particleSettings.confetti;
        
        for (let i = 0; i < count; i++) {
            setTimeout(() => {
                this.createConfettiParticle(colors[Math.floor(Math.random() * colors.length)]);
            }, i * 30);
        }
    }

    createConfettiParticle(color) {
        const particle = document.createElement('div');
        const startX = Math.random() * window.innerWidth;
        const endX = startX + (Math.random() - 0.5) * 200;
        const rotation = Math.random() * 360;
        
        particle.style.cssText = `
            position: fixed;
            width: 10px;
            height: 10px;
            background: ${color};
            top: -10px;
            left: ${startX}px;
            pointer-events: none;
            z-index: 10000;
            border-radius: 2px;
            animation: confettiFall 3s ease-out forwards;
            --end-x: ${endX}px;
            --rotation: ${rotation}deg;
        `;
        
        document.body.appendChild(particle);
        setTimeout(() => particle.remove(), 3000);
    }

    showSparkleText() {
        const sparkle = document.createElement('div');
        sparkle.innerHTML = '✨ Copied! ✨';
        sparkle.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: bold;
            color: var(--accent-primary);
            pointer-events: none;
            z-index: 10000;
            animation: sparkleFloat 2s ease-out forwards;
        `;
        
        document.body.appendChild(sparkle);
        setTimeout(() => sparkle.remove(), 2000);
    }

    createTransformationRipple() {
        const ripples = document.querySelectorAll('.btn-transform:hover');
        ripples.forEach(button => {
            this.createSuccessRipple(button);
        });
    }

    createSuccessRipple(element) {
        const rect = element.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        
        for (let i = 0; i < 3; i++) {
            setTimeout(() => {
                const ripple = document.createElement('div');
                ripple.style.cssText = `
                    position: fixed;
                    width: 0;
                    height: 0;
                    border: 2px solid var(--accent-primary);
                    border-radius: 50%;
                    left: ${centerX}px;
                    top: ${centerY}px;
                    pointer-events: none;
                    z-index: 9999;
                    animation: successRipple 1s ease-out forwards;
                `;
                
                document.body.appendChild(ripple);
                setTimeout(() => ripple.remove(), 1000);
            }, i * 200);
        }
    }

    // Contextual Interface Responses
    setupContextualResponses() {
        this.setupInputInvitation();
        this.setupButtonCallouts();
        this.setupWarmGlow();
        this.setupStyleGuidePreview();
    }

    setupInputInvitation() {
        const textInput = document.querySelector('#inputText');
        if (!textInput) return;
        
        const pulseWhenEmpty = () => {
            if (!textInput.value.trim()) {
                textInput.style.animation = 'invitePulse 2s ease-in-out infinite';
            } else {
                textInput.style.animation = '';
            }
        };
        
        textInput.addEventListener('input', pulseWhenEmpty);
        setInterval(pulseWhenEmpty, 5000);
    }

    setupButtonCallouts() {
        const buttons = document.querySelectorAll('.btn-transform');
        const usageMap = new Map();
        
        buttons.forEach(button => {
            usageMap.set(button, 0);
            
            button.addEventListener('click', () => {
                usageMap.set(button, usageMap.get(button) + 1);
            });
        });
        
        // Highlight unused buttons occasionally
        setInterval(() => {
            const unusedButtons = Array.from(buttons).filter(btn => usageMap.get(btn) === 0);
            const randomButton = unusedButtons[Math.floor(Math.random() * unusedButtons.length)];
            
            if (randomButton && Math.random() < 0.3) {
                this.calloutButton(randomButton);
            }
        }, 10000);
    }

    calloutButton(button) {
        button.style.animation = 'calloutGlow 1.5s ease-in-out';
        setTimeout(() => button.style.animation = '', 1500);
    }

    setupWarmGlow() {
        const buttons = document.querySelectorAll('.btn-transform');
        
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                button.style.filter = 'hue-rotate(20deg) brightness(1.1)';
                setTimeout(() => button.style.filter = '', 2000);
            });
        });
    }

    setupStyleGuidePreview() {
        const styleButtons = document.querySelectorAll('.btn-style-guide');
        
        styleButtons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                this.showStylePreview(button);
            });
            
            button.addEventListener('mouseleave', () => {
                this.hideStylePreview();
            });
        });
    }

    showStylePreview(button) {
        const preview = document.createElement('div');
        const style = button.textContent.trim();
        
        preview.className = 'style-preview';
        preview.innerHTML = this.getStyleExample(style);
        preview.style.cssText = `
            position: fixed;
            background: var(--neutral-0);
            border: 1px solid var(--neutral-200);
            border-radius: 8px;
            padding: 12px;
            font-size: 12px;
            z-index: 10000;
            pointer-events: none;
            box-shadow: var(--shadow-medium);
            animation: fadeIn 0.3s ease-out;
        `;
        
        const rect = button.getBoundingClientRect();
        preview.style.left = rect.right + 10 + 'px';
        preview.style.top = rect.top + 'px';
        
        document.body.appendChild(preview);
    }

    hideStylePreview() {
        document.querySelectorAll('.style-preview').forEach(p => p.remove());
    }

    getStyleExample(style) {
        const examples = {
            'APA Style': 'Smith, J. (2023). Title case with proper citation.',
            'Chicago': 'Title Should Be Properly Capitalized Here',
            'AP Style': 'Headlines and proper nouns only',
            'MLA Style': 'Last, First. "Title of Work." Publication.',
            'Oxford': 'Formal Academic Style With Precision'
        };
        
        return examples[style] || 'Professional formatting applied';
    }

    // Playful Physics
    setupPlayfulPhysics() {
        this.setupFloatingButtons();
        this.setupElasticBounce();
        this.setupTextDance();
        this.setupGravityDefying();
    }

    setupFloatingButtons() {
        const buttons = document.querySelectorAll('.btn-transform');
        
        buttons.forEach((button, index) => {
            const floatDelay = index * 0.5;
            button.style.animationDelay = `${floatDelay}s`;
            button.classList.add('gentle-float');
        });
    }

    setupElasticBounce() {
        const buttons = document.querySelectorAll('.btn-transform');
        
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                button.style.animation = 'elasticBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
                setTimeout(() => button.style.animation = '', 600);
            });
        });
    }

    setupTextDance() {
        // Text characters dance during transformation
        document.addEventListener('livewire:updated', () => {
            const outputArea = document.querySelector('textarea[readonly]');
            if (outputArea) {
                this.animateTextCharacters(outputArea);
            }
        });
    }

    animateTextCharacters(element) {
        const text = element.value;
        const chars = text.split('');
        
        element.style.position = 'relative';
        element.style.backgroundColor = 'transparent';
        
        // Create dancing characters overlay
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            padding: inherit;
            font: inherit;
            line-height: inherit;
            white-space: pre-wrap;
            word-wrap: break-word;
            overflow: hidden;
        `;
        
        chars.forEach((char, index) => {
            if (char.trim()) {
                const span = document.createElement('span');
                span.textContent = char;
                span.style.animation = `charDance 0.6s ease-out`;
                span.style.animationDelay = `${index * 20}ms`;
                overlay.appendChild(span);
            } else {
                overlay.appendChild(document.createTextNode(char));
            }
        });
        
        element.parentNode.appendChild(overlay);
        
        setTimeout(() => {
            overlay.remove();
        }, 1000);
    }

    setupGravityDefying() {
        const buttons = document.querySelectorAll('.btn-transform.primary');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.animation = 'gravityDefying 0.8s ease-out';
            });
        });
    }

    // Easter Eggs
    setupEasterEggs() {
        this.setupKonamiCode();
        this.setupSecretStats();
        this.setupHiddenFormattingRules();
        this.setupPartyMode();
    }

    setupKonamiCode() {
        document.addEventListener('keydown', (e) => {
            if (e.keyCode === this.konamiCode[this.konamiIndex]) {
                this.konamiIndex++;
                if (this.konamiIndex === this.konamiCode.length) {
                    this.activateKonamiMode();
                    this.konamiIndex = 0;
                }
            } else {
                this.konamiIndex = 0;
            }
        });
    }

    activateKonamiMode() {
        document.body.classList.add('konami-mode');
        this.createKonamiCelebration();
        
        setTimeout(() => {
            document.body.classList.remove('konami-mode');
        }, 10000);
    }

    createKonamiCelebration() {
        // Massive confetti explosion
        for (let i = 0; i < 100; i++) {
            setTimeout(() => {
                this.createConfettiParticle(this.particleSettings.confetti.colors[Math.floor(Math.random() * 5)]);
            }, i * 20);
        }
        
        // Show secret message
        const message = document.createElement('div');
        message.innerHTML = '🎉 DEVELOPER MODE ACTIVATED! 🎉';
        message.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 36px;
            font-weight: bold;
            color: var(--accent-primary);
            text-align: center;
            z-index: 10000;
            animation: konamiMessage 3s ease-out forwards;
        `;
        
        document.body.appendChild(message);
        setTimeout(() => message.remove(), 3000);
    }

    setupSecretStats() {
        let clickCount = 0;
        
        document.addEventListener('dblclick', (e) => {
            if (e.target.closest('.transformation-grid') && !e.target.closest('.btn-transform')) {
                clickCount++;
                this.showSecretStats(clickCount);
            }
        });
    }

    showSecretStats(count) {
        const stats = document.createElement('div');
        const transformCount = document.querySelectorAll('.btn-transform').length;
        
        stats.innerHTML = `
            <div style="font-weight: bold; margin-bottom: 8px;">🔍 Developer Stats</div>
            <div>Transformations Available: ${transformCount}</div>
            <div>Secret Activations: ${count}</div>
            <div>Magic Level: ${Math.min(count * 10, 100)}%</div>
        `;
        
        stats.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--neutral-900);
            color: var(--neutral-0);
            padding: 16px;
            border-radius: 8px;
            font-size: 12px;
            z-index: 10000;
            animation: slideInRight 0.5s ease-out;
        `;
        
        document.body.appendChild(stats);
        setTimeout(() => stats.remove(), 3000);
    }

    setupHiddenFormattingRules() {
        const styleButtons = document.querySelectorAll('.btn-style-guide');
        
        styleButtons.forEach(button => {
            let pressCount = 0;
            
            button.addEventListener('click', () => {
                pressCount++;
                if (pressCount >= 3) {
                    this.showFormattingSecrets(button);
                    pressCount = 0;
                }
            });
        });
    }

    showFormattingSecrets(button) {
        const secrets = this.getFormattingSecrets(button.textContent.trim());
        const popup = document.createElement('div');
        
        popup.innerHTML = `
            <div style="font-weight: bold; margin-bottom: 8px;">📚 Behind the Scenes</div>
            ${secrets}
        `;
        
        popup.style.cssText = `
            position: fixed;
            background: var(--neutral-0);
            border: 2px solid var(--accent-primary);
            border-radius: 12px;
            padding: 20px;
            max-width: 300px;
            z-index: 10000;
            animation: popIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        `;
        
        document.body.appendChild(popup);
        
        setTimeout(() => {
            popup.style.animation = 'popOut 0.3s ease-in forwards';
            setTimeout(() => popup.remove(), 300);
        }, 4000);
    }

    getFormattingSecrets(style) {
        const secrets = {
            'APA Style': 'Uses title case for headings, sentence case for titles. Founded in 1929!',
            'Chicago': 'Two styles: Notes-Bibliography and Author-Date. Academic favorite since 1906.',
            'AP Style': 'Used by journalists worldwide. Updates annually for modern usage.',
            'MLA Style': 'Modern Language Association standard. Emphasizes author-page citations.',
            'Oxford': 'Traditional British academic style. Famous for the Oxford comma debate!'
        };
        
        return secrets[style] || 'Professional formatting with hidden complexity!';
    }

    setupPartyMode() {
        let titleClickCount = 0;
        const title = document.querySelector('h1');
        
        if (title) {
            title.addEventListener('click', () => {
                titleClickCount++;
                if (titleClickCount >= 3) {
                    this.activatePartyMode();
                    titleClickCount = 0;
                }
            });
        }
    }

    activatePartyMode() {
        document.body.classList.add('party-mode');
        
        // Enhanced animations for 10 seconds
        const buttons = document.querySelectorAll('.btn-transform');
        buttons.forEach(button => {
            button.style.animation = 'partyBounce 0.5s infinite alternate ease-in-out';
        });
        
        // Party colors
        const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7', '#fd79a8'];
        let colorIndex = 0;
        
        const colorInterval = setInterval(() => {
            document.documentElement.style.setProperty('--accent-primary', colors[colorIndex]);
            colorIndex = (colorIndex + 1) % colors.length;
        }, 500);
        
        setTimeout(() => {
            document.body.classList.remove('party-mode');
            buttons.forEach(button => button.style.animation = '');
            clearInterval(colorInterval);
            document.documentElement.style.removeProperty('--accent-primary');
        }, 10000);
    }

    // Shareable Elements
    setupShareableElements() {
        this.setupScreenshotReady();
        this.setupViralAnimations();
        this.setupSharePrompts();
    }

    setupScreenshotReady() {
        // Make success moments screenshot-worthy
        document.addEventListener('livewire:updated', () => {
            if (document.querySelector('textarea[readonly]')?.value) {
                this.createScreenshotMoment();
            }
        });
    }

    createScreenshotMoment() {
        const overlay = document.createElement('div');
        overlay.innerHTML = '✨ Transformation Complete! ✨';
        overlay.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-glow));
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: bold;
            z-index: 10000;
            animation: screenshotReady 3s ease-out forwards;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        `;
        
        document.body.appendChild(overlay);
        setTimeout(() => overlay.remove(), 3000);
    }

    setupViralAnimations() {
        // Perfect for TikTok/Instagram
        const specialButtons = document.querySelectorAll('.btn-transform');
        
        specialButtons.forEach(button => {
            button.addEventListener('click', () => {
                if (Math.random() < 0.1) { // 10% chance for viral moment
                    this.createViralMoment(button);
                }
            });
        });
    }

    createViralMoment(button) {
        // Epic transformation sequence
        const sequence = [
            () => button.style.transform = 'scale(1.2) rotate(5deg)',
            () => button.style.transform = 'scale(0.8) rotate(-5deg)',
            () => button.style.transform = 'scale(1.1) rotate(2deg)',
            () => button.style.transform = ''
        ];
        
        sequence.forEach((step, index) => {
            setTimeout(step, index * 150);
        });
        
        // Epic confetti
        setTimeout(() => this.createConfetti(), 300);
    }

    setupSharePrompts() {
        let transformCount = 0;
        
        document.addEventListener('livewire:updated', () => {
            transformCount++;
            
            if (transformCount === 5) {
                this.showSharePrompt();
            }
        });
    }

    showSharePrompt() {
        const prompt = document.createElement('div');
        prompt.innerHTML = `
            <div style="font-size: 18px; margin-bottom: 12px;">🔥 You're on fire!</div>
            <div>Share your text transformation skills with friends!</div>
        `;
        
        prompt.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--accent-primary);
            color: white;
            padding: 16px;
            border-radius: 12px;
            max-width: 250px;
            z-index: 10000;
            animation: sharePrompt 4s ease-out forwards;
            cursor: pointer;
        `;
        
        prompt.addEventListener('click', () => {
            if (navigator.share) {
                navigator.share({
                    title: 'Case Changer Pro',
                    text: 'Transform text into performance art with this amazing tool!',
                    url: window.location.href
                });
            }
            prompt.remove();
        });
        
        document.body.appendChild(prompt);
        setTimeout(() => prompt.remove(), 4000);
    }
}

// Additional CSS Animations for Whimsy
const whimsicalStyles = document.createElement('style');
whimsicalStyles.textContent = `
@keyframes shoutPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

@keyframes mockingWobble {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-2deg) scale(0.98); }
    75% { transform: rotate(2deg) scale(1.02); }
}

@keyframes matrixFall {
    to {
        transform: translateY(100vh);
        opacity: 0;
    }
}

@keyframes zalgoGlitch {
    0%, 100% { filter: none; }
    25% { filter: hue-rotate(90deg) contrast(1.5); }
    50% { filter: hue-rotate(180deg) invert(0.1); }
    75% { filter: hue-rotate(270deg) saturate(2); }
}

@keyframes magneticPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

@keyframes cursorBounce {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0.7; }
    100% { transform: scale(1); opacity: 0; }
}

@keyframes confettiFall {
    0% {
        transform: translateY(-10px) translateX(0) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) translateX(var(--end-x, 0)) rotate(var(--rotation, 0deg));
        opacity: 0;
    }
}

@keyframes sparkleFloat {
    0% {
        transform: translate(-50%, -50%) scale(0);
        opacity: 0;
    }
    50% {
        transform: translate(-50%, -60%) scale(1.2);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -70%) scale(1);
        opacity: 0;
    }
}

@keyframes successRipple {
    to {
        width: 100px;
        height: 100px;
        margin: -50px;
        opacity: 0;
    }
}

@keyframes invitePulse {
    0%, 100% { box-shadow: inset 0 0 0 2px transparent; }
    50% { box-shadow: inset 0 0 0 2px var(--accent-glow); }
}

@keyframes calloutGlow {
    0%, 100% { box-shadow: var(--shadow-ambient); }
    50% { box-shadow: 0 0 20px var(--accent-glow), var(--shadow-medium); }
}

@keyframes gentle-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-2px); }
}

@keyframes elasticBounce {
    0% { transform: scale(1); }
    30% { transform: scale(0.9); }
    60% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes charDance {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    25% { transform: translateY(-3px) rotate(1deg); }
    75% { transform: translateY(-1px) rotate(-1deg); }
}

@keyframes gravityDefying {
    0% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
    100% { transform: translateY(0); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInRight {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}

@keyframes popIn {
    0% { transform: translate(-50%, -50%) scale(0); }
    100% { transform: translate(-50%, -50%) scale(1); }
}

@keyframes popOut {
    to { transform: translate(-50%, -50%) scale(0); opacity: 0; }
}

@keyframes konamiMessage {
    0% { transform: translate(-50%, -50%) scale(0) rotate(-10deg); opacity: 0; }
    50% { transform: translate(-50%, -50%) scale(1.2) rotate(0deg); opacity: 1; }
    100% { transform: translate(-50%, -50%) scale(1) rotate(0deg); opacity: 0; }
}

@keyframes partyBounce {
    from { transform: translateY(0); }
    to { transform: translateY(-10px); }
}

@keyframes screenshotReady {
    0% { transform: translateX(-50%) translateY(-50px); opacity: 0; }
    20% { transform: translateX(-50%) translateY(0); opacity: 1; }
    80% { transform: translateX(-50%) translateY(0); opacity: 1; }
    100% { transform: translateX(-50%) translateY(-20px); opacity: 0; }
}

@keyframes sharePrompt {
    0% { transform: translateX(100%); }
    20% { transform: translateX(0); }
    80% { transform: translateX(0); }
    100% { transform: translateX(100%); }
}

.gentle-float {
    animation: gentle-float 3s ease-in-out infinite;
}

.konami-mode {
    filter: hue-rotate(45deg) saturate(1.5);
}

.party-mode * {
    transition: all 0.3s ease-out !important;
}

/* Accessibility: Respect reduced motion */
@media (prefers-reduced-motion: reduce) {
    .gentle-float,
    [class*="animate-"],
    [style*="animation"] {
        animation: none !important;
    }
}
`;

document.head.appendChild(whimsicalStyles);

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    
    if (!prefersReducedMotion.matches) {
        new WhimsicalDelights();
        console.log('🎭 Whimsical Delights activated! Look for hidden features...');
    }
});

// Export for external use
window.WhimsicalDelights = WhimsicalDelights;
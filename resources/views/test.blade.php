<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Style Debug Test</title>
        @vite(['resources/css/app.css', 'resources/css/glassmorphism.css', 'resources/css/revolutionary-ui.css', 'resources/js/app.js'])
    </head>
    <body>
        <h1>CSS Debug Test Page</h1>

        <div class="p-5 border-2 border-red-500">
            <h2>Plain Test Container</h2>
            <p>This has no glassmorphism classes</p>
        </div>

        <div class="glassmorphism-container gradient-background min-h-[400px] my-5" >
            <h2 class="text-white p-5">Glassmorphism Container Test</h2>

            <div class="floating-orbs">
                <div class="orb orb-1"></div>
                <div class="orb orb-2"></div>
                <div class="orb orb-3"></div>
                <div class="orb orb-4"></div>
            </div>

            <div class="glass-primary m-5 p-5" >
                <h3 class="text-white">Glass Primary Box</h3>
                <p class="text-white">This should have glass effect with backdrop blur</p>
            </div>

            <div class="p-5">
                <button class="glass-button-primary">Glass Button Primary</button>
                <button class="glass-button-secondary">Glass Button Secondary</button>
            </div>
        </div>

        <div class="p-5 border-2 border-blue-500 my-5">
            <h2>CSS Variable Test</h2>
            <div>
                This uses --gradient-primary variable directly
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const testEl = document.querySelector('.glassmorphism-container');
            if (testEl) {
            const styles = window.getComputedStyle(testEl);
            console.log('=== Glassmorphism Container Styles ===');
            console.log('Background:', styles.background);
            console.log('Min-Height:', styles.minHeight);
            console.log('Position:', styles.position);
            console.log('Overflow:', styles.overflow);
            console.log('Animation:', styles.animation);
            }

            const root = document.documentElement;
            const rootStyles = window.getComputedStyle(root);
            console.log('=== CSS Variables ===');
            console.log('--gradient-primary:', rootStyles.getPropertyValue('--gradient-primary'));
            console.log('--glass-bg-primary:', rootStyles.getPropertyValue('--glass-bg-primary'));

            console.log('=== Stylesheets Loaded ===');
            for (let sheet of document.styleSheets) {
            try {
            console.log('Stylesheet:', sheet.href || 'inline');
            } catch(e) {
            console.log('Stylesheet: (cross-origin or inline)');
            }
            }
            });
        </script>
    </body>
</html>
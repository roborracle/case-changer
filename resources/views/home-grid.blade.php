<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Case Changer Pro - 172+ Professional Text Transformation Tools</title>
    <meta name="description" content="Professional text transformation suite with 172+ tools. All transformations validated every 6 hours for quality assurance.">
    <meta name="keywords" content="text converter, case converter, text transformation, uppercase, lowercase, camelCase, snake_case, validation verified">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @if(isset($schemaData))
    <script type="application/ld+json">
        {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif
    
    <style>
        .validation-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-cyan-50 dark:from-gray-900 dark:via-blue-900 dark:to-cyan-900"
      x-data="validationDashboard()">
    
    <!-- Header -->
    <header class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-400 dark:to-cyan-400">
                        Case Changer Pro
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        172+ Text Transformation Tools • Validated Every 6 Hours
                    </p>
                </div>
                
                <!-- Theme Dropdown -->
                <div x-data="{ ...themeManager(), showDropdown: false }" class="relative">
                    <button @click="showDropdown = !showDropdown" 
                            class="flex items-center px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="flex items-center">
                            <!-- Light Mode Icon -->
                            <svg x-show="theme === 'light'" class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                            <!-- Dark Mode Icon -->
                            <svg x-show="theme === 'dark'" class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <!-- System Mode Icon -->
                            <svg x-show="theme === 'system'" class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span x-text="theme.charAt(0).toUpperCase() + theme.slice(1)"></span>
                        </span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="showDropdown" 
                         @click.away="showDropdown = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                        <button @click="setTheme('light'); showDropdown = false" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-lg">
                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                            Light
                        </button>
                        <button @click="setTheme('dark'); showDropdown = false" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            Dark
                        </button>
                        <button @click="setTheme('system'); showDropdown = false" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-b-lg">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            System
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                Transform Text Instantly
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-8">
                Professional-grade text transformation tools with real-time validation monitoring. 
                Start transforming your text now or choose from our top tools below.
            </p>
            
            <!-- CRITICAL: Main Text Input Field -->
            <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 border border-blue-200 dark:border-blue-800">
                <form action="{{ route('transform') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="text-input" class="block text-lg font-semibold text-gray-900 dark:text-white mb-3">
                            Enter Your Text to Transform
                        </label>
                        <textarea 
                            id="text-input"
                            name="text"
                            rows="6"
                            class="w-full px-4 py-3 text-lg border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all"
                            placeholder="Type or paste your text here to transform it instantly..."
                            required
                        ></textarea>
                    </div>
                    
                    <div class="flex flex-col md:flex-row gap-4">
                        <select name="transformation" class="flex-1 px-4 py-3 text-lg border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Choose Transformation...</option>
                            <optgroup label="Popular">
                                <option value="upper-case">UPPERCASE</option>
                                <option value="lower-case">lowercase</option>
                                <option value="title-case">Title Case</option>
                                <option value="camel-case">camelCase</option>
                                <option value="snake-case">snake_case</option>
                            </optgroup>
                            <optgroup label="More Options">
                                <option value="kebab-case">kebab-case</option>
                                <option value="pascal-case">PascalCase</option>
                                <option value="reverse">Reverse Text</option>
                                <option value="base64-encode">Base64 Encode</option>
                            </optgroup>
                        </select>
                        
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                            Transform Text Now
                        </button>
                    </div>
                </form>
                
                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                    💡 Tip: Select a transformation above or browse our 172+ tools below for more options
                </div>
            </div>
        </div>
        
        <!-- Top Categories Grid (2x5 on desktop) -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6 mb-12">
            @if(isset($topCategories))
                @foreach($topCategories as $category)
                    <a href="{{ $category['url'] }}" 
                       class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm hover:shadow-xl transform hover:scale-105 transition-all duration-200 group">
                        <!-- Category Icon -->
                        <div class="text-3xl mb-3">
                            {{ $category['icon'] }}
                        </div>
                        
                        <!-- Category Title -->
                        <h3 class="font-semibold text-base text-gray-900 dark:text-white mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $category['title'] }}
                        </h3>
                        
                        <!-- Tool Count -->
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            {{ $category['description'] }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                            {{ $category['tool_count'] }} tools
                        </p>
                    </a>
                @endforeach
            @else
                <!-- Fallback if no categories data -->
                @for($i = 1; $i <= 10; $i++)
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                    <div class="animate-pulse">
                        <div class="h-10 w-10 bg-gray-300 dark:bg-gray-700 rounded mb-3"></div>
                        <div class="h-4 bg-gray-300 dark:bg-gray-700 rounded mb-2"></div>
                        <div class="h-3 bg-gray-200 dark:bg-gray-600 rounded"></div>
                    </div>
                </div>
                @endfor
            @endif
        </div>
        
        <!-- Quick Actions Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-12">
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Browse All Tools -->
                <a href="{{ route('case-changer') }}" 
                   class="group bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-6 hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Browse All 172+ Tools</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Explore our complete collection of text transformation tools</p>
                </a>
                
                <!-- Modern Interface -->
                <a href="{{ route('modern-case-changer') }}" 
                   class="group bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-6 hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-500 transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Try Modern Interface</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Experience our keyboard-first command palette interface</p>
                </a>
                
                <!-- Validation Dashboard -->
                <a href="/api/validation/status" 
                   class="group bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600 rounded-xl p-6 hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Validation Status</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">View real-time validation results and system health</p>
                </a>
            </div>
        </div>
        
        <!-- Statistics Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex justify-center">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">172+</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Tools Available</div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="mt-auto bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    © {{ date('Y') }} Case Changer Pro. All tools validated and operational.
                </div>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <a href="/api/validation/status" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">API Status</a>
                    <a href="/api/validation/certificate" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Validation Certificate</a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        function validationDashboard() {
            return {
                validationStatuses: {},
                
                init() {
                    this.fetchValidationStatus();
                    setInterval(() => this.fetchValidationStatus(), 60000);
                },
                
                async fetchValidationStatus() {
                    try {
                        const response = await fetch('/api/tools/validation-status');
                        const data = await response.json();
                        if (data && data.data) {
                            this.validationStatuses = data.data;
                        }
                    } catch (error) {
                        console.error('Failed to fetch validation status:', error);
                    }
                }
            }
        }
        
        function themeManager() {
            return {
                theme: localStorage.getItem('theme') || 'system',
                isDark: false,
                
                init() {
                    this.applyTheme();
                    
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                        if (this.theme === 'system') {
                            this.applyTheme();
                        }
                    });
                },
                
                applyTheme() {
                    let isDark = false;
                    
                    if (this.theme === 'dark') {
                        isDark = true;
                    } else if (this.theme === 'light') {
                        isDark = false;
                    } else {
                        isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    }
                    
                    this.isDark = isDark;
                    
                    if (isDark) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                },
                
                setTheme(theme) {
                    this.theme = theme;
                    localStorage.setItem('theme', theme);
                    this.applyTheme();
                },
                
                cycleTheme() {
                    const themes = ['light', 'dark', 'system'];
                    const currentIndex = themes.indexOf(this.theme);
                    const nextIndex = (currentIndex + 1) % themes.length;
                    this.setTheme(themes[nextIndex]);
                }
            };
        }
    </script>
</body>
</html>

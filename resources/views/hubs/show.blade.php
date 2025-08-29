<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $categoryData['title'] }} - Case Changer Pro</title>
    <meta name="description" content="{{ $categoryData['description'] }}">
    <meta name="keywords" content="text converter, {{ strtolower($categoryData['name']) }}, text transformation">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @if(isset($schemaData))
    @foreach($schemaData as $schema)
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endforeach
    @endif
    
    <style>
        .metric-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.8);
        }
        .dark .metric-card {
            background: rgba(31, 41, 55, 0.8);
        }
        .chart-container {
            position: relative;
            height: 200px;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-cyan-50 dark:from-gray-900 dark:via-blue-900 dark:to-cyan-900"
      x-data="hubDashboard()">
    
    <!-- Header with Breadcrumbs -->
    <header class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-4">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-4">
                <a href="/" class="hover:text-blue-600 dark:hover:text-blue-400">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="/hubs" class="hover:text-blue-600 dark:hover:text-blue-400">Content Hubs</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ $categoryData['name'] }}</span>
            </nav>
            
            <!-- Page Title -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                        <span class="text-4xl mr-3">{{ $categoryData['icon'] }}</span>
                        {{ $categoryData['title'] }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $categoryData['description'] }}</p>
                </div>
                
                <!-- Quick Actions -->
                <div class="hidden md:flex space-x-3">
                    <button @click="refreshMetrics()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refresh Metrics
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <main class="container mx-auto px-4 py-8">
        <!-- CRITICAL: Category-Specific Input Field -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border-2 border-{{ $category === 'text-case' ? 'blue' : ($category === 'programming-cases' ? 'purple' : 'green') }}-500">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                    Try {{ $categoryData['name'] }} Tools Instantly
                </h3>
                <form action="{{ route('transform') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <textarea 
                            name="text"
                            rows="4"
                            class="w-full px-4 py-3 text-lg border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Enter text to transform with {{ strtolower($categoryData['name']) }} tools..."
                            required
                        ></textarea>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @foreach(array_slice($categoryData['tools'], 0, 5) as $toolId)
                        <button type="submit" name="transformation" value="{{ $toolId }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-blue-800 rounded-lg font-medium transition-colors">
                            {{ ucwords(str_replace('-', ' ', $toolId)) }}
                        </button>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content Area -->
            <div class="lg:col-span-2">
                <!-- Quality Metrics Dashboard -->
                <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Quality Metrics Dashboard</h2>
                    
                    <!-- Summary Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="metric-card rounded-lg p-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400">Reliability Score</div>
                            <div class="text-2xl font-bold" :class="{
                                'text-green-600': metrics.reliability_score >= 90,
                                'text-yellow-600': metrics.reliability_score >= 70 && metrics.reliability_score < 90,
                                'text-red-600': metrics.reliability_score < 70
                            }" x-text="metrics.reliability_score + '%'">--</div>
                        </div>
                        
                        <div class="metric-card rounded-lg p-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400">Average Speed</div>
                            <div class="text-2xl font-bold text-blue-600" x-text="metrics.average_speed + 'ms'">--</div>
                        </div>
                        
                        <div class="metric-card rounded-lg p-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400">Tools Passed</div>
                            <div class="text-2xl font-bold text-green-600">
                                <span x-text="metrics.tools_passed">--</span>/<span x-text="metrics.total_tools">--</span>
                            </div>
                        </div>
                        
                        <div class="metric-card rounded-lg p-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400">Error Rate</div>
                            <div class="text-2xl font-bold" :class="{
                                'text-green-600': metrics.error_rate <= 2,
                                'text-yellow-600': metrics.error_rate > 2 && metrics.error_rate <= 5,
                                'text-red-600': metrics.error_rate > 5
                            }" x-text="metrics.error_rate + '%'">--</div>
                        </div>
                    </div>
                    
                    <!-- Charts -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Performance Trend</h3>
                            <div class="chart-container">
                                <canvas id="performanceChart"></canvas>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Usage Distribution</h3>
                            <div class="chart-container">
                                <canvas id="usageChart"></canvas>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- Comprehensive Guide -->
                <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Complete Guide</h2>
                    
                    <div class="prose dark:prose-invert max-w-none">
                        <p class="lead text-lg text-gray-600 dark:text-gray-400">{{ $guideContent['introduction'] }}</p>
                        
                        @foreach($guideContent['sections'] as $section)
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">{{ $section['title'] }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $section['content'] }}</p>
                            
                            @if(isset($section['examples']) && count($section['examples']) > 0)
                            <div class="mt-4 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Examples:</h4>
                                <div class="space-y-2">
                                    @foreach($section['examples'] as $label => $example)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $label }}:</span>
                                        <code class="px-2 py-1 bg-white dark:bg-gray-800 rounded text-sm">{{ $example }}</code>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </section>
                
                <!-- Tools in Category -->
                <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Available Tools</h2>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($tools as $tool)
                        <a href="{{ $tool['url'] }}" class="group border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-500 hover:shadow-lg transition-all">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600">{{ $tool['name'] }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">ID: {{ $tool['id'] }}</p>
                                </div>
                                
                                @if($tool['metrics']['validation_status'] === 'passed')
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                @elseif($tool['metrics']['validation_status'] === 'failed')
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                @else
                                <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                @endif
                            </div>
                            
                            @if($tool['metrics']['reliability_score'] > 0)
                            <div class="mt-3 flex items-center justify-between text-xs text-gray-600 dark:text-gray-400">
                                <span>Reliability: {{ $tool['metrics']['reliability_score'] }}%</span>
                                <span>Speed: {{ $tool['metrics']['avg_speed'] }}ms</span>
                            </div>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </section>
            </div>
            
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Top Performers -->
                @if(isset($metrics['top_performers']) && count($metrics['top_performers']) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <svg class="w-5 h-5 inline mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Top Performers
                    </h3>
                    <div class="space-y-3">
                        @foreach(array_slice($metrics['top_performers'], 0, 5) as $performer)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $performer['name'] }}</span>
                            <span class="text-sm font-medium text-green-600">{{ $performer['score'] }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Needs Attention -->
                @if(isset($metrics['needs_attention']) && count($metrics['needs_attention']) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <svg class="w-5 h-5 inline mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Needs Attention
                    </h3>
                    <div class="space-y-3">
                        @foreach($metrics['needs_attention'] as $tool)
                        <div>
                            <div class="text-sm text-gray-700 dark:text-gray-300">{{ $tool['name'] }}</div>
                            <div class="text-xs text-red-600 dark:text-red-400">{{ $tool['issue'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Related Categories -->
                @if(isset($relatedContent['related_categories']) && count($relatedContent['related_categories']) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Related Categories</h3>
                    <div class="space-y-3">
                        @foreach($relatedContent['related_categories'] as $related)
                        <a href="{{ $related['url'] }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-600 transition-colors">
                            <div class="font-medium text-gray-900 dark:text-white">{{ $related['name'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $related['description'] }}</div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Tutorials -->
                @if(isset($relatedContent['tutorials']) && count($relatedContent['tutorials']) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tutorials & Guides</h3>
                    <ul class="space-y-2">
                        @foreach($relatedContent['tutorials'] as $tutorial)
                        <li>
                            <a href="{{ $tutorial['url'] }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                {{ $tutorial['title'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </aside>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="mt-16 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                © {{ date('Y') }} Case Changer Pro. Professional Text Transformation Suite.
            </div>
        </div>
    </footer>
    
    <script>
        function hubDashboard() {
            return {
                metrics: @json($metrics ?? []),
                performanceChart: null,
                usageChart: null,
                
                init() {
                    this.initCharts();
                    setInterval(() => this.refreshMetrics(), 300000);
                },
                
                initCharts() {
                    const perfCtx = document.getElementById('performanceChart').getContext('2d');
                    this.performanceChart = new Chart(perfCtx, {
                        type: 'line',
                        data: {
                            labels: this.metrics.performance_trend?.map(d => d.date) || [],
                            datasets: [{
                                label: 'Average Speed (ms)',
                                data: this.metrics.performance_trend?.map(d => d.avg_speed) || [],
                                borderColor: 'rgb(59, 130, 246)',
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                    
                    const usageCtx = document.getElementById('usageChart').getContext('2d');
                    this.usageChart = new Chart(usageCtx, {
                        type: 'doughnut',
                        data: {
                            labels: this.metrics.usage_distribution?.map(d => d.tool) || [],
                            datasets: [{
                                data: this.metrics.usage_distribution?.map(d => d.count) || [],
                                backgroundColor: [
                                    '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
                                    '#EC4899', '#14B8A6', '#F97316', '#06B6D4', '#84CC16'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 10,
                                        font: {
                                            size: 10
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                
                async refreshMetrics() {
                    try {
                        const response = await fetch('/hub/{{ $category }}/metrics');
                        const data = await response.json();
                        
                        if (data && data.data) {
                            this.metrics = data.data;
                            this.updateCharts();
                        }
                    } catch (error) {
                        console.error('Failed to refresh metrics:', error);
                    }
                },
                
                updateCharts() {
                    if (this.performanceChart) {
                        this.performanceChart.data.labels = this.metrics.performance_trend?.map(d => d.date) || [];
                        this.performanceChart.data.datasets[0].data = this.metrics.performance_trend?.map(d => d.avg_speed) || [];
                        this.performanceChart.update();
                    }
                    
                    if (this.usageChart) {
                        this.usageChart.data.labels = this.metrics.usage_distribution?.map(d => d.tool) || [];
                        this.usageChart.data.datasets[0].data = this.metrics.usage_distribution?.map(d => d.count) || [];
                        this.usageChart.update();
                    }
                }
            }
        }
    </script>
</body>
</html>
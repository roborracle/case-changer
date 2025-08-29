@extends('layouts.app')

@section('title', 'QA Dashboard - Case Changer Pro')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">QA Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Monitor test quality, coverage, and performance metrics</p>
        </div>

        <!-- Status Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Quality Score -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Quality Score</h3>
                    <span class="text-2xl font-bold {{ $qualityScore['score'] >= 80 ? 'text-green-600' : ($qualityScore['score'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ $qualityScore['grade'] }}
                    </span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($qualityScore['score'], 1) }}%</div>
                <div class="flex items-center mt-2">
                    @if($qualityScore['trend'] === 'improving')
                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-500 text-sm">Improving</span>
                    @elseif($qualityScore['trend'] === 'declining')
                        <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-red-500 text-sm">Declining</span>
                    @else
                        <svg class="w-4 h-4 text-gray-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-500 text-sm">Stable</span>
                    @endif
                </div>
            </div>

            <!-- Test Coverage -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Code Coverage</h3>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($coverage['line'], 1) }}%</div>
                <div class="mt-2">
                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400">
                        <span>Lines</span>
                        <span>{{ $coverage['statements']['covered'] ?? 0 }}/{{ $coverage['statements']['total'] ?? 0 }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $coverage['line'] }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Test Status -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Test Status</h3>
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($currentStatus['status'] === 'passed')
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        @elseif($currentStatus['status'] === 'failed')
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        @elseif($currentStatus['status'] === 'running')
                            <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                        @else
                            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-lg font-semibold text-gray-900 dark:text-white capitalize">{{ $currentStatus['status'] }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $currentStatus['message'] }}</p>
                    </div>
                </div>
                @if($currentStatus['lastRun'])
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">Last run: {{ $currentStatus['lastRun'] }}</p>
                @endif
            </div>

            <!-- Open Defects -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Open Defects</h3>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $defects['by_status']['open'] ?? 0 }}</div>
                <div class="flex space-x-2 mt-2">
                    @if(isset($defects['by_severity']['critical']) && $defects['by_severity']['critical'] > 0)
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded">{{ $defects['by_severity']['critical'] }} Critical</span>
                    @endif
                    @if(isset($defects['by_severity']['high']) && $defects['by_severity']['high'] > 0)
                        <span class="px-2 py-1 text-xs bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200 rounded">{{ $defects['by_severity']['high'] }} High</span>
                    @endif
                    @if(isset($defects['by_severity']['medium']) && $defects['by_severity']['medium'] > 0)
                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded">{{ $defects['by_severity']['medium'] }} Medium</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Trends Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Coverage Trend</h3>
                <canvas id="coverageTrendChart" height="150"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pass Rate Trend</h3>
                <canvas id="passRateTrendChart" height="150"></canvas>
            </div>
        </div>

        <!-- Recent Test Runs -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Test Runs</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Run ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Started</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentRuns as $run)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $run->run_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $run->status === 'passed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $run->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $run->status === 'running' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $run->status === 'pending' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ $run->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $run->duration_seconds ? number_format($run->duration_seconds, 2) . 's' : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($run->started_at ?? $run->created_at)->format('M d, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" x-on:click.prevent="viewRunDetails('{{ $run->run_id }}')" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center">
            <div class="flex space-x-4">
                <button x-on:click="triggerTestRun()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Run Tests
                </button>
                <button x-on:click="refreshDashboard()" class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Refresh
                </button>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Auto-refresh in <span id="refresh-timer">60</span> seconds
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const coverageCtx = document.getElementById('coverageTrendChart').getContext('2d');
    new Chart(coverageCtx, {
        type: 'line',
        data: {
            labels: @json($trends['labels']),
            datasets: [{
                label: 'Coverage %',
                data: @json($trends['datasets']['coverage'] ?? []),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    const passRateCtx = document.getElementById('passRateTrendChart').getContext('2d');
    new Chart(passRateCtx, {
        type: 'line',
        data: {
            labels: @json($trends['labels']),
            datasets: [{
                label: 'Pass Rate %',
                data: @json($trends['datasets']['passRate'] ?? []),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    function viewRunDetails(runId) {
        fetch(`/qa/api/runs/${runId}`)
            .then(response => response.json())
            .then(data => {
                console.log('Run details:', data);
            });
    }

    function triggerTestRun() {
        if (confirm('Start a new test run?')) {
            fetch('/qa/api/trigger-run', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    coverage: true,
                    parallel: true
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Test run started: ' + data.run_id);
                    setTimeout(() => location.reload(), 2000);
                }
            });
        }
    }

    function refreshDashboard() {
        location.reload();
    }

    let refreshTimer = 60;
    setInterval(() => {
        refreshTimer--;
        document.getElementById('refresh-timer').textContent = refreshTimer;
        if (refreshTimer <= 0) {
            refreshDashboard();
        }
    }, 1000);
</script>
@endpush
@endsection

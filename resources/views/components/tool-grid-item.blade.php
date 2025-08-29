@props(['tool'])

<div class="tool-grid-item relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm hover:shadow-xl transform hover:scale-105 transition-all duration-200 cursor-pointer group"
     x-on:click="window.location.href='{{ $tool['url'] }}'"
     x-data="{ showTooltip: false }">
    
    <!-- Validation Badge -->
    <div class="absolute top-2 right-2 z-10"
         @mouseenter="showTooltip = true"
         @mouseleave="showTooltip = false">
        
        <!-- Badge Circle -->
        <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-md transition-all duration-300
            @if($tool['validation']['badge'] === 'green') bg-green-500
            @elseif($tool['validation']['badge'] === 'yellow') bg-yellow-500
            @elseif($tool['validation']['badge'] === 'red') bg-red-500
            @elseif($tool['validation']['badge'] === 'orange') bg-orange-500
            @else bg-gray-400
            @endif">
            
            @if($tool['validation']['icon'] === 'check')
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            @elseif($tool['validation']['icon'] === 'x')
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            @elseif($tool['validation']['icon'] === 'warning')
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            @elseif($tool['validation']['icon'] === 'alert')
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @else
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @endif
        </div>
        
        <!-- Tooltip -->
        <div x-show="showTooltip"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             class="absolute top-10 right-0 z-20 bg-gray-900 text-white text-xs rounded-lg py-2 px-3 whitespace-nowrap shadow-xl">
            <div class="font-semibold">{{ $tool['validation']['label'] }}</div>
            <div class="text-gray-300">{{ $tool['validation']['tooltip'] }}</div>
            <div class="absolute -top-1 right-2 w-2 h-2 bg-gray-900 transform rotate-45"></div>
        </div>
    </div>
    
    <!-- Tool Icon -->
    <div class="text-4xl mb-3">
        {{ $tool['icon'] }}
    </div>
    
    <!-- Tool Name -->
    <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
        {{ $tool['name'] }}
    </h3>
    
    <!-- Tool Description -->
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
        {{ $tool['description'] }}
    </p>
    
    <!-- Category Tag -->
    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
        {{ $tool['category'] }}
    </div>
    
    <!-- Hover Effect Overlay -->
    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 opacity-0 group-hover:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
</div>

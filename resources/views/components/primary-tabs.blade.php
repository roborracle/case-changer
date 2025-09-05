@props(['tabs' => [], 'activeTabId' => null])

<div 
    x-data="primaryTabs(@js($activeTabId))"
    role="tablist"
    aria-label="Primary text transformations"
    class="w-full"
    @keydown.arrow-right.prevent="nextTab()"
    @keydown.arrow-left.prevent="previousTab()"
    @keydown.home.prevent="firstTab()"
    @keydown.end.prevent="lastTab()"
>
    {{-- Tab Buttons Container --}}
    <div class="flex bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-md p-1">
        @foreach($tabs as $index => $tab)
            <button
                x-ref="tab-{{ $tab['id'] }}"
                @click="selectTab('{{ $tab['id'] }}')"
                :class="{
                    'border-b-2 border-blue-500 bg-blue-500/10 text-slate-900 dark:text-slate-100 font-semibold': activeTab === '{{ $tab['id'] }}',
                    'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-gray-700': activeTab !== '{{ $tab['id'] }}'
                }"
                class="flex-1 h-11 flex items-center justify-center px-3 py-2 rounded-md transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                role="tab"
                :aria-selected="activeTab === '{{ $tab['id'] }}' ? 'true' : 'false'"
                aria-controls="panel-{{ $tab['id'] }}"
                :tabindex="activeTab === '{{ $tab['id'] }}' ? '0' : '-1'"
                data-tab-id="{{ $tab['id'] }}"
            >
                @if(isset($tab['icon']))
                    <span class="mr-2">{!! $tab['icon'] !!}</span>
                @endif
                <span>{{ $tab['label'] }}</span>
            </button>
        @endforeach
    </div>

    {{-- Tab Panels Container --}}
    <div class="mt-4">
        @foreach($tabs as $tab)
            <div
                x-show="activeTab === '{{ $tab['id'] }}'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                role="tabpanel"
                id="panel-{{ $tab['id'] }}"
                aria-labelledby="tab-{{ $tab['id'] }}"
                :tabindex="activeTab === '{{ $tab['id'] }}' ? '0' : '-1'"
                class="focus:outline-none"
            >
                {{-- Content slot for each tab --}}
                @if(isset($tab['content']))
                    {!! $tab['content'] !!}
                @else
                    {{-- Dynamic slot based on tab ID --}}
                    @if(View::exists('components.tabs.' . $tab['id']))
                        @include('components.tabs.' . $tab['id'])
                    @else
                        <div class="p-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg">
                            <p class="text-gray-600 dark:text-gray-400">Tab content for {{ $tab['label'] }}</p>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>
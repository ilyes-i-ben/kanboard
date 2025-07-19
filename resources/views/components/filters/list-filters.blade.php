@props(['board'])
@php
    $labelClass = 'block text-xs font-medium text-white dark:text-gray-300 mb-1';
    $inputClass = 'w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white/90 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-sm transition-shadow duration-150 shadow-sm';
    $containerClass = 'flex flex-col gap-1';
    $sectionTitleClass = 'text-sm font-semibold text-white dark:text-slate-400 mb-2 tracking-wide';
    $cardClass = 'w-full bg-transparent rounded-2xl shadow-xl dark:border-gray-800 p-6 mb-8';
    $resetBtnClass = 'absolute top-6 right-6 px-2 py-1 rounded-md bg-white/90 dark:bg-gray-900 text-blue-700 dark:text-blue-400 border-2 border-white-300 dark:border-gray-400 text-xs font-semibold shadow focus:ring-2 focus:ring-blue-400 transition-colors';
@endphp

<div class="relative w-full rounded-3xl p-6 mb-8 shadow-2xl border border-white/20
    bg-gradient-to-br from-white/10 via-white/5 to-transparent
    dark:bg-none dark:backdrop-blur-xl overflow-hidden"
    @if(isset($board->background_color))
        style="background:
            radial-gradient(circle at 20% 20%, rgba(255,255,255,0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
            linear-gradient(135deg, {{ $board->background_color }}33 0%, {{ $board->background_color }}B3 50%, {{ $board->background_color }}E6 100%);
            backdrop-filter: blur(10px);"
    @endif
>
    <div class="flex items-center justify-end mb-4 z-20 relative gap-3">
        <span class="inline-flex items-center gap-2 bg-white/20 dark:bg-black/30 rounded-xl px-4 py-1.5 text-sm font-semibold text-white dark:text-white shadow border border-white/20">
            <x-heroicon-o-rectangle-stack class="w-5 h-5 text-white dark:text-blue-300" />
            <span id="total-cards-count">{{ $board->lists->sum(fn($list) => $list->cards()->count()) }}</span> Cards
        </span>
        <button
            data-tooltip-target="reset-filters-tooltip"
            type="button"
            class="ml-2 px-2 py-1 rounded-xl bg-white/20 dark:bg-blue-900/40 text-white dark:text-blue-300 border-2 border-white/30 dark:border-blue-400 text-xs font-semibold shadow-lg focus:ring-2 focus:ring-blue-400 transition-colors z-20 hover:bg-white/40 hover:scale-105"
            style="position: static; top: auto; right: auto;"
            onclick="window.dispatchEvent(new CustomEvent('reset-filters'))"
        >
            <x-heroicon-o-arrow-path class="h-6 w-6" />
        </button>
        <div id="reset-filters-tooltip" role="tooltip" class="absolute z-30 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-slate-800">
            Reset filters
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>

    <div class="absolute inset-0 opacity-20 pointer-events-none select-none">
        <div class="absolute top-8 left-8 w-24 h-24 rounded-full bg-white/10 blur-xl animate-pulse dark:bg-white/10"></div>
        <div class="absolute top-1/3 right-16 w-16 h-16 rounded-full bg-white/15 blur-lg animate-pulse delay-1000 dark:bg-white/15"></div>
        <div class="absolute bottom-10 left-1/3 w-12 h-12 rounded-full bg-white/12 blur-md animate-pulse delay-2000 dark:bg-white/12"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
        <div class="col-span-1 flex flex-col gap-6">
            <div class="flex items-center gap-2 text-lg font-bold text-white/90 dark:text-white mb-2 tracking-wide">
                <x-heroicon-o-magnifying-glass class="w-6 h-6" />
                Search
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-white/80 dark:text-gray-200 mb-1" for="filter-card-name">Card Name</label>
                <input type="text" id="filter-card-name" placeholder="Search by name..." class="w-full rounded-xl border border-white/30 dark:border-gray-700 bg-white/80 dark:bg-black/80 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-sm shadow transition-all duration-150" />
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-white/80 dark:text-gray-200 mb-1" for="filter-card-description">Description</label>
                <input type="text" id="filter-card-description" placeholder="Search by description..." class="w-full rounded-xl border border-white/30 dark:border-gray-700 bg-white/80 dark:bg-black/80 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-sm shadow transition-all duration-150" />
            </div>
        </div>
        <div class="col-span-1 flex flex-col gap-6">
            <div class="flex items-center gap-2 text-lg font-bold text-white/90 dark:text-white mb-2 tracking-wide">
                <x-heroicon-s-list-bullet class="w-6 h-6" />
                Details
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-white/80 dark:text-gray-200 mb-1" for="filter-list-title">In list</label>
                <select id="filter-list-title" class="w-full rounded-xl border border-white/30 dark:border-gray-700 bg-white/80 dark:bg-black/80 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-sm shadow transition-all duration-150">
                    <option value="">All Lists</option>
                    @foreach($board->lists as $list)
                        <option value="{{ strtolower($list->title) }}">{{ $list->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-2">
                <x-filters.priority-select id="filter-priority" />
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-white/80 dark:text-gray-200 mb-1" for="filter-category">Category</label>
                <select id="filter-category" class="w-full rounded-xl border border-white/30 dark:border-gray-700 bg-white/80 dark:bg-black/80 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-sm shadow transition-all duration-150">
                    <option value="">All Categories</option>
                    <option value="uncategorized">Not specified</option>
                    @foreach($board->categories as $category)
                        <option value="{{ strtolower($category->name) }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-white/80 dark:text-gray-200 mb-1" for="filter-status">Status</label>
                <x-filters.completed-status />
            </div>
        </div>
        <div class="col-span-1 flex flex-col gap-6">
            <div class="flex items-center gap-2 text-lg font-bold text-white/90 dark:text-white mb-2 tracking-wide">
                <x-heroicon-o-calendar-days class="w-6 h-6" />
                Dates
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-white/80 dark:text-gray-200 mb-1" for="filter-start-date">Start Date</label>
                <x-date-picker id="filter-start-date" />
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-white/80 dark:text-gray-200 mb-1" for="filter-end-date">End Date</label>
                <x-date-picker id="filter-end-date" type="range"/>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-pulse {
        animation: pulse 4s ease-in-out infinite;
    }
    .delay-1000 { animation-delay: 1s; }
    .delay-2000 { animation-delay: 2s; }
    @keyframes pulse {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 0.4; }
    }
</style>

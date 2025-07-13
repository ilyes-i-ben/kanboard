@props(['board'])
@php
    $labelClass = 'block text-xs font-medium text-white dark:text-gray-300 mb-1';
    $inputClass = 'w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white/90 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-sm transition-shadow duration-150 shadow-sm';
    $containerClass = 'flex flex-col gap-1';
    $sectionTitleClass = 'text-sm font-semibold text-white dark:text-slate-400 mb-2 tracking-wide';
    $cardClass = 'w-full bg-transparent rounded-2xl shadow-xl dark:border-gray-800 p-6 mb-8';
    $resetBtnClass = 'absolute top-6 right-6 px-2 py-1 rounded-md bg-white/90 dark:bg-gray-900 text-blue-700 dark:text-blue-400 border-2 border-white-300 dark:border-gray-400 text-xs font-semibold shadow focus:ring-2 focus:ring-blue-400 transition-colors';
@endphp

<div class="relative {{ $cardClass }}">
    <button
        data-tooltip-target="reset-filters-tooltip"
        type="button"
        class="{{ $resetBtnClass }}"
        onclick="window.dispatchEvent(new CustomEvent('reset-filters'))"
    >
        <x-heroicon-o-arrow-path class="h-6 w-6" />
    </button>
    <div id="reset-filters-tooltip" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
        Reset filters
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1 flex flex-col gap-4">
            <div class="{{ $sectionTitleClass }}"><x-heroicon-o-magnifying-glass class="w-6 h-6 mr-2 inline" />Search</div>
            <div class="{{ $containerClass }}">
                <label class="{{ $labelClass }}" for="filter-card-name">Card Name</label>
                <input type="text" id="filter-card-name" placeholder="Search by name..." class="{{ $inputClass }} pr-10" />
            </div>
            <div>
                <label class="{{ $labelClass }}" for="filter-card-description">Description</label>
                <input type="text" id="filter-card-description" placeholder="Search by description..." class="{{ $inputClass }}" />
            </div>
        </div>
        <div class="col-span-1 flex flex-col gap-4">
            <div class="{{ $sectionTitleClass }}"><x-heroicon-s-list-bullet class="w-6 h-6 mr-2 inline" />Details</div>
            <div class="{{ $containerClass }}">
                <label class="{{ $labelClass }}" for="filter-list-title">In list</label>
                <select id="filter-list-title" class="{{ $inputClass }}">
                    <option value="">All Lists</option>
                    @foreach($board->lists as $list)
                        <option value="{{ strtolower($list->title) }}">{{ $list->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="{{ $containerClass }}">
                <x-filters.priority-select id="filter-priority" />
            </div>
            <div class="{{ $containerClass }}">
                <label class="{{ $labelClass }}" for="filter-status">Status</label>
                <x-filters.completed-status />
            </div>
        </div>
        <div class="col-span-1 flex flex-col gap-4">
            <div class="{{ $sectionTitleClass }}"><x-heroicon-o-calendar-days class="w-6 h-6 mr-2 inline" />Dates</div>
            <div class="{{ $containerClass }}">
                <label class="{{ $labelClass }}" for="filter-start-date">Start Date</label>
                <x-date-picker id="filter-start-date" />
            </div>
            <div class="{{ $containerClass }}">
                <label class="{{ $labelClass }}" for="filter-end-date">End Date</label>
                <x-date-picker id="filter-end-date" type="range"/>
            </div>
        </div>
    </div>
</div>

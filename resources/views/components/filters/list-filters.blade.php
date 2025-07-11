@props(['board'])
{{--TODO:: fix labels + fix padding + fix the reset button --}}
@php
    $labelClass = 'block text-xs font-medium text-white dark:text-gray-300 mb-1';
    $inputClass = 'w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white/90 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-sm transition-shadow duration-150 shadow-sm';
    $containerClass = 'flex flex-col gap-1';
    $sectionTitleClass = 'text-sm font-semibold text-white dark:text-slate-400 mb-2 tracking-wide';
    $cardClass = 'w-full bg-transparent rounded-2xl shadow-xl dark:border-gray-800 p-6 mb-8';
    $resetBtnClass = 'absolute top-6 right-6 px-2 py-1 rounded-md bg-gradient-to-r from-blue-500 to-blue-700 text-white text-xs font-semibold shadow hover:scale-105 transition-transform duration-150 focus:ring-2 focus:ring-blue-400';
@endphp

<div class="relative {{ $cardClass }}">
    <button type="button" class="{{ $resetBtnClass }}" onclick="window.dispatchEvent(new CustomEvent('reset-filters'))" title="Reset filters">
        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M19.418 19A9 9 0 104.582 9" /></svg>
    </button>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1 flex flex-col gap-4">
            <div>
                <div class="{{ $sectionTitleClass }}">Search</div>
                <div class="{{ $containerClass }}">
                    <label class="{{ $labelClass }}" for="filter-card-name">Card Name</label>
                    <div class="relative">
                        <input type="text" id="filter-card-name" placeholder="Search by name..." class="{{ $inputClass }} pr-10" />
                        <span class="absolute right-3 top-2.5 text-gray-400 dark:text-gray-500"><x-heroicon-o-magnifying-glass class="w-4 h-4" /></span>
                    </div>
                </div>
            </div>
            <div>
                <label class="{{ $labelClass }}" for="filter-card-description">Description</label>
                <input type="text" id="filter-card-description" placeholder="Search by description..." class="{{ $inputClass }}" />
            </div>
        </div>
        <div class="col-span-1 flex flex-col gap-4">
            <div>
                <div class="{{ $sectionTitleClass }}">Details</div>
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
                    <label class="{{ $labelClass }}" for="filter-priority">Priority</label>
                    <x-filters.priority-select id="filter-priority" />
                </div>
            </div>
        </div>
        <div class="col-span-1 flex flex-col gap-4">
            <div>
                <div class="{{ $sectionTitleClass }}">Dates & Status</div>
                <div class="{{ $containerClass }}">
                    <label class="{{ $labelClass }}" for="filter-start-date">Start Date</label>
                    <x-date-picker-placeholder id="filter-start-date" />
                </div>
                <div class="{{ $containerClass }}">
                    <label class="{{ $labelClass }}" for="filter-end-date">End Date</label>
                    <x-date-picker-placeholder id="filter-end-date" />
                </div>
                <div class="{{ $containerClass }}">
                    <label class="{{ $labelClass }}" for="filter-status">Status</label>
                    <x-filters.completed-status />
                </div>
            </div>
        </div>
    </div>
</div>

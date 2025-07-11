@php
    $labelClass = 'block text-xs font-medium text-white dark:text-gray-300 mb-1';
    $inputClass = 'w-full rounded-md border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none px-3 py-2 text-sm';
    $containerClass = 'flex-1';
@endphp

<div class="mb-6 flex flex-col md:flex-row md:items-end md:space-x-4 space-y-2 md:space-y-0">
    <div class="{{ $containerClass }}">
        <label class="{{ $labelClass }}">Card Name</label>
        <input type="text" id="filter-card-name" placeholder="Search by name..." class="{{ $inputClass }}" />
    </div>
    <div class="{{ $containerClass }}">
        <label class="{{ $labelClass }}">Description</label>
        <input type="text" id="filter-card-description" placeholder="Search by description..." class="{{ $inputClass }}" />
    </div>
    <div class="{{ $containerClass }}">
        <label class="{{ $labelClass }}">Start Date</label>
        <x-date-picker-placeholder id="filter-start-date" />
    </div>
    <div class="{{ $containerClass }}">
        <label class="{{ $labelClass }}">End Date</label>
        <x-date-picker-placeholder id="filter-end-date" />
    </div>
    <div class="{{ $containerClass }}">
        <x-filters.priority-select id="filter-priority" />
    </div>
    <div class="{{ $containerClass }}">
        <label class="{{ $labelClass }}">Status</label>
        <x-filters.completed-status />
    </div>
</div>

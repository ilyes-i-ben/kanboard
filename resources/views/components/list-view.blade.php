@props(['board'])
{{-- TODO:: save the last selected list mode to localStorage--}}
<div class="list-view w-5/6 bg-white/5 dark:bg-gray-900 rounded-lg p-4">
    <div class="mb-6 flex flex-col md:flex-row md:items-end md:space-x-4 space-y-2 md:space-y-0">
        <div class="flex-1">
            <label class="block text-xs font-medium text-white dark:text-gray-300 mb-1">Card Name</label>
            <input type="text" id="filter-card-name" placeholder="Search by name..." class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none px-3 py-2 text-sm" />
        </div>
        <div class="flex-1">
            <label class="block text-xs font-medium text-white dark:text-gray-300 mb-1">Description</label>
            <input type="text" id="filter-card-description" placeholder="Search by description..." class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none px-3 py-2 text-sm" />
        </div>
        <div class="flex-1">
            <label class="block text-xs font-medium text-white dark:text-gray-300 mb-1">Start Date</label>
            <x-date-picker-placeholder id="filter-start-date" />
        </div>
        <div class="flex-1">
            <label class="block text-xs font-medium text-white dark:text-gray-300 mb-1">End Date</label>
            <x-date-picker-placeholder id="filter-end-date" />
        </div>
    </div>

    <div id="list-view-card-list" class="space-y-3">
        @foreach($board->lists as $list)
            @foreach($list->cards as $card)
                <x-card-list-item :card="$card" />
            @endforeach
        @endforeach
        <div id="no-cards-message" class="hidden text-center text-gray-500 dark:text-gray-400 py-8 text-sm">No cards found matching your filters.</div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/app.js')
@endpush

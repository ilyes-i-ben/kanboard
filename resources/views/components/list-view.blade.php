@props(['board'])
<div class="list-view w-5/6 bg-white/5 dark:bg-gray-900 rounded-lg p-4">
    <x-filters.list-filters />

    <div id="list-view-card-list" class="space-y-3">
        @foreach($board->lists as $list)
            @foreach($list->cards as $card)
                <x-card-list-item :card="$card" />
            @endforeach
        @endforeach
        <div id="no-cards-message" class="hidden text-center text-white dark:text-gray-400 py-8 text-sm flex flex-col items-center">
            <x-heroicon-s-no-symbol class="w-10 h-10 mb-2" />
            <span>
                No cards found matching your filters.
            </span>
        </div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/app.js')
@endpush

@props(['list'])

<div
    class="list bg-gray-100 dark:bg-gray-800 rounded-lg shadow p-3 w-72 flex flex-col h-full"
    x-data="{
        listId: {{ $list->id }}
    }"
    x-sort:item="{{ $list->id }}"
>
    <div class="flex justify-between items-center mb-3">
        <h2 class="font-bold text-gray-800 dark:text-gray-200">{{ $list->title }}</h2>
        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $list->cards->count() }} cards</div>
    </div>

    <div
        class="cards-container flex-1 overflow-y-auto min-h-[200px] max-h-[calc(100vh-220px)]"
        x-sort="updateCardPosition($item, $position, listId)"
        x-sort:group="cards"
    >
        @foreach($list->cards->sortBy('position') as $card)
            <x-card :card="$card" />
        @endforeach
    </div>

    <!-- Add card button (placeholder for future implementation) -->
    <button
        class="mt-2 w-full flex items-center justify-center text-sm text-gray-600 dark:text-gray-400 py-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded transition"
    >
        <x-heroicon-s-plus class="w-6 h-6" />
        {{ __("Add a card") }}
    </button>
</div>

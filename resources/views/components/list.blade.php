@props(['list'])

<div
    x-data="{ showCreateCardModal: false }"
    class="list bg-gray-100 dark:bg-gray-800 rounded-lg shadow p-3 w-96 flex flex-col h-full"
    x-sort:item="{{ $list->id }}"
>
    <div class="flex justify-between items-center mb-3">
        <h2 class="font-bold text-gray-800 dark:text-gray-200">{{ $list->title }}</h2>
        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $list->cards->count() }} cards</div>
    </div>

    <div
        class="cards-container flex-1 overflow-y-auto min-h-[200px] max-h-[calc(100vh-220px)]"
        x-sort="updateCardPosition($item, $position, '{{ $list->id }}')"
        x-sort:group="cards"
    >
        @if($list->cards->isEmpty())
            <div class="text-center text-gray-800 dark:text-gray-400 py-8 text-sm flex items-center">
                <x-heroicon-s-no-symbol class="w-10 h-10 mb-2" />
                <span>
                    No cards in this list.
                </span>
            </div>
        @else
            @foreach($list->cards->sortBy('position') as $card)
                <x-card :card="$card"/>
            @endforeach
        @endif
    </div>

    <button
        class="mt-2 w-full flex items-center justify-center text-sm text-gray-600 dark:text-gray-400 py-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded transition"
        @click="showCreateCardModal = true"
    >
        <x-heroicon-s-plus class="w-6 h-6"/>
        {{ __("Add a card") }}
    </button>

    <x-card.create-modal
        :list="$list"
        :board="$list->board"
        show-create-card-modal="showCreateCardModal"
        onClose="() => { showCreateCardModal = false }"
    />
</div>

@props(['list'])

<div
    id="list-id-{{ $list->id }}"
    x-data="{ showCreateCardModal: false, showEditListModal: false }"
    class="list bg-gray-100 dark:bg-gray-800 rounded-lg shadow p-3 min-w-80 w-80 flex flex-col"
    x-sort:item="{{ $list->id }}"
>
    <div class="flex justify-between items-center mb-3">
        <div class="flex items-center gap-2">
            <h2
                id="title-list-{{ $list->id }}"
                class="font-bold text-gray-800 dark:text-gray-200"
            >{{ $list->title }}</h2>
            <span
                id="terminal-badge-{{ $list->id }}"
                class="terminal-badge {{ !$list->is_terminal ? 'hidden ' : '' }} ml-2 px-2 py-0.5 rounded bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs font-semibold shadow"
            >Terminal</span>
        </div>
        <button
            type="button"
            class="flex items-center justify-center"
            title="Edit list"
            @click="showEditListModal = true"
        >
            <x-heroicon-o-pencil-square class="w-8 h-8 text-white" style="background:rgba(0,0,0,0.25);border-radius:4px;padding:2px;" />
        </button>
    </div>

    <div
        id="list-cards-container-{{ $list->id }}"
        class="cards-container flex-1 overflow-y-auto min-h-[200px] max-h-[calc(100vh-220px)]"
        x-sort="updateCardPosition($item, $position, '{{ $list->id }}')"
        x-sort:group="cards"
    >
        @if($list->cards->isEmpty())
            <div class="empty-list flex flex-col items-center justify-center h-full text-gray-800 dark:text-gray-400 py-8 text-sm">
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
    <x-list.edit-modal
        :list="$list"
        :board="$list->board"
        show-edit-list-modal="showEditListModal"
    />
</div>

@props(['board'])

<div
    class="board-container h-full rounded-lg p-4"
    style="background-color: {{ $board->background_color }}"
    x-data="boardComponent()"
>
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white drop-shadow">{{ $board->title }}</h1>

        <div class="flex items-center space-x-4">
            <!-- Board members display -->
            <a href="{{ route('boards.members.index', $board) }}" class="bg-white/10 backdrop-blur-sm rounded-md px-3 py-1 hover:bg-white/20 transition">
                <div class="flex p-2 -space-x-1 overflow-hidden items-center">
                    @foreach($board->members->take(5) as $member)
                        <x-user.avatar :user="$member"/>
                    @endforeach
                    @if($board->members->count() > 5)
                        <span
                            class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-gray-100 text-[11px] font-semibold text-gray-800 ring-1 ring-white"
                            style="font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;"
                        >
                            +{{ $board->members->count() - 5 }}
                        </span>
                    @endif
                </div>
            </a>
        </div>
    </div>

    <div
        class="lists-container flex space-x-4 overflow-x-auto pb-4"
        x-sort="updateListPosition($item, $position)"
        x-sort:group="lists"
    >
        @foreach($board->lists->sortBy('position') as $list)
            <x-list :list="$list" />
        @endforeach

        <!-- Add list placeholder (future implementation) -->
        <div class="w-72 bg-white/20 backdrop-blur-sm rounded-lg p-3 flex items-center justify-center cursor-pointer hover:bg-white/30 transition">
            <div class="text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add another list
            </div>
        </div>
    </div>
</div>

<script>
    function boardComponent() {
        return {
            updateCardPosition(cardId, position, listId) {
                fetch('/api/cards/move', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        board_id: {{ $board->id }},
                        card_id: cardId,
                        list_id: listId,
                        position: position,
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Error updating card position');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            },

            calculateNewPosition(index) {
                return (index + 1) * 100;
            },

            updateListPosition(listId, position) {
                fetch('/api/lists/move', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        list_id: listId,
                        position: (position + 1) * 100
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Error updating list position');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }
    }
</script>

@props(['board'])

<div
    class="board-container h-full rounded-lg p-4 m-6"
    style="background-color: {{ $board->background_color }}"
    x-data="boardComponent()"
>
    <div class="mb-4 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <template x-if="!editingTitle">
                <h1
                    class="text-2xl font-bold text-white drop-shadow select-text"
                    x-text="title"
                ></h1>
            </template>
            <template x-if="editingTitle">
                <input
                    x-ref="titleInput"
                    x-model="title"
                    @keydown.enter.prevent="confirmEditTitle"
                    @keydown.escape="cancelEditTitle"
                    class="text-2xl font-bold text-white drop-shadow bg-transparent border-b border-white focus:outline-none px-1"
                    style="min-width: 120px; max-width: 400px;"
                />
            </template>
            @if(auth()->id() === $board->created_by)
                <button
                    x-show="!editingTitle"
                    @click="startEditTitle"
                    class="ml-2 p-1 rounded hover:bg-white/20 transition"
                    title="Edit title"
                >
                    <x-heroicon-o-pencil-square class="w-8 h-8 text-white" style="background:rgba(0,0,0,0.25);border-radius:4px;padding:2px;" />
                </button>
            @endif
            <button
                x-show="editingTitle"
                @click="confirmEditTitle"
                class="ml-2 p-1 rounded hover:bg-green-500/20 transition"
                title="Confirm"
            >
                <x-heroicon-o-check-circle class="w-10 h-10 text-white" style="background:rgba(0,0,0,0.25);border-radius:4px;padding:2px;" />
            </button>
        </div>
        <div class="flex-1 flex justify-center">
            <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-md px-2 py-1">
                <button @click="viewType = 'kanban'" :class="viewType === 'kanban' ? 'bg-white/20' : ''" class="p-2 rounded transition hover:bg-white/20" title="Kanban view">
                    <x-heroicon-o-table-cells class="w-6 h-6 text-white" />
                </button>
                <button @click="viewType = 'list'" :class="viewType === 'list' ? 'bg-white/20' : ''" class="p-2 rounded transition hover:bg-white/20" title="List view">
                    <x-heroicon-o-bars-3-bottom-left class="w-6 h-6 text-white" />
                </button>
                <button @click="viewType = 'calendar'" :class="viewType === 'calendar' ? 'bg-white/20' : ''" class="p-2 rounded transition hover:bg-white/20" title="Calendar view">
                    <x-heroicon-o-calendar-days class="w-6 h-6 text-white" />
                </button>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('boards.members.index', $board) }}" class="bg-white/10 backdrop-blur-sm rounded-md px-3 py-1 hover:bg-white/20 transition">
                <span class="text-xs font-medium text-white drop-shadow-sm mr-2">Manage members</span>
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
            <a href="{{ route('boards.edit', $board) }}" class="flex items-center justify-center bg-white/10 backdrop-blur-sm rounded-full w-12 h-12 hover:bg-white/20 transition">
                <x-heroicon-s-cog-6-tooth class="w-8 h-8 text-white" />
            </a>
        </div>
    </div>

    <div
        x-show="viewType === 'kanban'"
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
    <div
        class="flex justify-center"
        x-show="viewType === 'list'"
    >
        <x-list-view :board="$board" />
    </div>
    <div x-show="viewType === 'calendar'">
        <div class="text-center text-gray-400 py-12 text-lg font-semibold">Calendar view coming soon...</div>
    </div>
</div>

<script>
    // TODO:: replace the hard-coded urls with blade route() methodd.
    // TODO:: move to a SOLID seperate JS file..
    function boardComponent() {
        return {
            title: @json($board->title),
            editingTitle: false,
            originalTitle: @json($board->title),
            // TODO:: save the last selected list mode to localStorage
            viewType: 'list',
            startEditTitle() {
                this.editingTitle = true;
                this.$nextTick(() => this.$refs.titleInput.focus());
            },
            cancelEditTitle() {
                this.title = this.originalTitle;
                this.editingTitle = false;
            },
            confirmEditTitle() {
                this.editingTitle = false;
                this.originalTitle = this.title;
                fetch('/api/boards/{{ $board->id }}/update-title', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ title: this.title })
                }).then(() => {
                });
            },

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

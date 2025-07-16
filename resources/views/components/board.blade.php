@props(['board'])

<div
    class="board-container h-full rounded-3xl p-6 m-4 relative overflow-hidden shadow-2xl border border-white/20"
    style="
        background:
            radial-gradient(circle at 20% 20%, rgba(255,255,255,0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
            linear-gradient(135deg, {{ $board->background_color }} 0%, {{ $board->background_color }}E6 50%, {{ $board->background_color }}CC 100%);
        backdrop-filter: blur(10px);
        position: relative;
    "
    x-data="boardComponent()"
>
    <!-- Animated background elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-10 left-10 w-32 h-32 rounded-full bg-white/10 blur-xl animate-pulse"></div>
        <div class="absolute top-1/3 right-20 w-24 h-24 rounded-full bg-white/15 blur-lg animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-1/3 w-20 h-20 rounded-full bg-white/12 blur-md animate-pulse delay-2000"></div>
    </div>

    <!-- Enhanced Header Section -->
    <div class="mb-8 relative z-10">
        <!-- Board Title and Stats Row -->
        <div class="flex justify-between items-start mb-6">
            <div class="flex-1">
                <div x-cloak class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                            <x-heroicon-o-rectangle-group class="w-7 h-7 text-white" />
                        </div>
                        <div>
                            <template x-if="!editingTitle">
                                <h1
                                    class="text-4xl font-black text-white drop-shadow-lg select-text tracking-tight"
                                    x-text="title"
                                ></h1>
                            </template>
                            <template x-if="editingTitle">
                                <input
                                    x-ref="titleInput"
                                    x-model="title"
                                    @keydown.enter.prevent="confirmEditTitle"
                                    @keydown.escape="cancelEditTitle"
                                    class="text-4xl font-black text-white drop-shadow-lg bg-transparent border-b-2 border-white focus:outline-none px-2 tracking-tight"
                                    style="min-width: 200px; max-width: 600px;"
                                />
                            </template>
                        </div>
                    </div>
                    @if(auth()->id() === $board->created_by)
                        <button
                            x-show="!editingTitle"
                            @click="startEditTitle"
                            class="p-3 rounded-xl bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105"
                            title="Edit title"
                        >
                            <x-heroicon-o-pencil-square class="w-6 h-6 text-white" />
                        </button>
                    @endif
                    <button
                        x-show="editingTitle"
                        @click="confirmEditTitle"
                        class="p-3 rounded-xl bg-green-500/20 backdrop-blur-sm hover:bg-green-500/30 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105"
                        title="Confirm"
                    >
                        <x-heroicon-o-check-circle class="w-6 h-6 text-white" />
                    </button>
                </div>

                <!-- Board Stats -->
                <div class="flex items-center space-x-6 text-white/90">
                    <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 shadow-lg">
                        <x-heroicon-o-rectangle-group class="w-5 h-5" />
                        <span class="text-sm font-semibold"><span id="board-list-count">{{ $board->lists->count() }}</span> Lists</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 shadow-lg">
                        <x-heroicon-o-users class="w-5 h-5" />
                        <span class="text-sm font-semibold">{{ $board->members->count() }} Members</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 shadow-lg">
                        <x-heroicon-o-clock class="w-5 h-5" />
                        <span class="text-sm font-semibold">Created {{ $board->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Controls and Actions Row -->
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-1 bg-white/15 backdrop-blur-lg rounded-2xl p-2 shadow-xl border border-white/20">
                    <button
                        @click="viewType = 'kanban'"
                        :class="viewType === 'kanban' ? 'bg-white/30 shadow-lg scale-105' : 'hover:bg-white/20'"
                        class="p-3 rounded-xl transition-all duration-300 hover:scale-105"
                        title="Kanban view"
                    >
                        <x-heroicon-o-table-cells class="w-6 h-6 text-white" />
                    </button>
                    <button
                        @click="viewType = 'list'"
                        :class="viewType === 'list' ? 'bg-white/30 shadow-lg scale-105' : 'hover:bg-white/20'"
                        class="p-3 rounded-xl transition-all duration-300 hover:scale-105"
                        title="List view"
                    >
                        <x-heroicon-o-bars-3-bottom-left class="w-6 h-6 text-white" />
                    </button>
                    <button
                        @click="viewType = 'calendar'"
                        :class="viewType === 'calendar' ? 'bg-white/30 shadow-lg scale-105' : 'hover:bg-white/20'"
                        class="p-3 rounded-xl transition-all duration-300 hover:scale-105"
                        title="Calendar view"
                    >
                        <x-heroicon-o-calendar-days class="w-6 h-6 text-white" />
                    </button>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Members Section -->
                <a
                    href="{{ route('boards.members.index', $board) }}"
                    class="group flex items-center space-x-4 bg-white/15 backdrop-blur-lg rounded-2xl px-6 py-3 hover:bg-white/25 transition-all duration-300 shadow-xl border border-white/20 hover:scale-105"
                >
                    <div class="flex flex-col items-start">
                        <span class="text-sm font-bold text-white mb-1">Team Members</span>
                        <span class="text-xs text-white/80">Manage access & permissions</span>
                    </div>
                    <div class="flex -space-x-2">
                        @foreach($board->members->take(4) as $member)
                            <div class="ring-2 ring-white/30 rounded-full transition-transform group-hover:scale-110">
                                <x-user.avatar :user="$member"/>
                            </div>
                        @endforeach
                        @if($board->members->count() > 4)
                            <div class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-white/20 backdrop-blur-sm text-xs font-bold text-white ring-2 ring-white/30 transition-transform group-hover:scale-110">
                                +{{ $board->members->count() - 4 }}
                            </div>
                        @endif
                    </div>
                    <x-heroicon-o-chevron-right class="w-5 h-5 text-white/70 group-hover:text-white transition-colors" />
                </a>

                <!-- Settings Button -->
                <a
                    href="{{ route('boards.edit', $board) }}"
                    class="group flex items-center justify-center bg-white/15 backdrop-blur-lg rounded-2xl w-14 h-14 hover:bg-white/25 transition-all duration-300 shadow-xl border border-white/20 hover:scale-105"
                    title="Board Settings"
                >
                    <x-heroicon-o-cog-6-tooth class="w-7 h-7 text-white group-hover:rotate-180 transition-transform duration-500" />
                </a>
            </div>
        </div>
    </div>

    <!-- Board Content -->
    <div class="relative z-10">
        <div
            x-show="viewType === 'kanban'"
            x-data="{ showCreateListModal: false }"
            class="lists-container flex space-x-6 overflow-x-auto pb-6 scroll-smooth"
            x-sort="updateListPosition($item, $position)"
            x-sort:group="lists"
            style="scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.3) transparent;"
        >
            @foreach($board->lists->sortBy('position') as $list)
                <x-list :list="$list" />
            @endforeach

            <div
                id="add-list-section"
                class="min-w-80 bg-white/15 backdrop-blur-lg rounded-2xl p-6 flex flex-col items-center justify-center cursor-pointer hover:bg-white/25 transition-all duration-300 shadow-xl border border-white/20 hover:scale-105 group"
                @click="showCreateListModal = true"
            >
                <div class="text-white flex flex-col items-center space-y-3">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-white/30 transition-all duration-300">
                        <x-heroicon-s-plus class="w-8 h-8 group-hover:scale-110 transition-transform"/>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-bold mb-1">Add New List</div>
                        <div class="text-sm text-white/80">Create another list for your board</div>
                    </div>
                </div>
            </div>
            <x-list.create-modal
                show-create-list-modal="showCreateListModal"
                onClose="() => { showCreateListModal = false }"
                :board="$board"
            />
        </div>

        <div x-show="viewType === 'calendar'" class="text-center py-20">
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-12 shadow-2xl border border-white/20 max-w-md mx-auto">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <x-heroicon-o-calendar-days class="w-10 h-10 text-white" />
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Calendar View</h3>
                <p class="text-white/80 text-lg">Coming soon with advanced scheduling features!</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom scrollbar for lists container */
    .lists-container::-webkit-scrollbar {
        height: 8px;
    }

    .lists-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .lists-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    .lists-container::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Smooth animations */
    @keyframes pulse {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 0.4; }
    }

    .animate-pulse {
        animation: pulse 4s ease-in-out infinite;
    }

    .delay-1000 {
        animation-delay: 1s;
    }

    .delay-2000 {
        animation-delay: 2s;
    }
</style>

<script>
    // TODO:: replace the hard-coded urls with blade route() methodd.
    // TODO:: move to a SOLID seperate JS file..
    function boardComponent() {
        return {
            title: @json($board->title),
            editingTitle: false,
            originalTitle: @json($board->title),
            // TODO:: save the last selected list mode to localStorage
            viewType: 'kanban',
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
                    window.showSuccessToast('Board title updated successfully!');
                    document.querySelector("#board-title-{{ $board->id }}").innerHTML = this.title;
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
                    .then(responseData => {
                        if (!responseData.success) {
                            console.error('Error updating card position');
                        }
                        if (responseData.completed) {
                            window.dispatchEvent(new CustomEvent('card-completed', { detail: {cardId} }));
                        }
                        if (responseData.original?.emptied) {
                            window.dispatchEvent(new CustomEvent('list-emptied', { detail: {listId: responseData.original.id} }));
                        }
                        if (responseData.target?.wasEmpty) {
                            window.dispatchEvent(new CustomEvent('list-was-empty', { detail: {listId: responseData.target.id} }));
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
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        board_id: {{ $board->id }},
                        list_id: listId,
                        position: position
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

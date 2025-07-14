@props(['list', 'board', 'showCreateCardModal' => false, 'onClose'])

<div
    x-show="showCreateCardModal"
    x-cloak
    x-transition
    class="fixed inset-0 z-100 overflow-auto bg-black bg-opacity-50 flex items-center justify-center"
    @keydown.escape.window="showCreateCardModal = false; if (typeof onClose === 'function') onClose()"
    x-on:close-create-card-modal.window="showCreateCardModal = false"
>
    <div
        class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-xl mx-4 overflow-hidden border border-gray-200 dark:border-gray-700 animate-fadeIn"
        @click.stop
        @click.away="showCreateCardModal = false; if (typeof onClose === 'function') onClose()"
    >
        <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <div class="flex items-center gap-3">
                <x-heroicon-o-plus class="w-7 h-7 text-blue-500 dark:text-blue-400"/>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create Card</h2>
            </div>
            <button
                @click="showCreateCardModal = false; if (typeof onClose === 'function') onClose()"
                class="rounded-full p-2 text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition"
            >
                <x-heroicon-o-x-mark class="w-6 h-6"/>
            </button>
        </div>
        <form method="POST" action="{{ route('cards.store') }}" class="card-create-modal-form p-3 space-y-3">
            @csrf
            <input type="hidden" name="board_id" value="{{ $list->board_id }}">
            <input type="hidden" name="list_id" value="{{ $list->id }}" />
            <section>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                <input type="text" name="title" id="title" required class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Card title">
            </section>
            <section>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" id="description" rows="3" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Card description"></textarea>
            </section>
            <section>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">In list</label>
                <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 rounded px-3 py-2">
                    <x-heroicon-o-rectangle-group class="w-5 h-5 text-blue-400" />
                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $list->title }}</span>
                </div>
            </section>
            <section>
                <label
                    for="deadline"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                >Deadline</label>
                <input
                    type="date"
                    id="deadline"
                    value="2025-07-22"
                    name="deadline"
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none px-3 py-2 text-sm placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="Select date..."
                />
            </section>
            <section>
                <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                <div class="relative">
                    <select name="priority" id="priority" required class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none pr-10">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </section>
            <section>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assignees</label>
                <div class="flex flex-wrap gap-3">
                    @foreach($board->members as $member)
                        <label class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 rounded-full px-3 py-1 shadow-sm cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900 transition">
                            <input
                                type="checkbox"
                                name="assignees[]"
                                value="{{ $member->id }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                            <x-user.avatar :user="$member" />
                            <span class="text-sm text-gray-800 dark:text-gray-200 font-medium">{{ $member->name }}</span>
                        </label>
                    @endforeach
                </div>
            </section>
            <section class="flex justify-end gap-3">
                <button type="button" @click="showCreateCardModal = false; if (typeof onClose === 'function') onClose()" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">Cancel</button>
                <x-primary-button type="submit" class="flex items-center gap-2">
                    <x-heroicon-o-plus class="mr-2 h-5 w-5" />
                    {{ __('Create Card') }}
                </x-primary-button>
            </section>
        </form>
    </div>
</div>

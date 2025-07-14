@props(['showCreateListModal' => false, 'board', 'onClose'])

<div
    x-show="showCreateListModal"
    x-cloak
    x-transition
    class="fixed inset-0 z-150 overflow-auto bg-black bg-opacity-50 flex items-center justify-center"
    @keydown.escape.window="showCreateListModal = false; if (typeof onClose === 'function') onClose()"
    x-on:close-create-list-modal.window="showCreateListModal = false"
    @click.away="showCreateListModal = false; if (typeof onClose === 'function') onClose()"
>
    <div
        class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden border border-gray-200 dark:border-gray-700"
        @click.stop
    >
        <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <div class="flex items-center gap-3">
                <x-heroicon-o-plus class="w-7 h-7 text-blue-500 dark:text-blue-400"/>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create List</h2>
            </div>
            <button
                @click="showCreateListModal = false; if (typeof onClose === 'function') onClose()"
                class="rounded-full p-2 text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition"
            >
                <x-heroicon-o-x-mark class="w-6 h-6"/>
            </button>
        </div>
        {{-- TODO: fix name focusing only on label-click --}}
        <form method="POST" action="{{ route('lists.store') }}" class="list-create-modal-form p-4 space-y-4">
            @csrf
            <input type="hidden" name="board_id" value="{{ $board->id }}">
            <section>
                <label for="list_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">List name</label>
                <input type="text" name="list_name" id="list_name" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="List name">
            </section>
            <section>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mark as terminating</label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_terminal" value="1" class="sr-only peer">
                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600 dark:peer-checked:bg-red-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Terminating</span>
                </label>
            </section>
            <section class="flex justify-end gap-3">
                <button type="button" @click="showCreateListModal = false; if (typeof onClose === 'function') onClose()" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">Cancel</button>
                <x-primary-button type="submit" class="flex items-center gap-2">
                    <x-heroicon-o-plus class="mr-2 h-5 w-5" />
                    {{ __('Create List') }}
                </x-primary-button>
            </section>
        </form>
    </div>
</div>

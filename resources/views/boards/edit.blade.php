<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="flex justify-center items-center p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 relative">
                    <a href="{{ route('boards.show', $board) }}" class="absolute left-6 inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition">
                        <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                        Back to board
                    </a>
                    <div class="flex items-center gap-3">
                        <x-heroicon-o-cog-6-tooth class="w-7 h-7 text-blue-500 dark:text-blue-400" />
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Edit Board') }}</h1>
                    </div>
                </div>

                <div class="p-6 space-y-8">
                    <form method="POST" action="{{ route('boards.update', $board) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <x-heroicon-o-document-text class="w-6 h-6 text-blue-500 dark:text-blue-400" />
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('Board Details') }}</h2>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="title" :value="__('Title')" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />
                                    <x-text-input
                                        id="title"
                                        name="title"
                                        type="text"
                                        class="w-full text-lg font-medium"
                                        placeholder="{{ __('Board Title') }}"
                                        value="{{ old('title', $board->title) }}"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="background_color" :value="__('Background Color')" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" />
                                    <input
                                        id="background_color"
                                        name="background_color"
                                        type="color"
                                        class="p-1 h-12 w-24 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 shadow"
                                        value="{{ old('background_color', $board->background_color ?? '#2563eb') }}"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <x-heroicon-o-document-text class="w-6 h-6 text-blue-500 dark:text-blue-400" />
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('Description') }}</h2>
                            </div>

                            <div x-data="{ editing: false }">
                                <div x-show="!editing" class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 min-h-[120px] mb-4 border border-gray-100 dark:border-gray-800">
                                    <div class="prose dark:prose-invert max-w-none [&_*]:text-gray-900 dark:[&_*]:text-gray-100">
                                        {!! old('description', $board->description) !!}
                                    </div>
                                </div>
                                <button type="button" x-show="!editing" @click="editing = true; $nextTick(() => { if(window.tinymce) tinymce.init({ selector: '#description', menubar: false, plugins: 'link lists code', toolbar: 'undo redo | bold italic underline | bullist numlist | link | code' }); })" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <x-heroicon-o-pencil-square class="w-4 h-4" />
                                    {{ __('Edit Description') }}
                                </button>
                                <div x-show="editing" x-cloak>
                                    <x-textarea
                                        id="description"
                                        name="description"
                                        class="tinyMce w-full min-h-[180px] text-base rounded-lg border-gray-300 dark:border-gray-700 focus:border-blue-500 focus:ring-blue-500"
                                    >{{ old('description', $board->description) }}</x-textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    <div class="mt-4 flex gap-3">
                                        <button type="button" @click="editing = false; if(window.tinymce && tinymce.get('description')) tinymce.get('description').remove();" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">{{ __('Cancel') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-blue-500 dark:text-blue-400" />
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('Categories') }}</h2>
                            </div>

                            <div id="categories-list" class="space-y-3">
                                @if($board->categories->count() > 0)
                                    @foreach($board->categories as $category)
                                        <div class="flex items-center gap-2" data-category-id="{{ $category->id }}">
                                            <input type="hidden" name="category_ids[]" value="{{ $category->id }}" />
                                            <input type="text" name="categories[]" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Category name" value="{{ $category->name }}" />
                                            <button type="button" class="remove-category rounded-full p-2 text-red-400 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition" title="Remove" style="{{ $board->categories->count() > 1 ? '' : 'display:none' }}">
                                                <x-heroicon-o-x-mark class="w-5 h-5" />
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex items-center gap-2">
                                        <input type="hidden" name="category_ids[]" value="" />
                                        <input type="text" name="categories[]" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Category name" />
                                        <button type="button" class="remove-category rounded-full p-2 text-red-400 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition" title="Remove" style="display:none">
                                            <x-heroicon-o-x-mark class="w-5 h-5" />
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <button type="button" id="add-category" class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-lg mt-4 hover:bg-blue-600 transition-colors">
                                <x-heroicon-o-plus class="w-5 h-5" />
                                {{ __('Add Category') }}
                            </button>
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button class="flex items-center gap-2 px-6 py-3 text-base">
                                <x-heroicon-o-check class="w-5 h-5" />
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6 mt-8">
                        <div class="flex items-center gap-3 mb-4">
                            <x-heroicon-o-exclamation-triangle class="w-7 h-7 text-red-500" />
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('Danger Zone') }}</h2>
                        </div>

                        <div x-data class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('Delete this board') }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Once deleted, this board and all its data will be permanently removed.') }}</p>
                            </div>
                            <button
                                type="button"
                                @click="window.dispatchEvent(new CustomEvent('delete-board', { detail: { boardId: {{ $board->id }} } }))"
                                class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 font-medium shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                            >
                                <x-heroicon-o-trash class="w-5 h-5" />
                                {{ __('Delete Board') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var addBtn = document.getElementById('add-category');
            var list = document.getElementById('categories-list');

            addBtn.addEventListener('click', function() {
                var inputs = list.querySelectorAll('input[name="categories[]"]');
                if (inputs.length > 0 && inputs[inputs.length - 1].value.trim() === '') {
                    inputs[inputs.length - 1].focus();
                    return;
                }

                var div = document.createElement('div');
                div.className = 'flex items-center gap-2';
                div.innerHTML = '<input type="hidden" name="category_ids[]" value="" />' +
                    '<input type="text" name="categories[]" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Category name" />' +
                    '<button type="button" class="remove-category rounded-full p-2 text-red-400 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition" title="Remove"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>';
                list.appendChild(div);
                updateRemoveButtons();
            });

            list.addEventListener('click', function(e) {
                var btn = e.target.closest('.remove-category');
                if (btn) {
                    btn.parentElement.remove();
                    updateRemoveButtons();
                }
            });

            function updateRemoveButtons() {
                var btns = list.querySelectorAll('.remove-category');
                btns.forEach(function(btn, idx) {
                    btn.style.display = (list.children.length > 1) ? '' : 'none';
                });
            }
        });
    </script>
</x-app-layout>

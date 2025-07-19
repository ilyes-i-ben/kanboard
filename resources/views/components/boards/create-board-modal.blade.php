<!-- Create Board Modal -->
<div
    x-show="showCreateModal"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/40 dark:bg-black/40"
    @click.self="showCreateModal = false"
>
    <div
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 max-w-2xl w-full max-h-[90vh] overflow-y-auto"
    >
        <div class="p-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Create New Board') }}</h2>
                <p class="text-gray-700 dark:text-gray-300">{{ __('Start organizing your next project') }}</p>
            </div>

            <form method="POST" action="{{ route('boards.store') }}" class="space-y-6">
                @csrf
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('Board Title') }}</label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            class="w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-700 focus:border-blue-400 dark:focus:border-blue-700"
                            placeholder="{{ __('Enter board title...') }}"
                            value="{{ old('title') ?? '' }}"
                            required
                        />
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="background_color" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('Background Color') }}</label>
                        <div class="flex items-center space-x-4">
                            <input
                                id="background_color"
                                name="background_color"
                                type="color"
                                class="w-16 h-12 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer bg-transparent"
                                value="{{ old('background_color') ?? '#4C008A' }}"
                            >
                            <span class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Choose your board\'s theme color') }}</span>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('Description') }}</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-700 focus:border-blue-400 dark:focus:border-blue-700 resize-none"
                            placeholder="{{ __('Describe your board...') }}"
                        >{{ old('description') ?? '' }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-300">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-3">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 rounded bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <x-heroicon-o-tag class="w-5 h-5 text-gray-900 dark:text-white" />
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Categories') }}</h3>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('(Optional)') }}</span>
                    </div>

                    <div id="categories-list" class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <input
                                type="text"
                                name="categories[]"
                                class="flex-1 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg px-4 py-2 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-700 focus:border-blue-400 dark:focus:border-blue-700"
                                placeholder="{{ __('Category name...') }}"
                            />
                            <button
                                type="button"
                                class="remove-category p-2 rounded-lg bg-red-100 text-red-600 dark:text-red-300 hover:bg-red-200 transition-colors opacity-0"
                                title="{{ __('Remove') }}"
                            >
                                <x-heroicon-o-x-mark class="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <button
                        type="button"
                        id="add-category"
                        class="mt-4 flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 rounded-lg px-4 py-2 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                    >
                        <x-heroicon-o-plus class="w-5 h-5" />
                        <span>{{ __('Add Category') }}</span>
                    </button>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button
                        type="button"
                        @click="showCreateModal = false"
                        class="px-6 py-3 bg-gray-100 dark:bg-gray-700 rounded-lg text-gray-600 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                    >
                        {{ __('Cancel') }}
                    </button>
                    <button
                        type="submit"
                        class="px-8 py-3 bg-blue-100 dark:bg-blue-900 rounded-lg text-blue-700 dark:text-white font-semibold hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors"
                    >
                        {{ __('Create Board') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

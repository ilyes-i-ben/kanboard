<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <a href="{{ route('boards.show', $board) }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition">
                            <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                            Back to board
                        </a>
                    </div>

                    <div class="mb-8 flex items-center justify-between">
                        <div class="flex items-center">
                            <x-heroicon-o-cog-6-tooth class="w-7 h-7 mr-3 text-blue-500 dark:text-blue-400" />
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Edit Board') }}</h1>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('boards.update', $board) }}" class="space-y-8"
                        x-data="{ editingDescription: false }">
                        @csrf
                        @method('PUT')
                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Title')" class="text-lg text-center mx-auto" />
                            <x-text-input
                                id="title"
                                name="title"
                                type="text"
                                class="mt-2 block w-full text-center text-xl"
                                placeholder="{{ __('Board Title') }}"
                                value="{{ old('title', $board->title) }}"
                                required
                            />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div class="mb-6 flex flex-col items-center">
                            <x-input-label for="background_color" :value="__('Background Color')" class="mb-2" />
                            <input
                                id="background_color"
                                name="background_color"
                                type="color"
                                class="p-1 h-12 w-24 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 shadow"
                                value="{{ old('background_color', $board->background_color ?? '#2563eb') }}"
                            >
                        </div>
                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Description')" />
                            <div x-data="{ editing: false, get content() { if (window.tinymce && tinymce.get('description')) { return tinymce.get('description').getContent(); } return $refs.textarea ? $refs.textarea.value : ''; } }">
                                <div x-show="!editing" class="prose dark:prose-invert bg-gray-50 dark:bg-gray-700 rounded p-4 min-h-[120px] mb-2 custom-prose-preview">
                                    {!! old('description', $board->description) !!}
                                </div>
                                <button type="button" x-show="!editing" @click="editing = true; $nextTick(() => { if(window.tinymce) tinymce.init({ selector: '#description', menubar: false, plugins: 'link lists code', toolbar: 'undo redo | bold italic underline | bullist numlist | link | code' }); })" class="mb-4 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Change Description</button>
                                <div x-show="editing" x-cloak>
                                    <x-textarea
                                        id="description"
                                        name="description"
                                        class="tinyMce mt-2 w-full min-h-[180px] text-base"
                                        x-ref="textarea"
                                    >{{ old('description', $board->description) }}</x-textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    <div class="mt-2">
                                        <button type="button" @click="editing = false; if(window.tinymce && tinymce.get('description')) tinymce.get('description').remove();" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-400 dark:hover:bg-gray-700">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-4 mt-8">
                            <x-primary-button class="ml-2">
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .custom-prose-preview h1 {
            font-size: 2.25rem;
            line-height: 2.5rem;
            font-weight: 700;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }
    </style>
</x-app-layout>

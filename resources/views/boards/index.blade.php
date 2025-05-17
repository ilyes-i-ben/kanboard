<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Boards') }}
        </h2>
    </x-slot>
    <div x-data>
        <div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-gray-100 text-xl font-bold">
                {{ __("Owned boards") }}
            </div>
        </div>
        {{--TODO:: move to component--}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($ownedBoards as $board)
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-2 border-black dark:border-gray-200"
                        style="background-color: {{ $board->background_color }}"
                    >
                        <a href="{{ route('boards.index', ['id' => $board->id]) }}" class="block p-6">
                            <h3 class="text-lg font-semibold text-black dark:text-white">
                                {{ $board->title }}
                            </h3>
                            <p
                                class="mt-2 text-sm text-gray dark:text-gray-100"
                                style="background-color: {{ $board->background_color }}; opacity: 0.85;"
                            >
                                {{ Str::limit($board->title, 100) }}
                            </p>
                        </a>
                    </div>
                @endforeach
                <div
                    @click="$dispatch('open-modal', 'create-board')"
                    class="flex items-center justify-center bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-2 border-black dark:border-gray-200 cursor-pointer">
                    <x-heroicon-s-squares-plus class="w-12 text-gray-800 dark:text-gray-200"/>
                </div>
            </div>
        </div>

        <div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-gray-100 text-xl font-bold">
                {{ __("Also member in") }}
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($boards as $board)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <a href="{{ route('boards.index', ['id' => $board->id]) }}" class="block p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                {{ $board->name }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ Str::limit($board->title, 100) }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Creation Modal --}}
        <x-modal name="create-board" size="3xl">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Create a new board') }}</h2>
            <form method="POST" action="{{ route('boards.store') }}" class="p-4">
                @csrf
                <div
                    class="space-y-4"
                    x-data="{
                        priority: '{{ old('priority') ?? 'medium' }}',
                        get priorityTranslated() {
                            const translations = {
                                high: @js(__('High')),
                                medium: @js(__('Medium')),
                                low: @js(__('Low'))
                            };
                            return translations[this.priority] || this.priority;
                        }
                    }"
                >
                    <x-input-label for="title" :errorName="'title'" :value="__('Title')"/>
                    <x-text-input
                        id="title"
                        name="title"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="{{ __('ex: Board Title') }}"
                        value="{{ old('title') ?? '' }}"
                        required
                    />
                    <x-input-label for="priority" :errorName="'priority'" :value="__('Priority')" />
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button type="button" class="inline-flex w-full justify-between items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <span x-text="priorityTranslated"></span>
                                <x-heroicon-m-chevron-down class="w-6 h-6" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="#" @click.prevent="priority = 'high'; $dispatch('close')">
                                {{ __('High') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="priority = 'medium'; $dispatch('close')">
                                {{ __('Medium') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="priority = 'low'; $dispatch('close')">
                                {{ __('Low') }}
                            </x-dropdown-link>
                            <input type="hidden" name="priority" x-bind:value="priority">
                        </x-slot>
                    </x-dropdown>
                    <x-input-label for="background_color" :errorName="'background_color'" :value="__('Board background color')" />
                    <input
                        id="background_color"
                        name="background_color"
                        type="color"
                        class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700"
                        value="{{ old('background_color') ?? '#2563eb' }}"
                    >
                    <x-input-label for="description" :errorName="'description'" :value="__('Description')" />
                    <x-textarea
                        id="description"
                        name="description"
                        class="tinyMce"
                    >{{ old('description') ?? '' }}</x-textarea>
                </div>
                <div class="mt-4 flex justify-end gap-4">
                    <x-secondary-button @click="$dispatch('close-modal', 'create-board')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-primary-button class="ml-2">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>

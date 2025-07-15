<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Boards') }}
        </h2>
    </x-slot>
    <div
        x-data
        x-init="() => {
        @if($errors->any())
            $nextTick(() => {
                $dispatch('open-modal', 'create-board-modal');
            });
        @endif
        }"
    >
        {{--TODO:: move to component--}}
        @if($createdBoards?->count())
            <div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="text-gray-900 dark:text-gray-100 text-xl font-bold">
                    {{ __("Owned boards") }}
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($createdBoards as $board)
                        <div
                            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-2 border-black dark:border-gray-200"
                            style="
                                background:
                                    linear-gradient(135deg, {{ $board->background_color }} 0%, {{ $board->background_color }}CC 100%),
                                    repeating-linear-gradient(45deg, rgba(255,255,255,0.1) 0, rgba(255,255,255,0.1) 4px, transparent 4px, transparent 8px);
                                background-blend-mode: overlay;
                            "
                        >
                            <a href="{{ route('boards.show', $board->id) }}" class="block p-6">
                                <h3 class="text-lg font-semibold text-black dark:text-white">
                                    {{ $board->title }}
                                </h3>
                                <p
                                    class="mt-2 text-sm text-gray dark:text-gray-100"
                                >
                                    {{ Str::limit($board->title, 100) }}
                                </p>
                            </a>
                        </div>
                    @endforeach
                    <div
                        @click="$dispatch('open-modal', 'create-board-modal')"
                        class="flex items-center justify-center bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-2 border-black dark:border-gray-200 cursor-pointer">
                        <x-heroicon-s-squares-plus class="w-12 text-gray-800 dark:text-gray-200"/>
                    </div>
                </div>
            </div>
        @endif
        <div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-gray-100 text-xl font-bold">
                {{ __("Vous êtes invité à :") }}
            </div>
            @if(isset($invitations) && $invitations->count())
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($invitations as $invitation)
                        <div
                            @click="$dispatch('open-modal', 'invitation-modal-{{ $invitation->id }}')"
                            class="cursor-pointer bg-blue-50 dark:bg-blue-900 border border-blue-300 dark:border-blue-700 rounded-lg p-4 shadow hover:shadow-md transition"
                        >
                            <div class="font-semibold text-blue-800 dark:text-blue-200">
                                {{ $invitation->board->title ?? 'Board' }}
                            </div>
                            <div class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                Invité par : {{ $invitation->inviter->name }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $invitation->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <x-modal name="invitation-modal-{{ $invitation->id }}" maxWidth="md">
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                                    {{ __('Invitation à rejoindre le board :') }} <span class="font-bold">{{ $invitation->board->title ?? '' }}</span>
                                </h2>
                                <p class="mb-4 text-gray-700 dark:text-gray-300">
                                    {{ __('Invité par :') }} {{ $invitation->inviter->name }}
                                </p>
                                <div class="flex justify-end gap-3">
                                    <form method="POST" action="{{ route('boards.invitations.accept', $invitation) }}">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">{{ __('Accepter') }}</button>
                                    </form>
                                    <form method="POST" action="{{ route('boards.invitations.decline', $invitation) }}">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">{{ __('Refuser') }}</button>
                                    </form>
                                    <button type="button" @click="$dispatch('close-modal', 'invitation-modal-{{ $invitation->id }}')" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md">{{ __('Fermer') }}</button>
                                </div>
                            </div>
                        </x-modal>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500 dark:text-gray-400 mt-2">{{ __('Aucune invitation en attente.') }}</div>
            @endif
        </div>
        @if($boards?->count())
            <div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="text-gray-900 dark:text-gray-100 text-xl font-bold">
                    {{ __("Also member in") }}
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($boards as $board)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <a href="{{ route('boards.show', $board->id) }}" class="block p-6">
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
        @endif
        {{-- Creation Modal --}}
        <x-modal name="create-board-modal" size="3xl">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Create a new board') }}</h2>
            <form method="POST" action="{{ route('boards.store') }}" class="p-4">
                @csrf
                <div
                    class="space-y-4"
                    x-data
                >
                    <x-input-label for="title" :value="__('Title')"/>
                    <x-text-input
                        id="title"
                        name="title"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="{{ __('ex: Board Title') }}"
                        value="{{ old('title') ?? '' }}"
                        required
                    />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    <x-input-label for="background_color" :value="__('Board background color')" />
                    <input
                        id="background_color"
                        name="background_color"
                        type="color"
                        class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700"
                        value="{{ old('background_color') ?? '#2563eb' }}"
                    >
                    <x-input-label for="description" :value="__('Description')" />
                    <x-textarea
                        id="description"
                        name="description"
                        class="tinyMce"
                    >{{ old('description') ?? '' }}</x-textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    <div id="categories-section" class="mt-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-blue-500 dark:text-blue-400" />
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Categories (optional)</h3>
                            </div>
                            <div id="categories-list">
                                <div class="flex items-center gap-2 mb-2">
                                    <input type="text" name="categories[]" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Category name" />
                                    <button type="button" class="remove-category rounded-full p-2 text-red-400 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition" style="display:none" title="Remove">
                                        <x-heroicon-o-x-mark class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-category" class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-md mt-2 hover:bg-blue-600 transition">
                                <x-heroicon-o-plus class="w-5 h-5" />
                                Add Category
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-4">
                    <x-secondary-button @click="$dispatch('close-modal', 'create-board-modal')">
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

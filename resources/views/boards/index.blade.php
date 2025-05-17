<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Boards') }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-gray-900 dark:text-gray-100 text-xl font-bold">
            {{ __("Owned boards") }}
        </div>
    </div>
    {{--TODO:: move to component--}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($ownedBoards as $board)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <a href="{{ route('board.index', ['id' => $board->id]) }}" class="block p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            {{ $board->title }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ Str::limit($board->title, 100) }}
                        </p>
                    </a>
                </div>
            @endforeach
            <a href="{{ route('board.index') }}" class="bg-white dark:bg-gray-800 flex items-center justify-center overflow-hidden shadow-sm sm:rounded-lg">
                <div class="">
                        <x-heroicon-s-squares-plus class="w-12 text-gray-800 dark:text-gray-200"/>
                </div>
            </a>
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
                    <a href="{{ route('board.index', ['id' => $board->id]) }}" class="block p-6">
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

</x-app-layout>

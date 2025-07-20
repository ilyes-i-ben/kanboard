<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center space-x-2" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <div>
                        <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200">
                            <x-heroicon-o-home class="flex-shrink-0 h-5 w-5" />
                            <span class="sr-only">Home</span>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="flex-shrink-0 h-5 w-5" />
                        <a href="{{ route('boards.index') }}" class="ml-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm font-medium transition-colors duration-200">
                            Boards
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-o-chevron-right class="flex-shrink-0 h-5 w-5" />
                        <span id="board-title-{{ $board->id }}" class="ml-2 text-gray-800 dark:text-gray-200 text-lg font-semibold" aria-current="page">
                            {{ $board->title }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <x-board :board="$board" :view-type="$view" />
    <div id="card-modal-container"></div>
    <style>
        /* Custom styles for the drag and drop interface */
        .sortable-ghost {
            opacity: 0.5 !important;
            background-color: #e2e8f0 !important;
        }
        .dark .sortable-ghost {
            background-color: #334155 !important;
        }
        body.sorting {
            cursor: grabbing !important;
        }

        /* Improve scrolling behavior during drag */
        .lists-container {
            scroll-behavior: smooth;
            scrollbar-width: thin;
        }
    </style>
</x-app-layout>

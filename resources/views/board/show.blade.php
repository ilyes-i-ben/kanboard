<x-app-layout>
    <x-slot name="header">
        <h2 id="board-title-{{ $board->id }}" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $board->title }}
        </h2>
    </x-slot>

    <x-board :board="$board" />

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

@props(['member', 'board'])

@php
    $isCreator = $member->id === $board->created_by;
@endphp

<div class="bg-gray-50 dark:bg-gray-700 rounded-xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100 dark:border-gray-600">
    <div class="p-5">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <x-user.avatar :user="$member" size="md" />
            </div>
            <div class="ml-4">
                <div class="font-medium text-lg text-gray-900 dark:text-gray-100 flex items-center">
                    {{ $member->name }}
                    @if($isCreator)
                        <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                            Creator
                        </span>
                    @endif
                </div>
                <div class="flex items-center mt-1 text-xs text-gray-500 dark:text-gray-400">
                    <x-heroicon-o-envelope class="w-4 h-4 mr-1" />
                    {{ $member->email }}
                </div>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-600 flex justify-between items-center">
            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                <x-heroicon-o-calendar class="w-4 h-4 mr-1" />
                Joined {{ $member->pivot->created_at->format('M d, Y') }}
            </div>

            @if(auth()->id() == $board->created_by && !$isCreator)
                <form
                    method="POST"
                    action="{{ route('boards.members.remove', ['board' => $board, 'user' => $member]) }}"
                    class="inline-block"
                    x-data="{ open: false }"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 flex items-center transition"
                        onclick="return confirm('sure ?');"
                    >
                        <x-heroicon-o-trash class="w-4 h-4 mr-1" />
                        Remove
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@props(['member', 'isCreator' => false])

<div class="flex items-center justify-between py-3 border-b last:border-b-0">
    <div class="flex items-center">
        <x-user.avatar :user="$member" size="10" />

        <div class="ml-3">
            <div class="font-medium text-gray-900">{{ $member->name }}</div>
            <div class="text-sm text-gray-500">{{ $member->email }}</div>
        </div>

        @if($isCreator)
            <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                Creator
            </span>
        @endif
    </div>

    <div class="flex items-center">
        @if(auth()->id() == $board->created_by && !$isCreator)
            <div class="relative mr-3" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="text-gray-500 hover:text-gray-700"
                >
                    <span>{{ $member->pivot->role ?? 'Member' }}</span>
                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    class="absolute right-0 mt-1 w-36 bg-white border rounded-md shadow-lg z-20"
                    style="display: none;"
                >
                    <div class="py-1">
                        <button
                            @click="$parent.updateRole({{ $member->id }}, 'Admin'); open = false"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Admin
                        </button>
                        <button
                            @click="$parent.updateRole({{ $member->id }}, 'Member'); open = false"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Member
                        </button>
                        <button
                            @click="$parent.updateRole({{ $member->id }}, 'Viewer'); open = false"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Viewer
                        </button>
                    </div>
                </div>
            </div>

            <button
                @click="$parent.removeMember({{ $member->id }})"
                class="text-red-500 hover:text-red-600"
                title="Remove member"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        @endif
    </div>
</div>

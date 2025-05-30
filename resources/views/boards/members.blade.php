<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Back to board button -->
                    <div class="mb-6">
                        <a href="{{ route('boards.show', $board) }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition">
                            <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                            Back to board
                        </a>
                    </div>

                    <div class="mb-8 flex items-center justify-between">
                        <div class="flex items-center">
                            <x-heroicon-o-users class="w-7 h-7 mr-3 text-blue-500 dark:text-blue-400" />
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Board Members</h1>
                        </div>

                        @if(auth()->id() == $board->created_by)
                            <button
                                x-data="{}"
                                @click="$dispatch('open-modal', 'add-member-modal')"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition flex items-center shadow-sm"
                            >
                                <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                                Add Member
                            </button>
                        @endif
                    </div>

                    <!-- Members grid -->
                    @if(!$board->members->isEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                            @foreach($board->members as $member)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100 dark:border-gray-600">
                                    <div class="p-5">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <x-user.avatar :user="$member" size="md" />
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-lg text-gray-900 dark:text-gray-100 flex items-center">
                                                    {{ $member->name }}
                                                    @if($member->id === $board->created_by)
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

                                            @if(auth()->id() == $board->created_by && $member->id !== $board->created_by)
                                                <form method="POST" action="{{ route('boards.members.remove', ['board' => $board->id, 'user' => $member->id]) }}" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 flex items-center transition"
                                                        onclick="return confirm('Are you sure you want to remove this member?');"
                                                    >
                                                        <x-heroicon-o-trash class="w-4 h-4 mr-1" />
                                                        Remove
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Empty state -->
                    @if($board->members->isEmpty())
                        <div class="text-center py-16 bg-gray-50 dark:bg-gray-700 rounded-xl border border-dashed border-gray-200 dark:border-gray-600">
                            <x-heroicon-o-users class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" />
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">No board members</h3>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">Get started by adding a member to this board.</p>

                            @if(auth()->id() == $board->created_by)
                                <button
                                    x-data="{}"
                                    @click="$dispatch('open-modal', 'add-member-modal')"
                                    class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md transition flex items-center shadow-sm mx-auto"
                                >
                                    <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                                    Add Your First Member
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
{{-- modal to invite members to board.. --}}
    <x-modal name="add-member-modal" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                    <x-heroicon-o-user-plus class="w-6 h-6 mr-2 text-blue-500" />
                    Add Board Member
                </h2>
                <button @click="$dispatch('close-modal', 'add-member-modal')" class="text-gray-400 hover:text-gray-500">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>

            <form method="POST" action="{{ route('boards.members.add', $board) }}">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-envelope class="h-5 w-5 text-gray-400" />
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            class="w-full border dark:border-gray-700 rounded-md pl-10 px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="{{ __('Enter email address') }}"
                        >
                    </div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">The user will receive an invitation to join this board.</p>
                </div>

                <div class="flex justify-end gap-3">
                    <button
                        type="button"
                        @click="$dispatch('close-modal', 'add-member-modal')"
                        class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
                    >
                        <span class="flex items-center">
                            <x-heroicon-o-paper-airplane class="mr-2 h-5 w-5" />
                            Send Invitation
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>

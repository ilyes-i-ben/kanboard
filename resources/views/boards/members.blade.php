<x-app-layout>
    <div
        x-data
        x-init="() => {
        @if(session('invitation_sent') || $errors->any())
            $nextTick(() => {
                $dispatch('open-modal', 'add-member-modal');
            });
        @endif
        }"
        class="py-12"
    >
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

                    @if(!$board->members->isEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                            @foreach($board->members as $member)
                                <x-user.member-item :member="$member" :board="$board"/>
                            @endforeach
                        </div>
                    @endif

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
    <x-modal
        name="add-member-modal"
        maxWidth="md"
    >
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

            @if(session('invitation_sent'))
                <div class="mb-4 p-4 rounded-md bg-green-100 border border-green-300 text-green-800 flex items-center">
                    <x-heroicon-o-check-circle class="h-5 w-5 mr-2 text-green-600" />
                    <span>{{ session('invitation_sent') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-4 rounded-md bg-red-100 border border-red-300 text-red-800 flex items-center">
                    <x-heroicon-o-exclamation-circle class="h-5 w-5 mr-2 text-red-600 mt-1" />
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('boards.invitations.store', $board) }}">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Email Address
                    </label>

                    @php $hasSuccess = session('invitation_sent'); @endphp

                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-envelope class="h-5 w-5 text-gray-400" />
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            value="{{ old('email') }}"
                            class="w-full rounded-md border px-3 py-2 pl-10 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100
                               focus:outline-none focus:ring-2 focus:ring-offset-2
                               {{ $hasSuccess ? 'border-green-400 focus:ring-green-500 focus:border-green-500' : 'border-gray-300 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500' }}"
                            placeholder="{{ __('Enter email address') }}"
                        >
                    </div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        The user will receive an invitation to join this board.
                    </p>
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

@props(['card'])

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('boards.show', $card->list->board) }}"
                   class="group flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200">
                    <x-heroicon-o-arrow-left class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-200" />
                    <span class="font-medium">Back to Board</span>
                </a>
                <div class="h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl shadow-lg">
                        <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $card->title }}</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Card #{{ $card->id }} • {{ $card->list->title }}</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @can('update', $card)
                    <button
                        id="edit-card-btn"
                        class="group flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105"
                    >
                        <x-heroicon-o-pencil-square class="w-4 h-4 group-hover:rotate-12 transition-transform duration-200" />
                        <span class="font-medium">Edit</span>
                    </button>
                @endcan
                @can('delete', $card)
                    <button
                        id="delete-card-btn"
                        class="group flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105"
                    >
                        <x-heroicon-o-trash class="w-4 h-4 group-hover:rotate-12 transition-transform duration-200" />
                        <span class="font-medium">Delete</span>
                    </button>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-purple-900/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Hero Section -->
            <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 mb-8">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-purple-500/5 dark:from-blue-400/5 dark:to-purple-400/5"></div>
                <div class="relative p-8">
                    <div class="grid lg:grid-cols-3 gap-8">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Card Status & Priority -->
                            <div class="flex items-center gap-4 flex-wrap">
                                <div class="flex items-center gap-2 px-4 py-2 rounded-full {{ $card->finished_at ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                    @if($card->finished_at)
                                        <x-heroicon-o-check-circle class="w-5 h-5" />
                                        <span class="font-semibold">Completed</span>
                                    @else
                                        <x-heroicon-o-clock class="w-5 h-5" />
                                        <span class="font-semibold">In Progress</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 px-4 py-2 rounded-full {{ $card->priority === 'high' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : ($card->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300') }}">
                                    <x-heroicon-o-flag class="w-5 h-5" />
                                    <span class="font-semibold">{{ ucfirst($card->priority) }} Priority</span>
                                </div>
                                @if($card->category)
                                    <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                        <x-heroicon-o-tag class="w-5 h-5" />
                                        <span class="font-semibold">{{ $card->category->name }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Description -->
                            @if($card->description)
                                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                                        <x-heroicon-o-document-text class="w-5 h-5 text-blue-500" />
                                        Description
                                    </h3>
                                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                                        {!! nl2br(e($card->description)) !!}
                                    </div>
                                </div>
                            @endif

                            <!-- Timeline -->
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <x-heroicon-o-calendar class="w-5 h-5 text-blue-500" />
                                    Timeline
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 w-3 h-3 bg-blue-500 rounded-full"></div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Card created</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $card->created_at->format('M d, Y \a\t H:i') }}</p>
                                        </div>
                                    </div>
                                    @if($card->deadline)
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 w-3 h-3 {{ \Carbon\Carbon::parse($card->deadline)->isPast() && !$card->finished_at ? 'bg-red-500' : 'bg-yellow-500' }} rounded-full"></div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Deadline</p>
                                                <p class="text-xs {{ \Carbon\Carbon::parse($card->deadline)->isPast() && !$card->finished_at ? 'text-red-600 dark:text-red-400' : 'text-gray-500 dark:text-gray-400' }}">
                                                    {{ \Carbon\Carbon::parse($card->deadline)->format('M d, Y') }}
                                                    @if(\Carbon\Carbon::parse($card->deadline)->isPast() && !$card->finished_at)
                                                        (Overdue)
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($card->finished_at)
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 w-3 h-3 bg-green-500 rounded-full"></div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Completed</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($card->finished_at)->format('M d, Y \a\t H:i') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-6">
                            <!-- Card Creator -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <x-heroicon-o-user class="w-5 h-5 text-blue-500" />
                                    Created by
                                </h3>
                                <div class="flex items-center gap-3">
                                    <x-user.avatar :user="$card->user" class="w-12 h-12" />
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $card->user->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $card->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Assignees -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <x-heroicon-o-users class="w-5 h-5 text-blue-500" />
                                    Assignees
                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">({{ $card->members->count() }})</span>
                                </h3>
                                <div class="space-y-3">
                                    @forelse($card->members as $member)
                                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors">
                                            <x-user.avatar :user="$member" class="w-10 h-10" />
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $member->name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $member->email }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8">
                                            <x-heroicon-o-user-plus class="w-12 h-12 text-gray-400 mx-auto mb-3" />
                                            <p class="text-gray-500 dark:text-gray-400">No assignees yet</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <x-heroicon-o-bolt class="w-5 h-5 text-blue-500" />
                                    Quick Actions
                                </h3>
                                <div class="space-y-3">
                                    @if(!$card->finished_at)
                                        <button
                                            id="mark-complete-btn"
                                            class="w-full flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors"
                                        >
                                            <x-heroicon-o-check-circle class="w-5 h-5" />
                                            <span class="font-medium">Mark as Complete</span>
                                        </button>
                                    @else
                                        <button
                                            id="mark-incomplete-btn"
                                            class="w-full flex items-center gap-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 rounded-xl hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition-colors"
                                        >
                                            <x-heroicon-o-exclamation-circle class="w-5 h-5" />
                                            <span class="font-medium">Mark as Incomplete</span>
                                        </button>
                                    @endif

                                    <button
                                        id="share-card-btn"
                                        class="w-full flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors"
                                    >
                                        <x-heroicon-o-share class="w-5 h-5" />
                                        <span class="font-medium">Share Card</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <x-heroicon-o-calendar class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Created</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $card->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                            <x-heroicon-o-users class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Assignees</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $card->members->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                            <x-heroicon-o-clock class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $card->finished_at ? 'Complete' : 'Active' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl">
                            <x-heroicon-o-flag class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Priority</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst($card->priority) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <div class="flex items-center gap-3">
                    <x-heroicon-o-pencil-square class="w-7 h-7 text-blue-500 dark:text-blue-400"/>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Card</h2>
                </div>
                <button id="close-edit-modal" class="rounded-full p-2 text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                    <x-heroicon-o-x-mark class="w-6 h-6"/>
                </button>
            </div>
            <form id="edit-form" action="{{ route('cards.update.post', $card) }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="board_id" value="{{ $card->list->board->id }}">

                <section>
                    <label for="edit-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                    <input type="text" name="title" id="edit-title" value="{{ $card->title }}" required class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </section>

                <section>
                    <label for="edit-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" id="edit-description" rows="3" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $card->description }}</textarea>
                </section>

                <div class="grid grid-cols-2 gap-4">
                    <section>
                        <label for="edit-category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select name="category_id" id="edit-category" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a category</option>
                            @foreach($card->list->board->categories as $category)
                                <option value="{{ $category->id }}" {{ $card->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </section>

                    <section>
                        <label for="edit-priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                        <select name="priority" id="edit-priority" required class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="low" {{ $card->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $card->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $card->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </section>
                </div>

                <section>
                    <label for="edit-deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deadline</label>
                    <input type="date" name="deadline" id="edit-deadline" value="{{ $card->deadline ? \Carbon\Carbon::parse($card->deadline)->format('Y-m-d') : '' }}" class="w-full rounded-md border px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </section>

                <section>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assignees</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($card->list->board->members as $member)
                            <label class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 rounded-full px-3 py-1 shadow-sm cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900 transition">
                                <input type="checkbox" name="assignees[]" value="{{ $member->id }}" {{ $card->members->contains($member->id) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <x-user.avatar :user="$member" />
                                <span class="text-sm text-gray-800 dark:text-gray-200 font-medium">{{ $member->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </section>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" id="cancel-edit" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">Update Card</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Edit modal functionality
        document.getElementById('edit-card-btn')?.addEventListener('click', function() {
            document.getElementById('edit-modal').classList.remove('hidden');
        });

        document.getElementById('close-edit-modal')?.addEventListener('click', function() {
            document.getElementById('edit-modal').classList.add('hidden');
        });

        document.getElementById('cancel-edit')?.addEventListener('click', function() {
            document.getElementById('edit-modal').classList.add('hidden');
        });

        // Close modal on outside click
        document.getElementById('edit-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        // Quick actions
        document.getElementById('mark-complete-btn')?.addEventListener('click', function() {
            // Implementation for marking as complete
            console.log('Mark as complete');
        });

        document.getElementById('mark-incomplete-btn')?.addEventListener('click', function() {
            // Implementation for marking as incomplete
            console.log('Mark as incomplete');
        });

        document.getElementById('share-card-btn')?.addEventListener('click', function() {
            // Copy current URL to clipboard
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Card URL copied to clipboard!');
            });
        });

        document.getElementById('delete-card-btn')?.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this card?')) {
                // Implementation for deleting card
                console.log('Delete card');
            }
        });
    </script>

    <style>
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .prose {
            max-width: none;
        }

        .prose p {
            margin-bottom: 1em;
        }

        .prose p:last-child {
            margin-bottom: 0;
        }
    </style>
</x-app-layout>

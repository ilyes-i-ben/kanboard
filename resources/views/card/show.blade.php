@props(['card'])

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl shadow-lg">
                        <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $card->title }}</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Card <span class="text-xs text-gray-400 dark:text-gray-500">{{ $card->public_token ?? $card->id }}</span> • {{ $card->list->title }}
                        </p>
                    </div>
                </div>
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
                        <div class="lg:col-span-2 space-y-6">
                            <div class="flex items-center gap-4 flex-wrap">
                                <div class="flex items-center gap-2 px-4 py-2 rounded-full {{ $card->finished_at ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                    @if($card->finished_at)
                                        <x-heroicon-o-check-circle class="w-5 h-5" />
                                        <span class="font-semibold">Completed</span>
                                    @else
                                        <x-heroicon-o-clock class="w-5 h-5" />
                                        <span class="font-semibold">Pending</span>
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

                            @if($card->description)
                                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                                        <x-heroicon-o-document-text class="w-5 h-5 text-blue-500" />
                                        Description
                                    </h3>
                                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                                        {!! $card->description !!}
                                    </div>
                                </div>
                            @endif

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
                        </div>
                    </div>
                </div>
            </div>

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
</x-app-layout>

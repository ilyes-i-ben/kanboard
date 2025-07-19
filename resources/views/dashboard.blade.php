<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <div class="flex items-center space-x-4">
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <label for="board_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Board:</label>
                    <select name="board_id" id="board_id" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 text-sm" onchange="this.form.submit()">
                        <option value="">All Boards</option>
                        @foreach($userBoards as $board)
                            <option value="{{ $board->id }}" {{ $selectedBoardId == $board->id ? 'selected' : '' }}>
                                {{ $board->title }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Overall Statistics -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        <x-heroicon-o-chart-bar-square class="w-6 h-6 inline mr-2 text-blue-500" />
                        Overall Statistics
                    </h3>

                    @if($userStats->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($userStats->take(10) as $stat)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            @php
                                                $user = (object)[
                                                    'id' => $stat->user_id,
                                                    'name' => $stat->user_name,
                                                    'email' => $stat->user_email
                                                ];
                                            @endphp
                                            <x-user.avatar :user="$user" />
                                            <div>
                                                <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $stat->user_name }}</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $stat->user_email }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stat->total_completed_cards }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">completed cards</div>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="inline-flex items-center">
                                            <x-heroicon-o-building-office class="w-4 h-4 mr-1" />
                                            {{ $stat->boards_participated }} boards
                                        </span>
                                        @if($stat->last_completion_date)
                                            <span class="ml-3 inline-flex items-center">
                                                <x-heroicon-o-clock class="w-4 h-4 mr-1" />
                                                {{ \Carbon\Carbon::parse($stat->last_completion_date)->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <x-heroicon-o-chart-bar-square class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No completed cards yet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start completing cards to see statistics here.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Completion by Board -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        <x-heroicon-o-squares-2x2 class="w-6 h-6 inline mr-2 text-purple-500" />
                        Card Completion by Board
                    </h3>

                    @if($cardStats->count() > 0)
                        <div class="space-y-4">
                            @foreach($cardStats->groupBy('board_id') as $boardId => $boardStats)
                                @php
                                    $board = $boardStats->first();
                                @endphp
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600"
                                         style="background: linear-gradient(135deg, {{ $board->board_background_color }} 0%, {{ $board->board_background_color }}CC 100%);">
                                        <h4 class="font-medium text-white">{{ $board->board_title }}</h4>
                                        <p class="text-sm text-white/80">{{ $boardStats->sum('completed_cards_count') }} total completed cards</p>
                                    </div>
                                    <div class="p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                            @foreach($boardStats->sortByDesc('completed_cards_count') as $stat)
                                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                                    <div class="flex items-center space-x-3">
                                                        @php
                                                            $user = (object)[
                                                                'id' => $stat->user_id,
                                                                'name' => $stat->user_name,
                                                                'email' => $stat->user_email
                                                            ];
                                                        @endphp
                                                        <x-user.avatar :user="$user" />
                                                        <div>
                                                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $stat->user_name }}</p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                Last: {{ \Carbon\Carbon::parse($stat->last_completion_date)->format('M d, Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ $stat->completed_cards_count }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">cards</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <x-heroicon-o-squares-2x2 class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No completed cards by board</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Complete cards in your boards to see statistics here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

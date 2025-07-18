<x-app-layout>
    <div class="min-h-screen relative overflow-hidden">
        <!-- Dynamic animated background -->
        <div class="fixed inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-indigo-900 dark:via-purple-900 dark:to-pink-900"></div>
            <div class="absolute top-10 left-10 w-72 h-72 rounded-full bg-blue-500/10 dark:bg-blue-500/20 blur-3xl animate-pulse"></div>
            <div class="absolute top-1/3 right-20 w-64 h-64 rounded-full bg-purple-500/10 dark:bg-purple-500/20 blur-3xl animate-pulse delay-1000"></div>
            <div class="absolute bottom-20 left-1/3 w-56 h-56 rounded-full bg-pink-500/10 dark:bg-pink-500/20 blur-3xl animate-pulse delay-2000"></div>
            <div class="absolute bottom-40 right-1/4 w-48 h-48 rounded-full bg-cyan-500/10 dark:bg-cyan-500/20 blur-3xl animate-pulse delay-3000"></div>
        </div>

        <!-- Header -->
        <div class="relative z-10 pt-8 pb-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 rounded-2xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-2xl border border-gray-900/10 dark:border-white/20">
                            <x-heroicon-o-squares-plus class="w-10 h-10 text-gray-900 dark:text-white" />
                        </div>
                    </div>
                    <h1 class="text-5xl font-black text-gray-900 dark:text-white drop-shadow-lg mb-4 tracking-tight">
                        {{ __('Your Boards') }}
                    </h1>
                    <p class="text-xl text-gray-700 dark:text-white/80 max-w-2xl mx-auto leading-relaxed">
                        Organize your projects with beautiful, powerful boards
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 pb-20">
            <!-- Alpine.js data -->
            <div
                x-data="boardsIndex()"
                x-init="() => {
                @if($errors->any())
                    $nextTick(() => {
                        showCreateModal = true;
                    });
                @endif
                }"
            >
                <!-- Owned Boards Section -->
                @if($createdBoards?->count())
                    <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg border border-gray-900/10 dark:border-white/20">
                                    <x-heroicon-o-star class="w-7 h-7 text-yellow-400" />
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white drop-shadow-lg">{{ __("Owned Boards") }}</h2>
                                    <p class="text-gray-600 dark:text-white/70">{{ $createdBoards->count() }} {{ $createdBoards->count() === 1 ? 'board' : 'boards' }}</p>
                                </div>
                            </div>
                            <button
                                @click="showCreateModal = true"
                                class="group flex items-center space-x-3 bg-gray-900/10 dark:bg-white/15 backdrop-blur-lg rounded-xl px-6 py-3 hover:bg-gray-900/20 dark:hover:bg-white/25 transition-all duration-300 shadow-xl border border-gray-900/10 dark:border-white/20"
                            >
                                <x-heroicon-o-plus class="w-5 h-5 text-gray-900 dark:text-white group-hover:rotate-90 transition-transform duration-300" />
                                <span class="text-gray-900 dark:text-white font-semibold">{{ __('New Board') }}</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($createdBoards as $board)
                                <div
                                    class="group board-card relative overflow-hidden rounded-2xl shadow-2xl border border-gray-300/50 dark:border-white/20 hover:shadow-3xl transition-all duration-500 cursor-pointer"
                                    style="
                                        background:
                                            radial-gradient(circle at 20% 20%, rgba(255,255,255,0.15) 0%, transparent 50%),
                                            radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                                            linear-gradient(135deg, {{ $board->background_color }} 0%, {{ $board->background_color }}E6 50%, {{ $board->background_color }}CC 100%);
                                        backdrop-filter: blur(10px);
                                    "
                                    onclick="window.location.href = '{{ route('boards.show', $board->id) }}'"
                                >
                                    <!-- Animated background elements -->
                                    <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity duration-300">
                                        <div class="absolute top-4 right-4 w-16 h-16 rounded-full bg-white/10 blur-xl animate-pulse"></div>
                                        <div class="absolute bottom-4 left-4 w-12 h-12 rounded-full bg-white/15 blur-lg animate-pulse delay-1000"></div>
                                    </div>

                                    <div class="relative p-6 h-48 flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                                                    <x-heroicon-o-rectangle-group class="w-6 h-6 text-white" />
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                                                    <span class="text-xs text-white/80">Active</span>
                                                </div>
                                            </div>
                                            <h3 id="board-title-{{ $board->id }}" class="text-xl font-bold text-white drop-shadow-lg mb-2 line-clamp-2 group-hover:text-white/90 transition-colors">
                                                {{ $board->title }}
                                            </h3>
                                        </div>

                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between text-white/80 text-sm">
                                                <div class="flex items-center space-x-2">
                                                    <x-heroicon-o-rectangle-group class="w-4 h-4" />
                                                    <span>{{ $board->lists->count() }} lists</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <x-heroicon-o-users class="w-4 h-4" />
                                                    <span>{{ $board->members->count() }} members</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-white/70">{{ $board->created_at->diffForHumans() }}</span>
                                                <div class="flex -space-x-2">
                                                    @foreach($board->members->take(3) as $member)
                                                        <div class="ring-2 ring-white/30 rounded-full transition-transform group-hover:scale-110">
                                                            <x-user.avatar :user="$member" class="w-6 h-6" />
                                                        </div>
                                                    @endforeach
                                                    @if($board->members->count() > 3)
                                                        <div class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-xs font-bold text-white ring-2 ring-white/30">
                                                            +{{ $board->members->count() - 3 }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hover overlay -->
                                    <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                                </div>
                            @endforeach

                            <!-- Create New Board Card -->
                            <div
                                @click="showCreateModal = true"
                                class="group board-card relative overflow-hidden rounded-2xl shadow-2xl border border-gray-300/50 dark:border-white/20 hover:shadow-3xl transition-all duration-500 cursor-pointer bg-gray-900/5 dark:bg-white/10 backdrop-blur-lg"
                            >
                                <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity duration-300">
                                    <div class="absolute top-4 right-4 w-16 h-16 rounded-full bg-gray-900/10 dark:bg-white/10 blur-xl animate-pulse"></div>
                                    <div class="absolute bottom-4 left-4 w-12 h-12 rounded-full bg-gray-900/15 dark:bg-white/15 blur-lg animate-pulse delay-1000"></div>
                                </div>

                                <div class="relative p-6 h-48 flex flex-col items-center justify-center text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <x-heroicon-o-plus class="w-8 h-8 text-gray-900 dark:text-white group-hover:rotate-90 transition-transform duration-300" />
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white drop-shadow-lg mb-2">{{ __('Create New Board') }}</h3>
                                    <p class="text-gray-600 dark:text-white/70 text-sm">{{ __('Start a new project') }}</p>
                                </div>

                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty State for Owned Boards -->
                    <div class="max-w-4xl mx-auto px-6 lg:px-8 mb-16">
                        <div class="text-center bg-gray-900/5 dark:bg-white/10 backdrop-blur-lg rounded-3xl p-12 shadow-2xl border border-gray-300/50 dark:border-white/20">
                            <div class="w-24 h-24 rounded-3xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto mb-6 shadow-lg">
                                <x-heroicon-o-squares-plus class="w-12 h-12 text-gray-900 dark:text-white" />
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white drop-shadow-lg mb-4">{{ __('Create Your First Board') }}</h3>
                            <p class="text-gray-700 dark:text-white/80 text-lg mb-8 max-w-2xl mx-auto">{{ __('Start organizing your projects with beautiful, powerful boards. Create your first board to get started.') }}</p>
                            <button
                                @click="showCreateModal = true"
                                class="group inline-flex items-center space-x-3 bg-gray-900/10 dark:bg-white/20 backdrop-blur-lg rounded-xl px-8 py-4 hover:bg-gray-900/20 dark:hover:bg-white/30 transition-all duration-300 shadow-xl border border-gray-300/50 dark:border-white/20"
                            >
                                <x-heroicon-o-plus class="w-6 h-6 text-gray-900 dark:text-white group-hover:rotate-90 transition-transform duration-300" />
                                <span class="text-gray-900 dark:text-white font-bold text-lg">{{ __('Create Board') }}</span>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Invitations Section -->
                @if(isset($invitations) && $invitations->count())
                    <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-12 h-12 rounded-xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg border border-gray-900/10 dark:border-white/20">
                                <x-heroicon-o-envelope class="w-7 h-7 text-blue-400" />
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white drop-shadow-lg">{{ __("Board Invitations") }}</h2>
                                <p class="text-gray-600 dark:text-white/70">{{ $invitations->count() }} pending {{ $invitations->count() === 1 ? 'invitation' : 'invitations' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($invitations as $invitation)
                                <div
                                    @click="openInvitationModal('{{ $invitation->id }}')"
                                    class="group invitation-card relative overflow-hidden rounded-2xl shadow-2xl border border-blue-300/50 dark:border-blue-300/30 hover:shadow-3xl transition-all duration-500 cursor-pointer bg-gradient-to-br from-blue-500/20 to-cyan-500/20 backdrop-blur-lg"
                                >
                                    <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity duration-300">
                                        <div class="absolute top-4 right-4 w-16 h-16 rounded-full bg-blue-400/20 blur-xl animate-pulse"></div>
                                        <div class="absolute bottom-4 left-4 w-12 h-12 rounded-full bg-cyan-400/20 blur-lg animate-pulse delay-1000"></div>
                                    </div>

                                    <div class="relative p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="w-10 h-10 rounded-xl bg-blue-400/30 backdrop-blur-sm flex items-center justify-center shadow-lg">
                                                <x-heroicon-o-envelope class="w-6 h-6 text-white" />
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <div class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                                                <span class="text-xs text-white/80">Pending</span>
                                            </div>
                                        </div>

                                        <h3 class="text-xl font-bold text-white drop-shadow-lg mb-2 line-clamp-1">
                                            {{ $invitation->board->title ?? 'Board' }}
                                        </h3>

                                        <div class="space-y-3">
                                            <div class="flex items-center space-x-2 text-white/80">
                                                <x-heroicon-o-user class="w-4 h-4" />
                                                <span class="text-sm">Invited by {{ $invitation->inviter->name }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-white/80">
                                                <x-heroicon-o-clock class="w-4 h-4" />
                                                <span class="text-sm">{{ $invitation->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex space-x-2">
                                            <button
                                                @click.stop="acceptInvitation('{{ $invitation->id }}')"
                                                class="flex-1 bg-green-500/30 backdrop-blur-sm rounded-lg px-3 py-2 text-white text-sm font-semibold hover:bg-green-500/40 transition-colors"
                                            >
                                                Accept
                                            </button>
                                            <button
                                                @click.stop="declineInvitation('{{ $invitation->id }}')"
                                                class="flex-1 bg-red-500/30 backdrop-blur-sm rounded-lg px-3 py-2 text-white text-sm font-semibold hover:bg-red-500/40 transition-colors"
                                            >
                                                Decline
                                            </button>
                                        </div>
                                    </div>

                                    <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                                </div>

                                <!-- Invitation Modal -->
                                <div
                                    x-show="activeInvitationModal === '{{ $invitation->id }}'"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/70 dark:bg-black/70 backdrop-blur-sm"
                                    @click.self="activeInvitationModal = null"
                                >
                                    <div
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="bg-white/95 dark:bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-gray-300/50 dark:border-white/20 max-w-md w-full"
                                    >
                                        <div class="text-center mb-6">
                                            <div class="w-16 h-16 rounded-2xl bg-blue-400/20 dark:bg-blue-400/30 backdrop-blur-sm flex items-center justify-center mx-auto mb-4 shadow-lg">
                                                <x-heroicon-o-envelope class="w-8 h-8 text-blue-600 dark:text-white" />
                                            </div>
                                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white drop-shadow-lg mb-2">
                                                {{ __('Board Invitation') }}
                                            </h2>
                                            <p class="text-gray-700 dark:text-white/80">{{ $invitation->board->title ?? '' }}</p>
                                        </div>

                                        <div class="bg-gray-100/80 dark:bg-white/10 backdrop-blur-sm rounded-2xl p-4 mb-6">
                                            <p class="text-gray-800 dark:text-white/90 text-center">
                                                <strong>{{ $invitation->inviter->name }}</strong> {{ __('invited you to collaborate') }}
                                            </p>
                                        </div>

                                        <div class="flex space-x-3">
                                            <form method="POST" action="{{ route('boards.invitations.accept', $invitation) }}" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full bg-green-500/20 dark:bg-green-500/30 backdrop-blur-sm rounded-xl px-4 py-3 text-green-700 dark:text-white font-semibold hover:bg-green-500/30 dark:hover:bg-green-500/40 transition-colors shadow-lg">
                                                    {{ __('Accept') }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('boards.invitations.decline', $invitation) }}" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full bg-red-500/20 dark:bg-red-500/30 backdrop-blur-sm rounded-xl px-4 py-3 text-red-700 dark:text-white font-semibold hover:bg-red-500/30 dark:hover:bg-red-500/40 transition-colors shadow-lg">
                                                    {{ __('Decline') }}
                                                </button>
                                            </form>
                                        </div>

                                        <button
                                            @click="activeInvitationModal = null"
                                            class="w-full mt-3 bg-gray-200/50 dark:bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 text-gray-600 dark:text-white/80 hover:text-gray-800 dark:hover:text-white transition-colors"
                                        >
                                            {{ __('Close') }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Member Boards Section -->
                @if($boards?->count())
                    <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-12 h-12 rounded-xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg border border-gray-900/10 dark:border-white/20">
                                <x-heroicon-o-user-group class="w-7 h-7 text-green-400" />
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white drop-shadow-lg">{{ __("Collaborative Boards") }}</h2>
                                <p class="text-gray-600 dark:text-white/70">{{ $boards->count() }} shared {{ $boards->count() === 1 ? 'board' : 'boards' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($boards as $board)
                                <div
                                    class="group board-card relative overflow-hidden rounded-2xl shadow-2xl border border-gray-300/50 dark:border-white/20 hover:shadow-3xl transition-all duration-500 cursor-pointer bg-gradient-to-br from-green-500/20 to-emerald-500/20 backdrop-blur-lg"
                                    onclick="window.location.href = '{{ route('boards.show', $board->id) }}'"
                                >
                                    <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity duration-300">
                                        <div class="absolute top-4 right-4 w-16 h-16 rounded-full bg-green-400/20 blur-xl animate-pulse"></div>
                                        <div class="absolute bottom-4 left-4 w-12 h-12 rounded-full bg-emerald-400/20 blur-lg animate-pulse delay-1000"></div>
                                    </div>

                                    <div class="relative p-6 h-48 flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="w-10 h-10 rounded-xl bg-green-400/30 backdrop-blur-sm flex items-center justify-center shadow-lg">
                                                    <x-heroicon-o-user-group class="w-6 h-6 text-white" />
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                                                    <span class="text-xs text-white/80">Member</span>
                                                </div>
                                            </div>
                                            <h3 class="text-xl font-bold text-white drop-shadow-lg mb-2 line-clamp-2 group-hover:text-white/90 transition-colors">
                                                {{ $board->title }}
                                            </h3>
                                        </div>

                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between text-white/80 text-sm">
                                                <div class="flex items-center space-x-2">
                                                    <x-heroicon-o-rectangle-group class="w-4 h-4" />
                                                    <span>{{ $board->lists->count() ?? 0 }} lists</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <x-heroicon-o-users class="w-4 h-4" />
                                                    <span>{{ $board->members->count() ?? 0 }} members</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-white/70">{{ $board->created_at->diffForHumans() }}</span>
                                                <div class="flex items-center space-x-1">
                                                    <x-heroicon-o-star class="w-4 h-4 text-yellow-400" />
                                                    <span class="text-xs text-white/70">Shared</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Create Board Modal -->
                <div
                    x-show="showCreateModal"
                    x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/70 dark:bg-black/70 backdrop-blur-sm"
                    @click.self="showCreateModal = false"
                >
                    <div
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="bg-white/95 dark:bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl border border-gray-300/50 dark:border-white/20 max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                    >
                        <div class="p-8">
                            <div class="text-center mb-8">
                                <div class="w-16 h-16 rounded-2xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto mb-4 shadow-lg">
                                    <x-heroicon-o-squares-plus class="w-8 h-8 text-gray-900 dark:text-white" />
                                </div>
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white drop-shadow-lg mb-2">{{ __('Create New Board') }}</h2>
                                <p class="text-gray-700 dark:text-white/80">{{ __('Start organizing your next project') }}</p>
                            </div>

                            <form method="POST" action="{{ route('boards.store') }}" class="space-y-6">
                                @csrf
                                <div class="bg-gray-100/80 dark:bg-white/10 backdrop-blur-sm rounded-2xl p-6 space-y-4">
                                    <div>
                                        <label for="title" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('Board Title') }}</label>
                                        <input
                                            id="title"
                                            name="title"
                                            type="text"
                                            class="w-full bg-white/90 dark:bg-white/10 backdrop-blur-sm border border-gray-300 dark:border-white/20 rounded-xl px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-white/30 focus:border-blue-400 dark:focus:border-white/40"
                                            placeholder="{{ __('Enter board title...') }}"
                                            value="{{ old('title') ?? '' }}"
                                            required
                                        />
                                        @error('title')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-300">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="background_color" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('Background Color') }}</label>
                                        <div class="flex items-center space-x-4">
                                            <input
                                                id="background_color"
                                                name="background_color"
                                                type="color"
                                                class="w-16 h-12 rounded-xl border-2 border-gray-300 dark:border-white/20 cursor-pointer bg-transparent"
                                                value="{{ old('background_color') ?? '#2563eb' }}"
                                            >
                                            <span class="text-gray-600 dark:text-white/80 text-sm">{{ __('Choose your board\'s theme color') }}</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="description" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">{{ __('Description') }}</label>
                                        <textarea
                                            id="description"
                                            name="description"
                                            rows="4"
                                            class="w-full bg-white/90 dark:bg-white/10 backdrop-blur-sm border border-gray-300 dark:border-white/20 rounded-xl px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-white/30 focus:border-blue-400 dark:focus:border-white/40 resize-none"
                                            placeholder="{{ __('Describe your board...') }}"
                                        >{{ old('description') ?? '' }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-300">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="bg-gray-100/80 dark:bg-white/10 backdrop-blur-sm rounded-2xl p-6">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                            <x-heroicon-o-tag class="w-5 h-5 text-gray-900 dark:text-white" />
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Categories') }}</h3>
                                        <span class="text-sm text-gray-600 dark:text-white/60">{{ __('(Optional)') }}</span>
                                    </div>

                                    <div id="categories-list" class="space-y-3">
                                        <div class="flex items-center space-x-3">
                                            <input
                                                type="text"
                                                name="categories[]"
                                                class="flex-1 bg-white/90 dark:bg-white/10 backdrop-blur-sm border border-gray-300 dark:border-white/20 rounded-xl px-4 py-2 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-white/30 focus:border-blue-400 dark:focus:border-white/40"
                                                placeholder="{{ __('Category name...') }}"
                                            />
                                            <button
                                                type="button"
                                                class="remove-category p-2 rounded-xl bg-red-500/20 backdrop-blur-sm text-red-600 dark:text-red-300 hover:bg-red-500/30 transition-colors opacity-0"
                                                title="{{ __('Remove') }}"
                                            >
                                                <x-heroicon-o-x-mark class="w-5 h-5" />
                                            </button>
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        id="add-category"
                                        class="mt-4 flex items-center space-x-2 bg-gray-200/50 dark:bg-white/15 backdrop-blur-sm rounded-xl px-4 py-2 text-gray-900 dark:text-white hover:bg-gray-300/50 dark:hover:bg-white/20 transition-colors"
                                    >
                                        <x-heroicon-o-plus class="w-5 h-5" />
                                        <span>{{ __('Add Category') }}</span>
                                    </button>
                                </div>

                                <div class="flex justify-end space-x-4 pt-4">
                                    <button
                                        type="button"
                                        @click="showCreateModal = false"
                                        class="px-6 py-3 bg-gray-200/50 dark:bg-white/10 backdrop-blur-sm rounded-xl text-gray-600 dark:text-white hover:bg-gray-300/50 dark:hover:bg-white/20 transition-colors"
                                    >
                                        {{ __('Cancel') }}
                                    </button>
                                    <button
                                        type="submit"
                                        class="px-8 py-3 bg-blue-500/20 dark:bg-white/20 backdrop-blur-sm rounded-xl text-blue-700 dark:text-white font-semibold hover:bg-blue-500/30 dark:hover:bg-white/30 transition-colors shadow-lg"
                                    >
                                        {{ __('Create Board') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom animations */
        @keyframes pulse {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.4; }
        }

        .animate-pulse {
            animation: pulse 4s ease-in-out infinite;
        }

        .delay-1000 { animation-delay: 1s; }
        .delay-2000 { animation-delay: 2s; }
        .delay-3000 { animation-delay: 3s; }

        /* Line clamp utility */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>

    <script>
        function boardsIndex() {
            return {
                showCreateModal: false,
                activeInvitationModal: null,

                openInvitationModal(invitationId) {
                    this.activeInvitationModal = invitationId;
                },

                acceptInvitation(invitationId) {
                    // Handle accept logic if needed
                },

                declineInvitation(invitationId) {
                    // Handle decline logic if needed
                }
            }
        }

        // Add category functionality
        document.addEventListener('DOMContentLoaded', function() {
            const addCategoryBtn = document.getElementById('add-category');
            const categoriesList = document.getElementById('categories-list');

            if (addCategoryBtn && categoriesList) {
                addCategoryBtn.addEventListener('click', function() {
                    const newCategory = document.createElement('div');
                    newCategory.className = 'flex items-center space-x-3';
                    newCategory.innerHTML = `
                        <input
                            type="text"
                            name="categories[]"
                            class="flex-1 bg-white/90 dark:bg-white/10 backdrop-blur-sm border border-gray-300 dark:border-white/20 rounded-xl px-4 py-2 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-white/30 focus:border-blue-400 dark:focus:border-white/40"
                            placeholder="Category name..."
                        />
                        <button
                            type="button"
                            class="remove-category p-2 rounded-xl bg-red-500/20 backdrop-blur-sm text-red-600 dark:text-red-300 hover:bg-red-500/30 transition-colors"
                            title="Remove"
                        >
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    `;

                    categoriesList.appendChild(newCategory);
                    updateRemoveButtons();
                });

                function updateRemoveButtons() {
                    const categories = categoriesList.querySelectorAll('.flex.items-center');
                    const removeButtons = categoriesList.querySelectorAll('.remove-category');

                    removeButtons.forEach((btn, index) => {
                        if (categories.length > 1) {
                            btn.style.opacity = '1';
                            btn.style.pointerEvents = 'auto';
                        } else {
                            btn.style.opacity = '0';
                            btn.style.pointerEvents = 'none';
                        }

                        btn.onclick = function() {
                            if (categories.length > 1) {
                                btn.closest('.flex.items-center').remove();
                                updateRemoveButtons();
                            }
                        };
                    });
                }

                updateRemoveButtons();
            }
        });
    </script>
</x-app-layout>

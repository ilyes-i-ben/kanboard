@props(['invitation'])

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

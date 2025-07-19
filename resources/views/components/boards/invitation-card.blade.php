@props(['invitation'])

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

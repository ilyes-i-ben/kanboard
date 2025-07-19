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

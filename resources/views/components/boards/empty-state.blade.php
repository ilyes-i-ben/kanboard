@props(['title', 'description', 'buttonText' => 'Create Board'])

<div class="max-w-4xl mx-auto px-6 lg:px-8 mb-16">
    <div class="text-center bg-gray-900/5 dark:bg-white/10 backdrop-blur-lg rounded-3xl p-12 shadow-2xl border border-gray-300/50 dark:border-white/20">
        <div class="w-24 h-24 rounded-3xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto mb-6 shadow-lg">
            <x-heroicon-o-squares-plus class="w-12 h-12 text-gray-900 dark:text-white" />
        </div>
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white drop-shadow-lg mb-4">{{ $title }}</h3>
        <p class="text-gray-700 dark:text-white/80 text-lg mb-8 max-w-2xl mx-auto">{{ $description }}</p>
        <button
            @click="showCreateModal = true"
            class="group inline-flex items-center space-x-3 bg-gray-900/10 dark:bg-white/20 backdrop-blur-lg rounded-xl px-8 py-4 hover:bg-gray-900/20 dark:hover:bg-white/30 transition-all duration-300 shadow-xl border border-gray-300/50 dark:border-white/20"
        >
            <x-heroicon-o-plus class="w-6 h-6 text-gray-900 dark:text-white group-hover:rotate-90 transition-transform duration-300" />
            <span class="text-gray-900 dark:text-white font-bold text-lg">{{ $buttonText }}</span>
        </button>
    </div>
</div>

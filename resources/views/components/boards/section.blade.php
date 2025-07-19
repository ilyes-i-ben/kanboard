@props(['title', 'count', 'icon', 'iconColor' => 'text-yellow-400', 'showCreateButton' => false])

<div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg border border-gray-900/10 dark:border-white/20">
                <x-dynamic-component :component="$icon" class="w-7 h-7 {{ $iconColor }}" />
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white drop-shadow-lg">{{ $title }}</h2>
                <p class="text-gray-600 dark:text-white/70">{{ $count }} {{ $count === 1 ? Str::singular($title) : Str::plural($title) }}</p>
            </div>
        </div>
        @if($showCreateButton)
            <button
                @click="showCreateModal = true"
                class="group flex items-center space-x-3 bg-gray-900/10 dark:bg-white/15 backdrop-blur-lg rounded-xl px-6 py-3 hover:bg-gray-900/20 dark:hover:bg-white/25 transition-all duration-300 shadow-xl border border-gray-900/10 dark:border-white/20"
            >
                <x-heroicon-o-plus class="w-5 h-5 text-gray-900 dark:text-white group-hover:rotate-90 transition-transform duration-300" />
                <span class="text-gray-900 dark:text-white font-semibold">{{ __('New Board') }}</span>
            </button>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {{ $slot }}
    </div>
</div>

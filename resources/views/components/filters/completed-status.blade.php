@props(['active'])
<div x-data="{ active: 'all' }" class="inline-flex rounded-2xl shadow-xl text-sm justify-center bg-white/10 dark:bg-white/10 backdrop-blur-lg border border-white/20 overflow-hidden" role="group">
    <button type="button"
        @click="active = 'all'; $dispatch('completed-filter', { value: 'all' })"
        :class="active === 'all' ? 'bg-white/30 text-blue-700 dark:text-blue-300 shadow-lg scale-105' : 'hover:bg-white/20 text-white/90 dark:text-white'"
        class="inline-flex items-center px-4 py-2 font-semibold transition-all duration-200 focus:z-10 focus:ring-2 focus:ring-pink-400 focus:outline-none">
        <x-heroicon-s-list-bullet class="w-4 h-4 mr-2" /> All
    </button>
    <button type="button"
        @click="active = 'not'; $dispatch('completed-filter', { value: 'not' })"
        :class="active === 'not' ? 'bg-white/30 text-blue-700 dark:text-blue-300 shadow-lg scale-105' : 'hover:bg-white/20 text-white/90 dark:text-white'"
        class="inline-flex items-center px-4 py-2 font-semibold transition-all duration-200 focus:z-10 focus:ring-2 focus:ring-pink-400 focus:outline-none">
        <x-heroicon-s-clock class="w-4 h-4 mr-2" /> Pending
    </button>
    <button type="button"
        @click="active = 'yes'; $dispatch('completed-filter', { value: 'yes' })"
        :class="active === 'yes' ? 'bg-white/30 text-blue-700 dark:text-blue-300 shadow-lg scale-105' : 'hover:bg-white/20 text-white/90 dark:text-white'"
        class="inline-flex items-center px-4 py-2 font-semibold transition-all duration-200 focus:z-10 focus:ring-2 focus:ring-pink-400 focus:outline-none">
        <x-heroicon-s-check-circle class="w-4 h-4 mr-2" /> Completed
    </button>
    <button type="button"
        @click="active = 'late'; $dispatch('completed-filter', { value: 'late' })"
        :class="active === 'late' ? 'bg-white/30 text-blue-700 dark:text-blue-300 shadow-lg scale-105' : 'hover:bg-white/20 text-white/90 dark:text-white'"
        class="inline-flex items-center px-4 py-2 font-semibold transition-all duration-200 focus:z-10 focus:ring-2 focus:ring-pink-400 focus:outline-none">
        <x-heroicon-s-exclamation-triangle class="w-4 h-4 mr-2" /> Late
    </button>
</div>

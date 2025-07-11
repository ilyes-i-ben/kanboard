@props(['active'])
<div x-data="{ active: 'all' }" class="inline-flex rounded-md shadow-xs text-sm" role="group">
    <button type="button"
        @click="active = 'all'; $dispatch('completed-filter', { value: 'all' })"
        :class="active === 'all' ? 'bg-gray-800 text-white' : 'bg-transparent text-white'"
        class="inline-flex items-center px-3 py-2 font-medium border border-gray-300 rounded-s-lg hover:bg-gray-800 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-400 focus:bg-gray-800 focus:text-white dark:border-gray-500 dark:hover:bg-gray-800 dark:focus:bg-gray-800 transition-colors">
        <x-heroicon-s-list-bullet class="w-4 h-4 mr-2" /> All
    </button>
    <button type="button"
        @click="active = 'not'; $dispatch('completed-filter', { value: 'not' })"
        :class="active === 'not' ? 'bg-gray-800 text-white' : 'bg-transparent text-white'"
        class="inline-flex items-center px-3 py-2 font-medium border-t border-b border-gray-300 rounded-none hover:bg-gray-800 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-400 focus:bg-gray-800 focus:text-white dark:border-gray-500 dark:hover:bg-gray-800 dark:focus:bg-gray-800 transition-colors">
        <x-heroicon-s-clock class="w-4 h-4 mr-2" /> Pending
    </button>
    <button type="button"
        @click="active = 'yes'; $dispatch('completed-filter', { value: 'yes' })"
        :class="active === 'yes' ? 'bg-gray-800 text-white' : 'bg-transparent text-white'"
        class="inline-flex items-center px-3 py-2 font-medium border border-gray-300 rounded-e-lg hover:bg-gray-800 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-400 focus:bg-gray-800 focus:text-white dark:border-gray-500 dark:hover:bg-gray-800 dark:focus:bg-gray-800 transition-colors">
        <x-heroicon-s-check-circle class="w-4 h-4 mr-2" /> Completed
    </button>
</div>

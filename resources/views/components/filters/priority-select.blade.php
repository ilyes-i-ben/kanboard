@props(['id' => 'filter-priority'])
<div class="relative">
    <label for="{{ $id }}" class="block text-xs font-medium text-white dark:text-gray-300 mb-1">Priority</label>
    <select id="{{ $id }}" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white/90 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-sm transition-shadow duration-150 shadow-sm">
        <option value="" selected>All priorities</option>
        <option value="high">High</option>
        <option value="medium">Medium</option>
        <option value="low">Low</option>
    </select>
</div>

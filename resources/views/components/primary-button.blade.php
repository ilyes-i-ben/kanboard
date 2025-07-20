@props(['type' => 'submit'])

<button {{ $attributes->merge(['type' => $type, 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-gray-800 border border-transparent rounded-2xl font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-200 shadow-lg dark:bg-white/20 dark:backdrop-blur-sm dark:border-white/30 dark:text-white dark:hover:bg-white/30 dark:hover:border-white/40 dark:focus:bg-white/30 dark:focus:ring-white/50 dark:focus:ring-offset-transparent']) }}>
    {{ $slot }}
</button>

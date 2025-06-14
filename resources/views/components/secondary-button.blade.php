<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-neutral-800 border border-gray-300 dark:border-neutral-700 rounded-xl font-bold text-base text-gray-700 dark:text-gray-200 uppercase tracking-wide shadow hover:bg-gray-200 dark:hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-600 transition']) }}>
    {{ $slot }}
</button>

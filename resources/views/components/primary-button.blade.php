@props(['type' => 'submit'])

<button {{ $attributes->merge(['type' => $type, 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl font-semibold text-sm text-white uppercase tracking-widest hover:bg-white/30 hover:border-white/40 focus:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-offset-2 focus:ring-offset-transparent disabled:opacity-50 transition ease-in-out duration-200 shadow-lg']) }}>
    {{ $slot }}
</button>

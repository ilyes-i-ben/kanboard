<!-- Header -->
<x-slot name="header" class="max-w-7xl mx-auto py-0 px-0 sm:px-0 lg:px-0"></x-slot>
<div class="relative z-10 pt-8 pb-12 -mt-6 -mx-4 sm:-mx-6 lg:-mx-8">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 rounded-2xl bg-gray-900/10 dark:bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-2xl border border-gray-900/10 dark:border-white/20">
                    <x-heroicon-o-squares-plus class="w-10 h-10 text-gray-900 dark:text-white" />
                </div>
            </div>
            <h1 class="text-5xl font-black text-gray-900 dark:text-white drop-shadow-lg mb-4 tracking-tight">
                {{ $title ?? __('Your Boards') }}
            </h1>
            <p class="text-xl text-gray-700 dark:text-white/80 max-w-2xl mx-auto leading-relaxed">
                {{ $subtitle ?? __('Organize your projects with beautiful, powerful boards') }}
            </p>
        </div>
    </div>
</div>


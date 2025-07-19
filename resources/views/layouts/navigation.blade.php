<nav x-data="{ open: false }" class="bg-white/10 backdrop-blur-md border-b border-white/20 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('boards.index') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg border border-white/30 group-hover:bg-white/30 transition-all duration-200">
                            <x-application-logo class="w-6 h-6" />
                        </div>
                        <h1 class="text-xl font-black text-gray-800 dark:text-white tracking-tight">Kanboard</h1>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('boards.index')" :active="request()->routeIs('boards.*')" class="nav-link">
                        <div class="flex items-center space-x-2">
                            <x-heroicon-o-square-3-stack-3d class="w-4 h-4"/>
                            <span>{{ __('Boards') }}</span>
                        </div>
                    </x-nav-link>
                    @auth
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-link">
                        <div class="flex items-center space-x-2">
                            <x-heroicon-o-arrow-trending-up class="w-4 h-4"/>
                            <span>{{ __('Dashboard') }}</span>
                        </div>
                    </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center gap-3 sm:ms-6">
                <button
                    id="theme-toggle"
                    type="button"
                    class="inline-flex items-center px-4 py-2.5 border rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-200 "
                >
                    <x-heroicon-s-moon id="theme-toggle-dark-icon" class="hidden w-5 h-5"/>
                    <x-heroicon-s-sun id="theme-toggle-light-icon" class="hidden w-5 h-5"/>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-4 py-2.5 border rounded-xl font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-200"
                            style="height: 42px;"
                        >
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm
                                    @guest bg-amber-500/20 text-amber-600 dark:text-amber-400 @endguest">
                                    @auth
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    @else
                                        <x-heroicon-o-user class="w-5 h-5" />
                                    @endauth
                                </div>
                                <div class="hidden md:block">
                                    @auth
                                        {{ Auth::user()->name }}
                                    @else
                                        <span class="flex items-center space-x-1">
                                            <span class="font-semibold text-amber-600 dark:text-amber-400">Guest</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">(View only)</span>
                                        </span>
                                    @endauth
                                </div>
                                @auth
                                <x-heroicon-o-chevron-down class="h-4 w-4" />
                                @endauth
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @auth
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        @else
                        <div class="px-4 py-3 text-sm text-amber-600 dark:text-amber-400">
                            You're viewing as a guest
                        </div>
                        <x-dropdown-link :href="route('login')">
                            {{ __('Log In') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('register')">
                            {{ __('Register') }}
                        </x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-white/10 focus:outline-none focus:bg-white/10 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/5 backdrop-blur-sm border-t border-white/20">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('boards.index')" :active="request()->routeIs('boards.*')">
                {{ __('Boards') }}
            </x-responsive-nav-link>
            @auth
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-white/20">
            <div class="px-4">
                @auth
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                @else
                <div class="font-medium text-base text-amber-600 dark:text-amber-400">Guest User</div>
                <div class="font-medium text-sm text-gray-500">View-only access</div>
                @endauth
            </div>

            <div class="mt-3 space-y-1">
                @auth
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
                @else
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Log In') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    .nav-link {
        @apply px-4 py-2.5 rounded-xl transition-all duration-200 font-medium text-sm;
    }
    .nav-link:not(.active) {
        @apply text-gray-600 dark:text-gray-300 hover:bg-white/10 hover:text-gray-800 dark:hover:text-white;
    }
    .nav-link.active {
        @apply bg-white/20 backdrop-blur-sm text-gray-800 dark:text-white border border-white/30 shadow-lg;
    }
</style>

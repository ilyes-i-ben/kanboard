<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Welcome Back</h2>
        <p class="text-white/70 text-sm">Sign in to your account to continue</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300 text-sm" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-white/10 border-white/20 text-white shadow-sm focus:ring-white/50 focus:ring-offset-0" name="remember">
                <span class="ms-2 text-sm text-white/80">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-white/80 hover:text-white underline-offset-4 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-white/50 transition-colors duration-200" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="space-y-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Sign In') }}
            </x-primary-button>

            <div class="text-center">
                <span class="text-white/70 text-sm">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-white font-medium hover:text-white/80 underline-offset-4 hover:underline ml-1 transition-colors duration-200">
                    {{ __('Create one') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>

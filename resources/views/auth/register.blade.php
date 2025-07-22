<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Join Kanboard</h2>
        <p class="text-white/70 text-sm">Create your account and start organizing</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @honeypot
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300 text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300 text-sm" />
        </div>

        <div class="space-y-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Create Account') }}
            </x-primary-button>

            <div class="text-center">
                <span class="text-white/70 text-sm">Already have an account?</span>
                <a href="{{ route('login') }}" class="text-white font-medium hover:text-white/80 underline-offset-4 hover:underline ml-1 transition-colors duration-200">
                    {{ __('Sign in') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>

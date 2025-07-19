<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kanboard') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #5a357d 100%);
                min-height: 100vh;
            }
            .auth-container {
                background:
                    radial-gradient(circle at 20% 20%, rgba(255,255,255,0.15) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                    linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255,255,255,0.2);
                box-shadow:
                    0 25px 50px -12px rgba(0, 0, 0, 0.25),
                    0 0 0 1px rgba(255,255,255,0.1);
            }
            .floating-elements::before,
            .floating-elements::after {
                content: '';
                position: absolute;
                border-radius: 50%;
                background: rgba(255,255,255,0.1);
                animation: float 6s ease-in-out infinite;
            }
            .floating-elements::before {
                width: 200px;
                height: 200px;
                top: -100px;
                right: -100px;
                animation-delay: -2s;
            }
            .floating-elements::after {
                width: 150px;
                height: 150px;
                bottom: -75px;
                left: -75px;
                animation-delay: -4s;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(180deg); }
            }
            .dark body {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            }
            .dark .auth-container {
                background:
                    radial-gradient(circle at 20% 20%, rgba(255,255,255,0.08) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 50%),
                    linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
                border: 1px solid rgba(255,255,255,0.1);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-white/10 blur-xl animate-pulse"></div>
                <div class="absolute top-3/4 right-1/4 w-24 h-24 rounded-full bg-white/15 blur-lg animate-pulse delay-1000"></div>
                <div class="absolute bottom-1/4 left-3/4 w-20 h-20 rounded-full bg-white/12 blur-md animate-pulse delay-2000"></div>
            </div>

            <div class="mb-8 relative z-10">
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-28 h-28 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-2xl border border-white/30 p-1">
                        <img src="{{ asset('images/logo.png') }}" alt="Kanboard" class="object-contain">
                    </div>
                    <h1 class="text-4xl font-black text-white drop-shadow-lg tracking-tight">Kanboard</h1>
                    <p class="text-white/80 text-sm font-medium">Organize your projects beautifully</p>
                </div>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 auth-container floating-elements rounded-3xl relative z-10">
                {{ $slot }}
            </div>

            <button
                id="theme-toggle"
                class="fixed top-6 right-6 p-3 rounded-2xl bg-white/20 backdrop-blur-sm text-white border border-white/30 hover:bg-white/30 transition-all duration-200 shadow-lg z-20"
            >

                <x-heroicon-s-moon id="theme-toggle-dark-icon" class="hidden w-5 h-5"/>
                <x-heroicon-s-sun id="theme-toggle-light-icon" class="hidden w-5 h-5"/>

            </button>
        </div>
    </body>
</html>

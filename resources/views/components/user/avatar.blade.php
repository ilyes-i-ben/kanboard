@props(['user'])

@php
    $name = $user->name ?? 'U';
    $photo = $user->profile_photo_url ?? null;
    $initial = strtoupper(Str::substr($name, 0, 1));

    $bgColors = [
        'bg-red-500', 'bg-green-500', 'bg-blue-500', 'bg-yellow-500',
        'bg-indigo-500', 'bg-pink-500', 'bg-purple-500', 'bg-teal-500',
    ];

    $bgClass = $bgColors[crc32($name) % count($bgColors)];
@endphp

@if ($photo)
    <img
        src="{{ $photo }}"
        alt="{{ $name }}"
        class="inline-block h-6 w-6 rounded-full ring-2 ring-white object-cover"
    >
@else
    <div
        class="inline-flex items-center justify-center h-6 w-6 text-xs rounded-full ring-2 ring-white text-white {{ $bgClass }}"
        style="font-family: 'Inter', 'Segoe UI', system-ui, sans-serif; font-weight: 600;"
        title="{{ $name }}"
    >
        {{ $initial }}
    </div>
@endif

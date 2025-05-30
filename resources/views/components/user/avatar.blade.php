@props(['user', 'size' => '6'])

@php
    $name = $user->name ?? 'User';
    $photo = $user->profile_photo_url ?? null;

    $nameParts = explode(' ', $name);
    $firstInitial = strtoupper(Str::substr($nameParts[0] ?? '', 0, 1));
    $secondInitial = '';
    if (count($nameParts) > 1) {
        $secondInitial = strtoupper(Str::substr($nameParts[count($nameParts) - 1] ?? '', 0, 1));
    }
    $initials = $firstInitial . $secondInitial;

    $bgColors = [
        'bg-red-500', 'bg-green-500', 'bg-blue-500', 'bg-yellow-500',
        'bg-indigo-500', 'bg-pink-500', 'bg-purple-500', 'bg-teal-500',
    ];

    $bgClass = $bgColors[crc32($name) % count($bgColors)];
    $sizeClass = match($size) {
        'xs' => 'h-5 w-5 text-[10px]',
        'sm' => 'h-6 w-6 text-xs',
        'md' => 'h-8 w-8 text-sm',
        'lg' => 'h-10 w-10 text-base',
        'xl' => 'h-12 w-12 text-lg',
        '2xl' => 'h-16 w-16 text-xl',
        default => "h-$size w-$size text-xs"
    };
@endphp

@if ($photo)
    <img
        src="{{ $photo }}"
        alt="{{ $name }}"
        class="inline-block {{ $sizeClass }} rounded-full ring-2 ring-white object-cover"
        title="{{ $name }}"
    >
@else
    <div
        class="inline-flex items-center justify-center {{ $sizeClass }} rounded-full ring-2 ring-white text-white {{ $bgClass }}"
        style="font-family: 'Inter', 'Segoe UI', system-ui, sans-serif; font-weight: 600;"
        title="{{ $name }}"
    >
        {{ $initials }}
    </div>
@endif

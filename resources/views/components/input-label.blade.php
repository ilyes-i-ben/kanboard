@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-white/90 mb-2']) }}>
    {{ $value ?? $slot }}
</label>

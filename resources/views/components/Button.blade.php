@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $baseClasses = "rounded focus:outline-none font-semibold transition duration-150 ease-in-out cursor-pointer ";
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700',
        'secondary' => 'bg-gray-700 text-white hover:bg-gray-800',
        'success' => 'bg-green-700 text-white hover:bg-green-800',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
    ];
    $sizes = [
        'sm' => 'px-2 py-1 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
    ];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "$baseClasses {$variants[$variant]} {$sizes[$size]}"]) }}>
    {{ $slot }}
</button>

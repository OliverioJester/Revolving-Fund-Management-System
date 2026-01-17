@props([
    'label' => null,
    'type' => 'text',
    'name' => '',
    'value' => '',
    'placeholder' => '',
])

<div class="flex flex-col gap-1">
    @if ($label)
        <label for="{{ $name }}" class="font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        autocomplete="off"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none'
        ]) }}
    >

    {{-- Optional Laravel error message --}}
    @error($name)
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

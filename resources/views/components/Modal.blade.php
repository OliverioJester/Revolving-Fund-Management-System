@props(['title' => 'Modal Title'])

<div x-data="{ open: false }" class="inline">
    <!-- Trigger Button -->
    <span @click="open = true">
        {{ $trigger ?? $slot }}
    </span>

    <!-- Modal Background -->
    <div
        x-show="open"
        x-transition.opacity
        @click.self="open = false"
        class="fixed inset-0 bg-black/40 bg-opacity-50 flex items-center justify-center z-50 "
        style="display: none;"
    >
        <!-- Modal Box -->
        <div
            x-show="open"
            x-transition
            class="bg-white rounded-lg shadow-lg w-4xl max-h-9/10 p-6 overflow-auto lg:m-auto m-10"
        >
            <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>

            <!-- Modal Content -->
            <div class="mb-6">
                {{ $content }}
            </div>
        </div>
    </div>
</div>

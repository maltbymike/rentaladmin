<x-tools.toggle-button {{ $attributes }} :disabled="Auth::user()->cannot('update user permissions')">
    {{ $slot }}
</x-tools.toggle-button>
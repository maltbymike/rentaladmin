@props([
    'disabled' => false,    
])

<!-- from https://flowbite.com/docs/forms/toggle/ -->
<label class="inline-flex relative items-center cursor-pointer">
    <input @disabled($disabled) {{ $attributes->merge(['type' => 'checkbox', 'class' => 'sr-only peer']) }} />
    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
    <span class="ml-3 text-sm font-medium text-gray-900">{{ $slot }}</span>
</label>
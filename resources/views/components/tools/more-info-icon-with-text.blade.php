<div class="contents" x-data="{ open: false }"> 
    
    <x-svg.icons.circle-question class="w-4 h-4 fill-gray-500 hover:fill-gray-900" x-on:click="open = ! open" />
    
    <span class="text-sm text-gray-700 bg-gray-100 rounded px-3 py-1 inline max-w-sm" x-cloak x-show="open">
        {{ $slot }}
    </span>

</div>
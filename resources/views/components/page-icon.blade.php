@props([
    'linkTo',
])

<form action="{{ $linkTo ?? '#' }}" method="get" class="h-40 w-40 flex flex-col rounded-lg justify-center bg-white border hover:scale-105 ease-in-out duration-200">

    <button type="submit" class="h-40 w-40 grid grid-rows-3 gap-3 rounded-lg shadow-xl hover:bg-neutral-100 active:bg-orange-500 focus:bg-orange-100 focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">

        <div class="row-span-2 flex items-center justify-center h-full p-3">{{ $slot }}</div>

        @isset($title)
        <p class="text-gray-900 text-sm leading-tight font-medium mb-2 text-center">
            {{ $title }}
        </p>
        @endisset
    
    </button>
    
</form>

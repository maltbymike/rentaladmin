@props([
    'linkTo',
])

<form action="{{ $linkTo ?? '#' }}" method="get" class="aspect-square flex flex-col rounded-lg justify-center bg-white w-full border hover:scale-105 ease-in-out duration-200">

    <button type="submit" class="aspect-square rounded-lg shadow-xl hover:bg-neutral-100 active:bg-orange-500 focus:bg-orange-100 focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">

        {{ $slot }}

        @isset($title)
        <p class="text-gray-900 text-sm leading-tight font-medium mb-2 text-center">
            {{ $title }}
        </p>
        @endisset
    
    </button>
    
</form>

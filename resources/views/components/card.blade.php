@props([
    'linkTo',
])

<div class="flex flex-col justify-center p-6 rounded-lg shadow-lg bg-white w-full max-w-sm">
    
    @isset($title)
    <h5 class="text-gray-900 text-xl leading-tight font-medium mb-2 text-center">
        {{ $title }}
    </h5>
    @endisset
    
    <p class="text-gray-700 text-base">
    {{ $slot }}
    </p>

    @isset($button)
    <a href="{{ $linkTo ?? '#' }}" class="inline-block px-6 py-2.5 mt-4 bg-blue-600 text-white font-medium text-xs text-center leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
        {{ $button }}
</a>
    @endisset

</div>

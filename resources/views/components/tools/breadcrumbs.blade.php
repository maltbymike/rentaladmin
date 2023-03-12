@props([
    'breadcrumbs' => [],
])

<div {{ $attributes->merge(['class' => "flex gap-2"]) }}>

    @foreach ($breadcrumbs as $breadcrumb)
    
        <a href="{{ $breadcrumb['url'] }}" class="{{ $loop->last ? 'font-bold' : '' }}">{!! $breadcrumb['name'] !!}</a>

        @if(! $loop->last)
            <span>></span>
        @endif

    @endforeach

</div>
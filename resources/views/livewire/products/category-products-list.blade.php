@props([
    'products',
])

@aware([
    'state', 
])


@push('styles')
    <style>
    li.contents:nth-child(odd) > div {
        background-color: lightgray;
    }
    </style>
@endpush

<ul class="category-list grid grid-cols-10">

    @foreach ($products as $product )

        @if($product->product_status_id === $state['status'] && $product->product_visibility_id === $state['visibility'])

            <div class="col-span-full grid grid-cols-10 bg-white hover:bg-gray-50 items-center">
                <div class="col-span-4 py-1 px-2">{!! $product->name !!}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->two_hour_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->four_hour_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->daily_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->weekly_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->four_week_rate, 0) }}</div>
                <div class="justify-self-end p-1"><x-jet-button wire:click="$emit('showProduct', {{ $product->id }})">View</x-jet-button></div>
            </div>

        @endif

    @endforeach

</ul>
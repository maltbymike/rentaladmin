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

<ul class="category-list pl-3 grid grid-cols-10">

    @foreach ($products as $product )

        @if($product->product_status_id === $state['status'] && $product->product_visibility_id === $state['visibility'])

            <li class="contents">
                <div class="col-span-5 py-1 px-2">{!! $product->name !!}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->two_hour_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->four_hour_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->daily_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->weekly_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->four_week_rate, 0) }}</div>
            </li> 

        @endif

    @endforeach

</ul>
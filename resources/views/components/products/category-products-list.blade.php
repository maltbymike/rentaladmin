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

            <li class="col-span-full">
                <details>
                    
                    <summary class="col-span-full grid grid-cols-10 bg-white hover:bg-gray-50">
                        <div class="col-span-5 py-1 px-2">{!! $product->name !!}</div>
                        <div class="text-right py-1 px-2">{{ number_format($product->two_hour_rate, 0) }}</div>
                        <div class="text-right py-1 px-2">{{ number_format($product->four_hour_rate, 0) }}</div>
                        <div class="text-right py-1 px-2">{{ number_format($product->daily_rate, 0) }}</div>
                        <div class="text-right py-1 px-2">{{ number_format($product->weekly_rate, 0) }}</div>
                        <div class="text-right py-1 px-2">{{ number_format($product->four_week_rate, 0) }}</div>
                    </summary>

                    <div class="grid grid-cols-10 bg-white border border-white hover:border-gray-300">
                        <div class="col-span-5 py-1 px-4">Test Product</div>
                        <div class="text-right py-1 px-2">2h</div>
                        <div class="text-right py-1 px-2">4h</div>
                        <div class="text-right py-1 px-2">1d</div>
                        <div class="text-right py-1 px-2">1w</div>
                        <div class="text-right py-1 px-2">4w</div>
                    </div>

                </details>
            </li> 

        @endif

    @endforeach

</ul>
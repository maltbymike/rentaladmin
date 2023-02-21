<x-tools.section-with-heading>

    <x-slot name="heading">Rates</x-slot>

    <div class="flex flex-col">
        
        <div class="grid grid-cols-7 gap-3 py-2 even:bg-gray-50 -mx-3 px-3">
            <div class="col-span-2"></div>
            <div class="text-right">2 Hour</div>
            <div class="text-right">4 Hour</div>
            <div class="text-right">Daily</div>
            <div class="text-right">Weekly</div>
            <div class="text-right">4 Week</div>
        </div>

        @if($product)
            <div class="grid grid-cols-7 gap-3 py-2 even:bg-gray-50 -mx-3 px-3">
                <div class="col-span-2">{{ __('Current Rates:') }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->two_hour_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->four_hour_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->daily_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->weekly_rate, 0) }}</div>
                <div class="text-right py-1 px-2">{{ number_format($product->four_week_rate, 0) }}</div>
            </div>
                
        @endif

        @foreach ($rateTypes as $type)
            <div class="grid grid-cols-7 gap-3 py-2 even:bg-gray-50 -mx-3 px-3">
                <div class="col-span-2 col-start-1">{{ $type->name }}</div>
            </div>
        @endforeach
    </div>

</x-tools.section-with-heading>
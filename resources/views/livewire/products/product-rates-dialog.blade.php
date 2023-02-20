<x-jet-dialog-modal wire:model="showProduct">

    <x-slot name="title">
        {!! $product->name !!}
    </x-slot>

    <x-slot name="content">

        <div class="grid grid-cols-7 gap-3">

            <div class="col-span-2"></div>
            <div class="text-right py-1 px-2">2 Hour</div>
            <div class="text-right py-1 px-2">4 Hour</div>
            <div class="text-right py-1 px-2">Daily</div>
            <div class="text-right py-1 px-2">Weekly</div>
            <div class="text-right py-1 px-2">4 Week</div>

            <div class="col-span-2">{{ __('Current Rates:') }}</div>
            <div class="text-right py-1 px-2">{{ number_format($product->two_hour_rate, 0) }}</div>
            <div class="text-right py-1 px-2">{{ number_format($product->four_hour_rate, 0) }}</div>
            <div class="text-right py-1 px-2">{{ number_format($product->daily_rate, 0) }}</div>
            <div class="text-right py-1 px-2">{{ number_format($product->weekly_rate, 0) }}</div>
            <div class="text-right py-1 px-2">{{ number_format($product->four_week_rate, 0) }}</div>

            <livewire:products.alternate-rates.create-rate-type-form />

        </div>

    </x-slot>

    <x-slot name="footer">
        
    </x-slot>

</x-jet-dialog-modal>
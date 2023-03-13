<div>
    
    <x-slot name="header">
        <x-page-title>Input Alternate Rates By Category</x-page-title>
    </x-slot>

    <x-tools.breadcrumbs :breadcrumbs="$breadcrumb" class="-m-3 p-3 bg-gray-200" />

    @if(count($category->subcategoriesWithDescendants))
    <section class="flex flex-col gap-3 mt-3 pt-3">

        @foreach ($category->subcategoriesWithDescendants as $displayCategory)

            <x-jet-button wire:click.prevent="$set('currentCategory', {{ $displayCategory->wp_id }})">
                {!! $displayCategory->name !!}
            </x-jet-button>
        
        @endforeach

    </section>
    @endif

    <section class="flex flex-col gap-3 mt-3 pt-3">

        <div class="product-wrapper">

            @if(count($category->products))
            <div class="hidden lg:grid lg:grid-cols-2">
                <div class="font-bold bg-gray-500 text-white -ml-3 -mt-3 pl-5 py-3">Item</div>
                <div class="font-bold bg-gray-500 text-white text-center -mr-3 -mt-3 pr-5 py-3">Rates</div>
            </div>
            @endif
            
            @foreach ($category->products as $product)
            @if ($product->product_visibility_id === $visibleStatus && $product->product_status_id === $publishStatus)
            <div class="grid lg:grid-cols-2 {{ $loop->even ? 'lg:bg-gray-100 -mx-3 px-3' : '' }} {{ $loop->first ? '-mt-3 lg:mt-0' : '' }}">
                
                <div class="font-bold p-2 bg-gray-500 text-white lg:bg-inherit lg:text-inherit -mx-3 lg:m-0">{!! $product->name !!}</div>
                
                <div class="table-auto text-center p-2 grid grid-cols-7 gap-y-2">
                
                    <!-- Heading -->
                    <div class="col-start-4 font-bold">4 Hour</div>
                    <div class="font-bold">Day</div>
                    <div class="font-bold">Week</div>
                    <div class="font-bold">4 Week</div>
                
                    <!-- Current Rates -->
                    <div class="text-start col-span-3 border-b border-b-gray-500">Current Rates</div>
                    <div class="border-b border-b-gray-500">{{ number_format($product->four_hour_rate, 0) }}</div>
                    <div class="border-b border-b-gray-500">{{ number_format($product->daily_rate, 0) }}</div>
                    <div class="border-b border-b-gray-500">{{ number_format($product->weekly_rate, 0) }}</div>
                    <div class="border-b border-b-gray-500">{{ number_format($product->four_week_rate, 0) }}</div>

                    <!-- Alternate Rates Loop -->
                    @foreach ($rateTypes as $rateType)
                        @if($alternateProduct = $product->alternateProducts->where('product_alternate_rate_type_id', $rateType->id)->last())
    
                            <div class="text-start col-span-3 flex gap-2 items-center border-b border-b-gray-500">

                                {{ $rateType->name }}
    
                                <x-svg.icons.circle-question class="w-4 h-4 fill-gray-500 hover:fill-gray-900">
                                    <title>{{ $alternateProduct->alternateRates->first()->updated_at->toDateString() }}</title>
                                </x-svg.icons.circle-question>

                                <a href='{{ $rateType->url_start }}{{ $alternateProduct->product_identifier }}' target="_blank">
                                    <x-svg.icons.arrow-right-on-rectangle class="w-5 h-5 stroke-gray-500 hover:stroke-gray-900">
                                        <title>{{ __('Go to site:') }} {{ $rateType->url_start }}{{ $alternateProduct->product_identifier }}</title>
                                    </x-svg.icons.arrow-right-on-rectangle>
                                </a>
    
                            </div>
        
                            <div class="border-b border-b-gray-500">{{ number_format($alternateProduct->alternateRates->first()->four_hour_rate, 0) }}</div>
                            <div class="border-b border-b-gray-500">{{ number_format($alternateProduct->alternateRates->first()->daily_rate, 0) }}</div>
                            <div class="border-b border-b-gray-500">{{ number_format($alternateProduct->alternateRates->first()->weekly_rate, 0) }}</div>
                            <div class="border-b border-b-gray-500">{{ number_format($alternateProduct->alternateRates->first()->four_week_rate, 0) }}</div>
                        @endif
                    @endforeach

                    <!-- Add Rates -->
                    <x-jet-button class="justify-center col-start-4 col-span-4" wire:click="$emit('showProduct', {{ $product->id }})">
                        Add Rates
                    </x-jet-button>

                </div>
            
            </div>
            @endif
            @endforeach

        </div>
    
    </section>

    <livewire:products.alternate-rates.product-rates-dialog />

</div>

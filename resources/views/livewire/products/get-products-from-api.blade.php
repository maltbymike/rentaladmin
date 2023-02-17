<div>

    <x-slot name="header">
        <x-page-title>Get Products From Wordpress API</x-page-title>
    </x-slot>

    <x-jet-button
        wire:click="getProductsFromApi"
        wire:loading.class="opacity-50"
        wire:target="getProductsFromApi"
        class="mb-8">
        Get Products
    </x-jet-button>

    <section 
        wire:loading.class="opacity-50"
        wire:target="getProductsFromApi"
        class="grid grid-cols-6 gap-3 bg-gray-100 p-3">
    
        @foreach($productsByStatus as $status => $products)

            <div x-data="{ open: false }" class="contents">

                <x-jet-button x-on:click="open = ! open" class="col-span-full">
                    @if ($status === 'added') 
                        Added ({{ $productsByStatus['added']->count() }})
                    @elseif ($status === 'updated') 
                        Updated ({{ $productsByStatus['updated']->count() }})
                    @elseif ($status === 'toDelete') 
                        To Delete ({{ $productsByStatus['toDelete']->count() }})
                    @endif    
                </x-jet-button>

                <div x-show="open" class="contents">
                
                    <div class="col-span-3 font-bold">Name</div>
                    <div class="text-center font-bold">Product ID</div>
                    <div class="font-bold">Created At</div>
                    <div class="font-bold">Updated At</div>
                    
                    @foreach($products as $product)
                        <div class="col-span-3">{!! $product->name !!}</div>
                        <div class="text-center">{{ $product->id }}</div>
                        <div>{{ $product->created_at }}</div>
                        <div>{{ $product->updated_at }}</div>
                    @endforeach
                
                </div>

            </div>

        @endforeach
    
    </section>

</div>

@props([
    'categories',
    'level' => 1,
])

<div class="pl-3 bg-gray-100">

    @foreach($categories as $category)

        <details>

            <summary class="p-3 grid grid-cols-10 bg-gray-50 hover:bg-gray-100 border-b">

                <h{{ $level }} class="font-bold col-span-5">
                    <a href="{{ route('products.show', ['category' => $category->wp_id]) }}">
                        {!! $category->name !!}
                    </a>
                </h{{ $level }}>
    
                @if(count($category->products))
                    <div class="text-right">2 Hours</div>
                    <div class="text-right">4 Hours</div>
                    <div class="text-right">Daily</div>
                    <div class="text-right">Weekly</div>
                    <div class="text-right">4 Week</div>
                @else
                    <div class="col-span-5"></div>
                @endif
            </summary>
        
            @if(count($category->products))
                <x-products.category-products-list :products="$category->products" />
            @endif
            
            @if(count($category->subcategoriesWithDescendants))
                <x-products.category-with-subcategories :categories="$category->subcategoriesWithProductsAndDescendants" level="{{ $level + 1 }}" />
            @endif


                    
        </details>

    @endforeach

</div>
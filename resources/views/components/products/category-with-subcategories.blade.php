@props([
    'categories',
    'level' => 1,
])

<ul class="pl-3">

    @foreach($categories as $category)

        <li>
            <div class="pl-3 pt-3 grid grid-cols-10">
                <h{{ $level }} class="font-bold col-span-5">{!! $category->name !!}</h{{ $level }}>
                <div class="text-right">2 Hours</div>
                <div class="text-right">4 Hours</div>
                <div class="text-right">Daily</div>
                <div class="text-right">Weekly</div>
                <div class="text-right">4 Week</div>
            </div>
        
            @if(count($category->products))
                <x-products.category-products-list :products="$category->products" />
            @endif
            
            @if(count($category->subcategoriesWithDescendants))
                <x-products.category-with-subcategories :categories="$category->subcategoriesWithProductsAndDescendants" level="{{ $level + 1 }}" />
            @endif


                    
        </li>

    @endforeach

</ul>
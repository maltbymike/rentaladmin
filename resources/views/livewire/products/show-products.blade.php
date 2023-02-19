<div>

    <x-slot name="header">
        <x-page-title>Show Products</x-page-title>
    </x-slot>

    <x-products.category-with-subcategories :categories="$categories" :state="$state" />

</div>

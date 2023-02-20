<div>

    <x-slot name="header">
        <x-page-title>Show Products</x-page-title>
    </x-slot>

    <div class="">
        <x-products.category-with-subcategories :categories="$categories" :state="$state" />
    </div>

    <livewire:products.alternate-rates.product-rates-dialog />

</div>

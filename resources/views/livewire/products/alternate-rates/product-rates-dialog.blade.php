<x-jet-dialog-modal wire:model="showProduct">

    <x-slot name="title">
        {!! $product->name ?? '' !!}
    </x-slot>

    <x-slot name="content">

        <div class="flex flex-col gap-4">
        
            <livewire:products.alternate-rates.show-alternate-rates-for-product :product="$product" />

            <livewire:products.alternate-rates.create-alternate-rate-form />

            <livewire:products.alternate-rates.create-rate-type-form />

        </div>

    </x-slot>

    <x-slot name="footer">
        
    </x-slot>

</x-jet-dialog-modal>
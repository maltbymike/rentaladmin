<x-app-layout>
    <x-slot name="header">
        <x-page-title>{{ __('Show Expiring Credit Cards') }}</x-page-title>
    </x-slot>

    <livewire:moneris.get-expiring/>

</x-app-layout>
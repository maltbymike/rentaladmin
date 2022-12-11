<x-app-layout>
    <x-slot name="header">
        <x-page-title>{{ __('Dashboard') }}</x-page-title>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 p-3">
    
        <x-card.page.moneris />
        <x-card.page.moneris />
        <x-card.page.moneris />
        <x-card.page.moneris />
        <x-card.page.moneris />
        <x-card.page.moneris />
        <x-card.page.moneris />


    </div>

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <x-page-title>{{ __('Dashboard') }}</x-page-title>
    </x-slot>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 p-6">
        
        <div class="col-span-full">Time Clock</div>
        <x-page-icon.timeclock />
        
        <div class="col-span-full">Moneris</div>
        <x-page-icon.moneris-expiring />
        <x-page-icon.moneris-upload-vault-profiles />
        <x-page-icon.moneris-show-vault-profiles />

    </div>

</x-app-layout>

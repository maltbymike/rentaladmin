<x-app-layout>
    <x-slot name="header">
        <x-page-title>{{ __('Dashboard') }}</x-page-title>
    </x-slot>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 p-6">
        
        <x-page-icon.timeclock />
        <x-page-icon.moneris-expiring />

    </div>

</x-app-layout>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3"> 
                            
                            @if(session('success') or session()->has('success'))
                                <x-flash-messages.success-message role="alert">
                                    <span class="font-bold">Success: </span>
                                    {{ session('success') }}
                                </x-flash-messages.success-message>
                            @endif

                            @if(session('warning') or session()->has('warning'))
                                <x-flash-messages.warning-message role="alert">
                                    <span class="font-bold">Warning: </span>
                                    {{ session('warning') }}
                                </x-flash-messages.warning-message>
                            @endif

                            @if(session('failure') or session()->has('failure'))
                                <x-flash-messages.error-message role="alert">
                                    <span class="font-bold">Failure: </span>
                                    {{ session('failure') }}
                                </x-flash-messages.error-message>
                            @endif

                            @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                    <span class="font-bold">Error: </span>
                                    {{ $error }}
                                </div>
                            @endforeach
                            @endif


                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>

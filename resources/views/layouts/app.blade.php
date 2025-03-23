<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.header')

            <div class="flex min-h-screen">
                <div class="w-64 flex-shrink-0">
                    @if (isset($showSidebarB) && $showSidebarB)
                        @include('layouts.sidebar_b')
                    @else
                        @include('layouts.sidebar_a')
                    @endif
                </div>
                
                <main class="flex-1 p-6">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>

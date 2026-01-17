<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Home') || {{ 'Revolving Fund' }}</title>
        @vite('resources/css/app.css')
    </head>
    <body class="">
        @guest
            @include('auth.login')
        @endguest

        @auth
            {{-- Header --}}
            @include('components.header')

            {{-- Main Content --}}
            <main class="flex-1 p-6 bg-gray-100 pt-20">
                @yield('content')
            </main>
        
            {{-- Footer --}}
            @include('components.footer')

            {{-- Js --}}
            @vite('resources/js/app.js')
        @endauth
    </body>
</html>

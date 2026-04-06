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

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white">
            <div class="mt-7 flex justify-center">
    <a href="/">
        <x-application-logo class="w-20 h-20 text-blue-600 bg-emerald-600" />
    </a>
</div>
    <div class="min-h-screen flex items-center justify-center p-6">

        <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden flex">

            <!-- LEFT SIDE -->
            <div class="hidden md:flex w-1/2 bg-gradient-to-br from-green-500 to-emerald-600 items-center justify-center p-10 relative">

                <!-- Overlay Shape -->
                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>

                <img src="{{ asset('bg-login.jpeg') }}"
                     class="relative z-10 max-h-[400px] object-contain">

            </div>

            <!-- RIGHT SIDE -->
            <div class="w-full md:w-1/2 p-12 flex items-center justify-center bg-gray-50">

                <div class="w-full max-w-sm">
                    {{ $slot }}
                </div>

            </div>

        </div>

    </div>

</body>
</html>
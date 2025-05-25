<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="/balance.svg" type="image/svg+xml" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

    <!-- Animate.css -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="bg-blue-500 text-gray-800 font-sans animate__animated animate__fadeIn min-h-screen flex items-center justify-center overflow-hidden px-4">

    <!-- Bubble Effects -->
    <div
        class="absolute bottom-0 right-0 w-64 h-64 bg-blue-400 rounded-full opacity-30 blur-3xl animate-pulse pointer-events-none"
    ></div>
    <div
        class="absolute top-10 left-10 w-40 h-40 bg-blue-300 rounded-full opacity-20 blur-2xl pointer-events-none"
    ></div>

    <!-- Card wrapper -->
    <div
        class="w-full max-w-md bg-white p-8 rounded-xl shadow-xl z-10 relative"
    >
        <div class="flex items-center text-blue-500 mb-6 justify-center">
            <a href="/" class="flex items-center">
                <div class="transform -rotate-12 text-2xl mr-3">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div class="text-2xl font-semibold">
                    NimBank <sup class="text-sm font-normal">1.0</sup>
                </div>
            </a>
        </div>

        <!-- Dynamic content -->
        {{ $slot }}
    </div>
</body>
</html>

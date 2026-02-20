<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hospital Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
     @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Optional: Add a custom stylesheet for any overrides -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-0 min-h-screen">
        <!-- Sidebar - hidden on mobile by default, can be toggled via JS if needed -->
        @auth
            <div class="lg:col-span-1 max-lg:hidden">
                @include('layouts.sidebar')
            </div>
        @endauth

        <!-- Main Content Area -->
        <div class="@auth lg:col-span-4 @else lg:col-span-5 @endauth flex flex-col h-screen">
            <!-- Navigation -->
             @auth
                <div class="sticky top-0 z-10">
                    @include('layouts.navigation')
                </div>
            @endauth 

            <!-- Page Heading (if any) -->
            @isset($header)
                <header class="bg-white shadow flex-shrink-0">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset 

            <!-- Page Content -->
            <main class="flex-1 overflow-auto bg-gray-50">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Stack for scripts -->
    @stack('scripts')
</body>
</html>
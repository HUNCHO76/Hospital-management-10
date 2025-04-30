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
        <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
        <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="{{ asset('build/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('build/assets/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('build/assets/vendors/css/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ asset('build/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="{{ asset('build/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('build/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <!-- endinject -->
        <!-- Layout styles -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="{{ asset('build/assets/css/style.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('build/assets/css/cssStyle.css') }}"> --}}
        <link rel="stylesheet" href="resources/css/app.css">

        <!-- End layout styles -->
        <link rel="shortcut icon" href="assets/images/favicon.png" />
        <link rel="shortcut icon" href="{{ asset('build/assets/images/favicon.png') }}" />
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js',]) --}}
    </head>
    <body class="font-sans antialiased">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper">
            @include('layouts.navigation')
            @include('layouts.sidebar')
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
                <main class="main-panel">
                    <div class="content-wrapper">
                {{ $slot }}
                    </div>
                </main>

            </div>
        </div>
        <script src="{{ asset('build/assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="{{ asset('build/assets/vendors/chart.js/chart.umd.js') }}"></script>
        <script src="{{ asset('build/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

        <!-- End plugin js for this page -->
        <!-- inject:js -->
        {{-- <script src="assets/js/off-canvas.js"></script> --}}
        <script src="{{ asset('build/assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('build/assets/js/misc.js') }}"></script>

        <script src="{{ asset('build/assets/js/settings.js') }}"></script>
        <script src="{{ asset('build/assets/js/todolist.js') }}"></script>
        <script src="{{ asset('build/assets/js/jquery.cookie.js') }}"></script>
        <script src="{{ asset('build/assets/js/jquery-3.5.1.min.js') }}"></script>
        <!-- endinject -->
        <!-- Custom js for this page -->
        <script src="{{ asset('build/assets/js/dashboard.js') }}"></script>
    </body>
</html>

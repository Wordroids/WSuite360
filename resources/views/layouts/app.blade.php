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
<!--For alerts-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a23cd217c4.js" crossorigin="anonymous"></script>

</head>

<body class="font-sans antialiased">
    <div class="h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <div>
            @include('layouts.navigation')
        </div>

        <!-- Page Content -->
        <main class="p-6 w-full overflow-scroll">
            {{ $slot }}
        </main>
    </div>
</body>

</html>

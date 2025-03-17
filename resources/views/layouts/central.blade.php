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

<body class="font-sans antialiased h-full bg-gray-200 dark:bg-gray-800">
  <div class="min-h-full">
    <nav class="bg-gray-900 border-b border-gray-700">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
          <div class="flex flex-1 items-stretch">
            <div class="flex shrink-0 items-center">
              <h1 class="text-gray-200 font-bold">WSuite360</h1>
            </div>
            <div class="ml-6">
              <div class="flex space-x-4">
                <x-menu-item route="dashboard" name="Dashboard"/>
                <x-menu-item route="tenants" name="Tenants"/>
                <x-menu-item route="#" name="Transcations"/>
              </div>
            </div>
            <div class="ml-auto flex items-center">
              <form action="/logout" method="post">
                @csrf
                <button href="#" class="rounded-md bg-gray-800 px-3 py-2 text-sm font-medium text-gray-200 hover:bg-gray-700" aria-current="page">Logout</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="py-5">
      @isset($header)
      <header>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-5">
          <h1 class="text-3xl font-bold tracking-tight text-gray-800 dark:text-gray-200">{{$header}}</h1>
        </div>
      </header>
      @endisset

      <main>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          {{ $slot }}
        </div>
      </main>
    </div>
  </div>
</html>
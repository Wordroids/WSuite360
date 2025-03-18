@php 
  $port = request()->getPort();
  if($port == 80 || $port == 443 || $port == 8080){
    $port = "";
  } else{
    $port = ":".$port;
  }
@endphp
<x-central-layout>
  <x-slot name="header">
    <div class="md:flex md:items-center md:justify-between">
      <div class="min-w-0 flex-1">
        <h2 class="text-2xl/7 font-bold dark:text-white text-gray-800 sm:truncate sm:text-3xl sm:tracking-tight">{{ __('Tenants') }}</h2>
      </div>
      <div class="mt-4 flex md:mt-0 md:ml-4">
        <a href="{{route('tenants.create')}}" class="ml-3 inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Create Tenant</a>
      </div>
    </div>
  </x-slot>

  @if($tenants->count() == 0)
  <h1 class="dark:text-gray-200 text-gray-800">No tenants found</h1>
  @endif

  <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-700">
    @foreach($tenants as $tenant)
    <li class="flex items-center justify-between gap-x-6 py-5">
      <div class="min-w-0">
        <div class="flex items-start gap-x-3">
          <p class="text-sm/6 font-semibold text-gray-900 dark:text-white">{{$tenant->name}}</p>
          <p class="mt-0.5 rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium whitespace-nowrap text-green-700 ring-1 ring-green-600/20 ring-inset">Active</p>
        </div>
        <div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500 dark:text-gray-200">
          <p class="whitespace-nowrap">{{$tenant->domains()->first()->domain}}</p>
        </div>
      </div>
      <div class="flex flex-none items-center gap-x-4">
        <a href="http://{{$tenant->domains()->first()->domain}}{{$port}}/dashboard" class="rounded-md bg-gray-300 dark:bg-gray-700 px-3 py-2 text-sm font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-400 hover:dark:bg-gray-600">Dashboard</a>
        <a href="{{route('tenants.edit', compact('tenant'))}}" class="rounded-md bg-gray-300 dark:bg-gray-700 px-3 py-2 text-sm font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-400 hover:dark:bg-gray-600">Edit</a>
      </div>
    </li>
    @endforeach
  </ul>
</x-central-layout>
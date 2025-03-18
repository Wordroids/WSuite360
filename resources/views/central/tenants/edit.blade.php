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
        <h2 class="text-2xl/7 font-bold dark:text-white text-gray-800 sm:truncate sm:text-3xl sm:tracking-tight">{{ __('Edit Tenant') }}</h2>
      </div>
    </div>
  </x-slot>

  @if(session('success'))
  <div class="rounded-md bg-green-50 p-4 mb-4" x-data="{show: true}" x-show="show">
    <div class="flex">
      <div class="shrink-0">
        <svg class="size-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
          <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <p class="text-sm font-medium text-green-800">{{session('success')}}</p>
      </div>
      <div class="ml-auto pl-3">
        <div class="-mx-1.5 -my-1.5">
          <button x-on:click="show = false" type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50 focus:outline-hidden">
            <span class="sr-only">Dismiss</span>
            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
              <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
  @endif

  <form id="edit-tenant" action="{{route('tenants.update', compact('tenant'))}}" method="post" class="flex flex-col gap-4">
    @method('put')
    @csrf
    <div>
      <label for="name" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-200">Tenant Name</label>
      <div class="mt-2 flex">
        <input type="text" name="name" value="{{old('name', $tenant->name ?? '')}}" id="name" class="block w-full grow rounded-md bg-white dark:bg-gray-600 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200 placeholder:text-gray-400 sm:text-sm/6" placeholder="Exampleco, LLC">
      </div>
      @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
      <label for="id" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-200">Tenant ID</label>
      <div class="mt-2 flex">
        <input type="text" name="id" value="{{old('id', $tenant->id ?? '')}}" id="id" class="block w-full grow rounded-md bg-white dark:bg-gray-600 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200 placeholder:text-gray-400 sm:text-sm/6" placeholder="exampleco">
      </div>
      @error('id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
      <label for="tier" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-200">Tier</label>
      <div class="mt-2 flex">
        <select name="tier" id="tier" class="block w-full grow rounded-md bg-white dark:bg-gray-600 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200">
            <option value="" disabled {{ old('tier') ?? $tenant->tier == '' ? 'selected' : '' }}>Select</option>
            <option value="free" {{ old('tier') ?? $tenant->tier == 'free' ? 'selected' : '' }}>Free</option>
            <option value="basic" {{ old('tier') ?? $tenant->tier == 'basic' ? 'selected' : '' }}>Basic</option>
            <option value="pro" {{ old('tier') ?? $tenant->tier == 'pro' ? 'selected' : '' }}>Pro</option>
            <option value="enterprise" {{ old('tier') ?? $tenant->tier == 'enterprise' ? 'selected' : '' }}>Enterprise</option>
        </select>
      </div>
      @error('tier')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div x-data="{ domain: '{{explode('.', old('domain', $tenant->domains()->first()->domain ?? ''))[0] ?? ''}}', root: '{{explode('//', env('APP_URL'))[1]}}' }">
        <label for="display-domain" class="block text-sm font-medium text-gray-900 dark:text-gray-200">
            Subdomain
        </label>
        <div class="mt-2 flex">
            <input type="hidden" name="domain" x-bind:value="`${domain}.${root}`">
            <input type="text" x-model="domain" id="display-domain" class="block w-full grow rounded-l-md bg-white dark:bg-gray-600 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200 placeholder:text-gray-400 sm:text-sm">
            <div class="flex shrink-0 items-center rounded-r-md bg-white dark:bg-gray-600 px-3 text-base text-gray-500 dark:text-gray-200 sm:text-sm">
                .{{ explode('//', env('APP_URL'))[1] }}
            </div>
        </div>
        @error('domain')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
  </form>
  <form id="delete-tenant" action="{{route('tenants.destroy', compact('tenant'))}}" method="post">
    @method('delete')
    @csrf
  </form>
  <div class="flex justify-end mt-4 gap-4">
    <button type="submit" form="delete-tenant" class="inline-flex items-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">Delete Tenant</submit>
    <button type="submit" form="edit-tenant" class="inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Update Tenant</submit>
  </div>
</x-central-layout>
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
        <h2 class="text-2xl/7 font-bold dark:text-white text-gray-800 sm:truncate sm:text-3xl sm:tracking-tight">{{ __('Create Tenant') }}</h2>
      </div>
    </div>
  </x-slot>

  <form action="{{route('tenants.store')}}" method="post" class="flex flex-col gap-4">
    @csrf
    <div>
      <label for="name" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-200">Tenant Name</label>
      <div class="mt-2 flex">
        <input type="text" name="name" value="{{old('name', '')}}" id="name" class="block w-full grow rounded-md bg-gray-100 dark:bg-gray-600 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200 placeholder:text-gray-400 sm:text-sm/6" placeholder="Exampleco, LLC">
      </div>
      @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
      <label for="id" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-200">Tenant ID</label>
      <div class="mt-2 flex">
        <input type="text" name="id" value="{{old('id', '')}}" id="id" class="block w-full grow rounded-md bg-gray-100 dark:bg-gray-600 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200 placeholder:text-gray-400 sm:text-sm/6" placeholder="exampleco">
      </div>
      @error('id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
      <label for="tier" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-200">Tier</label>
      <div class="mt-2 flex">
        <select name="tier" id="tier" class="block w-full grow rounded-md bg-gray-100 dark:bg-gray-600 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200">
            <option value="" disabled {{ old('tier') == '' ? 'selected' : '' }}>Select</option>
            <option value="free" {{ old('tier') == 'free' ? 'selected' : '' }}>Free</option>
            <option value="basic" {{ old('tier') == 'basic' ? 'selected' : '' }}>Basic</option>
            <option value="pro" {{ old('tier') == 'pro' ? 'selected' : '' }}>Pro</option>
            <option value="enterprise" {{ old('tier') == 'enterprise' ? 'selected' : '' }}>Enterprise</option>
        </select>
      </div>
      @error('tier')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div x-data="{ domain: '{{ explode('.', old('domain', ''))[0] ?? '' }}', root: '{{ env('CENTRAL_DOMAIN') }}' }">
        <label for="display-domain" class="block text-sm font-medium text-gray-900 dark:text-gray-200">
            Subdomain
        </label>
        <div class="mt-2 flex">
            <input type="hidden" name="domain" x-bind:value="`${domain}.${root}`">
            <input type="text" x-model="domain" id="display-domain" class="block w-full grow rounded-l-md bg-gray-100 dark:bg-gray-600 px-3 py-1.5 text-base text-gray-900 dark:text-gray-200 placeholder:text-gray-400 sm:text-sm" placeholder="exampleco">
            <div class="flex shrink-0 items-center rounded-r-md bg-gray-100 dark:bg-gray-600 px-3 text-base text-gray-500 dark:text-gray-200 sm:text-sm">
                .{{ env('CENTRAL_DOMAIN') }}
            </div>
        </div>
        @error('domain')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="flex justify-end mt-4">
      <button type="submit" class="inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Create Tenant</submit>
    </div>
  </form>

</x-central-layout>
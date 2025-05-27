<x-central-layout>
  <x-slot name="header">
    <div class="md:flex md:items-center md:justify-between">
      <div class="min-w-0 flex-1">
        <h2 class="text-2xl/7 font-bold dark:text-white text-gray-800 sm:truncate sm:text-3xl sm:tracking-tight">{{ __('Dashboard') }}</h2>
      </div>
    </div>
  </x-slot>

  <div>
    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
      <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm sm:p-6 dark:border border-gray-700 dark:bg-gray-900">
        <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Subscribers</dt>
        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-200">71,897</dd>
      </div>
      <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm sm:p-6 dark:border border-gray-700 dark:bg-gray-900">
        <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">New Subscribers (30 days)</dt>
        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-200">4,642</dd>
      </div>
      <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm sm:p-6 dark:border border-gray-700 dark:bg-gray-900">
        <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Revenue (Monthly)</dt>
        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-200">$ 623,340</dd>
      </div>
    </dl>
  </div>
</x-app-layout>

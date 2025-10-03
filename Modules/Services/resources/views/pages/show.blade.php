<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Service Details') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h3 class="text-lg font-semibold">Service Name: {{ $service->name }}</h3>
        <p><strong>Client:</strong> {{ $service->client->name }}</p>
        <p><strong>Description:</strong> {{ $service->description ?? 'No description provided' }}</p>
        <p><strong>Start Date:</strong> {{ $service->start_date ?? 'Not set' }}</p>
        <p><strong>End Date:</strong> {{ $service->end_date ?? 'Not set' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($service->status) }}</p>




        <div class="mt-6">
            <a href="{{ route('services.index') }}" class="text-blue-500">Back to services</a>
        </div>
        <div class="mt-6">
            <a href="{{ route('services.edit',$service->id) }}" class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 transition">Edit Service</a>
        </div>
    </div>
</x-app-layout>

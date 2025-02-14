<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Project') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" name="name" class="mt-1 p-2 w-full border rounded-lg" required>
            </div>

            <!-- Client -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Client</label>
                <select name="client_id" class="mt-1 p-2 w-full border rounded-lg" required>
                    <option value="">-- Select Client --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 p-2 w-full border rounded-lg" required>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Create Project
            </button>
        </form>
    </div>
</x-app-layout>

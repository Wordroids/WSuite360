<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Project') }}
        </h2>

        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Project Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" name="name" id="name" value="{{ $project->name }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
            </div>

            <!-- Select Client -->
            <div class="mb-4">
                <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                <select name="client_id" id="client_id" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $client->id == $project->client_id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">{{ $project->description }}</textarea>
            </div>

            <!-- Start Date -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ $project->start_date }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <!-- End Date -->
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ $project->end_date }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">
                    <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Update Project
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

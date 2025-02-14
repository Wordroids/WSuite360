<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects List') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <a href="{{ route('projects.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Add Project
        </a>

        <table class="min-w-full bg-white border mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Project</th>
                    <th class="px-4 py-2 border">Client</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $project->name }}</td>
                        <td class="px-4 py-2 border">{{ $project->client->name }}</td>
                        <td class="px-4 py-2 border">{{ ucfirst($project->status) }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('projects.edit', $project->id) }}" class="text-yellow-600">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

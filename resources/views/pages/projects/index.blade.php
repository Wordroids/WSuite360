<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
       

        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Project Name</th>
                    <th class="px-4 py-2 border">Client</th>
                    <th class="px-4 py-2 border">Start Date</th>
                    <th class="px-4 py-2 border">End Date</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Assigned Users</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $project->name }}</td>
                        <td class="px-4 py-2">{{ $project->client->name }}</td>
                        <td class="px-4 py-2">{{ $project->start_date ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $project->end_date ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($project->status) }}</td>
                        <td class="px-4 py-2 text-center font-semibold">{{ $project->members_count }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('projects.edit', $project->id) }}" class="text-blue-500">Edit</a>
                            <a href="{{ route('projects.show', $project->id) }}" class="text-green-500">View</a>
                            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" 
                                class="text-purple-500 font-semibold">+ Create Task</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

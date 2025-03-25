<x-app-layout>

    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col bg-white p-6 rounded-lg shadow-lg mt-10">
            @if (auth()->user()->role->name === 'admin')
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-semibold">Project List</h3>
                    <a href="{{ route('projects.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        + Create Project
                    </a>
                </div>
            @endif

            <!-- Projects Table -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-200">
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
                        @foreach ($projects as $project)
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

            <!-- Pagination -->
            <div class="mt-4">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

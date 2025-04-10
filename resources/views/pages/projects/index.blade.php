<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col mt-5">
            <!-- Success message -->
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (auth()->user()->role && auth()->user()->role->name === 'admin')
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-semibold">Project List</h3>
                    <a href="{{ route('projects.create') }}"
                        class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        + Create Project
                    </a>
                </div>
            @endif

            <!-- Projects Table -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Project Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Client</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Start Date</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">End Date</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Assigned Users</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $project->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $project->client?->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $project->start_date ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $project->end_date ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ ucfirst($project->status) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $project->members_count }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-center">
                                    <a href="{{ route('projects.edit', $project->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <form id="delete-form-{{ $project->id }}"
                                        action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition"
                                        onclick="confirmDeletion({{ $project->id }})">
                                        Delete
                                    </button>

                                    <button type="button"
                                        class="bg-indigo-700 text-white px-3 py-1 rounded-lg hover:bg-indigo-700 transition"
                                        onclick="#">
                                        Add a task
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No projects available.
                                </td>
                            </tr>
                        @endforelse
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

<script>
    //to delete
    function confirmDeletion(projectId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#4338CA',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                document.getElementById(`delete-form-${projectId}`).submit();
            }
        });
    }
</script>

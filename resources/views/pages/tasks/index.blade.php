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

            <!-- Tasks Header -->
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">My Assigned Tasks</h3>
                <div class="flex items-center space-x-4">
                    <!-- Filter by Project -->
                    <form method="GET" action="{{ route('tasks.index') }}" class="flex items-center space-x-2">
                        <select id="project_id" name="project_id" class="border rounded-lg px-4 py-2">
                            <option value="">All Projects</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ $projectId == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-800 transition">
                            Filter
                        </button>
                    </form>

                    <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
                        class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-800 transition">
                        + Create Task
                    </a>
                </div>
            </div>

            <!-- Tasks Table -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Task Title</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Project</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Assigned User</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Start Date</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">End Date</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $task->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $task->project->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ $task->assignedMember->name ?? 'Unassigned' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $task->start_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $task->end_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ ucfirst($task->status) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-center">
                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <form id="delete-task-form-{{ $task->id }}"
                                        action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition"
                                        onclick="confirmTaskDeletion({{ $task->id }})">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No tasks assigned.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Function to confirm task deletion
    function confirmTaskDeletion(taskId) {
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
                document.getElementById(`delete-task-form-${taskId}`).submit();
            }
        });
    }
</script>

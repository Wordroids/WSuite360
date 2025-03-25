<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <div class="flex-1 max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Assigned Tasks') }}
            </h2>
            <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Task Title</th>
                        <th class="px-4 py-2 border">Project</th>
                        <th class="px-4 py-2 border">Assigned User</th>
                        <th class="px-4 py-2 border">Start Date</th>
                        <th class="px-4 py-2 border">End Date</th>
                        <th class="px-4 py-2 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $task->title }}</td>
                            <td class="px-4 py-2">{{ $task->project->name }}</td>
                            <td class="px-4 py-2">
                                {{ $task->assigned_to ? $task->assignedEmployee->name . ' (' . optional($task->assignedEmployee->role)->name . ')' : 'Unassigned' }}
                            </td>
                            <td class="px-4 py-2">{{ $task->start_date }}</td>
                            <td class="px-4 py-2">{{ $task->end_date }}</td>
                            <td class="px-4 py-2">{{ ucfirst($task->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

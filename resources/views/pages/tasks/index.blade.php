<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Management') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <div class="flex justify-between mb-4">
            <h3 class="text-lg font-semibold">Tasks</h3>
            <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Create Task
            </a>
        </div>

        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Project</th>
                    <th class="px-4 py-2 border">Assigned To</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $task->title }}</td>
                        <td class="px-4 py-2">{{ $task->project->name }}</td>
                        <td class="px-4 py-2">
                            {{ $task->assignedEmployee ? $task->assignedEmployee->name : 'Unassigned' }}
                        </td>
                        <td class="px-4 py-2">{{ ucfirst($task->status) }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500">Edit</a>
                            <a href="{{ route('tasks.show', $task->id) }}" class="text-green-500">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

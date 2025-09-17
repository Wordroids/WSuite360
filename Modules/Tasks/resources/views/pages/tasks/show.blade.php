<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Details') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h3 class="text-lg font-semibold">Title: {{ $task->title }}</h3>
        <p><strong>Project:</strong> {{ $task->project->name }}</p>
        <p><strong>Assigned To:</strong> {{ $task->assignedEmployee ? $task->assignedEmployee->name : 'Unassigned' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
        <p><strong>Start Date:</strong> {{ $task->start_date }}</p>
        <p><strong>End Date:</strong> {{ $task->end_date }}</p>
    </div>
</x-app-layout>

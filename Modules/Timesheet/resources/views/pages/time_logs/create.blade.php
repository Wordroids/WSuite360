<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Time for a Task') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <form action="{{ route('time_logs.store') }}" method="POST">
            @csrf

            <!-- Select Task -->
            <div class="mb-4">
                <label for="task_id" class="block text-sm font-medium text-gray-700">Select Task</label>
                <select name="task_id" id="task_id" class="mt-1 p-2 w-full border rounded-lg" required>
                    <option value="">-- Choose Task --</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->name }} ({{ $task->project->name }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Date -->
            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" id="date" class="mt-1 p-2 w-full border rounded-lg" required>
            </div>

            <!-- Time Spent -->
            <div class="mb-4">
                <label for="time_spent" class="block text-sm font-medium text-gray-700">Time Spent (Minutes)</label>
                <input type="number" name="time_spent" id="time_spent" class="mt-1 p-2 w-full border rounded-lg" required>
            </div>

            <!-- Billable Checkbox -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="billable" value="1" checked class="form-checkbox">
                    <span class="ml-2">Billable</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Submit Time Log
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

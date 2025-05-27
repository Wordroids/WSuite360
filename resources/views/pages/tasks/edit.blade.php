
<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>

        <!-- Edit Task Form -->
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Task Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Task Title</label>
                <input type="text" name="title" id="title"
                    class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    required value="{{ old('title', $task->title) }}">
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Project Selection -->
            <div class="mb-4">
                <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                <select name="project_id" id="project_id"
                    class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                    <option value="">Select a Project</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}"
                            {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Assign Employee -->
            <div class="mb-4">
                <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assign to Employee</label>
                <select name="assigned_to" id="assigned_to"
                    class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                    <option value="">Select a Member</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}"
                            {{ old('assigned_to', $task->assigned_to) == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                @error('assigned_to') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Start Date -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" id="start_date"
                    class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    required value="{{ old('start_date', $task->start_date) }}">
                @error('start_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- End Date -->
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="end_date" id="end_date"
                    class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    required value="{{ old('end_date', $task->end_date) }}">
                @error('end_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Update Task
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

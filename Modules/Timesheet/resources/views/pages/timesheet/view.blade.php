<x-app-layout>

    <div class="bg-white shadow-lg rounded-lg p-6 ">
        <h2 class="text-xl font-semibold mb-4">Time Entry Details</h2>
        <div class="mb-4">
            <p class="text-gray-700 font-semibold">Time and Date:</p>
            <p class="text-gray-600">1:00 (00:55 - 01:55) | 19/03/2025</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 font-semibold">Description:</p>
            <p class="text-gray-600">Worked on project tasks and bug fixes.</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 font-semibold">Project:</p>
            <p class="text-gray-600">Project A</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 font-semibold">Tags:</p>
            <p class="text-gray-600">Development, Bug Fix</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 font-semibold">Billable:</p>
            <p class="text-gray-600">Yes</p>
        </div>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('timesheet.edit') }}" class="px-4 py-2 text-gray-700 border rounded">Edit</a>
            <button class="px-4 py-2 bg-red-500 text-white rounded">Delete</button>
        </div>
    </div>

</x-app-layout>

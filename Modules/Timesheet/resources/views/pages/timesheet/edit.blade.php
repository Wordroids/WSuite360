<x-app-layout>

    <div class="bg-white shadow-lg rounded-lg p-6 ">
        <h2 class="text-xl font-semibold mb-4">Edit time entry</h2>
        <form action="#" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Time and date</label>
                <div class="flex space-x-2">
                    <input type="text" class="w-1/3 p-2 border rounded" placeholder="1:00">
                    <input type="text" class="w-1/3 p-2 border rounded" placeholder="00:55">
                    <input type="text" class="w-1/3 p-2 border rounded" placeholder="01:55">
                    <input type="date" class="p-2 border rounded" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea class="w-full p-2 border rounded" placeholder="What have you worked on?"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Project <span class="text-red-500">*</span></label>
                <select class="w-full p-2 border rounded">
                    <option>Select Project</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Tags</label>
                <select class="w-full p-2 border rounded">
                    <option>Add tags</option>
                </select>
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" id="billable" class="mr-2">
                <label for="billable" class="text-gray-700">Billable</label>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 text-gray-700 border rounded"
                    onclick="window.location.href='{{ route('timesheet.listView') }}'">Cancel</button>

                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
            </div>
        </form>
    </div>

</x-app-layout>

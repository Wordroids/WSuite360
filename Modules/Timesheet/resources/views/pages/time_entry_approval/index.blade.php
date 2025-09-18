<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Time Entry Approvals</h1>

        <!-- Tab Navigation -->
        <div class="mb-4 flex border-b">
            <button onclick="window.location.href='{{ route('pages.time_entry_approval.index') }}'"
                class="px-4 py-2 text-sm font-medium text-indigo-700 border-b-2 border-indigo-700">All</button>
            <button onclick="window.location.href='{{ route('pages.time_entry_approval.pending') }}'"
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-700">Pending</button>
            <button onclick="window.location.href='{{ route('pages.time_entry_approval.approved') }}'"
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-700">Approved</button>
            <button onclick="window.location.href='{{ route('pages.time_entry_approval.rejected') }}'"
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-700">Rejected</button>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-5 gap-4 mb-4 items-center">
            <select class="p-2 border border-gray-300 rounded-lg text-sm text-gray-800">
                <option>Team</option>
            </select>
            <select class="p-2 border border-gray-300 rounded-lg text-sm text-gray-800">
                <option>Client</option>
            </select>
            <select class="p-2 border border-gray-300 rounded-lg text-sm text-gray-800">
                <option>Project</option>
            </select>
            <input type="date" class="p-2 border border-gray-300 rounded-lg text-sm text-gray-800">
            <button class="w-full py-2 bg-indigo-700 text-white text-sm rounded-lg hover:bg-indigo-800 transition">Apply
                Filter</button>
        </div>

        <!-- Time Entries Table -->
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full table-auto border-collapse border border-gray-200 text-sm text-gray-800">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 border-b">Employee</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 border-b">Date</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 border-b">Project</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 border-b">Hours</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 border-b">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4 border">John Doe</td>
                        <td class="px-6 py-4 border">2025-02-24</td>
                        <td class="px-6 py-4 border">Attendance App</td>
                        <td class="px-6 py-4 border">8:00</td>
                        <td class="px-6 py-4 border text-indigo-700">Approved</td>
                        <td class="px-6 py-4 border flex space-x-2">
                            <button
                                class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Pending</button>
                            <button
                                class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Reject</button>
                        </td>
                    </tr>
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4 border">Jane Smith</td>
                        <td class="px-6 py-4 border">2025-02-25</td>
                        <td class="px-6 py-4 border">JDM - Infinity Code</td>
                        <td class="px-6 py-4 border">6:30</td>
                        <td class="px-6 py-4 border text-yellow-600">Pending</td>
                        <td class="px-6 py-4 border flex space-x-2">
                            <button
                                class="px-3 py-1 bg-indigo-700 text-white rounded-lg hover:bg-indigo-800 transition">Approve</button>
                            <button
                                class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Reject</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

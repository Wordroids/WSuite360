<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <div class="flex-1 flex flex-col mt-5">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Leave Balance Report</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('leave-applications.index') }}"
                        class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Back to Applications
                    </a>
                    <a href="{{ route('leave-applications.leave-balance', array_merge(request()->all(), ['export' => 'pdf'])) }}"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Export to PDF
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <form method="GET" action="{{ route('leave-applications.leave-balance') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                        <select name="department_id" id="department_id" class="mt-1 p-2 w-full border rounded-lg">
                            <option value="">All Departments</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="leave_type_id" class="block text-sm font-medium text-gray-700">Leave Type</label>
                        <select name="leave_type_id" id="leave_type_id" class="mt-1 p-2 w-full border rounded-lg">
                            <option value="">All Types</option>
                            @foreach ($leaveTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ request('leave_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="mt-1 p-2 w-full border rounded-lg">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="mt-1 p-2 w-full border rounded-lg">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Filter
                        </button>
                        <a href="{{ route('leave-applications.leave-balance') }}"
                            class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Leave Balance Table -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Employee</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Department</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Leave Type</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Allocated</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Used</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            @if ($employee->leave_breakdown->count() > 0)
                                @foreach ($employee->leave_breakdown as $balance)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            {{ $employee->full_name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            {{ $employee->department->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            {{ $balance['leave_type'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            {{ $balance['allocated'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            {{ $balance['used'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            <span
                                                class="{{ $balance['remaining'] < 0 ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $balance['remaining'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="bg-white hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-800" colspan="6">
                                        No leave balance information available for {{ $employee->full_name }}
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No employees found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

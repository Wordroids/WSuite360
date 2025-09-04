<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <div class="flex-1 flex flex-col mt-5">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Leave Applications</h3>
                <div class="flex space-x-2">
                    @if (in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
                <a href="{{ route('leave-applications.create') }}"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    + New Application
                </a>
                    <a href="{{ route('leave-applications.report') }}"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center0">
                        + Generate Report
                    </a>
                    <a href="{{ route('leave-applications.leave-balance') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Leave Balance Report
                    </a>
                    @elseif (auth()->user()->role->name !== 'guest')
                        <a href="{{ route('leave-applications.create') }}"
                            class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            + Request Leave
                        </a>
                    @endif
                </div>
            </div>

            <!-- Filters - Only show for admin/HR -->
            @if (in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee</label>
                        <select name="employee_id" id="employee_id" class="mt-1 p-2 w-full border rounded-lg">
                            <option value="">All Employees</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }}
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
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 p-2 w-full border rounded-lg">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Filter
                        </button>
                        <a href="{{ route('leave-applications.index') }}"
                            class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
            @endif

            <!-- Leave Applications Table -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if (in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Employee</th>
                            @endif
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Leave Type</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Dates</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Days</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leaveApplications as $leaveApplication)
                            <tr class="bg-white hover:bg-gray-50">
                                @if (in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ $leaveApplication->employee->full_name }}
                                </td>
                                @endif
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $leaveApplication->leaveType->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ $leaveApplication->start_date->format('d M Y') }} -
                                    {{ $leaveApplication->end_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $leaveApplication->days_requested }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    <div class="flex flex-col">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs
                                            {{ $leaveApplication->status == 'approved'
                                                ? 'bg-green-100 text-green-800'
                                                : ($leaveApplication->status == 'rejected'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($leaveApplication->status) }}
                                        </span>
                                        @if ($leaveApplication->status == 'rejected' && $leaveApplication->rejection_reason)
                                            <span class="text-xs text-gray-500 mt-1">Reason:
                                                {{ $leaveApplication->rejection_reason }}</span>
                                        @endif
                                        @if ($leaveApplication->status == 'approved' && $leaveApplication->approved_at)
                                            <span class="text-xs text-gray-500 mt-1">Approved:
                                                {{ $leaveApplication->approved_at->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2">
                                    <a href="{{ route('leave-applications.show', $leaveApplication) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition">
                                        View
                                    </a>
                                    @if (in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
                                        <a href="{{ route('leave-applications.show', $leaveApplication) }}#statusModal"
                                            class="bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700 transition">
                                            Edit Status
                                        </a>
                                    @endif
                                    @if ($leaveApplication->status == 'pending' && in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
                                        <form action="{{ route('leave-applications.approve', $leaveApplication) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition">
                                                Approve
                                            </button>
                                        </form>
                                        <button onclick="openRejectModal({{ $leaveApplication->id }})"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                            Reject
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ in_array(auth()->user()->role->name, ['admin', 'hr_manager']) ? '6' : '5' }}" class="px-6 py-4 text-center text-gray-500">
                                    No leave applications found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $leaveApplications->links() }}
            </div>
        </div>
    </div>

    <!-- Reject Modal - Only for admin/HR -->
    @if (in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Leave Application</h3>
                <form id="rejectForm" method="POST" class="mt-2">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="3"
                            class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required></textarea>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Submit Rejection
                        </button>
                        <button type="button" onclick="closeRejectModal()"
                            class="ml-3 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script>
        function openRejectModal(applicationId) {
            document.getElementById('rejectForm').action = `/leave-applications/${applicationId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>

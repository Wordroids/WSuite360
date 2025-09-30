<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <div class="flex justify-between items-center mb-5">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Application Details
            </h2>
            <a href="{{ route('leave-applications.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                Back to List
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Application Details -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium mb-4">Application Information</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Employee</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaveApplication->employee->full_name }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Leave Type</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaveApplication->leaveType->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Dates</p>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $leaveApplication->start_date->format('d M Y') }} to
                            {{ $leaveApplication->end_date->format('d M Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Days Requested</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $leaveApplication->days_requested }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="mt-1 text-sm text-gray-900">
                            <span
                                class="px-2 py-1 rounded-full text-xs
                                {{ $leaveApplication->status == 'approved'
                                    ? 'bg-green-100 text-green-800'
                                    : ($leaveApplication->status == 'rejected'
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($leaveApplication->status) }}
                            </span>
                        </p>
                    </div>

                    @if ($leaveApplication->status == 'approved')
                        <div>
                            <p class="text-sm font-medium text-gray-500">Approved By</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $leaveApplication->approver->name ?? 'System' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Approved At</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $leaveApplication->approved_at ? $leaveApplication->approved_at->format('d M Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    @endif

                    @if ($leaveApplication->status == 'rejected' && $leaveApplication->rejection_reason)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Rejection Reason</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $leaveApplication->rejection_reason }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Rejected By</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $leaveApplication->rejecter->name ?? 'System' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Rejected At</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $leaveApplication->rejected_at ? $leaveApplication->rejected_at->format('d M Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reason -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium mb-4">Reason for Leave</h3>
                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $leaveApplication->reason }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            @if (in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
                <button onclick="openStatusModal()"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Edit Status
                </button>
            @endif

            @if ($leaveApplication->status == 'pending' && in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
                <form action="{{ route('leave-applications.approve', $leaveApplication) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200">
                        Approve Application
                    </button>
                </form>
                <button onclick="openRejectModal()"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200">
                    Reject Application
                </button>
            @endif
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Leave Status</h3>
                <form action="{{ route('leave-applications.update-status', $leaveApplication) }}" method="POST"
                    class="mt-2">
                    @csrf
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                            <option value="pending" {{ $leaveApplication->status == 'pending' ? 'selected' : '' }}>
                                Pending</option>
                            <option value="approved" {{ $leaveApplication->status == 'approved' ? 'selected' : '' }}>
                                Approved</option>
                            <option value="rejected" {{ $leaveApplication->status == 'rejected' ? 'selected' : '' }}>
                                Rejected</option>
                        </select>
                    </div>
                    <div class="mb-4 {{ $leaveApplication->status != 'rejected' ? 'hidden' : '' }}" id="reasonField">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <textarea name="reason" id="reason" rows="3"
                            class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">{{ $leaveApplication->rejection_reason }}</textarea>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            Update Status
                        </button>
                        <button type="button" onclick="closeStatusModal()"
                            class="ml-3 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Leave Application</h3>
                <form action="{{ route('leave-applications.reject', $leaveApplication) }}" method="POST"
                    class="mt-2">
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

    <script>
        function openStatusModal() {
            document.getElementById('statusModal').classList.remove('hidden');

            // Show/hide reason field based on current status
            const statusSelect = document.getElementById('status');
            const reasonField = document.getElementById('reasonField');

            statusSelect.addEventListener('change', function() {
                if (this.value === 'rejected') {
                    reasonField.classList.remove('hidden');
                } else {
                    reasonField.classList.add('hidden');
                }
            });
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

      
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash === '#statusModal') {
                openStatusModal();
            }
        });
    </script>
</x-app-layout>

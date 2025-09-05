<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Leave Application') }}
        </h2>

        <form action="{{ route('leave-applications.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Employee - Only show for admin/HR -->
                @if(in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
                <div class="mb-4">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee</label>
                    <select name="employee_id" id="employee_id"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                        <option value="">Select Employee</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->full_name }} ({{ $employee->employee_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @else
                    <!-- Hidden input for employee ID for non-admin users -->
                    <input type="hidden" name="employee_id" value="{{ auth()->user()->employeeProfile->id }}">
                @endif

                <!-- Leave Type -->
                <div class="mb-4">
                    <label for="leave_type_id" class="block text-sm font-medium text-gray-700">Leave Type</label>
                    <select name="leave_type_id" id="leave_type_id"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                        <option value="">Select Leave Type</option>
                        @foreach ($leaveTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} ({{ $type->default_entitlement }} days)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Date -->
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <!-- End Date -->
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <!-- Reason -->
                <div class="mb-4 md:col-span-2">
                    <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                    <textarea name="reason" id="reason" rows="3"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>{{ old('reason') }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    @if(in_array(auth()->user()->role->name, ['admin', 'hr_manager']))
                    Submit Application
                    @else
                        Request Leave
                    @endif
                </button>
                <a href="{{ route('leave-applications.index') }}"
                    class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            // Set minimum date to today for both fields
            const today = new Date().toISOString().split('T')[0];
            startDateInput.min = today;
            endDateInput.min = today;

            // When start date changes, update end date min
            startDateInput.addEventListener('change', function() {
                endDateInput.min = this.value;
                if (endDateInput.value && endDateInput.value < this.value) {
                    endDateInput.value = this.value;
                }
            });
        });
    </script>
</x-app-layout>

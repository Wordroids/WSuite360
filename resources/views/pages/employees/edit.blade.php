<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Employee: ') . $employee->full_name }}
        </h2>

        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- User Account Fields -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name (User Account)*</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $employee->user->name) }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">User Email*</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $employee->user->email) }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <!-- Employee Profile Fields -->
                <div class="mb-4">
                    <label for="employee_code" class="block text-sm font-medium text-gray-700">Employee Code</label>
                    <input type="text" id="employee_code" value="{{ $employee->employee_code }}" class="mt-1 p-2 w-full border rounded-lg bg-gray-100" readonly>
                </div>

                <div class="mb-4">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name*</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $employee->first_name) }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <div class="mb-4">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name*</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $employee->last_name) }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone) }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                <div class="mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department*</label>
                    <select name="department_id" id="department_id" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="designation_id" class="block text-sm font-medium text-gray-700">Designation*</label>
                    <select name="designation_id" id="designation_id" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                        <option value="">Select Designation</option>
                        @foreach ($designations as $designation)
                            <option value="{{ $designation->id }}"
                                {{ $employee->designation_id == $designation->id ? 'selected' : '' }}>
                                {{ $designation->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="date_of_joining" class="block text-sm font-medium text-gray-700">Date of Joining*</label>
                    <input type="date" name="date_of_joining" id="date_of_joining" value="{{ $employee->date_of_joining->format('Y-m-d') }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Update Employee
                </button>
                <a href="{{ route('employees.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#department_id').change(function() {
            var departmentId = $(this).val();
            if (departmentId) {
                $.ajax({
                    url: "{{ route('employees.getDesignations') }}",
                    type: "GET",
                    data: {'department_id': departmentId},
                    success: function(data) {
                        $('#designation_id').empty();
                        $('#designation_id').append('<option value="">Select Designation</option>');
                        $.each(data, function(key, value) {
                            $('#designation_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#designation_id').empty();
                $('#designation_id').append('<option value="">Select Department First</option>');
            }
        });
    });
</script>
@endpush
</x-app-layout>

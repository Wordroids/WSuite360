<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Employee') }}
        </h2>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- User Account Fields -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name (User
                        Account)*</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required
                        value="{{ old('name') }}">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">User Email*</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required
                        value="{{ old('email') }}">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password*</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password*</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <div class="mb-4">
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Role*</label>
                    <select name="role_id" id="role_id"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                        <option value="">Select Role</option>
                        @foreach (\App\Models\Role::all() as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Employee Profile Fields -->
                <div class="mb-4">
                    <label for="employee_code" class="block text-sm font-medium text-gray-700">Employee Code*</label>
                    <input type="text" name="employee_code" id="employee_code" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required
                        value="{{ old('employee_code') }}">
                </div>

                <div class="mb-4">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name*</label>
                    <input type="text" name="first_name" id="first_name" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required
                        value="{{ old('first_name') }}">
                </div>

                <div class="mb-4">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name*</label>
                    <input type="text" name="last_name" id="last_name" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required
                        value="{{ old('last_name') }}">
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                        value="{{ old('phone') }}">
                </div>

                <div class="mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department*</label>
                    <select name="department_id" id="department_id" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('department_id') == $department->id ? 'selected' : '' }}> {{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="designation_id" class="block text-sm font-medium text-gray-700">Designation*</label>
                    <select name="designation_id" id="designation_id" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                        <option value="">Select Department First</option>
                        @if (old('department_id'))
                            @php
                                $designations = \App\Models\Designation::where(
                                    'department_id',
                                    old('department_id'),
                                )->get();
                            @endphp
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}"
                                    {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                    {{ $designation->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-4">
                    <label for="date_of_joining" class="block text-sm font-medium text-gray-700">Date of Joining*</label>
                    <input type="date" name="date_of_joining" id="date_of_joining" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required
                        value="{{ old('date_of_joining') }}">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Save Employee
                </button>
                <a href="{{ route('employees.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
            // Check if department select exists
            var departmentSelect = $('#department_id');
            if (departmentSelect.length) {
                departmentSelect.change(function() {
                    var departmentId = $(this).val();
                    var designationSelect = $('#designation_id');

                    if (designationSelect.length) {
        if (departmentId) {
            var url = "{{ route('employees.get-designations', ':id') }}".replace(':id',
 departmentId);

            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    designationSelect.empty();
                    designationSelect.append('<option value="">Select Designation</option>');
                    $.each(data, function(key, value) {
                        designationSelect.append('<option value="'+ value.id + '">' + value.name +'</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    console.log(xhr.responseText);
                                    designationSelect.empty();
                                    designationSelect.append(
                                        '<option value="">Error loading designations</option>'
                                        );
                }
            });
        } else {
            designationSelect.empty();
            designationSelect.append('<option value="">Select Department First</option>');
        }
        }
    });

                @if (old('department_id'))
                    departmentSelect.trigger('change');
                @endif
            }
});
</script>
</x-app-layout>

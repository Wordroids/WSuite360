<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Employee: ') . $employee->full_name }}
        </h2>

        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Employee Code (readonly) -->
                <div class="mb-4">
                    <label for="employee_code" class="block text-sm font-medium text-gray-700">Employee Code</label>
                    <input type="text" id="employee_code" value="{{ $employee->employee_code }}" class="mt-1 p-2 w-full border rounded-lg bg-gray-100" readonly>
                </div>

                <!-- First Name -->
                <div class="mb-4">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name*</label>
                    <input type="text" name="first_name" id="first_name" value="{{ $employee->first_name }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <!-- Last Name -->
                <div class="mb-4">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name*</label>
                    <input type="text" name="last_name" id="last_name" value="{{ $employee->last_name }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
                    <input type="email" name="email" id="email" value="{{ $employee->email }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ $employee->phone }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                <!-- Department -->
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

                <!-- Designation -->
                <div class="mb-4">
                    <label for="designation" class="block text-sm font-medium text-gray-700">Designation*</label>
                    <input type="text" name="designation" id="designation" value="{{ $employee->designation }}" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                </div>

                <!-- Date of Joining -->
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
</x-app-layout>

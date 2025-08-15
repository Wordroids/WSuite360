<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Details: ') . $employee->full_name }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-700">Employee Code</p>
                    <p class="text-sm text-gray-800">{{ $employee->employee_code }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Name</p>
                    <p class="text-sm text-gray-800">{{ $employee->full_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Email</p>
                    <p class="text-sm text-gray-800">{{ $employee->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Phone</p>
                    <p class="text-sm text-gray-800">{{ $employee->phone ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-700">Department</p>
                    <p class="text-sm text-gray-800">{{ $employee->department->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Designation</p>
                    <p class="text-sm text-gray-800">{{ $employee->designation->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Date of Joining</p>
                    <p class="text-sm text-gray-800">{{ $employee->date_of_joining->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Status</p>
                    <span
                        class="px-2 py-1 rounded-full text-xs {{ $employee->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($employee->status) }}
                    </span>
                </div>
                @if ($employee->status == 'inactive')
                    <div>
                        <p class="text-sm font-medium text-gray-700">Inactive Reason</p>
                        <p class="text-sm text-gray-800">{{ $employee->inactive_reason }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('employees.edit', $employee) }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                Edit
            </a>
            <a href="{{ route('employees.index') }}"
                class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                Back to List
            </a>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Department Details: ') . $department->name }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-700">Name</p>
                    <p class="text-sm text-gray-800">{{ $department->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Description</p>
                    <p class="text-sm text-gray-800">{{ $department->description ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-700">Total Employees</p>
                    <p class="text-sm text-gray-800">{{ $department->employees_count }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Created At</p>
                    <p class="text-sm text-gray-800">{{ $department->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Last Updated</p>
                    <p class="text-sm text-gray-800">{{ $department->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        @if($department->employees_count > 0)
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Employees in this Department</h3>
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <ul class="divide-y divide-gray-200">
                        @foreach($department->employees as $employee)
                            <li class="px-4 py-3 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('employees.show', $employee) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $employee->full_name }}
                                    </a>
                                    <span class="px-2 py-1 text-xs font-semibold bg-indigo-100 text-indigo-800 rounded-full">
                                        {{ $employee->designation }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="flex justify-end space-x-2">
            <a href="{{ route('departments.edit', $department) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                Edit
            </a>
            <a href="{{ route('departments.index') }}" class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                Back to List
            </a>
        </div>
    </div>
</x-app-layout>

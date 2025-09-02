<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <div class="flex-1 flex flex-col mt-5">
            <!-- Success message -->
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

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">Employee </h3>
                <div class="flex space-x-2">
                    <form action="{{ route('employees.export') }}" method="GET" class="flex items-center">
                        @foreach (request()->all() as $key => $value)
                            @if ($key !== '_token' && $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Export to PDF
                        </button>
                    </form>
                <a href="{{ route('employees.create') }}"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    + Add New Employee
                </a>
                </div>
            </div>

            <!-- Filter Form -->
            <div class=" p-4 mb-8">
                <form action="{{ route('employees.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                        <select id="department_id" name="department_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                        <label for="designation_id" class="block text-sm font-medium text-gray-700">Designation</label>
                        <select id="designation_id" name="designation_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Designations</option>
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}"
                                    {{ request('designation_id') == $designation->id ? 'selected' : '' }}>
                                    {{ $designation->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
            </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Filter
                        </button>
                        @if (request()->hasAny(['department_id', 'designation_id', 'status']))
                            <a href="{{ route('employees.index') }}"
                                class="ml-2 bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <!-- Employees Table -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Employee Code
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">User Email</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Department</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Designation</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Date of Joining
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->employee_code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->full_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->user->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->department->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->designation->name ?? 'N/A'}}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ $employee->date_of_joining->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs {{ $employee->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($employee->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2">
                                    <a href="{{ route('employees.show', $employee) }}"
                                        class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 transition">
                                        View
                                    </a>
                                    <a href="{{ route('employees.edit', $employee) }}"
                                        class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 transition">
                                        Edit
                                    </a>
                                    @if ($employee->status == 'active')
                                        <a href="{{ route('employees.deactivate.form', $employee) }}"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                            Deactivate
                                        </a>
                                    @else
                                        <form action="{{ route('employees.reactivate', $employee) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition">
                                                Reactivate
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('employees.documents.index', $employee) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition">
                                        Documents
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No employees available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

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
                <h3 class="text-lg font-semibold">Employee Directory</h3>
                <a href="{{ route('employees.create') }}"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    + Add New Employee
                </a>
            </div>

            <!-- Employees Table -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Employee Code
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Name</th>
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
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->department->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->designation }}</td>
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

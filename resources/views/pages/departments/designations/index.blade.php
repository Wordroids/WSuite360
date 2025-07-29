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

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">Designations for {{ $department->name }}</h3>
                <a href="{{ route('departments.designations.create', $department) }}"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    + Add New Designation
                </a>
            </div>

            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Description</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Employee Count</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($designations as $designation)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $designation->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $designation->description ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $designation->employees_count }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2">
                                    <a href="{{ route('departments.designations.edit', [$department, $designation]) }}"
                                        class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('departments.designations.destroy', [$department, $designation]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition"
                                            onclick="return confirm('Are you sure you want to delete this designation?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No designations available for this department.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $designations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

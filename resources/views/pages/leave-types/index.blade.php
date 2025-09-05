<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <div class="flex-1 flex flex-col mt-5">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">Leave Types</h3>
                <a href="{{ route('leave-types.create') }}"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    + Add New Leave Type
                </a>
            </div>

            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Default
                                Entitlement (Days)</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leaveTypes as $leaveType)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $leaveType->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $leaveType->default_entitlement }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs {{ $leaveType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $leaveType->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2">
                                    <a href="{{ route('leave-types.edit', $leaveType) }}"
                                        class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('leave-types.destroy', $leaveType) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this leave type?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No leave types found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $leaveTypes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

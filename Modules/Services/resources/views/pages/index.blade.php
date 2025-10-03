<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col mt-5">
            <!-- Success message -->
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (auth()->user()->role && auth()->user()->role->name === 'admin')
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-semibold">Service List</h3>
                    <a href="{{ route('services.create') }}"
                        class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        + Create Service
                    </a>
                </div>
            @endif

            <!-- Projects Table -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Service Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Client</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Start Date</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">End Date</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $service->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $service->client?->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $service->start_date ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $service->end_date ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ ucfirst($service->status) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-center">
                                    <a href="{{ route('services.show', $service->id) }}"
                                        class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 transition">
                                     View
                                    </a>
                                    <a href="{{ route('services.edit', $service->id) }}"
                                        class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 transition">
                                        Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <form id="delete-form-{{ $service->id }}"
                                        action="{{ route('services.destroy', $service->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition"
                                        onclick="confirmDeletion({{ $service->id }})">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No services available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    //to delete
    function confirmDeletion(serviceId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#4338CA',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                document.getElementById(`delete-form-${serviceId}`).submit();
            }
        });
    }
</script>

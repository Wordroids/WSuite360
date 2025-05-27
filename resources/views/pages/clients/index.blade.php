<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-5 mb-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ __('Clients List') }}
                </h2>
                <a href="{{ route('clients.create') }}"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    + Add Client
                </a>
            </div>

            <!-- Clients Table -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">#</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Phone</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Address</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Company</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800 text-center">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $client->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $client->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $client->phone }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $client->address }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $client->company->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-center">
                                    <a href="{{ route('clients.edit', $client->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <form id="delete-form-{{ $client->id }}"
                                        action="{{ route('clients.destroy', $client->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition"
                                        onclick="confirmDeletion({{ $client->id }})">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No clients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $clients->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

<!-- To confirm delete -->
<script>
    function confirmDeletion(clientId) {
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
                document.getElementById(`delete-form-${clientId}`).submit();
            }
        });
    }
</script>

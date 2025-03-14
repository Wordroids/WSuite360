<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col items-center justify-start bg-gray-100">
            <div class="w-3/4 bg-white p-6 rounded-lg shadow-lg mt-10">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Clients List') }}
                </h2>
                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Add New Client Button -->
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('clients.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        + Add Client
                    </a>
                </div>

                <!-- Clients Table -->
                <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Phone</th>
                                <th class="px-4 py-2 border">Address</th>
                                <th class="px-4 py-2 border">Company</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr class="border-t">
                                    <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $client->name }}</td>
                                    <td class="px-4 py-2">{{ $client->email }}</td>
                                    <td class="px-4 py-2">{{ $client->phone }}</td>
                                    <td class="px-4 py-2">{{ $client->address }}</td>
                                    <td class="px-4 py-2">{{ $client->company->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 flex space-x-2 justify-center">
                                        <a href="{{ route('clients.edit', $client->id) }}"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this client?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">No clients found.
                                    </td>
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
    </div>
</x-app-layout>

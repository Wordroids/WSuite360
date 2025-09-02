<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Users</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="verflow-x-auto rounded-lg shadow">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($users as $user)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $user->name }}</td>
                            <td class="py-3 px-6 text-left">{{ $user->email }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="bg-indigo-700 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-600">
                                        View
                                    </a>
                                     @if(Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded-md text-sm hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    @endif
                                    <form id="delete-form-{{ $user->id }}"
                                        action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                     @if(Auth::user()->hasRole('admin'))
                                    <button type="button"
                                        class="bg-red-500 text-white px-3 py-1 rounded-md text-sm hover:bg-red-600"
                                        onclick="confirmDeletion({{ $user->id }})">
                                        Delete
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Confirm Deletion Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDeletion(userId) {
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
                    document.getElementById(`delete-form-${userId}`).submit();
                }
            });
        }
    </script>
</x-app-layout>

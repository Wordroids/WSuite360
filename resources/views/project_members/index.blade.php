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
                    {{ __('Project Members List') }}
                </h2>
                <a href="{{ route('project_members.create') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    + Add Project Member
                </a>
            </div>


            <!-- Team Members Table -->
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">#</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Role</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Group</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projectMembers as $member)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800 text-center">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $member->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $member->role }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $member->group }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $member->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-center">
                                    <!-- Edit Button -->
                                    <a href="{{ route('project_members.edit', $member->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <form id="delete-form-{{ $member->id }}"
                                        action="{{ route('project_members.destroy', $member->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <button type="button"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition"
                                        onclick="confirmDeletion({{ $member->id }})">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No members found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $projectMembers->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

<!-- To confirm delete -->
<script>
    function confirmDeletion(memberId) {
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
                document.getElementById(`delete-form-${memberId}`).submit();
            }
        });
    }
</script>

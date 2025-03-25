<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <div class="flex-1">
            <div class="mx-auto bg-white p-6 rounded-lg shadow-lg mt-10 min-h-[75vh]">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    {{ __('Companies List') }}
                </h2>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Add New Company Button -->
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('companies.create') }}"
                        class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                        + Add Company
                    </a>
                </div>

                <!-- Companies Table -->
                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">#</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Logo</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Website</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                                <tr class="bg-white hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-800 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 flex justify-center">
                                        @if ($company->logo)
                                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo"
                                                class="w-10 h-10 rounded-full border border-gray-300">
                                        @else
                                            <span class="text-gray-500">No Logo</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $company->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $company->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        @if ($company->website)
                                            <a href="{{ $company->website }}" target="_blank"
                                                class="text-indigo-700 hover:underline">
                                                {{ parse_url($company->website)['host'] }}
                                            </a>
                                        @else
                                            <span class="text-gray-500">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-center">
                                        <a href="{{ route('companies.edit', $company->id) }}"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                        <!-- Delete Button -->
                                        <form id="delete-form-{{ $company->id }}"
                                            action="{{ route('companies.destroy', $company->id) }}"
                                            method="POST"
                                            style="display: none;">
                                          @csrf
                                          @method('DELETE')
                                      </form>

                                      <button type="button"
                                              class="bg-red-500 text-white px-2 py-1 rounded"
                                              onclick="confirmDeletion({{ $company->id }})">
                                          Delete
                                      </button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No companies found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!--to confirm delete-->
<script>
    function confirmDeletion(companyId) {
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
                document.getElementById(`delete-form-${companyId}`).submit();
            }
        });
    }
</script>

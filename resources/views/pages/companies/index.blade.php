<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies List') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add New Company Button -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('companies.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                + Add Company
            </a>
        </div>

        <!-- Companies Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Logo</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Website</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 flex justify-center">
                                @if($company->logo)
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class="w-12 h-12 rounded-lg">
                                @else
                                    <span class="text-gray-500">No Logo</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $company->name }}</td>
                            <td class="px-4 py-2">{{ $company->email }}</td>
                            <td class="px-4 py-2">
                                @if($company->website)
                                    <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ parse_url($company->website)['host'] }}
                                    </a>
                                @else
                                    <span class="text-gray-500">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 flex space-x-2 justify-center">
                                <a href="{{ route('companies.edit', $company->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">No companies found.</td>
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
</x-app-layout>

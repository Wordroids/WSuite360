<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Documents for ') . $employee->full_name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('employees.documents.create', $employee) }}"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Upload Document
                </a>
                <a href="{{ route('employees.show', $employee) }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    Back to Employee
                </a>
            </div>
        </div>

        @if ($documents->isEmpty())
            <div class="p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded">
                No documents found for this employee.
            </div>
        @else
            <div class="overflow-x-auto rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Document Type
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">File Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Size</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Uploaded By</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Uploaded At</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $document->document_type }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $document->file_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ round($document->file_size / 1024, 2) }}
                                    KB</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $document->uploader->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ $document->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2">
                                    <a href="{{ route('employees.documents.show', [$employee, $document]) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition"
                                        download>
                                        Download
                                    </a>
                                    <form action="{{ route('employees.documents.destroy', [$employee, $document]) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition"
                                            onclick="return confirm('Are you sure you want to delete this document?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>

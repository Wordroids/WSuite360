<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Document for ') . $employee->full_name }}
        </h2>

        <form action="{{ route('employees.documents.store', $employee) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="document_type" class="block text-sm font-medium text-gray-700">Document Type*</label>
                    <select name="document_type" id="document_type"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                        <option value="">Select Document Type</option>
                        <option value="Resume">Resume</option>
                        <option value="Contract">Contract</option>
                        <option value="ID Proof">ID Proof</option>
                        <option value="Educational Certificate">Educational Certificate</option>
                        <option value="Experience Letter">Experience Letter</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="document" class="block text-sm font-medium text-gray-700">Document File*</label>
                    <input type="file" name="document" id="document"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300 @error('document') border-red-500 @enderror"
                        required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    @error('document')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Allowed file types: PDF, JPG, JPEG, PNG, DOC, DOCX. Max size:
                        2MB</p>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-2">
                <button type="submit"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Upload Document
                </button>
                <a href="{{ route('employees.documents.index', $employee) }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

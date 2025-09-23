<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Designation for ') . $department->name }}
        </h2>

        <form action="{{ route('departments.designations.store', $department) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Designation Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300 @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">{{ old('description') }}</textarea>
                </div>

                <input type="hidden" name="department_id" value="{{ $department->id }}">
            </div>

            <div class="flex justify-end mt-6 space-x-2">
                <button type="submit"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Create Designation
                </button>
                <a href="{{ route('departments.designations.index', $department) }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

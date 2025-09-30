<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Leave Type: ') . $leaveType->name }}
        </h2>

        <form action="{{ route('leave-types.update', $leaveType) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name*</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $leaveType->name) }}"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Default Entitlement -->
                <div class="mb-4">
                    <label for="default_entitlement" class="block text-sm font-medium text-gray-700">Default Entitlement
                        (Days)*</label>
                    <input type="number" name="default_entitlement" id="default_entitlement"
                        value="{{ old('default_entitlement', $leaveType->default_entitlement) }}" min="0"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                    @error('default_entitlement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4 md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">{{ old('description', $leaveType->description) }}</textarea>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="is_active" id="is_active"
                        class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300">
                        <option value="1" {{ old('is_active', $leaveType->is_active) ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ !old('is_active', $leaveType->is_active) ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Update Leave Type
                </button>
                <a href="{{ route('leave-types.index') }}"
                    class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

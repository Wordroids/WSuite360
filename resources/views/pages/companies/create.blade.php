<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h1 class="text-2xl font-bold mb-4">Add a Company</h1>
        <!-- Company Form -->
        <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    required value="{{ old('name') }}">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Company Email</label>
                <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    required value="{{ old('email') }}">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Logo -->
            <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700">Company Logo (Optional)</label>
                <input type="file" name="logo" id="logo" class="mt-1 p-2 w-full border rounded-lg">
                @error('logo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Website -->
            <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-gray-700">Website (Optional)</label>
                <input type="url" name="website" id="website" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    value="{{ old('website') }}">
                @error('website') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Create Company
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

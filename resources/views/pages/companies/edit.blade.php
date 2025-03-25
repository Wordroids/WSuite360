<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Edit Company') }}
        </h2>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Company Form -->
        <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $company->name) }}"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-indigo-200">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $company->email) }}"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-indigo-200">
            </div>

            <!-- Website -->
            <div class="mb-4">
                <label for="website" class="block text-gray-700 font-medium">Website</label>
                <input type="url" id="website" name="website" value="{{ old('website', $company->website) }}"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-indigo-200">
            </div>

            <!-- Logo -->
            <div class="mb-4">
                <label for="logo" class="block text-gray-700 font-medium">Logo</label>
                <input type="file" id="logo" name="logo"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-indigo-200">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Update Company
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

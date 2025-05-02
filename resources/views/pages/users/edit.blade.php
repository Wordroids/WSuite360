<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Edit User</h1>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm"
                    value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm"
                    value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="submit" class="bg-indigo-700 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Update User
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

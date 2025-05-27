<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10 min-h-[75vh]">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Edit Project Member') }}
        </h2>

        <form action="{{ route('project_members.update', $projectMember->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name"
                    class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    value="{{ $projectMember->name }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <input type="text" name="role" id="role"
                    class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    value="{{ $projectMember->role }}" required>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Group -->
            <div class="mb-4">
                <label for="group" class="block text-sm font-medium text-gray-700">Group</label>
                <input type="text" name="group" id="group"
                    class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    value="{{ $projectMember->group }}" required>
                @error('group')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email"
                    class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    value="{{ $projectMember->email }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Update Project Member
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

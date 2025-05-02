<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">User Details</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="border-b pb-4 mb-4">
                <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
            </div>
            <div class="text-gray-700 space-y-4">
                <p><strong class="font-medium">Email:</strong> {{ $user->email }}</p>
                <p><strong class="font-medium">Role:</strong> {{ $user->getRoleName() }}</p>
                <p><strong class="font-medium">Created At:</strong> {{ $user->created_at->format('d M Y, h:i A') }}</p>
                <p><strong class="font-medium">Updated At:</strong> {{ $user->updated_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.users.index') }}"
                class="bg-indigo-700 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Back to User List
            </a>
        </div>
    </div>
</x-app-layout>

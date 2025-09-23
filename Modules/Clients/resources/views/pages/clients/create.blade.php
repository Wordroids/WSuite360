<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Client') }}
        </h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Client Form -->
        <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Client Name</label>
                <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                       required value="{{ old('name') }}">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Client Email</label>
                <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                       required value="{{ old('email') }}">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" name="phone" id="phone" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                       required value="{{ old('phone') }}">
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" id="address" rows="3" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                          required>{{ old('address') }}</textarea>
                @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Website -->
            <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-gray-700">Website (Optional)</label>
                <input type="url" name="website" id="website" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                       value="{{ old('website') }}">
                @error('website') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Billing Currency -->
            <div class="mb-4">
                <label for="billing_currency" class="block text-sm font-medium text-gray-700">Billing Currency (Optional)</label>
                <input type="text" name="billing_currency" id="billing_currency" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                       placeholder="e.g., USD, LKR" value="{{ old('billing_currency') }}">
                @error('billing_currency') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Logo Upload -->
            <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700">Client Logo (Optional)</label>
                <input type="file" name="logo" id="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-600 border rounded-lg file:bg-gray-100 file:border-0 file:mr-4 file:py-2 file:px-4">
                @error('logo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-800 transition duration-200">
                    Create Client
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

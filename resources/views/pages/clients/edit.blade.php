<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="mb-5 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Client') }}
        </h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Client Edit Form -->
        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Client Name</label>
                <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    required value="{{ old('name', $client->name) }}">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Client Email</label>
                <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    required value="{{ old('email', $client->email) }}">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" name="phone" id="phone" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    required value="{{ old('phone', $client->phone) }}">
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" id="address" rows="3" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300"
                    required>{{ old('address', $client->address) }}</textarea>
                @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Company Selection -->
            <div class="mb-4">
                <label for="company_id" class="block text-sm font-medium text-gray-700">Select Company</label>
                <select name="company_id" id="company_id" class="mt-1 p-2 w-full border rounded-lg focus:ring focus:ring-blue-300" required>
                    <option value="">-- Choose Company --</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $client->company_id) == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Update Client
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

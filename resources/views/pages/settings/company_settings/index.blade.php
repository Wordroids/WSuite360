<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Company Settings</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('company.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white shadow-md rounded-lg p-6">
            @csrf

            <!-- Company Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" name="name" value="{{ old('name', $company->name ?? '') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600" />
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $company->email ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600" />
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $company->phone ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600" />
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600">{{ old('address', $company->address ?? '') }}</textarea>
            </div>

            <!-- Tax ID -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tax ID / VAT</label>
                <input type="text" name="vat_number" value="{{ old('vat_number', $company->vat_number ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600" />
            </div>

            <!-- Logo Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Company Logo</label>
                <input type="file" name="logo" class="mt-1 block w-full text-sm text-gray-700" />
                @if (!empty($company->logo))
                    <div class="mt-2">
                        <img src="{{ tenant_asset($company->logo) }}" alt="Current Logo" class="h-16 rounded" />
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

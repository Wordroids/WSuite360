<x-app-layout>

<div class="max-w-4xl mx-auto mt-10 p-6 ">
    <h2 class="text-2xl font-semibold mb-6">Choose Your Payment Option</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Bank Payment Option -->
        <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
                <h3 class="text-xl font-semibold">Pay via Bank</h3>
            </div>
            <p class="text-gray-600 mb-4">Set up recurring payments using BECS direct debit from your bank account.</p>
            <a href="{{ route('payments.bank-charge') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-block">
                Select Bank Payment
            </a>
        </div>

        <!-- Card Payment Option -->
        <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <h3 class="text-xl font-semibold">Pay with Card</h3>
            </div>
            <p class="text-gray-600 mb-4">Set up recurring payments using your credit or debit card.</p>
            <a href="{{ route('payments.card-charge') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 inline-block">
                Select Card Payment
            </a>
        </div>
    </div>
</div>

</x-app-layout>

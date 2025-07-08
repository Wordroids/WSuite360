<x-app-layout>

<div class="max-w-4xl mx-auto mt-10 p-6 ">
    <h2 class="text-2xl font-semibold mb-6">Choose Your Payment Option</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Bank Payment Option -->
        <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-blue-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
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
                <svg class="w-8 h-8 mr-3 text-blue-700 dark:text-blue-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M2 7c0-1.10457.89543-2 2-2h16c1.1046 0 2 .89543 2 2v4c0 .5523-.4477 1-1 1s-1-.4477-1-1v-1H4v7h10c.5523 0 1 .4477 1 1s-.4477 1-1 1H4c-1.10457 0-2-.8954-2-2V7Z"/>
                    <path fill="currentColor" d="M5 14c0-.5523.44772-1 1-1h2c.55228 0 1 .4477 1 1s-.44772 1-1 1H6c-.55228 0-1-.4477-1-1Zm5 0c0-.5523.4477-1 1-1h4c.5523 0 1 .4477 1 1s-.4477 1-1 1h-4c-.5523 0-1-.4477-1-1Zm9-1c.5523 0 1 .4477 1 1v1h1c.5523 0 1 .4477 1 1s-.4477 1-1 1h-1v1c0 .5523-.4477 1-1 1s-1-.4477-1-1v-1h-1c-.5523 0-1-.4477-1-1s.4477-1 1-1h1v-1c0-.5523.4477-1 1-1Z"/>
                </svg>
                <h3 class="text-xl font-semibold">Pay with Card</h3>
            </div>
            <p class="text-gray-600 mb-4">Set up recurring payments using your credit or debit card.</p>
            <a href="{{ route('payments.card-charge') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-block">
                Select Card Payment
            </a>
        </div>
    </div>
</div>

</x-app-layout>

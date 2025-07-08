<x-app-layout>
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Confirm Card Payment</h2>

        <form action="{{ route('payments.card-process') }}" method="POST">
            @csrf
            <input type="hidden" name="payment_method_id" value="{{ $payment_method_id }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <input type="hidden" name="amount" value="{{ $amount }}">
            <input type="hidden" name="payment_cycle" value="{{ $payment_cycle }}">
            <div class="space-y-4">
                <div>
                    <p class="font-medium">Client:</p>
                    <p>{{ $client->name }} ({{ $client->email }})</p>
                </div>

                <div>
                    <p class="font-medium">Project:</p>
                    <p>{{ $project->name }}</p>
                </div>

                <div>
                    <p class="font-medium">Payment Method:</p>
                    <p>Credit/Debit Card</p>
                </div>

                <div>
                    <p class="font-medium">Amount:</p>
                    <p>${{ number_format($amount, 2) }} AUD</p>
                </div>

                <div>
                    <p class="font-medium">Payment Cycle:</p>
                    <p>{{ ucfirst($payment_cycle) }}</p>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <button type="submit" class="flex-1 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Confirm Payment
                </button>
                <a href="{{ route('payments.card-charge') }}"
                    class="flex-1 px-4 py-2 text-center bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    Go Back
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

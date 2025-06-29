<x-app-layout>
    <div class="max-w-7xl mx-auto ">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Client: {{ $client->name }} </h2>
            <a href="{{ route('clients.index') }}"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-block">Go Back </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Client Details Table -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Basic Information</h3>
            <div class="overflow-x-auto rounded-lg shadow-lg ">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <tbody class="divide-y divide-gray-200 bg-gray-50">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Name</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $client->name }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Email</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $client->email }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Phone</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $client->phone }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Address</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $client->address }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Website</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($client->website)
                                    <a href="{{ $client->website }}" target="_blank"
                                        class="text-indigo-600 hover:underline">{{ $client->website }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Billing Currency</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $client->billing_currency ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Stripe Customer ID</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $client->stripe_customer_id ?? 'Not created' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Logo</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($client->logo)
                                    <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }} logo"
                                        class="h-16 w-16 object-contain">
                                @else
                                    No logo uploaded
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Subscriptions Table -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Transactional Details</h3>
            </div>

            @if ($client->subscriptions->isEmpty())
                <div class="bg-gray-100 p-4 rounded-lg text-center text-gray-600">
                    No subscriptions found for this client.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">
                                    Project</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">
                                    Amount</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">
                                    Currency</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">
                                    Payment Cycle</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">
                                    Payment Type</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">
                                    Status</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($client->subscriptions as $subscription)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $subscription->project->name ?? 'Project Deleted' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $subscription->amount }} {{ $subscription->currency }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ strtoupper($subscription->currency) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ ucfirst($subscription->billing_cycle) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if (strtolower($subscription->payment_type) === 'bank')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Bank (BECS)
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Card
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $subscription->status === 'active'
                                                ? 'bg-green-100 text-green-800'
                                                : ($subscription->status === 'canceled'
                                                    ? 'bg-gray-100 text-gray-800'
                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($subscription->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if ($subscription->status === 'active')
                                            <form action="{{ route('payments.cancelSubscription') }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <input type="hidden" name="subscription_id"
                                                    value="{{ $subscription->stripe_subscription_id }}">
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to cancel this subscription?')">Cancel</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">No actions</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

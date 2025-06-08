<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">Invoices List</h2>
            <a href="{{ route('invoice.create') }}"
                class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-800 transition">
                + Create Invoice
            </a>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('invoice.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div>
                <label for="filter_client" class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                <select id="filter_client" name="client"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Clients</option>
                    @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filter_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" id="filter_date" name="date" value="{{ request('date') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex items-end">
                <button type="submit"
                    class="bg-gray-700 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition">
                    Apply Filters
                </button>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg shadow border">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-indigo-100 text-indigo-900 font-semibold text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Due Date</th>
                        <th class="px-4 py-3 text-left">Number</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Due Amount</th>
                        <th class="px-4 py-3 text-left">Total Amount</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($invoices as $invoice)
                    <tr class="bg-white hover:bg-gray-50">
                        <!-- Status -->
                        <td class="px-4 py-3">
                            @php
                            $badgeClasses = match($invoice->status) {
                            'draft' => 'bg-gray-200 text-gray-800',
                            'sent' => 'bg-blue-100 text-blue-800',
                            'paid' => 'bg-green-100 text-green-800',
                            'overdue' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-700'
                            };
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded {{ $badgeClasses }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>

                        <!-- Dates -->
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                        </td>

                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                        </td>

                        <!-- Number + Customer -->
                        <td class="px-4 py-3 font-medium">{{ $invoice->invoice_number }}</td>
                        <td class="px-4 py-3">{{ $invoice->client->name }}</td>

                        <!-- Amounts -->
                        <td class="px-4 py-3 font-medium">
                            {{ $invoice->currency }}{{ number_format($invoice->total, 2) }}
                        </td>
                        <td class="px-4 py-3 font-medium">
                            {{ $invoice->currency }}{{ number_format($invoice->total, 2) }}
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 text-right" x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 12h.01M12 12h.01M18 12h.01" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-36 bg-white border rounded shadow-lg z-50">
                                <a href="{{ route('invoice.show', ['id' => $invoice->id]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">
                                    View
                                </a>
                                <a href="{{ route('invoice.edit', $invoice->id) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">
                                    Edit
                                </a>
                                <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        <div class="mt-6">
            {{ $invoices->withQueryString()->links() }}
        </div>
    </div>

    <!-- Delete Confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDeletion(invoiceId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the invoice.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6366F1',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${invoiceId}`).submit();
                }
            });
        }
    </script>
</x-app-layout>
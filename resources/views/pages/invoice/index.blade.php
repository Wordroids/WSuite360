<x-app-layout>
    <div class="container mx-auto p-6 ">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                {{ __('Invoices List') }}
            </h2>
            <a href="{{ route('invoice.create') }}"
                class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                + Create Invoice
            </a>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label for="filter_company" class="block text-gray-700 font-medium mb-2">Filter by Company</label>
                <select id="filter_company" name="filter_company"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-700 focus:border-indigo-700">
                    <option value="">All Companies</option>
                    <option value="Company A">Company A</option>
                    <option value="Company B">Company B</option>
                </select>
            </div>
            <div>
                <label for="filter_date" class="block text-gray-700 font-medium mb-2">Filter by Date</label>
                <input type="date" id="filter_date" name="filter_date"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-700 focus:border-indigo-700">
            </div>
            <div class="flex items-end">
                <button class="bg-gray-700 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition duration-200">
                    Apply Filters
                </button>
            </div>
        </div>

        <!-- Invoices Table -->
        <div class="overflow-x-auto rounded-lg shadow-lg">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Invoice No</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Company</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Amount</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dummy Data -->
                    @php
                        $dummyInvoices = [
                            [
                                'id' => 1,
                                'invoice_no' => 'INV001',
                                'company' => 'Company A',
                                'date' => '2025-04-01',
                                'amount' => 1500,
                            ],
                            [
                                'id' => 2,
                                'invoice_no' => 'INV002',
                                'company' => 'Company B',
                                'date' => '2025-04-02',
                                'amount' => 2000,
                            ],
                            [
                                'id' => 3,
                                'invoice_no' => 'INV003',
                                'company' => 'Company A',
                                'date' => '2025-04-03',
                                'amount' => 2500,
                            ],
                        ];
                    @endphp
                    @forelse ($dummyInvoices as $invoice)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $invoice['invoice_no'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $invoice['company'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $invoice['date'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">Rs. {{ number_format($invoice['amount'], 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-center">
                                <a href="{{ route('invoice.viewInvoice') }}"
                                    class="bg-indigo-700 text-white px-3 py-1 rounded-lg hover:bg-indigo-700 transition">
                                    View
                                </a>
                                <form id="delete-form-{{ $invoice['id'] }}" action="#" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition"
                                    onclick="confirmDeletion({{ $invoice['id'] }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <!-- Dummy Pagination -->
            <nav>
                <ul class="flex justify-center space-x-2">
                    <li><a href="#" class="px-3 py-1 bg-gray-200 rounded-lg">1</a></li>
                    <li><a href="#" class="px-3 py-1 bg-gray-200 rounded-lg">2</a></li>
                    <li><a href="#" class="px-3 py-1 bg-gray-200 rounded-lg">3</a></li>
                </ul>
            </nav>
        </div>
    </div>
</x-app-layout>

<!-- Confirm Delete -->
<script>
    function confirmDeletion(invoiceId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#4338CA',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${invoiceId}`).submit();
            }
        });
    }
</script>

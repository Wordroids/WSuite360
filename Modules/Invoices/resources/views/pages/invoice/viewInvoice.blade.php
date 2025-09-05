<x-app-layout>
    <div class="container mx-auto my-10 px-4" x-data="{ paymentOpen: false }">

        <!-- Toast -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Invoice Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-gray-800">Invoice #{{ $invoice->invoice_number }}</h1>
        </div>

        <!-- Summary -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-8">
            <div class="md:col-span-2">
                <div class="text-sm text-gray-500">Status</div>
                <span class="inline-block bg-gray-200 text-gray-800 text-xs font-semibold mt-1 px-3 py-1 rounded-full">
                    {{ ucfirst($invoice->status) }}
                </span>
            </div>
            <div class="md:col-span-3">
                <div class="text-sm text-gray-500">Client</div>
                <div class="text-gray-800 font-medium mt-1">{{ $invoice->client->name }}</div>
            </div>
            <div class="md:col-span-2">
                <div class="text-sm text-gray-500">Due Date</div>
                <div class="text-gray-800 font-medium mt-1">{{ $invoice->due_date->format('d M Y') }}</div>
            </div>
            <div class="md:col-span-2">
                <div class="text-sm text-gray-500">Amount Due</div>
                <div class="text-gray-800 font-bold mt-1">{{ $invoice->currency }} {{ number_format($invoice->due, 2) }}
                </div>
            </div>
            <div class="col-span-3 items-center flex">
                <a href="{{ route('invoice.download', $invoice->id) }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Download PDF
                </a>
            </div>

            <div>
                <a href="{{ route('invoice.preview', $invoice->id) }}"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                    <i class="fa-solid fa-pencil-alt"></i> Invoice
                </a>
            </div>

        </div>

        <!-- Actions Overview -->
        <div class="grid grid-cols-1 gap-4 max-w-4xl mx-auto">
            {{-- CREATE --}}
            @if ($invoice->status === 'draft')
                <div class="grid grid-cols-1 md:grid-cols-4 items-center bg-white rounded-lg shadow p-5">
                    <div class="flex items-center gap-3">
                        <span class="border border-orange-400 p-3 rounded-full">
                            <i class="fa-regular fa-file-lines text-lg text-orange-500"></i>
                        </span>
                        <div>
                            <div class="text-gray-800 font-semibold">Create</div>
                            <div class="text-gray-500 text-sm">Draft Status</div>
                        </div>
                    </div>
                    <div class="md:col-span-2"></div>
                    <div class="flex justify-end">
                        <form method="POST" action="{{ route('invoice.approve', $invoice->id) }}">
                            @csrf
                            <button type="submit"
                                class="bg-orange-400 text-white px-4 py-2 rounded hover:bg-orange-500">
                                Approve Draft
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-4 items-center bg-white rounded-lg shadow p-5">
                    <div class="flex items-center gap-3">
                        <span class="border border-orange-400 p-3 rounded-full">
                            <i class="fa-regular fa-file-lines text-lg text-orange-500"></i>
                        </span>
                        <div>
                            <div class="text-gray-800 font-semibold">Created</div>
                            <div class="text-gray-500 text-sm">{{ $invoice->created_at->format('Y-m-d') }}</div>
                        </div>
                    </div>
                    <div class="md:col-span-2"></div>
                    <div class="flex justify-end">
                        <span class="text-green-600 text-sm font-semibold">Approved</span>
                    </div>
                </div>
            @endif

            {{-- SEND --}}
            @if (in_array($invoice->status, ['overdue', 'sent', 'paid', 'partialy-paid']))
                <div class="grid grid-cols-1 md:grid-cols-4 items-center bg-white rounded-lg shadow p-5">
                    <div class="flex items-center gap-3">
                        <span class="border border-orange-400 p-3 rounded-full">
                            <i class="fa-solid fa-paper-plane text-lg text-orange-500"></i>
                        </span>
                        <div>
                            <div class="text-gray-800 font-semibold">Send</div>
                            <div class="text-gray-500 text-sm">Last Sent:
                                {{ optional($invoice->sent_at)->format('Y-m-d') ?? 'Not sent' }}</div>
                        </div>
                    </div>
                    <div class="md:col-span-1"></div>
                    <div class="md:col-span-2 flex justify-end items-center gap-3">

                        <form method="POST" action="{{ route('invoice.markAsSent', $invoice->id) }}">
                            @csrf
                            <button type="submit"
                                class="bg-orange-400 text-white px-4 py-2 rounded hover:bg-orange-500">
                                Send Invoice
                            </button>
                        </form>
                        @if ($invoice->sent_at != null)
                            <span class="text-green-600 text-sm font-semibold">Sent</span>
                        @endif
                    </div>
                </div>
            @endif

            {{-- GET PAID --}}
            @if (in_array($invoice->status, ['sent', 'paid', 'partialy-paid']))
                <div class="bg-white rounded-lg shadow p-5">
                    <div class="grid grid-cols-1 md:grid-cols-4 items-center mb-4 ">
                        <div class="flex items-center gap-3">
                            <span class="border border-orange-400 p-3 rounded-full">
                                <i class="fa-solid fa-money-check-dollar text-lg text-orange-500"></i>
                            </span>
                            <div>
                                <div class="text-gray-800 font-semibold">Get Paid</div>
                                <div class="text-gray-500 text-sm">Amount Due: {{ $invoice->currency }}
                                    {{ number_format($invoice->due, 2) }}</div>
                            </div>
                        </div>
                        <div class="md:col-span-1"></div>
                        <div class="md:col-span-2 flex justify-end items-center gap-3">
                            @if ($invoice->status === 'sent' || $invoice->status === 'partialy-paid' || $invoice->status === 'overdue')
                                <button @click="paymentOpen = true"
                                    class="bg-orange-400 text-white px-4 py-2 rounded hover:bg-orange-500">
                                    Record Payment
                                </button>
                            @else
                                <span class="text-green-600 text-sm font-semibold">Paid</span>
                            @endif
                        </div>

                    </div>


                    <hr>

                    <!-- Payments List -->
                    <div class="mt-4">
                        <h4 class="text-gray-400 font-medium text-sm mb-2">Payments received :</h4>



                        @forelse($invoice->payments->sortByDesc('payment_date') as $index => $payment)
                            <p class="text-sm text-blue-950 mb-2 text-justify whitespace-normal leading-relaxed">

                                {{ $index + 1 }}.
                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }} –
                                A payment of {{ $invoice->currency }}{{ number_format($payment->amount, 2) }}
                                was made using {{ strtolower($payment->payment_method) }}.
                                <a href="{{ route('invoice.receipt', [$invoice->id, $payment->id]) }}"
                                    class="text-orange-500 hover:underline ml-1">
                                    send receipt
                                </a>
                                <span class="text-gray-500">.</span>
                                <a href="{{ route('invoice.editPayment', [$invoice->id, $payment->id]) }}"
                                    class="text-orange-500 hover:underline ml-1">
                                    edit payment
                                </a>
                            </p>

                        @empty
                            <p class="text-sm text-gray-500">No payments recorded yet.</p>
                        @endforelse


                    </div>
                </div>

            @endif

            <!-- PDF-like Preview -->
            <div class="mt-10">
                @include('invoices::pages.invoice.partials.preview', [
                    'invoice' => $invoice,
                    'company' => $company,
                    'payments' => $payments,
                ])
            </div>
        </div>



        <!-- Payment Modal -->
        <div x-show="paymentOpen" style="display: none;"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
                <h2 class="text-lg font-bold mb-4">Record Payment</h2>
                <form method="POST" action="{{ route('invoice.recordxPayment', $invoice->id) }}">
                    @csrf

                    <!-- Amount -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Amount Paid</label>
                        <input type="number" name="amount" step="0.01" min="0"
                            class="w-full border-gray-300 rounded px-3 py-2 mt-1" required>
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Payment Date</label>
                        <input type="date" name="payment_date"
                            class="w-full border-gray-300 rounded px-3 py-2 mt-1" required>
                    </div>

                    <!-- Method Dropdown -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select name="payment_method"
                            class="w-full border-gray-300 rounded px-3 py-2 mt-1 focus:ring focus:ring-indigo-500"
                            required>
                            <option value="">Select method</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Account Dropdown -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Payment Account</label>
                        <select name="payment_account"
                            class="w-full border-gray-300 rounded px-3 py-2 mt-1 focus:ring focus:ring-indigo-500">
                            <option value="">Select account</option>
                            <option value="Sampath Bank">Sampath Bank</option>
                            <option value="Commercial Bank">Commercial Bank</option>
                            <option value="People's Bank">People's Bank</option>
                            <option value="HNB">HNB</option>
                            <option value="BOC">BOC</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" rows="3" class="w-full border-gray-300 rounded px-3 py-2 mt-1"
                            placeholder="Optional remarks..."></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="paymentOpen = false"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Record Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>

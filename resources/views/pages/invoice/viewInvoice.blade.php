<x-app-layout>
    <div class="container mx-auto my-10">

        <div class="
         flex justify-between">
            <div>
                <span>Invoice 71</span>
            </div>

            <div>
                <button @click="open = !open" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 12h.01M12 12h.01M18 12h.01" />
                    </svg>
                </button>
            </div>
        </div>

        <div>
            <hr>
        </div>

        <div class="        ">

            <div class="grid grid-cols-12">

                <div>
                    <div>status</div>
                    <span class="bg-gray-300 text-gray-700 rounded-lg py-2 px-4">Draft</span>
                </div>

                <div class="col-span-2">
                    <div>Customer</div>
                    <span class=" text-gray-700">The Idea Hub</span>
                </div>
                <div class="col-span-7">

                </div>

                <div class="">
                    <div>Due Date</div>
                    <span class="text-gray-700">06 Jun 2025</span>
                </div>
                <div class="">
                    <div>Due Amount</div>
                    <span class=" text-gray-700">LKR5,000.00

                    </span>
                </div>


            </div>
        </div>

        <div>
            <div class="bg-gray-200 max-w-4xl mx-auto p-5 grid grid-cols-1 gap-4">

                <div class="grid grid-cols-4 bg-white p-5">

                    <div class="flex  items-center justify-between">
                        <div>
                            <span class="border-[1px] border-orange-400 p-3 rounded-full"><i class="fa-regular fa-file-lines text-lg" style="color: #ff9500;"></i></span>
                        </div>
                        <div>
                            <div>Create</div>
                            <span>Created: 2025-06-06</span>
                        </div>
                    </div>

                    <div class="col-span-2">

                    </div>

                    <div class="flex  items-center justify-between">
                        <div>
                            <i class="fa-solid fa-money-check-pen"></i>
                            <span>Edit</span>
                        </div>

                        <div>
                            <button class="bg-orange-400 px-4 py-2">Approve draft</button>
                        </div>

                    </div>


                </div>

                <div class="grid grid-cols-4 bg-white p-5">

                    <div class="flex  items-center justify-between">
                        <div>
                            <span class="border-[1px] border-orange-400 p-3 rounded-full"><i class="fa-solid fa-paper-plane text-lg" style="color: #ff9500;"></i></span>
                        </div>
                        <div>
                            <div>Send</div>
                            <span>Last Sent: 2025-06-06</span>
                        </div>
                    </div>

                    <div class="col-span-1">

                    </div>

                    <div class="flex col-span-2 items-center justify-between">
                        <div>
                            <span>Mark as Sent</span>
                        </div>

                        <div>
                            <button class="bg-orange-400 px-4 py-2">Send Invoice</button>
                        </div>

                    </div>


                </div>

                <div class="grid grid-cols-4 bg-white p-5">

                    <div class="flex  items-center justify-between">
                        <div>
                            <span class="border-[1px] border-orange-400 p-3 rounded-full"><i class="fa-solid fa-money-check-dollar text-lg" style="color: #ff9500;"></i></span>
                        </div>
                        <div>
                            <div>Get paid</div>
                            <span>Amount due: LKR55000</span>
                        </div>
                    </div>

                    <div class="col-span-1">

                    </div>

                    <div class="flex col-span-2 items-center justify-between">
                        <div>
                            <span>Send a reminder</span>
                        </div>

                        <div>
                            <button class="bg-orange-400 px-4 py-2">Record payment</button>
                        </div>

                    </div>


                </div>

                @php

                @endphp

                <div class="grid grid-cols-4 bg-white p-5">

                    <div class="col-span-4 bg-white">
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Invoice Preview</h3>

                        <div class="max-w-4xl mx-auto py-10 px-6">

                            <!-- Header -->
                            <div class="grid grid-cols-4 items-start mb-6">
                                <div>
                                    @if ($company->logo)
                                    <img src="{{ tenant_asset($company->logo) }}" class="w-40" alt="Company Logo">
                                    @endif
                                </div>
                                <div class="col-span-2 mt-8">
                                    <h2 class="text-3xl text-blue-950 font-black">{{ $company->name }}</h2>
                                    <p class="text-gray-400 font-bold">{{ $company->address }}</p>
                                </div>
                                <div class="text-right mt-8">
                                    <h1 class="text-lg font-bold">Contact Information</h1>
                                    <p class="text-gray-400">{{ $company->email }}</p>
                                    <p class="text-gray-400">{{ $company->phone }}</p>
                                </div>
                            </div>

                            <hr>

                            <!-- Client & Total -->
                            <div class="grid grid-cols-2 my-6">
                                <div>
                                    <h1 class="text-3xl text-blue-950 font-black">
                                        {{ $invoice->title ?? 'Invoice' }}
                                    </h1>
                                    <p class="text-gray-400">{{ $invoice->client->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-400">Amount Due ({{ $invoice->currency }})</p>
                                    <p class="text-3xl text-blue-950 font-black">
                                        {{ $invoice->currency }}{{ number_format($invoice->total, 2) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Billing & Invoice Details -->
                            <div class="grid md:grid-cols-2 gap-20 mt-6">
                                <div class="grid grid-cols-3 text-sm gap-y-1">
                                    <div class="text-gray-400">Bill to</div>
                                    <div class="col-span-2 font-bold">: {{ $invoice->client->name }}</div>

                                    <div class="text-gray-400">Email</div>
                                    <div class="col-span-2 font-bold">: {{ $invoice->client->email }}</div>

                                    <div class="text-gray-400">Phone</div>
                                    <div class="col-span-2 font-bold">: {{ $invoice->client->phone }}</div>

                                    <div class="text-gray-400">Address</div>
                                    <div class="col-span-2 font-bold">: {{ $invoice->client->address }}</div>
                                </div>

                                <div class="grid grid-cols-3 text-sm gap-y-1">
                                    <div class="text-gray-400 col-span-2">Invoice No:</div>
                                    <div class="font-bold text-right">{{ $invoice->invoice_number }}</div>

                                    <div class="text-gray-400 col-span-2">PO/SO Number:</div>
                                    <div class="font-bold text-right">{{ $invoice->po_so_number ?? '-' }}</div>

                                    <div class="text-gray-400 col-span-2">Invoice Date:</div>
                                    <div class="font-bold text-right">{{ $invoice->invoice_date->format('Y-m-d') }}</div>

                                    <div class="text-gray-400 col-span-2">Due Date:</div>
                                    <div class="font-bold text-right">{{ $invoice->due_date->format('Y-m-d') }}</div>
                                </div>
                            </div>

                            <!-- Items Table -->
                            <div class="mt-10">
                                <table class="w-full border-separate border-spacing-2 text-sm">
                                    <thead>
                                        <tr>
                                            <th class="bg-blue-100 text-left px-4 py-2 rounded">Item</th>
                                            <th class="bg-blue-100 text-left px-4 py-2 rounded">Quantity</th>
                                            <th class="bg-blue-100 text-left px-4 py-2 rounded">Price</th>
                                            <th class="bg-blue-100 text-left px-4 py-2 rounded">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $item)
                                        <tr>
                                            <td class="px-4 py-2 border-b">{{ $item->project->name ?? '-' }}</td>
                                            <td class="px-4 py-2 border-b">{{ $item->quantity }}</td>
                                            <td class="px-4 py-2 border-b">{{ $invoice->currency }}{{ number_format($item->price, 2) }}</td>
                                            <td class="px-4 py-2 border-b">{{ $invoice->currency }}{{ number_format($item->quantity * $item->price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Totals -->
                            <div class="mt-6 text-right space-y-1 text-sm">
                                <p class="font-semibold">Sub Total: {{ $invoice->currency }}{{ number_format($invoice->subtotal, 2) }}</p>
                                <p class="font-semibold">Tax: {{ $invoice->currency }}{{ number_format($invoice->tax_amount, 2) }}</p>
                                <p class="font-semibold">Discount: -{{ $invoice->currency }}{{ number_format($invoice->discount_amount, 2) }}</p>
                                <p class="font-bold">Total: {{ $invoice->currency }}{{ number_format($invoice->total, 2) }}</p>
                                <p class="mt-2 font-bold text-lg">Grand Total (LKR): LKR {{ number_format($invoice->total * $invoice->conversion_rate, 2) }}</p>
                            </div>

                        </div>
                    </div>


                </div>


            </div>
        </div>

    </div>
</x-app-layout>
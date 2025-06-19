<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-800">
    <div class="max-w-4xl mx-auto py-10 px-6">
        <!-- Header -->
        <div class="grid grid-cols-4 items-start mb-6">
            <div>
                @if (isset($company->base64_logo))
                    <img src="{{ $company->base64_logo }}" class="w-40" alt="Company Logo">
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
                <h1 class="text-2xl text-blue-950 font-black">
                    {{ $invoice->title ?? 'Invoice' }}
                </h1>
                <p class="text-gray-400">{{ $invoice->description }}</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400">Amount Due ({{ $invoice->currency }})</p>
                <p class="text-2xl text-blue-950 font-black">
                    {{ $invoice->currency }} {{ number_format($invoice->due, 2) }}
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
                        <th class="bg-blue-100 text-left px-4 py-2 rounded">Price ({{ $invoice->currency }})</th>
                        <th class="bg-blue-100 text-left px-4 py-2 rounded">Amount ({{ $invoice->currency }})</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $item->project->name ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 border-b">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-4 py-2 border-b">
                                {{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="mt-6 text-right space-y-2 text-sm text-blue-950">
            <div class="flex justify-end gap-4">
                <p class="font-semibold">Sub Total :</p>
                <p class="font-semibold">{{ $invoice->currency }}{{ number_format($invoice->subtotal, 2) }}</p>
            </div>
            <div class="flex justify-end gap-4">
                <p class="font-semibold">Tax :</p>
                <p class="font-semibold">{{ $invoice->currency }}{{ number_format($invoice->tax_amount ?? 0, 2) }}</p>
            </div>
            <div class="flex justify-end gap-4">
                <p class="font-semibold">Discount :</p>
                <p class="font-semibold">-{{ $invoice->currency }}{{ number_format($invoice->discount_amount ?? 0, 2) }}</p>
            </div>
            <div class="flex justify-end gap-4">
                <p class="font-semibold">Total :</p>
                <p class="font-semibold">{{ $invoice->currency }}{{ number_format($invoice->total, 2) }}</p>
            </div>
            <div class="flex justify-end gap-4 text-lg font-bold mt-3 border-t pt-3">
                <p>Grand total ({{ $invoice->currency }}) :</p>
                <p>{{ $invoice->currency }}{{ number_format($invoice->total * ($invoice->conversion_rate ?? 1), 2) }}</p>
            </div>

            @foreach ($invoice->payments as $payment)
                <div class="flex justify-end gap-4 text-base font-semibold">
                    <p>Payment on {{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }} using
                        {{ $payment->payment_method }} payment :</p>
                    <p>{{ $invoice->currency }}{{ number_format($payment->amount, 2) }}</p>
                </div>
            @endforeach
        </div>

        <!-- Notes, instructions and Footer Notes -->
        <div class="mt-10">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Notes</h3>
            <p class="text-gray-600">{{ $invoice->notes ?? 'No additional notes.' }}</p>
            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-2">Payment Instructions</h3>
            <p class="text-gray-600">{{ $invoice->instructions ?? 'No payment instructions provided.' }}</p>
            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-2">Footer Notes</h3>
            <p class="text-gray-600">{{ $invoice->footer ?? 'No footer notes provided.' }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tell the PDF generator we're ready
            setTimeout(() => {
                window.status = 'ready';
            }, 500);
        });
    </script>
</body>
</html>
<div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
            <!-- Header -->
    <div class="flex justify-between items-start mb-8">
        <div>
            @if($company && $company->logo)
                <img src="{{ tenant_asset($company->logo) }}" alt="Company Logo" class="h-16 mb-4">
            @endif
            <h1 class="text-2xl font-bold text-gray-800">INVOICE</h1>
        </div>
        <div class="text-right">
            <div class="text-lg font-bold text-gray-800">#<span id="preview-invoice-number">{{ $invoice->invoice_number ?? 'Auto-generated' }}</span></div>
            <div class="text-sm text-gray-600">Date: {{ ($invoice->invoice_date ?? now())->format('M d, Y') }}</div>
            <div class="text-sm text-gray-600">Due Date: {{ ($invoice->due_date ?? now()->addDays(30))->format('M d, Y') }}</div>
            @if($invoice->po_so_number ?? false)
                <div class="text-sm text-gray-600">PO/SO: {{ $invoice->po_so_number }}</div>
            @endif
        </div>
    </div>

    <!-- From/To Sections -->
    <div class="grid grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">From:</h3>
            @if($company)
                <div class="text-gray-800">
                    <div class="font-semibold">{{ $company->company_name ?? 'Your Company Name' }}</div>
                    @if($company->address)<div>{{ $company->address }}</div>@endif
                    @if($company->city || $company->state || $company->zip_code)
                        <div>{{ implode(', ', array_filter([$company->city, $company->state, $company->zip_code])) }}</div>
                    @endif
                    @if($company->phone)<div>Phone: {{ $company->phone }}</div>@endif
                    @if($company->email)<div>Email: {{ $company->email }}</div>@endif
                </div>
            @else
                <div class="text-gray-500">Company information not set</div>
            @endif
        </div>
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">To:</h3>
            @if($client)
                <div class="text-gray-800">
                    <div class="font-semibold">{{ $client->name }}</div>
                    @if($client->address)<div>{{ $client->address }}</div>@endif
                    @if($client->city || $client->state || $client->zip_code)
                        <div>{{ implode(', ', array_filter([$client->city, $client->state, $client->zip_code])) }}</div>
                    @endif
                    @if($client->phone)<div>Phone: {{ $client->phone }}</div>@endif
                    @if($client->email)<div>Email: {{ $client->email }}</div>@endif
                </div>
            @else
                <div class="text-gray-500 italic">No client selected</div>
            @endif
        </div>
    </div>

    <!-- Summary -->
    @if($invoice->title || $invoice->description)
    <div class="mb-6 p-4 bg-gray-50 rounded">
        @if($invoice->title)
            <h3 class="font-semibold text-gray-800 mb-2">{{ $invoice->title }}</h3>
        @endif
        @if($invoice->description)
            <p class="text-gray-600 text-sm">{{ $invoice->description }}</p>
        @endif
    </div>
    @endif

    <!-- Items Table -->
    <div class="mb-8">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold text-gray-700">Description</th>
                    <th class="border border-gray-300 px-4 py-2 text-center font-semibold text-gray-700">Qty</th>
                    <th class="border border-gray-300 px-4 py-2 text-right font-semibold text-gray-700">Price</th>
                    <th class="border border-gray-300 px-4 py-2 text-right font-semibold text-gray-700">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(count($items) > 0)
                    @foreach($items as $item)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="text-gray-800">{{ $item->description }}</div>
                                @if($item->project)
                                    <div class="text-xs text-gray-500">Project: {{ $item->project->name }}</div>
                                @elseif($item->service)
                                    <div class="text-xs text-gray-500">Service: {{ $item->service->name }}</div>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->quantity }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">{{ $invoice->currency ?? 'LKR' }} {{ number_format($item->unit_price, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">{{ $invoice->currency ?? 'LKR' }} {{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="border border-gray-300 px-4 py-4 text-center text-gray-500 italic">
                            No items added
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="border border-gray-300 px-4 py-2 text-right font-semibold">Subtotal:</td>
                    <td class="border border-gray-300 px-4 py-2 text-right font-semibold">
                        {{ $invoice->currency ?? 'LKR' }} {{ number_format($invoice->subtotal ?? 0, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="border border-gray-300 px-4 py-2 text-right font-semibold text-lg">Total:</td>
                    <td class="border border-gray-300 px-4 py-2 text-right font-semibold text-lg">
                        {{ $invoice->currency ?? 'LKR' }} {{ number_format($invoice->total ?? 0, 2) }}
                    </td>
                </tr>
                @if($due > 0)
                <tr>
                    <td colspan="3" class="border border-gray-300 px-4 py-2 text-right font-semibold">Amount Due:</td>
                    <td class="border border-gray-300 px-4 py-2 text-right font-semibold text-red-600">
                        {{ $invoice->currency ?? 'LKR' }} {{ number_format($due, 2) }}
                    </td>
                </tr>
                @endif
            </tfoot>
        </table>
    </div>

    <!-- Notes & Instructions -->
    <div class="grid grid-cols-2 gap-8 text-sm">
        @if($invoice->notes)
        <div>
            <h4 class="font-semibold text-gray-700 mb-2">Notes:</h4>
            <p class="text-gray-600 whitespace-pre-line">{{ $invoice->notes }}</p>
        </div>
        @endif

        @if($invoice->instructions)
        <div>
            <h4 class="font-semibold text-gray-700 mb-2">Payment Instructions:</h4>
            <p class="text-gray-600 whitespace-pre-line">{{ $invoice->instructions }}</p>
        </div>
        @endif
    </div>

    <!-- Footer -->
    @if($invoice->footer)
    <div class="mt-8 pt-4 border-t border-gray-300">
        <p class="text-center text-gray-500 text-sm">{{ $invoice->footer }}</p>
    </div>
    @endif

    <!-- Preview Notice -->
    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded text-center">
        <p class="text-yellow-700 text-sm">
            <strong>Preview Only</strong> - This is a preview of how your invoice will look. Changes are not saved until you submit the form.
        </p>
    </div>
</div>

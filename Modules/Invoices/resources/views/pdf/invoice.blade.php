<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>

    </style>
</head>

<body>

    <div class="header">
        <div>
            <img src="file://{{ storage_path("app/public/{$company->logo}") }}" alt="Company Logo" style="max-width: 150px; max-height: 50px;">
        </div>
        <div>vdefhw
            <h2>{{ $company->name  }}</h2>
        </div>

    </div>

    <table class="client-info">
        <tr>
            <td>
                <strong>Bill To:</strong><br>
                {{ $invoice->client->name }}<br>
                {{ $invoice->client->email }}<br>
                {{ $invoice->client->phone }}
            </td>
            <td>
                <strong>Invoice Number:</strong> {{ $invoice->invoice_number }}<br>
                <strong>PO/SO Number:</strong> {{ $invoice->po_so_number ?? '-' }}<br>
                <strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}<br>
                <strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price ({{ $invoice->currency ?? 'LKR' }})</th>
                <th>Amount ({{ $invoice->currency ?? 'LKR' }})</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item->project->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td class="text-right"><strong>Subtotal:</strong></td>
            <td class="text-right">{{ number_format($invoice->subtotal, 2) }} {{ $invoice->currency }}</td>
        </tr>
        <tr>
            <td class="text-right"><strong>Tax:</strong></td>
            <td class="text-right">{{ number_format($invoice->tax_amount, 2) }} {{ $invoice->currency }}</td>
        </tr>
        <tr>
            <td class="text-right"><strong>Discount:</strong></td>
            <td class="text-right">-{{ number_format($invoice->discount_amount, 2) }} {{ $invoice->currency }}</td>
        </tr>
        <tr>
            <td class="text-right"><strong>Total:</strong></td>
            <td class="text-right">{{ number_format($invoice->total, 2) }} {{ $invoice->currency }}</td>
        </tr>
        <tr>
            <td class="text-right"><strong>Grand Total (LKR):</strong></td>
            <td class="text-right">LKR {{ number_format($invoice->total * $invoice->conversion_rate, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>{{ $company->address ?? '1/85, Elhena Road, Maharagama' }}</p>
        <p>{{ $company->email ?? 'info@wordroids.com' }} | {{ $company->phone ?? '0761535453' }}</p>
    </div>

</body>

</html>
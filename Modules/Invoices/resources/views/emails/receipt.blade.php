<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Receipt - {{ $details['invoice']->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #f36f21;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-logo {
            max-width: 150px;
            margin-bottom: 15px;
        }

        .invoice-details {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .payment-details {
            background: #f0f8ff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }

        .status-partial {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            @if ($details['company']->logo)
                <img src="{{ $message->embedData(file_get_contents(storage_path('app/public/' . $details['company']->logo)), 'logo.png') }}"
                    alt="Company Logo" class="company-logo">
            @endif
            <h1>{{ $details['company']->name ?? 'Company Name' }}</h1>
            <h2>Payment Receipt</h2>
        </div>

        <!-- Invoice & Payment Details -->
        <div class="invoice-details">
            <h3>Invoice Information</h3>
            <table width="100%">
                <tr>
                    <td width="30%"><strong>Invoice Number:</strong></td>
                    <td>{{ $details['invoice']->invoice_number }}</td>
                </tr>
                <tr>
                    <td><strong>Invoice Date:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($details['invoice']->invoice_date)->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Client:</strong></td>
                    <td>{{ $details['client']->name }}</td>
                </tr>
                <tr>
                    <td><strong>Invoice Total:</strong></td>
                    <td>{{ $details['invoice']->currency }} {{ number_format($details['invoice']->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Payment Details -->
        <div class="payment-details">
            <h3>Payment Information</h3>
            <table width="100%">
                <tr>
                    <td width="30%"><strong>Payment Date:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($details['payment']->payment_date)->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Amount Paid:</strong></td>
                    <td><strong>{{ $details['invoice']->currency }}
                            {{ number_format($details['payment']->amount, 2) }}</strong></td>
                </tr>
                <tr>
                    <td><strong>Payment Method:</strong></td>
                    <td>{{ $details['payment']->payment_method }}</td>
                </tr>
                <tr>
                    <td><strong>Payment Account:</strong></td>
                    <td>{{ $details['payment']->payment_account }}</td>
                </tr>
                <tr>
                    <td><strong>Payment Status:</strong></td>
                    <td>
                        <span
                            class="status-badge {{ $details['invoice']->status === 'paid' ? 'status-paid' : 'status-partial' }}">
                            {{ $details['invoice']->status === 'paid' ? 'Fully Paid' : 'Partially Paid' }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Invoice Items -->
        <h3>Invoice Items</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details['invoice']->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $details['invoice']->currency }} {{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $details['invoice']->currency }} {{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;"><strong>Subtotal:</strong></td>
                    <td><strong>{{ $details['invoice']->currency }}
                            {{ number_format($details['invoice']->subtotal, 2) }}</strong></td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;"><strong>Total Paid:</strong></td>
                    <td><strong>{{ $details['invoice']->currency }}
                            {{ number_format($details['invoice']->payments->sum('amount'), 2) }}</strong></td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;"><strong>Amount Due:</strong></td>
                    <td><strong>{{ $details['invoice']->currency }}
                            {{ number_format($details['invoice']->total - $details['invoice']->payments->sum('amount'), 2) }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Notes -->
        @if ($details['payment']->notes)
            <div style="margin-top: 20px;">
                <h4>Payment Notes:</h4>
                <p>{{ $details['payment']->notes }}</p>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>{{ $details['company']->name ?? 'Company Name' }}</p>
            <p>
                @if ($details['company']->address)
                    {{ $details['company']->address }}
                @endif
                @if ($details['company']->phone)
                    | Tel: {{ $details['company']->phone }}
                @endif
                @if ($details['company']->email)
                    | Email: {{ $details['company']->email }}
                @endif
            </p>
            <p>Thank you!</p>
        </div>
    </div>
</body>

</html>

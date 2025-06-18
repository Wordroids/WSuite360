<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .invoice-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .invoice-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .company-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 40px;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .company-details h2 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .company-details p {
            color: #666;
            font-size: 14px;
        }

        .contact-info {
            text-align: right;
        }

        .contact-info h3 {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .contact-info p {
            color: #666;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .invoice-body {
            padding: 30px;
        }

        .invoice-summary {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .invoice-description h3 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        .invoice-description p {
            color: #666;
            font-size: 14px;
        }

        .amount-due {
            text-align: right;
        }

        .amount-due p {
            color: #666;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .amount-due h2 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .bill-to h4,
        .invoice-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 12px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 8px;
        }

        .detail-row .label {
            color: #666;
            font-size: 14px;
            min-width: 100px;
        }

        .detail-row .value {
            color: #333;
            font-size: 14px;
            font-weight: 500;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table thead {
            background-color: #e3f2fd;
        }

        .items-table th {
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }

        .items-table th:last-child,
        .items-table td:last-child {
            text-align: right;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #eee;
        }

        .items-table td {
            padding: 12px 15px;
            font-size: 14px;
            color: #333;
        }

        .totals-section {
            margin-top: 20px;
            text-align: right;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 8px;
        }

        .total-row .label {
            color: #666;
            font-size: 14px;
            min-width: 120px;
            text-align: right;
            margin-right: 20px;
        }

        .total-row .value {
            color: #333;
            font-size: 14px;
            font-weight: 500;
            min-width: 120px;
        }

        .grand-total {
            border-top: 2px solid #ddd;
            padding-top: 12px;
            margin-top: 12px;
        }

        .grand-total .label {
            font-weight: 600;
            font-size: 16px;
        }

        .grand-total .value {
            font-weight: 700;
            font-size: 18px;
        }

        .notes-section {
            margin-top: 40px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .section-content {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .payment-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: white;
            background-color: #9E9E9E;
        }

        .status-paid {
            background-color: #4CAF50;
        }

        .status-pending, .status-sent {
            background-color: #FF9800;
        }

        .status-overdue {
            background-color: #F44336;
        }

        .company-logo {
            max-height: 60px;
            max-width: 120px;
        }

        /* PDF-specific styles */
        @page {
            margin: 15px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="invoice-title">Invoice #{{ $invoice->invoice_number }}</div>
            <div class="header-content">
                <div class="company-info">
                    @if($company && $company->logo)
                        <img src="{{ isset($company->base64_logo) ? $company->base64_logo : public_path('storage/' . $company->logo) }}" class="company-logo" alt="{{ $company->name }}">
                    @else
                        <div class="logo"></div>
                    @endif
                    <div class="company-details">
                        <h2>{{ $company->name ?? 'Company Name' }}</h2>
                        <p>{{ $company->address ?? '' }}</p>
                    </div>
                </div>
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <p>{{ $company->email ?? '' }}</p>
                    <p>{{ $company->phone ?? '' }}</p>
                    @if($company->vat_number)
                        <p>VAT: {{ $company->vat_number }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="invoice-body">
            <div class="invoice-summary">
                <div class="invoice-description">
                    <h3>{{ $invoice->title ?? 'Invoice' }}</h3>
                    <p>{{ $invoice->description ?? '' }}</p>
                    <div style="margin-top: 10px;">
                        @if($invoice->status === 'paid')
                            <span class="payment-status status-paid">PAID</span>
                        @elseif($invoice->status === 'draft')
                            <span class="payment-status">DRAFT</span>
                        @elseif($invoice->status === 'overdue')
                            <span class="payment-status status-overdue">OVERDUE</span>
                        @elseif($invoice->status === 'sent')
                            <span class="payment-status status-sent">SENT</span>
                        @else
                            <span class="payment-status">{{ strtoupper($invoice->status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="amount-due">
                    <p>Amount Due ({{ $invoice->currency }})</p>
                    <h2>{{ $invoice->currency }} {{ number_format($invoice->due, 2) }}</h2>
                </div>
            </div>

            <div class="invoice-details">
                <div class="bill-to">
                    <h4>Bill to</h4>
                    <div class="detail-row">
                        <span class="label">Client</span>
                        <span class="value">: {{ $invoice->client->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Email</span>
                        <span class="value">: {{ $invoice->client->email }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Phone</span>
                        <span class="value">: {{ $invoice->client->phone }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Address</span>
                        <span class="value">: {{ $invoice->client->address }}</span>
                    </div>
                </div>
                <div class="invoice-info">
                    <h4>Invoice Details</h4>
                    <div class="detail-row">
                        <span class="label">Invoice No.</span>
                        <span class="value">: {{ $invoice->invoice_number }}</span>
                    </div>
                    @if($invoice->po_so_number)
                    <div class="detail-row">
                        <span class="label">PO/SO Number</span>
                        <span class="value">: {{ $invoice->po_so_number }}</span>
                    </div>
                    @endif
                    <div class="detail-row">
                        <span class="label">Invoice Date</span>
                        <span class="value">: {{ $invoice->invoice_date->format('d M Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Due Date</span>
                        <span class="value">: {{ $invoice->due_date->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price ({{ $invoice->currency }})</th>
                        <th>Amount ({{ $invoice->currency }})</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td>
                            <strong>{{ optional($item->project)->name ?? 'General' }}</strong>
                            <div style="font-size: 12px; color: #666;">{{ $item->description }}</div>
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $invoice->currency }} {{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $invoice->currency }} {{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals-section">
                <div class="total-row">
                    <span class="label">Sub Total :</span>
                    <span class="value">{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                
                @if($invoice->tax_amount > 0)
                <div class="total-row">
                    <span class="label">Tax :</span>
                    <span class="value">{{ $invoice->currency }} {{ number_format($invoice->tax_amount, 2) }}</span>
                </div>
                @endif
                
                @if($invoice->discount_amount > 0)
                <div class="total-row">
                    <span class="label">Discount :</span>
                    <span class="value">-{{ $invoice->currency }} {{ number_format($invoice->discount_amount, 2) }}</span>
                </div>
                @endif
                
                <div class="total-row">
                    <span class="label">Total :</span>
                    <span class="value">{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</span>
                </div>
                
                @if($payments && $payments->sum('amount') > 0)
                <div class="total-row">
                    <span class="label">Paid :</span>
                    <span class="value">{{ $invoice->currency }} {{ number_format($payments->sum('amount'), 2) }}</span>
                </div>
                
                <div class="total-row grand-total">
                    <span class="label">Amount Due :</span>
                    <span class="value">{{ $invoice->currency }} {{ number_format($invoice->due, 2) }}</span>
                </div>
                @else
                <div class="total-row grand-total">
                    <span class="label">Grand total ({{ $invoice->currency }}) :</span>
                    <span class="value">{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</span>
                </div>
                @endif
            </div>

            <div class="notes-section">
                @if($invoice->notes)
                <div class="section-title">Notes</div>
                <div class="section-content">{{ $invoice->notes }}</div>
                @endif

                @if($invoice->instructions)
                <div class="section-title">Payment Instructions</div>
                <div class="section-content">{{ $invoice->instructions }}</div>
                @endif

                @if($invoice->footer)
                <div class="section-title">Footer Notes</div>
                <div class="section-content">{{ $invoice->footer }}</div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
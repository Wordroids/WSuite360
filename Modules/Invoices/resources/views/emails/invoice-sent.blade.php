<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <div style="background: #f8fafc; padding: 20px; text-align: center;">
            <h1 style="color: #374151; margin: 0;">Invoice #{{ $invoice->invoice_number }}</h1>
        </div>

        <div style="padding: 20px;">
            <p>Dear {{ $invoice->client->name }},</p>

            <p>Please find your invoice #{{ $invoice->invoice_number }} attached to this email.</p>

            <div style="background: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <p style="margin: 0;"><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('F d, Y') }}</p>
                <p style="margin: 5px 0 0 0;"><strong>Due Date:</strong> {{ $invoice->due_date->format('F d, Y') }}</p>
                <p style="margin: 5px 0 0 0;"><strong>Total Amount:</strong> {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</p>
            </div>

            <p>If you have any questions regarding this invoice, please don't hesitate to contact us.</p>

            <p>Best regards,<br>
            {{ $company->company_name }}</p>
        </div>

        <div style="background: #f8fafc; padding: 15px; text-align: center; font-size: 12px; color: #6b7280;">
            <p style="margin: 0;">{{ $company->company_name }}<br>
            {{ $company->address }}, {{ $company->city }}, {{ $company->country }}<br>
            {{ $company->phone }} | {{ $company->email }}</p>
        </div>
    </div>
</body>
</html>

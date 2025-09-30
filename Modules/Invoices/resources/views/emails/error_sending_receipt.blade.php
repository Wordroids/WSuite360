<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error Sending Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .error-details {
            background: #f8d7da;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #dc3545;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1 style="color: #dc3545;">❌ Error Sending Receipt</h1>
            <p>There was an issue sending a payment receipt to the client.</p>
        </div>

        <!-- Error Details -->
        <div class="error-details">
            <h3>Error Information</h3>
            <table class="details-table">
                <tr>
                    <td><strong>Time:</strong></td>
                    <td>{{ now()->format('Y-m-d H:i:s') }}</td>
                </tr>
                <tr>
                    <td><strong>Invoice Number:</strong></td>
                    <td>{{ $details['invoice_number'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Client Email:</strong></td>
                    <td>{{ $details['client_email'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Payment Amount:</strong></td>
                    <td>{{ $details['currency'] ?? '' }} {{ number_format($details['amount'] ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Error Message:</strong></td>
                    <td>{{ $details['error_message'] ?? 'Unknown error occurred' }}</td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>

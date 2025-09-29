<?php

return [
    'name' => 'Invoices',
    'emails' => [
        'invoice_subject' => 'Invoice #:invoice_number',
        'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
        'from_name' => env('MAIL_FROM_NAME', 'Invoice System'),
    ],
];

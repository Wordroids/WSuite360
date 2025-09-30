<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Invoices\Models\Invoice;
use Modules\Invoices\Models\InvoicePayment;

class SendReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $payment;
    public $company;
    public $client;

    public function __construct(Invoice $invoice, InvoicePayment $payment, $company)
    {
        $this->invoice = $invoice;
        $this->payment = $payment;
        $this->company = $company;
        $this->client = $invoice->client;
    }

    public function build()
    {
        return $this->subject('Payment Receipt - Invoice #' . $this->invoice->invoice_number)
            ->view('invoices::emails.receipt')
            ->with([
                'details' => [
                    'invoice' => $this->invoice,
                    'payment' => $this->payment,
                    'company' => $this->company,
                    'client' => $this->client,
                ]
            ]);
    }
}

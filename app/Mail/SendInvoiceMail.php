<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Invoices\Models\Invoice;

class SendInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invoice;
    public $company;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, $company)
    {
        $this->invoice = $invoice;
        $this->company = $company;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Invoice #' . $this->invoice->invoice_number . ' from ' . $this->company->company_name)
            ->view('invoices::emails.invoice-sent');
    }
}

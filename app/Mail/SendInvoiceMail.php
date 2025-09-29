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
    public $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, $company, $pdfContent)
    {
        $this->invoice = $invoice;
        $this->company = $company;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $filename = 'invoice-' . $this->invoice->invoice_number . '.pdf';

        return $this->subject('Invoice #' . $this->invoice->invoice_number . ' from ' . $this->company->company_name)
                    ->view('invoices::emails.invoice-sent')
                    ->attachData($this->pdfContent, $filename, [
                        'mime' => 'application/pdf',
                    ]);
    }


}

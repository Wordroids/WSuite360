<?php

namespace Modules\Invoices\Apps\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Invoices\Models\Invoice;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $filePath;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, string $filePath)
    {
        $this->invoice = $invoice;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Invoice #' . $this->invoice->invoice_number . ' - ' . config('app.name'))
            ->view('invoices::emails.invoice')
            ->attach($this->filePath, [
                'as' => 'invoice-' . $this->invoice->invoice_number . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}

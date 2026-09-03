<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        // 1. Generate lampiran PDF menggunakan template PDF teroptimasi DomPDF
        $pdf = Pdf::loadView('transactions.pdf_ticket', ['transaction' => $this->transaction]);

        // 2. Kirim email dengan tampilan emails.ticket dan lampirkan file PDF
        return $this->subject('E-Ticket Resmi: ' . ($this->transaction->event->name ?? 'Event') . ' - #' . $this->transaction->order_id)
                    ->view('emails.ticket')
                    ->attachData($pdf->output(), 'E-Ticket-' . $this->transaction->order_id . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}

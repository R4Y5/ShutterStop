<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use PDF; // from barryvdh/laravel-dompdf

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        // Generate PDF receipt
        $pdf = PDF::loadView('pdf.receipt', ['order' => $this->order]);

        return $this->subject('Order Status Updated')
                    ->view('emails.status_updated')
                    ->attachData($pdf->output(), 'receipt.pdf');
    }
}

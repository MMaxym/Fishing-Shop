<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $products;
    public $shippingMethod;
    public $pdfContent;

    public function __construct($order, $user, $products, $shippingMethod, $pdfContent)
    {
        $this->order = $order;
        $this->user = $user;
        $this->products = $products ?: [];
        $this->shippingMethod = $shippingMethod;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject("Чек на замовлення №{$this->order->id}")
            ->view('emails.order_receipt')
            ->with([
                'order' => $this->order,
                'products' => $this->products,
            ])
            ->attachData($this->pdfContent, "Order_Receipt_{$this->order->id}.pdf", [
                'mime' => 'application/pdf',
            ]);
    }

}

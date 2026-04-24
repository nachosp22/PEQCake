<?php
namespace App\Mail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct(public Order $order) {}
    public function envelope(): Envelope
    {
        $orderNumber = str_pad((string) $this->order->id, 5, '0', STR_PAD_LEFT);

        return new Envelope(subject: 'PEQ Cakes | Pedido #'.$orderNumber.' confirmado!');
    }

    public function headers(): Headers
    {
        return new Headers(text: [
            'X-PEQ-Notification' => 'order-payment-confirmation',
        ]);
    }

    public function content(): Content { return new Content(view: 'emails.payment-confirmation'); }
    public function attachments(): array { return []; }
}

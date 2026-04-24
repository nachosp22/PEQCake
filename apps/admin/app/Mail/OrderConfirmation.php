<?php
namespace App\Mail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct(public Order $order) {}
    public function envelope(): Envelope
    {
        $orderNumber = str_pad((string) $this->order->id, 4, '0', STR_PAD_LEFT);

        return new Envelope(subject: 'PEQ Cakes | Hemos recibido tu pedido #'.$orderNumber);
    }

    public function headers(): Headers
    {
        return new Headers(text: [
            'X-PEQ-Notification' => 'order-confirmation',
        ]);
    }

    public function content(): Content { return new Content(view: 'emails.order-confirmation'); }
    public function attachments(): array { return []; }
}

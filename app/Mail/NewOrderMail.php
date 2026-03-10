<?php
namespace App\Mail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope {
        return new Envelope(
            subject: '🍪 New Order #'.$this->order->id.' – '.$this->order->full_name.' (₱'.number_format($this->order->total,2).')',
        );
    }

    public function content(): Content {
        return new Content(view: 'emails.new-order');
    }
}

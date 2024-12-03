<?php

namespace App\Mail;

use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RefundVoucherMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The voucher instance.
     *
     * @var Voucher
     */
    public $voucher;
    public $order_code; 

    /**
     * Create a new message instance.
     *
     * @param Voucher $voucher
     * @param string $order_code
     */
    public function __construct(Voucher $voucher, string $order_code)
    {
        $this->voucher = $voucher;
        $this->order_code = $order_code; // Gán mã đơn hàng
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hoàn tiền Voucher cho đơn hàng #' . $this->order_code, // Cập nhật tiêu đề
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.refund_voucher', 
            with: [
                'voucherAmount' => $this->voucher->discount_amount,
                'voucherCode' => $this->voucher->sku,
                'expiryDate' => $this->voucher->end->format('d/m/Y'), // Hạn sử dụng voucher
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
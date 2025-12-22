<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoucherCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $voucher;

    public function __construct($voucher)
    {
        $this->voucher = $voucher;
    }

    public function build()
    {
        return $this->subject('Kode Voucher Anda dari YusrilNet')
                    ->view('emails.voucher');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucherCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $voucher;
    public $order;

    public function __construct($voucher, $order = null)
    {
        $this->voucher = $voucher;
        $this->order = $order ?? ($voucher ? $voucher->order : null);
    }

    public function build()
    {
        $paketNama = $this->voucher->nama ?? ($this->voucher->paket->nama ?? 'WiFi YusrilNet');
        return $this->subject('Kode Voucher WiFi Anda - ' . $paketNama)
                    ->view('emails.voucher');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email? : Email tujuan pengujian}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uji coba pengiriman email SMTP/Webmail dari Laravel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $toEmail = $this->argument('email') ?? config('mail.from.address') ?? 'sidikwaluya25@gmail.com';

        $this->info("=== Pengujian Pengiriman Email Laravel ===");
        $this->info("Mailer        : " . config('mail.default'));
        $this->info("Host          : " . config('mail.mailers.smtp.host'));
        $this->info("Port          : " . config('mail.mailers.smtp.port'));
        $this->info("Encryption    : " . (config('mail.mailers.smtp.encryption') ?? 'none'));
        $this->info("Username      : " . config('mail.mailers.smtp.username'));
        $this->info("From Address  : " . config('mail.from.address'));
        $this->info("From Name     : " . config('mail.from.name'));
        $this->info("Email Tujuan  : " . $toEmail);
        $this->line("-----------------------------------------");
        $this->info("Mengirim email uji coba...");

        try {
            Mail::raw("Halo! Ini adalah email uji coba dari sistem YusrilNet pada " . now()->format('Y-m-d H:i:s') . ". Pengiriman email server Anda berjalan dengan lancar!", function ($message) use ($toEmail) {
                $message->to($toEmail)
                        ->subject('Uji Coba Pengiriman Email YusrilNet');
            });

            $this->info("✅ BERHASIL: Email uji coba telah sukses dikirim ke {$toEmail}!");
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ GAGAL: Terjadi kesalahan saat mengirim email:");
            $this->error($e->getMessage());
            Log::error("TestMailCommand failed: " . $e->getMessage(), ['exception' => $e]);
            return 1;
        }
    }
}

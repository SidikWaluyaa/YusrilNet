<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Mail\VoucherCodeMail;
use App\Services\IPaymuService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek status pembayaran yang menggantung ke iPaymu secara otomatis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan status pembayaran...');

        // Cari order yang masih menunggu dan punya session id
        $pendingOrders = Order::where('status', 'menunggu')
            ->whereNotNull('snap_token')
            ->where('created_at', '>=', now()->subHours(24))
            ->get();

        if ($pendingOrders->isEmpty()) {
            $this->comment('Tidak ada pesanan yang perlu dicek.');
            return;
        }

        $ipaymu = new IPaymuService();

        foreach ($pendingOrders as $order) {
            $this->info("Mengecek Order ID: {$order->id} (Session: {$order->snap_token})");

            try {
                // Gunakan snap_token (SessionID) untuk cek status
                $transaction = $ipaymu->checkTransactionStatus($order->snap_token);

                if ($transaction && ($transaction['Status'] == 1 || $transaction['Status'] == 6)) {
                    $statusUpdated = false;
                    
                    DB::transaction(function () use ($order, &$statusUpdated) {
                        $freshOrder = Order::lockForUpdate()->find($order->id);
                        if ($freshOrder && $freshOrder->status === 'menunggu') {
                            $freshOrder->update(['status' => 'terkirim']);
                            if ($freshOrder->voucher) {
                                $freshOrder->voucher->update(['status' => 'nonaktif', 'available' => 0]);
                            }
                            $statusUpdated = true;
                        }
                    });

                    if ($statusUpdated) {
                        $this->warn("Order ID {$order->id} BERHASIL dibayar. Mengirim email...");
                        Mail::to($order->email)->send(new VoucherCodeMail($order->voucher));
                        Log::info('Order auto-reconciled via Command', ['orderId' => $order->id]);
                    }
                } else {
                     $this->line("Order ID {$order->id} masih belum dibayar atau gagal.");
                }
            } catch (\Exception $e) {
                $this->error("Gagal mengecek Order {$order->id}: " . $e->getMessage());
                Log::error("Reconciliation Error for Order {$order->id}", ['error' => $e->getMessage()]);
            }
        }

        $this->info('Pengecekan selesai.');
    }
}

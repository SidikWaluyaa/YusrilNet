<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpirePendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batalkan order yang pending lebih dari 20 menit';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $minutes = 2;
        $cutoffTime = now()->subMinutes($minutes);

        $orders = Order::where('status', 'menunggu')
            ->where('created_at', '<', $cutoffTime)
            ->get();

        $count = 0;

        foreach ($orders as $order) {
            DB::transaction(function () use ($order) {
                // Update status order
                $order->update(['status' => 'dibatalkan']);

                // Kembalikan voucher jika ada
                if ($order->voucher) {
                    $order->voucher()->update([
                        'status' => 'aktif',
                        'available' => 1
                    ]);
                }
            });
            
            Log::info("Order ID {$order->id} telah dibatalkan otomatis karena expired.");
            $this->info("Order ID {$order->id} dibatalkan.");
            $count++;
        }

        $this->info("Total {$count} order expired berhasil dibatalkan.");
        return 0;
    }
}

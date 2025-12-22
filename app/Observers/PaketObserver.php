<?php

namespace App\Observers;

use App\Models\Paket;
use App\Models\Voucher;

class PaketObserver
{
    /**
     * Handle the Paket "created" event.
     */
    public function created(Paket $paket): void
    {
        // Pastikan sold diinisialisasi ke 0 saat paket dibuat
        $paket->sold = 0;
        $paket->save();
    }

    /**
     * Handle the Paket "updated" event.
     */
    public function updated(Paket $paket): void
    {
        // Jika paket di-non-aktifkan, reset penjualan
        if ($paket->isDirty('available') && $paket->available == 0) {
            $paket->sold = 0;
            $paket->save();
        }
    }

    /**
     * Validasi sebelum paket dijual
     */
    public function validatePaketSale(Paket $paket): bool
    {
        // Cek apakah paket tersedia
        if ($paket->available == 0) {
            return false;
        }

        // Cek apakah masih ada voucher tersedia
        $availableVouchers = Voucher::where('paket_id', $paket->id)
            ->where('status', 'available')
            ->count();

        return $availableVouchers > 0;
    }
}

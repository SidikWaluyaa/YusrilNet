<?php

namespace App\Exports;

use App\Models\Voucher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VouchersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Mengambil semua data voucher dari database.
    * Kita menggunakan with('paket') untuk efisiensi (menghindari N+1 problem).
    *
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Voucher::with('paket')->get();
    }

    /**
     * Mendefinisikan baris header untuk file Excel.
     * Ini harus sama persis dengan template Anda.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Username',
            'Password',
            'Profile',
            'Time Limit',
            'Data Limit',
            'Comment'
        ];
    }

    /**
     * Memetakan data dari setiap objek Voucher ke format array yang diinginkan.
     * Fungsi ini akan dipanggil untuk setiap baris data.
     *
     * @param mixed $voucher
     * @return array
     */
    public function map($voucher): array
    {
        return [
            // Kolom 1: Username
            $voucher->username,

            // Kolom 2: Password
            $voucher->password,

            // Kolom 3: Profile (diambil dari nama paket yang berelasi)
            $voucher->paket->nama ?? 'N/A', // Menggunakan ?? 'N/A' agar aman jika relasi paket tidak ada

            // Kolom 4: Time Limit (dibiarkan kosong sesuai template)
            '',

            // Kolom 5: Data Limit (dibiarkan kosong sesuai template)
            '',

            // Kolom 6: Comment (dibiarkan kosong sesuai template)
            '',
        ];
    }
}

<?php

namespace App\Imports;

use App\Models\Voucher;
use App\Models\Paket;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Str;

class VouchersImport implements ToModel, WithHeadingRow, WithValidation, \Maatwebsite\Excel\Concerns\WithColumnFormatting
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Ambil nama profil dari CSV (menggunakan key dengan huruf kapital)
        $profileName = $row['profile'];

        // --- Logika Cerdas untuk Parsing Profile ---
        $price = 0;
        $duration = 0;

        // 1. Ekstrak harga (menghapus "Rp" dan ".")
        // Contoh: "Rp20.000" akan menjadi 20000
        preg_match('/Rp([\d\.]+)/', $profileName, $priceMatches);
        if (isset($priceMatches[1])) {
            $price = (int) str_replace('.', '', $priceMatches[1]);
        }

        // 2. Ekstrak durasi (mengambil angka sebelum "Hari")
        // Contoh: "/7Hari" akan menjadi 7
        preg_match('/\/(\d+)Hari/', $profileName, $durationMatches);
        if (isset($durationMatches[1])) {
            $duration = (int) $durationMatches[1];
        }
        // Catatan: Jika Anda punya durasi dalam jam (misal /24Jam), Anda bisa menambahkan logika di sini.

        // Langkah 1: Cari paket berdasarkan nama profil.
        // Jika tidak ditemukan, buat paket baru dengan data yang sudah diparsing.
        $paket = Paket::firstOrCreate(
            ['nama' => $profileName], // Kunci pencarian adalah nama profil lengkap
            [
                // Data ini akan diisi jika paket baru dibuat
                'price'         => $price,
                'duration'      => $duration, // Durasi dalam hari
                'deskripsi'     => 'Paket ' . $profileName . ' dibuat otomatis via import Mikhmon.',
                'detail_paket'  => json_encode(['info' => 'Data diimpor dari Mikhmon.']),
                'available'     => 1,
                'sold'          => 0,
            ]
        );

        // Langkah 2: Buat voucher baru dan hubungkan dengan paketnya.
        // Nama voucher diambil dari nama paket (profile).
        return new Voucher([
            'paket_id' => $paket->id,
            'nama'     => $paket->nama, // Nama voucher sama dengan nama paket
            'username' => $row['username'],
            'password' => $row['password'],
            'price'    => $paket->price,    // Ambil harga dari paket
            'duration' => $paket->duration, // Ambil durasi dari paket
            'available'=> 1,
            'status'   => 'aktif',
        ]);
    }

    /**
     * Aturan validasi untuk setiap baris.
     * Menggunakan header dengan huruf kapital sesuai file CSV.
     * @return array
     */
    public function rules(): array
    {
        return [
            'profile' => 'required|string|max:255',
            'username' => 'required|string|unique:vouchers,username',
            'password' => 'required',
        ];
    }

    /**
     * Pesan error kustom untuk validasi.
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'profile.required'  => 'Kolom Profile (nama paket) wajib diisi.',
            'username.required' => 'Kolom Username wajib diisi.',
            'username.unique'   => 'Username ":input" sudah ada di database.',
            'password.required' => 'Kolom Password wajib diisi.',
        ];
    }

    /**
     * Mapping untuk mengubah header dari CSV ke huruf kecil.
     * Ini membuat kita bisa menggunakan $row['username'] meskipun di file aslinya 'Username'.
     */
    public function headingRow(): int
    {
        return 1; // Baris ke-1 adalah header
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }
}

// Catatan: Maatwebsite/Excel versi 3.x secara default mengubah header menjadi "snake_case" dan lowercase.
// Jadi, 'Username' menjadi 'username', 'Time Limit' menjadi 'time_limit', dan 'Profile' menjadi 'profile'.
// Oleh karena itu, kita tetap menggunakan key huruf kecil di dalam kode ($row['profile']), dan library akan menanganinya secara otomatis.

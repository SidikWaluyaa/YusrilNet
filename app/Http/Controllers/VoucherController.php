<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\VouchersExport;
use App\Imports\VouchersImport;
use Maatwebsite\Excel\Facades\Excel;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::with('paket');

        // Filter Status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter Paket
        if ($request->paket_id) {
            $query->where('paket_id', $request->paket_id);
        }

        // Filter Username
        if ($request->username) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }

        // Pagination
        $vouchers = $query->paginate(10);
        $pakets = Paket::all();

        return view('vouchers.index', compact('vouchers', 'pakets'));
    }

    public function create()
    {
        $pakets = Paket::all();
        return view('vouchers.create', compact('pakets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required',
            'jumlah'   => 'required|integer|min:1',
        ]);

        $paket = Paket::findOrFail($request->paket_id);

        // Looping sesuai jumlah yang diminta
        for ($i = 0; $i < $request->jumlah; $i++) {
            $username = 'USR-' . strtoupper(Str::random(6));
            $password = strtoupper(Str::random(8));

            Voucher::create([
                'paket_id' => $paket->id,
                'nama'     => $paket->nama,
                'username' => $username,
                'password' => $password,
                'price'    => $paket->price,
                'duration' => $paket->duration,
                'available'=> 1,
                'status'   => 'aktif',
            ]);
        }

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil ditambahkan');
    }

    public function show($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('vouchers.show', compact('voucher'));
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        $pakets = Paket::all();
        return view('vouchers.edit', compact('voucher', 'pakets'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            // Pastikan paket_id yang dikirim ada di tabel pakets
            'paket_id'  => 'required|exists:pakets,id',
            // Pastikan available adalah angka 0 atau 1
            'available' => 'required|integer|in:0,1',
            // Pastikan status adalah string
            'status'    => 'required|string'
        ]);

        // Cari voucher yang ingin di-update
        $voucher = Voucher::findOrFail($id);
        // Cari data paket baru (jika diubah)
        $paket = Paket::findOrFail($request->paket_id);

        // Hapus baris yang meng-generate username dan password baru.
        // $username = 'USR-' . strtoupper(Str::random(6)); <-- HAPUS
        // $password = strtoupper(Str::random(8)); <-- HAPUS

        // Lakukan update HANYA pada field yang relevan.
        // Username dan Password TIDAK diubah.
        $voucher->update([
            // Data yang mungkin berubah berdasarkan pilihan paket baru
            'paket_id' => $paket->id,
            'nama'     => $paket->nama,
            'price'    => $paket->price,
            'duration' => $paket->duration,

            // Data yang diubah dari form
            'available'=> $request->available,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil diperbarui');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dihapus');
    }

    /**
     * Delete all vouchers
     */
    public function destroyAll(Request $request)
    {
        try {
            // Hitung total voucher yang akan dihapus
            $totalVouchers = Voucher::count();

            if ($totalVouchers == 0) {
                return redirect()->route('admin.vouchers.index')->with('warning', 'Tidak ada voucher yang tersedia untuk dihapus');
            }

            // Hapus semua voucher menggunakan delete() karena ada foreign key constraint
            // Tidak bisa menggunakan truncate() karena ada relasi dengan tabel orders
            Voucher::query()->delete();

            return redirect()->route('admin.vouchers.index')->with('success', "Berhasil menghapus semua voucher ({$totalVouchers} voucher)");

        } catch (\Exception $e) {
            return redirect()->route('admin.vouchers.index')->with('error', 'Gagal menghapus voucher: ' . $e->getMessage());
        }
    }

    /**
     * Delete selected vouchers
     */
    public function destroySelected(Request $request)
    {
        $request->validate([
            'voucher_ids' => 'required|array',
            'voucher_ids.*' => 'exists:vouchers,id'
        ]);

        try {
            $deletedCount = Voucher::whereIn('id', $request->voucher_ids)->delete();

            return redirect()->route('admin.vouchers.index')->with('success', "Berhasil menghapus {$deletedCount} voucher");

        } catch (\Exception $e) {
            return redirect()->route('admin.vouchers.index')->with('error', 'Gagal menghapus voucher: ' . $e->getMessage());
        }
    }

    /**
     * Delete vouchers by filter
     */
    public function destroyByFilter(Request $request)
    {
        try {
            $query = Voucher::query();

            // Apply filters sama seperti di index
            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->paket_id) {
                $query->where('paket_id', $request->paket_id);
            }

            if ($request->username) {
                $query->where('username', 'like', '%' . $request->username . '%');
            }

            $deletedCount = $query->count();

            if ($deletedCount == 0) {
                return redirect()->route('admin.vouchers.index')->with('warning', 'Tidak ada voucher yang sesuai dengan filter untuk dihapus');
            }

            $query->delete();

            return redirect()->route('admin.vouchers.index')->with('success', "Berhasil menghapus {$deletedCount} voucher sesuai filter");

        } catch (\Exception $e) {
            return redirect()->route('admin.vouchers.index')->with('error', 'Gagal menghapus voucher: ' . $e->getMessage());
        }
    }

    /**
     * Export vouchers to Excel
     */
    public function export()
    {
        return Excel::download(new VouchersExport, 'vouchers_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('vouchers.import');
    }

    /**
     * Import vouchers from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new VouchersImport, $request->file('file'));
            return redirect()->route('admin.vouchers.index')->with('success', 'Data voucher berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk import
     */
    public function downloadTemplate()
    {
        // Gunakan header dengan huruf kapital agar mirip dengan ekspor Mikhmon
        $headers = [
            ['Username', 'Password', 'Profile', 'Time Limit', 'Data Limit', 'Comment'],
            ['voucher01', 'pass01', 'Rp5.000/1Hari', '', '', ''],
            ['voucher02', 'pass02', 'Rp20.000/7Hari', '', '', ''],
        ];

        return Excel::download(new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;

            public function __construct($data) {
                $this->data = $data;
            }

            public function array(): array {
                return $this->data;
            }
        }, 'template_import_mikhmon.xlsx');
    }
}

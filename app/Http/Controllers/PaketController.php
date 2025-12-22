<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function publicdeskripsi($id)
    {
        $paket = Paket::findOrFail($id);
        return view('publicdeskripsi', compact('paket')); // Kirim data paket ke view deskripsi.blade.php
    }
    public function deskripsi($id)
    {
        $paket = Paket::findOrFail($id);
        return view('deskripsi', compact('paket')); // Kirim data paket ke view deskripsi.blade.php
    }
    public function welcome()
    {
        $pakets = Paket::withCount(['vouchers as vouchers_available_count' => function ($query) {
            $query->where('available', 1)->where('status', 'aktif');
        }])->get();
        return view('welcome', compact('pakets')); // Kirim data paket ke view welcome.blade.php
    }
    // Menampilkan Data Paket
    public function index()
    {
        $pakets = Paket::with(['vouchers' => function ($query) {
            // Hanya akan mengambil voucher yang statusnya BUKAN 'used'.
            // Ganti 'status' dan 'used' sesuai dengan nama kolom dan nilai di database Anda.
            $query->where('available', '!=', '0');
        }])->get();

        return view('pakets.index', compact('pakets'));
    }

    // Menampilkan Form Create
    public function create()
    {
        return view('pakets.create');
    }

    // Simpan Paket Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'price' => 'required|integer',
            'duration' => 'required|integer',
            'deskripsi' => 'required',
            'detail_paket' => 'required|array',
            'available' => 'required|integer',
        ]);

        // Paket::create($request->all());
        Paket::create([
            'nama' => $request->nama,
            'price' => $request->price,
            'duration' => $request->duration,
            'deskripsi' => $request->deskripsi,
            'detail_paket' => json_encode($request->detail_paket, JSON_PRETTY_PRINT),
            'available' => $request->available,
            'sold' => 0,

        ]);
        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil ditambahkan');
    }

    // Menampilkan Data Paket Detail
    public function show($id)
    {
        $paket = Paket::findOrFail($id);
        return view('pakets.show', compact('paket'));
    }

    // Menampilkan Form Edit
    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('pakets.edit', compact('paket'));
    }

    // Update Paket
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'price' => 'required|integer',
            'duration' => 'required|integer',
            'deskripsi' => 'required',

            // --- PERBAIKAN UTAMA DI SINI ---
            // Pastikan kita memvalidasi bahwa 'detail_paket' yang dikirim dari form
            // adalah sebuah array, sama seperti pada fungsi store().
            'detail_paket' => 'required|array',
            'detail_paket.*' => 'required|string', // Validasi tambahan: setiap item di dalam array tidak boleh kosong.

            'available' => 'required|integer',
        ]);

        $paket = Paket::findOrFail($id);

        // Karena validasi di atas sudah memastikan $request->detail_paket adalah array,
        // proses encoding di bawah ini akan selalu aman dan benar.
        $paket->update([
            'nama' => $request->nama,
            'price' => $request->price,
            'duration' => $request->duration,
            'deskripsi' => $request->deskripsi,
            'detail_paket' => json_encode($request->detail_paket, JSON_PRETTY_PRINT),
            'available' => $request->available,
        ]);

        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil diperbarui');
    }

    // Hapus Paket
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil dihapus');
    }
}

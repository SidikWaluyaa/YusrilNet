<?php

namespace App\Http\Controllers;

use App\Mail\VoucherCodeMail;
use App\Models\Order;
use App\Models\Paket;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {


        $orders = Order::with(['paket', 'voucher', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Menggunakan pagination

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $pakets = Paket::all();
        return view('orders.create', compact('pakets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
        ]);

        $paket = Paket::findOrFail($request->paket_id);

        Order::create([
            'user_id'   => Auth::id(), // Admin yang membuat order
            'paket_id'  => $paket->id,
            'nama'      => $request->nama,
            'email'     => $request->email,
            'harga'     => $paket->harga,
            'status'    => 'pending', // Default status
            'payment_method' => 'manual', // Tandai sebagai manual order
            'payment_status' => 'unpaid'
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dibuat.');
    }

    // Edit order (hanya admin)
    public function edit($id)
    {


        $order = Order::findOrFail($id);
        $pakets = Paket::all();

        return view('orders.edit', compact('order', 'pakets'));
    }

    // Update order (hanya admin)
    public function update(Request $request, $id)
    {


        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'nama'     => 'required|string',
            'email'    => 'required|email',
            'status'   => 'required|in:menunggu,terkirim,batal,proses,selesai'
        ]);

        $order = Order::findOrFail($id);
        $paket = Paket::findOrFail($request->paket_id);

        $order->update([
            'paket_id' => $paket->id,
            'nama'     => $request->nama,
            'email'    => $request->email,
            'harga'    => $request->harga, // Menggunakan harga dari input form
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diperbarui.');
    }

    // Delete order (hanya admin)
    public function destroy($id)
    {

        $order = Order::findOrFail($id);



        $order->delete();

        // return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus.');
        return redirect()->back()->with('success', 'Order berhasil dihapus.');
    }
    public function deleteAll()
    {


        // Menonaktifkan pengecekan foreign key untuk sementara (jika diperlukan)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Menghapus semua data dari tabel orders menggunakan Truncate
        // Truncate lebih efisien dan otomatis mereset auto-increment
        Order::truncate();

        // Mengaktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('admin.orders.index')->with('success', 'Semua data order berhasil dihapus dan ID telah direset.');
    }

    public function printPdf(Request $request)
    {


        $query = Order::with(['paket', 'voucher', 'user'])->orderBy('created_at', 'desc');
        $query->where('status', 'terkirim');

        // Filter berdasarkan paket
        if ($request->filled('paket_id')) {
            $query->where('paket_id', $request->paket_id);
        }

        // Filter berdasarkan tanggal mulai dan akhir
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->tanggal_mulai . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59',
            ]);
        }

        $orders = $query->get();
        $filter = [
            'paket' => $request->filled('paket_id') ? Paket::find($request->paket_id)?->nama : null,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
        ];

        $pdf = Pdf::loadView('admin.pdf', compact('orders', 'filter'))->setPaper('A4', 'landscape');
        return $pdf->stream('laporan-penjualan.pdf');
    }


}

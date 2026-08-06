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
use App\Services\IPaymuService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Hitung statistik dengan query terpisah agar akurat (tidak terpengaruh pagination)
        $total_orders = Order::whereIn('status', ['terkirim', 'selesai'])->count();
        $total_selesai = Order::where('status', 'selesai')->count();
        // Pendapatan diambil dari order yang berhasil terkirim dan selesai
        $total_pendapatan = Order::whereIn('status', ['terkirim', 'selesai'])->sum('harga');

        $orders = Order::with(['paket', 'voucher', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Menggunakan pagination

        return view('orders.index', compact('orders', 'total_orders', 'total_selesai', 'total_pendapatan'));
    }

    /**
     * Konfirmasi manual order oleh Admin
     */
    public function confirmManual($id)
    {
        $order = Order::with(['paket', 'voucher'])->findOrFail($id);

        if ($order->status !== 'menunggu') {
            return redirect()->back()->with('info', "Order #{$id} sudah diproses atau dibatalkan.");
        }

        $voucherAssigned = false;

        DB::transaction(function () use ($order, &$voucherAssigned) {
            $freshOrder = Order::lockForUpdate()->find($order->id);
            if ($freshOrder->status !== 'menunggu') {
                return;
            }

            // Jika order belum memiliki voucher, alokasikan voucher aktif yang tersedia
            if (!$freshOrder->voucher_id) {
                $availableVoucher = Voucher::where('paket_id', $freshOrder->paket_id)
                    ->where('status', 'aktif')
                    ->where('available', 1)
                    ->lockForUpdate()
                    ->first();

                if ($availableVoucher) {
                    $freshOrder->voucher_id = $availableVoucher->id;
                    $availableVoucher->update(['status' => 'nonaktif', 'available' => 0]);
                    $voucherAssigned = true;
                }
            } else {
                if ($freshOrder->voucher) {
                    $freshOrder->voucher->update(['status' => 'nonaktif', 'available' => 0]);
                }
                $voucherAssigned = true;
            }

            $freshOrder->update(['status' => 'terkirim']);
        });

        $order->refresh();

        if ($order->status === 'terkirim') {
            if ($order->voucher) {
                try {
                    Mail::to($order->email)->send(new VoucherCodeMail($order->voucher, $order));
                    Log::info("Order #{$order->id} manually confirmed by Admin ID: " . Auth::id() . " & Email sent.");
                    return redirect()->back()->with('success', "Order #{$order->id} berhasil dikonfirmasi secara manual dan email voucher telah dikirim ke {$order->email}.");
                } catch (\Exception $e) {
                    Log::error("Order #{$order->id} manually confirmed, but email failed", ['error' => $e->getMessage()]);
                    return redirect()->back()->with('warning', "Order #{$order->id} berhasil dikonfirmasi, namun gagal mengirimkan email: {$e->getMessage()}");
                }
            }
            return redirect()->back()->with('success', "Order #{$order->id} berhasil dikonfirmasi secara manual.");
        }

        return redirect()->back()->with('error', "Gagal mengonfirmasi order #{$order->id}. Voucher tidak tersedia di sistem.");
    }

    /**
     * Cek status live iPaymu dan kembalikan data JSON untuk Modal Admin
     */
    public function checkIPaymuJson($id)
    {
        $order = Order::with(['paket', 'voucher'])->findOrFail($id);

        if (!$order->snap_token) {
            return response()->json([
                'success' => false,
                'message' => "Order #{$order->id} tidak memiliki Session ID / Snap Token iPaymu."
            ], 400);
        }

        $ipaymu = new IPaymuService();
        $transaction = $ipaymu->checkTransactionStatus($order->snap_token);

        // Jika iPaymu mengembalikan null (misal: buyer belum memilih metode bayar di iPaymu)
        if (!$transaction) {
            return response()->json([
                'success' => true,
                'is_paid' => false,
                'status_desc' => 'Belum Dibayar / Sesi Belum Diproses Pembeli',
                'transaction_id' => '-',
                'reference_id' => (string)$order->id,
                'amount' => $order->harga,
                'subtotal' => $order->harga,
                'fee' => 0,
                'payment_method' => '-',
                'payment_channel' => '-',
                'buyer_name' => $order->nama,
                'buyer_email' => $order->email,
                'created_date' => $order->created_at->format('Y-m-d H:i:s'),
                'paid_date' => null,
                'order' => [
                    'id' => $order->id,
                    'nama' => $order->nama,
                    'email' => $order->email,
                    'paket' => $order->paket->nama ?? '-',
                    'harga' => $order->harga,
                    'status' => $order->status,
                    'has_voucher' => !empty($order->voucher_id),
                ]
            ]);
        }

        $isPaid = $ipaymu->isPaid($transaction);
        $statusDesc = $transaction['StatusDesc'] ?? ($isPaid ? 'BERHASIL' : 'BELUM DIBAYAR');

        return response()->json([
            'success' => true,
            'is_paid' => $isPaid,
            'status_desc' => $statusDesc,
            'transaction_id' => $transaction['TransactionId'] ?? null,
            'reference_id' => $transaction['ReferenceId'] ?? null,
            'amount' => $transaction['Amount'] ?? $order->harga,
            'subtotal' => $transaction['SubTotal'] ?? $order->harga,
            'fee' => $transaction['Fee'] ?? 0,
            'payment_method' => $transaction['PaymentMethod'] ?? ($transaction['TypeDesc'] ?? '-'),
            'payment_channel' => $transaction['PaymentChannel'] ?? '-',
            'buyer_name' => $transaction['BuyerName'] ?? $order->nama,
            'buyer_email' => $transaction['BuyerEmail'] ?? $order->email,
            'created_date' => $transaction['CreatedDate'] ?? null,
            'paid_date' => $transaction['SuccessDate'] ?? null,
            'order' => [
                'id' => $order->id,
                'nama' => $order->nama,
                'email' => $order->email,
                'paket' => $order->paket->nama ?? '-',
                'harga' => $order->harga,
                'status' => $order->status,
                'has_voucher' => !empty($order->voucher_id),
            ]
        ]);
    }

    /**
     * Cek status live ke API iPaymu untuk order tertentu
     */
    public function syncStatus($id)
    {
        $order = Order::with(['paket', 'voucher'])->findOrFail($id);

        if (!$order->snap_token) {
            return redirect()->back()->with('error', "Order #{$order->id} tidak memiliki Session ID / Snap Token iPaymu.");
        }

        $ipaymu = new IPaymuService();
        $transaction = $ipaymu->checkTransactionStatus($order->snap_token);

        if ($transaction && $ipaymu->isPaid($transaction)) {
            $statusUpdated = false;

            DB::transaction(function () use ($order, &$statusUpdated) {
                $freshOrder = Order::lockForUpdate()->find($order->id);
                if ($freshOrder && $freshOrder->status === 'menunggu') {
                    if (!$freshOrder->voucher_id) {
                        $availableVoucher = Voucher::where('paket_id', $freshOrder->paket_id)
                            ->where('status', 'aktif')
                            ->where('available', 1)
                            ->lockForUpdate()
                            ->first();

                        if ($availableVoucher) {
                            $freshOrder->voucher_id = $availableVoucher->id;
                            $availableVoucher->update(['status' => 'nonaktif', 'available' => 0]);
                        }
                    } else if ($freshOrder->voucher) {
                        $freshOrder->voucher->update(['status' => 'nonaktif', 'available' => 0]);
                    }

                    $freshOrder->update(['status' => 'terkirim']);
                    $statusUpdated = true;
                }
            });

            $order->refresh();

            if ($statusUpdated && $order->voucher) {
                try {
                    Mail::to($order->email)->send(new VoucherCodeMail($order->voucher));
                    Log::info("Order #{$order->id} auto-synced via Admin Live Check & Email sent.");
                } catch (\Exception $e) {
                    Log::error("Order #{$order->id} synced, but mail failed", ['error' => $e->getMessage()]);
                }
            }

            return redirect()->back()->with('success', "Live Check iPaymu: Order #{$order->id} terdeteksi LUNAS! Status diperbarui ke Terkirim & email voucher dikirim.");
        }

        $statusDesc = $transaction['StatusDesc'] ?? 'Belum Dibayar';
        return redirect()->back()->with('info', "Live Check iPaymu: Order #{$order->id} berstatus '{$statusDesc}' di iPaymu.");
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['paket', 'voucher', 'user'])->findOrFail($id);
        return view('orders.show', compact('order'));
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

    public function destroySelected(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);

        try {
            $deletedCount = Order::whereIn('id', $request->order_ids)->delete();
            return redirect()->route('admin.orders.index')->with('success', "Berhasil menghapus {$deletedCount} order");
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Gagal menghapus order: ' . $e->getMessage());
        }
    }

    public function destroyByFilter(Request $request)
    {
        try {
            $query = Order::query();

            // Apply filters sama seperti di printPdf
            if ($request->filled('paket_id')) {
                $query->where('paket_id', $request->paket_id);
            }

            if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
                $query->whereBetween('created_at', [
                    $request->tanggal_mulai . ' 00:00:00',
                    $request->tanggal_akhir . ' 23:59:59',
                ]);
            }

            $deletedCount = $query->count();

            if ($deletedCount == 0) {
                return redirect()->route('admin.orders.index')->with('warning', 'Tidak ada order yang sesuai dengan filter untuk dihapus');
            }

            $query->delete();
            return redirect()->route('admin.orders.index')->with('success', "Berhasil menghapus {$deletedCount} order sesuai filter");

        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Gagal menghapus order: ' . $e->getMessage());
        }
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

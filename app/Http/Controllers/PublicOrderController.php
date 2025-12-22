<?php

namespace App\Http\Controllers;

use App\Mail\VoucherCodeMail;
use App\Models\Order;
use App\Models\Paket;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PublicOrderController extends Controller
{
    // ... (fungsi beli() tetap sama)
    public function beli($id)
    {
        $paket = Paket::findOrFail($id);
        $isAvailable = Voucher::where('paket_id', $id)->where('status', 'aktif')->where('available', 1)->exists();
        if (!$isAvailable) {
            return redirect()->route('tidaktersedia')->with('error', 'Mohon maaf, paket ini sudah habis.');
        }
        return view('public.beli', compact('paket'));
    }

    public function store(Request $request)
    {
        // ... (fungsi store() tidak perlu diubah, biarkan seperti semula)
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
        ]);
        $paket = Paket::findOrFail($request->paket_id);
        $order = null;
        // --- LOGIKA TRANSAKSI YANG DIPERBAIKI ---
        DB::transaction(function () use ($request, $paket, &$order) {
            // Langkah 1: Cari voucher yang tersedia dan KUNCI baris datanya.
            // Proses lain yang mencoba mengakses baris ini akan dipaksa menunggu.
            $voucher = Voucher::where('paket_id', $paket->id)
                ->where('status', 'aktif')->where('available', 1)
                ->lockForUpdate()->first();

            // Jika tidak ada voucher setelah menunggu, keluar.
            if (!$voucher) {
                return;
            }

            // Langkah 2: LANGSUNG tandai voucher ini sebagai tidak tersedia.
            // Ini adalah langkah kunci yang hilang sebelumnya.
            // Sekarang, bahkan setelah transaksi ini selesai, tidak ada proses lain
            // yang akan menemukan voucher ini lagi.
            $voucher->update(['available' => 0]);

            // Langkah 3: Buat order yang merujuk pada voucher yang sudah aman ini.
            $order = Order::create([
                'user_id'    => null,
                'paket_id'   => $paket->id,
                'voucher_id' => $voucher->id, // ID voucher yang sudah di-update
                'nama'       => $request->nama,
                'email'      => $request->email,
                'harga'      => $paket->price,
                'status'     => 'menunggu',
            ]);
        });
        if (!$order) {
            return redirect()->route('tidaktersedia')->with('error', 'Voucher tidak tersedia saat ini.');
        }
        $va        = config('services.ipaymu.va');
        $apiKey    = config('services.ipaymu.api_key');
        $ipaymuUrl = config('services.ipaymu.url');
        $body = [
            'product'     => [$paket->nama], 'qty'         => [1], 'price'       => [$paket->price],
            'returnUrl'   => route('public.order.return'), // <-- UBAH KE ROUTE BARU
            'cancelUrl'   => route('public.order.cancel', ['order_id' => $order->id]),
            'notifyUrl'   => route('ipaymu.callback'), // Biarkan saja, tidak apa-apa
            'referenceId' => (string) $order->id,
            'buyerName'   => $request->nama, 'buyerEmail'  => $request->email,
        ];
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = 'POST:' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature    = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp    = Date('YmdHis');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json', 'signature'    => $signature,
            'va'           => $va, 'timestamp'    => $timestamp,
        ])->post($ipaymuUrl, $body);
        $result = $response->json();
        if ($response->successful() && $result['Status'] == 200) {
            return redirect()->away($result['Data']['Url']);
        } else {
            Log::error('iPaymu Payment URL Error: ', $result);
            return back()->with('error', 'Gagal terhubung dengan gateway pembayaran.');
        }
    }

    public function cancelOrder($order_id)
    {
        $this->cancelOrderInternal($order_id);
        return redirect()->route('welcome')->with('error', 'Pembayaran Anda telah dibatalkan.');
    }

    /**
     * Logika internal untuk membatalkan order dan melepaskan voucher.
     * Bisa dipanggil dari berbagai tempat.
     */
    private function cancelOrderInternal($order_id)
    {
        $order = Order::where('id', $order_id)->where('status', 'menunggu')->first();
        if ($order) {
            DB::transaction(function () use ($order) {
                $order->update(['status' => 'dibatalkan']);
                if ($order->voucher) {
                    // Kembalikan voucher ke kondisi semula
                    $order->voucher()->update(['status' => 'aktif', 'available' => 1]);
                }
            });
        }
    }


    // --- FUNGSI BARU UNTUK MENANGANI RETURN URL ---
    public function handleReturnUrl(Request $request)
    {
        $status = $request->query('status');
        $trx_id = $request->query('trx_id');

        if ($status == 'berhasil' && $trx_id) {
            // Panggil fungsi untuk memeriksa status transaksi ke API iPaymu
            $transaction = $this->checkTransactionStatus($trx_id);

            if ($transaction && $transaction['Status'] == 1) { // Status 1 = Berhasil/Settlement
                $order = Order::find($transaction['ReferenceId']);

                // Pastikan order ada dan statusnya masih 'menunggu' untuk mencegah proses ganda
                if ($order && $order->status === 'menunggu') {
                    DB::transaction(function () use ($order) {
                        $order->update(['status' => 'terkirim']);
                        $order->voucher->update(['status' => 'nonaktif', 'available' => 0]);
                        Mail::to($order->email)->send(new VoucherCodeMail($order->voucher));
                    });
                }
                // Arahkan ke halaman sukses
                return redirect()->route('public.order.success', $order->id);
            }
        }

        // Jika status bukan 'berhasil' atau gagal verifikasi, arahkan ke halaman utama dengan pesan
        return redirect()->route('welcome')->with('error', 'Pembayaran gagal atau dibatalkan.');
    }

    // --- FUNGSI BARU UNTUK BERTANYA KE API IPAYMU ---
    private function checkTransactionStatus($transactionId)
    {
        $va        = config('services.ipaymu.va');
        $apiKey    = config('services.ipaymu.api_key');

        $body = ['transactionId' => $transactionId];
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = 'POST:' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature    = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp    = Date('YmdHis');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json', 'signature'    => $signature,
            'va'           => $va, 'timestamp'    => $timestamp,
        ])->post('https://sandbox.ipaymu.com/api/v2/transaction', $body); // URL untuk cek transaksi

        if ($response->successful() && $response->json()['Status'] == 200) {
            return $response->json()['Data'];
        }

        Log::error('iPaymu Check Status Error: ', $response->json());
        return null;
    }

    // handleCallback dan success() bisa Anda biarkan atau hapus jika mau
    public function handleCallback(Request $request) { /* ... */ }
    public function success($orderId)
    {
        $order = Order::with(['paket', 'voucher'])->findOrFail($orderId);
        return view('public.success', compact('order'));
    }
}

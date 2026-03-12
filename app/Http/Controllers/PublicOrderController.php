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
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|regex:/^[0-9]{10,13}$/',
        ]);

        $paket = Paket::findOrFail($request->paket_id);
        $order = null;

        DB::transaction(function () use ($request, $paket, &$order) {
            $voucher = Voucher::where('paket_id', $paket->id)
                ->where('status', 'aktif')
                ->where('available', 1)
                ->lockForUpdate()
                ->first();

            if (!$voucher) {
                return;
            }

            $voucher->update(['available' => 0]);

            $order = Order::create([
                'user_id'    => null,
                'paket_id'   => $paket->id,
                'voucher_id' => $voucher->id,
                'nama'       => $request->nama,
                'email'      => $request->email,
                'harga'      => $paket->price,
                'status'     => 'menunggu',
            ]);
        });

        if (!$order) {
            return redirect()->route('tidaktersedia')
                ->with('error', 'Voucher tidak tersedia saat ini.');
        }

        if (!$order) {
            return redirect()->route('tidaktersedia')
                ->with('error', 'Voucher tidak tersedia saat ini.');
        }

        // ==========================================
        // BYPASS PAYMENT FOR LOCAL TESTING (DISABLED)
        // ==========================================
        /*
        if (app()->isLocal()) {
            $statusUpdated = false;
            DB::transaction(function () use ($order, &$statusUpdated) {
                $order->update(['status' => 'terkirim']);
                if ($order->voucher) {
                    $order->voucher->update(['status' => 'nonaktif', 'available' => 0]);
                }
                $statusUpdated = true;
            });
            
            if ($statusUpdated && $order->voucher) {
                Mail::to($order->email)->send(new VoucherCodeMail($order->voucher));
            }
            
            Log::info('Local Payment Bypass: Order automatically approved', ['orderId' => $order->id]);
            
            return redirect()->route('public.order.success', ['orderId' => $order->id]);
        }
        */
        // ==========================================

        // Use iPaymu Service
        $ipaymu = new \App\Services\IPaymuService();
        
        // Membersihkan nama produk untuk Sandbox (Hanya huruf dan angka)
        $cleanProductName = preg_replace('/[^a-zA-Z0-9 ]/', '', $paket->nama);
        if (empty($cleanProductName)) $cleanProductName = 'Voucher Wifi';

        $paymentData = [
            'product'     => [$cleanProductName], // Nama produk bersih
            'qty'         => [1],                 // Integer murni
            'price'       => [(int)$paket->price], // Integer murni
            'returnUrl'   => route('public.order.return', ['orderId' => $order->id]),
            'cancelUrl'   => route('public.order.cancel', ['order_id' => $order->id]),
            'notifyUrl'   => route('public.order.callback', ['orderId' => $order->id]),
            'referenceId' => (string)$order->id,
            'buyerName'   => $request->nama,
            'buyerEmail'  => $request->email,
            'buyerPhone'  => $request->phone ?? '',
        ];

        $result = $ipaymu->createPayment($paymentData);

        if ($result['success']) {
            // Simpan SessionID iPaymu ke kolom snap_token untuk recon nanti
            $order->update(['snap_token' => $result['data']['Data']['SessionID']]);

            Log::info('Payment URL generated successfully', [
                'mode' => $ipaymu->getModeName(),
                'url' => $result['data']['Data']['Url']
            ]);
            return redirect()->away($result['data']['Data']['Url']);
        } else {
            Log::error('iPaymu Payment Error', [
                'mode' => $ipaymu->getModeName(),
                'status_code' => $result['status_code'],
                'result' => $result['data'],
            ]);
            return back()->with('error', 'Gagal membuat sesi pembayaran. Silakan coba lagi.');
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



    public function handleReturnUrl(Request $request)
    {
        $status = $request->query('status');
        $trx_id = $request->query('trx_id');

        if ($status == 'berhasil' && $trx_id) {
            $transaction = $this->checkTransactionStatus($trx_id);

            if ($transaction && $transaction['Status'] == 1) {
                // Extract order ID from reference format: ORDER-{id}-{timestamp}
                $referenceId = $transaction['ReferenceId'];
                $parts = explode('-', $referenceId);
                $orderId = isset($parts[1]) ? (int)$parts[1] : null;

                if (!$orderId) {
                    Log::error('Invalid reference ID format', ['referenceId' => $referenceId]);
                    return redirect()->route('welcome')->with('error', 'Format referensi pembayaran tidak valid.');
                }

                $order = Order::find($orderId);

                if (!$order) {
                    Log::error('Order not found', ['orderId' => $orderId]);
                    return redirect()->route('welcome')->with('error', 'Pesanan tidak ditemukan.');
                }

                if ($order->status === 'menunggu') {
                    DB::transaction(function () use ($order) {
                        $order->update(['status' => 'terkirim']);
                        $order->voucher->update(['status' => 'nonaktif', 'available' => 0]);
                        Mail::to($order->email)->send(new VoucherCodeMail($order->voucher));
                    });
                }

                return redirect()->route('public.order.success', $order->id);
            }
        }

        return redirect()->route('welcome')->with('error', 'Pembayaran gagal atau dibatalkan.');
    }


    private function checkTransactionStatus($transactionId)
    {
        $ipaymu = new \App\Services\IPaymuService();
        return $ipaymu->checkTransactionStatus($transactionId);
    }

    /**
     * Handle return URL - User clicked "Back to Merchant"
     * DO NOT auto-update status here! Only show current order status.
     */
    /**
     * Handle return URL - User clicked "Back to Merchant" or auto-redirect
     * ACTIVE CHECK: Check iPaymu status immediately because Callback might fail on localhost
     */
    public function returnUrl(Request $request, $orderId)
    {
        $order = Order::with(['paket', 'voucher'])->findOrFail($orderId);
        
        // 1. Jika URL callback sukses membawa trx_id dari iPaymu
        $trx_id = $request->query('trx_id');
        // 2. Jika tidak ada trx_id, kita pakai ReferenceId = orderId (Standar SidikNet ke iPaymu)
        // Note: API iPaymu CheckTransaction butuh TransactionId (trx_id), bukan ReferenceId. 
        // Namun, demi keamanan, kita hanya akan mengecek jika trx_id tersedia. Jika tidak, iPaymu gagal mengirimnya.
        
        if ($order->status === 'menunggu') {
            if ($trx_id) {
                 $transaction = $this->checkTransactionStatus($trx_id);
                 
                 // 1=Success, 6=Paid/Settled
                 if ($transaction && ($transaction['Status'] == 1 || $transaction['Status'] == 6)) { 
                     
                     $statusUpdated = false;
                     DB::transaction(function () use ($order, &$statusUpdated) {
                        // Double check agar tidak dobel update jika webhook ternyata masuk duluan
                        $freshOrder = Order::lockForUpdate()->find($order->id);
                        if ($freshOrder->status === 'menunggu') {
                            $freshOrder->update(['status' => 'terkirim']);
                            if ($freshOrder->voucher) {
                                $freshOrder->voucher->update(['status' => 'nonaktif', 'available' => 0]);
                            }
                            $statusUpdated = true;
                        }
                    });
                    
                    // Email dikirim SETELAH transaksi DB selesai dan di-commit
                    if ($statusUpdated && $order->voucher) {
                        Mail::to($order->email)->send(new VoucherCodeMail($order->voucher));
                        Log::info('Order updated & Email sent via Return URL check', ['orderId' => $orderId]);
                    }
                    
                    // Redirect ke halaman sukses final
                    return redirect()->route('public.order.success', ['orderId' => $order->id]);
                 }
            } else {
               // Fallback: Jika iPaymu melempar ke ReturnURL tapi TANPA trx_id, 
               // Atau nge-blank. Kemungkinan user cancel atau close tab sebelum beres.
               Log::warning('Return URL accessed without trx_id for pending order', [
                   'orderId' => $orderId,
                   'query' => $request->all()
               ]);
            }
        }
        
        // Jika sudah sukses terkirim (oleh webhook atau pengecekan barusan)
        if ($order->fresh()->status === 'terkirim') {
            return redirect()->route('public.order.success', ['orderId' => $order->id]);
        }
        
        // Jika status masih menunggu, tampilkan warning ke user
        return view('public.order-status', compact('order'))->with('error', 'Pembayaran sedang diproses / belum berstatus Lunas di sistem kami. Harap refresh halaman ini berkala.');
    }

    /**
     * Handle callback URL - iPaymu payment notification
     * This is where we verify and update payment status
     */
    public function callback(Request $request, $orderId)
    {
        // Log callback for debugging
        Log::info('=== iPaymu Callback Received ===', [
            'orderId' => $orderId,
            'request_data' => $request->all(),
        ]);

        $order = Order::with(['paket', 'voucher'])->findOrFail($orderId);

        // Only update if still pending
        if ($order->status === 'menunggu') {
            // Verify payment status from iPaymu
            $trx_id = $request->input('trx_id');
            
            if ($trx_id) {
                $transaction = $this->checkTransactionStatus($trx_id);
                
                // Only update if payment is confirmed
                if ($transaction && $transaction['Status'] == 1) {
                    $statusUpdated = false;
                    DB::transaction(function () use ($order, &$statusUpdated) {
                        $order->update(['status' => 'terkirim']);
                        if ($order->voucher) {
                            $order->voucher->update(['status' => 'nonaktif', 'available' => 0]);
                        }
                        $statusUpdated = true;
                    });
                    
                    if ($statusUpdated && $order->voucher) {
                        // Send email with voucher code in background
                        Mail::to($order->email)->send(new VoucherCodeMail($order->voucher));
                        Log::info('Order payment confirmed via Callback & Email queued', ['orderId' => $orderId]);
                    }
                }
            }
        }

        // Return JSON response for iPaymu server
        return response()->json([
            'success' => true,
            'message' => 'Callback received',
            'order_id' => $orderId,
        ]);
    }
    /**
     * Success page - Show order details after payment
     */
    public function success($orderId)
    {
        $order = Order::with(['paket', 'voucher'])->findOrFail($orderId);
        
        // Only show success if order is actually paid
        if ($order->status !== 'terkirim') {
            return redirect()->route('public.order.return', $orderId)
                ->with('warning', 'Pembayaran Anda masih dalam proses verifikasi.');
        }
        
        return view('public.success', compact('order'));
    }
}

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

        // iPaymu Configuration
        $va = config('services.ipaymu.va');
        $apiKey = config('services.ipaymu.api_key');
        $baseUrl = config('services.ipaymu.base_url');
        $url = $baseUrl . '/payment';

        // Generate simple reference ID (just order ID)
        $referenceId = (string)$order->id;

        // Build request payload
        $payload = [
            'product'     => [$paket->nama],
            'qty'         => [1],
            'price'       => [(int)$paket->price],
            'returnUrl'   => route('public.order.return', ['orderId' => $order->id]), // User redirect (no auto-update)
            'cancelUrl'   => route('public.order.cancel', ['order_id' => $order->id]),
            'notifyUrl'   => route('public.order.callback', ['orderId' => $order->id]), // Payment callback (auto-update)
            'referenceId' => $referenceId,
            'buyerName'   => $request->nama,
            'buyerEmail'  => $request->email,
        ];

        // Generate signature
        $jsonBody = json_encode($payload, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = 'POST:' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp = date('YmdHis');

        // Prepare HTTP client
        $http = Http::withHeaders([
            'Content-Type' => 'application/json',
            'va'           => $va,
            'signature'    => $signature,
            'timestamp'    => $timestamp,
        ])->timeout(60);

        if (app()->isLocal()) {
            $http->withoutVerifying()->withOptions(['force_ip_resolve' => 'v4']);
        }

        // Log request
        Log::info('=== iPaymu Payment Request ===', [
            'url' => $url,
            'payload' => $payload,
            'signature' => $signature,
            'timestamp' => $timestamp,
        ]);

        // Make request
        $response = $http->post($url, $payload);
        $result = $response->json();

        // Log response
        Log::info('=== iPaymu Payment Response ===', [
            'status_code' => $response->status(),
            'result' => $result,
        ]);

        if ($response->successful() && isset($result['Status']) && $result['Status'] == 200) {
            Log::info('Payment URL generated successfully', ['url' => $result['Data']['Url']]);
            return redirect()->away($result['Data']['Url']);
        } else {
            Log::error('iPaymu Payment Error', [
                'status_code' => $response->status(),
                'result' => $result,
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
        $va        = config('services.ipaymu.va');
        $apiKey    = config('services.ipaymu.api_key');
        $baseUrl   = config('services.ipaymu.base_url');
        $url       = $baseUrl . '/transaction'; // Tambahkan endpoint transaction

        $body = ['transactionId' => $transactionId];
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = 'POST:' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature    = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp    = Date('YmdHis');


        $http = Http::withHeaders([
            'Content-Type' => 'application/json', 'signature'    => $signature,
            'va'           => $va, 'timestamp'    => $timestamp,
        ])->timeout(60)->withOptions(['force_ip_resolve' => 'v4']);

        if (app()->isLocal()) {
            $http->withoutVerifying();
        }

        $response = $http->post($url, $body); // Gunakan URL dinamis

        if ($response->successful() && $response->json()['Status'] == 200) {
            return $response->json()['Data'];
        }

        Log::error('iPaymu Check Status Error: ', $response->json() ?? []);
        return null;
    }

    /**
     * Handle return URL - User clicked "Back to Merchant"
     * DO NOT auto-update status here! Only show current order status.
     */
    public function returnUrl($orderId)
    {
        $order = Order::with(['paket', 'voucher'])->findOrFail($orderId);
        
        // Just show the order status, don't modify anything
        return view('public.order-status', compact('order'));
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
                    DB::transaction(function () use ($order) {
                        $order->update(['status' => 'terkirim']);
                        if ($order->voucher) {
                            $order->voucher->update(['status' => 'nonaktif', 'available' => 0]);
                        }
                        // Send email with voucher code
                        Mail::to($order->email)->send(new VoucherCodeMail($order->voucher));
                    });
                    
                    Log::info('Order payment confirmed', ['orderId' => $orderId]);
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

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * iPaymu Payment Gateway Service
 * Handles all iPaymu API interactions with automatic sandbox/production switching
 */
class IPaymuService
{
    protected $va;
    protected $apiKey;
    protected $baseUrl;
    protected $isSandbox;

    public function __construct()
    {
        $this->isSandbox = config('services.ipaymu.sandbox', true);
        
        // Auto-select credentials based on mode
        if ($this->isSandbox) {
            $this->va = config('services.ipaymu.sandbox_va') ?? config('services.ipaymu.va');
            $this->apiKey = config('services.ipaymu.sandbox_api_key') ?? config('services.ipaymu.api_key');
        } else {
            $this->va = config('services.ipaymu.production_va') ?? config('services.ipaymu.va');
            $this->apiKey = config('services.ipaymu.production_api_key') ?? config('services.ipaymu.api_key');
        }
        
        $this->baseUrl = config('services.ipaymu.base_url');
        
        // Log current mode
        Log::info('iPaymu Service Initialized', [
            'mode' => $this->isSandbox ? 'SANDBOX' : 'PRODUCTION',
            'base_url' => $this->baseUrl,
            'va' => $this->va,
        ]);
    }

    /**
     * Create payment transaction
     */
    public function createPayment(array $data)
    {
        $url = $this->baseUrl . '/payment';
        
        // Mandatory fields
        $payload = [
            'product'     => $data['product'],
            'qty'         => $data['qty'],
            'price'       => $data['price'],
            'returnUrl'   => $data['returnUrl'],
            'cancelUrl'   => $data['cancelUrl'],
            'notifyUrl'   => $data['notifyUrl'],
            'referenceId' => $data['referenceId'],
            'buyerName'   => $data['buyerName'],
            'buyerEmail'  => $data['buyerEmail'],
        ];

        // Add optional fields ONLY if they have valid values
        if (!empty($data['buyerPhone'])) {
            $payload['buyerPhone'] = $data['buyerPhone'];
        }
        
        if (!empty($data['paymentMethod'])) {
            $payload['paymentMethod'] = $data['paymentMethod'];
        }

        if (!empty($data['paymentChannel'])) {
            $payload['paymentChannel'] = $data['paymentChannel'];
        }

        if (isset($data['expired'])) {
            $payload['expired'] = $data['expired'];
        }
        
        if (!empty($data['description'])) {
            $payload['description'] = $data['description'];
        }

        // Log the final payload for debugging
        Log::info('iPaymu Clean Payload', $payload);

        // Generate signature correctly using the helper method
        $signature = $this->generateSignature($payload);
        $jsonBody = json_encode($payload, JSON_UNESCAPED_SLASHES);
        
        // Removed incorrect overwrite of $signature

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'signature'    => $signature,
                'va'           => $this->va,
                'timestamp'    => date('YmdHis'),
                'Referer'      => config('app.url'), // Tambahkan Referer agar dikenali iPaymu
            ])->withBody($jsonBody, 'application/json')->post($url); // Force raw JSON body

            $result = $response->json();
            
            // Log response
            Log::info('iPaymu Response', [
                'status' => $response->status(),
                'body' => $result
            ]);

            return [
                'success'     => isset($result['Status']) && $result['Status'] == 200,
                'status_code' => $result['Status'] ?? null,
                'data'        => $result
            ];
        } catch (\Exception $e) {
            Log::error('iPaymu Connection Error: ' . $e->getMessage());
            return [
                'success'     => false,
                'status_code' => 500,
                'data'        => ['message' => $e->getMessage()]
            ];
        }
    }

    /**
     * Check transaction status
     */
    public function checkTransactionStatus($transactionId)
    {
        $url = $this->baseUrl . '/transaction';
        
        $body = ['transactionId' => $transactionId];
        
        // Generate signature
        $signature = $this->generateSignature($body);
        $timestamp = date('YmdHis');

        // Prepare HTTP client
        $http = $this->prepareHttpClient($signature, $timestamp);

        // Log request
        Log::info('=== iPaymu Check Status Request ===', [
            'mode' => $this->isSandbox ? 'SANDBOX' : 'PRODUCTION',
            'url' => $url,
            'transaction_id' => $transactionId,
        ]);

        // Make request
        $response = $http->post($url, $body);
        $result = $response->json();

        // Log response
        Log::info('=== iPaymu Check Status Response ===', [
            'mode' => $this->isSandbox ? 'SANDBOX' : 'PRODUCTION',
            'status_code' => $response->status(),
            'result' => $result,
        ]);

        if ($response->successful() && isset($result['Status']) && $result['Status'] == 200) {
            return $result['Data'];
        }

        Log::error('iPaymu Check Status Error', [
            'mode' => $this->isSandbox ? 'SANDBOX' : 'PRODUCTION',
            'result' => $result ?? [],
        ]);
        
        return null;
    }

    /**
     * Generate signature for iPaymu API
     */
    protected function generateSignature(array $payload)
    {
        $jsonBody = json_encode($payload, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = 'POST:' . $this->va . ':' . $requestBody . ':' . $this->apiKey;
        
        return hash_hmac('sha256', $stringToSign, $this->apiKey);
    }

    /**
     * Prepare HTTP client with headers
     */
    protected function prepareHttpClient($signature, $timestamp)
    {
        $http = Http::withHeaders([
            'Content-Type' => 'application/json',
            'va'           => $this->va,
            'signature'    => $signature,
            'timestamp'    => $timestamp,
        ])->timeout(60);

        // For localhost/sandbox, disable SSL verification
        if (app()->isLocal() || $this->isSandbox) {
            $http->withoutVerifying()->withOptions(['force_ip_resolve' => 'v4']);
        }

        return $http;
    }

    /**
     * Check if currently in sandbox mode
     */
    public function isSandbox()
    {
        return $this->isSandbox;
    }

    /**
     * Get current mode name
     */
    public function getModeName()
    {
        return $this->isSandbox ? 'SANDBOX' : 'PRODUCTION';
    }

    /**
     * Check if transaction status indicates a successful payment
     */
    public function isPaid(?array $transaction): bool
    {
        if (!$transaction) {
            return false;
        }

        $status = $transaction['Status'] ?? null;
        $paidStatus = strtolower($transaction['PaidStatus'] ?? '');

        // iPaymu Paid Statuses:
        // Status 1 = Success / Berhasil
        // Status 6 = Paid / Settled
        // Status 7 = Escrow (QRIS / Virtual Account)
        // PaidStatus = 'paid'
        return in_array((int)$status, [1, 6, 7], true) || $paidStatus === 'paid';
    }
}

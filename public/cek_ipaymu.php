<?php

// Load Laravel correctly from parent directory
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

echo "<h1>Diagnosa Koneksi iPaymu (Server Side)</h1>";

// 1. Cek Config
$isSandbox = config('services.ipaymu.sandbox');
$va = config('services.ipaymu.va');
$apiKey = config('services.ipaymu.api_key');
$baseUrl = config('services.ipaymu.base_url');

echo "<h3>1. Konfigurasi</h3>";
echo "Mode: " . ($isSandbox ? "SANDBOX" : "PRODUCTION") . "<br>";
echo "VA: " . $va . "<br>";
echo "Base URL: " . $baseUrl . "<br>";
echo "API Key Length: " . strlen($apiKey) . " chars<br>";

if (empty($va) || empty($apiKey)) {
    die("<h2 style='color:red'>ERROR: VA atau API Key KOSONG! Cek .env Anda.</h2>");
}

// 2. Test Koneksi Sederhana (Cek Saldo)
echo "<h3>2. Test API (Cek Saldo)</h3>";
$url = $baseUrl . '/balance';
$body = ['account' => $va];
$jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
$signature = hash_hmac('sha256', 'POST:' . $va . ':' . $jsonBody . ':' . $apiKey, $apiKey);

echo "Target URL: $url <br>";

try {
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'signature' => $signature,
        'va' => $va,
        'timestamp' => date('YmdHis'),
    ])->withBody($jsonBody, 'application/json')->post($url);

    echo "Status Code: " . $response->status() . "<br>";
    echo "Response Body: <pre>" . print_r($response->json(), true) . "</pre>";
    
    if ($response->successful()) {
        echo "<h2 style='color:green'>✅ KONEKSI SUKSES!</h2>";
    } else {
        echo "<h2 style='color:red'>❌ KONEKSI GAGAL</h2>";
        if ($response->status() == 0) {
           echo "Mungkin masalah SSL atau Firewall server.";
        }
    }

} catch (\Exception $e) {
    echo "<h2 style='color:red'>EXCEPTION ERROR:</h2>";
    echo $e->getMessage();
}

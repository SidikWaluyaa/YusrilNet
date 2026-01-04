<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\Http;

echo "<h1>Hardcode Credential Check</h1>";

// DATA HARDCODE (JANGAN DICOPY UNTUK PRODUKSI)
$va = '1179005720664738';
$apiKey = '0FBDB682-6860-4221-86D7-097CB31294FA';
$url = 'https://my.ipaymu.com/api/v2/balance'; // Production URL

echo "VA: $va <br>";
echo "URL: $url <br>";
echo "Key: " . substr($apiKey, 0, 5) . "... (Hidden)<br>";

// Logic Signature
$body = ['account' => $va];
$jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
$stringToSign = "POST:" . $va . ":" . $jsonBody . ":" . $apiKey;
$signature = hash_hmac('sha256', $stringToSign, $apiKey);

echo "<br>Sending Request...<br>";

try {
    // Gunakan Guzzle HTTP Client bawaan Laravel (via Facade) tapi manual
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'signature' => $signature,
        'va' => $va,
        'timestamp' => date('YmdHis'),
    ])->withBody($jsonBody, 'application/json')->post($url);

    echo "<h3>Result:</h3>";
    echo "Status Code: <b>" . $response->status() . "</b><br>";
    
    $json = $response->json();
    echo "<pre>" . print_r($json, true) . "</pre>";
    
    if ($response->status() == 200 && isset($json['Data'])) {
        echo "<h2 style='color:green'>BERHASIL! AKUN AMAN.</h2>";
        echo "Saldo: " . $json['Data']['Balance'];
    } elseif ($response->status() == 401) {
        echo "<h2 style='color:red'>GAGAL: UNAUTHORIZED</h2>";
        echo "Artinya: VA atau API Key SALAH, atau IP Server belum di-whitelist.";
    } else {
        echo "<h2 style='color:orange'>GAGAL LAINNYA</h2>";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

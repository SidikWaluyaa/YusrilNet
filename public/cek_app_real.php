<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\IPaymuService; // PAKE SERVICE ASLI
use Illuminate\Support\Facades\Config;

echo "<h1>Diagnosa Aplikasi Real (Menggunakan IPaymuService)</h1>";

// 1. Cek Config yang terbaca
echo "<h3>1. Konfigurasi Terdeteksi</h3>";
echo "APP_URL (Referer): <b>" . config('app.url') . "</b> (Harus sama dengan di Dashboard iPaymu)<br>";
echo "VA: <b>" . config('services.ipaymu.va') . "</b><br>";
echo "API Key: <b>" . substr(config('services.ipaymu.api_key'), 0, 5) . "...</b><br>";
echo "Mode: <b>" . (config('services.ipaymu.sandbox') ? 'SANDBOX' : 'PRODUCTION') . "</b><br>";

// 2. Test Panggil Service Asli
echo "<h3>2. Test IPaymuService Class</h3>";

try {
    $service = new IPaymuService();
    
    // Kita tembak fungsi checkTransactionStatus dengan ID ngawur (hanya untuk cek koneksi/auth)
    // Atau kita buat request payment dummy
    
    $dummyOrder = [
        'product' => ['Test Diagnosa'],
        'qty' => [1],
        'price' => [1000],
        'returnUrl' => config('app.url'),
        'cancelUrl' => config('app.url'),
        'notifyUrl' => config('app.url'),
        'referenceId' => 'DIAG-' . time(),
        'buyerName' => 'Tester',
        'buyerEmail' => 'test@example.com',
        'buyerPhone' => '08123456789'
    ];
    
    echo "Mencoba membuat payment dummy...<br>";
    $result = $service->createPayment($dummyOrder);
    
    echo "<h4>Hasil Response:</h4>";
    echo "<pre>" . print_r($result, true) . "</pre>";

    if ($result['success']) {
        echo "<h2 style='color:green'>✅ SERVICE BERJALAN LANCAR!</h2>";
    } else {
        echo "<h2 style='color:red'>❌ SERVICE GAGAL</h2>";
        echo "Cek pesan error di atas.";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

<?php

echo "<h1>Hardcode Credential Check (Native CURL)</h1>";

// 1. CEK REAL OUTBOUND IP
echo "<h3>Checking Server Outbound IP...</h3>";
$ch_ip = curl_init('https://api.ipify.org');
curl_setopt($ch_ip, CURLOPT_RETURNTRANSFER, true);
$real_ip = curl_exec($ch_ip);
curl_close($ch_ip);

echo "Detected Outbound IP: <b>" . $real_ip . "</b><br>";
echo "(IP ini yang HARUS didaftarkan di Whitelist iPaymu, bukan Shared IP cPanel)<br><hr>";

// DATA HARDCODE
$va = '1179005720664738';
$apiKey = '0FBDB682-6860-4221-86D7-097CB31294FA';
$url = 'https://my.ipaymu.com/api/v2/balance'; 

echo "VA: $va <br>";
echo "URL: $url <br>";
echo "Key: " . substr($apiKey, 0, 5) . "... (Hidden)<br>";

// Prepare Data
$body = ['account' => $va];
$jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
$stringToSign = "POST:" . $va . ":" . $jsonBody . ":" . $apiKey;
$signature = hash_hmac('sha256', $stringToSign, $apiKey);

echo "<br>Sending Request...<br>";

// CURL MANUAL
$ch = curl_init();

$headers = [
    'Content-Type: application/json',
    'signature: ' . $signature,
    'va: ' . $va,
    'timestamp: ' . date('YmdHis')
];

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$server_output = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error_msg = curl_error($ch);

curl_close($ch);

echo "<h3>Result:</h3>";
echo "HTTP Status: <b>$http_code</b><br>";

if ($error_msg) {
    echo "CURL Error: $error_msg<br>";
}

echo "Response Body:<br>";
echo "<pre>" . htmlspecialchars($server_output) . "</pre>";

$json = json_decode($server_output, true);

if ($http_code == 200 && isset($json['Status']) && $json['Status'] == 200) {
    echo "<h2 style='color:green'>BERHASIL! AKUN AMAN.</h2>";
} elseif ($http_code == 401) {
    echo "<h2 style='color:red'>GAGAL: 401 UNAUTHORIZED</h2>";
    echo "Penyebab: VA/Key Salah atau IP Server ($real_ip) belum Whitelist.";
} else {
    echo "<h2 style='color:orange'>GAGAL: CODE $http_code</h2>";
}

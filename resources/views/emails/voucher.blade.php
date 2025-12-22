<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kode Voucher Anda</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Halo {{ $voucher->order->nama }},</h2>
    <p>Berikut adalah detail pesanan dan kredensial voucher Anda:</p>

    <ul>
        <li><strong>Paket:</strong> {{ $voucher->paket->nama }}</li>
        <li><strong>Harga:</strong> Rp {{ number_format($voucher->price, 0, ',', '.') }}</li>
        <li><strong>Username:</strong> {{ $voucher->username }}</li>
        <li><strong>Password:</strong> {{ $voucher->password }}</li>
    </ul>

    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>
</html>

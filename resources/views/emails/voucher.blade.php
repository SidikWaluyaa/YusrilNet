<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Voucher WiFi Anda - YusrilNet</title>
</head>
<body style="font-family: 'Segoe UI', Helvetica, Arial, sans-serif; background-color: #f4f6fb; margin: 0; padding: 20px; color: #1e293b;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <!-- Header -->
        <tr>
            <td style="background: linear-gradient(135deg, #1865f2 0%, #00d2ff 100%); padding: 30px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">YusrilNet</h1>
                <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Pembayaran Berhasil & Kode Voucher Siap Digunakan</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 30px;">
                @php
                    $namaPelanggan = $order->nama ?? ($voucher->order->nama ?? 'Pelanggan');
                    $namaPaket = $voucher->nama ?? ($voucher->paket->nama ?? 'Paket WiFi');
                    $hargaPaket = $voucher->price ?? ($voucher->paket->price ?? 0);
                    $username = $voucher->username ?? '-';
                    $password = $voucher->password ?? '-';
                @endphp

                <p style="font-size: 16px; margin-top: 0;">Halo <strong>{{ $namaPelanggan }}</strong>,</p>
                <p style="font-size: 14px; color: #64748b; line-height: 1.5;">
                    Terima kasih telah membeli voucher WiFi di <strong>YusrilNet</strong>. Pembayaran Anda telah terkonfirmasi. Berikut adalah kredensial voucher Anda:
                </p>

                <!-- Voucher Credentials Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; margin: 25px 0; padding: 20px;">
                    <tr>
                        <td style="padding-bottom: 15px; border-bottom: 1px solid #e2e8f0;">
                            <span style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Paket Internet</span>
                            <div style="font-size: 18px; font-weight: 800; color: #1865f2; margin-top: 2px;">{{ $namaPaket }}</div>
                            <div style="font-size: 13px; color: #475569; margin-top: 2px;">Total: Rp {{ number_format($hargaPaket, 0, ',', '.') }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 15px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="50%" style="padding-right: 10px;">
                                        <div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; text-align: center;">
                                            <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">USERNAME</div>
                                            <div style="font-size: 18px; font-weight: 800; color: #0f172a; font-family: monospace; letter-spacing: 1px;">{{ $username }}</div>
                                        </div>
                                    </td>
                                    <td width="50%" style="padding-left: 10px;">
                                        <div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; text-align: center;">
                                            <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">PASSWORD</div>
                                            <div style="font-size: 18px; font-weight: 800; color: #1865f2; font-family: monospace; letter-spacing: 1px;">{{ $password }}</div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Usage Instructions -->
                <div style="background-color: #eff6ff; border-left: 4px solid #1865f2; padding: 15px; border-radius: 0 8px 8px 0; margin-bottom: 25px;">
                    <div style="font-size: 13px; font-weight: 700; color: #1e40af; margin-bottom: 6px;">Cara Menggunakan Voucher:</div>
                    <ol style="margin: 0; padding-left: 20px; font-size: 13px; color: #1e3a8a; line-height: 1.6;">
                        <li>Hubungkan perangkat Anda ke WiFi <strong>YusrilNet</strong>.</li>
                        <li>Buka browser dan halaman login hotspot akan otomatis muncul.</li>
                        <li>Masukkan <strong>Username</strong> dan <strong>Password</strong> di atas.</li>
                        <li>Klik <strong>Login / Connect</strong> untuk mulai berselancar!</li>
                    </ol>
                </div>

                <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">
                    Jika Anda mengalami kendala atau membutuhkan bantuan teknis, hubungi CS kami via WhatsApp di <a href="https://wa.me/62895343565099" style="color: #1865f2; font-weight: 700; text-decoration: none;">0895343565099</a>.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px; text-align: center; font-size: 12px; color: #94a3b8;">
                &copy; 2025 YusrilNet Sriwijaya. All rights reserved.
            </td>
        </tr>
    </table>

</body>
</html>

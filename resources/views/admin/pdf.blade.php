<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Voucher YusrilNet</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding: 20px;
        }

        .print-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3498db;
        }

        .company-logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: #3498db;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .company-tagline {
            font-size: 1rem;
            color: #7f8c8d;
            margin-bottom: 15px;
        }

        .report-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 10px 0;
        }

        .print-date {
            font-size: 0.85rem;
            color: #7f8c8d;
            margin-top: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px 8px;
            text-align: center;
            font-size: 0.85rem;
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .table-container {
            margin: 20px 0;
            overflow-x: auto;
        }

        .table-header {
            font-weight: bold;
            background-color: #e9ecef;
        }

        .total-section {
            margin-top: 30px;
            font-size: 1rem;
            text-align: right;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 0.85rem;
            color: #7f8c8d;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .status-active {
            background-color: #2ecc71;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #f39c12;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .summary-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .summary-item {
            text-align: center;
            flex: 1;
        }

        .summary-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #3498db;
            margin-bottom: 5px;
        }

        .summary-label {
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        .voucher-details {
            font-weight: 600;
        }

        .signature-area {
            margin-top: 50px;
            text-align: right;
        }

        .signature-line {
            display: inline-block;
            width: 200px;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .signature-name {
            font-weight: 600;
        }

        .signature-title {
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        @media print {
            body {
                font-size: 12pt;
                color: #000;
            }

            .print-header {
                border-bottom-color: #000;
            }

            .company-logo {
                color: #000;
            }

            th {
                background-color: #eee !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .status-active,
            .status-pending {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            a {
                text-decoration: none;
                color: #000;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="print-header">
            <div class="company-logo">YusrilNet</div>
            <div class="company-tagline">Penyedia Voucher WiFi Terbaik</div>
            <div class="report-title">LAPORAN PENJUALAN VOUCHER WIFI</div>
            <div class="print-date">
                Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d F Y, H:i') }} WIB
            </div>

        </div>
        @if (isset($filter))
            <div style="margin-bottom: 15px;">
                <strong>Filter:</strong>
                <ul style="list-style: none; padding-left: 0;">
                    @if ($filter['paket'])
                        <li>Paket: {{ $filter['paket'] }}</li>
                    @endif
                    @if ($filter['tanggal_mulai'] && $filter['tanggal_akhir'])
                        <li>
                            Tanggal: {{ \Carbon\Carbon::parse($filter['tanggal_mulai'])->format('d M Y') }}
                            - {{ \Carbon\Carbon::parse($filter['tanggal_akhir'])->format('d M Y') }}
                        </li>
                    @endif
                </ul>
            </div>
        @endif


        <div class="summary-box">
            <div class="summary-item">
                <div class="summary-value">{{ $orders->count() }}</div>
                <div class="summary-label">Total Voucher</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $orders->where('status', '!=', 'selesai')->count() }}</div>
                <div class="summary-label">Voucher Terkirim</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">Rp {{ number_format($orders->sum('harga'), 0, ',', '.') }}</div>
                <div class="summary-label">Total Pendapatan</div>
            </div>
        </div>

        <h2>Daftar Order Voucher WiFi</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pelanggan</th>
                        <th>Email</th>
                        <th>Paket</th>
                        <th>Username & Password</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Tanggal Order</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->nama }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->paket->nama }}</td>
                            <td class="voucher-details">
                                @if ($order->voucher)
                                    {{ $order->voucher->username }} / {{ $order->voucher->password }}
                                @else
                                    Voucher Sudah Habis
                                @endif
                            </td>
                            <td>Rp {{ number_format($order->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="{{ $order->status == 'selesai' ? 'status-active' : 'status-pending' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total-section">
            <p>Total Pendapatan: Rp {{ number_format($orders->sum('harga'), 0, ',', '.') }}</p>
        </div>

        <div class="signature-area">
            <p>{{ date('d F Y') }}</p>
            <div class="signature-line">&nbsp;</div>
            <p class="signature-name">Admin YusrilNet</p>
            <p class="signature-title">Pengelola Layanan WiFi</p>
        </div>

        <div class="footer">
            <p>YusrilNet &copy; {{ date('Y') }} - Koneksi Internet Stabil, Harga Bersahabat</p>
            <p>Jl. Sriwijay VIII, Kota Bandung | Telp: (0123) 456789 | Email: yusrilnet@gmail.com</p>
        </div>
    </div>
</body>

</html>

@extends('layouts.public')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="custom-card shadow-lg" data-aos="fade-up">
            <div class="card-body p-5">
                
                @if($order->status === 'terkirim')
                    <!-- Payment Success -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-check fa-3x"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-2">Pembayaran Berhasil!</h2>
                        <p class="text-muted">Terima kasih atas pembelian Anda</p>
                    </div>

                    <!-- Order Details -->
                    <div class="border-top border-bottom py-4 mb-4">
                        <h5 class="fw-bold mb-3">Detail Pesanan</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Order ID</span>
                                <span class="fw-bold">#{{ $order->id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Paket</span>
                                <span class="fw-bold">{{ $order->paket->nama }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Harga</span>
                                <span class="fw-bold">Rp {{ number_format($order->harga, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Status</span>
                                <span class="badge bg-success rounded-pill px-3">Berhasil</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Voucher Code -->
                    @if($order->voucher)
                    <div class="alert alert-primary text-center py-4 mb-4" role="alert">
                        <h5 class="alert-heading fw-bold mb-3"><i class="fas fa-ticket me-2"></i>Kredensial Voucher Anda</h5>
                        <div class="row g-2 justify-content-center">
                            <div class="col-6">
                                <div class="bg-white rounded p-2 border-2 border-primary shadow-sm">
                                    <small class="text-muted d-block font-bold">USERNAME</small>
                                    <h4 class="mb-0 fw-bold text-dark font-monospace">{{ $order->voucher->username ?? '-' }}</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-white rounded p-2 border-2 border-primary shadow-sm">
                                    <small class="text-muted d-block font-bold">PASSWORD</small>
                                    <h4 class="mb-0 fw-bold text-primary font-monospace">{{ $order->voucher->password ?? '-' }}</h4>
                                </div>
                            </div>
                        </div>
                        <p class="small text-muted mt-3 mb-0">
                            Salinan voucher juga dikirim ke email: <strong>{{ $order->email }}</strong>
                        </p>
                    </div>
                    @endif

                    <!-- Action Button -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>

                @elseif($order->status === 'menunggu')
                    <!-- Payment Pending -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning text-dark rounded-circle mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-clock fa-3x"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-2">Menunggu Pembayaran</h2>
                        <p class="text-muted">Pesanan Anda belum dibayar</p>
                    </div>

                    <!-- Order Details -->
                    <div class="border-top border-bottom py-4 mb-4">
                        <h5 class="fw-bold mb-3">Detail Pesanan</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Order ID</span>
                                <span class="fw-bold">#{{ $order->id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Paket</span>
                                <span class="fw-bold">{{ $order->paket->nama }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Harga</span>
                                <span class="fw-bold">Rp {{ number_format($order->harga, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Status</span>
                                <span class="badge bg-warning text-dark rounded-pill px-3">Menunggu Pembayaran</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Instructions -->
                    <div class="alert alert-info mb-4">
                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-2"></i>Instruksi Pembayaran</h6>
                        <ol class="mb-0 ps-3">
                            <li>Silakan selesaikan pembayaran Anda</li>
                            <li>Setelah pembayaran berhasil, voucher akan dikirim ke email Anda</li>
                            <li>Proses verifikasi otomatis dalam 1-5 menit</li>
                        </ol>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="{{ route('welcome') }}" class="btn btn-outline-secondary flex-grow-1">
                            Kembali ke Beranda
                        </a>
                        <button onclick="location.reload()" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-sync-alt me-2"></i>Refresh Status
                        </button>
                    </div>

                @else
                    <!-- Payment Failed/Cancelled -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-times fa-3x"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-2">Pembayaran Dibatalkan</h2>
                        <p class="text-muted">Pesanan Anda telah dibatalkan</p>
                    </div>

                    <!-- Order Details -->
                    <div class="border-top border-bottom py-4 mb-4">
                        <h5 class="fw-bold mb-3">Detail Pesanan</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Order ID</span>
                                <span class="fw-bold">#{{ $order->id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Status</span>
                                <span class="badge bg-danger rounded-pill px-3">{{ ucfirst($order->status) }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Button -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.public')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-6">
            <div class="custom-card" data-aos="zoom-in">
                <!-- Success Icon -->
                <div class="text-center pt-5">
                    <div class="success-icon" data-aos="flip-down" data-aos-delay="200">
                        <i class="fas fa-check"></i>
                    </div>
                </div>

                <div class="custom-card-header border-0 bg-transparent text-dark pt-0" 
                     style="font-size: clamp(1.5rem, 5vw, 2rem);">
                    <i class="fas fa-circle-check me-2 text-success"></i>
                    Pembayaran Berhasil!
                </div>

                <div class="card-body p-4 p-md-5 pt-3">
                    <div class="text-center mb-4" data-aos="fade-up" data-aos-delay="300">
                        <h5 class="fw-bold mb-3" style="font-size: clamp(1.2rem, 4vw, 1.5rem);">Terima Kasih Atas Pembelian Anda! 🎉</h5>
                        <p class="text-muted">
                            Pesanan Anda untuk paket <strong class="text-primary">{{ $order->paket->nama }}</strong> telah
                            berhasil diproses.
                        </p>
                    </div>

                    <!-- Voucher Code Box -->
                    <div class="voucher-box" data-aos="fade-up" data-aos-delay="400">
                        <h6 class="text-center mb-4 text-uppercase fw-bold text-primary">
                            <i class="fas fa-ticket me-2"></i>Kode Voucher Anda
                        </h6>

                        <!-- Username -->
                        <div class="voucher-code">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="text-break">
                                    <small class="text-muted d-block mb-1">Username</small>
                                    <strong id="voucherUsername"
                                        class="fs-5 text-dark">{{ $order->voucher->username }}</strong>
                                </div>
                                <button class="btn btn-outline-primary copy-btn flex-shrink-0"
                                    onclick="copyToClipboard('voucherUsername', this)" title="Salin Username">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="voucher-code">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="text-break">
                                    <small class="text-muted d-block mb-1">Password</small>
                                    <strong id="voucherPassword"
                                        class="fs-5 text-dark">{{ $order->voucher->password }}</strong>
                                </div>
                                <button class="btn btn-outline-primary copy-btn flex-shrink-0"
                                    onclick="copyToClipboard('voucherPassword', this)" title="Salin Password">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 mb-0" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Klik tombol <strong>salin</strong> untuk menyalin kode voucher dengan mudah!</small>
                        </div>
                    </div>

                    <!-- Email Notification -->
                    <div class="text-center mb-4" data-aos="fade-up" data-aos-delay="500">
                        <div class="alert alert-success border-0">
                            <i class="fas fa-envelope-circle-check me-2"></i>
                            Salinan kode voucher telah dikirim ke email Anda: <strong>{{ $order->email }}</strong>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2" data-aos="fade-up" data-aos-delay="600">
                        <a href="{{ route('welcome') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-home me-2"></i>Kembali ke Halaman Utama
                        </a>
                    </div>

                    <!-- Order Info -->
                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-receipt me-1"></i>
                            Order ID: <strong>YNET-{{ $order->id }}</strong>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Additional Info Card -->
            <div class="card border-0 shadow-sm mt-4" data-aos="fade-up" data-aos-delay="700" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-primary">
                        <i class="fas fa-lightbulb me-2"></i>Cara Menggunakan Voucher
                    </h6>
                    <ol class="mb-0 ps-3">
                        <li class="mb-2">Hubungkan perangkat Anda ke WiFi <strong>YusrilNet</strong></li>
                        <li class="mb-2">Buka browser dan masukkan username & password di atas</li>
                        <li class="mb-2">Klik login dan nikmati internet cepat!</li>
                    </ol>
                    <div class="alert alert-warning border-0 mt-3 mb-0">
                        <small>
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Simpan kode voucher Anda dengan aman. Jangan bagikan ke orang lain!
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk fungsi "Copy to Clipboard" --}}
    <script>
        function copyToClipboard(elementId, button) {
            const textToCopy = document.getElementById(elementId).innerText;
            const originalIcon = button.innerHTML;

            navigator.clipboard.writeText(textToCopy).then(() => {
                // Success feedback
                button.innerHTML = '<i class="fas fa-check"></i>';
                button.classList.remove('btn-outline-primary');
                button.classList.add('btn-success');

                // Show toast notification
                showToast('Berhasil disalin!');

                // Reset after 2 seconds
                setTimeout(() => {
                    button.innerHTML = originalIcon;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-primary');
                }, 2000);
            }).catch(err => {
                console.error('Gagal menyalin: ', err);
                showToast('Gagal menyalin!', 'error');
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed top-0 start-50 translate-middle-x mt-3`;
            toast.style.zIndex = '9999';
            toast.style.minWidth = '250px';
            toast.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${message}
                `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }
    </script>
@endsection
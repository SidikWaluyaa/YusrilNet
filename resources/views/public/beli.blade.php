@extends('layouts.public')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-6">
            <div class="custom-card" data-aos="fade-up">
                <div class="custom-card-header">
                    <i class="fas fa-shopping-cart me-2"></i>
                    <span style="font-size: clamp(1.2rem, 4vw, 1.5rem);">Form Pembelian Voucher</span>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Detail Paket -->
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        <h5 class="mb-3 fw-bold text-primary" style="font-size: clamp(1.1rem, 4vw, 1.25rem);">
                            <i class="fas fa-box-open me-2"></i>Detail Paket Pilihan Anda
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted">Nama Paket</span>
                                <span class="fw-bold">{{ $paket->nama }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted">Durasi Aktif</span>
                                <span class="fw-bold">{{ $paket->duration }} Jam</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted">Deskripsi</span>
                                <span class="fw-bold text-end" style="max-width: 60%;">{{ $paket->deskripsi }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pt-3">
                                <span class="fs-5 fw-bold text-primary">Total Harga</span>
                                <span class="fw-bolder text-primary" style="font-size: clamp(1.5rem, 5vw, 1.8rem);">Rp
                                    {{ number_format($paket->price, 0, ',', '.') }}</span>
                            </li>
                        </ul>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger" data-aos="shake">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <hr class="my-4">

                    <!-- Form Input -->
                    <div data-aos="fade-up" data-aos-delay="200">
                        <h5 class="mb-4 fw-bold text-primary" style="font-size: clamp(1.1rem, 4vw, 1.25rem);">
                            <i class="fas fa-user-edit me-2"></i>Lengkapi Data Anda
                        </h5>
                        <form action="{{ route('public.order.store') }}" method="POST" id="formPembelian">
                            @csrf
                            <input type="hidden" name="paket_id" value="{{ $paket->id }}">

                            <div class="form-floating mb-3">
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                    required placeholder="Nama Lengkap Anda">
                                <label for="nama">
                                    <i class="fas fa-user me-2"></i>Nama Lengkap Anda
                                </label>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-4">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required placeholder="email@contoh.com">
                                <label for="email">
                                    <i class="fas fa-envelope me-2"></i>Alamat Email (Untuk kirim voucher)
                                </label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- BAGIAN PERSETUJUAN (Client Side Only) -->
                            <div class="mb-4 p-3 bg-light rounded border">
                                <div class="form-check">
                                    <!-- Atribut 'required' memaksa browser mengecek ini tanpa perlu controller -->
                                    <input class="form-check-input" type="checkbox" id="terms_check" required>
                                    <label class="form-check-label fw-bold text-dark" for="terms_check">
                                        Saya telah membaca dan menyetujui:
                                    </label>
                                </div>
                                <ul class="list-unstyled ms-4 mt-2 mb-0 small">
                                    <li class="mb-1">
                                        1. <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                            data-bs-target="#termsModal">Syarat &
                                            Ketentuan</a>
                                    </li>
                                    <li>
                                        2. <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                            data-bs-target="#refundModal">Kebijakan
                                            Refund</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- END BAGIAN PERSETUJUAN -->

                            <div class="d-grid">
                                <!-- Tombol default disabled, akan aktif via JS saat dicentang -->
                                <button type="submit" class="btn btn-brand btn-lg disabled" id="btnSubmit" disabled>
                                    <i class="fas fa-shield-halved me-2"></i>
                                    Lanjutkan ke Pembayaran Aman
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-lock me-1"></i>
                                    Pembayaran aman dengan enkripsi SSL
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-footer bg-light text-center py-3 border-0">
                    <a href="{{ route('welcome') }}" class="text-decoration-none text-muted">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0" style="background: var(--gradient); color: white;">
                    <h5 class="modal-title fw-bold" id="termsModalLabel">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" height="30" class="me-2">
                        SYARAT & KETENTUAN
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Dengan melakukan pembelian dan/atau mengakses website voucheryusril.biz.id, Anda menyetujui
                        poin-poin berikut:</p>
                    <ol>
                        <li class="mb-2"><strong>Status Produk:</strong> Produk yang kami jual adalah voucher
                            internet Wi-Fi Yusril.net yang bersifat digital dan selalu ready stock, dengan detail paket
                            tersedia di katalog website.</li>
                        <li class="mb-2"><strong>Kesesuaian Layanan:</strong> Voucher ini hanya dapat digunakan di
                            area yang terjangkau oleh jaringan Wi-Fi Yusril.net. Pengguna wajib memastikan lokasi berada
                            dalam jangkauan.</li>
                        <li class="mb-2"><strong>Tanggung Jawab Pengguna:</strong> Pembeli bertanggung jawab penuh
                            atas kerahasiaan kode voucher yang diterima. Penggunaan kode yang berlebihan atau
                            penyalahgunaan (seperti sharing tanpa izin) dapat mengakibatkan pemblokiran kode tanpa
                            pengembalian dana.</li>
                        <li class="mb-2"><strong>Hak Perubahan:</strong> Kami berhak mengubah Syarat & Ketentuan ini
                            kapan saja tanpa pemberitahuan sebelumnya. Penggunaan layanan yang berlanjut dianggap
                            sebagai persetujuan atas perubahan tersebut.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Refund Modal -->
    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0" style="background: var(--gradient); color: white;">
                    <h5 class="modal-title fw-bold" id="refundModalLabel">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" height="30" class="me-2">
                        KEBIJAKAN REFUND
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Mengingat voucher adalah produk digital, berikut adalah ketentuan pengembalian dana (refund):</p>
                    <ol>
                        <li class="mb-2"><strong>Sifat Transaksi:</strong> Semua pembelian voucher adalah final
                            setelah kode berhasil terkirim. Pembatalan atau pengembalian dana tidak berlaku jika kode
                            sudah terkirim dan valid/dapat digunakan.</li>
                        <li class="mb-2"><strong>Kondisi Refund:</strong> Refund hanya dapat diproses jika terjadi
                            kegagalan sistem yang menyebabkan salah satu dari kondisi ini:
                            <ul>
                                <li>Voucher tidak terkirim setelah pembayaran terkonfirmasi.</li>
                                <li>Voucher terkirim, namun kode terbukti invalid (tidak dapat digunakan) setelah
                                    diverifikasi oleh tim kami.</li>
                            </ul>
                        </li>
                        <li class="mb-2"><strong>Prosedur Pengajuan:</strong> Permintaan refund harus diajukan
                            maksimal 24 jam setelah pembelian kepada Layanan Pelanggan dengan melampirkan bukti
                            pembayaran.</li>
                        <li class="mb-2"><strong>Proses Pengembalian:</strong> Jika refund disetujui, dana akan
                            dikembalikan dalam waktu 3-5 hari kerja ke rekening/sumber pembayaran yang digunakan.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Sederhana untuk Mengunci Tombol --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('terms_check');
            const btnSubmit = document.getElementById('btnSubmit');

            // Fungsi untuk cek status checkbox
            function toggleButton() {
                if (checkbox.checked) {
                    btnSubmit.removeAttribute('disabled');
                    btnSubmit.classList.remove('disabled');
                } else {
                    btnSubmit.setAttribute('disabled', 'disabled');
                    btnSubmit.classList.add('disabled');
                }
            }

            // Jalankan saat checkbox diklik
            checkbox.addEventListener('change', toggleButton);

            // Jalankan sekali saat halaman dimuat (untuk mengatasi refresh)
            toggleButton();
        });
    </script>
@endsection

@extends('layouts.public')

@section('content')
    <div class="row justify-content-center">
        <!-- Kolom Kiri: Detail Paket -->
        <div class="col-lg-7 mb-4">
            <div class="custom-card h-100" data-aos="fade-up">
                <div class="custom-card-header text-start">
                    <i class="fas fa-box-open me-2"></i>Detail Paket
                </div>
                <div class="card-body p-4">
                    <h3 class="fw-bold text-primary mb-3">{{ $paket->nama }}</h3>

                    <div class="mb-4">
                        <h6 class="fw-bold text-dark"><i class="fas fa-align-left me-2 text-primary"></i>Deskripsi</h6>
                        <p class="text-muted">{{ $paket->deskripsi }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-list-check me-2 text-primary"></i>Fitur &
                            Keuntungan</h6>
                        @php
                            $details = $paket->detail_paket ? json_decode($paket->detail_paket) : [];
                        @endphp

                        @if (is_array($details) && count($details) > 0)
                            <ul class="list-group list-group-flush">
                                @foreach ($details as $detail)
                                    <li class="list-group-item d-flex align-items-center bg-transparent px-0 border-bottom-0">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>{{ $detail }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted fst-italic">Detail fitur tidak tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Ringkasan & Aksi -->
        <div class="col-lg-5 mb-4">
            <div class="custom-card" data-aos="fade-up" data-aos-delay="100">
                <div class="custom-card-header text-start bg-secondary">
                    <i class="fas fa-info-circle me-2"></i>Ringkasan
                </div>
                <div class="card-body p-4">
                    <!-- Harga -->
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded-4">
                        <span class="text-muted">Harga Paket</span>
                        <span class="h4 fw-bold text-primary mb-0">Rp {{ number_format($paket->price, 0, ',', '.') }}</span>
                    </div>

                    <!-- Durasi -->
                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded-4">
                        <span class="text-muted">Masa Aktif</span>
                        <span class="fw-bold text-dark"><i class="fas fa-clock me-2 text-warning"></i>{{ $paket->duration }}
                            Jam</span>
                    </div>

                    <hr class="my-4">

                    <!-- Status Stock -->
                    @php
                        $jumlahTersedia = $paket->vouchers
                            ->where('status', 'aktif')
                            ->where('available', 1)
                            ->count();
                        $isAvailable = $paket->available == 1 && $jumlahTersedia > 0;
                    @endphp

                    <div class="mb-4 text-center">
                        @if ($isAvailable)
                            <span class="badge bg-success-subtle text-success fs-6 px-3 py-2 rounded-pill">
                                <i class="fas fa-check-circle me-1"></i> {{ $jumlahTersedia }} Voucher Tersedia
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger fs-6 px-3 py-2 rounded-pill">
                                <i class="fas fa-times-circle me-1"></i> Stok Habis / Tidak Tersedia
                            </span>
                        @endif
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2">
                        @if ($isAvailable)
                            <a href="{{ route('public.beli', $paket->id) }}" class="btn btn-brand btn-lg">
                                Beli Sekarang <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg" disabled>
                                Tidak Dapat Dibeli
                            </button>
                        @endif

                        <a href="{{ route('welcome') }}" class="btn btn-outline-primary btn-lg mt-2">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
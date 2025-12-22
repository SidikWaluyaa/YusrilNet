<x-app-layout>
    @section('title', 'Deskripsi Paket')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $paket->nama }}</h1>
        <a href="{{ route('user.dashboard') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Detail Lengkap Paket -->
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Paket</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Deskripsi</h6>
                        <p>{{ $paket->deskripsi }}</p>
                    </div>

                    <div>
                        <h6 class="font-weight-bold">Yang Akan Anda Dapatkan</h6>
                        @php
                            // Tambahkan pengecekan untuk memastikan $paket->detail_paket tidak null
                            $details = $paket->detail_paket ? json_decode($paket->detail_paket) : [];
                        @endphp

                        @if (is_array($details) && count($details) > 0)
                            <ul class="list-group list-group-flush">
                                @foreach ($details as $detail)
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-2"></i>
                                        <span>{{ $detail }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Detail tidak tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Info Ringkas & Tombol Aksi -->
        <div class="col-lg-5">
            <!-- Card Harga & Durasi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi</h6>
                </div>
                <div class="card-body">
                    <!-- Harga -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-gray-600">Harga</span>
                        <span class="h5 font-weight-bold text-gray-800 mb-0">Rp
                            {{ number_format($paket->price, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-2">
                    <!-- Durasi -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-gray-600">Durasi</span>
                        <span class="font-weight-bold text-gray-800">{{ $paket->duration }} Hari</span>
                    </div>
                </div>
            </div>

            <!-- Card Status & Aksi Beli -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status & Pembelian</h6>
                </div>
                <div class="card-body text-center">
                    @php
                        $jumlahTersedia = $paket->vouchers->where('status', 'aktif')->where('available', 1)->count();
                    @endphp

                    <h6 class="font-weight-bold">Ketersediaan Voucher</h6>
                    @if ($jumlahTersedia > 0)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-1"></i>
                            <strong>{{ $jumlahTersedia }}</strong> Voucher Tersedia
                        </div>
                        <p>Segera lakukan pembelian sebelum voucher habis.</p>
                        <a href="{{ route('user.orders.beli', $paket->id) }}"
                            class="btn btn-success btn-icon-split btn-block">
                            <span class="icon text-white-50">
                                <i class="fas fa-shopping-cart"></i>
                            </span>
                            <span class="text">Beli Sekarang</span>
                        </a>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle mr-1"></i>
                            Voucher Tidak Tersedia
                        </div>
                        <p>Mohon maaf, saat ini voucher untuk paket ini sudah habis.</p>
                        <button class="btn btn-secondary btn-icon-split btn-block" disabled>
                            <span class="icon text-white-50">
                                <i class="fas fa-ban"></i>
                            </span>
                            <span class="text">Voucher Habis</span>
                        </button>
                    @endif
                    <a href="{{ route('user.dashboard', $paket->id) }}" class="btn btn-info btn-icon-split btn-block">
                        <span class="text">Kembali Ke Daftar Paket</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

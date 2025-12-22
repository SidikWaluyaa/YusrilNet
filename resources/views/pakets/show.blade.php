<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-eye me-2"></i>Detail Paket
                </h1>
                <p class="text-muted mb-0 small">{{ $paket->nama }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.pakets.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('admin.pakets.edit', $paket->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Info -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <!-- Nama & Harga -->
                        <div class="mb-4">
                            <h2 class="mb-2" style="color: #2d3748;">{{ $paket->nama }}</h2>
                            <h3 class="mb-0" style="color: var(--neptune-blue); font-weight: 700;">
                                Rp {{ number_format($paket->price, 0, ',', '.') }}
                            </h3>
                        </div>

                        <hr>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">
                                <i class="fas fa-info-circle me-2" style="color: var(--neptune-blue);"></i>Deskripsi
                            </h6>
                            <p class="text-muted mb-0">{{ $paket->deskripsi }}</p>
                        </div>

                        <hr>

                        <!-- Detail & Fitur -->
                        <div>
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-list-check me-2" style="color: var(--neptune-blue);"></i>Detail & Fitur
                            </h6>
                            <ul class="list-unstyled mb-0">
                                @php
                                    $details = json_decode($paket->detail_paket, true);
                                    if (!is_array($details)) $details = [];
                                @endphp
                                @forelse($details as $detail)
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>{{ $detail }}
                                    </li>
                                @empty
                                    <li class="text-muted">
                                        <i class="fas fa-times-circle text-danger me-2"></i>Detail tidak tersedia
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Sidebar -->
            <div class="col-lg-4">
                <!-- Durasi -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(67, 97, 238, 0.1);">
                                    <i class="fas fa-clock fa-lg" style="color: var(--neptune-blue);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Durasi</div>
                                <div class="h4 mb-0 fw-bold">{{ $paket->duration }} Jam</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stok Voucher -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(6, 214, 160, 0.1);">
                                    <i class="fas fa-ticket-alt fa-lg" style="color: var(--success);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Stok Voucher</div>
                                <div class="h4 mb-0 fw-bold">{{ $paket->vouchers->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terjual -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(239, 71, 111, 0.1);">
                                    <i class="fas fa-shopping-cart fa-lg" style="color: var(--danger);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Terjual</div>
                                <div class="h4 mb-0 fw-bold">{{ $paket->sold_count ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="text-muted small mb-2">Status Ketersediaan</div>
                        @if($paket->available == 1)
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Tersedia
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>Tidak Tersedia
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

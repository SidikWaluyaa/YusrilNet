<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-eye me-2"></i>Detail Voucher
                </h1>
                <p class="text-muted mb-0 small">{{ $voucher->nama }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Info -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-4" style="color: #2d3748;">{{ $voucher->nama }}</h5>

                        <!-- Credentials -->
                        <div class="p-3 mb-4" style="background: #f8f9fa; border-radius: 8px; border: 1px dashed #dee2e6;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Username</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <code style="background: white; padding: 0.5rem; border-radius: 4px; flex: 1;">
                                            {{ $voucher->username }}
                                        </code>
                                        <button class="btn btn-sm btn-outline-primary" onclick="copyText('{{ $voucher->username }}')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Password</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <code style="background: white; padding: 0.5rem; border-radius: 4px; flex: 1;">
                                            {{ $voucher->password }}
                                        </code>
                                        <button class="btn btn-sm btn-outline-primary" onclick="copyText('{{ $voucher->password }}')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Info -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Harga</label>
                                <div class="h5 mb-0" style="color: var(--neptune-blue);">
                                    Rp {{ number_format($voucher->price, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Durasi</label>
                                <div class="h5 mb-0">
                                    <i class="fas fa-clock me-1"></i>{{ $voucher->duration }} Jam
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Sidebar -->
            <div class="col-lg-4">
                <!-- Available -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-3">
                        <div class="text-muted small mb-2">Available</div>
                        @if($voucher->available == 1)
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                <i class="fas fa-check me-1"></i>Available
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2">
                                <i class="fas fa-times me-1"></i>Used
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Status -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="text-muted small mb-2">Status</div>
                        @if($voucher->status == 'aktif')
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Aktif
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>Nonaktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Berhasil disalin!');
            });
        }
    </script>
</x-app-layout>

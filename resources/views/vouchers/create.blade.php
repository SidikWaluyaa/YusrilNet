<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i>Tambah Voucher
                </h1>
                <p class="text-muted mb-0 small">Buat voucher WiFi baru</p>
            </div>
            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.vouchers.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <!-- Paket -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Paket <span class="text-danger">*</span>
                            </label>
                            <select name="paket_id" class="form-select" required>
                                <option value="">Pilih Paket</option>
                                @foreach($pakets as $paket)
                                    <option value="{{ $paket->id }}">{{ $paket->nama }} - Rp {{ number_format($paket->price, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jumlah -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Jumlah Voucher <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="quantity" class="form-control" 
                                   placeholder="10" required min="1" value="1">
                            <small class="text-muted">Jumlah voucher yang akan dibuat</small>
                        </div>

                        <!-- Username Prefix (Optional) -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Prefix Username (Opsional)
                            </label>
                            <input type="text" name="username_prefix" class="form-control" 
                                   placeholder="Contoh: USER-">
                            <small class="text-muted">Prefix untuk username (akan ditambah nomor otomatis)</small>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" 
                                           id="status_aktif" value="aktif" checked>
                                    <label class="form-check-label" for="status_aktif">
                                        <i class="fas fa-check-circle text-success me-1"></i>Aktif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" 
                                           id="status_nonaktif" value="nonaktif">
                                    <label class="form-check-label" for="status_nonaktif">
                                        <i class="fas fa-times-circle text-danger me-1"></i>Nonaktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Buat Voucher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

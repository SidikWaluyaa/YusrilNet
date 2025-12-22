<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-edit me-2"></i>Edit Voucher
                </h1>
                <p class="text-muted mb-0 small">Perbarui informasi voucher</p>
            </div>
            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Paket -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Paket</label>
                            <select name="paket_id" class="form-select" required>
                                @foreach($pakets as $paket)
                                    <option value="{{ $paket->id }}" {{ $paket->id == $voucher->paket_id ? 'selected' : '' }}>
                                        {{ $paket->nama }} - Rp {{ number_format($paket->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Available -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Available</label>
                            <input type="number" name="available" class="form-control" 
                                   value="{{ $voucher->available }}" required min="0" max="1">
                            <small class="text-muted">0 = Used, 1 = Available</small>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" 
                                           id="status_aktif" value="aktif" {{ $voucher->status == 'aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_aktif">
                                        <i class="fas fa-check-circle text-success me-1"></i>Aktif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" 
                                           id="status_nonaktif" value="nonaktif" {{ $voucher->status == 'nonaktif' ? 'checked' : '' }}>
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
                            <i class="fas fa-save me-2"></i>Update Voucher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

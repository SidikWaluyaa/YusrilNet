<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i>Tambah Paket
                </h1>
                <p class="text-muted mb-0 small">Buat paket voucher WiFi baru</p>
            </div>
            <a href="{{ route('admin.pakets.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.pakets.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <!-- Nama Paket -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Nama Paket <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama" class="form-control" 
                                   placeholder="Contoh: Paket Harian 5GB" required>
                            <small class="text-muted">Nama paket yang akan ditampilkan</small>
                        </div>

                        <!-- Harga & Durasi -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Harga (Rp) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="price" class="form-control" 
                                   placeholder="10000" required min="0">
                            <small class="text-muted">Harga dalam Rupiah</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Durasi (Jam) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="duration" class="form-control" 
                                   placeholder="24" required min="1">
                            <small class="text-muted">Masa aktif voucher</small>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi" class="form-control" rows="3" 
                                      placeholder="Jelaskan keunggulan paket..." required></textarea>
                            <small class="text-muted">Deskripsi singkat paket</small>
                        </div>

                        <!-- Detail Paket -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Detail & Fitur <span class="text-danger">*</span>
                            </label>
                            <div id="detail-wrapper" class="mb-2">
                                <div class="input-group mb-2">
                                    <input type="text" name="detail_paket[]" class="form-control" 
                                           placeholder="Contoh: Kecepatan hingga 20 Mbps" required>
                                    <button type="button" class="btn btn-outline-danger btn-remove-detail">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm" id="add-detail">
                                <i class="fas fa-plus me-1"></i>Tambah Detail
                            </button>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Status Ketersediaan</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="available" 
                                           id="available_yes" value="1" checked>
                                    <label class="form-check-label" for="available_yes">
                                        <i class="fas fa-check-circle text-success me-1"></i>Tersedia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="available" 
                                           id="available_no" value="0">
                                    <label class="form-check-label" for="available_no">
                                        <i class="fas fa-times-circle text-danger me-1"></i>Tidak Tersedia
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('admin.pakets.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Paket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Tambah Detail
        document.getElementById('add-detail').onclick = function() {
            const wrapper = document.getElementById('detail-wrapper');
            const html = `
                <div class="input-group mb-2">
                    <input type="text" name="detail_paket[]" class="form-control" placeholder="Detail paket" required>
                    <button type="button" class="btn btn-outline-danger btn-remove-detail">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            wrapper.insertAdjacentHTML('beforeend', html);
        };

        // Hapus Detail
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove-detail')) {
                const wrapper = document.getElementById('detail-wrapper');
                if (wrapper.children.length > 1) {
                    e.target.closest('.input-group').remove();
                } else {
                    alert('Minimal harus ada satu detail paket!');
                }
            }
        });
    </script>
    @endpush
</x-app-layout>

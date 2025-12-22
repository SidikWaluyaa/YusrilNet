<!-- Modal Delete All -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-labelledby="deleteAllModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); color: white; border: none;">
                <h5 class="modal-title fw-bold" id="deleteAllModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus Semua
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-center text-danger fw-bold">PERINGATAN!</h5>
                <p class="text-center">Anda akan menghapus <strong>SEMUA</strong> voucher yang ada di database.</p>
                <p class="text-center text-muted">Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin?</p>
                <div class="alert alert-warning" style="border-radius: 12px;">
                    <i class="fas fa-info-circle me-2"></i>
                    Total voucher yang akan dihapus: <strong>{{ $vouchers->total() }}</strong>
                </div>
            </div>
            <div class="modal-footer" style="border: none; padding: 1.5rem 2rem;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 12px; padding: 0.75rem 1.5rem;">
                    <i class="fas fa-times me-2"></i> Batal
                </button>
                <form method="POST" action="{{ route('admin.vouchers.destroyAll') }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="border-radius: 12px; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); border: none;">
                        <i class="fas fa-trash-alt me-2"></i> Ya, Hapus Semua
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete by Filter -->
<div class="modal fade" id="deleteByFilterModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteByFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f5a623 0%, #f76b1c 100%); color: white; border: none;">
                <h5 class="modal-title fw-bold" id="deleteByFilterModalLabel">
                    <i class="fas fa-filter me-2"></i> Hapus Berdasarkan Filter
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.vouchers.destroyByFilter') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body" style="padding: 2rem;">
                    <div class="text-center mb-3">
                        <i class="fas fa-filter text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-center text-warning fw-bold">PERINGATAN!</h5>
                    <p class="text-center">Voucher akan dihapus sesuai dengan filter yang Anda pilih:</p>

                    <div class="mb-3">
                        <label for="modal_status" class="form-label fw-bold">Status</label>
                        <select name="status" id="modal_status" class="form-select" style="border-radius: 12px; border: 2px solid #e9ecef; padding: 0.75rem;">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal_paket_id" class="form-label fw-bold">Paket</label>
                        <select name="paket_id" id="modal_paket_id" class="form-select" style="border-radius: 12px; border: 2px solid #e9ecef; padding: 0.75rem;">
                            <option value="">Semua Paket</option>
                            @foreach ($pakets as $paket)
                                <option value="{{ $paket->id }}"
                                    {{ request('paket_id') == $paket->id ? 'selected' : '' }}>
                                    {{ $paket->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal_username" class="form-label fw-bold">Username</label>
                        <input type="text" name="username" id="modal_username" class="form-control"
                            value="{{ request('username') }}" placeholder="Cari berdasarkan username..."
                            style="border-radius: 12px; border: 2px solid #e9ecef; padding: 0.75rem;">
                    </div>

                    <div class="alert alert-info" style="border-radius: 12px;">
                        <i class="fas fa-info-circle me-2"></i>
                        Filter akan diterapkan pada voucher yang akan dihapus
                    </div>
                </div>
                <div class="modal-footer" style="border: none; padding: 1.5rem 2rem;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 12px; padding: 0.75rem 1.5rem;">
                        <i class="fas fa-times me-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning" style="border-radius: 12px; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f5a623 0%, #f76b1c 100%); border: none; color: white;">
                        <i class="fas fa-filter me-2"></i> Hapus Sesuai Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-box me-2"></i>Daftar Paket
                </h1>
                <p class="text-muted mb-0 small">Kelola paket voucher WiFi</p>
            </div>
            <a href="{{ route('admin.pakets.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Paket
            </a>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(67, 97, 238, 0.1);">
                                    <i class="fas fa-box fa-lg" style="color: var(--neptune-blue);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Total Paket</div>
                                <div class="h3 mb-0 fw-bold">{{ $pakets->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(6, 214, 160, 0.1);">
                                    <i class="fas fa-ticket-alt fa-lg" style="color: var(--success);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Total Voucher</div>
                                <div class="h3 mb-0 fw-bold">{{ $pakets->sum(fn($p) => $p->vouchers->count()) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
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
                                <div class="h3 mb-0 fw-bold">{{ $pakets->sum(fn($p) => $p->sold_count) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if($pakets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th class="border-0 px-4 py-3">Nama Paket</th>
                                    <th class="border-0 px-4 py-3">Harga</th>
                                    <th class="border-0 px-4 py-3">Durasi</th>
                                    <th class="border-0 px-4 py-3">Stok</th>
                                    <th class="border-0 px-4 py-3">Status</th>
                                    <th class="border-0 px-4 py-3 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pakets as $paket)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="fw-semibold">{{ $paket->nama }}</div>
                                            <div class="text-muted small">{{ Str::limit($paket->deskripsi, 50) }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-bold" style="color: var(--neptune-blue);">
                                                Rp {{ number_format($paket->price, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <i class="fas fa-clock me-1 text-muted"></i>{{ $paket->duration }} Jam
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark border">
                                                {{ $paket->vouchers_available_count ?? $paket->vouchers->count() }} voucher
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($paket->available == 1)
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="fas fa-check-circle me-1"></i>Tersedia
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger">
                                                    <i class="fas fa-times-circle me-1"></i>Tutup
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.pakets.show', $paket->id) }}" 
                                                   class="btn btn-outline-primary" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.pakets.edit', $paket->id) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.pakets.destroy', $paket->id) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada paket</h5>
                        <p class="text-muted mb-3">Mulai tambahkan paket voucher pertama</p>
                        <a href="{{ route('admin.pakets.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Paket
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($pakets, 'links') && $pakets->count() > 0)
            <div class="mt-4">
                {{ $pakets->links() }}
            </div>
        @endif
    </div>

    <style>
        .table tbody tr {
            transition: background-color 0.2s;
        }
        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }
        .btn-group-sm .btn {
            padding: 0.375rem 0.75rem;
        }
    </style>
</x-app-layout>

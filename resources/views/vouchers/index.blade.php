<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-ticket-alt me-2"></i>Daftar Voucher
                </h1>
                <p class="text-muted mb-0 small">Kelola voucher WiFi</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah
                </a>
                <a href="{{ route('admin.vouchers.export') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-download me-1"></i>Export
                </a>
                <a href="{{ route('admin.vouchers.import.form') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-upload me-1"></i>Import
                </a>
                <a href="{{ route('admin.vouchers.template') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-file-excel me-1"></i>Template
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('admin.vouchers.index') }}">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="username" class="form-control form-control-sm" 
                                   placeholder="Cari username..." value="{{ request('username') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="paket_id" class="form-select form-select-sm">
                                <option value="">Semua Paket</option>
                                @foreach($pakets as $paket)
                                    <option value="{{ $paket->id }}" {{ request('paket_id') == $paket->id ? 'selected' : '' }}>
                                        {{ $paket->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-undo me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if($vouchers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th class="border-0 px-4 py-3">ID</th>
                                    <th class="border-0 px-4 py-3">Paket</th>
                                    <th class="border-0 px-4 py-3">Username</th>
                                    <th class="border-0 px-4 py-3">Password</th>
                                    <th class="border-0 px-4 py-3">Harga</th>
                                    <th class="border-0 px-4 py-3">Durasi</th>
                                    <th class="border-0 px-4 py-3">Available</th>
                                    <th class="border-0 px-4 py-3">Status</th>
                                    <th class="border-0 px-4 py-3 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vouchers as $voucher)
                                    <tr>
                                        <td class="px-4 py-3">{{ $voucher->id }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark border">{{ $voucher->nama }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <code style="background: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                                {{ $voucher->username }}
                                            </code>
                                        </td>
                                        <td class="px-4 py-3">
                                            <code style="background: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                                {{ $voucher->password }}
                                            </code>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-bold" style="color: var(--neptune-blue);">
                                                Rp {{ number_format($voucher->price, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <i class="fas fa-clock me-1 text-muted"></i>{{ $voucher->duration }} Jam
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($voucher->available == 1)
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="fas fa-check me-1"></i>Available
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">
                                                    <i class="fas fa-times me-1"></i>Used
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($voucher->status == 'aktif')
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger">
                                                    <i class="fas fa-times-circle me-1"></i>Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.vouchers.show', $voucher->id) }}" 
                                                   class="btn btn-outline-primary" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus voucher ini?')">
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
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada voucher</h5>
                        <p class="text-muted mb-3">Mulai tambahkan voucher pertama</p>
                        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Voucher
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($vouchers, 'links') && $vouchers->count() > 0)
            <div class="mt-4">
                {{ $vouchers->links() }}
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
        @media (max-width: 768px) {
            .table {
                font-size: 0.875rem;
            }
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</x-app-layout>

<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-shopping-cart me-2"></i>Daftar Order
                </h1>
                <p class="text-muted mb-0 small">Kelola transaksi pelanggan</p>
            </div>
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
                                    <i class="fas fa-receipt fa-lg" style="color: var(--neptune-blue);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Total Order</div>
                                <div class="h3 mb-0 fw-bold">{{ $orders->count() }}</div>
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
                                    <i class="fas fa-check-circle fa-lg" style="color: var(--success);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Selesai</div>
                                <div class="h3 mb-0 fw-bold">{{ $orders->where('status', 'selesai')->count() }}</div>
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
                                     style="width: 50px; height: 50px; background: rgba(67, 97, 238, 0.1);">
                                    <i class="fas fa-wallet fa-lg" style="color: var(--neptune-blue);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Pendapatan</div>
                                <div class="h3 mb-0 fw-bold" style="font-size: 1.25rem;">
                                    Rp {{ number_format($orders->sum('harga'), 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Print -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-3">
                <form action="{{ route('admin.orders.print') }}" method="GET" target="_blank">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <select name="paket_id" class="form-select form-select-sm">
                                <option value="">Semua Paket</option>
                                @foreach(\App\Models\Paket::all() as $paket)
                                    <option value="{{ $paket->id }}">{{ $paket->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal_mulai" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal_akhir" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-print me-1"></i>Cetak PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th class="border-0 px-4 py-3">ID</th>
                                    <th class="border-0 px-4 py-3">Pelanggan</th>
                                    <th class="border-0 px-4 py-3">Paket</th>
                                    <th class="border-0 px-4 py-3">Voucher</th>
                                    <th class="border-0 px-4 py-3">Harga</th>
                                    <th class="border-0 px-4 py-3">Status</th>
                                    <th class="border-0 px-4 py-3 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="px-4 py-3">#{{ $order->id }}</td>
                                        <td class="px-4 py-3">
                                            <div>
                                                <div class="fw-semibold">{{ $order->nama }}</div>
                                                <div class="text-muted small">{{ $order->email }}</div>
                                                <div class="text-muted small">
                                                    <i class="far fa-clock me-1"></i>{{ $order->created_at->format('d M Y, H:i') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark border">{{ $order->paket->nama }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($order->voucher)
                                                <div class="small">
                                                    <code style="background: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                                        {{ $order->voucher->username }}
                                                    </code>
                                                </div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-bold" style="color: var(--neptune-blue);">
                                                Rp {{ number_format($order->harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($order->status == 'selesai' || $order->status == 'terkirim')
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="fas fa-check-circle me-1"></i>{{ ucfirst($order->status) }}
                                                </span>
                                            @elseif($order->status == 'pending')
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                </span>
                                            @else
                                                <span class="badge bg-info-subtle text-info">
                                                    <i class="fas fa-info-circle me-1"></i>{{ ucfirst($order->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.orders.edit', $order->id) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus order ini?')">
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
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada order</h5>
                        <p class="text-muted mb-0">Order baru akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($orders, 'links') && $orders->count() > 0)
            <div class="mt-4">
                {{ $orders->links() }}
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

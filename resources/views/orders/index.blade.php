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
            <div class="dropdown">
                <button class="btn btn-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-trash me-1"></i>Hapus Massal
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button type="button" class="dropdown-item text-danger" onclick="submitBulkDelete()">
                            <i class="fas fa-check-square me-2"></i>Hapus Terpilih
                        </button>
                    </li>
                    <li>
                        <form action="{{ route('admin.orders.destroyByFilter', request()->all()) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus order sesuai filter saat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-filter me-2"></i>Hapus Sesuai Filter
                            </button>
                        </form>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('admin.orders.deleteAll') }}" method="POST" onsubmit="return confirm('PERINGATAN: Semua order akan dihapus! Yakin?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>Hapus SEMUA Data
                            </button>
                        </form>
                    </li>
                </ul>
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
                                <div class="text-muted small mb-1">Total Order (Berhasil)</div>
                                <div class="h3 mb-0 fw-bold">{{ $total_orders }}</div>
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
                                <div class="h3 mb-0 fw-bold">{{ $total_selesai }}</div>
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
                                    Rp {{ number_format($total_pendapatan, 0, ',', '.') }}
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
                                    <th class="border-0 px-4 py-3" style="width: 40px;">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
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
                                        <td class="px-4 py-3">
                                            <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="form-check-input order-checkbox">
                                        </td>
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
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="small">
                                                        <span class="text-muted me-1" style="font-size: 0.7rem;">User:</span>
                                                        <code style="background: #f8f9fa; padding: 0.15rem 0.4rem; border-radius: 4px; color: var(--primary);">
                                                            {{ $order->voucher->username }}
                                                        </code>
                                                    </div>
                                                    <div class="small">
                                                        <span class="text-muted me-1" style="font-size: 0.7rem;">Pass:</span>
                                                        <code style="background: #f8f9fa; padding: 0.15rem 0.4rem; border-radius: 4px; color: var(--danger);">
                                                            {{ $order->voucher->password }}
                                                        </code>
                                                    </div>
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
                                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                                   class="btn btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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
    </style>
</x-app-layout>

<form id="bulkDeleteForm" action="{{ route('admin.orders.destroySelected') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="order_ids" id="bulkDeleteInput">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.order-checkbox');

        // Handle Select All
        if(selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        }

        // Handle individual checkbox change to update Select All state
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (!this.checked) {
                    selectAll.checked = false;
                } else {
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    if (allChecked) selectAll.checked = true;
                }
            });
        });
    });

    function submitBulkDelete() {
        // Collect checked IDs
        const checkboxes = document.querySelectorAll('.order-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Pilih setidaknya satu order untuk dihapus.');
            return;
        }

        if (!confirm('Yakin ingin menghapus ' + checkboxes.length + ' order terpilih?')) {
            return;
        }

        const ids = Array.from(checkboxes).map(cb => cb.value);
        
        // Prepare hidden form
        const form = document.getElementById('bulkDeleteForm');
        // Remove existing dynamic inputs
        form.querySelectorAll('input[name="order_ids[]"]').forEach(el => el.remove());

        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'order_ids[]';
            input.value = id;
            form.appendChild(input);
        });

        form.submit();
    }
</script>

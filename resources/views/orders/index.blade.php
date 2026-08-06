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
                                                 @if($order->status == 'menunggu' || $order->status == 'pending')
                                                     @if($order->snap_token)
                                                         <button type="button" 
                                                                 class="btn btn-outline-primary btn-check-ipaymu" 
                                                                 data-order-id="{{ $order->id }}"
                                                                 title="Cek Status iPaymu (Live Modal)">
                                                             <i class="fas fa-search-dollar"></i>
                                                         </button>
                                                     @endif
                                                     <form action="{{ route('admin.orders.confirmManual', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengonfirmasi Order #{{ $order->id }} secara manual dan langsung mengirim email voucher?')">
                                                         @csrf
                                                         <button type="submit" class="btn btn-success text-white" title="Konfirmasi Manual & Kirim Voucher">
                                                             <i class="fas fa-check-double"></i>
                                                         </button>
                                                     </form>
                                                 @endif
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

    <!-- Modal Status iPaymu (Live 2-Langkah) -->
    <div class="modal fade" id="ipaymuStatusModal" tabindex="-1" aria-labelledby="ipaymuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-header-title modal-title h6 fw-bold mb-0" id="ipaymuModalLabel">
                        <i class="fas fa-receipt me-2 text-primary"></i>Detail Status iPaymu (Live)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="ipaymuModalBody">
                    <div class="text-center py-4" id="ipaymuModalSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted small mt-2 mb-0">Menghubungkan ke API iPaymu...</p>
                    </div>
                    <div id="ipaymuModalContent" style="display: none;">
                        <!-- Alert Status -->
                        <div id="ipaymuStatusAlert" class="alert d-flex align-items-center p-3 mb-3" role="alert">
                            <i id="ipaymuStatusIcon" class="fas fa-2x me-3"></i>
                            <div>
                                <div class="fw-bold" id="ipaymuStatusTitle">Status Pembayaran</div>
                                <div class="small" id="ipaymuStatusSub">Keterangan iPaymu</div>
                            </div>
                        </div>

                        <!-- Details Table -->
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body p-3">
                                <div class="row g-2 small">
                                    <div class="col-6 text-muted">Order ID:</div>
                                    <div class="col-6 text-end fw-semibold" id="mOrderId">#0</div>
                                    <div class="col-6 text-muted">Pelanggan:</div>
                                    <div class="col-6 text-end fw-semibold" id="mBuyerName">-</div>
                                    <div class="col-6 text-muted">Email:</div>
                                    <div class="col-6 text-end fw-semibold" id="mBuyerEmail">-</div>
                                    <div class="col-6 text-muted">Paket WiFi:</div>
                                    <div class="col-6 text-end fw-semibold" id="mPaketNama">-</div>
                                    <div class="col-6 text-muted">Nominal Total:</div>
                                    <div class="col-6 text-end fw-bold text-primary" id="mAmount">Rp 0</div>
                                    <div class="col-6 text-muted">Metode Bayar:</div>
                                    <div class="col-6 text-end fw-semibold" id="mPaymentMethod">-</div>
                                    <div class="col-6 text-muted">Transaction ID:</div>
                                    <div class="col-6 text-end text-muted font-monospace" id="mTrxId">-</div>
                                </div>
                            </div>
                        </div>

                        <div id="ipaymuHoldNotice" class="alert alert-warning small mb-0 d-none">
                            <i class="fas fa-exclamation-triangle me-1"></i> Pembayaran di iPaymu belum lunas. Transaksi tetap berada di status <strong>Menunggu (Hold)</strong>.
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <form id="confirmManualFormModal" action="" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" id="btnConfirmInModal" class="btn btn-success btn-sm text-white d-none" onclick="return confirm('Konfirmasi order ini dan kirimkan email voucher ke pelanggan?')">
                            <i class="fas fa-check-circle me-1"></i>Konfirmasi & Kirim Kode Voucher
                        </button>
                    </form>
                </div>
            </div>
        </div>
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

        // Handle iPaymu Status Check Modal (2-Step)
        const modalEl = document.getElementById('ipaymuStatusModal');
        const modal = modalEl && typeof bootstrap !== 'undefined' ? new bootstrap.Modal(modalEl) : null;

        document.querySelectorAll('.btn-check-ipaymu').forEach(btn => {
            btn.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                if (!orderId) return;

                // Reset modal state
                document.getElementById('ipaymuModalSpinner').style.display = 'block';
                document.getElementById('ipaymuModalContent').style.display = 'none';
                document.getElementById('btnConfirmInModal').classList.add('d-none');
                document.getElementById('ipaymuHoldNotice').classList.add('d-none');

                if (modal) modal.show();

                fetch(`/admin/orders/${orderId}/check-ipaymu`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('ipaymuModalSpinner').style.display = 'none';
                    document.getElementById('ipaymuModalContent').style.display = 'block';

                    if (data.success) {
                        const isPaid = data.is_paid;
                        const alertEl = document.getElementById('ipaymuStatusAlert');
                        const iconEl = document.getElementById('ipaymuStatusIcon');
                        const titleEl = document.getElementById('ipaymuStatusTitle');
                        const subEl = document.getElementById('ipaymuStatusSub');
                        const btnConfirm = document.getElementById('btnConfirmInModal');
                        const holdNotice = document.getElementById('ipaymuHoldNotice');
                        const formConfirm = document.getElementById('confirmManualFormModal');

                        formConfirm.action = `/admin/orders/${orderId}/confirm-manual`;

                        if (isPaid) {
                            alertEl.className = 'alert alert-success d-flex align-items-center p-3 mb-3';
                            iconEl.className = 'fas fa-check-circle fa-2x me-3 text-success';
                            titleEl.innerText = 'LUNAS / BERHASIL';
                            subEl.innerText = `Pembayaran terkonfirmasi di iPaymu (${data.status_desc})`;
                            btnConfirm.classList.remove('d-none');
                            holdNotice.classList.add('d-none');
                        } else {
                            alertEl.className = 'alert alert-warning d-flex align-items-center p-3 mb-3';
                            iconEl.className = 'fas fa-clock fa-2x me-3 text-warning';
                            titleEl.innerText = 'BELUM DIBAYAR';
                            subEl.innerText = `Status iPaymu: ${data.status_desc}`;
                            btnConfirm.classList.add('d-none');
                            holdNotice.classList.remove('d-none');
                        }

                        document.getElementById('mOrderId').innerText = '#' + data.order.id;
                        document.getElementById('mBuyerName').innerText = data.buyer_name || data.order.nama;
                        document.getElementById('mBuyerEmail').innerText = data.buyer_email || data.order.email;
                        document.getElementById('mPaketNama').innerText = data.order.paket;
                        document.getElementById('mAmount').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.amount);
                        document.getElementById('mPaymentMethod').innerText = (data.payment_method || '-') + (data.payment_channel && data.payment_channel !== '-' ? ' (' + data.payment_channel + ')' : '');
                        document.getElementById('mTrxId').innerText = data.transaction_id || '-';
                    } else {
                        alert('Gagal mengambil status: ' + data.message);
                        if (modal) modal.hide();
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan koneksi ke server.');
                    if (modal) modal.hide();
                });
            });
        });
    });

    function submitBulkDelete() {
        const checkboxes = document.querySelectorAll('.order-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Pilih setidaknya satu order untuk dihapus.');
            return;
        }

        if (!confirm('Yakin ingin menghapus ' + checkboxes.length + ' order terpilih?')) {
            return;
        }

        const ids = Array.from(checkboxes).map(cb => cb.value);
        const form = document.getElementById('bulkDeleteForm');
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

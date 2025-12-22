<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-edit me-2"></i>Edit Order
                </h1>
                <p class="text-muted mb-0 small">Perbarui informasi order #{{ $order->id }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Nama -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Pelanggan</label>
                            <input type="text" name="nama" class="form-control" 
                                   value="{{ $order->nama }}" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ $order->email }}" required>
                        </div>

                        <!-- Paket -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Paket</label>
                            <select name="paket_id" class="form-select" required>
                                @foreach($pakets as $paket)
                                    <option value="{{ $paket->id }}" {{ $order->paket_id == $paket->id ? 'selected' : '' }}>
                                        {{ $paket->nama }} - Rp {{ number_format($paket->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" 
                                   value="{{ $order->harga }}" required min="0">
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Status Order</label>
                            <div class="d-flex gap-3 flex-wrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" 
                                           id="status_pending" value="pending" {{ $order->status == 'pending' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_pending">
                                        <i class="fas fa-clock text-warning me-1"></i>Pending
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" 
                                           id="status_terkirim" value="terkirim" {{ $order->status == 'terkirim' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_terkirim">
                                        <i class="fas fa-paper-plane text-info me-1"></i>Terkirim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" 
                                           id="status_selesai" value="selesai" {{ $order->status == 'selesai' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_selesai">
                                        <i class="fas fa-check-circle text-success me-1"></i>Selesai
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" 
                                           id="status_batal" value="batal" {{ $order->status == 'batal' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_batal">
                                        <i class="fas fa-times-circle text-danger me-1"></i>Batal
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

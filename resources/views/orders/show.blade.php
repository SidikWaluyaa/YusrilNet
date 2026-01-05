<x-app-layout>
    @section('title', 'Detail Order #' . $order->id)

    <style>
        :root {
            --primary: #667eea;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 10px 30px rgba(102, 126, 234, 0.15);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .page-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .card-header-modern {
            background: var(--gradient-primary);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .card-header-modern h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .card-body-modern {
            padding: 2.5rem;
        }

        .info-group {
            margin-bottom: 1.5rem;
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            display: block;
        }

        .info-value {
            font-weight: 500;
            color: #2d3748;
            font-size: 1.1rem;
            word-break: break-word;
        }

        .btn-modern {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            background: var(--gradient-primary);
            box-shadow: var(--shadow-sm);
            text-decoration: none;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .btn-secondary-modern {
            background: #e9ecef;
            color: #495057;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary-modern:hover {
            background: #dee2e6;
            color: #212529;
            transform: translateY(-2px);
        }
    </style>

    <div class="container-fluid px-4 mb-5">
        <div class="page-header" data-aos="fade-down">
            <h1>Detail Order #{{ $order->id }}</h1>
            <p class="text-muted">Informasi lengkap transaksi pelanggan</p>
        </div>

        <div class="form-card" data-aos="fade-up" data-aos-delay="200">
            <div class="card-header-modern">
                <h2>
                    <i class="fas fa-info-circle"></i>
                    <span>Informasi Order</span>
                </h2>
            </div>
            
            <div class="card-body-modern">
                <div class="row">
                    <!-- Informasi Pelanggan -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-muted border-bottom pb-2">Informasi Pelanggan</h5>
                        
                        <div class="info-group">
                            <span class="info-label">Nama Pelanggan</span>
                            <div class="info-value">{{ $order->nama }}</div>
                        </div>

                        <div class="info-group">
                            <span class="info-label">Email</span>
                            <div class="info-value">{{ $order->email }}</div>
                        </div>

                        <div class="info-group">
                            <span class="info-label">Info User (Akun yang membuat)</span>
                            <div class="info-value">{{ $order->user ? $order->user->name : 'By System/Public' }}</div>
                        </div>
                    </div>

                    <!-- Detail Pesanan -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-muted border-bottom pb-2">Detail Transaksi</h5>

                        <div class="info-group">
                            <span class="info-label">Paket</span>
                            <div class="info-value badge bg-primary">{{ $order->paket->nama }}</div>
                            <small class="d-block text-muted mt-1">{{ $order->paket->deskripsi ?? '' }}</small>
                        </div>

                        <div class="info-group">
                            <span class="info-label">Harga</span>
                            <div class="info-value text-success">Rp {{ number_format($order->harga, 0, ',', '.') }}</div>
                        </div>

                        <div class="info-group">
                            <span class="info-label">Status</span>
                            <div class="info-value">
                                @if($order->status == 'selesai' || $order->status == 'terkirim')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>{{ ucfirst($order->status) }}
                                    </span>
                                @elseif($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                @else
                                    <span class="badge bg-info">
                                        <i class="fas fa-info-circle me-1"></i>{{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="info-group">
                            <span class="info-label">Tanggal Order</span>
                            <div class="info-value">{{ $order->created_at->format('d F Y, H:i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Voucher Info -->
                @if($order->voucher)
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-muted border-bottom pb-2">Informasi Voucher</h5>
                        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
                            <i class="fas fa-wifi fa-2x me-3"></i>
                            <div class="w-100">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-uppercase small fw-bold opacity-75">Username</span>
                                        <div class="h4 mb-0 font-monospace">{{ $order->voucher->username }}</div>
                                    </div>
                                    <div class="col-md-6 border-start">
                                        <span class="text-uppercase small fw-bold opacity-75">Password</span>
                                        <div class="h4 mb-0 font-monospace">{{ $order->voucher->password }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="d-flex gap-3 mt-5 justify-content-between" data-aos="fade-up" data-aos-delay="600">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary-modern">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning text-white btn-modern" style="background: #f6ad55; color: white;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script>
            AOS.init({
                duration: 600,
                once: true
            });
        </script>
    @endpush
</x-app-layout>

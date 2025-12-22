<x-app-layout>
    @section('title', 'Buat Order Baru')

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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control-modern {
            border-radius: 10px;
            border: 1px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control-modern:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
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
            <h1>Buat Order Baru</h1>
            <p class="text-muted">Tambahkan pesanan manual untuk pelanggan</p>
        </div>

        <div class="form-card" data-aos="fade-up" data-aos-delay="200">
            <div class="card-header-modern">
                <h2>
                    <i class="fas fa-plus-circle"></i>
                    <span>Form Order Baru</span>
                </h2>
            </div>
            
            <div class="card-body-modern">
                <form action="{{ route('admin.orders.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Informasi Pelanggan -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-muted border-bottom pb-2">Informasi Pelanggan</h5>
                            
                            <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                                <label class="form-label">Nama Pelanggan</label>
                                <input type="text" class="form-control-modern" name="nama" placeholder="Masukkan nama pelanggan" required>
                            </div>

                            <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control-modern" name="email" placeholder="Masukkan email pelanggan" required>
                            </div>
                        </div>

                        <!-- Detail Pesanan -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-muted border-bottom pb-2">Detail Pesanan</h5>

                            <div class="form-group" data-aos="fade-up" data-aos-delay="500">
                                <label class="form-label">Pilih Paket</label>
                                <select name="paket_id" class="form-select form-control-modern" required>
                                    <option value="">-- Pilih Paket Layanan --</option>
                                    @foreach($pakets as $paket)
                                        <option value="{{ $paket->id }}">
                                            {{ $paket->nama }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-5 justify-content-end" data-aos="fade-up" data-aos-delay="600">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary-modern">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-modern">
                            <i class="fas fa-save"></i> Buat Order
                        </button>
                    </div>
                </form>
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

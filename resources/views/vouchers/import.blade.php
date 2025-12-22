<x-app-layout>
    @section('title', 'Import Voucher')

    {{-- Styling --}}
    <style>
        :root {
            --neptune-primary: #4682B4;
            --neptune-secondary: #5F9EA0;
            --neptune-light: #B0E0E6;
            --neptune-dark: #2F4F4F;
            --neptune-gradient: linear-gradient(135deg, #4682B4 0%, #5F9EA0 100%);
            --neptune-gradient-light: linear-gradient(135deg, #B0E0E6 0%, #87CEEB 100%);
        }

        .neptune-container {
            padding: 2rem 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fdff 0%, #e6f3ff 100%);
        }

        .import-card {
            background: #ffffffcc;
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(70, 130, 180, 0.1);
            overflow: hidden;
        }

        .card-header-neptune {
            background: var(--neptune-gradient);
            color: white;
            padding: 2rem;
        }

        .card-body-neptune {
            padding: 2.5rem;
        }

        .alert-neptune-success,
        .alert-neptune-danger {
            border-radius: 12px;
            padding: 1rem 1.5rem;
            border-left: 5px solid;
            margin-bottom: 20px;
        }

        .alert-neptune-success {
            background: #d4edda;
            border-color: #28a745;
            color: #155724;
        }

        .alert-neptune-danger {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }

        .form-control-neptune {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 12px 20px;
            font-size: 1rem;
            background: #fff;
        }

        .form-label-neptune {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--neptune-dark);
        }

        .upload-area {
            border: 2px dashed var(--neptune-light);
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            background: var(--neptune-gradient-light);
            transition: all 0.3s ease;
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--neptune-primary);
        }

        .btn-neptune-primary {
            background: var(--neptune-gradient);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-neptune-primary:hover {
            background: #365f87;
        }

        .btn-neptune-secondary {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
        }

        .instructions-card {
            margin-top: 2rem;
            background: #f1f9ff;
            padding: 1.5rem;
            border-left: 5px solid var(--neptune-primary);
            border-radius: 15px;
        }

        .instructions-list li::before {
            content: '✓';
            color: var(--neptune-primary);
            margin-right: 8px;
        }

        .download-badge {
            display: inline-block;
            padding: 8px 15px;
            background: var(--neptune-gradient-light);
            border-radius: 20px;
            font-weight: 600;
            color: var(--neptune-dark);
            text-decoration: none;
            transition: 0.3s ease;
        }

        .download-badge:hover {
            background: var(--neptune-primary);
            color: white;
        }
    </style>

    {{-- Content --}}
    <div class="neptune-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="card import-card">
                        <div class="card-header card-header-neptune">
                            <h4 class="mb-0">
                                <i class="fas fa-file-import me-2"></i> Import Vouchers dari File
                            </h4>
                        </div>
                        <div class="card-body card-body-neptune">
                            {{-- Success/Error Alert --}}
                            @if (session('success'))
                                <div class="alert alert-neptune-success">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-neptune-danger">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                </div>
                            @endif

                            {{-- Template Download --}}
                            <div class="text-center mb-4">
                                <a href="{{ route('admin.vouchers.template') }}" class="download-badge">
                                    <i class="fas fa-download me-1"></i> Download Template CSV
                                </a>
                            </div>

                            {{-- Upload Form --}}
                            <form action="{{ route('admin.vouchers.import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="upload-area mb-4">
                                    <div class="upload-icon mb-2">
                                        <i class="fas fa-file-csv"></i>
                                    </div>
                                    <label for="file" class="form-label-neptune">Pilih File CSV / Excel</label>
                                    <input type="file" name="file" id="file" accept=".csv,.xls,.xlsx"
                                        class="form-control form-control-neptune @error('file') is-invalid @enderror"
                                        required>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-muted mt-2">
                                        Format didukung: .csv, .xlsx, .xls (maks. 2MB)
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <button type="submit" class="btn btn-neptune-primary">
                                        <i class="fas fa-upload me-1"></i> Import Sekarang
                                    </button>
                                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-neptune-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>
                            </form>

                            {{-- Instructions --}}
                            <div class="instructions-card mt-4">
                                <h5><i class="fas fa-info-circle me-2"></i> Petunjuk Pengisian</h5>
                                <ul class="instructions-list">
                                    <li>Unduh template terlebih dahulu.</li>
                                    <li>Isi sesuai format: nama_paket, status, dst.</li>
                                    <li>Nama paket harus cocok dengan data di sistem.</li>
                                    <li>Username dan password bisa dikosongkan untuk auto-generate.</li>
                                    <li>Status hanya boleh: "aktif" atau "nonaktif".</li>
                                    <li>Ukuran file maksimal 2MB.</li>
                                </ul>
                            </div>
                        </div> {{-- end card-body --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

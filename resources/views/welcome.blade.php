<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yusril Net - Penyedia Voucher WiFi Terpercaya</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Icons & CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('Logo.png') }}" type="image/x-icon">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --success: #06d6a0;
            --dark: #1e293b;
            --light: #f8f9fa;
            --gradient: linear-gradient(135deg, #4361ee 0%, #4cc9f0 100%);
            --gradient-hover: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%);
            --glass: rgba(255, 255, 255, 0.95);
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 15px -3px rgba(67, 97, 238, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(67, 97, 238, 0.15);
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--dark);
            background-color: #f3f6fc;
            overflow-x: hidden;
            line-height: 1.7;
        }

        /* Navbar */
        .navbar {
            padding: 15px 0;
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
        }

        .navbar-brand span {
            color: var(--secondary);
        }

        .nav-link {
            font-weight: 600;
            color: var(--dark) !important;
            margin: 0 5px;
            padding: 8px 16px !important;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary) !important;
            background: rgba(67, 97, 238, 0.05);
        }

        /* Hero Section */
        #home {
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.6)), url('gedung1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 80px;
        }

        .hero-content {
            text-align: center;
            color: white;
            padding: 20px;
        }

        .hero-content h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .hero-content p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-btn {
            background: var(--gradient);
            color: white !important;
            padding: 16px 45px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
        }

        .hero-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(67, 97, 238, 0.5);
            background: var(--gradient-hover);
        }

        /* Section Styles */
        section {
            padding: 100px 0;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 15px;
            display: inline-block;
            position: relative;
        }

        .section-title h2::after {
            content: '';
            display: block;
            width: 80px;
            height: 6px;
            background: var(--gradient);
            margin: 15px auto 0;
            border-radius: 10px;
        }

        /* Cards */
        .service-card,
        .pricing-card {
            background: white;
            border-radius: 25px;
            padding: 40px 30px;
            border: 1px solid rgba(0, 0, 0, 0.03);
            box-shadow: var(--shadow-sm);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .service-card:hover,
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-md);
            border-color: transparent;
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 25px;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            background: var(--gradient);
            color: white;
            transform: scale(1.1) rotate(5deg);
        }

        .service-title {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 15px;
        }

        /* Pricing */
        .pricing-card.popular {
            border: 2px solid var(--primary);
            box-shadow: var(--shadow-md);
        }

        .popular-badge {
            position: absolute;
            top: 20px;
            right: -35px;
            transform: rotate(45deg);
            background: var(--gradient);
            color: white;
            padding: 8px 40px;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .pricing-price {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin: 20px 0 5px;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .pricing-btn {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: 15px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid var(--primary);
            background: var(--primary);
            color: white;
            margin-top: 10px;
        }

        .pricing-btn:hover {
            background: transparent;
            color: var(--primary);
        }

        .pricing-btn.secondary {
            background: transparent;
            color: var(--primary);
            border: 2px solid rgba(67, 97, 238, 0.3);
        }

        .pricing-btn.secondary:hover {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.05);
        }

        /* About */
        .about-img {
            border-radius: 30px;
            box-shadow: var(--shadow-lg);
            transform: rotate(-2deg);
            transition: all 0.5s ease;
        }

        .about-img:hover {
            transform: rotate(0) scale(1.02);
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 80px 0 30px;
            position: relative;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 1.5rem;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-5px);
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .navbar-collapse {
                background: white;
                padding: 20px;
                border-radius: 15px;
                box-shadow: var(--shadow-lg);
                margin-top: 15px;
            }

            .navbar-toggler {
                border: 2px solid var(--primary);
                padding: 8px 12px;
            }

            .navbar-toggler:focus {
                box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
            }

            .service-card,
            .pricing-card {
                padding: 30px 20px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
                line-height: 1.3;
            }

            .hero-content p {
                font-size: 1.1rem;
                line-height: 1.6;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            section {
                padding: 60px 0;
            }

            #voucher,
            #services,
            #about {
                padding: 50px 0;
            }

            .navbar-brand {
                font-size: 1.5rem;
            }

            .pricing-price {
                font-size: 2rem;
            }

            .service-icon {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
            }

            .footer-title {
                font-size: 1.3rem;
            }

            .pricing-card {
                margin-bottom: 25px;
            }
        }

        @media (max-width: 576px) {
            html, body {
                max-width: 100%;
                overflow-x: hidden;
            }

            /* Safety reset for standard box model behavior */
            *, ::after, ::before {
                box-sizing: border-box;
            }

            .navbar {
                padding: 10px 0;
            }

            .navbar-brand {
                font-size: 1.4rem;
            }
            
            #home {
                padding: 110px 0 50px; 
                background-position: center top;
                width: 100%;
                position: relative;
                overflow: hidden;
            }

            .hero-content {
                padding: 0 20px;
                text-align: center;
                width: 100%;
            }

            .hero-content h1 {
                font-size: clamp(2rem, 9vw, 2.5rem); 
                margin-bottom: 1rem;
                text-align: center;
            }

            .hero-content p {
                font-size: 1rem;
                margin-bottom: 2rem;
                line-height: 1.5;
                text-align: center;
                opacity: 0.95;
                padding: 0 10px; /* Prevent text hitting edges changes */
            }

            .hero-btn {
                padding: 15px 30px;
                width: 100%;
                display: inline-block;
                text-align: center;
                box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
            }

            section {
                padding: 60px 0;
            }

            .section-title {
                margin-bottom: 30px;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }
            
            /* Card Refinements */
            .pricing-card {
                padding: 30px 20px;
                margin-bottom: 25px;
                border: 1px solid rgba(0,0,0,0.04);
                box-shadow: 0 4px 15px rgba(0,0,0,0.03); /* Subtle shadow */
            }
            
            /* Add spacing between stacked columns */
            .col-md-6.col-lg-3 {
                padding-bottom: 10px;
            }

            .pricing-price {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 400px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            #home {
                min-height: 80vh;
                padding: 70px 0 30px;
            }

            .hero-content h1 {
                font-size: 1.4rem;
            }

            .hero-content p {
                font-size: 0.85rem;
            }

            .hero-btn {
                padding: 10px 20px;
                font-size: 0.85rem;
                max-width: 250px;
            }

            .section-title h2 {
                font-size: 1.4rem;
            }

            .service-card,
            .pricing-card {
                padding: 18px 12px;
            }

            .service-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .service-title {
                font-size: 1rem;
            }

            .pricing-price {
                font-size: 1.4rem;
            }

            .pricing-btn {
                padding: 8px 12px;
                font-size: 0.85rem;
            }
        }

        /* Navbar Toggler Custom Style */
        .navbar-toggler {
            border-color: var(--primary);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(67, 97, 238, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#home" data-aos="fade-right">Yusril<span>Net</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Service</a></li>
                    <li class="nav-item"><a class="nav-link" href="#voucher">Voucher</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="hero-content">
                        <h1 data-aos="fade-up">Internet Cepat & Stabil Untuk Semua Kebutuhan Anda</h1>
                        <p data-aos="fade-up" data-aos-delay="100">Nikmati pengalaman internet tanpa batas dengan
                            voucher wifi Yusril Net. Kecepatan tinggi, koneksi stabil, dan harga terjangkau.</p>
                        <a href="#voucher" class="hero-btn" data-aos="fade-up" data-aos-delay="200">
                            <i class="fas fa-shopping-cart me-2"></i>Beli Voucher Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Voucher Section -->
    <section id="voucher">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Paket Voucher</h2>
            </div>
            <div class="row">
                @foreach ($pakets as $paket)
                    {{-- Variabel didefinisikan di awal agar bisa digunakan di seluruh card DAN modal --}}
                    @php
                        $jumlahVoucher = $paket->vouchers_available_count ?? 0;
                        $bisaBeli = $paket->available == 1 && $jumlahVoucher > 0;
                    @endphp

                    <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up"
                        data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="pricing-card {{ $loop->iteration == 2 ? 'popular' : '' }}">
                            @if ($loop->iteration == 2)
                                <div class="popular-badge">Terlaris</div>
                            @endif

                            <div class="text-center mb-4">
                                <h3 class="service-title">{{ $paket->nama }}</h3>
                                <div class="pricing-price">Rp {{ number_format($paket->price, 0, ',', '.') }}</div>
                                <div class="text-muted">{{ $paket->deskripsi }}</div>

                                @if ($paket->available == 0)
                                    <span class="badge rounded-pill mt-3 bg-danger-subtle text-danger">
                                        Tidak Tersedia
                                    </span>
                                @elseif ($jumlahVoucher > 0)
                                    <span class="badge rounded-pill mt-3 bg-success-subtle text-success">
                                        {{ $jumlahVoucher }} Voucher Tersedia
                                    </span>
                                @else
                                    <span class="badge rounded-pill mt-3 bg-warning-subtle text-warning">
                                        Stok Habis
                                    </span>
                                @endif
                            </div>

                            <ul class="list-unstyled mb-4">
                                @php $details = $paket->detail_paket ? json_decode($paket->detail_paket) : []; @endphp
                                @if (is_array($details) && count($details) > 0)
                                    @foreach (array_slice($details, 0, 3) as $detail)
                                        <li class="mb-2 d-flex align-items-center"><i
                                                class="fas fa-check-circle text-primary me-2"></i> {{ $detail }}
                                        </li>
                                    @endforeach
                                @else
                                    <li class="text-muted">Detail tidak tersedia</li>
                                @endif
                            </ul>

                            <div class="d-grid gap-2">
                                <button type="button" class="pricing-btn secondary" data-bs-toggle="modal"
                                    data-bs-target="#deskripsiModal{{ $paket->id }}">
                                    Detail
                                </button>

                                @if ($bisaBeli)
                                    <a href="{{ route('public.beli', $paket->id) }}" class="pricing-btn">
                                        Beli Sekarang
                                    </a>
                                @else
                                    <button class="pricing-btn" disabled style="opacity: 0.5; cursor: not-allowed;">
                                        {{ $paket->available == 0 ? 'Tidak Tersedia' : 'Habis' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal (Keep existing structure but clean up classes) -->
                    <div class="modal fade" id="deskripsiModal{{ $paket->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg"
                                style="border-radius: 20px; overflow: hidden;">
                                <div class="modal-header border-0 p-4"
                                    style="background: var(--gradient); color: white;">
                                    <h5 class="modal-title fw-bold"><i
                                            class="fas fa-wifi me-2"></i>{{ $paket->nama }}</h5>
                                    <button type="button" class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    {{-- ... (isi modal body tidak berubah) ... --}}
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="p-3 bg-light rounded-4 h-100">
                                                <h6 class="fw-bold text-primary mb-3">Deskripsi</h6>
                                                <p class="text-muted mb-0">{{ $paket->deskripsi }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <div class="p-3 bg-light rounded-4 text-center">
                                                        <small class="text-muted d-block mb-1">Harga</small>
                                                        <h5 class="fw-bold text-primary mb-0">Rp
                                                            {{ number_format($paket->price, 0, ',', '.') }}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="p-3 bg-light rounded-4 text-center">
                                                        <small class="text-muted d-block mb-1">Durasi</small>
                                                        <h5 class="fw-bold text-primary mb-0">{{ $paket->duration }}
                                                            Hari
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h6 class="fw-bold text-primary mb-3">Fitur Lengkap</h6>
                                        <div class="row">
                                            @if (is_array($details) && count($details) > 0)
                                                @foreach ($details as $detail)
                                                    <div class="col-md-6 mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-check-circle text-success me-2"></i>
                                                            <span>{{ $detail }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4 bg-light">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Tutup</button>

                                    {{-- --- INILAH PERBAIKANNYA --- --}}
                                    {{-- Menggunakan variabel $bisaBeli yang sudah ada --}}
                                    @if ($bisaBeli)
                                        <a href="{{ route('public.beli', $paket->id) }}"
                                            class="btn btn-primary rounded-pill px-4">Beli Sekarang</a>
                                    @else
                                        <button class="btn btn-primary rounded-pill px-4" disabled
                                            style="opacity: 0.5; cursor: not-allowed;">
                                            {{ $paket->available == 0 ? 'Tidak Tersedia' : 'Habis' }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <div class="section-title text-start mb-4">
                        <h2 style="margin-left: 0;">Tentang Kami</h2>
                    </div>
                    <p class="lead mb-4">YusrilNet Sriwijaya adalah penyedia layanan internet lokal yang berkomitmen
                        memberikan akses internet cepat, stabil, dan terjangkau.</p>
                    <p class="text-muted mb-4">Berdiri sejak 2021, kami telah melayani ratusan pelanggan di Bandung
                        dengan dukungan teknisi profesional dan infrastruktur handal.</p>

                    <div class="row g-4 mt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 btn-lg-square bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-wifi fs-4"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0 fw-bold">10+</h5>
                                    <small class="text-muted">Titik Hotspot</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 btn-lg-square bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-users fs-4"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0 fw-bold">100+</h5>
                                    <small class="text-muted">Pengguna Aktif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <img src="{{ asset('logo.png') }}" alt="About YusrilNet" class="img-fluid about-img"
                        style="max-height: 400px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Layanan Kami</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-bolt"></i></div>
                        <h3 class="service-title text-center">Kecepatan Tinggi</h3>
                        <p class="text-center text-muted">Akses internet hingga 5 Mbps tanpa buffering untuk streaming
                            dan browsing lancar.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-shield-alt"></i></div>
                        <h3 class="service-title text-center">Aman & Privat</h3>
                        <p class="text-center text-muted">Sistem keamanan terkini untuk melindungi data dan privasi
                            Anda
                            saat berselancar.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-headset"></i></div>
                        <h3 class="service-title text-center">Support 24/7</h3>
                        <p class="text-center text-muted">Tim teknis kami siap membantu Anda kapanpun jika terjadi
                            kendala koneksi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <h3 class="footer-title">Yusril Net</h3>
                    <p class="text-white-50">Solusi internet hemat dan cepat untuk masyarakat. Terhubung lebih mudah
                        dengan dunia digital.</p>
                    <div class="social-links mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h3 class="footer-title">Navigasi</h3>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><a href="#home" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#voucher" class="text-white text-decoration-none">Voucher</a>
                        </li>
                        <li class="mb-2"><a href="#about" class="text-white text-decoration-none">About</a></li>
                        <li class="mb-2"><a href="#services" class="text-white text-decoration-none">Services</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6">
                    <h3 class="footer-title">Layanan</h3>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2">WiFi Harian</li>
                        <li class="mb-2">WiFi Mingguan</li>
                        <li class="mb-2">WiFi Bulanan</li>
                        <li class="mb-2">Pemasangan Baru</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h3 class="footer-title">Kontak</h3>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-3 d-flex"><i class="fas fa-map-marker-alt mt-1 me-3"></i> Jl. Sriwijaya Gg. IX
                            No.31, Bandung</li>
                        <li class="mb-3 d-flex"><i class="fas fa-phone mt-1 me-3"></i> +62 812-3456-7890</li>
                        <li class="mb-3 d-flex"><i class="fas fa-envelope mt-1 me-3"></i> info@yusrilnet.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary mt-5 pt-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-white-50">
                    <p class="mb-2 mb-md-0">&copy; 2025 Yusril Net. All rights reserved.</p>
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item ms-3"><a href="#"
                                class="text-white-50 text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#termsModal">Syarat & Ketentuan</a></li>
                        <li class="list-inline-item ms-3"><a href="#"
                                class="text-white-50 text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#refundModal">Kebijakan Refund</a></li>
                        <li class="list-inline-item ms-3"><a href="#"
                                class="text-white-50 text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#faqModal">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modals -->
    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0" style="background: var(--gradient); color: white;">
                    <h5 class="modal-title fw-bold" id="termsModalLabel">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" height="30" class="me-2">
                        SYARAT & KETENTUAN
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Dengan melakukan pembelian dan/atau mengakses website voucheryusril.biz.id, Anda menyetujui
                        poin-poin berikut:</p>
                    <ol>
                        <li class="mb-2"><strong>Status Produk:</strong> Produk yang kami jual adalah voucher
                            internet Wi-Fi Yusril.net yang bersifat digital dan selalu ready stock, dengan detail paket
                            tersedia di katalog website.</li>
                        <li class="mb-2"><strong>Kesesuaian Layanan:</strong> Voucher ini hanya dapat digunakan di
                            area yang terjangkau oleh jaringan Wi-Fi Yusril.net. Pengguna wajib memastikan lokasi berada
                            dalam jangkauan.</li>
                        <li class="mb-2"><strong>Tanggung Jawab Pengguna:</strong> Pembeli bertanggung jawab penuh
                            atas kerahasiaan kode voucher yang diterima. Penggunaan kode yang berlebihan atau
                            penyalahgunaan (seperti sharing tanpa izin) dapat mengakibatkan pemblokiran kode tanpa
                            pengembalian dana.</li>
                        <li class="mb-2"><strong>Hak Perubahan:</strong> Kami berhak mengubah Syarat & Ketentuan ini
                            kapan saja tanpa pemberitahuan sebelumnya. Penggunaan layanan yang berlanjut dianggap
                            sebagai persetujuan atas perubahan tersebut.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Refund Modal -->
    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0" style="background: var(--gradient); color: white;">
                    <h5 class="modal-title fw-bold" id="refundModalLabel">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" height="30" class="me-2">
                        KEBIJAKAN REFUND
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Mengingat voucher adalah produk digital, berikut adalah ketentuan pengembalian dana (refund):</p>
                    <ol>
                        <li class="mb-2"><strong>Sifat Transaksi:</strong> Semua pembelian voucher adalah final
                            setelah kode berhasil terkirim. Pembatalan atau pengembalian dana tidak berlaku jika kode
                            sudah terkirim dan valid/dapat digunakan.</li>
                        <li class="mb-2"><strong>Kondisi Refund:</strong> Refund hanya dapat diproses jika terjadi
                            kegagalan sistem yang menyebabkan salah satu dari kondisi ini:
                            <ul>
                                <li>Voucher tidak terkirim setelah pembayaran terkonfirmasi.</li>
                                <li>Voucher terkirim, namun kode terbukti invalid (tidak dapat digunakan) setelah
                                    diverifikasi oleh tim kami.</li>
                            </ul>
                        </li>
                        <li class="mb-2"><strong>Prosedur Pengajuan:</strong> Permintaan refund harus diajukan
                            maksimal 24 jam setelah pembelian kepada Layanan Pelanggan dengan melampirkan bukti
                            pembayaran.</li>
                        <li class="mb-2"><strong>Proses Pengembalian:</strong> Jika refund disetujui, dana akan
                            dikembalikan dalam waktu 3-5 hari kerja ke rekening/sumber pembayaran yang digunakan.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Modal -->
    <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0" style="background: var(--gradient); color: white;">
                    <h5 class="modal-title fw-bold" id="faqModalLabel">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" height="30" class="me-2">
                        PERTANYAAN UMUM (FAQ)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Berikut adalah ringkasan pertanyaan yang sering diajukan mengenai layanan kami:</p>
                    <ol>
                        <li class="mb-2"><strong>Apa yang dijual?</strong> Kami menjual paket internet berupa kode
                            voucher untuk mengakses layanan Wi-Fi Yusril.net.</li>
                        <li class="mb-2"><strong>Apakah produk selalu tersedia?</strong> Ya, produk voucher adalah
                            digital dan selalu ready stock. Ketersediaan paket dapat dilihat langsung di katalog
                            voucheryusril.biz.id.</li>
                        <li class="mb-2"><strong>Metode Pembayaran:</strong> Pembayaran dapat dilakukan melalui
                            berbagai saluran yang difasilitasi oleh payment gateway iPaymu, seperti Virtual Account bank
                            dan e-wallet.</li>
                        <li class="mb-2"><strong>Kapan voucher dikirim?</strong> Kode voucher akan dikirimkan secara
                            otomatis ke kontak terdaftar segera setelah pembayaran Anda dikonfirmasi oleh iPaymu.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('shadow-sm');
                document.querySelector('.navbar').style.background = 'rgba(255, 255, 255, 0.95)';
            } else {
                document.querySelector('.navbar').classList.remove('shadow-sm');
                document.querySelector('.navbar').style.background = 'rgba(255, 255, 255, 0.9)';
            }
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>

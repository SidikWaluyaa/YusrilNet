<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yusril Net - Penyedia Voucher WiFi Terpercaya</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icons & CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('Logo.png') }}" type="image/x-icon">

    <style>
        :root {
            --primary-blue: #1865f2;
            --primary-dark: #0f3cb3;
            --cyan-accent: #00d2ff;
            --dark-bg: #06101e;
            --light-bg: #f5f8ff;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            background-color: var(--light-bg);
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6, .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar */
        .navbar {
            padding: 14px 0;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.65rem;
            color: var(--primary-blue) !important;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .navbar-brand img {
            height: 32px;
            width: auto;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.95rem;
            color: #475569 !important;
            margin: 0 8px;
            padding: 8px 12px !important;
            transition: all 0.25s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-blue) !important;
        }

        .nav-link.active {
            color: var(--primary-blue) !important;
            font-weight: 700;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 3px;
            background: var(--primary-blue);
            border-radius: 4px;
        }

        .btn-nav-buy {
            background-color: var(--primary-blue);
            color: white !important;
            font-weight: 700;
            padding: 10px 24px;
            border-radius: 50px;
            box-shadow: 0 4px 14px rgba(24, 101, 242, 0.3);
            transition: all 0.3s ease;
        }

        .btn-nav-buy:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(24, 101, 242, 0.4);
        }

        /* Hero Section */
        #home {
            background: linear-gradient(rgba(6, 16, 30, 0.75), rgba(6, 16, 30, 0.75)), url('{{ asset("images/hero_wifi_city.png") }}');
            background-size: cover;
            background-position: center;
            min-height: 85vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: 120px 0 80px;
            color: white;
        }

        .hero-badge {
            font-size: 0.78rem;
            letter-spacing: 1.5px;
            color: var(--cyan-accent);
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .hero-title {
            font-size: clamp(2.2rem, 5.5vw, 3.8rem);
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .hero-title span {
            color: var(--cyan-accent);
        }

        .hero-desc {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.85);
            max-width: 580px;
            margin-bottom: 28px;
        }

        .hero-features {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 35px;
            font-size: 0.9rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        .hero-features div {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-cta {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--cyan-accent) 100%);
            color: white !important;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 14px 34px;
            border-radius: 50px;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 210, 255, 0.35);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-hero-cta:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 14px 30px rgba(0, 210, 255, 0.45);
        }

        /* Section Global Titles */
        .section-header {
            text-align: center;
            margin-bottom: 45px;
        }

        .section-header h2 {
            font-weight: 800;
            font-size: 2.1rem;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .section-header-line {
            width: 45px;
            height: 4px;
            background: var(--primary-blue);
            border-radius: 4px;
            margin: 0 auto;
        }

        /* Paket Voucher Section */
        #voucher {
            padding: 90px 0;
            background-color: white;
        }

        .voucher-card {
            background: white;
            border: 1.5px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            position: relative;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .voucher-card:hover {
            border-color: var(--primary-blue);
            transform: translateY(-6px);
            box-shadow: 0 14px 30px rgba(24, 101, 242, 0.1);
        }

        .voucher-card.popular {
            border-color: var(--primary-blue);
            box-shadow: 0 10px 25px rgba(24, 101, 242, 0.12);
        }

        .popular-ribbon {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--primary-blue);
            color: white;
            font-size: 0.72rem;
            font-weight: 800;
            padding: 6px 20px 6px 14px;
            border-radius: 0 18px 0 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 15% 100%);
        }

        .badge-type {
            display: inline-block;
            background: var(--primary-blue);
            color: white;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 8px;
            margin-bottom: 14px;
        }

        .voucher-duration {
            font-size: 0.95rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 4px;
        }

        .voucher-price {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary-blue);
            margin-bottom: 4px;
        }

        .voucher-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .badge-stock {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 18px;
        }

        .badge-stock.available {
            background-color: #ecfdf5;
            color: #059669;
        }

        .badge-stock.out {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .voucher-features {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
            font-size: 0.88rem;
            color: #475569;
        }

        .voucher-features li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .voucher-features i {
            color: var(--primary-blue);
        }

        .btn-outline-detail {
            border: 1.5px solid #cbd5e1;
            color: #475569;
            font-weight: 700;
            border-radius: 12px;
            padding: 10px;
            transition: all 0.2s ease;
        }

        .btn-outline-detail:hover {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            background-color: #f0f5ff;
        }

        .btn-buy-now {
            background-color: var(--primary-blue);
            color: white !important;
            font-weight: 700;
            border-radius: 12px;
            padding: 11px;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-buy-now:hover:not(:disabled) {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* Tentang Kami Section */
        #about {
            padding: 90px 0;
            background-color: var(--light-bg);
        }

        .about-sub {
            color: var(--primary-blue);
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .about-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 20px;
        }

        .stat-box {
            background: white;
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid #f1f5f9;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #eff6ff;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-val {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.1;
        }

        .stat-label {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .about-card-net {
            background: white;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f5f9;
            text-align: center;
        }

        /* Layanan Kami Section */
        #services {
            padding: 90px 0;
            background-color: white;
        }

        .service-box {
            background: white;
            border-radius: 20px;
            padding: 32px 24px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            text-align: center;
            height: 100%;
        }

        .service-box:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(24, 101, 242, 0.08);
            border-color: rgba(24, 101, 242, 0.2);
        }

        .service-icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #eff6ff;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 20px;
        }

        /* Footer */
        footer {
            background-color: var(--dark-bg);
            color: #94a3b8;
            padding: 70px 0 0;
            font-size: 0.9rem;
        }

        footer h5 {
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 22px;
        }

        footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        footer a:hover {
            color: white;
        }

        .social-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 24px 0;
            margin-top: 50px;
            font-size: 0.82rem;
        }

        /* Floating WhatsApp Button */
        .floating-wa-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 58px;
            height: 58px;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: white !important;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 8px 22px rgba(37, 211, 102, 0.45);
            z-index: 9999;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            animation: waPulse 2.2s infinite;
        }

        .floating-wa-btn:hover {
            transform: scale(1.12);
            box-shadow: 0 12px 28px rgba(37, 211, 102, 0.6);
        }

        .wa-tooltip {
            position: absolute;
            right: 70px;
            background: #1e293b;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            white-space: nowrap;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .floating-wa-btn:hover .wa-tooltip {
            opacity: 1;
            visibility: visible;
            right: 74px;
        }

        @keyframes waPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 16px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        /* Responsive Breakpoints */
        @media (max-width: 991.98px) {
            #home {
                text-align: center;
                padding-top: 130px;
            }
            .hero-desc, .hero-features {
                justify-content: center;
                margin-left: auto;
                margin-right: auto;
            }
            .about-card-net {
                margin-top: 30px;
            }
        }

        @media (max-width: 576px) {
            #home {
                padding-top: 100px;
                padding-bottom: 45px;
            }
            .hero-title {
                font-size: 1.75rem !important;
                line-height: 1.25 !important;
            }
            .hero-desc {
                font-size: 0.9rem !important;
            }
            .voucher-card {
                padding: 18px 16px !important;
            }
            .voucher-price {
                font-size: 1.85rem !important;
            }
            .floating-wa-btn {
                bottom: 18px;
                right: 18px;
                width: 52px;
                height: 52px;
                font-size: 26px;
            }
            .wa-tooltip {
                font-size: 0.75rem;
                padding: 4px 10px;
                right: 60px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <i class="fas fa-wifi text-primary me-1"></i>Yusril<span style="color: var(--primary-blue);">Net</span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fas fa-bars text-primary fs-3"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Service</a></li>
                    <li class="nav-item"><a class="nav-link" href="#voucher">Voucher</a></li>
                </ul>
                <div class="d-flex align-items-center justify-content-center mt-3 mt-lg-0">
                    <a href="#voucher" class="btn btn-nav-buy">Beli Voucher</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="hero-badge">INTERNET CEPAT & STABIL</div>
                    <h1 class="hero-title">Internet Cepat & Stabil<br>Untuk <span>Semua Kebutuhan</span> Anda</h1>
                    <p class="hero-desc">Nikmati pengalaman internet tanpa batas dengan voucher wifi Yusril Net. Kecepatan tinggi, koneksi stabil, dan harga terjangkau.</p>

                    <div class="hero-features">
                        <div><i class="fas fa-rocket text-info"></i> Cepat & Stabil</div>
                        <div><i class="fas fa-bolt text-warning"></i> Harga Terjangkau</div>
                        <div><i class="fas fa-check-circle text-success"></i> Mudah Digunakan</div>
                    </div>

                    <a href="#voucher" class="btn btn-hero-cta">
                        <i class="fas fa-shopping-cart"></i> Beli Voucher Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Paket Voucher Section -->
    <section id="voucher">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Paket Voucher</h2>
                <div class="section-header-line"></div>
            </div>

            <div class="row g-4 align-items-center">
                <!-- Grid Voucher Cards (Left Side) -->
                <div class="col-lg-7">
                    <div class="row g-3">
                        @foreach ($pakets as $paket)
                            @php
                                $jumlahVoucher = $paket->vouchers_available_count ?? 0;
                                $bisaBeli = $paket->available == 1 && $jumlahVoucher > 0;
                                $isPopular = $loop->iteration == 2;
                            @endphp

                            <div class="col-sm-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                                <div class="voucher-card {{ $isPopular ? 'popular' : '' }}">
                                    @if($isPopular)
                                        <div class="popular-ribbon">Popular</div>
                                    @endif

                                    <div>
                                        <span class="badge-type">{{ $loop->iteration == 1 ? 'Basic' : 'Premium' }}</span>
                                        <div class="voucher-duration">{{ $paket->nama }}</div>
                                        <div class="voucher-price">Rp {{ number_format($paket->price, 0, ',', '.') }}</div>
                                        <div class="voucher-desc">{{ $paket->deskripsi }}</div>

                                        @if ($paket->available == 0)
                                            <span class="badge-stock out">Tidak Tersedia</span>
                                        @elseif ($jumlahVoucher > 0)
                                            <span class="badge-stock available"><i class="fas fa-check me-1"></i>Voucher Ready</span>
                                        @else
                                            <span class="badge-stock out">Stok Habis</span>
                                        @endif

                                        <ul class="voucher-features">
                                            @php $details = $paket->detail_paket ? json_decode($paket->detail_paket) : []; @endphp
                                            @if (is_array($details) && count($details) > 0)
                                                @foreach (array_slice($details, 0, 2) as $detail)
                                                    <li><i class="fas fa-check-circle"></i> <span>{{ $detail }}</span></li>
                                                @endforeach
                                            @else
                                                <li><i class="fas fa-check-circle"></i> <span>Unlimited High Speed</span></li>
                                            @endif
                                        </ul>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="button" class="btn btn-outline-detail" data-bs-toggle="modal" data-bs-target="#deskripsiModal{{ $paket->id }}">
                                            Detail
                                        </button>

                                        @if ($bisaBeli)
                                            <a href="{{ route('public.beli', $paket->id) }}" class="btn btn-buy-now text-center text-decoration-none">
                                                Beli Sekarang
                                            </a>
                                        @else
                                            <button class="btn btn-buy-now" disabled style="opacity: 0.5; cursor: not-allowed;">
                                                {{ $paket->available == 0 ? 'Tidak Tersedia' : 'Habis' }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Modal -->
                            <div class="modal fade" id="deskripsiModal{{ $paket->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                                        <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, var(--primary-blue), var(--cyan-accent)); color: white;">
                                            <h5 class="modal-title fw-bold"><i class="fas fa-wifi me-2"></i>{{ $paket->nama }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <div class="p-3 bg-light rounded-4 h-100">
                                                        <h6 class="fw-bold text-primary mb-3">Deskripsi Paket</h6>
                                                        <p class="text-muted mb-0">{{ $paket->deskripsi }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row g-3">
                                                        <div class="col-6">
                                                            <div class="p-3 bg-light rounded-4 text-center">
                                                                <small class="text-muted d-block mb-1">Harga</small>
                                                                <h5 class="fw-bold text-primary mb-0">Rp {{ number_format($paket->price, 0, ',', '.') }}</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="p-3 bg-light rounded-4 text-center">
                                                                <small class="text-muted d-block mb-1">Masa Aktif</small>
                                                                <h5 class="fw-bold text-primary mb-0">{{ $paket->duration }} Hari</h5>
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
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                            @if ($bisaBeli)
                                                <a href="{{ route('public.beli', $paket->id) }}" class="btn btn-primary rounded-pill px-4">Beli Sekarang</a>
                                            @else
                                                <button class="btn btn-primary rounded-pill px-4" disabled style="opacity: 0.5; cursor: not-allowed;">
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

                <!-- 3D Illustration Graphic (Right Side) -->
                <div class="col-lg-5 text-center" data-aos="fade-left">
                    <img src="{{ asset('images/avatar_wifi_3d.png') }}" alt="YusrilNet WiFi Illustration" class="img-fluid" style="max-height: 440px; filter: drop-shadow(0 15px 30px rgba(0,0,0,0.06));">
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-sub">TENTANG KAMI</div>
                    <h2 class="about-title">YusrilNet Sriwijaya</h2>
                    <p class="text-secondary mb-3">YusrilNet Sriwijaya adalah penyedia layanan internet lokal yang berkomitmen memberikan akses internet cepat, stabil, dan terjangkau.</p>
                    <p class="text-secondary mb-4">Berdiri sejak 2021, kami telah melayani ribuan pelanggan di Bandung dengan dukungan teknisi profesional dan infrastruktur handal.</p>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="stat-box">
                                <div class="stat-icon"><i class="fas fa-wifi"></i></div>
                                <div>
                                    <div class="stat-val">10+</div>
                                    <div class="stat-label">Titik Hotspot</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="stat-box">
                                <div class="stat-icon"><i class="fas fa-users"></i></div>
                                <div>
                                    <div class="stat-val">100+</div>
                                    <div class="stat-label">Pengguna Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <div class="about-card-net mx-auto" style="max-width: 420px;">
                        <img src="{{ asset('NET.png') }}" alt="YusrilNet Logo Emblem" class="img-fluid" style="max-height: 280px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Kami Section -->
    <section id="services">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Layanan Kami</h2>
                <div class="section-header-line"></div>
            </div>

            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-box">
                        <div class="service-icon-circle"><i class="fas fa-bolt"></i></div>
                        <h4 class="fw-bold fs-5 mb-2">Kecepatan Tinggi</h4>
                        <p class="text-muted small mb-0">Akses internet hingga 5 Mbps tanpa buffering untuk streaming dan browsing lancar.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-box">
                        <div class="service-icon-circle"><i class="fas fa-shield-alt"></i></div>
                        <h4 class="fw-bold fs-5 mb-2">Aman & Privat</h4>
                        <p class="text-muted small mb-0">Sistem keamanan terkini untuk melindungi data dan privasi Anda saat berselancar.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-box">
                        <div class="service-icon-circle"><i class="fas fa-headset"></i></div>
                        <h4 class="fw-bold fs-5 mb-2">Support 24/7</h4>
                        <p class="text-muted small mb-0">Tim teknis kami siap membantu Anda kapanpun jika terjadi kendala koneksi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold text-white mb-3">YusrilNet</h5>
                    <p class="small text-secondary mb-4">Solusi internet hemat dan cepat untuk masyarakat. Terhubung lebih mudah dengan dunia digital.</p>
                    <div>
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                        <a href="https://wa.me/62895343565099" target="_blank" class="social-btn"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <h5>Navigasi</h5>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><a href="#home">Home</a></li>
                        <li class="mb-2"><a href="#voucher">Voucher</a></li>
                        <li class="mb-2"><a href="#about">About</a></li>
                        <li class="mb-2"><a href="#services">Services</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-6">
                    <h5>Layanan</h5>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">WiFi Harian</li>
                        <li class="mb-2">WiFi Mingguan</li>
                        <li class="mb-2">WiFi Bulanan</li>
                        <li class="mb-2">Pemasangan Baru</li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2 d-flex"><i class="fas fa-map-marker-alt text-primary mt-1 me-2"></i> <span>Jl. Sriwijaya Gg. IX No.31, Bandung</span></li>
                        <li class="mb-2 d-flex"><i class="fas fa-phone text-primary mt-1 me-2"></i> <a href="https://wa.me/62895343565099" target="_blank" class="text-secondary text-decoration-none">0895343565099</a></li>
                        <li class="mb-2 d-flex"><i class="fas fa-envelope text-primary mt-1 me-2"></i> <a href="mailto:voucheryusrilnet@gmail.com" class="text-secondary text-decoration-none">voucheryusrilnet@gmail.com</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <div>&copy; 2025 Yusril Net. All rights reserved.</div>
                    <div class="d-flex gap-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat & Ketentuan</a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#refundModal">Kebijakan Refund</a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#faqModal">FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/62895343565099?text=Halo%20Admin%20YusrilNet,%20saya%20butuh%20bantuan%20terkait%20voucher%20WiFi" 
       target="_blank" 
       class="floating-wa-btn" 
       title="Chat CS Kami">
        <span class="wa-tooltip">Chat CS Kami</span>
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Modals -->
    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, var(--primary-blue), var(--cyan-accent)); color: white;">
                    <h5 class="modal-title fw-bold" id="termsModalLabel">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" height="28" class="me-2">
                        SYARAT & KETENTUAN
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p>Dengan melakukan pembelian dan/atau mengakses website YusrilNet, Anda menyetujui poin-poin berikut:</p>
                    <ol>
                        <li class="mb-2"><strong>Status Produk:</strong> Produk yang kami jual adalah voucher internet Wi-Fi Yusril.net yang bersifat digital dan selalu ready stock, dengan detail paket tersedia di katalog website.</li>
                        <li class="mb-2"><strong>Kesesuaian Layanan:</strong> Voucher ini hanya dapat digunakan di area yang terjangkau oleh jaringan Wi-Fi Yusril.net. Pengguna wajib memastikan lokasi berada dalam jangkauan.</li>
                        <li class="mb-2"><strong>Tanggung Jawab Pengguna:</strong> Pembeli bertanggung jawab penuh atas kerahasiaan kode voucher yang diterima. Penggunaan kode yang berlebihan atau penyalahgunaan dapat mengakibatkan pemblokiran kode tanpa pengembalian dana.</li>
                        <li class="mb-2"><strong>Hak Perubahan:</strong> Kami berhak mengubah Syarat & Ketentuan ini kapan saja tanpa pemberitahuan sebelumnya. Penggunaan layanan yang berlanjut dianggap sebagai persetujuan atas perubahan tersebut.</li>
                    </ol>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Refund Modal -->
    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, var(--primary-blue), var(--cyan-accent)); color: white;">
                    <h5 class="modal-title fw-bold" id="refundModalLabel">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" height="28" class="me-2">
                        KEBIJAKAN REFUND
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p>Mengingat voucher adalah produk digital, berikut adalah ketentuan pengembalian dana (refund):</p>
                    <ol>
                        <li class="mb-2"><strong>Sifat Transaksi:</strong> Semua pembelian voucher adalah final setelah kode berhasil terkirim. Pembatalan atau pengembalian dana tidak berlaku jika kode sudah terkirim dan valid.</li>
                        <li class="mb-2"><strong>Kondisi Refund:</strong> Refund hanya dapat diproses jika terjadi kegagalan sistem yang menyebabkan voucher tidak terkirim atau kode invalid.</li>
                        <li class="mb-2"><strong>Prosedur Pengajuan:</strong> Permintaan refund harus diajukan maksimal 24 jam setelah pembelian kepada Layanan Pelanggan dengan melampirkan bukti pembayaran.</li>
                    </ol>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Modal -->
    <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, var(--primary-blue), var(--cyan-accent)); color: white;">
                    <h5 class="modal-title fw-bold" id="faqModalLabel">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" height="28" class="me-2">
                        PERTANYAAN UMUM (FAQ)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p>Berikut adalah ringkasan pertanyaan yang sering diajukan mengenai layanan kami:</p>
                    <ol>
                        <li class="mb-2"><strong>Apa yang dijual?</strong> Kami menjual paket internet berupa kode voucher untuk mengakses layanan Wi-Fi Yusril.net.</li>
                        <li class="mb-2"><strong>Apakah produk selalu tersedia?</strong> Ya, produk voucher adalah digital dan selalu ready stock.</li>
                        <li class="mb-2"><strong>Metode Pembayaran:</strong> Pembayaran dapat dilakukan melalui berbagai saluran yang difasilitasi oleh payment gateway iPaymu.</li>
                        <li class="mb-2"><strong>Kapan voucher dikirim?</strong> Kode voucher akan dikirimkan secara otomatis ke email terdaftar segera setelah pembayaran Anda dikonfirmasi.</li>
                    </ol>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
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

        // Navbar active link highlight on scroll
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', () => {
            const scrollY = window.pageYOffset;
            sections.forEach(current => {
                const sectionHeight = current.offsetHeight;
                const sectionTop = current.offsetTop - 100;
                const sectionId = current.getAttribute('id');
                const link = document.querySelector('.navbar-nav a[href*=' + sectionId + ']');
                if (link) {
                    if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                        document.querySelectorAll('.navbar-nav a').forEach(a => a.classList.remove('active'));
                        link.classList.add('active');
                    }
                }
            });
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>

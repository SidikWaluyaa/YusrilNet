<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YusrilNet') }} - Beli Voucher WiFi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --success: #06d6a0;
            --dark: #1e293b;
            --light: #f8f9fa;
            --gradient: linear-gradient(135deg, #4361ee 0%, #4cc9f0 100%);
            --gradient-hover: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 30px -5px rgba(67, 97, 238, 0.15);
            --shadow-lg: 0 20px 40px -5px rgba(67, 97, 238, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--dark);
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand i {
            color: var(--accent);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 120px 0 80px;
            margin-top: 20px;
        }

        /* Custom Card */
        .custom-card {
            background: white;
            border: none;
            border-radius: 25px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(67, 97, 238, 0.25);
        }

        .custom-card-header {
            background: var(--gradient);
            color: white;
            padding: 25px 30px;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
        }

        .custom-card-header i {
            font-size: 1.3rem;
        }

        /* Form Styles */
        .form-floating>label {
            color: #6c757d;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.1);
        }

        .form-floating>.form-control {
            height: calc(3.5rem + 2px);
        }

        /* Buttons */
        .btn-brand {
            background: var(--gradient);
            border: none;
            color: white;
            padding: 15px 35px;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
        }

        .btn-brand:hover {
            background: var(--gradient-hover);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(67, 97, 238, 0.4);
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* List Group */
        .list-group-item {
            border: none;
            border-bottom: 1px solid #f0f0f0;
            padding: 15px 0;
            font-size: 1.05rem;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Voucher Box */
        .voucher-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 3px dashed var(--primary);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
        }

        .voucher-code {
            background: white;
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 15px;
            box-shadow: var(--shadow-sm);
        }

        .copy-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .copy-btn:hover {
            transform: scale(1.1);
        }

        /* Success Icon */
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #06d6a0 0%, #1cc88a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(6, 214, 160, 0.3);
        }

        .success-icon i {
            font-size: 3rem;
            color: white;
        }

        /* Alert */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: rgba(255, 255, 255, 0.7);
            padding: 30px 0;
            text-align: center;
            margin-top: auto;
        }

        footer a {
            color: var(--accent);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        footer a:hover {
            color: white;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }

            .main-content {
                padding: 100px 0 60px;
                margin-top: 10px;
            }

            .custom-card-header {
                font-size: 1.3rem;
                padding: 20px;
            }

            .btn-brand {
                padding: 12px 25px;
                font-size: 1rem;
            }

            .voucher-box {
                padding: 20px;
            }

            .success-icon {
                width: 80px;
                height: 80px;
            }

            .success-icon i {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.3rem;
            }

            .main-content {
                padding: 90px 15px 50px; /* Reduced side padding slightly, kept vertical */
                margin-top: 5px;
            }

            .custom-card {
                border-radius: 20px;
            }

            .custom-card-header {
                font-size: 1.1rem;
                padding: 15px;
            }

            .card-body {
                padding: 20px !important;
            }

            .btn-brand {
                padding: 12px 20px;
                font-size: 0.95rem;
            }

            .list-group-item {
                font-size: 0.95rem;
                padding: 12px 0;
            }

            .voucher-box {
                padding: 15px;
            }

            .voucher-code {
                padding: 12px 15px;
            }

            .copy-btn {
                width: 35px;
                height: 35px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}" data-aos="fade-right">
                <i class="fas fa-wifi"></i> YusrilNet
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} <strong>YusrilNet</strong>. All Rights Reserved.</p>
            <p class="mb-0 mt-2">
                <a href="{{ route('welcome') }}">Kembali ke Beranda</a>
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>
</body>

</html>

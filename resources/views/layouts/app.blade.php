<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YusrilNet - Admin Panel</title>
    
    <!-- Script pencegah FOUC untuk restore UI Scale -->
    <script>
        (function() {
            const savedScale = localStorage.getItem('yusrilnet_ui_scale') || 'normal';
            document.documentElement.classList.add('scale-' + savedScale);
        })();
    </script>

    <!-- PWA Primary Meta Tags -->
    <meta name="theme-color" content="#4361ee">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="YusrilNet">
    <link rel="apple-touch-icon" href="{{ asset('Logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="shortcut icon" href="{{ asset('Logo.png') }}" type="image/x-icon">

    <!-- Google Fonts & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --neptune-blue: #4361ee;
            --neptune-dark: #3a0ca3;
            --neptune-light: #4cc9f0;
            --success: #06d6a0;
            --warning: #ffd60a;
            --danger: #ef476f;
            --sidebar-width: 250px;
            --topbar-height: 60px;
            --bottom-nav-height: 60px;
        }

        /* Scale Presets (Pengatur Ukuran Tampilan) */
        html.scale-compact { font-size: 81.25% !important; } /* ~13px */
        html.scale-normal  { font-size: 87.5% !important; }  /* ~14px - Default Mobile */
        html.scale-large   { font-size: 93.75% !important; } /* ~15px */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f8f9fa;
            color: #2b2d42;
            overflow-x: hidden;
        }

        /* Glassmorphism Topbar */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.25rem;
            z-index: 999;
            transition: left 0.3s ease;
        }

        .topbar-brand {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--neptune-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--neptune-blue), var(--neptune-dark));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.88rem;
            box-shadow: 0 2px 8px rgba(67, 97, 238, 0.25);
        }

        /* Desktop Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--neptune-dark) 0%, var(--neptune-blue) 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
        }

        .sidebar-brand {
            padding: 1.1rem 1.25rem;
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-menu {
            padding: 0.75rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--neptune-light);
        }

        .menu-item.active {
            background: rgba(255,255,255,0.18);
            color: white;
            border-left-color: var(--neptune-light);
            font-weight: 700;
        }

        .menu-item i {
            width: 20px;
            font-size: 1.05rem;
            margin-right: 0.75rem;
        }

        /* Main Content Container */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 1.5rem;
            min-height: calc(100vh - var(--topbar-height));
            transition: margin-left 0.3s ease;
        }

        /* Mobile Bottom Navigation Bar (< 768px) */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: var(--bottom-nav-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            z-index: 1050;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.06);
        }

        .mobile-nav-items {
            display: flex;
            height: 100%;
            width: 100%;
            align-items: center;
            justify-content: space-around;
        }

        .mobile-nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #718096;
            text-decoration: none;
            font-size: 0.65rem;
            font-weight: 500;
            width: 20%;
            height: 100%;
            transition: all 0.2s ease;
            position: relative;
        }

        .mobile-nav-link i {
            font-size: 1.15rem;
            margin-bottom: 2px;
            transition: transform 0.2s ease;
        }

        .mobile-nav-link.active {
            color: var(--neptune-blue);
            font-weight: 700;
        }

        .mobile-nav-link.active i {
            transform: translateY(-2px);
        }

        .mobile-nav-link.active::before {
            content: '';
            position: absolute;
            top: 0;
            width: 28px;
            height: 3px;
            background: var(--neptune-blue);
            border-radius: 0 0 4px 4px;
        }

        /* Mobile Responsive Adjustments (High Density Compact) */
        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
                padding: 0 0.85rem;
            }

            .main-content {
                margin-left: 0;
                padding: 0.85rem 0.65rem;
                padding-bottom: calc(var(--bottom-nav-height) + 1.25rem);
            }

            .mobile-bottom-nav {
                display: block;
            }

            .sidebar-toggle-btn {
                display: flex !important;
            }

            /* Compact card padding & spacing on mobile */
            .card-body {
                padding: 0.85rem !important;
            }
            .card-header {
                padding: 0.75rem 0.85rem !important;
            }
            .container-fluid {
                padding-left: 0.25rem !important;
                padding-right: 0.25rem !important;
            }
            .row {
                --bs-gutter-x: 0.5rem;
                --bs-gutter-y: 0.5rem;
            }
            .h1, h1 { font-size: 1.35rem !important; }
            .h2, h2 { font-size: 1.2rem !important; }
            .h3, h3 { font-size: 1.1rem !important; }
            .h4, h4 { font-size: 1.0rem !important; }
            .h5, h5 { font-size: 0.92rem !important; }
            .h6, h6 { font-size: 0.85rem !important; }
            p { margin-bottom: 0.5rem; }
        }

        /* Micro Animations */
        .btn, .card, .menu-item, .mobile-nav-link {
            transition: all 0.2s ease;
        }
        
        .btn:active {
            transform: scale(0.96);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
            border-radius: 12px;
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.5rem 0.85rem;
        }

        .ui-scale-btn-group .btn {
            font-size: 0.72rem;
            padding: 0.25rem 0.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- Sidebar (Desktop & Slide-out Mobile) -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-wifi text-light me-1"></i>
            <span>YusrilNet</span>
        </div>
        <nav class="sidebar-menu">
            @php $user = auth()->user(); @endphp
            @if($user && $user->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('admin.pakets.index') }}" class="menu-item {{ request()->routeIs('admin.pakets.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i><span>Paket WiFi</span>
                </a>
                <a href="{{ route('admin.vouchers.index') }}" class="menu-item {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i><span>Voucher</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i><span>Daftar Order</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i><span>Manajemen User</span>
                </a>
            @endif
        </nav>
    </aside>

    <!-- Topbar Header -->
    <header class="topbar">
        <div class="d-flex align-items-center">
            <button class="btn btn-light btn-sm me-2 d-none sidebar-toggle-btn border-0" id="sidebarToggle" style="width: 36px; height: 36px; border-radius: 10px;">
                <i class="fas fa-bars text-dark"></i>
            </button>
            <div class="topbar-brand">
                <img src="{{ asset('Logo.png') }}" alt="Logo" style="height: 26px; width: auto;" class="d-md-none">
                <span>Admin Panel</span>
            </div>
        </div>
        
        <div class="topbar-user">
            @auth
                <div class="dropdown">
                    <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-none d-md-inline-block me-2 fw-semibold text-dark">{{ auth()->user()->name }}</span>
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width: 220px;">
                        <li class="px-3 py-2 border-bottom d-md-none">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <div class="text-muted small">{{ auth()->user()->email }}</div>
                        </li>
                        
                        <!-- UI Scale / Font Size Selector -->
                        <li class="px-3 py-2 border-bottom bg-light rounded-2 mx-1 my-1">
                            <div class="text-muted extra-small fw-bold mb-1 text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                <i class="fas fa-text-height me-1 text-primary"></i>Ukuran Tampilan (Scale)
                            </div>
                            <div class="btn-group btn-group-sm w-100 ui-scale-btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-scale-set" data-scale="compact">Kecil</button>
                                <button type="button" class="btn btn-outline-primary btn-scale-set" data-scale="normal">Sedang</button>
                                <button type="button" class="btn btn-outline-primary btn-scale-set" data-scale="large">Besar</button>
                            </div>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-circle me-2 text-primary"></i>Pengaturan Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="main-content">
        {{ $slot }}
    </main>

    <!-- Mobile Bottom Navigation Bar (< 768px) -->
    <nav class="mobile-bottom-nav">
        <div class="mobile-nav-items">
            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.pakets.index') }}" class="mobile-nav-link {{ request()->routeIs('admin.pakets.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Paket</span>
            </a>
            <a href="{{ route('admin.vouchers.index') }}" class="mobile-nav-link {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i>
                <span>Voucher</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="mobile-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="mobile-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
        </div>
    </nav>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar toggle for mobile drawer
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.toggle('show');
            });
        }

        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && sidebar && sidebar.classList.contains('show')) {
                if (!sidebar.contains(e.target) && (!sidebarToggle || !sidebarToggle.contains(e.target))) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // UI Scale Switcher (Kecil, Sedang, Besar)
        function setUIScale(scaleName) {
            const html = document.documentElement;
            html.classList.remove('scale-compact', 'scale-normal', 'scale-large');
            html.classList.add('scale-' + scaleName);
            localStorage.setItem('yusrilnet_ui_scale', scaleName);
            updateScaleButtons(scaleName);
        }

        function updateScaleButtons(currentScale) {
            document.querySelectorAll('.btn-scale-set').forEach(btn => {
                const btnScale = btn.getAttribute('data-scale');
                if (btnScale === currentScale) {
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-primary', 'active');
                } else {
                    btn.classList.remove('btn-primary', 'active');
                    btn.classList.add('btn-outline-primary');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const currentScale = localStorage.getItem('yusrilnet_ui_scale') || 'normal';
            updateScaleButtons(currentScale);

            document.querySelectorAll('.btn-scale-set').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const scale = this.getAttribute('data-scale');
                    setUIScale(scale);
                });
            });
        });

        // PWA Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('PWA ServiceWorker registered with scope: ', registration.scope);
                    })
                    .catch(function(err) {
                        console.log('PWA ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>

    @stack('scripts')
</body>
</html>

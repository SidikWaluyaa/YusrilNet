<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YusrilNet - Admin Panel</title>
    
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
            --sidebar-width: 260px;
            --topbar-height: 65px;
            --bottom-nav-height: 64px;
        }

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
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 999;
            transition: left 0.3s ease;
        }

        .topbar-brand {
            font-family: 'Poppins', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--neptune-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--neptune-blue), var(--neptune-dark));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
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
            padding: 1.25rem 1.5rem;
            font-family: 'Poppins', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.95rem;
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
            width: 22px;
            font-size: 1.1rem;
            margin-right: 0.85rem;
        }

        /* Main Content Container */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 1.75rem;
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
            font-size: 0.68rem;
            font-weight: 500;
            width: 20%;
            height: 100%;
            transition: all 0.2s ease;
            position: relative;
        }

        .mobile-nav-link i {
            font-size: 1.25rem;
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
            width: 32px;
            height: 3px;
            background: var(--neptune-blue);
            border-radius: 0 0 4px 4px;
        }

        /* Mobile Responsive Adjustments */
        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
                padding: 0 1rem;
            }

            .main-content {
                margin-left: 0;
                padding: 1.25rem 0.85rem;
                padding-bottom: calc(var(--bottom-nav-height) + 1.5rem);
            }

            .mobile-bottom-nav {
                display: block;
            }

            .sidebar-toggle-btn {
                display: flex !important;
            }
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
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
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
            <button class="btn btn-light btn-sm me-2 d-none sidebar-toggle-btn border-0" id="sidebarToggle" style="width: 38px; height: 38px; border-radius: 10px;">
                <i class="fas fa-bars text-dark"></i>
            </button>
            <div class="topbar-brand">
                <img src="{{ asset('Logo.png') }}" alt="Logo" style="height: 28px; width: auto;" class="d-md-none">
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
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li class="px-3 py-2 border-bottom d-md-none">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <div class="text-muted small">{{ auth()->user()->email }}</div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-circle me-2 text-primary"></i>Pengaturan Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
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

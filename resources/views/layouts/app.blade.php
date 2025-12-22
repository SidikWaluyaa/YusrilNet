<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YusrilNet - Admin</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="shortcut icon" href="{{ asset('Logo.png') }}" type="image/x-icon">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --neptune-blue: #4361ee;
            --neptune-dark: #3a0ca3;
            --neptune-light: #4cc9f0;
            --success: #06d6a0;
            --warning: #ffd60a;
            --danger: #ef476f;
            --sidebar-width: 260px;
            --topbar-height: 70px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--neptune-dark) 0%, var(--neptune-blue) 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: block;
            padding: 0.875rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--neptune-light);
        }

        .menu-item.active {
            background: rgba(255,255,255,0.15);
            color: white;
            border-left-color: var(--neptune-light);
            font-weight: 600;
        }

        .menu-item i {
            width: 20px;
            margin-right: 0.75rem;
        }

        /* Topbar */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 999;
        }

        .topbar-brand {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--neptune-dark);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--neptune-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 2rem;
            min-height: calc(100vh - var(--topbar-height));
        }

        /* Mobile Toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--neptune-blue);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
            z-index: 1001;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem 1rem;
            }

            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .topbar-brand {
                font-size: 1rem;
            }
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Button Primary */
        .btn-primary {
            background: var(--neptune-blue);
            border-color: var(--neptune-blue);
        }

        .btn-primary:hover {
            background: var(--neptune-dark);
            border-color: var(--neptune-dark);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-wifi me-2"></i>YusrilNet
        </div>
        <div class="sidebar-menu">
            @php
                $user = auth()->user();
            @endphp
            
            @if($user && $user->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
                <a href="{{ route('admin.pakets.index') }}" class="menu-item {{ request()->routeIs('admin.pakets.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>Paket
                </a>
                <a href="{{ route('admin.vouchers.index') }}" class="menu-item {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i>Voucher
                </a>
                <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>Orders
                </a>
                <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>Users
                </a>
            @endif
        </div>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-brand">
            Admin Panel
        </div>
        <div class="topbar-user">
            @auth
                <div class="dropdown">
                    <button class="btn btn-link text-decoration-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <span class="me-2">{{ auth()->user()->name }}</span>
                        <div class="user-avatar d-inline-flex">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user me-2"></i>Profile
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        {{ $slot }}
    </div>

    <!-- Mobile Toggle -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

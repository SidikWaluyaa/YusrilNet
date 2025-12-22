@auth


    @php
        $user = auth()->user();
    @endphp

    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center"
            href="{{ $user->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
            <div class="sidebar-brand-text mx-3">YusrilNet</div>
        </a>


        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li
            class="nav-item {{ request()->routeIs('admin.dashboard') || request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ $user->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        {{-- <!-- Divider -->
        <hr class="sidebar-divider"> --}}

        {{-- <!-- Heading -->
        <div class="sidebar-heading">
            Informasi
        </div> --}}

        {{-- <!-- Nav Item - Deskripsi Paket -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('welcome') }}#voucher">
                <i class="fas fa-book-open"></i>
                <span>Deskripsi Paket</span>
            </a>
        </li> --}}


        @if ($user && $user->role === 'admin')
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Management</div>

            <li class="nav-item {{ request()->routeIs('admin.pakets.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pakets.index') }}">
                    <i class="fas fa-box"></i>
                    <span>Pakets</span></a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.vouchers.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.vouchers.index') }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Vouchers</span></a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span></a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span></a>
            </li>
        @elseif($user && $user->role === 'user')
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Order</div>

            <li class="nav-item {{ request()->routeIs('user.orders.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.orders.index') }}">
                    <i class="fas fa-receipt"></i>
                    <span>Orderan Saya</span></a>
            </li>
        @endif

        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
@endauth

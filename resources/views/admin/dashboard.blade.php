<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0" style="color: #2d3748; font-weight: 700;">Dashboard Admin</h1>
            <a href="{{ route('welcome') }}" class="btn btn-primary btn-sm" target="_blank">
                <i class="fas fa-eye me-2"></i>Lihat Website
            </a>
        </div>

        <!-- Welcome Card -->
        <div class="card mb-4" style="background: linear-gradient(135deg, #4361ee 0%, #4cc9f0 100%); color: white; border: none;">
            <div class="card-body d-flex justify-content-between align-items-center py-4">
                <div>
                    <h4 class="mb-2" style="font-weight: 700; color: white;">Selamat datang kembali, Admin! 👋</h4>
                    <p class="mb-0" style="opacity: 0.95; color: white;">Kelola semua layanan YusrilNet dari dashboard ini</p>
                </div>
                <i class="fas fa-chart-line fa-3x" style="opacity: 0.2; color: white;"></i>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <!-- Paket -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.9;">
                                    Total Paket</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $pakets }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x" style="opacity: 0.3;"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.pakets.index') }}" class="small mt-3 d-block" style="color: rgba(255,255,255,0.9); text-decoration: none;">
                            <i class="fas fa-arrow-right me-1"></i>Kelola Paket
                        </a>
                    </div>
                </div>
            </div>

            <!-- Voucher -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.9;">
                                    Total Voucher</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $vouchers }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ticket-alt fa-2x" style="opacity: 0.3;"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.vouchers.index') }}" class="small mt-3 d-block" style="color: rgba(255,255,255,0.9); text-decoration: none;">
                            <i class="fas fa-arrow-right me-1"></i>Kelola Voucher
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.9;">
                                    Total Order</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $orders }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x" style="opacity: 0.3;"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="small mt-3 d-block" style="color: rgba(255,255,255,0.9); text-decoration: none;">
                            <i class="fas fa-arrow-right me-1"></i>Kelola Order
                        </a>
                    </div>
                </div>
            </div>

            <!-- Users -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">
                                    Management</div>
                                <div class="h5 mb-0 font-weight-bold">Users</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x" style="opacity: 0.3;"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="small mt-3 d-block" style="color: #333; text-decoration: none;">
                            <i class="fas fa-arrow-right me-1"></i>Kelola Users
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card" style="border-left: 4px solid var(--neptune-blue);">
                    <div class="card-body">
                        <h5 class="mb-3" style="color: var(--neptune-dark); font-weight: 600;">
                            <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                        </h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(76, 201, 240, 0.1));">
                                        <i class="fas fa-box text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Paket Tersedia</small>
                                        <strong style="color: var(--neptune-dark);">{{ $pakets }} Paket</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(6, 214, 160, 0.1), rgba(27, 231, 176, 0.1));">
                                        <i class="fas fa-ticket-alt text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Voucher Aktif</small>
                                        <strong style="color: var(--success);">{{ $vouchers }} Voucher</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(76, 201, 240, 0.1), rgba(109, 217, 255, 0.1));">
                                        <i class="fas fa-shopping-cart" style="color: var(--neptune-light);"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Total Pesanan</small>
                                        <strong style="color: var(--neptune-light);">{{ $orders }} Order</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

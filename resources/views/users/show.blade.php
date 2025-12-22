<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-eye me-2"></i>Detail User
                </h1>
                <p class="text-muted mb-0 small">{{ $user->name }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Info -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-4" style="color: #2d3748;">Informasi User</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Nama Lengkap</label>
                                <div class="h5 mb-0">{{ $user->name }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Email</label>
                                <div class="h5 mb-0">{{ $user->email }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">User ID</label>
                                <div class="h5 mb-0">#{{ $user->id }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Terdaftar Sejak</label>
                                <div class="h5 mb-0">
                                    <i class="far fa-calendar me-1"></i>{{ $user->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Sidebar -->
            <div class="col-lg-4">
                <!-- Role -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-3">
                        <div class="text-muted small mb-2">Role</div>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                <i class="fas fa-user-shield me-1"></i>Administrator
                            </span>
                        @else
                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                <i class="fas fa-user me-1"></i>User
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Email Verified -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="text-muted small mb-2">Email Verification</div>
                        @if($user->email_verified_at)
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Verified
                            </span>
                            <div class="text-muted small mt-2">
                                {{ $user->email_verified_at->format('d M Y, H:i') }}
                            </div>
                        @else
                            <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                <i class="fas fa-exclamation-circle me-1"></i>Not Verified
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

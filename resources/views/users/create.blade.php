<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-user-plus me-2"></i>Tambah User
                </h1>
                <p class="text-muted mb-0 small">Buat user baru</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <!-- Nama -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Nama <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name') }}" required placeholder="Nama lengkap">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ old('email') }}" required placeholder="email@example.com">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password" class="form-control" 
                                   required placeholder="Minimal 8 karakter">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password_confirmation" class="form-control" 
                                   required placeholder="Ulangi password">
                        </div>

                        <!-- Role -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Role</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" 
                                           id="role_user" value="user" checked>
                                    <label class="form-check-label" for="role_user">
                                        <i class="fas fa-user text-primary me-1"></i>User
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" 
                                           id="role_admin" value="admin">
                                    <label class="form-check-label" for="role_admin">
                                        <i class="fas fa-user-shield text-danger me-1"></i>Admin
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

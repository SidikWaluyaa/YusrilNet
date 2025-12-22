<x-app-layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-users me-2"></i>Daftar User
                </h1>
                <p class="text-muted mb-0 small">Kelola pengguna sistem</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Tambah User
            </a>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(67, 97, 238, 0.1);">
                                    <i class="fas fa-users fa-lg" style="color: var(--neptune-blue);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Total Users</div>
                                <div class="h3 mb-0 fw-bold">{{ $users->total() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: rgba(239, 71, 111, 0.1);">
                                    <i class="fas fa-user-shield fa-lg" style="color: var(--danger);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Administrators</div>
                                <div class="h3 mb-0 fw-bold">{{ $users->where('role', 'admin')->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th class="border-0 px-4 py-3">ID</th>
                                    <th class="border-0 px-4 py-3">Nama</th>
                                    <th class="border-0 px-4 py-3">Email</th>
                                    <th class="border-0 px-4 py-3">Role</th>
                                    <th class="border-0 px-4 py-3 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="px-4 py-3">#{{ $user->id }}</td>
                                        <td class="px-4 py-3">
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-muted">{{ $user->email }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($user->role === 'admin')
                                                <span class="badge bg-danger-subtle text-danger">
                                                    <i class="fas fa-user-shield me-1"></i>Admin
                                                </span>
                                            @else
                                                <span class="badge bg-primary-subtle text-primary">
                                                    <i class="fas fa-user me-1"></i>User
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                                   class="btn btn-outline-primary" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-outline-secondary" disabled title="Tidak bisa hapus diri sendiri">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada user</h5>
                        <p class="text-muted mb-3">Mulai tambahkan user pertama</p>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Tambah User
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($users, 'links') && $users->count() > 0)
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <style>
        .table tbody tr {
            transition: background-color 0.2s;
        }
        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }
        .btn-group-sm .btn {
            padding: 0.375rem 0.75rem;
        }
    </style>
</x-app-layout>

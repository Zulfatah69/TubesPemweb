@extends('layouts.app')

@section('title', 'Data Users & Owners')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Pengguna</h4>
            <p class="text-muted small mb-0">Kelola data User, Owner, dan Admin dalam satu tempat.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FILTER CARD --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Cari nama atau email..." value="{{ request('q') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select form-select-sm">
                        <option value="">Semua Role</option>
                        <option value="user" {{ request('role')=='user'?'selected':'' }}>User (Pencari)</option>
                        <option value="owner" {{ request('role')=='owner'?'selected':'' }}>Owner (Pemilik)</option>
                        <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm w-100 fw-bold"><i class="bi bi-funnel me-1"></i> Filter</button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm w-100 border" title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE DATA --}}
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary text-uppercase small" width="5%">ID</th>
                            <th class="py-3 text-secondary text-uppercase small" width="30%">Pengguna</th>
                            <th class="py-3 text-secondary text-uppercase small" width="15%">Role</th>
                            <th class="py-3 text-secondary text-uppercase small" width="15%">Status</th>
                            <th class="pe-4 py-3 text-secondary text-uppercase small text-end" width="35%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4 fw-bold text-muted">#{{ $u->id }}</td>

                            {{-- USER PROFILE --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold text-white shadow-sm" 
                                         style="width: 40px; height: 40px; background-color: {{ $u->role == 'owner' ? '#0d6efd' : ($u->role == 'admin' ? '#212529' : '#198754') }};">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $u->name }}</div>
                                        <div class="small text-muted">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- ROLE --}}
                            <td>
                                @if($u->role === 'owner')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 rounded-pill">Owner</span>
                                @elseif($u->role === 'admin')
                                    <span class="badge bg-dark px-3 rounded-pill">Admin</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 rounded-pill">User</span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($u->is_blocked)
                                    <span class="badge bg-danger"><i class="bi bi-slash-circle me-1"></i> Blocked</span>
                                @else
                                    <span class="badge bg-light text-secondary border"><i class="bi bi-check-circle me-1"></i> Active</span>
                                @endif
                            </td>

                            {{-- ACTIONS --}}
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Properti (Khusus Owner) --}}
                                    @if($u->role === 'owner')
                                        <a href="{{ route('admin.owners.properties', $u->id) }}" class="btn btn-sm btn-outline-info" title="Lihat Properti">
                                            <i class="bi bi-houses"></i>
                                        </a>
                                    @endif

                                    {{-- Block / Unblock --}}
                                    @if($u->role !== 'admin') {{-- Admin tidak bisa blokir sesama admin (opsional) --}}
                                        <form action="{{ route('admin.users.block', $u->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm {{ $u->is_blocked ? 'btn-success' : 'btn-outline-dark' }}" 
                                                    onclick="return confirm('Ubah status akses user ini?')"
                                                    title="{{ $u->is_blocked ? 'Buka Blokir' : 'Blokir User' }}">
                                                <i class="bi {{ $u->is_blocked ? 'bi-unlock-fill' : 'bi-slash-circle' }}"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus user ini secara permanen?')" title="Hapus Permanen">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-light rounded-circle p-3 mb-3">
                                        <i class="bi bi-person-x fs-1 text-muted opacity-50"></i>
                                    </div>
                                    <h6 class="text-muted">Data tidak ditemukan</h6>
                                    <p class="small text-muted">Coba ubah kata kunci pencarian atau filter.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($users->hasPages())
            <div class="card-footer bg-white border-top py-3">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
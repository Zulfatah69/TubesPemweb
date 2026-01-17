@extends('layouts.app')

@section('title', 'Data Users & Owners')

@section('content')
<style>
    /* Definisi Tombol Slate 700 */
    .btn-slate-700 {
        background-color: #334155 !important; /* Warna Slate 700 */
        border-color: #334155 !important;
        color: #ffffff !important; /* Memaksa teks menjadi putih */
        transition: all 0.3s ease;
    }

    .btn-slate-700:hover {
        background-color: #1e293b !important; /* Slate 800 saat hover */
        border-color: #1e293b !important;
        color: #ffffff !important;
    }

    /* Opsional: Efek focus agar tidak muncul garis biru */
    .btn-slate-700:focus {
        box-shadow: 0 0 0 0.25 margin rgba(51, 65, 85, 0.5);
    }
</style>
<div class="container py-5">

    {{-- HEADER --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h3 class="fw-bold text-slate-800 mb-1">
                <i class="bi bi-shield-lock-fill me-2 text-secondary"></i>Manajemen Pengguna
            </h3>
            <p class="text-muted mb-0">Otoritas pusat untuk mengelola akses User, Owner, dan Administrator.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.users.index') }}" class="btn btn-white border shadow-sm px-3 fw-medium text-slate-700">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh Data
            </a>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 py-3" style="border-left: 4px solid #198754 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                <div>
                    <span class="fw-medium text-dark">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FILTER CARD --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-3">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control border-start-0 ps-0 shadow-none" placeholder="Cari nama atau email..." value="{{ request('q') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select shadow-none">
                        <option value="">Semua Peran</option>
                        <option value="user" {{ request('role')=='user'?'selected':'' }}>User (Pencari)</option>
                        <option value="owner" {{ request('role')=='owner'?'selected':'' }}>Owner (Pemilik)</option>
                        <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Administrator</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-slate-700 w-100 fw-semibold shadow-sm">
                        <i class="bi bi-funnel me-1 text-white"></i> 
                        <span class="text-white">Terapkan</span>
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light border w-25 shadow-sm" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE DATA --}}
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold small" style="width: 80px;">ID</th>
                            <th class="py-3 text-muted fw-semibold small" style="width: 30%;">PENGGUNA</th>
                            <th class="py-3 text-muted fw-semibold small">PERAN</th>
                            <th class="py-3 text-muted fw-semibold small text-center">STATUS</th>
                            <th class="pe-4 py-3 text-muted fw-semibold small text-end">KELOLA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4 text-secondary fw-medium">#{{ $u->id }}</td>

                            {{-- USER PROFILE --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $avatarBg = match($u->role) {
                                            'owner' => '#475569', // Slate 600
                                            'admin' => '#1e293b', // Slate 800
                                            default => '#94a3b8', // Slate 400
                                        };
                                    @endphp
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold text-white shadow-sm" 
                                         style="width: 40px; height: 40px; background-color: {{ $avatarBg }}; border: 2px solid #fff;">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800 mb-0">{{ $u->name }}</div>
                                        <div class="text-muted small">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- ROLE --}}
                            <td>
                                @if($u->role === 'owner')
                                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200 px-3 py-2 rounded-2">
                                        <i class="bi bi-house-door me-1"></i> Owner
                                    </span>
                                @elseif($u->role === 'admin')
                                    <span class="badge bg-dark text-white px-3 py-2 rounded-2">
                                        <i class="bi bi-shield-check me-1"></i> Admin
                                    </span>
                                @else
                                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-2">
                                        <i class="bi bi-person me-1"></i> User
                                    </span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td class="text-center">
                                @if($u->is_blocked)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 px-2 py-1 rounded-1 small">
                                        <i class="bi bi-slash-circle me-1"></i> Terblokir
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-2 py-1 rounded-1 small">
                                        <i class="bi bi-check-circle me-1"></i> Aktif
                                    </span>
                                @endif
                            </td>

                            {{-- ACTIONS --}}
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-slate text-slate-600" title="Ubah Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Properti (Khusus Owner) --}}
                                    @if($u->role === 'owner')
                                        <a href="{{ route('admin.owners.properties', $u->id) }}" class="btn btn-sm btn-outline-slate text-slate-600" title="Daftar Properti">
                                            <i class="bi bi-houses-fill"></i>
                                        </a>
                                    @endif

                                    {{-- Block / Unblock --}}
                                    @if($u->role !== 'admin')
                                        <form action="{{ route('admin.users.block', $u->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $u->is_blocked ? 'btn-success' : 'btn-outline-slate' }}" 
                                                    onclick="return confirm('Ubah status akses pengguna ini?')"
                                                    title="{{ $u->is_blocked ? 'Aktifkan Akun' : 'Blokir Akun' }}">
                                                <i class="bi {{ $u->is_blocked ? 'bi-unlock-fill' : 'bi-shield-slash' }}"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data pengguna secara permanen? Tindakan ini tidak dapat dibatalkan.')" title="Hapus Permanen">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-5">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                        <i class="bi bi-person-x fs-1 text-muted opacity-50"></i>
                                    </div>
                                    <h5 class="text-slate-700 fw-bold">Data Tidak Ditemukan</h5>
                                    <p class="text-muted small mx-auto" style="max-width: 300px;">Tidak ada hasil untuk kriteria pencarian Anda. Silakan coba kata kunci lain atau reset filter.</p>
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
            <div class="card-footer bg-white border-top py-4 px-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<style>
    /* Professional Grey Palette */
    .text-slate-800 { color: #1e293b; }
    .text-slate-700 { color: #334155; }
    .text-slate-600 { color: #475569; }
    .bg-slate-700 { background-color: #334155 !important; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .bg-light { background-color: #f8fafc !important; }
    
    .btn-white { background: #fff; }
    .btn-white:hover { background: #f1f5f9; }

    .btn-outline-slate {
        border-color: #e2e8f0;
        color: #475569;
    }
    .btn-outline-slate:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
        color: #1e293b;
    }

    .form-control, .form-select {
        border-color: #e2e8f0;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }

    .table thead th { 
        border-top: none;
        letter-spacing: 0.05em;
        font-size: 0.7rem !important;
    }

    .badge { font-weight: 600; }
</style>
@endsection
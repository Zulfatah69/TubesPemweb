@extends('layouts.app')

@section('title', 'Monitoring Owner')

@section('content')
<div class="container py-5">

    {{-- HEADER --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h3 class="fw-bold text-slate-800 mb-1">
                <i class="bi bi-people-fill me-2 text-secondary"></i>Monitoring Owner
            </h3>
            <p class="text-muted mb-0">Kelola basis data pemilik properti dan awasi aktivitas akun mereka.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <button class="btn btn-white border shadow-sm px-3 fw-medium">
                <i class="bi bi-download me-1"></i> Export Data
            </button>
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

    {{-- CARD TABEL --}}
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-secondary fw-bold small text-uppercase tracking-wider">Database Pemilik Properti</span>
                <span class="badge bg-slate-100 text-slate-700 border fw-normal">{{ $owners->total() ?? $owners->count() }} Terdaftar</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold small" style="width: 80px;">ID</th>
                            <th class="py-3 text-muted fw-semibold small">PROFIL OWNER</th>
                            <th class="py-3 text-muted fw-semibold small text-center">TOTAL UNIT</th>
                            <th class="py-3 text-muted fw-semibold small text-center">STATUS AKUN</th>
                            <th class="pe-4 py-3 text-muted fw-semibold small text-end">MANAJEMEN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($owners as $o)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4 text-secondary fw-medium">#{{ $o->id }}</td>

                            {{-- PROFIL --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-slate-200 text-slate-700 rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 42px; height: 42px; border: 2px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
                                        {{ strtoupper(substr($o->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800 mb-0">{{ $o->name }}</div>
                                        <div class="text-muted small">{{ $o->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- TOTAL PROPERTI --}}
                            <td class="text-center">
                                <div class="fw-bold text-slate-700">{{ $o->properties_count }}</div>
                                <div class="text-muted" style="font-size: 0.7rem;">Properti</div>
                            </td>

                            {{-- STATUS --}}
                            <td class="text-center">
                                @if($o->is_blocked)
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-2 border border-danger border-opacity-10 w-100" style="max-width: 100px;">
                                        <i class="bi bi-x-circle me-1"></i> Diblokir
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-2 border border-success border-opacity-10 w-100" style="max-width: 100px;">
                                        <i class="bi bi-check2-circle me-1"></i> Aktif
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Lihat Properti --}}
                                    <a href="{{ route('admin.owners.properties', $o->id) }}" class="btn btn-sm btn-outline-slate px-3" title="Lihat Properti">
                                        <i class="bi bi-houses-fill me-1"></i> Unit
                                    </a>

                                    {{-- Block / Unblock --}}
                                    <form action="{{ route('admin.users.block', $o->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $o->is_blocked ? 'btn-success' : 'btn-outline-danger' }} px-3" 
                                                onclick="return confirm('Apakah Anda yakin ingin mengubah status akses owner ini?')"
                                                title="{{ $o->is_blocked ? 'Aktifkan Kembali' : 'Blokir Akun' }}">
                                            @if($o->is_blocked)
                                                <i class="bi bi-unlock-fill me-1"></i> Aktifkan
                                            @else
                                                <i class="bi bi-shield-slash me-1"></i> Blokir
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-person-x fs-1 text-light mb-3 d-block"></i>
                                    <h5 class="text-secondary">Tidak ada data owner</h5>
                                    <p class="text-muted small">Basis data saat ini belum memiliki pemilik kos yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($owners->hasPages())
            <div class="card-footer bg-white border-top py-4 px-4">
                {{ $owners->links() }}
            </div>
        @endif
    </div>

</div>

<style>
    /* Professional Grey Palette */
    .text-slate-800 { color: #1e293b; }
    .text-slate-700 { color: #334155; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .bg-slate-200 { background-color: #e2e8f0; }
    .bg-light { background-color: #f8fafc !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    
    .btn-white { background: #fff; color: #334155; }
    .btn-white:hover { background: #f1f5f9; }

    .btn-outline-slate {
        border-color: #cbd5e1;
        color: #475569;
    }
    .btn-outline-slate:hover {
        background-color: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
    }

    .table > :not(caption) > * > * {
        padding: 1.1rem 0.75rem;
    }

    .table thead th { 
        border-top: none;
        letter-spacing: 0.025em;
    }
    
    .badge { font-weight: 600; }
</style>
@endsection
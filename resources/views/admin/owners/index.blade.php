@extends('layouts.app')

@section('title', 'Monitoring Owner')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Monitoring Owner</h4>
            <p class="text-muted small mb-0">Kelola data pemilik kos dan status akun mereka.</p>
        </div>
        <div>
            <button class="btn btn-light border shadow-sm btn-sm">
                <i class="bi bi-download me-1"></i> Export
            </button>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD TABEL --}}
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary text-uppercase small" width="5%">ID</th>
                            <th class="py-3 text-secondary text-uppercase small" width="35%">Profil Owner</th>
                            <th class="py-3 text-secondary text-uppercase small text-center" width="15%">Total Properti</th>
                            <th class="py-3 text-secondary text-uppercase small" width="15%">Status Akun</th>
                            <th class="pe-4 py-3 text-secondary text-uppercase small text-end" width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($owners as $o)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4 fw-bold text-muted">#{{ $o->id }}</td>

                            {{-- PROFIL --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <span class="fw-bold">{{ substr($o->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $o->name }}</div>
                                        <div class="small text-muted">{{ $o->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- TOTAL PROPERTI --}}
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                    <i class="bi bi-building me-1"></i> {{ $o->properties_count }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($o->is_blocked)
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                        <i class="bi bi-slash-circle me-1"></i> Diblokir
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i> Aktif
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Lihat Properti --}}
                                    <a href="{{ route('admin.owners.properties', $o->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Properti">
                                        <i class="bi bi-houses"></i> Properti
                                    </a>

                                    {{-- Block / Unblock --}}
                                    <form action="{{ route('admin.users.block', $o->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm {{ $o->is_blocked ? 'btn-success' : 'btn-outline-danger' }}" 
                                                onclick="return confirm('Apakah Anda yakin ingin mengubah status owner ini?')"
                                                title="{{ $o->is_blocked ? 'Aktifkan Kembali' : 'Blokir Akun' }}">
                                            @if($o->is_blocked)
                                                <i class="bi bi-unlock-fill me-1"></i> Unblock
                                            @else
                                                <i class="bi bi-lock-fill me-1"></i> Block
                                            @endif
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
                                        <i class="bi bi-people fs-1 text-muted opacity-50"></i>
                                    </div>
                                    <h6 class="text-muted">Belum ada data owner</h6>
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
            <div class="card-footer bg-white border-top py-3">
                {{ $owners->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
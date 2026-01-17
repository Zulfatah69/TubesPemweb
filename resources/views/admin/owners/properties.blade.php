@extends('layouts.app')

@section('title', 'Detail Properti Owner')

@section('content')
<div class="container py-5">

    {{-- HEADER --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="bg-slate-200 text-slate-700 rounded-3 p-3 me-3">
                    <i class="bi bi-collection-fill fs-4"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-slate-800 mb-1">Portofolio: {{ $user->name }}</h3>
                    <p class="text-muted mb-0 small">Menampilkan semua unit properti yang dikelola oleh owner ini.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.users.index') }}" class="btn btn-white border px-3 fw-medium">
                <i class="bi bi-arrow-left-short me-1"></i> Kembali ke Monitoring
            </a>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 py-3" style="border-left: 4px solid #198754 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-5 text-success"></i>
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
                <span class="text-secondary fw-bold small text-uppercase tracking-wider">Daftar Inventaris Properti</span>
                <span class="badge bg-light text-secondary border fw-normal">{{ $properties->count() }} Properti</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold small" style="width: 80px;">ID</th>
                            <th class="py-3 text-muted fw-semibold small">NAMA PROPERTI</th>
                            <th class="py-3 text-muted fw-semibold small">LOKASI WILAYAH</th>
                            <th class="py-3 text-muted fw-semibold small">HARGA SEWA</th>
                            <th class="py-3 text-muted fw-semibold small text-center">MEDIA</th>
                            <th class="pe-4 py-3 text-muted fw-semibold small text-end">KONTROL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $p)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4">
                                <span class="text-secondary fw-medium">#{{ $p->id }}</span>
                            </td>

                            {{-- NAMA --}}
                            <td>
                                <div class="fw-bold text-slate-800">{{ $p->name }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Diposting pada {{ $p->created_at->format('d/m/Y') }}</div>
                            </td>

                            {{-- LOKASI --}}
                            <td>
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-geo-alt text-secondary me-2 mt-1"></i>
                                    <div>
                                        <div class="text-slate-700 fw-medium small">{{ $p->district }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $p->city }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- HARGA --}}
                            <td>
                                <div class="fw-bold text-slate-800">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                                <div class="text-muted" style="font-size: 0.7rem;">Estimasi / Bulan</div>
                            </td>

                            {{-- FOTO (COUNT) --}}
                            <td class="text-center">
                                <div class="badge bg-slate-100 text-slate-600 border px-3 py-2 rounded-2">
                                    <i class="bi bi-camera me-1"></i> {{ $p->images->count() }} <span class="fw-normal opacity-75 ms-1">Foto</span>
                                </div>
                            </td>

                            {{-- AKSI --}}
                            <td class="pe-4 text-end">
                                <form action="{{ route('admin.properties.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus properti ini secara permanen? Seluruh data gambar dan transaksi terkait akan hilang.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3 py-2" style="border-radius: 6px;">
                                        <i class="bi bi-trash3 me-1"></i> Hapus Properti
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-5">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                        <i class="bi bi-house-dash fs-1 text-muted opacity-50"></i>
                                    </div>
                                    <h5 class="text-slate-700 fw-bold">Belum Ada Properti</h5>
                                    <p class="text-muted small mx-auto" style="max-width: 300px;">Owner ini belum mendaftarkan unit kosan atau properti apapun ke dalam sistem.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    /* Professional Grey Global Styles */
    .text-slate-800 { color: #1e293b; }
    .text-slate-700 { color: #334155; }
    .text-slate-600 { color: #475569; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .bg-slate-200 { background-color: #e2e8f0; }
    .bg-light { background-color: #f8fafc !important; }
    
    .btn-white { 
        background: #fff; 
        color: #475569; 
    }
    .btn-white:hover { 
        background: #f1f5f9; 
        color: #1e293b;
    }

    .table > :not(caption) > * > * {
        padding: 1.25rem 0.75rem;
    }

    .table thead th { 
        border-top: none;
        letter-spacing: 0.05em;
        font-size: 0.7rem !important;
    }

    .badge {
        font-weight: 600;
        letter-spacing: 0.01em;
    }

    .tracking-wider {
        letter-spacing: 0.08em;
    }
</style>
@endsection
@extends('layouts.app')

@section('title', 'Detail Properti Owner')

@section('content')
<div class="container py-5">

    {{-- HEADER --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="bg-slate-700 text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 50px; height: 50px;">
                    <i class="bi bi-person-badge fs-4"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-slate-800 mb-0">Properti Milik: {{ $user->name }}</h4>
                    <p class="text-muted small mb-0">
                        <i class="bi bi-envelope-fill me-1 opacity-75"></i> {{ $user->email }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.users.index') }}" class="btn btn-white border px-3 fw-medium text-slate-600 shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 py-3" style="border-left: 4px solid #198754 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-5 text-success"></i>
                <span class="fw-medium">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD TABEL --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-slate-600 fw-bold small text-uppercase tracking-wider">Inventaris Aset & Performa</span>
                <span class="badge bg-slate-100 text-slate-700 border fw-normal">{{ $properties->count() }} Unit Terdaftar</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold small" style="width: 80px;">ID</th>
                            <th class="py-3 text-muted fw-semibold small">INFO PROPERTI</th>
                            <th class="py-3 text-muted fw-semibold small">LOKASI</th>
                            <th class="py-3 text-muted fw-semibold small">HARGA SEWA</th>
                            <th class="py-3 text-muted fw-semibold small text-center">TOTAL BOOKING</th>
                            <th class="pe-4 py-3 text-muted fw-semibold small text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $p)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4 text-secondary fw-medium">#{{ $p->id }}</td>

                            {{-- INFO (FOTO + NAMA) --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    @php 
                                        $thumb = $p->images->where('is_main', 1)->first() ?? $p->images->first(); 
                                    @endphp
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-light rounded overflow-hidden border shadow-sm" style="width: 65px; height: 45px;">
                                            @if($thumb)
                                                <img src="{{ asset('storage/'.$thumb->file_path) }}" class="w-100 h-100 object-fit-cover shadow-inner">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center h-100 text-muted small bg-slate-50">
                                                    <i class="bi bi-image" style="font-size: 1.2rem;"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800">{{ $p->name }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">Terakhir Update: {{ $p->updated_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- LOKASI --}}
                            <td>
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-geo-alt-fill text-danger opacity-75 me-2 mt-1" style="font-size: 0.85rem;"></i>
                                    <div>
                                        <div class="text-slate-700 fw-medium small">{{ $p->district }}</div>
                                        <div class="text-muted small">{{ $p->city }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- HARGA --}}
                            <td>
                                <div class="fw-bold text-slate-800">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                                <div class="text-muted opacity-75" style="font-size: 0.7rem;">Per Bulan</div>
                            </td>

                            {{-- JUMLAH BOOKING --}}
                            <td class="text-center">
                                <div class="badge rounded-pill px-3 py-2 border shadow-sm {{ ($p->bookings_count ?? 0) > 0 ? 'bg-primary bg-opacity-10 text-primary border-primary border-opacity-25' : 'bg-light text-muted border-light' }}">
                                    <i class="bi bi-calendar-check me-1"></i> {{ $p->bookings_count ?? 0 }} <span class="fw-normal">Booking</span>
                                </div>
                            </td>

                            {{-- AKSI --}}
                            <td class="pe-4 text-end">
                                <form action="{{ route('admin.properties.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('PERINGATAN: Menghapus properti ini akan menghapus seluruh data booking dan riwayat pembayaran terkait. Lanjutkan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3 shadow-none border-opacity-25" style="border-radius: 6px;">
                                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 bg-white">
                                <div class="py-4">
                                    <div class="bg-slate-50 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                        <i class="bi bi-building-dash fs-1 text-muted opacity-40"></i>
                                    </div>
                                    <h5 class="text-slate-700 fw-bold">Portfolio Kosong</h5>
                                    <p class="text-muted small mx-auto" style="max-width: 320px;">
                                        Owner ini belum mendaftarkan unit properti ke dalam sistem. Silakan hubungi owner untuk bantuan lebih lanjut.
                                    </p>
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
    /* Professional Slate Palette */
    .text-slate-800 { color: #1e293b; }
    .text-slate-700 { color: #334155; }
    .text-slate-600 { color: #475569; }
    .bg-slate-700 { background-color: #334155 !important; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .bg-slate-50 { background-color: #f8fafc; }
    
    .btn-white { 
        background: #fff; 
        color: #475569; 
    }
    .btn-white:hover { 
        background: #f8fafc; 
        color: #1e293b;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .table > :not(caption) > * > * {
        padding: 1.1rem 0.75rem;
    }

    .table thead th { 
        border-top: none;
        letter-spacing: 0.05em;
        font-size: 0.7rem !important;
    }

    .tracking-wider {
        letter-spacing: 0.08em;
    }

    .shadow-inner {
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
    }
</style>
@endsection
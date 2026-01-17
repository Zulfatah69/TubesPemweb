@extends('layouts.app')

@section('title', 'Booking Masuk')

@section('content')

<div class="container py-5">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1">Booking Masuk</h3>
            <p class="text-slate-500 mb-0">Tinjau dan kelola permintaan sewa dari calon penyewa properti Anda.</p>
        </div>
        
        <a href="{{ route('owner.dashboard') }}" class="btn btn-white shadow-sm border-slate-200 text-slate-700 px-4 rounded-pill transition-all">
            <i class="bi bi-arrow-left me-2"></i> Dashboard
        </a>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="bg-slate-50 border-bottom border-slate-100">
                            <th class="ps-4 py-4 text-slate-600 fw-bold text-uppercase small tracking-wider">Penyewa</th>
                            <th class="py-4 text-slate-600 fw-bold text-uppercase small tracking-wider">Properti</th>
                            <th class="py-4 text-slate-600 fw-bold text-uppercase small tracking-wider">Jadwal Mulai</th>
                            <th class="py-4 text-slate-600 fw-bold text-uppercase small tracking-wider">Durasi</th>
                            <th class="py-4 text-slate-600 fw-bold text-uppercase small tracking-wider">Status Booking</th>
                            <th class="py-4 text-slate-600 fw-bold text-uppercase small tracking-wider">Pembayaran</th>
                            <th class="py-4 text-end pe-4 text-slate-600 fw-bold text-uppercase small tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>

                    @forelse($bookings as $b)
                        <tr class="transition-all border-bottom border-slate-50">
                            {{-- PENYEWA --}}
                            <td class="ps-4 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle shadow-sm d-flex align-items-center justify-content-center me-3 fw-bold" 
                                         style="width: 44px; height: 44px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #475569;">
                                        {{ substr($b->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800 mb-0" style="font-size: 0.95rem;">{{ $b->user->name }}</div>
                                        <small class="text-slate-400">ID: #BOK-{{ 1000 + $b->id }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- PROPERTI --}}
                            <td class="py-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-building me-2 text-slate-400"></i>
                                    <span class="fw-medium text-slate-700">{{ $b->property->name }}</span>
                                </div>
                            </td>

                            {{-- TANGGAL MULAI --}}
                            <td class="py-4 text-slate-600">
                                <div class="small fw-medium">
                                    {{ $b->start_date ? \Carbon\Carbon::parse($b->start_date)->format('d M, Y') : '-' }}
                                </div>
                            </td>

                            {{-- LAMA SEWA --}}
                            <td class="py-4 text-slate-600 small">
                                <span class="badge bg-slate-100 text-slate-700 px-2 py-1 fw-normal border border-slate-200">
                                    {{ $b->months }} Bulan
                                </span>
                            </td>

                            {{-- STATUS BOOKING --}}
                            <td class="py-4">
                                @if($b->status == 'pending')
                                    <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2">
                                        <i class="bi bi-clock-history me-1"></i> Menunggu
                                    </span>
                                @elseif($b->status == 'approved')
                                    <span class="badge rounded-pill bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-2">
                                        <i class="bi bi-check-circle me-1"></i> Disetujui
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger-subtle text-danger-emphasis border border-danger-subtle px-3 py-2">
                                        <i class="bi bi-x-circle me-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>

                            {{-- STATUS PEMBAYARAN --}}
                            <td class="py-4">
                                @if($b->payment_status === 'paid')
                                    <div class="d-flex align-items-center text-success small fw-bold">
                                        <i class="bi bi-shield-check me-1"></i> Terverifikasi
                                    </div>
                                @elseif($b->payment_status === 'unpaid')
                                    <div class="d-flex align-items-center text-slate-400 small fw-medium">
                                        <i class="bi bi-hourglass-split me-1"></i> Belum Bayar
                                    </div>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-end pe-4 py-4">
                                @if($b->status == 'pending')
                                    <div class="d-flex gap-2 justify-content-end">
                                        @if($b->payment_status === 'paid')
                                            <form method="POST" action="{{ route('owner.booking.update', $b->id) }}">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">

                                                <button class="btn btn-slate-800 btn-sm px-3 rounded-pill shadow-sm transition-all hover-scale">
                                                    Terima
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-slate-100 btn-sm px-3 rounded-pill text-slate-400 border border-slate-200" disabled title="Calon penyewa belum melakukan pembayaran">
                                                <i class="bi bi-lock-fill me-1 small"></i> Terima
                                            </button>
                                        @endif

                                        <form method="POST"
                                            action="{{ route('owner.booking.update', $b->id) }}"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menolak permohonan booking ini?');">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">

                                            <button class="btn btn-outline-danger btn-sm px-3 rounded-pill transition-all">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-slate-100">
                                            <li><a class="dropdown-item small" href="#"><i class="bi bi-eye me-2"></i> Detail Booking</a></li>
                                            <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-trash me-2"></i> Hapus Riwayat</a></li>
                                        </ul>
                                    </div>
                                @endif
                            </td>  
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <div class="bg-slate-50 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                        <i class="bi bi-inbox text-slate-200 fs-1"></i>
                                    </div>
                                    <h6 class="fw-bold text-slate-800">Tidak ada permintaan booking</h6>
                                    <p class="text-slate-500 small mx-auto" style="max-width: 300px;">Permintaan sewa dari calon penghuni akan tampil di sini untuk Anda tinjau.</p>
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
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
    }

    body {
        background-color: #fcfcfd;
    }

    .bg-slate-50 { background-color: var(--slate-50); }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-700 { color: var(--slate-700); }
    .text-slate-600 { color: var(--slate-600); }
    .text-slate-500 { color: var(--slate-500); }
    .text-slate-400 { color: var(--slate-400); }
    .border-slate-50 { border-color: var(--slate-50) !important; }
    .border-slate-100 { border-color: var(--slate-100) !important; }
    .border-slate-200 { border-color: var(--slate-200) !important; }

    .btn-white {
        background: white;
        transition: all 0.2s;
    }
    
    .btn-white:hover {
        background: var(--slate-50);
        transform: translateY(-1px);
    }

    .btn-slate-800 {
        background-color: var(--slate-800);
        color: white;
        border: none;
    }

    .btn-slate-800:hover {
        background-color: var(--slate-700);
        color: white;
    }

    .table thead th {
        letter-spacing: 0.05em;
    }

    .avatar-circle {
        border-radius: 50%;
    }

    .tracking-wider {
        letter-spacing: 0.05rem;
    }

    .hover-scale:hover {
        transform: scale(1.03);
    }

    .transition-all {
        transition: all 0.2s ease-in-out;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(248, 250, 252, 0.8);
    }
    
    .bg-warning-subtle { background-color: #fef9c3 !important; }
    .text-warning-emphasis { color: #854d0e !important; }
    .bg-success-subtle { background-color: #dcfce7 !important; }
    .text-success-emphasis { color: #166534 !important; }
    .bg-danger-subtle { background-color: #fee2e2 !important; }
    .text-danger-emphasis { color: #991b1b !important; }
</style>

@endsection
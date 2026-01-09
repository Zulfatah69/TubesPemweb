@extends('layouts.app')

@section('title', 'Booking Masuk')

@section('content')

<div class="container py-4">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Booking Masuk</h4>
            <p class="text-muted small mb-0">Kelola permintaan sewa dari calon penyewa.</p>
        </div>
        
        {{-- Tombol Kembali (Opsional, jika ingin navigasi cepat) --}}
        <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD TABEL --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Penyewa</th>
                            <th class="py-3">Properti</th>
                            <th class="py-3">Tanggal Mulai</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    @forelse($bookings as $b)
                        <tr>
                            {{-- PENYEWA --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; color: #6c757d;">
                                        <i class="bi bi-person-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $b->user->name }}</div>
                                        <div class="small text-muted" style="font-size: 0.8rem;">
                                            {{-- Jika ada no hp atau email, bisa ditampilkan disini --}}
                                            Pemohon
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- PROPERTI --}}
                            <td>
                                <a href="#" class="text-decoration-none fw-medium text-primary">
                                    {{ $b->property->name }}
                                </a>
                            </td>

                            {{-- TANGGAL --}}
                            <td>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    {{ date('d M Y', strtotime($b->start_date)) }}
                                </div>
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($b->status == 'pending')
                                    <span class="badge bg-warning text-dark border border-warning bg-opacity-25">
                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                    </span>
                                @elseif($b->status == 'approved')
                                    <span class="badge bg-success bg-opacity-75">
                                        <i class="bi bi-check-circle me-1"></i> Diterima
                                    </span>
                                @elseif($b->status == 'rejected')
                                    <span class="badge bg-danger bg-opacity-75">
                                        <i class="bi bi-x-circle me-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-end pe-4">
                                @if($b->status == 'pending')
                                    <div class="d-flex gap-2 justify-content-end">
                                        <form method="POST" action="{{ route('owner.booking.update', [$b->id, 'approved']) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-success fw-bold" title="Terima Pengajuan">
                                                <i class="bi bi-check-lg"></i> Terima
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('owner.booking.update', [$b->id, 'rejected']) }}" onsubmit="return confirm('Yakin ingin menolak pengajuan ini?');">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-danger" title="Tolak Pengajuan">
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small fst-italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                    <h6>Belum ada permintaan booking</h6>
                                    <p class="small mb-0">Permintaan sewa baru akan muncul di sini.</p>
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

@endsection

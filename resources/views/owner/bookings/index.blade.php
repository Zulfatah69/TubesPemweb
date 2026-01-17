@extends('layouts.app')

@section('title', 'Booking Masuk')

@section('content')

<div class="container py-4">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text">Booking Masuk</h4>
            <p class="text-muted small mb-0">Kelola permintaan sewa dari calon penyewa.</p>
        </div>
        
        <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Penyewa</th>
                            <th class="py-3">Properti</th>
                            <th class="py-3">Tanggal Mulai</th>
                            <th class="py-3">Lama Sewa</th>
                            <th class="py-3">Status Booking</th>
                            <th class="py-3">Pembayaran</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    @forelse($bookings as $b)
                        <tr>
                            {{-- PENYEWA --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill text-secondary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $b->user->name }}</div>
                                        <small class="text-muted">Pemohon</small>
                                    </div>
                                </div>
                            </td>

                            {{-- PROPERTI --}}
                            <td class="fw-medium text-primary">
                                {{ $b->property->name }}
                            </td>

                            {{-- TANGGAL MULAI --}}
                            <td>
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $b->start_date ? \Carbon\Carbon::parse($b->start_date)->format('d M Y') : '-' }}
                            </td>

                            {{-- LAMA SEWA --}}
                            <td>
                                {{ $b->months }} bulan
                            </td>

                            {{-- STATUS BOOKING --}}
                            <td>
                                @if($b->status == 'pending')
                                    <span class="badge bg-warning text-dark">
                                        Menunggu
                                    </span>
                                @elseif($b->status == 'approved')
                                    <span class="badge bg-success">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            {{-- STATUS PEMBAYARAN --}}
                            <td>
                                @if($b->payment_status === 'paid')
                                    <span class="badge bg-success">
                                        Sudah Bayar
                                    </span>
                                @elseif($b->payment_status === 'unpaid')
                                    <span class="badge bg-secondary">
                                        Belum Bayar
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark">
                                        -
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-end pe-4">
                                @if($b->status == 'pending')
                                    <div class="d-flex gap-2 justify-content-end">

                                        {{-- Optional: kunci approve kalau belum bayar --}}
                                        @if($b->payment_status === 'paid')
                                            <form method="POST" action="{{ route('owner.booking.update', [$b->id, 'approved']) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-success">
                                                    <i class="bi bi-check-lg"></i> Terima
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-success" disabled title="Menunggu pembayaran">
                                                <i class="bi bi-lock"></i> Terima
                                            </button>
                                        @endif

                                        <form method="POST" action="{{ route('owner.booking.update', [$b->id, 'rejected']) }}" onsubmit="return confirm('Yakin ingin menolak booking ini?');">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-danger">
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                <h6>Belum ada permintaan booking</h6>
                                <p class="small mb-0">Permintaan sewa baru akan muncul di sini.</p>
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

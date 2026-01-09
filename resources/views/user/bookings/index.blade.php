@extends('layouts.app')

@section('title', 'Booking Saya')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Riwayat Booking</h4>
            <p class="text-muted small mb-0">Daftar kos yang pernah atau sedang kamu sewa.</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-search me-1"></i> Cari Kos Lagi
        </a>
    </div>

    {{-- LIST BOOKING --}}
    @forelse($bookings as $booking)
        <div class="card border-0 shadow-sm mb-4 overflow-hidden card-booking">
            <div class="row g-0">
                
                {{-- KOLOM 1: FOTO THUMBNAIL --}}
                <div class="col-md-3 bg-light position-relative">
                    @php 
                        $img = $booking->property->images->first(); 
                    @endphp
                    @if($img)
                        <img src="{{ asset('storage/'.$img->file_path) }}" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" alt="Foto Kos">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                            <i class="bi bi-image fs-1 opacity-25"></i>
                        </div>
                    @endif
                </div>

                {{-- KOLOM 2: INFO DETAIL --}}
                <div class="col-md-9">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between">
                            
                            {{-- INFO KOS --}}
                            <div class="mb-3 mb-md-0">
                                <h5 class="fw-bold text-dark mb-1">
                                    <a href="{{ route('user.property.show', $booking->property->id) }}" class="text-decoration-none text-dark">
                                        {{ $booking->property->name }}
                                    </a>
                                </h5>
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $booking->property->city }}
                                </p>
                                <div class="text-muted small">
                                    <i class="bi bi-calendar-event me-2"></i> Mulai Sewa: 
                                    <span class="fw-bold text-dark">{{ date('d M Y', strtotime($booking->start_date)) }}</span>
                                </div>
                            </div>

                            {{-- STATUS & HARGA --}}
                            <div class="text-md-end">
                                <div class="mb-2">
                                    {{-- Status Booking --}}
                                    @if($booking->status == 'pending')
                                        <span class="badge bg-warning text-dark border border-warning bg-opacity-25">Menunggu Konfirmasi</span>
                                    @elseif($booking->status == 'approved')
                                        <span class="badge bg-success bg-opacity-75">Booking Diterima</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-75">Ditolak</span>
                                    @endif

                                    {{-- Status Pembayaran --}}
                                    @if($booking->payment_status == 'paid')
                                        <span class="badge bg-primary bg-opacity-75">Lunas</span>
                                    @elseif($booking->payment_status == 'failed')
                                        <span class="badge bg-danger">Gagal Bayar</span>
                                    @elseif($booking->payment_status == 'unpaid' && $booking->status != 'rejected')
                                        <span class="badge bg-light text-dark border">Belum Bayar</span>
                                    @endif
                                </div>

                                <div class="fs-5 fw-bold text-primary mb-3">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </div>

                                {{-- TOMBOL AKSI --}}
                                @if($booking->payment_status === 'unpaid' && $booking->status != 'rejected')
                                    <a href="{{ route('booking.pay', $booking->id) }}" class="btn btn-primary fw-bold btn-sm px-3 shadow-sm">
                                        <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                                    </a>
                                @elseif($booking->payment_status === 'paid')
                                    <button class="btn btn-outline-success btn-sm pe-none">
                                        <i class="bi bi-check-all me-1"></i> Pembayaran Berhasil
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>
                    
                    {{-- FOOTER KECIL (Opsional: Info ID Booking) --}}
                    <div class="card-footer bg-white border-top small text-muted d-flex justify-content-between">
                        <span>ID Booking: #{{ $booking->id }}</span>
                        <span>Dibuat: {{ $booking->created_at->diffForHumans() }}</span>
                    </div>

                </div>
            </div>
        </div>

    @empty
        {{-- EMPTY STATE --}}
        <div class="text-center py-5">
            <div class="mb-3">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi bi-journal-x fs-1 text-muted opacity-50"></i>
                </div>
            </div>
            <h5 class="fw-bold text-dark">Belum ada riwayat booking</h5>
            <p class="text-muted mb-4">Kamu belum pernah mengajukan sewa kosan.</p>
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary px-4 fw-bold">
                Mulai Cari Kos
            </a>
        </div>
    @endforelse

</div>

<style>
    /* Agar kolom gambar pada card responsif dan punya tinggi minimal di mobile */
    .card-booking .col-md-3 {
        min-height: 200px; 
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>

@endsection

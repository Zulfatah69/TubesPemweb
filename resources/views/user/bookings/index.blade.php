@extends('layouts.app')

@section('title', 'Riwayat Booking')

@section('content')
<div class="container py-5">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1">Riwayat Booking</h3>
            <p class="text-slate-500 mb-0">Kelola reservasi kos yang sedang berjalan atau riwayat sewa sebelumnya.</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-slate-800 fw-bold px-4 py-2 rounded-pill">
            <i class="bi bi-search me-2"></i>Cari Kos Lagi
        </a>
    </div>

    {{-- LIST BOOKING --}}
    @forelse($bookings as $booking)
        <div class="card border-0 shadow-sm mb-4 overflow-hidden action-card" style="border-radius: 20px;">
            <div class="row g-0">
                
                {{-- PHOTO THUMBNAIL --}}
                <div class="col-md-3 bg-slate-100 position-relative" style="min-height: 200px;">
                    @php 
                        $img = $booking->property->images->first(); 
                    @endphp
                    @if($img)
                        <img src="{{ asset('storage/'.$img->file_path) }}" class="w-100 h-100 object-fit-cover position-absolute" alt="Property">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 text-slate-300">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                </div>

                {{-- INFO DETAIL --}}
                <div class="col-md-9 border-start border-slate-50">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between">
                            
                            {{-- PROPERTY INFO --}}
                            <div class="mb-3 mb-md-0">
                                <h5 class="fw-bold text-slate-800 mb-2">
                                    <a href="{{ route('user.property.show', $booking->property->id) }}" class="text-decoration-none text-slate-800">
                                        {{ $booking->property->name }}
                                    </a>
                                </h5>
                                <p class="text-slate-500 small mb-3">
                                    <i class="bi bi-geo-alt me-1"></i> {{ $booking->property->city }}, {{ $booking->property->district }}
                                </p>
                                
                                <div class="p-3 bg-slate-50 rounded-4 inline-block d-inline-block">
                                    <div class="text-slate-500 small mb-1">Mulai Sewa</div>
                                    <div class="fw-bold text-slate-800"><i class="bi bi-calendar3 me-2 text-slate-400"></i>{{ date('d M Y', strtotime($booking->start_date)) }}</div>
                                </div>
                            </div>

                            {{-- STATUS & PRICE --}}
                            <div class="text-md-end">
                                <div class="mb-3 d-flex flex-wrap gap-2 justify-content-md-end">
                                    {{-- Booking Status --}}
                                    @if($booking->status == 'pending')
                                        <span class="badge rounded-pill bg-amber-50 text-amber-700 border border-amber-100 px-3">Menunggu Konfirmasi</span>
                                    @elseif($booking->status == 'approved')
                                        <span class="badge rounded-pill bg-emerald-50 text-emerald-700 border border-emerald-100 px-3">Disetujui</span>
                                    @else
                                        <span class="badge rounded-pill bg-rose-50 text-rose-600 border border-rose-100 px-3">Ditolak</span>
                                    @endif

                                    {{-- Payment Status --}}
                                    @if($booking->payment_status == 'paid')
                                        <span class="badge rounded-pill bg-slate-800 text-white px-3">Lunas</span>
                                    @elseif($booking->payment_status == 'unpaid' && $booking->status != 'rejected')
                                        <span class="badge rounded-pill bg-white text-slate-400 border px-3">Belum Bayar</span>
                                    @endif
                                </div>

                                <div class="h4 fw-bold text-slate-800 mb-3">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </div>

                                {{-- ACTION BUTTONS --}}
                                @if($booking->payment_status === 'unpaid' && $booking->status != 'rejected')
                                    <a href="{{ route('booking.pay', $booking->id) }}" class="btn btn-slate-800 fw-bold rounded-pill px-4 shadow-slate">
                                        <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                                    </a>
                                @elseif($booking->payment_status === 'paid')
                                    <button class="btn btn-emerald-50 text-emerald-700 fw-bold rounded-pill px-4 border border-emerald-100 cursor-default pe-none">
                                        <i class="bi bi-check-circle-fill me-2"></i>Selesai
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- META INFO --}}
                    <div class="px-4 py-2 bg-slate-50 border-top border-slate-100 d-flex justify-content-between align-items-center">
                        <span class="text-slate-400 x-small fw-medium">ID BOOKING #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-slate-400 x-small italic text-end">Dipesan {{ $booking->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        {{-- EMPTY STATE --}}
        <div class="text-center py-5">
            <div class="mb-4 text-slate-200">
                <i class="bi bi-calendar-x" style="font-size: 5rem;"></i>
            </div>
            <h4 class="fw-bold text-slate-800">Belum Ada Riwayat</h4>
            <p class="text-slate-500 mb-5 mx-auto" style="max-width: 350px;">Sepertinya Anda belum melakukan pemesanan kos apapun di platform kami.</p>
            <a href="{{ route('user.dashboard') }}" class="btn btn-slate-800 px-5 py-3 rounded-pill fw-bold shadow-slate">
                Temukan Kos Idaman
            </a>
        </div>
    @endforelse
</div>

<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-800: #1e293b;
        --amber-50: #fffbeb;
        --amber-100: #fef3c7;
        --amber-700: #b45309;
        --emerald-50: #ecfdf5;
        --emerald-100: #d1fae5;
        --emerald-700: #047857;
        --rose-50: #fff1f2;
        --rose-100: #fecdd3;
        --rose-600: #e11d48;
    }

    body { background-color: #fcfcfd; }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-500 { color: var(--slate-500); }
    .text-slate-400 { color: var(--slate-400); }
    .bg-slate-50 { background-color: var(--slate-50); }
    .bg-slate-100 { background-color: var(--slate-100); }
    .bg-amber-50 { background-color: var(--amber-50); }
    .text-amber-700 { color: var(--amber-700); }
    .bg-emerald-50 { background-color: var(--emerald-50); }
    .text-emerald-700 { color: var(--emerald-700); }
    .bg-rose-50 { background-color: var(--rose-50); }
    .text-rose-600 { color: var(--rose-600); }
    
    .x-small { font-size: 0.75rem; letter-spacing: 0.025em; }

    .btn-outline-slate-800 {
        border: 2px solid var(--slate-800);
        color: var(--slate-800);
        transition: 0.2s;
    }
    .btn-outline-slate-800:hover {
        background: var(--slate-800);
        color: white;
    }

    .btn-slate-800 { background: var(--slate-800); color: white; border: none; transition: 0.2s; }
    .btn-slate-800:hover { background: var(--slate-700); transform: translateY(-2px); color: white; }
    .shadow-slate { box-shadow: 0 10px 15px -3px rgba(30, 41, 59, 0.2); }

    .action-card {
        transition: 0.3s;
        border: 1px solid transparent !important;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05) !important;
        border-color: var(--slate-100) !important;
    }

    .object-fit-cover { object-fit: cover; }
</style>
@endsection
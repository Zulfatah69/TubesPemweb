@extends('layouts.app')

@section('title', 'Monitoring Booking')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Monitoring Booking</h4>
            <p class="text-muted small mb-0">Pantau seluruh aktivitas penyewaan antar User dan Owner.</p>
        </div>
        <div>
            <button class="btn btn-light border shadow-sm btn-sm">
                <i class="bi bi-filter"></i> Filter
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

    {{-- TABLE CARD --}}
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary text-uppercase small" width="5%">ID</th>
                            <th class="py-3 text-secondary text-uppercase small" width="20%">Penyewa (User)</th>
                            <th class="py-3 text-secondary text-uppercase small" width="25%">Detail Properti</th>
                            <th class="py-3 text-secondary text-uppercase small" width="15%">Harga Sewa</th>
                            <th class="py-3 text-secondary text-uppercase small" width="15%">Status</th>
                            <th class="pe-4 py-3 text-secondary text-uppercase small text-end" width="20%">Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $b)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4 fw-bold text-muted">#{{ $b->id }}</td>

                            {{-- USER --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <span class="fw-bold small">{{ substr($b->user->name ?? 'U', 0, 1) }}</span>
                                    </div>
                                    <span class="fw-medium text-dark">{{ $b->user->name ?? '-' }}</span>
                                </div>
                            </td>

                            {{-- PROPERTI & OWNER (Digabung biar rapi) --}}
                            <td>
                                <div class="fw-bold text-dark">{{ $b->property->name ?? '-' }}</div>
                                <div class="small text-muted">
                                    <i class="bi bi-person-fill text-secondary me-1"></i> 
                                    Owner: {{ $b->property->owner->name ?? '-' }}
                                </div>
                            </td>

                            {{-- HARGA --}}
                            <td>
                                <span class="fw-bold text-dark">Rp {{ number_format($b->property->price ?? 0, 0, ',', '.') }}</span>
                            </td>

                            {{-- STATUS (LOGIKA WARNA) --}}
                            <td>
                                @php
                                    $statusColor = match($b->status) {
                                        'approved', 'success', 'paid' => 'success',
                                        'pending', 'unpaid' => 'warning',
                                        'rejected', 'failed', 'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                    
                                    $statusLabel = match($b->status) {
                                        'approved' => 'Diterima',
                                        'pending' => 'Menunggu',
                                        'rejected' => 'Ditolak',
                                        'paid' => 'Lunas',
                                        'unpaid' => 'Belum Bayar',
                                        default => ucfirst($b->status)
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} px-3 py-2 rounded-pill">
                                    <i class="bi bi-circle-fill me-1 small" style="font-size: 0.5rem;"></i> {{ $statusLabel }}
                                </span>
                            </td>

                            {{-- TANGGAL --}}
                            <td class="pe-4 text-end text-muted small">
                                <div>{{ $b->created_at->format('d M Y') }}</div>
                                <div>{{ $b->created_at->format('H:i') }} WIB</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-light rounded-circle p-3 mb-3">
                                        <i class="bi bi-inbox fs-1 text-muted opacity-50"></i>
                                    </div>
                                    <h6 class="text-muted">Belum ada data booking</h6>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- PAGINATION --}}
        @if($bookings->hasPages())
            <div class="card-footer bg-white border-top py-3">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
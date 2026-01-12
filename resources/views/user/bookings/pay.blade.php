@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            {{-- HEADER STEP --}}
            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                    <i class="bi bi-credit-card-2-front-fill fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark">Selesaikan Pembayaran</h4>
                <p class="text-muted small">Amankan kamar kos pilihanmu sekarang.</p>
            </div>

            <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                
                {{-- HEADER CARD --}}
                <div class="card-header bg-primary text-white text-center py-3">
                    <small class="text-uppercase fw-bold letter-spacing-1 opacity-75">Total Tagihan</small>
                    <h2 class="mb-0 fw-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h2>
                </div>

                <div class="card-body p-4">
                    
                    {{-- DETAIL BOOKING --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-muted small text-uppercase mb-3">Rincian Pesanan</h6>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi bi-building text-secondary fs-4"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold text-dark mb-0">{{ $booking->property->name }}</h6>
                                <small class="text-muted">ID Booking: #{{ $booking->id }}</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <span class="text-muted small">Tanggal Mulai</span>
                            <span class="fw-bold text-dark">{{ date('d M Y', strtotime($booking->start_date)) }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Durasi Sewa</span>
                            <span class="fw-bold text-dark">1 Bulan</span>
                        </div>
                    </div>

                    {{-- TOMBOL BAYAR --}}
                    <div class="d-grid">
                        <button id="pay-button" class="btn btn-success py-3 fw-bold shadow-sm rounded-3">
                            <i class="bi bi-shield-lock-fill me-2"></i> Bayar Sekarang
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted" style="font-size: 0.75rem;">
                            <i class="bi bi-lock"></i> Transaksi diamankan oleh Midtrans
                        </small>
                    </div>

                </div>
            </div>

            {{-- TOMBOL BATAL --}}
            <div class="text-center mt-4">
                <a href="{{ route('user.booking.my') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left me-1"></i> Batal & Kembali ke Booking Saya
                </a>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT MIDTRANS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
    const payButton = document.getElementById('pay-button');
    
    payButton.onclick = function () {
        snap.pay('{{ $snapToken }}', {
            // Callback jika sukses
            onSuccess: function(result){
                /* Kamu bisa redirect ke halaman sukses atau reload */
                window.location.href = "{{ route('user.booking.my') }}";
                alert("Pembayaran Berhasil!");
            },
            // Callback jika pending
            onPending: function(result){
                alert("Menunggu pembayaran Anda!");
                window.location.href = "{{ route('user.booking.my') }}";
            },
            // Callback jika error
            onError: function(result){
                alert("Pembayaran gagal!");
            },
            // Callback jika ditutup
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
</script>

<style>
    .letter-spacing-1 {
        letter-spacing: 1px;
    }
</style>

@endsection